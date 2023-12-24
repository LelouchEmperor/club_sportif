<?php

#[Route('/licencie')] // Route pour accéder aux licencies

class licencieController extends Controller
{

    public function createLicencie(Request $request): Response {
        // Récupération des données du formulaire
        $numeroLicence = $request->request->get('numero_licence');
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $contact = $request->request->get('contact');
        $categorie = $request->request->get('categorie');
        $educateur = $request->request->get('educateur');

        // Validation des données (vous pouvez utiliser des validateurs Symfony)

        // Création d'une nouvelle instance de la classe Licencie
        $nouveauLicencie = new Licencie();
        $nouveauLicencie->setNumeroLicence($numeroLicence);
        $nouveauLicencie->setNom($nom);
        $nouveauLicencie->setPrenom($prenom);
        $nouveauLicencie->setContact($contact);
        $nouveauLicencie->setCategorie($categorie);
        $nouveauLicencie->setEducateur($educateur);

        // Récupération de l'Entity Manager et sauvegarde du licencié
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($nouveauLicencie);
        $entityManager->flush();

        // Redirection ou réponse en fonction de vos besoins
        return $this->redirectToRoute('liste_licencies');
    }

    public function editLicencie(Request $request, $id): Response {
        // Récupération du licencié à modifier depuis la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $licencie = $entityManager->getRepository(Licencie::class)->find($id);

        // Validation si le licencié existe
        if (!$licencie) {
            throw $this->createNotFoundException('Licencié non trouvé');
        }

        // Mise à jour des propriétés du licencié
        $licencie->setNumeroLicence($request->request->get('numero_licence'));
        $licencie->setNom($request->request->get('nom'));
        $licencie->setPrenom($request->request->get('prenom'));
        $licencie->setContact($request->request->get('contact'));
        $licencie->setCategorie($request->request->get('categorie'));
        $licencie->setEducateur($request->request->get('educateur'));

        // Enregistrement des modifications
        $entityManager->flush();

        // Redirection ou réponse en fonction de vos besoins
        return $this->redirectToRoute('liste_licencies');
    }

    public function deleteLicencie($id): Response {
        // Récupération du licencié à supprimer depuis la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $licencie = $entityManager->getRepository(Licencie::class)->find($id);

        // Validation si le licencié existe
        if (!$licencie) {
            throw $this->createNotFoundException('Licencié non trouvé');
        }

        // Suppression du licencié
        $entityManager->remove($licencie);
        $entityManager->flush();

        // Redirection ou réponse en fonction de vos besoins
        return $this->redirectToRoute('liste_licencies');
    }

    public function listLicencies(): Response {
        // Récupération de tous les licenciés depuis la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $licencies = $entityManager->getRepository(Licencie::class)->findAll();

        // Affichage de la liste des licenciés dans la vue (à adapter selon votre système de templates)
        return $this->render('licencies/liste.html.twig', ['licencies' => $licencies]);
    }



}