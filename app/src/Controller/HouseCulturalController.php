<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HouseCulturalController extends AbstractController
{
    #[Route('/house-culture', name: 'app_house_cultural')]
    public function index(PostsRepository $postsRepository): Response
    {
        //findBy méthode auto
        $culturalPosts = $postsRepository->findByType('cultural');

        return $this->render('house_cultural/index.html.twig', [
            'controller_name' => 'HouseCulturalController',
            'posts' =>  $culturalPosts
        ]);
    }
}
