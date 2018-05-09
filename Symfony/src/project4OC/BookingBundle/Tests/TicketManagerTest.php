<?php

namespace project4OC\BookingBundle\Tests;

use project4OC\BookingBundle\Entity\Ticket;
use project4OC\BookingBundle\Entity\TicketManager;
use PHPUnit\Framework\TestCase;

class TicketManagerTest extends TestCase
{
	public function testPriceCorrespondsAge()
	{
		$ticket = new Ticket('Caroline', 'Hugues', '9/10/1991', 'France', false);

        $this->assertSame(16, $ticket->computePrice('9/10/1991', false));
	}

	public function testPriceAppliesRaducedRate()
	{
		$ticket = new Ticket('Rose', 'Maxime', '15/06/1989', 'France', true);

        $this->assertSame(10, $ticket->computePrice('9/10/1991', true));
	}

	public function testDisplayMessageNullOrNegativeAge()
	{
		$ticket = new Ticket('Caroline', 'Hugues', '25/05/2030', 'France', false);

        $this->expectException('LogicException');

        $ticket->computePrice('25/05/2030', false);
	}

}