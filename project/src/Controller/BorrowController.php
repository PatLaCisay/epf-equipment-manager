<?php

namespace App\Controller;

use App\Entity\Borrow;
use App\Form\BorrowType;
use App\Entity\ItemBorrow;
use App\Repository\ItemRepository;
use App\Repository\BorrowRepository;
use App\Repository\ItemBorrowRepository;
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
        return $this->render('borrow/index.html.twig');
    }
    
    #[Route('/borrow/view/{id}', name: 'app_borrow_view')]
    public function view(Borrow $borrow): Response
    {
        return $this->render('borrow/view.html.twig',[
            'borrow'=>$borrow
        ]);
    }

    #[Route('/borrow/add', name: 'app_add_borrow')]
    public function add(Request $request, ManagerRegistry $doctrine, SessionInterface $session, ItemRepository $itemRepo, ItemBorrowRepository $itemBorrowRepo): Response
    {
        $repo = new BorrowRepository($doctrine);

        $borrow = new Borrow();
        $form = $this->createForm(BorrowType::class, $borrow);
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
                $itemBorrow = new ItemBorrow();
                $itemBorrow
                    ->setItem($element['item'])
                    ->setBorrow($borrow)
                    ->setQuantity($element['quantity']);
                $doctrine->getManager()->persist($itemBorrow);
            }
            $repo->add($borrow, true);
            
            $doctrine->getManager()->flush();

            return $this->redirectToRoute("app_borrow_mail", ["id"=>$borrow->getId()]);
        }

        return $this->render('borrow/add.html.twig', [
            'form' => $form->createView(),
            'items'=>$items
        ]);
    }
}
