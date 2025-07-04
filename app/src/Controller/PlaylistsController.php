<?php

namespace App\Controller;

use App\Entity\Playlists;
use App\Form\PlaylistsForm;
use App\Repository\PlaylistsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/playlists')]
final class PlaylistsController extends AbstractController
{
    #[Route(name: 'app_playlists_index', methods: ['GET'])]
    public function index(PlaylistsRepository $playlistsRepository): Response
    {
        return $this->render('playlists/index.html.twig', [
            'playlists' => $playlistsRepository->findAll(),
        ]);
    }
    //Ajout de playlist
    #[Route('/ajouter', name: 'app_playlists_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $playlist = new Playlists();
        $form = $this->createForm(PlaylistsForm::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($playlist);
            $entityManager->flush();

            return $this->redirectToRoute('playlist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('playlists/new.html.twig', [
            'playlist' => $playlist,
            'form' => $form,
        ]);
    }
    //Gestion playlist en favoris
    #[Route('/{id}/toggle-favorite', name: 'app_playlists_toggle_favorite', methods: ['POST'])]
    public function toggleFavorite(Playlists $playlist, EntityManagerInterface $em): Response
    {

        //** @var User $user */
        $user = $this->getUser();

        if ($user->getPlaylists()->contains($playlist)) {
            $user->removePlaylist($playlist);
        } else {
            $user->addPlaylist($playlist);
        }

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('playlist_show', ['id' => $playlist->getSpotifyId()]);
    }

    //Edit de playlist
    #[Route('/{id}/modifier', name: 'app_playlists_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Playlists $playlist, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlaylistsForm::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_playlists_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('playlists/edit.html.twig', [
            'playlist' => $playlist,
            'form' => $form,
        ]);
    }
    //Supprimer la playlist
    #[Route('/{id}/supprimer', name: 'app_playlists_delete', methods: ['POST'])]
    public function delete(Request $request, Playlists $playlist, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$playlist->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($playlist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_playlists_index', [], Response::HTTP_SEE_OTHER);
    }



}
