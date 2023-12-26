<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Educateur;


class EducateurController extends AbstractController
{
    public function createEducateur(Request $request): Response {
        // Récupération des données du formulaire
        $numeroLicence = $request->request->get('numero_licence');
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $contact = $request->request->get('contact');
        $email = $request->request->get('email');
        $motDePasse = $request->request->get('mot_de_passe');

        // Validation des données (vous pouvez utiliser des validateurs Symfony)

        // Création d'une nouvelle instance de la classe Educateur
        $nouvelEducateur = new Educateur();
        $nouvelEducateur->setNumeroLicence($numeroLicence);
        $nouvelEducateur->setNom($nom);
        $nouvelEducateur->setPrenom($prenom);
        $nouvelEducateur->setContact($contact);
        $nouvelEducateur->setEmail($email);
        $nouvelEducateur->setMotDePasse($motDePasse);

        // Récupération de l'Entity Manager et sauvegarde de l'éducateur
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($nouvelEducateur);
        $entityManager->flush();

        // Redirection ou réponse en fonction de vos besoins
        return $this->redirectToRoute('educateur');
    }
   
   
   
    public function editEducateur(Request $request, $id): Response {
        // Récupération de l'éducateur à modifier depuis la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $educateur = $entityManager->getRepository(Educateur::class)->find($id);

        // Validation si l'éducateur existe
        if (!$educateur) {
            throw $this->createNotFoundException('Éducateur non trouvé');
        }

        // Mise à jour des propriétés de l'éducateur
        $educateur->setNumeroLicence($request->request->get('numero_licence'));
        $educateur->setNom($request->request->get('nom'));
        $educateur->setPrenom($request->request->get('prenom'));
        $educateur->setContact($request->request->get('contact'));
        $educateur->setEmail($request->request->get('email'));
        $educateur->setMotDePasse($request->request->get('mot_de_passe'));

        // Enregistrement des modifications
        $entityManager->flush();

        // Redirection ou réponse en fonction de vos besoins
        return $this->redirectToRoute('educateur');
    }
   
    public function deleteEducateur($id): Response {
        // Récupération de l'éducateur à supprimer depuis la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $educateur = $entityManager->getRepository(Educateur::class)->find($id);

        // Validation si l'éducateur existe
        if (!$educateur) {
            throw $this->createNotFoundException('Éducateur non trouvé');
        }

        // Suppression de l'éducateur
        $entityManager->remove($educateur);
        $entityManager->flush();

        // Redirection ou réponse en fonction de vos besoins
        return $this->redirectToRoute('educateur');
    }
   
    public function listEducateurs(EntityManagerInterface $entityManager): Response
    {
        // Récupération de toutes les catégories depuis la base de données
        $educateur = $entityManager->getRepository(Educateur::class)->findAll();

        // Affichage de la liste des educateurs dans la vue (à adapter selon votre système de templates)
        return $this->render('Educateur/list.html.twig', ['educateurs' => $educateur]);
    }

}
