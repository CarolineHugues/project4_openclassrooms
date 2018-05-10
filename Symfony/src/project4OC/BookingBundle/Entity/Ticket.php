<?php

namespace project4OC\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="project4OC\BookingBundle\Repository\TicketRepository")
 */
class Ticket extends Entity
{
	/**
	 * @ORM\ManyToOne(targetEntity="project4OC\BookingBundle\Entity\Booking")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $booking;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="date")
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var bool
     *
     * @ORM\Column(name="reducedRate", type="boolean")
     */
    private $reducedRate;

    public function __construct()
    {
        $this->reducedRate = false;
    }
    

    public function setBooking (Booking $booking)
    {
    	$this->booking = $booking;

    	return $this;
    }

    public function getBooking()
    {
    	return $this->booking;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Ticket
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Ticket
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Ticket
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Ticket
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set reducedRate
     *
     * @param boolean $reducedRate
     *
     * @return Ticket
     */
    public function setReducedRate($reducedRate)
    {
        $this->reducedRate = $reducedRate;

        return $this;
    }

    /**
     * Get reducedRate
     *
     * @return bool
     */
    public function getReducedRate()
    {
        return $this->reducedRate;
    }
}

