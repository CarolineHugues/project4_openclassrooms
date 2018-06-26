<?php

namespace project4OC\BookingBundle\Tests\ManagersTests;

use project4OC\BookingBundle\Entity\Booking;
use project4OC\BookingBundle\Entity\BookingManager;
use project4OC\BookingBundle\Entity\Ticket;
use project4OC\BookingBundle\Entity\VisitDay;
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
		$birthDate1 = new \DateTime('2010-08-05');
		$ticket1->setBirthDate($birthDate1);
		$ticket2 = new Ticket();
		$birthDate2 = new \DateTime('1935-01-03');
		$ticket2->setBirthDate($birthDate2);

		$booking1 = new Booking ();
		$booking1->addTicket($ticket1);
		$booking1->addTicket($ticket2);

		$bookingManager = new BookingManager();

        $this->assertSame(20, $bookingManager->computeTotalPrice($booking1));
	}

	public function testHalfdayRate()
	{
		$ticket1 = new Ticket();
		$birthDate1 = new \DateTime('1935-01-03');
		$ticket1->setBirthDate($birthDate1);

		$booking1 = new Booking ();
		$booking1->addTicket($ticket1);
		$booking1->setTicketType('halfday_ticketType');

		$bookingManager = new BookingManager();

        $this->assertSame(12, $bookingManager->computeTotalPrice($booking1));
	}
}