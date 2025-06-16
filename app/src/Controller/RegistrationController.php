<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationForm;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request,
                             UserPasswordHasherInterface $userPasswordHasher,
                             EntityManagerInterface $entityManager,
                             Security $security,
                             EmailService $emailService)
    : Response
    {

        $user = new Users();
        $form = $this->createForm(RegistrationForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            $user->setRoles(['ROLE_USER']);


            $entityManager->persist($user);
            $entityManager->flush();

            // Connection automatique avec Security
            $security->login($user);

            //On initialise le contexte
            $context = [
                "username" => $user->getusername(),
            ];

            $emailService->send('admin@lagroovebox.fr', $user->getEmail(), 'Bienvenue dans l\'Univers de la Groove Box', 'register', $context);
            //Envoi d'Email pour l'inscription utilisateur

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
