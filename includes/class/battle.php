<?php
class battle extends feats
{
	function diceRoll($u1, $u2, $sid)
	{
		$sDef = $this->chance($u1,$u2,$sid);
		$actual = mt_rand(0,100);
		if($sDef >= 100)
		{
			return 	'true';
		}
		else
		{
			if($sDef < $actual)
			{
				return 'false';
			}
			if($sDef == $actual)
			{
				if($this->killPopulation($sid))
				{
				return 'stalemate';
				}
			}
			else
			{
				return 'true';
			}
		}
			
	}
	function battleReturns()
	{
		return mt_rand(1,5);
	}
	function killPopulation($sid)
	{
		$returns = $this->battleReturns();
		$sql = "UPDATE map SET population = population/".$returns." WHERE sid = :sid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':sid', $sid);
		try { if($que->execute()) { return true; } } catch(PDOException $e) { echo $e->getMessage(); } 	
	}
	function chance($u1, $u2, $sid)
	{
		/* 
			This function eeds to be tweaked ever so slightly so that it's literally 
			a percentage instead of a faux percentage. It also needs to include the "Luck" meter and
			eventually incorporate the size of a users fleet. which that is still coming.
		*/
		$star = $this->getSUpgrades($sid);
		$u2t = $u2 > 0 ? $this->getSpecificUpgrade('technology', $u2) : 6;
		$u1t = $u1 > 0 ? $this->getSpecificUpgrade('technology', $u1) : 6;
		$u2d = $u2 > 0 ? $this->getSpecificUpgrade('defense', $u2) : 4;
		$u1o = $u1 > 0 ? $this->getSpecificUpgrade('offense', $u1) : 4;	
		$u2 = ($u2d*$u2t);
		$u1 = ($u1o*$u1t);
		if($u2 <=0 )
		{
			$u2 = 1;
		}
		else
		{
			$u2 = $u2;
		}
		if($u1 <= 0)
		{
			$u1 = 1;
		}
		else
		{
			$u1 = $u1;
		}
		$sDef = ($u1/$u2)*100;
		return $sDef;
		
	}
}

?>