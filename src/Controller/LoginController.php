<?php
// src/Controller/LoginController.php

namespace App\Controller;

use App\Entity\Educateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class LoginController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/login', name: 'app_login')]
    #[IsGranted('ROLE_ADMIN')]

    public function login(Request $request): Response
    {
        if ($request->getMethod() === 'POST') {
            // Vérifiez les informations d'identification
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            $user = $this->entityManager->getRepository(Educateur::class)->findOneBy(['email' => $email]);

            if (!$user || !$this->isPasswordValid($user, $password) || !$user->getIsAdmin()) {
                throw new BadCredentialsException('Identifiants invalides');
            }

            if (!$user instanceof Educateur) {
                throw new \Exception('User is not an Educateur: ' . get_class($user));
            }
            
            $roles = $user->getRoles();
            
            if (!is_array($roles)) {
                throw new \Exception('getRoles did not return an array: ' . gettype($roles));
            }

            $token = new UsernamePasswordToken($user, '', 'main', $roles);
            $this->get('security.token_storage')->setToken($token);

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('Authentification/login.html.twig');
    }

    private function isPasswordValid(Educateur $user, string $password): bool
    {
        // Comparez le mot de passe fourni avec celui stocké dans la base de données
        return password_verify($password, $user->getMotDePasse());
    }
}
