<?php

namespace App\Service;

// J'importe le composant HttpClient de Symfony pour faire des requêtes HTTP
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SpotifyApiService
{
    // Je prépare les variables pour stocker mes identifiants Spotify
    private string $clientId;
    private string $clientSecret;

    // Le constructeur est exécuté quand je crée mon service dans le contrôleur
    public function __construct(private HttpClientInterface $client) // Service qui permet l'envoi de requêtes
    {
        // Je récupère les identifiants de mon app Spotify depuis le fichier .env.local
        $this->clientId = $_ENV['SPOTIFY_CLIENT_ID'];
        $this->clientSecret = $_ENV['SPOTIFY_CLIENT_SECRET'];
    }

    // Cette méthode me permet d'obtenir un token d'accès (access_token)
    // Je n'ai pas besoin que l'utilisateur soit connecté (Client Credentials Flow)
    public function getAppAccessToken(): string
    {
        // J’envoie une requête POST à l’API de Spotify pour demander un token
        $response = $this->client->request('POST', 'https://accounts.spotify.com/api/token', [
            'headers' => [
                // J’ajoute une en-tête d’autorisation avec mes identifiants codés en base64
                'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            // J’indique à l’API quel type de token je veux (client_credentials)
            'body' => 'grant_type=client_credentials',
        ]);

        // L'API me répond avec un JSON, que je convertis en tableau PHP
        // Je retourne uniquement le token pour pouvoir l'utiliser dans les autres méthodes
        return $response->toArray()['access_token'];
    }

    // Cette méthode récupère les infos d’une playlist Spotify à partir de son ID
    public function getPlaylistById(string $playlistId, string $accessToken): array
    {
        // Je fais une requête GET à l'API Spotify avec le token d'accès
        $response = $this->client->request('GET', "https://api.spotify.com/v1/playlists/{$playlistId}", [
            'headers' => [
                // Je m’identifie avec le token récupéré précédemment
                'Authorization' => 'Bearer ' . $accessToken,
            ]
        ]);

        // Je retourne les données de la playlist sous forme de tableau
        return $response->toArray();
    }

    // Cette méthode permet de récupérer les morceaux d'une playlist
    public function getPlaylistTracks(string $playlistId, string $accessToken): array
    {
        // Je fais une requête GET pour obtenir la liste des morceaux de la playlist
        $response = $this->client->request('GET', "https://api.spotify.com/v1/playlists/{$playlistId}/tracks", [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ]
        ]);

        // L'API renvoie un JSON avec plein d'infos, je retourne seulement les morceaux (clé 'items')
        return $response->toArray()['items'];
    }

    // Cette méthode permet d’obtenir les infos d’un artiste Spotify via son ID
    public function getArtistById(string $artistId, string $accessToken): array
    {
        // Requête GET vers Spotify pour récupérer les infos de l'artiste
        $response = $this->client->request('GET', "https://api.spotify.com/v1/artists/{$artistId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ]
        ]);

        // Je transforme le JSON en tableau et je le retourne
        return $response->toArray();
    }

    // 💡 Idée d'amélioration : ajouter des try/catch ici pour gérer les erreurs (ex : mauvais ID, token expiré, etc.)
}
