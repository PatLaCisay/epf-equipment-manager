<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    { 
        $available = $doctrine->getRepository(Item::class)->findAvailableNow();
        $rented = $doctrine->getRepository(Item::class)->findRentedNow();

        return $this->render('home/index.html.twig', [
            'available_items' => $available,
            'rented_items' => $rented,
        ]);
    }
}
