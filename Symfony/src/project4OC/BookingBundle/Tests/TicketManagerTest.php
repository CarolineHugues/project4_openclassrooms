<?php

namespace project4OC\BookingBundle\Tests;

use project4OC\BookingBundle\Entity\Ticket;
use project4OC\BookingBundle\Entity\TicketManager;
use PHPUnit\Framework\TestCase;

class TicketManagerTest extends TestCase
{
	public function testPriceCorrespondsAge()
	{
		$ticketManager = new TicketManager();

        $this->assertSame(16, $ticketManager->computePrice('9/10/1991', false));
	}

	public function testPriceAppliesRaducedRate()
	{
		$ticketManager = new TicketManager();

        $this->assertSame(10, $ticketManager->computePrice('9/10/1991', true));
	}

	public function testDisplayMessageNullOrNegativeAge()
	{
		$ticketManager = new TicketManager();

        $this->expectException('LogicException');

        $ticketManager->computePrice('25/05/2030', false);
	}

}