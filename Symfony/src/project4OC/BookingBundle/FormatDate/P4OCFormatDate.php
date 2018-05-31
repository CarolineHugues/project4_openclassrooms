<?php

// src/project4OC/BookingBundle/FormatDate/P4OCFormatDate.php

namespace project4OC\BookingBundle\FormatDate;

class P4OCFormatDate
{
    public function formatDateToDb($date)
    {
        $formatDate = new \DateTime($date);
        $formatDate->format('yy-mm-dd');

        return $formatDate;
    }
}