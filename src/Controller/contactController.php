<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;

class ContactController extends AbstractController
{

    public function createContact(Request $request): Response
    {
       
    }



    public function editContact(Request $request, $id): Response {
        // Récupération du contact à modifier depuis la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $contact = $entityManager->getRepository(Contact::class)->find($id);

        // Validation si le contact existe
        if (!$contact) {
            throw $this->createNotFoundException('Contact non trouvé');
        }

        // Mise à jour des propriétés du contact
        $contact->setNom($request->request->get('nom'));
        $contact->setPrenom($request->request->get('prenom'));
        $contact->setEmail($request->request->get('email'));
        $contact->setNumeroTel($request->request->get('numero_tel'));

        // Enregistrement des modifications
        $entityManager->flush();

        // Redirection ou réponse en fonction de vos besoins
        return $this->redirectToRoute('liste_contacts');
    }

    public function deleteContact($id): Response {
        // Récupération du contact à supprimer depuis la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $contact = $entityManager->getRepository(Contact::class)->find($id);

        // Validation si le contact existe
        if (!$contact) {
            throw $this->createNotFoundException('Contact non trouvé');
        }

        // Suppression du contact
        $entityManager->remove($contact);
        $entityManager->flush();

        // Redirection ou réponse en fonction de vos besoins
        return $this->redirectToRoute('liste_contacts');
    }

    public function listContacts(EntityManagerInterface $entityManager): Response
    {
        // Récupération de toutes les catégories depuis la base de données
        $contact = $entityManager->getRepository(Contact::class)->findAll();

        // Affichage de la liste des catégories dans la vue (à adapter selon votre système de templates)
        return $this->render('Contact/list.html.twig', ['contacts' => $contact]);
    }

    
}



