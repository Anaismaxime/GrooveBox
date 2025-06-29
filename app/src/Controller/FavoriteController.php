<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FavoriteController extends AbstractController
{
    // Cette route ajoute ou retire une playlist des favoris
    #[Route('/playlist/{id}/toggle-favorite', name: 'playlist_toggle_favorite')]
    public function toggleFavorite(string $id, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Ajoute ou supprime l’ID de la playlist dans le tableau
        if (in_array($id, $user->getFavoritePlaylists())) {
            $user->removeFavoritePlaylist($id);
        } else {
            $user->addFavoritePlaylist($id);
        }

        $em->persist($user);
        $em->flush();

        // Redirection vers la page des playlists
        return $this->redirectToRoute('playlist_index');
    }
}
