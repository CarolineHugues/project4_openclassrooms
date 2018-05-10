<?php

namespace project4OC\BookingBundle\Tests;

use project4OC\BookingBundle\Entity\Booking;
use project4OC\BookingBundle\Entity\BookingManager;
use project4OC\BookingBundle\Entity\Ticket;
use PHPUnit\Framework\TestCase;

class BookingManagerTest extends TestCase
{
	public function testComputeNumberOfTickets()
	{
		$ticket1 = new Ticket();
		$ticket2 = new Ticket();
		$ticket3 = new Ticket();
		$ticket4 = new Ticket();
		$booking1 = new Booking();
		$booking1->addTicket($ticket1);
		$booking1->addTicket($ticket2); 
		$booking1->addTicket($ticket3);
		$booking1->addTicket($ticket4);

		$bookingManager = new BookingManager();

		$this->assertSame(4, $bookingManager->computeNumberOfTickets($booking1));
	}

	public function testEachTicketHisRate()
	{
		$ticket1 = new Ticket();
		$ticket1->setBirthDate('5/08/2010');
		$ticket2 = new Ticket();
		$ticket2->setBirthDate('3/01/1935');

		$booking1 = new Booking ();
		$booking1->addTicket($ticket1);
		$booking1->addTicket($ticket2);

		$bookingManager = new BookingManager();

        $this->assertSame(20, $bookingManager->computeTotalPrice($booking1));
	}

	public function testHalfdayRate()
	{
		$ticket1 = new Ticket();
		$ticket1->setBirthDate('3/01/1935');

		$booking1 = new Booking ();
		$booking1->addTicket($ticket1);
		$booking1->setTicketType('half-day');

		$bookingManager = new BookingManager();

        $this->assertSame(12, $bookingManager->computeTotalPrice($booking1));
	}

	public function testDisplayGroupRateMessage()
	{
		$bookingManager = new BookingManager();

		$this->assertSame("Veuillez contacter l'équipe du musée pour réserver et avoir des renseignements à propos de notre tarif groupe.", $bookingManager->individualOrGroupRate(16));
	}
}