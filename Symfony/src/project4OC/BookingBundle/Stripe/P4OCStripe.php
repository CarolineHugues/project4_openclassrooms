<?php

// src/project4OC/BookingBundle/Stripe/P4OCStripe.php

namespace project4OC\BookingBundle\Stripe;

use project4OC\BookingBundle\Entity\BookingManager;

class P4OCStripe
{
	public function chargeStripe($request, $token)
	{
		\Stripe\Stripe::setApiKey("sk_test_SkklxJXLce11qiJtfABTlWar");

		$session = $request->getSession();
		$booking = $session->get('booking');
		$bookingManager = new BookingManager();
		$totalPrice = $bookingManager->computeTotalPrice($booking);
		$totalPriceCents = $totalPrice . '00';
		$customer = $booking->getMail();
		$nbOfTickets = $booking->getNumberOfTickets();
		$visitDay = $booking->getVisitDay()->getDate();
		$visitDayText = $visitDay->format('d/m/Y');

		$charge = \Stripe\Charge::create([
		    'amount' => $totalPriceCents,
		    'currency' => 'eur',
		    'receipt_email' => $customer,
		    'description' => 'Paiement de ' . $nbOfTickets . ' billet(s) pour le ' . $visitDayText . ' par ' . $customer,
		    'source' => $token,
		]);

		return $charge;
	}

	public function getChargeStatus($charge)
	{
		\Stripe\Stripe::setApiKey("sk_test_SkklxJXLce11qiJtfABTlWar");

		$id = \Stripe\Charge::retrieve("$charge->id");
		$status = $id->status;

		return $status;
	}
}