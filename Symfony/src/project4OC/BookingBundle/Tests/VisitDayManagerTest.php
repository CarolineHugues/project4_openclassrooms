<?php

namespace project4OC\BookingBundle\Tests;

use project4OC\BookingBundle\Entity\VisitDay;
use project4OC\BookingBundle\Entity\VisitDayManager;
use PHPUnit\Framework\TestCase;

class VisitDayManagerTest extends TestCase
{
	public function testPreviousGaugeDifferentNewGauge()
	{
		/*...*/
		
		$this->assertSame(85, $visitDay->fillGauge(/*...*/));
	}

	public function testDayAvailableUntil1000Tickets()
	{
		$visitDay = new visitDay('5/09/2019', 999);

        $this->assertSame(true, $visitDay->available('5/09/2019', 999));
	}
}