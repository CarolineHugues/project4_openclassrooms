<?php

namespace project4OC\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Entity
{
	/**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}