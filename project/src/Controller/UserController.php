<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/delete/{id}', name: 'app_user')]
    public function delete(Request $request, $id,  ManagerRegistry $doctrine): Response
    {
        $entityManager= $doctrine->getManager();
        if($id==null){
            return $this->render('user/index.html.twig');
        }
        
        $user = $entityManager
            ->getRepository(User::class)
            ->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                "Aucun utilisateur trouvé"
            );    
        }

        $form = $this->createFormBuilder($user)
            ->add('proceed', SubmitType::class, ['label' => 'Proceed'])
            ->add('abort', SubmitType::class, ['label' => 'Abort'])
            ->getForm();
        
        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            if($form->get('abort')->isClicked()) //this method works and is imported from 'Symfony\Component\Form\Extension\Core\Type\SubmitType' but isn't recognized
            {
                return $this->redirectToRoute("app_home");
            }
            if ($form->get('proceed')->isClicked())
            {            
                $entityManager->remove($user);
                $entityManager->flush();
                return $this->redirectToRoute("app_home");
            }
        }
        return $this->render('user/delete.html.twig', [
            'form'=>$form->createView(),
            'user'=>$user
        ]);
    }
}
