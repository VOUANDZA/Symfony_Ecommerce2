<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
           
            ->setEntityLabelInSingular('Utilisateur')// label au singulier
            ->setEntityLabelInPlural('Utilisateurs');// label au pluriel

           

    }







    
    public function configureFields(string $pageName): iterable
    {
        return [
           TextField::new('firstname')->setLabel('Prénom'),
           TextField::new('lastname')->setLabel('Nom'),
           TextField::new('email')->setLabel('Email')->onlyOnIndex()];//uniquement sur l'index
    }
    
}
