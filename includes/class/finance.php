<?php
class finance extends upgrades
{
	function getUserBanks()
	{
		/*
			Retrieve user coffers for use elsewhere
		*/
		$sql = "SELECT balance, energyCell, fuelCell,exp FROM user_coffers WHERE uid = :uid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $this->uid);
		try { 
		
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row;
			}catch(PDOException $e) { echo $e->getMessage(); }	
	}
	function replenishBanks($type, $roam)
	{
		/* 
			Pretty sure this function is used in CMAC and other places to restore things the user gets from a planet. 
			Or possibly it's the sorta defunct 'buy resource' tab?
		*/
		$banks = $this->getUserBanks();
		$tech = $this->getSpecificUpgrade('technology', $this->uid);
		
		switch($type)
		{
			case 'fuel':
			$replenish = ((TECHLEV* 100)+1000)*2;
			$price = $this->canAfford(FUEL_COST) ? FUEL_COST : false;
			if(is_numeric($price))
			{
				
				$sql = "UPDATE user_coffers SET fuelCell = {$replenish} WHERE uid = :uid";			
			}
			else
			{
				return 'false';
			}
			break;
			case 'energy':
			$price = $this->canAfford(ENERGY_COST) ? ENERGY_COST : false;
			$replenish =( (TECHLEV* 50)+1000)*2;
			if(is_numeric($price))
			{
				$sql = "UPDATE user_coffers SET energyCell = {$replenish} WHERE uid = :uid";			
			}
			else
			{
				return 'false';
			}
			break;
		}
		if(isset($sql))
		{
			$price = $price*-1;
			$this->updateCoffers($price, $this->uid);
			$que = $this->db->prepare($sql);
			$que->bindParam(':uid', $this->uid);
			try { $que->execute(); }catch(PDOexception $e) { echo $e->getMessage(); } 
			return 'true';
		}
		else
		{
			return 'false';	
		}
	}
	function canAfford($price)
	{
		/*
			Can a user afford things
		*/
		$money = $this->getUserBanks();
		$money = $money['balance'];
		if($price <= $money)
		{
			return true;	
		}
		elseif($price == 0)
		{
			return true;	
		}
		else
		{
			return false;	
		}
	}
	function createCoffers()
	{
		/* Create user coffer, this is a registration function, right? */
			$sql2 = "
				INSERT INTO 
					user_coffers
					(
					`balance`, 
					`energyCell`, 
					`fuelCell`, 
					`uid`) 
					VALUES
					('10000','1000','1000', :id);";
					$id =$this->db->lastInsertId();
					$que = $this->db->prepare($sql2);
					$que->bindParam(':id', $id);	
				try { 
					if($que->execute())
					{
						return true;	
					}
					else
					{
						return false;	
					}
				} catch(PDOException $e) { die('Coffers Failure'.$e->getMessage());}
	}
	function updateCoffers($price, $uid)
	{
			/* Update user bank */
			$sql = "UPDATE user_coffers SET balance = balance+:balance WHERE uid = :uid";
			$que = $this->db->prepare($sql);
			$que->bindParam(':uid', $uid);
			$que->bindParam(':balance', $price);
			try { 
				if($que->execute()) 
					{ return true; } 
				else { return false;} 
				}catch(PDOException $e) { echo $e->getMessage(); }
	}
	function updateCoffersOld($price)
	{
			/* Update user bank */
			$sql = "UPDATE user_coffers SET balance = balance+:balance WHERE uid = :uid";
			$que = $this->db->prepare($sql);
			$que->bindParam(':uid', $this->uid);
			$que->bindParam(':balance', $price);
			try { 
				if($que->execute()) 
					{ return true; } 
				else { return false;} 
				}catch(PDOException $e) { echo $e->getMessage(); }
	}

	function mineSystem($id, $uid)
	{
		$sid = $this->sinfor($id);
		$rid = $sid['resource'];
		$money = $this->miningReturns($rid,$sid['habitablePlanets'], $sid['population'], $id);
		if($this->updateCoffers($money, $uid))
		{
			$date1 = new DateTime('NOW');
			$lm = $date1->format("Y-m-d H:i:s");
			$sql = "UPDATE map SET lastMine = :date WHERE sid = :sid";
			$que = $this->db->prepare($sql);
			$que->bindParam(':sid', $id);
			$que->bindParam(':date', $lm);
			try { 
			if($que->execute())
				{
						$ammount = mt_rand(1,3);
					if($this->updateUserInv($uid, $rid, $ammount) 
					&& $this->updateUserInv($uid, mt_rand(1,118), mt_rand(1,2)))
					{
					return true;
					}
				}
				else
				{
					
				}
			}catch(PDOException $e){ $e->getMessage(); }
		}
		else
		{
			return false;	
		}
		
	}
	function lastMineCheck($sid)
	{
		$sql = "SELECT lastMine FROM map WHERE sid = :sid";
		$que = $this->db->prepare($sql);
		$que->bindParam(":sid", $sid);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			$lmin = $row['lastMine'];
			}catch(PDOException $e){}
		$date1 = new DateTime($lmin);
		$date2 = new DateTime('NOW');
		$interval = $date1->diff($date2);
		$hour = $interval->h;
		return $hour > 0 ? $hour : 24;
	}
	function getResourceValue($rid)
	{
		$sql = "SELECT value FROM resources WHERE rid = :rid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':rid', $rid);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row['value'];
			} catch(PDOException $e) { echo $e->getMessage(); } 	
	}
	function miningReturnsOld($rid,$hab, $pop, $id)
	{
	/* 
		REtooling this so it's not just a random number;
	*/
		$fuelArray = array('186','182','179','165','157');
		/* Gather All the information for */
		$lm = $this->lastMineCheck($id);
		$value = $this->getResourceValue($rid);	
		$tech = $this->getSpecificUpgrade('technology', $this->uid);
		$eco = $this->getSpecificUpgrade('economy', $this->uid);
		$su = $this->getSUpgrades($id);
		$su = $su[0]; //* This array return needs to be fixed, but for now, let's do it this way
		//* Fuel Returns for Player *//
		$warehouse = $su['warehouse'] +1;
		$refin = $su['refineries'] +1;
		$fuelReturn = (($refin*25)+($rid/2))*-1;
		$this->depleteCells($fuelReturn,'fuel'); 
		if(mt_rand(1,34) == 2)
		{
			$fuelReturn = (($refin*25)+($rid/2))*-1;
			$this->depleteCells($fuelReturn,'energy'); 		
		}
		
		/* Do the Math for the actual returns */
		$money = ($warehouse+$tech)+(abs($value)+($refin/$eco));
		//die($money);
		return $money;
	}
	function miningReturns($rid,$hab, $pop, $id)
	{
	/* 
		REtooling this so it's not just a random number;
	*/
		//$warehouse = $su['warehouse'] +1;
		//$refin = $su['refineries'] +1;
		/* Do the Math for the actual returns */
		$rid = $this->resourceValue($rid);
		$rid = $rid*33.975999;
		$pop = 0;
		$tech = $this->getSpecificUpgrade('technology', $this->uid);
		$tech = ($tech+($tech/1.75)*2);
		$eco = $this->getSpecificUpgrade('economy', $this->uid);
		$eco = $eco+($tech);
		$su = $this->getSUpgrades($id);
		$su = $su[0]; //* This array return needs to be fixed, but for now, let's do it this way
		$wh = $su['warehouse'] +1;
		$refin = $su['refineries'] +1;
		//* Prevent people from "Goding out"
		$tech = $tech >= 50 ? $tech/2 : $tech;
		//* Current Idea for Mining Returns: 
		$money = floor(((($rid)+($tech+$refin)*(($wh+($eco/2)))+1)-($hab/($pop+1000)))/1.999);
		//die($money);
		return $money;
	}
	function resourceValue($rid)
	{
		$sql = "SELECT value FROM resources WHERE rid = :rid";
		$que = $this->db->prepare($sql);
		$que->bindParam(":rid", $rid);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row['value'];
			}catch(PDOException $e) { echo $e->getMessage(); }	
	}
/* 
	Deplete Cells is used in pretty much every other function in CMAC and Battle so it needs to stay here just for
	clarity. After all it does techincally effect the "Coffers".

*/
	function depleteCells($ammount, $type)
	{
		$bank = $this->getUserBanks();
		$energy = $bank[$type.'Cell'];
		if($energy >= $ammount)
		{
		$sql = "UPDATE user_coffers SET {$type}Cell = {$type}Cell - :ammount WHERE uid = :uid AND {$type}Cell >= 0";
		$que = $this->db->prepare($sql);
		$que->bindParam(':ammount', $ammount);
		$que->bindParam(':uid', $this->uid);
		try { if($que->execute()) { return true; } else { return false; } }catch(PDOException $e) { echo $e->getMessage(); }	
		}
		else
		{
			return false;	
		}
	}
}