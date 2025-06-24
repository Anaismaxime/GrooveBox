<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class EmailService
{
    private MailerInterface $mailer;

    //On charge le MailerInterface dans le constructeur
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    //Ecriture de la logique d'envoi de mail
    public function send(string $form,  string $to, string $subject, string $template, array $context = []): void
    {
        $email = (new TemplatedEmail())
        ->from($form)
        ->to($to)
        ->subject($subject)
        ->htmlTemplate("emails/$template.html.twig")
        ->context($context)
        ;
        $this->mailer->send($email);
    }

}
