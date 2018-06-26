<?php

// src/project4OC/BookingBundle/Tests/ServicesTests/P4OCVerifyAvailableDateTest.php

namespace project4OC\BookingBundle\Tests\ServicesTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use project4OC\BookingBundle\Entity\VisitDay;
use project4OC\BookingBundle\Entity\Booking;

class P4OCVerifyAvailableDateServiceTest extends WebTestCase
{

	public function testAvailableDate()
	{
		$visitDay = new visitDay();
		$date = new \DateTime('2019-09-12');
		$visitDay->setDate($date);
		$visitDay->setGauge('2');

		$kernel = static::createKernel();
 		$kernel->boot();
 
 		$container = $kernel->getContainer();
 
 		$service = $container->get('project4_oc_booking.verifyavailabledate');

 		$result = $service->available($visitDay);

 		$this->assertEquals(true, $result);
	}

	public function testMessageFullGauge()
	{
		$visitDay = new visitDay();
		$date = new \DateTime('2019-10-12');
		$visitDay->setDate($date);
		$visitDay->setGauge('1000');

		$kernel = static::createKernel();
 		$kernel->boot();
 
 		$container = $kernel->getContainer();
 
 		$service = $container->get('project4_oc_booking.verifyavailabledate');

 		$result = $service->available($visitDay);

 		$this->assertEquals('Cette date n\'est pas disponible à la réservation', $result);
	}

	public function testMessagePastDate()
	{
		$visitDay = new visitDay();
		$date = new \DateTime('2017-10-12');
		$visitDay->setDate($date);
		$visitDay->setGauge('2');

		$kernel = static::createKernel();
 		$kernel->boot();
 
 		$container = $kernel->getContainer();
 
 		$service = $container->get('project4_oc_booking.verifyavailabledate');

 		$result = $service->available($visitDay);

 		$this->assertEquals('Cette date n\'est pas disponible à la réservation', $result);
	}

	public function testNotEnoughTickets()
	{
		$visitDay = new visitDay();
		$visitDay->setGauge('998');
		$booking = new booking();
		$booking->setNumberOfTickets('4');

		$kernel = static::createKernel();
 		$kernel->boot();
 
 		$container = $kernel->getContainer();
 
 		$service = $container->get('project4_oc_booking.verifyavailabledate');

 		$result = $service->notEnoughTickets($visitDay, $booking);

 		$this->assertEquals('Vous souhaitez réserver 4 tickets cependant il reste seulement 2 tickets disponibles à la date choisie.', $result);
	}

	public function testEnoughTickets()
	{
		$visitDay = new visitDay();
		$visitDay->setGauge('500');
		$booking = new booking();
		$booking->setNumberOfTickets('4');

		$kernel = static::createKernel();
 		$kernel->boot();
 
 		$container = $kernel->getContainer();
 
 		$service = $container->get('project4_oc_booking.verifyavailabledate');

 		$result = $service->notEnoughTickets($visitDay, $booking);

 		$this->assertEquals(false, $result);
	}

	public function testGroupRate()
	{
		$booking = new booking();
		$booking->setNumberOfTickets('15');

		$kernel = static::createKernel();
 		$kernel->boot();
 
 		$container = $kernel->getContainer();
 
 		$service = $container->get('project4_oc_booking.verifyavailabledate');

 		$result = $service->individualOrGroupRate($booking);

 		$this->assertEquals("Veuillez contacter l'équipe du musée du Louvre pour réserver au-delà de 14 personnes et/ou obtenir des informations sur le tarif groupe.", $result);
	}

	public function testIndividualRate()
	{
		$booking = new booking();
		$booking->setNumberOfTickets('8');

		$kernel = static::createKernel();
 		$kernel->boot();
 
 		$container = $kernel->getContainer();
 
 		$service = $container->get('project4_oc_booking.verifyavailabledate');

 		$result = $service->individualOrGroupRate($booking);

 		$this->assertEquals("individual", $result);
	}

	public function testVerifyAvailableSelectedDate()
	{
		$booking = new booking();
		$booking->setNumberOfTickets('8');
		$visitDay = new visitDay();
		$date = new \DateTime('2019-09-12');
		$visitDay->setDate($date);
		$visitDay->setGauge('2');

		$kernel = static::createKernel();
 		$kernel->boot();
 
 		$container = $kernel->getContainer();
 
 		$service = $container->get('project4_oc_booking.verifyavailabledate');

 		$result = $service->verifyAvailableSelectedDate($date, $visitDay, $booking);

 		$this->assertEquals("availableDate", $result);
	}

	public function testVerifyAvailableSelectedDateMessage()
	{
		$booking = new booking();
		$booking->setNumberOfTickets('15');
		$visitDay = new visitDay();
		$date = new \DateTime('2019-09-12');
		$visitDay->setDate($date);
		$visitDay->setGauge('2');

		$kernel = static::createKernel();
 		$kernel->boot();
 
 		$container = $kernel->getContainer();
 
 		$service = $container->get('project4_oc_booking.verifyavailabledate');

 		$result = $service->verifyAvailableSelectedDate($date, $visitDay, $booking);

 		$this->assertEquals("Veuillez contacter l'équipe du musée du Louvre pour réserver au-delà de 14 personnes et/ou obtenir des informations sur le tarif groupe.", $result);
	}
}