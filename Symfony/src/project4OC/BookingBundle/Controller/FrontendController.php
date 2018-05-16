<?php

// src/project4OC/BookingBundle/Controller/FrontendController.php

namespace project4OC\BookingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use project4OC\BookingBundle\Entity\Ticket;
use project4OC\BookingBundle\Entity\Booking;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use project4OC\BookingBundle\Form\TicketType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FrontendController extends Controller 
{
	public function indexAction()
	{
    $booking = new Booking();

    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $booking);

    $formBuilder 
      ->add('ticketType',      RadioType::class)
      ->add('mail',            EmailType::class)
      ->add('numberOfTickets', IntegerType::class)
      ->add('tickets',         CollectionType::class, array(
        'entry_type'   =>      TicketType::class,
        'allow_add'    => true,
        'allow_delete' => true
      ))
      ->add('save',            SubmitType::class);
    ;

    $form = $formBuilder->getForm();

		return $this->render('project4OCBookingBundle:Frontend:index.html.twig', array('page_title' => 'Réservation en ligne', 'form' => $form->createView(),));
	}
}