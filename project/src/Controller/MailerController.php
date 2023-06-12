<?php

namespace App\Controller;

use Twig\Environment;

use App\Entity\Borrow;
use App\Repository\BorrowRepository;
use Symfony\Component\Mime\Email;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
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

    #[Route('/mail/borrow/{id}', name: 'app_borrow_mail')]
    public function borrow(MailerInterface $mailer, Borrow $borrow, Environment $twig, BorrowRepository $repo ): Response
    {
        
        $sender_email = $_ENV["EMAIL_ADDRESS"];

        $emailContent = $twig->render('mailer/borrow.html.twig', [
            'stakeHolder' => $borrow->getStakeholder(),
            'pm' => $borrow->getProjectManager(),
            'borrow' => $borrow,
            'items' => $repo->findItems()
        ]);

        $email = (new Email())
            ->from($sender_email)
            ->to($borrow->getStakeholder()->getEmail())
            ->html($emailContent);
        $mailer->send($email);

        return $this->redirectToRoute("app_borrow");
    }
}
