<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,['label'=>"Votre email",'attr'=>['placeholder'=>"Entrez votre adresse Email",'style'=>"width:50%"]])
           ->add('plainPassword',RepeatedType::class,[
            'type' => PasswordType::class, 'constraints'=>[
              new Regex([
                'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                'message' => 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.'
            ])],
            'first_options'  => ['label' => 'Votre mot de passe', 'hash_property_path' => 'password','attr'=>['placeholder'=>"Entrez votre mot de passe",'style'=>"width:50%"]],
            'second_options' => ['label' => 'Confirmez votre mot de passe','attr'=>['placeholder'=>"Confirmez votre mot de passe",'style'=>"width:50%"]],
            'mapped' => false])

     ->add('firstname',TextType::class,['label'=>"Votre prenom",'attr'=>['placeholder'=>"Entrez votre mot de passe",'style'=>"width:50%"],'constraints'=>[ new Regex([
       'pattern' => '/^[A-Z][a-z]+$/',
     'message' => 'Le prénom doit commencer par une majuscule, suivi de lettres minuscules.'
    ])
             ]])
            ->add('lastname',TextType::class,['label'=>"Votre Nom",'attr'=>['placeholder'=>"Entrez votre nom",'style'=>"width:50%"],'constraints'=>[
                new Regex([
                 'pattern' => '/^[A-Z]+$/',
                'message' => 'Le nom doit contenir uniquement des lettres majuscules.'
                ])]])
            ->add('Inscription',SubmitType::class,['attr'=>['class'=>"btn btn-success"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
            'data_class' => User::class,
        ]);
    }
}
