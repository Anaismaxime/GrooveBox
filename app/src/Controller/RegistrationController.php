<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationForm;
use App\Service\EmailService;
use App\Service\JWTService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request,
                             UserPasswordHasherInterface $userPasswordHasher,
                             EntityManagerInterface $entityManager,
                             Security $security,
                             EmailService $emailService,
                             JWTService $JWTService)
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
            //$security->login($user);

            //header Structuration du token
            $header= [
                'typ' => 'JWT',
                'alg' => 'HS256',
            ];

            //payload
            $payload = [
                'user_id' => $user->getId(),
            ];

            //Générer le token
            $token = $JWTService->generate($header, $payload,$this->getParameter('app.jwtsecret'));


            //On initialise le contexte
            $context = [
                "username" => $user->getusername(),
            ];
            //Envoi d'Email pour l'inscription utilisateur
            $emailService->send(
                'admin@lagroovebox.fr',
                $user->getEmail(),
                'Bienvenue dans l\'Univers de la Groove Box',
                'register', $context);


            return $this->redirectToRoute('app_profile');
        }

        $this->addFlash('danger', 'Votre lien est invalide ou a expiré');
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
