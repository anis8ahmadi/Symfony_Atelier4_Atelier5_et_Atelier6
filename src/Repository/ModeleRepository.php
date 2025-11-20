<?php

namespace App\Repository;

use App\Entity\Modele;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Modele>
 */
class ModeleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Modele::class);
    }

    //    /**
    //     * @return Modele[] Returns an array of Modele objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Modele
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function addModele(string $libelle, string $pays): Modele
    {
        $en = $this->getEntityManager();
        $modele = new Modele();
        $modele->setLibelle($libelle);
        $modele->setPays($pays);
        $en->persist($modele);
        $en->flush();
        return $modele;
    }

    public function findAllModeles(): array
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT m
            FROM App\Entity\Modele m
            ORDER BY m.libelle ASC
        ');

        return $query->getResult();
    }



    public function updateModele(int $id, string $libelle, string $pays): int
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
      UPDATE App\Entity\Modele m
      SET m.libelle = :libelle, m.pays = :pays Where m.id = :id')
            ->setParameter('libelle', $libelle)
            ->setParameter('pays', $pays)
            ->setParameter('id', $id);
        return $query->execute();
    }


    public function deleteModele(int $id): int

    {
        $em= $this->getEntityManager();
        $query = $em->createQuery('
        DELETE FROM App\Entity\Modele m
        WHERE m.id = :id')
            ->setParameter('id', $id);
        return $query->execute();

    }




}
