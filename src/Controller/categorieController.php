<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;

class CategorieController extends AbstractController {

    public function createCategorie($nom, $codeRaccourci) {
        // Faudra regarder si les paramètres sont bien renseignés et correctes

        // Création d'une nouvelle instance de la classe Categorie
        $nouvelleCategorie = new Categorie();
        $nouvelleCategorie->setNom($nom);
        $nouvelleCategorie->setCodeRaccourci($codeRaccourci);

        // Récupération de l'Entity Manager (EntityManager) pour interagir avec la base de données
        $entityManager = $this->getDoctrine()->getManager();

        // Persistez l'objet en base de données
        $entityManager->persist($nouvelleCategorie);

        // Exécution des opérations en base de données
        $entityManager->flush();

        // Redirection vers la liste des catégories 
        return $this->redirectToRoute('Categorie/list.html.twig');
    }


    public function editCategorie($id, $nom, $codeRaccourci) {
        // Validation des données

        // Récupération de la catégorie à modifier depuis la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $categorie = $entityManager->getRepository(Categorie::class)->find($id);

        // Vérification si la catégorie existe
        if (!$categorie) {
            throw $this->createNotFoundException('Catégorie non trouvée');
        }

        // Modification des propriétés de la catégorie
        $categorie->setNom($nom);
        $categorie->setCodeRaccourci($codeRaccourci);

        // Enregistrement des modifications en base de données
        $entityManager->flush();

        // Redirection vers la liste des catégories 
        return $this->redirectToRoute('Categorie/list.html.twig');
    }

    public function deleteCategorie($id) {
        // Récupération de la catégorie à supprimer depuis la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $categorie = $entityManager->getRepository(Categorie::class)->find($id);

        // Vérification si la catégorie existe
        if (!$categorie) {
            throw $this->createNotFoundException('Catégorie non trouvée');
        }

        // Suppression de la catégorie
        $entityManager->remove($categorie);
        $entityManager->flush();

        // Redirection vers la liste des catégories (ou autre action appropriée)
        return $this->redirectToRoute('Categorie/list.html.twig');
    }

    
    public function listCategories(EntityManagerInterface $entityManager): Response
{
    // Récupération de toutes les catégories depuis la base de données
    $categories = $entityManager->getRepository(Categorie::class)->findAll();

    // Affichage de la liste des catégories dans la vue (à adapter selon votre système de templates)
    return $this->render('Categorie/list.html.twig', ['categories' => $categories]);
}

}
?>
