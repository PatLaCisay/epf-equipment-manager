<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, ItemRepository $itemRepo): Response
    {
        $cart = $session->get("cart", []);

        $items = [];

        foreach($cart as $id => $quantity){
            $items[] = [
                "item" => $itemRepo->find($id),
                "quantity" => $quantity
            ];
        }

        return $this->render('cart/index.html.twig', [
            'items' => $items,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add(Item $item, SessionInterface $session): Response
    {
        $id = $item->getId();
        
        $cart = $session->get("cart", []); //if cart is empty it's initialized by an empty array

        if(!empty($cart[$id])){
            if($item->getStock()<=$cart[$id]){
                $this->addFlash('error', 'Quantité maximum atteinte.');
            }else{
                $cart[$id]++;
            }
            
        }else{
            $cart[$id]=1;
        }

        $session->set("cart", $cart);

        return $this->redirectToRoute("app_home");
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function remove(Item $item, SessionInterface $session): Response
    {
        $id = $item->getId();
        
        $cart = $session->get("cart");

        if(!empty($cart[$id])){
            if($cart[$id]>1){
                $cart[$id]--;
            }else{
                unset($cart[$id]);
            }
        }

        $session->set("cart", $cart);

        return $this->redirectToRoute("app_cart");
    }

    #[Route('/cart/delete/{id}', name: 'app_cart_delete')]
    public function delete(Item $item, SessionInterface $session): Response
    {
        $id = $item->getId();
        
        $cart = $session->get("cart");

        if(!empty($cart[$id])){
            unset($cart[$id]);
        }

        $session->set("cart", $cart);

        return $this->redirectToRoute("app_cart");
    }

}
