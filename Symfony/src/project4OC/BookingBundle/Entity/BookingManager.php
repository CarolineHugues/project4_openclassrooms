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
	
	public function computeTotalPrice(Booking $booking, $adultRate, $babyRate, $childRate, $reducedPrice, $seniorRate)
	{
		$totalPrice = 0;
    	foreach($booking->getTickets() as $ticket)
    	{
    		$ticketManager = new ticketManager();
    		$birthDate = $ticket->getBirthDate();
    		$reducedRate = $ticket->getReducedRate();
      		$totalPrice += $ticketManager->computePrice($birthDate, $reducedRate, $adultRate, $babyRate, $childRate, $reducedPrice, $seniorRate);
    	}

    	return $totalPrice;
	}
}