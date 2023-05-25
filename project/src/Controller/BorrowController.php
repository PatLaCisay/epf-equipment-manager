<?php

namespace App\Controller;

use App\Entity\Borrow;
use App\Form\BorrowType;
use App\Repository\BorrowRepository;
use App\Repository\ItemRepository;
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

            foreach($form->get('items')->getData() as $item){
                $borrow->addItem($item);
            }
            
            $doctrine->getManager()->persist($borrow);
            $doctrine->getManager()->flush();
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
            foreach($form->get('items')->getData() as $item){
                $borrow->addItem($item);
            }
            
            $doctrine->getManager()->persist($borrow);
            $doctrine->getManager()->flush();
            
            return $this->redirectToRoute('app_edit_borrow', ['id' => $borrow->getId()]);
        }

        return $this->render('borrow/edit.html.twig',[
            'form' => $form->createView(),
            'borrow' => $borrow
        ]);
    }

    #[Route('/borrow/edit/{id}/remove/{itemId}', name: 'app_edit_borrow_item_removal')]
    public function removeItem(Borrow $borrow, ManagerRegistry $doctrine, $id, $itemId): Response
    {
        $borrowRepo = new BorrowRepository($doctrine);
        $itemRepo = new ItemRepository($doctrine);

        $borrow = $borrowRepo->find($id);

        $borrow->removeItem($itemRepo->find($itemId));

        $doctrine->getManager()->flush();
        return $this->redirectToRoute('app_edit_borrow', ['id' => $id]);
    }

    #[Route('/borrow/remove/{id}', name: 'app_remove_borrow')]
    public function remove(Borrow $borrow, ManagerRegistry $doctrine): Response
    {
        $borrowRepo = new BorrowRepository($doctrine);
        $borrowRepo->remove($borrow, true);
        return $this->redirectToRoute('app_borrow');
    }
}
