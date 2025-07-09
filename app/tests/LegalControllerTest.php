<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LegalControllerTest extends WebTestCase
{
    public function testIndexPageIsAccessible(): void
    {
        $client = static::createClient(); //Creer virtuellement un navigateur
        $client->request('GET', '/confidentialite'); //Envoi de la requete vers l'URL

        $this->assertResponseIsSuccessful(); //Charge bien la page
        $this->assertSelectorTextContains('h1', 'Politique'); //Verifi le contenu
    }
}
