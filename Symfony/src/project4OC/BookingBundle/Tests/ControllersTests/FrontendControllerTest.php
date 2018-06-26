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

    public function testBookingForm()
    {
    	$client = static::createClient();
 
  		$crawler = $client->request('GET', '/');
      $form = $crawler->selectButton('booking[save]')->form(array(
	      'booking[mail]' => 'contact@test.fr',
	      'booking[visitDay][date]' => '01-02-2019',
	      'booking[ticketType]' => 'halfDay_ticketType',
	      'booking[numberOfTickets]' => '1',
	    ));

      $values = $form->getPhpValues();
      $values['booking']['tickets'][0]['name'] = 'Hugues';
      $values['booking']['tickets'][0]['surname'] = 'Caroline';
      $values['booking']['tickets'][0]['birthDate']['day'] = '9';
      $values['booking']['tickets'][0]['birthDate']['month'] = '10';
      $values['booking']['tickets'][0]['birthDate']['year'] = '1991';
      $values['booking']['tickets'][0]['country'] = 'FR';
      $values['booking']['tickets'][0]['reducedRate'] = '1';
      
      $crawler = $client->request('POST', '/', $values);

      $this->assertEquals(1, $crawler->filter('#booking_tickets_0')->count());

      var_dump($values);

      /*$crawler = $client->followRedirect();*/

  		$this->assertEquals('project4OC\BookingBundle\Controller\FrontendController::indexAction', $client->getRequest()->attributes->get('_controller'));
      $this->assertContains('Récapitulatif', $crawler->filter('h2')->text());
    }

    /*public function testPaiementAndMail()
    {
      SELF::testIndex();

    	$client = static::createClient();
  		$crawler = $client->request('POST', '/');

    	$formStripe = $crawler->selectButton('submit-stripe')->form(array(
	      'cardnumber' => '4242 4242 4242 4242',
	      'exp-date' => '10/21',
	      'cvc' => '123',
	    ));

    	$client->submit($formStripe);
  		$this->assertEquals('project4OC\BookingBundle\Controller\FrontendController::confirmationAction', $client->getRequest()->attributes->get('_controller'));
    }*/
}