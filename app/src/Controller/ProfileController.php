<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();

        // Vérifie si l'utilisateur est connecté
        if (!$user) {
            // Redirige vers la page de login si non connecté
            return $this->redirectToRoute('app_login');
        }

        // Passe l'utilisateur à la vue Twig
        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }
    //Route pour modifier avartar Variable d'environnement qui contient mon chemin vers mes avatars


}
