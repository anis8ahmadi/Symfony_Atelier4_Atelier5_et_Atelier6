<?php

namespace App\Controller;

use App\Entity\Modele;
use App\Entity\Voiture;
use App\Form\VoitureFormType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;


final class VoitureController extends AbstractController
{
    #[Route('/voitures', name: 'app_voiture')]
    public function listeVoiture(VoitureRepository $vr): Response
    {
        $voitures = $vr->findAll();
        return $this->render('voiture/listeVoiture.html.twig', [
            'listeVoiture' => $voitures,
        ]);
    }


    #[Route('addVoiture', name: 'addVoiture')]
    public function addVoiture(Request $request, EntityManagerInterface $em)
    {
        $voiture = new Voiture();
        $form= $this->createForm(VoitureFormType::class, $voiture);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('app_voiture');
        }
        return $this->render('voiture/addVoiture.html.twig', [
            'formV' => $form->createView(),
        ]);
    }

    #[Route('/voiture/{id}', name: 'voitureDelete')]
    public function delete(EntityManagerInterface $em, VoitureRepository $vr, $id): Response
    {
        $voiture = $vr->find($id);
        $em->remove($voiture);
        $em->flush();

        return $this->redirectToRoute('app_voiture');
    }


    #[Route('/updateVoiture/{id}', name: 'voitureUpdate')]
    public function updateVoiture(Request $request, EntityManagerInterface $em,
                                  VoitureRepository $vr, $id): Response
    {
        $voiture = $vr->find($id);

        $editform =$this->createForm(VoitureFormType::class, $voiture);
        $editform->handleRequest($request);
        if ($editform->isSubmitted() && $editform->isValid()) {
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('app_voiture');
        }

        return $this->render('voiture/updateVoiture.html.twig', [
            'editFormVoiture' => $editform->createView()
        ]);

    }

    #[Route('/voitures-par-modele', name: 'voitures_par_modele')]
    public function voitureParModele(Request $request, VoitureRepository $vr, EntityManagerInterface $em): Response
    {
        $modeleId = $request->query->get('modeleId'); // safer than get()
        $voitures = [];

        if ($modeleId) {
            $voitures = $vr->findByModele((int)$modeleId);
        }

        $modeles = $em->getRepository(Modele::class)->findAll();

        return $this->render('voiture/voituresParModele.html.twig', [
            'voitures' => $voitures,
            'modeles' => $modeles,
            'selectedModele' => $modeleId
        ]);
    }

}
