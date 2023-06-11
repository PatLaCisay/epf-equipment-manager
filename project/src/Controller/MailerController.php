<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerController extends AbstractController
{

    #[Route('/mail', name: 'app_mail')]
    public function index(MailerInterface $mailer): Response
    {

        $sender_email = $_ENV["EMAIL_ADDRESS"];

        $email = (new Email())
            ->from($sender_email)
            ->to($sender_email)
            ->subject('Test d\'envoi')
            ->text('Ceci est un courriel envoyé depuis Symfony.');
        $mailer->send($email);

        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
