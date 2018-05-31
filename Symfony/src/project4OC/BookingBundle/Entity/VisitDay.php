<?php

namespace project4OC\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;
use project4OC\BookingBundle\Entity\VisitDayManager;

/**
 * VisitDay
 *
 * @ORM\Table(name="visit_day")
 * @ORM\Entity(repositoryClass="project4OC\BookingBundle\Repository\VisitDayRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class VisitDay extends Entity
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", unique=true)
     * @Assert\Datetime()
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

    public function newGauge($numberReservedTickets)
    {
        $visitDayManager = new visitDayManager();
        $newGauge = $visitDayManager->fillGauge($this, $numberReservedTickets);
        SELF::setGauge($newGauge);
    }

    /**
    *
    *@ORM\PrePersist
    */
    public function formatDateToDb()
    {
        $date = $this->getDate();
        $formatDate = new \DateTime($date);
        $formatDate->format('yy-mm-dd');

        SELF::setDate($formatDate);
    }
}