<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
           
            ->setEntityLabelInSingular('Produit')// label au singulier
            ->setEntityLabelInPlural('Produits');// label au pluriel

           

    }

    
    public function configureFields(string $pageName): iterable
    {
        $required=true;
        if($pageName=='edit'){
            $required=false;
        }
        return [
        
            TextField::new('name')->setLabel('nom')->setHelp('nom de votre produit'),
            SlugField::new('slug')->setTargetFieldName('name')->setLabel('Url')->setHelp('url generer automatiquement'),
            TextEditorField::new('description')->setLabel('Description')->setHelp('description de votre produit'),
            ImageField::new('illustration')
            ->setLabel('Image')->setHelp('image du produit')
            ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
            ->setBasePath('/uploads')->setUploadDir('public/uploads')->setRequired($required),
            
            NumberField::new('price')->setLabel('Prix HT')->setHelp('le prix de votre produit sans €'),
            ChoiceField::new('tva')->setLabel('Taux de tva')->setChoices(['5,5%'=>'5.5','10%'=>'10','20%'=>'20']),
            AssociationField::new('category'),
         
         
        ];
    }
    
}
