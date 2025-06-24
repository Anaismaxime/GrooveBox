<?php

namespace App\Controller;

use App\Form\ChangePasswordForm;
use App\Form\ResetPasswordForm;
use App\Repository\UsersRepository;
use App\Service\EmailService;
use App\Service\JWTService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Security $security): Response
    {
        //Traitement du login (traitement interne à symfony)
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/forgotten-password', name: 'app_forgot_password')]
    public function forgottenPassword(
        Request         $request, //Request httpfondation pour HandleRequest
        UsersRepository $usersRepository, //Interroger la base
        JWTService      $JWTService,
        EmailService     $emailService
    ): Response
    {
        $form = $this->createForm(ResetPasswordForm::class);
        // Recuperer le contenu de mon formulaire pour le manipuler
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //le formulaire est envoyé et valide
            //Récuperation Utilisateur dans la base
            $user = $usersRepository->findOneByEmail($form->get('email')->getData());

            if ($user) { //Si on a un utilisateur
                //header Structuration du token
                $header = [
                    'typ' => 'JWT',
                    'alg' => 'HS256',
                ];

                //payload
                $payload = [
                    'user_id' => $user->getId(),
                ];

                //Générer le token
                $token = $JWTService->generate($header, $payload, $this->getParameter('app.jwtsecret'));

                //On génère l'url vers reset password
                $url = $this->generateUrl('reset_forgotten_password', ['token' => $token],
                    UrlGeneratorInterface::ABSOLUTE_URL);

                //Envoi d'Email pour l'inscription utilisateur
                $emailService->send(
                    'admin@lagroovebox.fr',
                    $user->getEmail(),
                    'Récupération de Mot de passe',
                    'password_reset',
                    compact('user', 'url')
                );
            }
            //$user est null
            $this->addFlash('success', 'Email envoyé avec succès');
            return $this->redirectToRoute('app_login'); //Redirection sur la page de connexion
        }

        return $this->render('security/reset_forgotten_password.html.twig', [
            'RequestPassForm' => $form
        ]);
    }

    #[Route('/forgotten-password/{token}', name: 'reset_forgotten_password')]
    public function resetPassword(
        $token,
        JWTService $jwtService,
        UsersRepository $usersRepository,
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ):Response
    {
        //On vérifie si le token est valide (cohérent, pas expiré et signature correcte)
        if($jwtService->isValid($token) && !$jwtService->isExpired($token) && $jwtService->check(
            $token, $this->getParameter('app.jwtsecret'))) {
            //Token valide
            $payload = $jwtService->getPayload($token); //On récupère les données
            $user = $usersRepository->find($payload['user_id']); //On récupère le user

            if($user){
                $form= $this->createForm(ChangePasswordForm::class);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $user->setPassword(
                        $userPasswordHasher->hashPassword($user, $form->get('password')->getData())//On hash le mot de passe
                    );

                    $entityManager->flush();//J'enregistre en base de donnée

                    $this->addFlash('success', 'Mot de passe modifié avec succès');
                    return $this->redirectToRoute('app_login'); //Redirection sur la page de connexion
                }

                return $this->render('security/change_password.html.twig', [
                    'ChangePasswordForm' => $form->createView()
                ]);
            }
        }

        $this->addFlash('danger', 'Votre lien est invalide ou a expiré');
        return $this->redirectToRoute('app_login');
    }



}
