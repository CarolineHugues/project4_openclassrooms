<?php

// src/project4OC/BookingBundle/Controller/FrontendController.php

namespace project4OC\BookingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use project4OC\BookingBundle\Entity\Booking;

use project4OC\BookingBundle\Form\BookingType;

class FrontendController extends Controller 
{
	public function indexAction()
	{
    	$booking = new Booking();

    	$form = $this->get('form.factory')->create(BookingType::class, $booking);

    	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) 
    	{
			$formatDate = $this->container->get('project4_oc_booking.formatdate');
			$date =  $formatDate->formatVisitDayDateToDb($booking);

			$em = $this->getDoctrine()->getManager();
			$visitDay = $em->getRepository('project4OCBookingBundle:VisitDay')->findOneByDate($date);

			$verifyAvailableDate = $this->container->get('project4_oc_booking.verifyavailabledate');
			if ($verifyAvailableDate->available($visitDay) == true && $verifyAvailableDate->availableAllDay($visitDay) == true && $verifyAvailableDate->notEnoughTickets($visitDay, $booking) == false && $verifyAvailableDate->individualOrGroupRate($booking))
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
				}
       		}
       	}

		return $this->render('project4OCBookingBundle:Frontend:index.html.twig', array('page_title' => 'Réservation en ligne', 'form' => $form->createView(),));
	}
}