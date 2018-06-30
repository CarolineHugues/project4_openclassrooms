<?php

// src/project4OC/BookingBundle/Tests/ControllersTests/FrontendControllerTest.php 

namespace project4OC\BookingBundle\Tests\ControllersTests;
 
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase; 
 
class FrontendControllerTest extends WebTestCase 
{
	public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Informations pratiques', $crawler->filter('h2')->text());
    }
}