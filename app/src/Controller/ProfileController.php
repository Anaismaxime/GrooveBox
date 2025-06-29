<?php

namespace App\Controller;

use App\Service\SpotifyApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'app_profile')]
    public function index(SpotifyApiService $spotifyApiService): Response
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Récupère un token public d'accès à l'API Spotify
        $accessToken = $spotifyApiService->getAppAccessToken();

        // Crée un tableau pour stocker les playlists favorites complètes
        $favoritePlaylists = [];

        // Pour chaque ID de playlist stocké dans l'utilisateur
        foreach ($user->getFavoritePlaylists() as $playlistId) {
            // Appelle l'API Spotify pour récupérer les infos de la playlist
            $favoritePlaylists[] = $spotifyApiService->getPlaylistById($playlistId, $accessToken);
        }

        // Envoie les données à la vue Twig
        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'favoritePlaylists' => $favoritePlaylists,
        ]);
    }

    #[Route('/profil/playlists', name: 'profile_playlists')]
    public function playlists(SpotifyApiService $spotifyApiService): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $accessToken = $spotifyApiService->getAppAccessToken(); // Récupère le token application
        $favoritePlaylists = [];

        foreach ($user->getFavoritePlaylists() as $playlistId) {
            $favoritePlaylists[] = $spotifyApiService->getPlaylistById($playlistId, $accessToken);
        }

        return $this->render('profile/favorites.html.twig', [
            'favoritePlaylists' => $favoritePlaylists,
        ]);
    }

}
