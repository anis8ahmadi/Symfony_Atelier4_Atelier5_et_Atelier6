<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\ModeleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/modeles')]
final class ModeleController extends AbstractController
{
    #[Route('/modele', name: 'app_modele')]
    public function index(): Response
    {
        return $this->render('modele/index.html.twig', [
            'controller_name' => 'ModeleController',
        ]);
    }

    #[Route('/add', name: 'modele_add')]
    public function add(ModeleRepository $repo): Response
    {
        $modele = $repo->addModele('Clio', 'France');
        return new Response('Modèle ajouté avec ID: ' . $modele->getId());
    }



    #[Route('/list', name:'modele_list')]
    public function list(\App\Repository\ModeleRepository $repo): Response
    {
        $modeles = $repo->findAllModeles(); // now works
        $output = '<h2>Liste des modèles</h2><ul>';
        foreach ($modeles as $m) {
            $output .= '<li>ID: ' . $m->getId() . ' | Libellé: ' . $m->getLibelle() . ' | Pays: ' . $m->getPays() . '</li>';
        }
        $output .= '</ul>';
        return new Response($output);
    }



    #[Route('/update/{id}', name: 'modele_update')]
    public function update(ModeleRepository $repo, int $id ): Response
    {

        $rows =$repo->updateModele($id, 'Megane', 'France');
        return new Response("Modele mis à jour : {$rows} ligne(s).");
    }



    #[Route('/delete/{id}', name: 'modele_delete')]
    public function delete(ModeleRepository $repo, int $id): Response
    {
        $rows = $repo->deleteModele($id);
        return new Response('Modele supprimé: {$rows} ligne(s).');

    }



}
