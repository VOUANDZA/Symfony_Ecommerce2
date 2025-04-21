<?php
namespace App\Twig;

use App\Repository\CategoryRepository;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;
use App\Classe\Cart;

class AppExtensions extends AbstractExtension implements GlobalsInterface
//m'oblige a utilisé la function getglobals
{
private $categoryRepository;
private $cart;

public function __construct(CategoryRepository $categoryRepository,Cart $cart){
    $this->categoryRepository=$categoryRepository;
    $this->cart=$cart;
}

public function getFilters()
{
    return [
        new TwigFilter('price',[$this,'formatPrice'])//nom du filtre(price), this(object),
        // formatprice->nom de la function qui va faire le traitement du filtre
    ];
}
public function formatPrice($number){
return number_format($number,'2', ','). '€';
}

public function  getGlobals():array
{
   return [
    'allcategories'=>$this->categoryRepository->findAll(),
    'fullQuantity'=>$this->cart->fullQuantity()
   ];
}

}