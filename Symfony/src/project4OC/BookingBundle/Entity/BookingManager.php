<?php 

namespace project4OC\BookingBundle\Entity;

use project4OC\BookingBundle\Entity\TicketManager;

class BookingManager 
{
	public function computeNumberOfTickets(Booking $booking)
	{
		$numberOfTickets = 0;
		foreach($booking->getTickets() as $ticket)
    	{
      		$numberOfTickets++;
    	}

    	return $numberOfTickets;
    }

    public function individualOrGroupRate($numberOfWhishedTickets)
    {
		if ($numberOfWhishedTickets < 15)
		{
			return $numberOfWhishedTickets;
		}
		else
		{
			return $message = "Veuillez contacter l'équipe du musée pour réserver et avoir des renseignements à propos de notre tarif groupe.";
		}
	}

	public function notEnoughTickets($numberOfWhishedTickets, VisitDay $visitDay)
	{
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

	public function computeTotalPrice(Booking $booking)
	{
		$totalPrice = 0;
    	foreach($booking->getTickets() as $ticket)
    	{
    		$ticketManager = new ticketManager();
    		$birthDate = $ticket->getBirthDate();
    		$reducedRate = $ticket->getReducedRate();
      		$totalPrice += $ticketManager->computePrice($birthDate, $reducedRate);
    	}

    	return $totalPrice;
	}
}