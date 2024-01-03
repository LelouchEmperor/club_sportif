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
            // Effectuez la recherche en utilisant le repository LicencieRepository
            $resultats = $licencieRepository->rechercherParCategorie($categorie);
        }

        return $this->render('recherche_licencie/index.html.twig', [
            'form' => $form->createView(),
            'resultats' => $resultats,
        ]);
    }
}
