<?php

namespace project4OC\BookingBundle\Tests\ManagersTests;

use project4OC\BookingBundle\Entity\Ticket;
use project4OC\BookingBundle\Entity\TicketManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketManagerTest extends WebTestCase
{
	public function testPriceCorrespondsAge()
	{
		$ticketManager = new TicketManager();
		$birthDay = new \DateTime('9/10/1991');

		$kernel = static::createKernel();
 		$kernel->boot();
 		$container = $kernel->getContainer();
 		$em = $container->get('doctrine.orm.entity_manager');

    	$adultRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('adultRate')->getValue();
       	$babyRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('babyRate')->getValue();
       	$childRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('childRate')->getValue();
       	$reducedPrice = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('reducedRate')->getValue();
       	$seniorRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('seniorRate')->getValue();

        $this->assertSame(16, $ticketManager->computePrice($birthDay, false, $adultRate, $babyRate, $childRate, $reducedPrice, $seniorRate));
	}

	public function testPriceAppliesRaducedRate()
	{
		$ticketManager = new TicketManager();
		$birthDay = new \DateTime('9/10/1991');

		$kernel = static::createKernel();
 		$kernel->boot();
 		$container = $kernel->getContainer();
 		$em = $container->get('doctrine.orm.entity_manager');

    	$adultRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('adultRate')->getValue();
       	$babyRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('babyRate')->getValue();
       	$childRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('childRate')->getValue();
       	$reducedPrice = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('reducedRate')->getValue();
       	$seniorRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('seniorRate')->getValue();

        $this->assertSame(10, $ticketManager->computePrice($birthDay, true, $adultRate, $babyRate, $childRate, $reducedPrice, $seniorRate));
	}

	public function testDisplayMessageNullOrNegativeAge()
	{
		$ticketManager = new TicketManager();
		$birthDay = new \DateTime('2/01/2030');

		$kernel = static::createKernel();
 		$kernel->boot();
 		$container = $kernel->getContainer();
 		$em = $container->get('doctrine.orm.entity_manager');

    	$adultRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('adultRate')->getValue();
       	$babyRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('babyRate')->getValue();
       	$childRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('childRate')->getValue();
       	$reducedPrice = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('reducedRate')->getValue();
       	$seniorRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('seniorRate')->getValue();

        $this->expectException('LogicException');

        $ticketManager->computePrice($birthDay, false, $adultRate, $babyRate, $childRate, $reducedPrice, $seniorRate);
	}
}