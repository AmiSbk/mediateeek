<?php

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tester l'accès à la page d'accueil
 *
 */
class AccueilControllerTest extends WebTestCase {

    /**
     * Test l'accès à la page d'accueil
     */
    public function testAccesPage(){
       $client = static::createClient();
       $client->request('GET', '/');
       $this->assertResponseStatusCodeSame(Response::HTTP_OK);
   }
}