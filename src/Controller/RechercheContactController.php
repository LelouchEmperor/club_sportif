<?php
// src/Controller/RechercheContactController.php

namespace App\Controller;

use App\Form\RechercheContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RechercheContactController extends AbstractController
{
    #[Route('/recherche-contact', name: 'recherche_contact')]
    public function rechercheContact(Request $request, ContactRepository $contactRepository): Response
    {
        $form = $this->createForm(RechercheContactType::class);
        $form->handleRequest($request);

        $contacts = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $categorie = $form->get('categorie')->getData();
            // Utilisez $categorie pour récupérer les contacts associés depuis le repository
            $contacts = $contactRepository->findByCategorie($categorie);
        }

        return $this->render('recherche_contact/index.html.twig', [
            'form' => $form->createView(),
            'contacts' => $contacts,
        ]);
    }
}
