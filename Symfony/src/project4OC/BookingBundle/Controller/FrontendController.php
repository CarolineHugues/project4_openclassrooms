<?php

// src/project4OC/BookingBundle/Controller/FrontendController.php

namespace project4OC\BookingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FrontendController extends Controller 
{
	public function indexAction()
	{
		return $this->render('project4OCBookingBundle:Frontend:index.html.twig', array('page_title' => 'Réservation - Musée du Louvre'));
	}
}