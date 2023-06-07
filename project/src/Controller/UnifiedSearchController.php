<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\UnifiedSearchType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UnifiedSearchController extends AbstractController
{
    #[Route('/search', name: 'app_unified_search')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $request->query->get('search');

        if ($form) {
            $searched_name = $form;
            $search_results = $doctrine->getRepository(Item::class)
                        ->findByDefaultMatch($form);

            return $this->renderForm('unified_search/index.html.twig', [
                'controller_name' => 'UnifiedSearchController',
                'keyword' => $searched_name,
                'results' => $search_results,
            ]);
        }

        return $this->renderForm('unified_search/index.html.twig', [
            'controller_name' => 'UnifiedSearchController',
        ]);
    }
}
