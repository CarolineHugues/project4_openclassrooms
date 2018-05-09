<?php

namespace project4OC\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VisitDay
 *
 * @ORM\Table(name="visit_day")
 * @ORM\Entity(repositoryClass="project4OC\BookingBundle\Repository\VisitDayRepository")
 */
class VisitDay extends Entity
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", unique=true)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="gauge", type="integer")
     */
    private $gauge;

    public function __construct()
    {
        $this->gauge = 0;
    }
    

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return VisitDay
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set gauge
     *
     * @param integer $gauge
     *
     * @return VisitDay
     */
    public function setGauge($gauge)
    {
        $this->gauge = $gauge;

        return $this;
    }

    /**
     * Get gauge
     *
     * @return int
     */
    public function getGauge()
    {
        return $this->gauge;
    }
}

