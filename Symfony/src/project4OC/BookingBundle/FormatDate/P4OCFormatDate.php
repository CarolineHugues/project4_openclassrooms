<?php

// src/project4OC/BookingBundle/FormatDate/P4OCFormatDate.php

namespace project4OC\BookingBundle\FormatDate;

use project4OC\BookingBundle\Entity\Booking;

class P4OCFormatDate
{
    public function formatDateToDb($date)
    {
        $formatDate = new \DateTime($date);
        $formatDate->format('yy-mm-dd');

        return $formatDate;
    }

    public function formatVisitDayDateToDb(Booking $booking)
    {
    	$date = $booking->getVisitDay()->getDate();
        $formatDate = new \DateTime($date);
        $formatDate->format('yy-mm-dd');

        $booking->getVisitDay()->setDate($formatDate);

        return $booking->getVisitDay()->getDate();
    }
}