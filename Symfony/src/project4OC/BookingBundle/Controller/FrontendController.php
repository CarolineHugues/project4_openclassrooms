<?php

// src/project4OC/BookingBundle/Controller/FrontendController.php

namespace project4OC\BookingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;

use project4OC\BookingBundle\Entity\Booking;
use project4OC\BookingBundle\Entity\VisitDay;
use project4OC\BookingBundle\Entity\Ticket;
use project4OC\BookingBundle\Entity\VisitDayManager;
use project4OC\BookingBundle\Entity\BookingManager;

use project4OC\BookingBundle\Form\BookingType;

class FrontendController extends Controller 
{	
	public function indexAction(Request $request)
	{
		$booking = new Booking();

    	$form = $this->get('form.factory')->create(BookingType::class, $booking);

    	$em = $this->getDoctrine()->getManager();

    	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) 
    	{
			$formatDate = $this->container->get('project4_oc_booking.formatdate');
			$date =  $formatDate->formatVisitDayDateToDb($booking);

			$visitDay = $em->getRepository('project4OCBookingBundle:VisitDay')->findOneByDate($date);

			$verifyAvailableDate = $this->container->get('project4_oc_booking.verifyavailabledate');

			if ($verifyAvailableDate->available($visitDay) == true && $verifyAvailableDate->availableAllDay($date) == true && $verifyAvailableDate->notEnoughTickets($visitDay, $booking) == false && $verifyAvailableDate->individualOrGroupRate($booking))
			{
				if (null !== $visitDay)
				{
					$booking->setVisitDay($visitDay);
				}

    			$validator = $this->get('validator');
				$listErrors = $validator->validate($booking);
				if(count($listErrors) > 0) 
				{
					return new Response((string) $listErrors);
				} 
				else 
				{
      				$em->detach($booking);
					$session = $request->getSession();
					$session->set('booking', $booking);
					$bookingManager = new BookingManager();
					$totalPrice = $bookingManager->computeTotalPrice($booking);
					return $this->render('project4OCBookingBundle:Frontend:purchase.html.twig', array('page_title' => 'Réservation en ligne', 'booking' => $booking,'totalPrice' => $totalPrice));
				}
       		}
       		else
			{
				return new Response("Réservation impossible");	
			}
       	}

		return $this->render('project4OCBookingBundle:Frontend:index.html.twig', array('page_title' => 'Réservation en ligne', 'form' => $form->createView(),));	
	}

	/**
     * @Rest\Get("/visitDays")
     */
	public function getListVisitDayAction()
	{
		$em = $this->getDoctrine()->getManager();
		$gauge = 1000;
        $visitDays = $em->getRepository('project4OCBookingBundle:VisitDay')->findByGauge($gauge);

        $formatted = [];
        foreach ($visitDays as $visitDay) {
            $formatted[] = [
                'id' => $visitDay->getId(),
                'date' => $visitDay->getDate(),
                'gauge' => $visitDay->getGauge(),
            ];
        }

        return new JsonResponse($formatted);
	}


	public function confirmationAction(Request $request)
	{

		\Stripe\Stripe::setApiKey("sk_test_SkklxJXLce11qiJtfABTlWar");

		$token = $_POST['stripeToken'];

		$em = $this->getDoctrine()->getManager();
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

		$booking = $em->merge($booking);
		$em->persist($booking);
		$em->flush();
    	return $this->render('project4OCBookingBundle:Frontend:confirmation.html.twig', array('page_title' => 'Réservation en ligne',));	
	}
}