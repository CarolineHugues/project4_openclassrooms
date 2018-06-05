<?php

namespace project4OC\BookingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="project4OC\BookingBundle\Repository\BookingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Booking extends Entity
{
	/**
	 * @ORM\OneToMany(targetEntity="project4OC\BookingBundle\Entity\Ticket", mappedBy="booking", cascade={"persist"})
	 */
	private $tickets;

	/**
	 * @ORM\ManyToOne(targetEntity="project4OC\BookingBundle\Entity\VisitDay", cascade={"persist"})
	 */
	private $visitDay;

    /**
     * @var string
     *
     * @ORM\Column(name="ticketType", type="string", length=255)
     * @Assert\NotNull()
     */
    private $ticketType;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     * @Assert\Email()
     */
    private $mail;

    /**
     * @var integer
     *
     * @ORM\Column(name="numberOfTickets", type="integer")
     * @Assert\Range(min=1)
     */
    private $numberOfTickets;

    /**
     * @var string
     *
     * @ORM\Column(name="bookingCode", type="string", length=255, unique=true)
     */
    private $bookingCode;


    public function __construct()
    {
    	$this->bookingCode = uniqid();
        $this->tickets = new ArrayCollection();
    }
    
    public function addTicket(Ticket $ticket)
    {
    	$this->tickets[] = $ticket;

    	$ticket->setBooking($this);

    	return $this;
    }

    public function removeTicket(Ticket $ticket)
    {
    	$this->tickets->removeElement($ticket);
    }

    public function getTickets()
    {
    	return $this->tickets;
    }

    public function setVisitDay (VisitDay $visitDay)
    {
    	$this->visitDay = $visitDay;

    	return $this;
    }

    public function getVisitDay()
    {
    	return $this->visitDay;
    }

    /**
     * Set ticketType
     *
     * @param string $ticketType
     *
     * @return Booking
     */
    public function setTicketType($ticketType)
    {
        $this->ticketType = $ticketType;

        return $this;
    }

    /**
     * Get ticketType
     *
     * @return string
     */
    public function getTicketType()
    {
        return $this->ticketType;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Booking
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set mail
     *
     * @param integer $numberOfTickets
     *
     * @return Booking
     */
    public function setNumberOfTickets($numberOfTickets)
    {
        $this->numberOfTickets = $numberOfTickets;

        return $this;
    }

    /**
     * Get numberOfTickets
     *
     * @return integer
     */
    public function getNumberOfTickets()
    {
        return $this->numberOfTickets;
    }

    /**
     * Set bookingCode
     *
     * @param string $bookingCode
     *
     * @return Booking
     */
    public function setBookingCode($bookingCode)
    {
        $this->bookingCode = $bookingCode;

        return $this;
    }

    /**
     * Get bookingCode
     *
     * @return string
     */
    public function getBookingCode()
    {
        return $this->bookingCode;
    }

    /**
    *
    *@ORM\PrePersist
    */
    public function fillNewGauge()
    {
        $numberReservedTickets = $this->getNumberOfTickets();
        $this->getVisitDay()->fillGauge($numberReservedTickets);
    }
}