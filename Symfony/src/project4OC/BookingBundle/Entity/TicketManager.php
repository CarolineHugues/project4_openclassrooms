<?php 

namespace project4OC\BookingBundle\Entity;

class TicketManager
{
	public function computeAge($birthDate)
	{
		$birthD = explode('/', $birthDate);
		$todaysDate = explode('/', date('d/m/Y'));

		if(($birthD[1] < $todaysDate[1]) OR (($birthD[1] == $todaysDate[1]) AND ($birthD[0] <= $todaysDate[0])))
		{
			$age = $todaysDate[2] - $birthD[2];
		}
		else
		{
			$age = $todaysDate[2] - $birthD[2] - 1;
		}

		return $age;
	}

	public function computePrice($birthDate, $reducedRate)
	{
		$computedAge = SELF::computeAge($birthDate);

		if ($reducedRate == true)
		{
			$price = 10;
		}
		else
		{
			if($computedAge >= 60)
			{
				$price = 12;
			}
			else if($computedAge >= 12)
			{
				$price = 16;
			}
			else if($computedAge >= 4)
			{
				$price = 8;
			}
			else if($computedAge > 0 AND $computedAge < 4)
			{
				$price = 0;
			}
			else if($computedAge <= 0)
			{
				throw new \LogicException('L\'âge ne peut pas être négatif ou nul.');
			}
		}
		
		return $price;
	}
}