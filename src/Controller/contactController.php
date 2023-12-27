<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contact;
use App\Form\ContactType;

class ContactController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/contact/create', name: 'contact_create', methods: ['GET', 'POST'])]
    public function createContact(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($contact);
            $this->entityManager->flush();

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/contact/edit/{id}', name: 'contact_edit', methods: ['GET', 'POST'])]
    public function editContact(Request $request, $id): Response
    {
        $contact = $this->entityManager->getRepository(Contact::class)->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact non trouvé');
        }

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('contact');
        }

        return $this->render('Contact/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/contact/delete/{id}', name: 'contact_delete')]
    public function deleteContact($id): Response
    {
        $contact = $this->entityManager->getRepository(Contact::class)->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact non trouvé');
        }

        $this->entityManager->remove($contact);
        $this->entityManager->flush();

        return $this->redirectToRoute('contact');
    }

    #[Route('/Contact/list', name: 'contact')]
    public function listContacts(EntityManagerInterface $entityManager): Response
    {
        $contact = $entityManager->getRepository(Contact::class)->findAll();
    
        return $this->render('Contact/list.html.twig', ['contacts' => $contact]);
    }
}
