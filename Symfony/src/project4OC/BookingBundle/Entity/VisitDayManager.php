<?php 

namespace project4OC\BookingBundle\Entity;

class VisitDayManager
{
	public function fillGauge(/**/)
	{
		if ($visitDay->available())
		{
			$newGauge = $visitDay->gauge() + /* Nombre de tickets réservés à la présédente réservation*/;
		}
		else 
		{
			throw new RuntimeException('La date doit être valide pour être réservée.');
		}
	}

	public function available($date, $gauge)
	{
		$selectedDate = explode('/', $date);
		$currentTime = explode('/', date('i/h'));

		if ($date < date('d/m/Y') OR $gauge == 1000 OR $selectedDate[0] == "mardi" OR ($selectedDate[0] == 1 AND $selectedDate[1] == 05) OR ($selectedDate[0] == 1 AND $selectedDate[1] ==  11) OR ($selectedDate[0] == 25 AND $selectedDate[0] == 12) OR $currentDate[1] > 18)
		{
			return $availableDate = false;
		}
		else
		{
			return $availableDate = true;
		}
	}

	public function availableAllDay($date)
	{
		$currentTime = explode('/', date('i/h'));

		if ($date == date('d/m/Y') AND $currentTime[1] > 12)
		{
			return $availableAllDay = false;
		}
		else
		{
			return $availableAllDay = true;
		}
	}
}