<?php

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class contactController extends Controller
{
    public function createContact(Request $request): Response {
        // Récupération des données du formulaire
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $numeroTel = $request->request->get('numero_tel');

        // Validation des données (vous pouvez utiliser des validateurs Symfony)

        // Création d'une nouvelle instance de la classe Contact
        $nouveauContact = new Contact();
        $nouveauContact->setNom($nom);
        $nouveauContact->setPrenom($prenom);
        $nouveauContact->setEmail($email);
        $nouveauContact->setNumeroTel($numeroTel);

        // Récupération de l'Entity Manager et sauvegarde du contact
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($nouveauContact);
        $entityManager->flush();

        // Redirection ou réponse en fonction de vos besoins
        return $this->redirectToRoute('liste_contacts');
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

    public function listContacts(): Response {
        // Récupération de tous les contacts depuis la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $contacts = $entityManager->getRepository(Contact::class)->findAll();

        // Affichage de la liste des contacts dans la vue (à adapter selon votre système de templates)
        return $this->render('contacts/liste.html.twig', ['contacts' => $contacts]);
    }

    
}



