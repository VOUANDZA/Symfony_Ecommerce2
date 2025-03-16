<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\PassewordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }
    #[Route('/compte/password',name:'app_password')]
   public function password(EntityManagerInterface $entityManager,Request $request,UserPasswordHasherInterface $userPasswordHasher):Response
   {
     $user= $this->getUser(); //obtenir l'utilisateur en cours
    $form=$this->createForm(PassewordUserType::class,$user,['passwordHasher'=>$userPasswordHasher]);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
      $entityManager->flush();
      $this->addFlash('success','votre mot de passe a été correctement modifier');
    }
    return $this->render('account/password.html.twig',['passewordform'=>$form->createView()]);
   }
}
