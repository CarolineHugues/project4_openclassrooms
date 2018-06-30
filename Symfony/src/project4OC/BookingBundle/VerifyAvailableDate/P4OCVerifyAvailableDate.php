<?php

// src/project4OC/BookingBundle/VerifyAvailableDate/P4OCVerifyAvailableDate.php

namespace project4OC\BookingBundle\VerifyAvailableDate;

use project4OC\BookingBundle\Entity\VisitDay;
use project4OC\BookingBundle\Entity\Booking;

class P4OCVerifyAvailableDate
{
	public function verifyAvailableSelectedDate($date, $visitDay, Booking $booking)
	{
		if (SELF::available($visitDay) == true)
		{	
			if(SELF::availableAllDay($date) == true)
			{
				if (SELF::notEnoughTickets($visitDay, $booking) === false)
				{
					if(SELF::individualOrGroupRate($booking) == "individual")
					{
						return $message = 'availableDate';
					}
					else
					{
						return $message = SELF::individualOrGroupRate($booking);
					}
				}
				else
				{
					return $message = SELF::notEnoughTickets($visitDay, $booking);
				}
			}
			else
			{
				return $message = SELF::availableAllDay($date);
			}
		}
		else
		{
			return $message = SELf::available($visitDay);
		}
	}

   public function available($visitDay)
	{
		if ($visitDay != null)
		{
			$date = $visitDay->getDate();
			$dateText = $date->format('w/d/m/Y');
			$gauge = $visitDay->getGauge();
			$selectedDate = explode('/', $dateText);
			$currentTime = explode('/', date('i/h'));
			$currentDate = explode ('/', date('w/d/m/Y'));

			if ($selectedDate[3] < $currentDate[3] OR (($selectedDate[3] == $currentDate[3]) AND  ($selectedDate[2] < $currentDate[2])) OR (($selectedDate[3] == $currentDate[3]) AND  ($selectedDate[2] == $currentDate[2]) AND ($selectedDate[1] < $currentDate[1])) OR $gauge >= 1000 OR $selectedDate[0] == 2 OR ($selectedDate[1] == 1 AND $selectedDate[2] == 05) OR ($selectedDate[1] == 1 AND $selectedDate[2] ==  11) OR ($selectedDate[1] == 25 AND $selectedDate[2] == 12) OR ($selectedDate == date('w/d/m/Y') AND $currentTime[1] > 18))
			{
				return $message = 'Cette date n\'est pas disponible à la réservation';
			}
			else
			{
				return $availableDate = true;
			}
		}
		else 
		{
			return $availableDate = true;
		}
	}

	public function availableAllDay($date)
	{
		$selectedDate = $date;
		$selectedDateText = $selectedDate->format('d/m/y');
		$currentTime = explode('/', date('i/h'));

		if ($selectedDateText == date('d/m/Y') AND $currentTime[1] > 14)
		{
			return $message = 'Il n\'est pas possible de réserver le billet "Journée" pour le jour même une fois 14 heures passées.';
		}
		else
		{
			return $availableAllDay = true;
		}
	}

	public function notEnoughTickets($visitDay, Booking $booking)
	{
		if ($visitDay != null)
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
					return $message = "Vous souhaitez réserver " . $numberOfWhishedTickets . " tickets cependant il reste seulement " . $numberAvailableTickets . " ticket disponible à la date choisie.";
				}
				else
				{
					return $message = "Vous souhaitez réserver " . $numberOfWhishedTickets . " tickets cependant il reste seulement " . $numberAvailableTickets . " tickets disponibles à la date choisie.";
				}	
			}
		}
		else
		{
			return $gaugeAlmostReached = false;	
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
			return $message = "Veuillez contacter l'équipe du musée du Louvre pour réserver au-delà de 14 personnes et/ou obtenir des informations sur le tarif groupe.";
		}
	}
}