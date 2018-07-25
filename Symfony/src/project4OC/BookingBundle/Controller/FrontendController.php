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
use project4OC\BookingBundle\Entity\Parameter;
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

    	$gauge = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('gauge')->getValue();
       	$adultRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('adultRate')->getValue();
       	$babyRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('babyRate')->getValue();
       	$childRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('childRate')->getValue();
       	$reducedPrice = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('reducedRate')->getValue();
       	$seniorRate = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('seniorRate')->getValue();

    	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) 
    	{
			$formatDate = $this->container->get('project4_oc_booking.formatdate');
			$date =  $formatDate->formatVisitDayDateToDb($booking);

			$visitDay = $em->getRepository('project4OCBookingBundle:VisitDay')->findOneByDate($date);

			$verifyAvailableDate = $this->container->get('project4_oc_booking.verifyavailabledate');

			if ($verifyAvailableDate->verifyAvailableSelectedDate($date, $visitDay, $booking, $gauge) == 'availableDate')
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
					$em->persist($booking);
					$em->flush();
			      	$em->detach($booking);
					$session = $request->getSession();
					$session->set('booking', $booking);
					$bookingManager = new BookingManager();
					$totalPrice = $bookingManager->computeTotalPrice($booking, $adultRate, $babyRate, $childRate, $reducedPrice, $seniorRate);

					return $this->render('project4OCBookingBundle:Frontend:purchase.html.twig', array('page_title' => 'Réservation en ligne', 'booking' => $booking,'totalPrice' => $totalPrice,));
				}
			}
			else
			{
				$message = $verifyAvailableDate->verifyAvailableSelectedDate($date, $visitDay, $booking);
				$buttonText = "Modifier sa réservation";
				return $this->render('project4OCBookingBundle:Frontend:errorspages.html.twig', array('page_title' => 'Réservation en ligne', 'message' => $message, 'buttonText' => $buttonText));
			}
       	}

		return $this->render('project4OCBookingBundle:Frontend:index.html.twig', array('page_title' => 'Réservation en ligne', 'form' => $form->createView(), 'gauge' => $gauge, 'adultRate' => $adultRate, 'babyRate' => $babyRate, 'childRate' => $childRate, 'reducedRate' => $reducedPrice, 'seniorRate' => $seniorRate,));	
	}

	/**
     * @Rest\Get("/visitDays")
     */
	public function getListVisitDayAction()
	{
		$em = $this->getDoctrine()->getManager();
		$gauge = $em->getRepository('project4OCBookingBundle:Parameter')->findOneByName('gauge')->getValue();
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
		$token = $_POST['stripeToken'];

		$stripe = $this->container->get('project4_oc_booking.stripe');

		$charge = $stripe->chargeStripe($request, $token);

		$status = $stripe->getChargeStatus($charge);

		if ($status == "succeeded")
		{
			$session = $request->getSession();
			$booking = $session->get('booking');

			$em = $this->getDoctrine()->getManager();
			$booking = $em->merge($booking);

			$booking->setStatus('Paiement effectué');

			$date =  $booking->getVisitDay();
			$visitDay = $em->getRepository('project4OCBookingBundle:VisitDay')->find($date);
			$booking->setVisitDay($visitDay);
			$booking->fillNewGauge();
			
			$em->persist($booking);
			$em->flush();

			$bookingManager = new BookingManager();
			$totalPrice = $bookingManager->computeTotalPrice($booking);

			$message = \Swift_Message::newInstance()
		  		->setFrom('contact@hc-projet1.ovh')
		  		->setTo($booking->getMail())
		  		->setSubject('Test - projet 4')
		  		->setBody($this->container->get('templating')->render('project4OCBookingBundle:Email:tickets.html.twig', array('page_title' => 'Votre réservation au Musée du Louvre', 'booking' => $booking, 'totalPrice' => $totalPrice,)), 'text/html')
			;
	                  
	        $this->get('mailer')->send($message);

	    	return $this->render('project4OCBookingBundle:Frontend:confirmation.html.twig', array('page_title' => 'Réservation en ligne',));
	    }
	    else
	    {
	    	$message = "Le paiement a échoué, votre réservation n'a pas pu être prise en compte.";
	    	$buttonText = "Renouveler le paiement";
	    	return $this->render('project4OCBookingBundle:Frontend:errorspages.html.twig', array('page_title' => 'Réservation en ligne', 'message' => $message, 'buttonText' => $buttonText));
	    }	
	}
}