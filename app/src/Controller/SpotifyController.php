<?php

namespace App\Controller;

use App\Service\SpotifyApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SpotifyController extends AbstractController
{
    // Cette route affiche les playlists officielles de La Groove Box
    #[Route('/playlists', name: 'playlist_index')]
    public function index(SpotifyApiService $spotifyApiService): Response
    {
        // Je récupère un token d'accès "application" (pas lié à un utilisateur)
        $accessToken = $spotifyApiService->getAppAccessToken();

        // Je définis ici les ID des playlists que je veux afficher
        $playlistIds = [
            '5v31Tnzb8TJr6o8itHdRd1', // Playlist Soulful de La Groove Box
            // Ajoute ici d'autres IDs si tu en crées d'autres dans ton compte Spotify
        ];

        // Je crée un tableau vide pour stocker les playlists récupérées
        $playlists = [];

        // Pour chaque ID, je récupère les infos de la playlist via l'API Spotify
        foreach ($playlistIds as $id) {
            $playlists[] = $spotifyApiService->getPlaylistById($id, $accessToken);
        }

        // J'envoie les playlists à ma vue Twig pour les afficher
        return $this->render('playlist/index.html.twig', [
            'playlists' => $playlists,
        ]);
    }
}

