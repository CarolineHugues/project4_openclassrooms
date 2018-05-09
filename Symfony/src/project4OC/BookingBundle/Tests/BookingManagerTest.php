<?php

namespace project4OC\BookingBundle\Tests;

use project4OC\BookingBundle\Entity\Booking;
use project4OC\BookingBundle\Entity\BookingManager;
use project4OC\BookingBundle\Entity\Ticket;
use PHPUnit\Framework\TestCase;

class BookingManagerTest extends TestCase
{
	public function testEachTicketHisRate()
	{
		$ticket1 = new Ticket('Julie', 'Henri', '5/08/2010', 'France', false);
		$ticket2 = new Ticket('Hugo', 'Marc', '3/01/1935', 'Italie', false);

		$booking = new Booking ('5/09/2019', 'day', 'contact@project.fr', '0200203LP');

        $this->assertSame(20, $booking->computeTotalPrice());
	}

	public function testHalfdayRate()
	{
		$ticket2 = new Ticket('Hugo', 'Marc', '3/01/1935', 'Italie', false);

		$booking = new Booking ('12/11/2019', 'half-day', 'contact@project2.fr', '050308MM');

        $this->assertSame(12, $booking->computeTotalPrice());
	}

	public function testDisplayGroupRateMessage()
	{
		/*16 tickets achetés à la fois*/

		$booking = new Booking ('02/02/2020', 'day', 'contact@project3.fr', '09080706NN');

		$this->assertSame("Veuillez contacter l'équipe du musée pour réserver et avoir des renseignements à propos de notre tarif groupe.", $booking->computeNumberOfTickets());
	}
}