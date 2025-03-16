<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\FormError;
class PassewordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualpassword' ,PasswordType::class,['label'=>"Saisissez le mot de passe actuel ","attr"=>['style'=>"width:50%"],'mapped'=>false])
          
            ->add('plainPassword',RepeatedType::class,[
                'type' => PasswordType::class, 'constraints'=>[
                  new Regex([
                    'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                    'message' => 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.'
                ])],
                'first_options'  => ['label' => 'Votre mot de passe', 'hash_property_path' => 'password','attr'=>['placeholder'=>"Saissisez votre nouveau mot de passe",'style'=>"width:50%"]],
                'second_options' => ['label' => 'Confirmez votre nouveau mot de passe','attr'=>['placeholder'=>"Confirmez votre mot de passe",'style'=>"width:50%"]],
                'mapped' => false])
            ->add('Modification',SubmitType::class,['attr'=>['class'=>"btn btn-success"]])
            ->addEventListener(FormEvents::SUBMIT,function(FormEvent $event ){
                $form = $event->getForm();
                $user = $form->getConfig()->getOptions()['data']; // Récupère l'utilisateur
                $passwordHasher = $form->getConfig()->getOptions()['passwordHasher']; // Récupère le hasher
                $actualPassword = $form->get('actualpassword')->getData();
           
                $isvalid=$passwordHasher->isPasswordValid($user, $actualPassword);
                // Récupération du mot de passe saisi par l'utilisateur
           
                
                if (!$actualPassword) {
                    $form->get('actualpassword')->addError(new FormError("Veuillez saisir votre mot de passe actuel."));
                    return; // Stoppe l'exécution si le champ est vide
                }
            
                // Récupération du mot de passe haché stocké en BDD
                $passwordBdd = $user->getPassword();
            
                // Vérification du mot de passe avec le hasher
                if (!$isvalid) {
                    $form->get('actualpassword')->addError(new FormError("Le mot de passe actuel est incorrect."));
                }
            });// permet decouter le formulaire
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordHasher'=>null // Valeur par défaut pour eviter une erreur
        ]);
    }
}
