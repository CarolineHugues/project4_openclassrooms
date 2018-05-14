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
			return $message "Veuillez contacter l'équipe du musée pour réserver et avoir des renseignements à propos de notre tarif groupe.";
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