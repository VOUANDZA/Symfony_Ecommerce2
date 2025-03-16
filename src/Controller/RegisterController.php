<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\RegisterUserType;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException as ExceptionUniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(EntityManagerInterface $entityManager,Request $request): Response
    {
      $user=new User();
      $form=$this->createForm(RegisterUserType::class,$user);
      $form->handleRequest($request);
if($form->isSubmitted() && $form->isValid()){
    try {
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash('success','Inscription réussie');
       return $this->redirectToRoute('app_login');
    } catch (ExceptionUniqueConstraintViolationException $ex) {
        $form->get('email')->addError(new FormError('Cet email est déjà utilisé.'));
    }
}


    return $this->render('register/index.html.twig',['registerForm'=>$form->createView()]);
    
}
}