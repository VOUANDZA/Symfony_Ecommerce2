<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
           
            ->setEntityLabelInSingular('Catégorie')// label au singulier
            ->setEntityLabelInPlural('Catégories');// label au pluriel

           

    }


    
    public function configureFields(string $pageName): iterable
    {
        return [
       
            TextField::new('name')->setLabel('Titre')->setHelp('Titre de la categorie'),
           SlugField::new('slug')->setLabel('Url')->setTargetFieldName('name')->setHelp('Url generer automatiquement')//on a besoin de ce champs pour creer le slog
        ];
    }
    
}

