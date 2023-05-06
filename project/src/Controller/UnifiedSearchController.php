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
        $form = $this->createForm(UnifiedSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searched_name = $form->get('query')->getData();
            $search_results = [];

            switch ($form->get("criterion")->getData()) {
                case "auto":
                    $search_results = $doctrine->getRepository(Item::class)
                        ->findByDefaultMatch($searched_name);
                    break;

                case "item":
                    $search_results = $doctrine->getRepository(Item::class)
                        ->findByNameMatch($searched_name);
                    break;

                case "cat":
                    $search_results = $doctrine->getRepository(Item::class)
                        ->findByCategoryMatch($searched_name);
                    break;

                default:
                    throw new \Exception("Unknow criterion selected.", 1);
            }

            return $this->renderForm('unified_search/index.html.twig', [
                'controller_name' => 'UnifiedSearchController',
                'form' => $form,
                "results" => $search_results,
            ]);
        }

        return $this->renderForm('unified_search/index.html.twig', [
            'controller_name' => 'UnifiedSearchController',
            'form' => $form,
        ]);
    }
}
