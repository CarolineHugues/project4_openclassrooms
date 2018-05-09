<?php

namespace project4OC\BookingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('project4OCBookingBundle:Default:index.html.twig');
    }
}
