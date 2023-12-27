<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categorie;
use App\Form\CategorieType;

class CategorieController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/categorie/create', name: 'categorie_create', methods: ['GET', 'POST'])]
    public function createCategorie(Request $request): Response
    {
        $categorie = new categorie();
        $form = $this->createForm(categorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($categorie);
            $this->entityManager->flush();

            return $this->redirectToRoute('categorie');
        }

        return $this->render('categorie/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/categorie/edit/{id}', name: 'categorie_edit', methods: ['GET', 'POST'])]
    public function editCategorie(Request $request, $id): Response
    {
        $categorie = $this->entityManager->getRepository(Categorie::class)->find($id);

        if (!$categorie) {
            throw $this->createNotFoundException('categorie non trouvé');
        }

        $form = $this->createForm(categorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('categorie');
        }

        return $this->render('categorie/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/categorie/delete/{id}', name: 'categorie_delete')]
    public function deleteCategorie($id): Response
    {
        $categorie = $this->entityManager->getRepository(Categorie::class)->find($id);

        if (!$categorie) {
            throw $this->createNotFoundException('categorie non trouvé');
        }

        $this->entityManager->remove($categorie);
        $this->entityManager->flush();

        return $this->redirectToRoute('categorie');
    }

    #[Route('/categorie/list', name: 'categorie')]
    public function listcategories(EntityManagerInterface $entityManager): Response
    {
        $categorie = $entityManager->getRepository(Categorie::class)->findAll();
    
        return $this->render('categorie/list.html.twig', ['categories' => $categorie]);
    }
}
