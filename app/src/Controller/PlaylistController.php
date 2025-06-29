<?php

namespace App\Controller;

use App\Service\SpotifyApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class PlaylistController extends AbstractController
{
    #[Route('/playlists', name: 'playlist_index')]
    public function index( SpotifyApiService $spotifyApiService, SessionInterface $session): Response
    {
        $accessToken = $session->get('spotify_access_token');

        if (!$accessToken) {
            return $this->redirectToRoute('spotify_login');
        }

        $playlists = $spotifyApiService->getUserPlaylists($accessToken);

        return $this->render('playlist/index.html.twig', [
            'playlists' => $playlists,
        ]);
    }

    #[Route('/playlist/{id}', name: 'playlist_show')]
    public function show(string $id, SpotifyApiService $spotifyApiService): Response
    {
        // J’obtiens un token public (application only)
        $accessToken = $spotifyApiService->getAppAccessToken();

        // Je récupère les morceaux de la playlist via son ID
        $tracks = $spotifyApiService->getPlaylistTracks($id, $accessToken);

        // J'envoie les morceaux à ma vue Twig
        return $this->render('playlist/show.html.twig', [
            'tracks' => $tracks,
            'playlist_id' => $id,
        ]);
    }


}

