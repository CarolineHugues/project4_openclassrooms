<?php

namespace project4OC\BookingBundle\Tests\ManagersTests;

use project4OC\BookingBundle\Entity\Ticket;
use project4OC\BookingBundle\Entity\TicketManager;
use PHPUnit\Framework\TestCase;

class TicketManagerTest extends TestCase
{
	public function testPriceCorrespondsAge()
	{
		$ticketManager = new TicketManager();
		$birthDay = new \DateTime('9/10/1991');

        $this->assertSame(16, $ticketManager->computePrice($birthDay, false));
	}

	public function testPriceAppliesRaducedRate()
	{
		$ticketManager = new TicketManager();
		$birthDay = new \DateTime('9/10/1991');

        $this->assertSame(10, $ticketManager->computePrice($birthDay, true));
	}

	public function testDisplayMessageNullOrNegativeAge()
	{
		$ticketManager = new TicketManager();
		$birthDay = new \DateTime('2/01/2030');

        $this->expectException('LogicException');

        $ticketManager->computePrice($birthDay, false);
	}
}