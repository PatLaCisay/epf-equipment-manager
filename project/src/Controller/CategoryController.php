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
            

            return $this->redirectToRoute('app_admin');
        }

        return $this->renderForm('category/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/category/{id}', name: 'app_view_category', requirements: ['id' => '\d+'])]
    public function view(Category $category): Response
    {
        return $this->render('category/view.html.twig', [
            "category" => $category,
        ]);
    }
}
