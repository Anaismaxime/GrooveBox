<?php

// Déclaration de l'espace de noms du contrôleur
namespace App\Controller;

// Importation des classes nécessaires
use App\Entity\Posts;
use App\Form\PostsForm;
use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

// L'entité représentant un article/post
// Le formulaire utilisé pour créer/modifier un post
// Le repository pour accéder aux données des posts
// Pour interagir avec la base de données (Doctrine)
// Classe de base pour les contrôleurs Symfony
// Représente une requête HTTP (GET, POST, etc.)
// Représente une réponse HTTP

// Permet d'utiliser les attributs pour définir les routes

// Contrôleur pour gérer les routes liées aux "posts"
#[Route('/articles')]
final class PostsController extends AbstractController
{
    // Route pour afficher tous les posts (page d'accueil des articles)
    #[Route(name: 'app_posts_index', methods: ['GET'])]
    public function index(PostsRepository $postsRepository, SessionInterface $session): Response
    {
        $posts = $postsRepository->findAll();
        $favorites = $session->get('favorites', []);
        // Récupère tous les articles dans la base de données via le repository
        return $this->render('posts/index.html.twig', [
            'posts' => $posts,
            'favorites' => $favorites,
        ]);
    }

    // Route pour ajouter un nouvel article (affiche le formulaire + gère l'envoi)
    #[Route('/ajouter', name: 'app_posts_new', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        //dd('coucou');
        $post = new Posts(); // Crée un nouvel objet Post vide
        $form = $this->createForm(PostsForm::class, $post);// Génère le formulaire à partir de la classe PostsForm
        $form->handleRequest($request); // Gère la soumission du formulaire (hydrate $post si soumis)

        //FORMULAIRE MEME PAS SOUMIS
        // Si le formulaire a été soumis ET est valide
        if ($form->isSubmitted() && $form->isValid()) {
            $coverImage = $form->get('coverImage')->getData();

            if($coverImage){
                //On récupère le nom de l'image sans l'extension
                $originalName = pathinfo($coverImage->getClientOriginalName(), PATHINFO_FILENAME);
                //On nettoie le nom de l'image (Enlever espace, caractères spéciaux etc)
                $safeName = strtolower($slugger->slug($originalName));
                //On compose le nouveau nom
                $newName = $safeName . '-' . uniqid() . '.' . $coverImage->guessExtension();
                //On récupère la destination
                $destination =$this->getParameter('uploads_directory');
                //On déplace l'image vers son dossier d'upload
                $coverImage->move($destination, $newName);
                //On stock le nom de l'image
                $post->setCoverImage($newName);
            }


            $entityManager->persist($post); // Prépare le post à être enregistré
            $entityManager->flush();        // Enregistre le post dans la base de données

            // Redirige vers la liste des posts après l'ajout
            return $this->redirectToRoute('app_posts_index', [], Response::HTTP_SEE_OTHER);
        }

        // Si le formulaire n'est pas soumis ou invalide, afficher la page avec le formulaire
        return $this->render('posts/new.html.twig', [
            'post' => $post, // Objet vide ou avec données soumises
            'form' => $form, // Le formulaire à afficher dans Twig
        ]);
    }

    #[Route('/{id}/posts-favorite', name: 'app_posts_favorite', methods: ['POST'])]
    public function favorite(Posts $posts, Request $request, SessionInterface $session): Response
    {
        $session = $request->getSession();
        $favorites = $session->get('favorite', []);

        $id = $posts->getId();

        if (in_array($id, $favorites)) {
            // Retirer des favoris
            $favorites = array_filter($favorites, fn($favId) => $favId != $id);
        } else {
            // Ajouter aux favoris
            $favorites[] = $id;
        }

        $session->set('favorites', $favorites);

        return $this->redirect($request->headers->get('referer'));
    }

    // Route pour afficher un post individuel (détails d’un article)
    #[Route('/{id}', name: 'app_posts_show', methods: ['GET'])]
    public function show(Posts $post, Request $request): Response
    {
        $favorites = $request->getSession()->get('favorites', []); //Id stocker en session
        // Affiche la page de détails d’un post
        //Interroger API

        return $this->render('posts/show.html.twig', [
            'post' => $post, // Symfony injecte automatiquement le post grâce à l’ID
            'favorites' => $favorites,
        ]);


    }

    // Route pour modifier un article existant
    #[Route('/{id}/modifier', name: 'app_posts_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Posts $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostsForm::class, $post); // Crée le formulaire avec les données du post existant
        $form->handleRequest($request); // Gère la soumission

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush(); // Sauvegarde les modifications (pas besoin de "persist" car c'est un objet existant)

            return $this->redirectToRoute('app_posts_index', [], Response::HTTP_SEE_OTHER);
        }

        // Si le formulaire n’est pas soumis ou invalide, affiche la page avec le formulaire rempli
        return $this->render('posts/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    // Route pour supprimer un article (méthode POST, souvent appelée depuis un formulaire invisible)
    #[Route('/{id}', name: 'app_posts_delete', methods: ['POST'])]
    public function delete(Request $request, Posts $post, EntityManagerInterface $entityManager): Response
    {
        // Vérifie la validité du token CSRF pour sécuriser la suppression
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($post); // Marque l'objet pour suppression
            $entityManager->flush();       // Applique la suppression dans la base
        }

        // Redirige vers la liste après la suppression
        return $this->redirectToRoute('app_posts_index', [], Response::HTTP_SEE_OTHER);
    }

}
