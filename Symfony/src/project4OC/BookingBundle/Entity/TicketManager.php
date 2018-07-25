<?php 

namespace project4OC\BookingBundle\Entity;

class TicketManager
{
	public function computeAge($birthDate)
	{
		$birthDateText = $birthDate->format('d/m/Y');
		$birthD = explode('/', $birthDateText);
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

	public function computePrice($birthDate, $reducedRate, $adultRate, $babyRate, $childRate, $reducedPrice, $seniorRate)
	{
		$computedAge = SELF::computeAge($birthDate);

		if ($reducedRate == true)
		{
			$price = $reducedPrice;
		}
		else
		{
			if($computedAge >= 60)
			{
				$price = $seniorRate;
			}
			else if($computedAge >= 12)
			{
				$price = $adultRate;
			}
			else if($computedAge >= 4)
			{
				$price = $childRate;
			}
			else if($computedAge > 0 AND $computedAge < 4)
			{
				$price = $babyRate;
			}
			else if($computedAge <= 0)
			{
				throw new \LogicException('L\'âge ne peut pas être négatif ou nul.');
			}
		}

		return $price;
	}
}