<?php

namespace App\Controller;

use App\Entity\Artists;
use App\Form\ArtistsForm;
use App\Repository\ArtistsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/artists')]
final class ArtistsController extends AbstractController
{
    #[Route(name: 'app_artists_index', methods: ['GET'])]
    public function index(ArtistsRepository $artistsRepository): Response
    {
        return $this->render('artists/index.html.twig', [
            'artists' => $artistsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_artists_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $artist = new Artists();
        $form = $this->createForm(ArtistsForm::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('picture')->getData();

            if($picture){
                $originalName = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                $safeName = strtolower($slugger->slug($originalName));
                $newName = $safeName . '-' . uniqid() . '.' . $picture->guessExtension();
                $destination =$this->getParameter('uploads_directory');
                $picture->move($destination, $newName);
                $artist->setPicture($newName);
            }

            $entityManager->persist($artist);
            $entityManager->flush();

            return $this->redirectToRoute('app_artists_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('artists/new.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_artists_show', methods: ['GET'])]
    public function show(Artists $artist): Response
    {
        return $this->render('artists/show.html.twig', [
            'artist' => $artist,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_artists_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Artists $artist, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArtistsForm::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_artists_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('artists/edit.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_artists_delete', methods: ['POST'])]
    public function delete(Request $request, Artists $artist, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artist->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($artist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_artists_index', [], Response::HTTP_SEE_OTHER);
    }
}
