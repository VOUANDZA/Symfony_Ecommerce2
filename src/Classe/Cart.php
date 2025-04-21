<?php
namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
public function __construct(private RequestStack $requeststack)
{
    
}

    public function add($product)
    {
        //on récupère le panier déjà présent dans la session
  $cart=$this->requeststack->getSession()->get('cart',[]);
  // le [] signifie-> “Si la session 'cart' n’existe pas encore, donne-moi un tab vide.”

        //ajouter la qte+1 si j'ai déja le produit
        if(isset($cart[$product->getId()])){
            $cart[$product->getId()]= [
                'object'=>$product,
                'qte'=>$cart[$product->getId()]['qte'] + 1
            ]; //$cart[$product->getId()]['qte'] + 1 va chercher l'entree qte dans la
            //carte ou le panier pour le rajouter à +1
    } 
    else{
      $cart[$product->getId()]= [
                'object'=>$product,
                'qte'=> 1
            ];
    }
       

         //	Sauvegarder la $cart dans la session
        $this->requeststack->getSession()->set('cart' ,$cart);
       // dd($this->requeststack->getSession()->get('cart'));//le contenu de la session
        //le set prends deux paramètre , le nom de la session et la valeur,
        //notre valeur sera un tableau
        //se tableau doit ressembler ceci
        //$cart[identifiant]=[
       // 'object'=>valeur
        //'qte'=>valeur]
        //on peut faire $cart['panier'] ou $cart[identifiant]
    }
public function getCart(){
    return  $this->requeststack->getSession()->get('cart');
}

public function remove(){
    return  $this->requeststack->getSession()->remove('cart');
}

public function decrease($id){
    $cart=$this->requeststack->getSession()->get('cart');
    
if($cart[$id]['qte'] > 1){
    $cart[$id]['qte'] = $cart[$id]['qte'] -1;
} else{
 unset($cart[$id]);
}
$this->requeststack->getSession()->set('cart' ,$cart);// on met à jour le panier
}

public function fullQuantity(){
    $cart=$this->requeststack->getSession()->get('cart');
    $qte=0;
    if(!isset($cart)){
        return $qte;
    }
   
foreach($cart as $produit){
   $qte+=$produit['qte'];
}
return $qte;
}

public function getTotalwt(){
    $cart=$this->requeststack->getSession()->get('cart');
    $total=0;
    if(!isset($cart)){
        return $total;
    }
    foreach($cart as $produit){
        $total+=$produit['object']->PriceWt() * $produit['qte'];
     } 
     return $total;
}
}