<?php

namespace project4OC\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VisitDay
 *
 * @ORM\Table(name="visit_day")
 * @ORM\Entity(repositoryClass="project4OC\BookingBundle\Repository\VisitDayRepository")
 */
class VisitDay
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

