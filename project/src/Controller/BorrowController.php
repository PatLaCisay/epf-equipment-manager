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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
    public function add(Request $request, ManagerRegistry $doctrine, SessionInterface $session, ItemRepository $itemRepo): Response
    {
        $repo = new BorrowRepository($doctrine);

        $borrow = new Borrow();
        $form = $this->createForm(BorrowType::class, $borrow);

        //getting items from the session cart
        $cart=$session->get("cart",[]);
        $items = [];

        if(empty($cart)){
            return $this->redirectToRoute("app_cart");
        }else{

            foreach($cart as $id => $quantity){
                $items[] = [
                    "item" => $itemRepo->find($id),
                    "quantity" => $quantity
                ];
            }
        }

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($items as $element) {
                $borrow->addItem($element['item']);
            }
            $repo->add($borrow, true);

            return $this->redirectToRoute('app_borrow');
        }

        return $this->render('borrow/add.html.twig', [
            'form' => $form->createView(),
            'items'=>$items
        ]);
    }
}
