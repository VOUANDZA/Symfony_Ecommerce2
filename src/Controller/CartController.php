<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    #[Route('/monpanier', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' =>$cart->getCart(),
            'totalwt'=>$cart->getTotalwt()
        ]);
    }
    #[Route('/monpanier/cart/{id}', name: 'app_cart_add')]
    public function add($id,Cart $cart, ProductRepository $productRepository,Request $request): Response
        {
          
        $product=$productRepository->findOneById($id);
         $cart->add($product);
          $this->addFlash('success','votre produit a été ajouter au panier');
       return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/monpanier/decrease/{id}', name: 'app_cart_decrease')]
    public function decrease($id,Cart $cart): Response
        {
       
         $cart->decrease($id);
          $this->addFlash('infos','votre produit a été supprimer du panier');
       return $this->redirectToRoute('app_cart');
        }
    #[Route('/cart/remove', name: 'app_cart_remove')]
    public function remove(Cart $cart): Response
        {
       
        $cart->remove();

       return $this->redirectToRoute('app_home');
    }
}
