<?php
class populationGrowth extends battle
{
/*
*
*
*	Population Growth -- Should it be a math function?
*
*/
	function selectOwnedSystems()
	{
		$sql = "SELECT 
				sid,
				currentOwner as CO, 
				population as pop FROM map WHERE currentOwner <> 0 AND habitablePlanets > 0";
		$que = $this->db->prepare($sql);
		try{ 
			$que->execute(); 
				while($row = $que->fetch(PDO::FETCH_ASSOC))
				{
					echo $row['sid']."\n";
					$this->growPopulation($row['sid'], $row['CO'], $row['pop']);  
				}
			}catch(PDOException $e) { echo $e->getMessage(); } 	
	}
	function growPopulation($sid, $owner, $pop)
	{	
		$popB = $pop;
		$k = 20;
		$r = 100;
		$infect = mt_rand(0,10);
		$rand = mt_rand(0,3);
		$x = pow($k/$r, 2);
		$i = mt_rand(1,10);
		//* This Really Needs to be Improved, I can't figure out how to convert the math to PHP math
		$pop = $pop+mt_rand(-20,33);
		$pop = $pop > 0 ? $pop : 0; 
		$this->updatePop($sid, $pop);
	}
	function updatePop($sid, $pop)
	{
		echo $sid."\n";
		$sql = "UPDATE map SET population = {$pop} WHERE sid = {$sid}";
		try { $this->db->exec($sql); } catch(PDOException $e) { echo $e->getMessage(); } 	
	}
		
}