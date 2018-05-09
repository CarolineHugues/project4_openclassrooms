<?php 

namespace project4OC\BookingBundle\Entity;

class BookingManager 
{
	public function computeNumberOfTickets()
	{
		/*Compter le nombre de billets*/

		if ($numberOfTickets < 15)
		{
			return $numberOfTickets;
		}
		else
		{
			echo "Veuillez contacter l'équipe du musée pour réserver et avoir des renseignements à propos de notre tarif groupe.";
		}
	}

	public function computeTotalPrice()
	{

	}
}