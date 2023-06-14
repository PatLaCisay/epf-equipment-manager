<?php

namespace App\Controller;

use App\Entity\Borrow;
use App\Entity\Item;
use App\Form\ExcelType;
use App\Repository\UserRepository;
use App\Repository\BorrowRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(UserRepository $userRepo): Response
    {
        $userId = $userRepo->find(1);
        $pendingBorrows = $userRepo->findPendingBorrows($userId);


        return $this->render('admin/index.html.twig', [
            'pendingBorrows' => $pendingBorrows,
        ]);
    }

    #[Route('/admin/validate/{id}', name: 'app_admin_validate_borrow')]
    public function validateBorrow(Borrow $borrow,  ManagerRegistry $doctrine ): Response
    {
        $borrow->setAccepted(true);
        $doctrine->getManager()->flush();

        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/revoke/{id}', name: 'app_admin_revoke_borrow')]
    public function revokeBorrow(Request $request, Borrow $borrow, ManagerRegistry $doctrine): Response
    {
    
        $form = $this->createFormBuilder()
            ->add('description', TextType::class)
            ->add('proceed', SubmitType::class, ['label' => 'Valider'])
            ->add('abort', SubmitType::class, ['label' => 'Retour'])
            ->getForm();
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if($form->get('abort')->isClicked()) //this method works and is imported from 'Symfony\Component\Form\Extension\Core\Type\SubmitType' but isn't recognized
            {
                return $this->redirectToRoute("app_admin");
            }
            if ($form->get('proceed')->isClicked())
            {  
                $borrow->setDescription($form->get('description')->getData());
                $doctrine->getManager()->flush();
                return $this->redirectToRoute("app_borrow_mail", ["id"=>$borrow->getId()]);
            }
        }

        return $this->render('admin/borrowRevoke.html.twig', [
            'form' => $form->createView(),
            'borrow' => $borrow
        ]);
    }

    #[Route('/admin/import/items', name: 'app_admin_import_items')]
    public function importItems(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(ExcelType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $file = $form->get('file')->getData();
            $spreadsheet = IOFactory::load($file->getPathname());
            
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();

            for ($row = 2; $row <= $highestRow; $row++) {
                $item = new Item();
                $item
                    ->setName($worksheet->getCell('A' . $row)->getValue())
                    ->setPrice((float)$worksheet->getCell('B' . $row)->getValue())
                    ->setStock((integer)$worksheet->getCell('C' . $row)->getValue())
                    ->setCategory($form->get('category')->getData())
                    ->setDefaultImage()
                    ;
                
                
                $entityManager->persist($item);
            }

            // Flush all changes to the database
            $entityManager->flush();
        }

        return $this->render('admin/import_items.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
