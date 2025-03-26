<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InscriptionTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();//creation du client ou du faux nav
        $client->request('GET','/inscription');//le client se pointe à L'url inscription
        //on a besoin de nos difféérent input pour que notre faux client sache dans quoi rentrer des infos
       // $crawler = $client->request('GET', '/');
      

    $client->submitForm('Inscription',['register_user[email]'=>'ma@gmail.com', 
    'register_user[plainPassword][first]'=>'Noeldy@2020',
        'register_user[plainPassword][second]'=>'Noeldy@2020',
       'register_user[firstname]'=>'Cedrioo',
       'register_user[lastname]'=>'VOUqqADZAsee'

    ]);
   
     // Vérifie la redirection après inscription
    $this->assertResponseRedirects('/connexion');
        // Suivre la redirection
    $client->followRedirect();
        // Vérifier la présence du message flash
    $this->assertSelectorExists('div:contains("Inscription réussie")');
      
    }
} 
