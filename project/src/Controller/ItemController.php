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
    public function index(ManagerRegistry $doctrine): Response
    {
        $items = $doctrine->getRepository(Item::class)->findAll();

        return $this->render('item/index.html.twig', [
            "items" => $items,
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
            "form" => $form,
        ]);
    }

    #[Route('/item/{id}', name: 'app_view_item', requirements: ['id' => '\d+'])]
    public function view(Item $item): Response
    {
        return $this->render('item/view.html.twig', [
            "item" => $item,
        ]);
    }


    #[Route('/item/available', name: 'app_available_items')]
    public function available(ManagerRegistry $doctrine): Response
    {
        $available = $doctrine->getRepository(Item::class)->findAvailableNow();

        return $this->render('item/available.html.twig', [
            'controller_name' => 'AvailableItemsController',
            'available_items' => $available,
        ]);
    }
}
