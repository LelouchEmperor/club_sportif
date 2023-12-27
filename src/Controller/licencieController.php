<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Licencie;
use App\Form\LicencieType;


class LicencieController extends AbstractController
{

    private $entityManager;

    // Injection de dépendance de l'EntityManagerInterface dans le constructeur
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/create', name: 'create_licencie', methods: ['GET', 'POST'])]
    public function createLicencie(Request $request): Response
{
    // Créer une instance de l'entité Licencie
    $licencie = new Licencie();

    // Créer le formulaire en utilisant la classe de formulaire (LicencieType)
    $form = $this->createForm(LicencieType::class, $licencie);

    // Gérez la soumission du formulaire
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Enregistrez le licencié dans la base de données
        $this->entityManager->persist($licencie);
        $this->entityManager->flush();

        // Redirigez vers la liste des licenciés
        return $this->redirectToRoute('licencie');
    }

    // Affichez le formulaire dans le template
    return $this->render('Licencie/create.html.twig', [
        'form' => $form->createView(),
    ]);
}
    
    /**
     * @Route("/licencie/edit/{id}", name="edit_licencie", methods={"POST"})
     */
    public function editLicencie(Request $request, $id): Response
{
    $entityManager = $this->entityManager;
    $licencie = $entityManager->getRepository(Licencie::class)->find($id);

    if (!$licencie) {
        throw $this->createNotFoundException('Licencié non trouvé');
    }

    $form = $this->createForm(LicencieType::class, $licencie);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();
        // Redirection vers la liste des licenciés
        return $this->redirectToRoute('licencie');
    }

    return $this->render('licencie/edit.html.twig', [
        'form' => $form->createView(),
    ]);
}

    /**
     * @Route("/licencie/delete/{id}", name="delete_licencie")
     */
    public function deleteLicencie($id): Response {
        $entityManager = $this->entityManager;
        $licencie = $entityManager->getRepository(Licencie::class)->find($id);

        if (!$licencie) {
            throw $this->createNotFoundException('Licencié non trouvé');
        }

        $entityManager->remove($licencie);
        $entityManager->flush();

        return $this->redirectToRoute('licencie');
    }

    /**
     * @Route("/licencie/list", name="liste_licencies")
     */
    public function listLicencies(EntityManagerInterface $entityManager): Response
    {
        // Récupération de toutes les catégories depuis la base de données
        $licencie = $entityManager->getRepository(Licencie::class)->findAll();

        // Affichage de la liste des educateurs dans la vue (à adapter selon votre système de templates)
        return $this->render('Licencie/list.html.twig', ['licencies' => $licencie]);
    }
}
