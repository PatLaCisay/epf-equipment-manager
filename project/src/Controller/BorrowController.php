<?php

namespace App\Controller;

use App\Entity\Borrow;
use App\Form\BorrowType;
use App\Repository\BorrowRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BorrowController extends AbstractController
{
    #[Route('/borrow', name: 'app_borrow')]
    public function index(): Response
    {
        return $this->render('borrow/index.html.twig', [
            'controller_name' => 'BorrowController',
        ]);
    }

    #[Route('/borrow/add', name: 'app_add_borrow')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $repo = new BorrowRepository($doctrine);

        $borrow = new Borrow();
        $form = $this->createForm(BorrowType::class, $borrow);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repo->add($form->getData(), true);
            
            return $this->redirectToRoute('app_borrow');
        }

        return $this->render('borrow/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/borrow/edit/{id}', name: 'app_edit_borrow')]
    public function edit(Borrow $borrow, Request $request, ManagerRegistry $doctrine): Response
    {
        $repo = new BorrowRepository($doctrine);

        $form = $this->createForm(BorrowType::class, $borrow);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repo->add($form->getData(), true);
            
            return $this->redirectToRoute('app_borrow');
        }

        return $this->render('borrow/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
