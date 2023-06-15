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
            'stakeholder' => $borrow->getStakeholder(),
            'pm' => $borrow->getProjectManager(),
            'borrow' => $borrow,
            'items' => $repo->findItems()
        ]);

        $email = (new Email())
            ->from($sender_email)
            ->to($borrow->getStakeholder()->getEmail())
            ->subject("[NO-REPLY] Demande d'emprunt d'articles n°". $borrow->getId()." - ".$borrow->getProjectManager()->getFirstName()." ".$borrow->getProjectManager()->getLastName())
            ->html($emailContent);
        $mailer->send($email);

        return $this->redirectToRoute("app_borrow");
    }

    #[Route('/mail/revoke/borrow/{id}', name: 'app_borrow_revoke_mail')]
    public function revokeBorrow(MailerInterface $mailer, Borrow $borrow, Environment $twig, ManagerRegistry $doctrine ): Response
    {
        
        $sender_email = $_ENV["EMAIL_ADDRESS"];

        $emailContent = $twig->render('mailer/borrowRevoke.html.twig', [
            'stakeholder' => $borrow->getStakeholder(),
            'pm' => $borrow->getProjectManager(),
            'borrow' => $borrow
        ]);

        $email = (new Email())
            ->from($sender_email)
            ->to($borrow->getProjectManager()->getEmail())
            ->subject('Votre emprunt a été refusé par '.$borrow->getStakeholder()->getFirstName().' '.$borrow->getStakeholder()->getLastName().'.')
            ->html($emailContent);
        $mailer->send($email);

        $borrow->setAccepted(false);
        $doctrine->getManager()->flush();

        return $this->redirectToRoute("app_admin");
    }
}
