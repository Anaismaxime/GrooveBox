<?php

namespace App\Controller;

use App\Form\AvatarForm;
use App\Repository\PostsRepository;
use App\Service\SpotifyApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'app_profile')]
    public function index(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profil/playlists-favoris', name: 'app_profile_favorites')]
    public function favorites(SpotifyApiService $spotifyApiService): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $accessToken = $spotifyApiService->getAppAccessToken();

        $favoritePlaylists = [];

        foreach ($user->getPlaylists() as $playlist) {
            $favoritePlaylists[] = $spotifyApiService->getPlaylistById($playlist->getSpotifyId(), $accessToken);
        }

        return $this->render('profile/favorites.html.twig', [
            'user' => $user,
            'favoritePlaylists' => $favoritePlaylists,
        ]);
    }

    #[Route('/profil/articles-favoris', name: 'app_profile_favorites_posts')]
    public function favoritesPosts(Request $request, PostsRepository $postsRepository): Response
    {
        // Récupère les IDs des posts favoris depuis la session
        $favoriteIds = $request->getSession()->get('favorites', []);

        // Récupère les entités Posts correspondantes
        $favoritePosts = $postsRepository->findBy(['id' => $favoriteIds]);

        return $this->render('profile/favorites-posts.html.twig', [
            'favoritePosts' => $favoritePosts,
        ]);
    }


    #[Route('/profil/avatar/modifier', name: 'app_edit_avatar')]
    public function editAvatar(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AvatarForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avatar = $form->get('avatar')->getData();
            $originalName = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);
            $cleanName = strtolower($slugger->slug($originalName));
            $fileName = $cleanName . '.' . uniqid() . '.' . $avatar->guessExtension();
            $path = $this->getParameter('avatars_directory');
            $avatar->move($path, $fileName);

            $user = $this->getUser();
            $user->setAvatar('uploads/avatars/' . $fileName);

            $entityManager->flush();

            return $this->redirectToRoute('app_profile');

        }
        return $this->render('profile/editavatar.html.twig', [
            'form' => $form
        ]);
    }

}
















