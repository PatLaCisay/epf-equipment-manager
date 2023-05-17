<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

    #[Route('/user/delete/{id}', name: 'app_delete_user')]
    public function delete(Request $request, $id,  ManagerRegistry $doctrine): Response
    {
        $entityManager= $doctrine->getManager();
        $userRepo = $entityManager->getRepository(User::class);
        if($id==null){
            return $this->render('user/index.html.twig');
        }
        
        $user = $userRepo->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                "Aucun utilisateur trouvé"
            );    
        }

        $message = 'Vous allez supprimer '.$user->getFirstName().' '.$user->getLastName().' de la BDD. Cette action est irréversible.';

        if($userRepo->isDeletable($user)){
            $form = $this->createFormBuilder()
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
        }else{
            $form = $this->createFormBuilder()
                ->add('abort', SubmitType::class, ['label' => 'Abort'])
                ->getForm();
            
            $form->handleRequest($request);

            $message="Impossible de supprimer ".$user->getFirstName()." ".$user->getLastName()." de la BDD. Cet utilisateur a des emprunts en cours ou est administrateur.";
            
            if($form->isSubmitted())
            {
                return $this->redirectToRoute("app_home");
            }
        }
        return $this->render('user/delete.html.twig', [
            'message'=>$message,
            'form'=>$form->createView()
        ]);
    }
}
