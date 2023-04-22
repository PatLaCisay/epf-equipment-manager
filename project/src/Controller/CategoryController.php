<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $categories = $doctrine->getRepository(Category::class)->findAll();

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            "categories" => $categories,
        ]);
    }

    #[Route('/category/add', name: 'app_add_category')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $repo = new CategoryRepository($doctrine);

        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repo->add($form->getData(), true);

            return $this->redirectToRoute('app_category');
        }

        return $this->renderForm('category/add.html.twig', [
            'controller_name' => 'CategoryController',
            'form' => $form,
        ]);
    }
}
