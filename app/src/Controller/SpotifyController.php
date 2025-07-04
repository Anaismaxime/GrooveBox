<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsForm;
use App\Repository\PlaylistsRepository;
use App\Service\SpotifyApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SpotifyController extends AbstractController
{
    // Cette route affiche les playlists officielles de La Groove Box
    #[Route('/playlists-officielles', name: 'playlist_index')]
    public function index(SpotifyApiService $spotifyApiService, PlaylistsRepository $playlistsRepository): Response
    {
        // Je récupère un token d'accès "application" (pas lié à un utilisateur)
        $accessToken = $spotifyApiService->getAppAccessToken();

        // Je récupere toutes mes playlists marquées publiques
        $storedPlaylists = $playlistsRepository->findBy(['isPublic' => true]);

        // Je récupère les infos Spotify de chaque ID
        $playlists = [];

        // Pour chaque ID, je récupère les infos de la playlist via l'API Spotify
        foreach ($storedPlaylists as $playlist) {
            $spotifyId = $this->extractSpotifyId($playlist->getSpotifyId());
            $playlists[] = $spotifyApiService->getPlaylistById($spotifyId, $accessToken);
        }

        // J'envoie les playlists à ma vue Twig pour les afficher
        return $this->render('playlists/index.html.twig', [
            'playlists' => $playlists,
        ]);
    }

    private function extractSpotifyId(string $input): string
    {
        // Si l'utilisateur a collé une URL complète
        if (str_contains($input, 'spotify.com/playlist/')) {
            preg_match('#playlist/([a-zA-Z0-9]+)#', $input, $matches);
            return $matches[1] ?? $input;
        }

        // Sinon on retourne tel quel (c'est déjà un ID)
        return $input;
    }


    //Méthode pour afficher les morceaux d'une playlist
    #[Route('/playlist/{id}', name: 'playlist_show')]
    public function show(string $id, SpotifyApiService $spotifyApiService, PlaylistsRepository $playlistsRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $accessToken = $spotifyApiService->getAppAccessToken();
        $tracks = $spotifyApiService->getPlaylistTracks($id, $accessToken);

        $playlist = $playlistsRepository->findOneBy(['spotifyId' => $id]);

        //Partie commentaire
        $comment = new Comments(); //Creation nouveau comm vide

        $form = $this->createForm(CommentsForm::class, $comment); // Creation form lié au comm
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { //Si form soumis et valide
            $comment->setUser($this->getUser()); //Associe user
            $comment->setPlaylists($playlist); //Lis le comm à la playlist
            $comment->setCreatedAt(new \DateTimeImmutable()); //Enregistre la date

            $entityManager->persist($comment); //Enregistre base de donnée
            $entityManager->flush();

            return $this->redirectToRoute('playlist_show', ['id' => $playlist->getSpotifyId()]); //redirection
        }
        return $this->render('playlists/show.html.twig', [
            'tracks' => $tracks,
            'playlist' => $playlist,
            'commentForm' => $form,
        ]);

    }


}

