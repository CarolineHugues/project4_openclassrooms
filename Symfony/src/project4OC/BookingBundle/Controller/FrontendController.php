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

    	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) 
    	{
			$formatDate = $this->container->get('project4_oc_booking.formatdate');
			$date =  $formatDate->formatVisitDayDateToDb($booking);

			$em = $this->getDoctrine()->getManager();
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
					$em->persist($booking);
      				$em->flush();

      				$request->getSession()->getFlashBag()->add('notice', 'Réservation bien enregistrée.');

      				/*return $this->render('project4OCBookingBundle:Frontend:index.html.twig', array('page_title' => 'Réservation en ligne', 'form' => $form->createView(),));*/
					return new Response("La réservation est bien enregistrée !");	
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
}