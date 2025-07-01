<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class SpotifyApiService
{
    private string $clientId;
    private string $clientSecret;

    // Le constructeur récupère l'identité de mon app Spotify
    public function __construct(private HttpClientInterface $client)
    {
        $this->clientId = $_ENV['SPOTIFY_CLIENT_ID'];
        $this->clientSecret = $_ENV['SPOTIFY_CLIENT_SECRET'];
    }

    // 👉 Méthode pour récupérer un access_token SANS que l'utilisateur se connecte (Client Credentials Flow)
    public function getAppAccessToken(): string
    {
        // Je fais une requête POST à l’API de Spotify pour obtenir un token d’accès public
        $response = $this->client->request('POST', 'https://accounts.spotify.com/api/token', [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'body' => 'grant_type=client_credentials',
        ]);

        // Je récupère le token à partir de la réponse
        return $response->toArray()['access_token'];
    }

    // 👉 Méthode pour récupérer les infos d’une playlist publique (titre, description, image, etc.)
    public function getPlaylistById(string $playlistId, string $accessToken): array
    {
        $response = $this->client->request('GET', "https://api.spotify.com/v1/playlists/{$playlistId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ]
        ]);

        return $response->toArray();
    }

    // Méthode pour récupérer la liste des morceaux d'une playlist
    public function getPlaylistTracks(string $playlistId, string $accessToken): array
    {
        $response = $this->client->request('GET', "https://api.spotify.com/v1/playlists/{$playlistId}/tracks", [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ]
        ]);

        // Je retourne uniquement la liste des morceaux (contenue dans 'items')
        return $response->toArray()['items'];
    }

    //Méthode pour récuperer un artiste
    public function getArtistById(string $artistId, string $accessToken): array
    {
        $response = $this->client->request('GET', "https://api.spotify.com/v1/artists/{$artistId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ]
        ]);
        return $response->toArray();
    }
    //Ajouter un try pour la gestion des erreur en cas de token expirer ou ID invalide ??
}

