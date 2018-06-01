<?php 

namespace project4OC\BookingBundle\Entity;

class VisitDayManager
{
	public function fillGauge(VisitDay $visitDay, $numberReservedTickets)
	{
		if (SELF::available($visitDay) == true)
		{
			$newGauge = $visitDay->getGauge() + $numberReservedTickets;

			return $newGauge;
		}
		else 
		{
			throw new RuntimeException('La date doit être valide pour être réservée.');
		}
	}

	public function available(VisitDay $visitDay)
	{
		$date = $visitDay->getDate();
		$dateText = $date->format('w/d/m/y');
		$gauge = $visitDay->getGauge();
		$selectedDate = explode('/', $dateText);
		$currentTime = explode('/', date('i/h'));

		if ($date < date('w/d/m/Y') OR $gauge >= 1000 OR $selectedDate[0] == 2 OR ($selectedDate[1] == 1 AND $selectedDate[2] == 05) OR ($selectedDate[1] == 1 AND $selectedDate[2] ==  11) OR ($selectedDate[1] == 25 AND $selectedDate[2] == 12) OR ($selectedDate == date('w/d/m/Y') AND $currentTime[1] > 18))
		{
			return $availableDate = false;
		}
		else
		{
			return $availableDate = true;
		}
	}

	public function availableAllDay($selectedDate)
	{
		$currentTime = explode('/', date('i/h'));

		if ($selectedDate == date('d/m/Y') AND $currentTime[1] > 12)
		{
			return $availableAllDay = false;
		}
		else
		{
			return $availableAllDay = true;
		}
	}
}