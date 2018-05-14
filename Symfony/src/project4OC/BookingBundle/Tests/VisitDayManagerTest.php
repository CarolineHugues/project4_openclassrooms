<?php

namespace project4OC\BookingBundle\Tests;

use project4OC\BookingBundle\Entity\VisitDay;
use project4OC\BookingBundle\Entity\VisitDayManager;
use project4OC\BookingBundle\Entity\Ticket;
use project4OC\BookingBundle\Entity\Booking;
use project4OC\BookingBundle\Entity\BookingManager;
use PHPUnit\Framework\TestCase;

class VisitDayManagerTest extends TestCase
{
	public function testPreviousGaugeDifferentNewGauge()
	{
		$ticket1 = new Ticket();
		$ticket2 = new Ticket();
		$booking1 = new Booking();
		$booking1->addTicket($ticket1);
		$booking1->addTicket($ticket2);

		$bookingManager = new BookingManager(); 
		$numberReservedTickets = $bookingManager->computeNumberOfTickets($booking1);

		$visitDayManager = new visitDayManager(); 
		
		$visitDay1 = new VisitDay();
		$visitDay1->setDate('5/07/2019');
		$visitDay1->setGauge(400);
		
		$this->assertSame(402, $visitDayManager->fillGauge($visitDay1, $numberReservedTickets));
	}

	public function testDayAvailableUntil1000Tickets()
	{
		$visitDayManager = new visitDayManager();

		$visitDay1 = new VisitDay();
		$visitDay1->setDate('5/09/2019');
		$visitDay1->setGauge(999);

        $this->assertSame(true, $visitDayManager->available($visitDay1));
	}

	public function testDayNoAvailableFullGauge()
	{
		$visitDayManager = new visitDayManager();

        $visitDay1 = new VisitDay();
		$visitDay1->setDate('5/09/2019');
		$visitDay1->setGauge(1000);

        $this->assertSame(false, $visitDayManager->available($visitDay1));
	}

	public function testDayNoAvailablePublicHoliday()
	{
		$visitDayManager = new visitDayManager();

		$visitDay1 = new VisitDay();
		$visitDay1->setDate('1/05/2020');
		$visitDay1->setGauge(200);

        $this->assertSame(false, $visitDayManager->available($visitDay1));
	}

	public function testAvailableAllDay()
	{
		$visitDayManager = new visitDayManager();

        $this->assertSame(true, $visitDayManager->availableAllDay('5/09/2019'));
	}

	public function testAvailableOnlyHalfDay()
	{
		$visitDayManager = new visitDayManager();

		$selectedDate = date("Y-m-d H:i:s");

		$currentTime = explode('/', date('i/h'));
		if ($currentTime[1] > 12)
		{
			return $result = false;
		}
		else
		{
			return $result = true;
		}

        $this->assertSame($result, $visitDayManager->availableAllDay($selectedDate));
	}
}