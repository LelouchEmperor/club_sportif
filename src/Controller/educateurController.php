<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Educateur;
use App\Form\EducateurType;

class EducateurController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/Educateur/create', name: 'educateur_create', methods: ['GET', 'POST'])]
    public function createEducateur(Request $request): Response
    {
        $educateur = new Educateur();
        $form = $this->createForm(EducateurType::class, $educateur);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Hasher le mot de passe avec password_hash
            $hashedPassword = password_hash($educateur->getMotDePasse(), PASSWORD_BCRYPT);
            $educateur->setMotDePasse($hashedPassword);
    
            $this->entityManager->persist($educateur);
            $this->entityManager->flush();
    
            return $this->redirectToRoute('dashboard');
        }
    
        return $this->render('Authentification/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/Educateur/edit/{id}', name: 'educateur_edit', methods: ['GET', 'POST'])]
    public function editEducateur(Request $request, $id): Response
    {
        $educateur = $this->entityManager->getRepository(Educateur::class)->find($id);

        if (!$educateur) {
            throw $this->createNotFoundException('Éducateur non trouvé');
        }

        $form = $this->createForm(EducateurType::class, $educateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('educateur');
        }

        return $this->render('Educateur/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/educateur/delete/{id}', name: 'educateur_delete')]
    public function deleteEducateur($id): Response
    {
        $educateur = $this->entityManager->getRepository(Educateur::class)->find($id);

        if (!$educateur) {
            throw $this->createNotFoundException('Éducateur non trouvé');
        }

        $this->entityManager->remove($educateur);
        $this->entityManager->flush();

        return $this->redirectToRoute('educateur');
    }

    #[Route('/Educateur/list', name: 'educateur')]
    public function listEducateurs(EntityManagerInterface $entityManager): Response
    {
        $educateurs = $entityManager->getRepository(Educateur::class)->findAll();
    
        return $this->render('Educateur/list.html.twig', ['educateurs' => $educateurs]);
    }
}