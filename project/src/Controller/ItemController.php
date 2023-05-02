<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    #[Route('/item', name: 'app_item')]
    public function index(): Response
    {
        return $this->render('item/index.html.twig', [
            'controller_name' => 'ItemController',
        ]);
    }

    #[Route('/item/add', name: 'app_add_item')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $repo = new ItemRepository($doctrine);

        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repo->add($form->getData(), true);

            return $this->redirectToRoute('app_item');
        }

        return $this->renderForm('item/add.html.twig', [
            'controller_name' => 'ItemController',
            "form" => $form,
        ]);
    }
}