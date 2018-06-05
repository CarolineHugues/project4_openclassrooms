<?php

// src/project4OC/BookingBundle/VerifyAvailableDate/P4OCVerifyAvailableDate.php

namespace project4OC\BookingBundle\VerifyAvailableDate;

use project4OC\BookingBundle\Entity\VisitDay;
use project4OC\BookingBundle\Entity\Booking;

class P4OCVerifyAvailableDate
{
   public function available($visitDay)
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

	public function availableAllDay($visitDay)
	{
		$selectedDate = $visitDay->getDate();
		$selectedDateText = $selectedDate->format('d/m/y');
		$currentTime = explode('/', date('i/h'));

		if ($selectedDateText == date('d/m/Y') AND $currentTime[1] > 12)
		{
			return $availableAllDay = false;
		}
		else
		{
			return $availableAllDay = true;
		}
	}

	public function notEnoughTickets($visitDay, Booking $booking)
	{
		$numberOfWhishedTickets = $booking->getNumberOfTickets();
		$gauge = $visitDay->getGauge();
		$numberAvailableTickets = (1000 - $gauge);
		if ($numberAvailableTickets > $numberOfWhishedTickets)
		{
			return $gaugeAlmostReached = false;
		}
		else 
		{	if ($numberAvailableTickets <= 1)
			{
				return $message = "Il reste seulement " . $numberAvailableTickets . " ticket disponible à la date choisie.";
			}
			else
			{
				return $message = "Il reste seulement " . $numberAvailableTickets . " tickets disponibles à la date choisie.";
			}	
		}
	}

	public function individualOrGroupRate(Booking $booking)
    {
    	$numberOfWhishedTickets = $booking->getNumberOfTickets();
		if ($numberOfWhishedTickets < 15)
		{
			return $typeOfTickets = "individual";
		}
		else
		{
			return $typeOfTickets = "groupRate";
		}
	}
}