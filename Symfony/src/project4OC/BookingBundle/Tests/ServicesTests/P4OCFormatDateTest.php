<?php

// src/project4OC/BookingBundle/Tests/ServicesTests/P4OCFormatDateTest.php

namespace project4OC\BookingBundle\Tests\ServicesTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use project4OC\BookingBundle\Entity\Booking;
use project4OC\BookingBundle\Entity\VisitDay;

class P4OCFormatDateServiceTest extends WebTestCase
{
	public function testFormatDateToDb()
	{
		$date = '12/10/2019';
		$date2 = new \DateTime('2019-12-10');

		$kernel = static::createKernel();
 		$kernel->boot();
 
 		$container = $kernel->getContainer();
 
 		$service = $container->get('project4_oc_booking.formatdate');

 		$result = $service->formatDateToDb($date);

 		$this->assertEquals($date2, $result);
	}

	public function testFormatVisitDayDateToDb()
	{
		$date = '12/10/2019';
		$booking = new booking();
		$visitDay = new visitDay();
		$booking->setvisitDay($visitDay);
		$booking->getVisitDay()->setDate($date);
		$date2 = new \DateTime('2019-12-10');

		$kernel = static::createKernel();
 		$kernel->boot();
 
 		$container = $kernel->getContainer();
 
 		$service = $container->get('project4_oc_booking.formatdate');

 		$result = $service->formatVisitDayDateToDb($booking);

 		$this->assertEquals($date2, $result);
	}
}