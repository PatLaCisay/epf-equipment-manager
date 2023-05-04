<?php

namespace App\Controller;

use App\Form\UnifiedSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UnifiedSearchController extends AbstractController
{
    #[Route('/search', name: 'app_unified_search')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(UnifiedSearchType::class);
        $form->handleRequest($request);

        return $this->renderForm('unified_search/index.html.twig', [
            'controller_name' => 'UnifiedSearchController',
            'form' => $form,
        ]);
    }
}
