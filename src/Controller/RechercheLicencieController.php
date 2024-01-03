<?php
// src/Controller/RechercheLicencieController.php

namespace App\Controller; 

use App\Form\RechercheLicencieType;
use App\Repository\LicencieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RechercheLicencieController extends AbstractController
{
    #[Route('/recherche-licencie', name: 'recherche_licencie')]
    public function rechercheLicencie(Request $request, LicencieRepository $licencieRepository): Response
    {
        $form = $this->createForm(RechercheLicencieType::class);
        $form->handleRequest($request);
    
        $resultats = [];
    
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->get('categorie')->getData();
    
            // Vérifiez que la catégorie est sélectionnée
            if ($categorie) {
                // Effectuez la recherche en utilisant le repository LicencieRepository
                $resultats = $licencieRepository->rechercherParCategorie($categorie);
            } else {
                // Catégorie non sélectionnée, affichez un message d'erreur par exemple
                $this->addFlash('error', 'Veuillez sélectionner une catégorie pour la recherche.');
            }
        }
    
        return $this->render('recherche_licencie/index.html.twig', [
            'form' => $form->createView(),
            'resultats' => $resultats,
        ]);
    }
    
}
