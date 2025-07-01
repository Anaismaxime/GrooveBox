<?php

namespace App\Controller;


use App\Form\ContactsForm;
use App\Repository\ArtistsRepository;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Request $request, MailerInterface $mailer, ArtistsRepository $artistsRepository, PostsRepository $postsRepository): Response
    {

        $form = $this->createForm(ContactsForm::class );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $email = (new Email())
                ->from($contact['email']) //On utilise pas d'entité donc tableau
                ->to('contact@lagroovebox.fr') //Fictive
                ->subject('Nouvelle proposition depuis la GrooveBox')
                ->text($contact['subject']);

            $mailer->send($email);
            $this->addFlash('success','Message envoyé avec succès');
            return $this->redirectToRoute('app_main');
        }

        //Ici on récupère l'artiste de la semaine
        $artistOfTheWeek = $artistsRepository->findArtistOfTheWeek();
        $lastPosts = $postsRepository->findDiapoLastThree();

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
            'artistOfTheWeek' => $artistOfTheWeek, //Transmet à mon twig
            'lastPosts' => $lastPosts,
        ]);
    }
}
