<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController extends AbstractController
{
    #[Route('/connexion', name: 'app_login')]
    public function index(AuthenticationUtils $authentication): Response
    {
               //AuthenticationsUtils est une class dans symfony qui gère des fonctions
        // gerer les erreurs 
        $error=$authentication->getLastAuthenticationError();//Récupère la dernière erreur d'authentification (ex : mauvais mot de passe).
        //gerer le dernier username entrer par l'utilisateur
        $last_username=$authentication->getLastUsername();// Récupère le dernier nom d'utilisateur saisi
        return $this->render('login/index.html.twig', [
            'error' => $error,
            'last_username'=>$last_username
        ]);
 }

 #[Route('/deconnexion','app_logout',methods:['GET'])]
 public function logout():Response
 {
    throw new \Exception("Noubliez pas d'activez le logout dans la sécurité.yaml");
 }
}
