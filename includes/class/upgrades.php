<?php
class upgrades extends populationGrowth
{
	function upgradesInsert()
	{
		$sql = "INSERT INTO user_upgrades(uid) VALUES (:id)";
		$que = $this->db->prepare($sql);
		$id =$this->db->lastInsertId();
		$que->bindParam(':id', $id);
		//* Change this if/when six and seven are changed to actual upgrades or if new upgrades are added

		try { if($que->execute())
			{return true;}else{return false;}
		 }catch(PDOException $e) { echo $e->getMessage(); }	
	}
	function getSpecificUpgrade($upgrade, $uid)
	{
		$sql = "SELECT {$upgrade} as value FROM user_upgrades WHERE uid = :uid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		try { $que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row['value'];
		}catch(PDOException $e) { echo $e->getMessage(); }
	}
	function upgrade($upgrade)
	{
		if(in_array($upgrade, $this->upgradeArray))
			{
				$gsu = $this->getSpecificUpgrade($upgrade, $this->uid);
				$price = $this->upgradeCost($upgrade, $gsu);
				if($this->canAfford($price))
				{
				$sql = "UPDATE user_upgrades SET {$upgrade} = {$upgrade}+1 WHERE uid = :uid";
				$que = $this->db->prepare($sql);
				$que->bindParam(':uid', $this->uid);
					try { 
						if($que->execute())
						{
							$price = $price *-1;
							if($this->updateCoffers($price, $this->uid) && $this->userLevelMath($this->uid,UPGRADE_XP))
							{
								return 'true';	
							}
							else
							{
								return 'false';	
							}
						}
						else
						{
							echo 'false';	
						}
						}catch(PDOException $e) { echo $e->getMessage(); }	
				}
				else
				{
					$money = $this->getUserBanks();
					$money = $money['balance'];
					echo $price."|".$money;
				}
			}
	}
	function fetchUpgrades()
	{
		$sql = "SELECT technology, economy, medicine, biology, offense, defense FROM user_upgrades WHERE uid = :uid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $this->uid);
		try { 
			$que->execute();
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row;
			 }catch(PDOException $e) { echo $e->getMessage(); }
	}
	function displayUpgrades()
	{
		$upgrade = $this->fetchUpgrades();
		#echo "<div class='upgrade-title'>Upgrades</div>";
		$html ='';
		foreach($upgrade as $k => $v)
		{
			
			$price = $this->numberAbbreviation(($this->upgradeCost($k, $v)));
			switch($k)
			{
				case 'technology':
				$name = $k[0];
				$fName = substr($k,1);
				$desc = "Upgrading your {$k} ";
				$desc .= "decreases the cost of other upgrades";
				break;
				case 'economy':
				$name = $k[0];
				$fName = substr($k,1);
				$desc = "Upgrading your {$k} ";
				$desc .= "increases the returns from mining";
				break;
				case 'biology':
				$name = $k[0];
				$fName = substr($k,1);
				$desc = "Upgrading your {$k} ";
				$desc .= "Increases the effectiveness of your citizens";
				break;
				case 'medicine':
				$name = $k[0];
				$fName = substr($k,1);
				$desc = "Upgrading your {$k} ";
				$desc .= "Increase the age limit/rate of healing for all your systems";
				break;
				case 'defense':
				$name = $k[0];
				$fName = substr($k,1);
				$desc = "Upgrading your {$k} ";
				$desc .= "Increases overall defensive abilities of your ship/systems";
				break;
				case 'offense':
				$name = $k[0];
				$fName = substr($k,1);
				$desc = "Upgrading your {$k} ";
				$desc .= "Increases overall offensive abilities of your ship/systems";
				break;
				default:
				
				break;	
			}
			$class = strtoupper($name);
			$fName = strtolower($fName);
			$html .= "<dl id='{$k}' class='upgrade {$class}'><dt><h2>{$k}</h2><div>{$v}</div></dt>";
			$html .= "<dd>{$desc} | Price {$price}</dd></dl>";
			#$html .= "<div class='upgrade' id='{$k}' title='{$desc}'><div class='name'>{$name}{$fName}</div><div class='level'><span class='noshow'>Level</span>{$v}</div><div class='price noshow'>$".$price."</div></div>";	
		}
		echo $html;
	}
	function upgradeCost($k, $v)
	{
		$tech = $this->getSpecificUpgrade('technology', $this->uid);
		$eco  = $this->getSpecificUpgrade('economy',$this->uid);
		$bio = $this->getSpecificUpgrade('biology',$this->uid);
		$med = $this->getSpecificUpgrade('medicine',$this->uid);
		$def = $this->getSpecificUpgrade('defense',$this->uid);
		$off = $this->getSpecificUpgrade('offense',$this->uid);
		switch($k)
		{
			case 'technology':
			$discount = $eco > 1 ? (($eco * $eco))/0.225 : 0;
			$price = ((10)*($v*($v/0.25)))*100.0009 - $discount;
			break;
			case 'economy':
			$discount = 0;
			$price = (((10)*($v*$v))*10);
			if(($price - $discount) > 0)
			{
				$price = $price - $discount;	
			}
			break;
			case 'biology':
			$discount = $med > 1 ? abs(($med - $tech)*10)*($v*$v) : 0; 
			$price = (((10)*($v*$v))*10);
			if(($price - $discount) > 0)
			{
				$price = $price - $discount;	
			}
			break;
			case 'medicine':
			$discount = $bio > 1 ? (($v*$bio)*10)/0.19293412367 : 0;
			$price = (((10)*($v*$v))*10);
			if(($price - $discount) > 0)
			{
				$price = $price - $discount;	
			}
			break;
			case 'offense':
			$discount = ($eco*100)/0.199;
			$price = $off < 1 ? (((10)*($v*$v))*9) : (((5)*($v*$v)*3)*($def/1.25))*(5/0.2229919197);
			if(($price - $discount) > 0)
			{
				$price = $price - $discount;	
			}
			break;
			case 'defense':
			$discount = ($eco*100)/0.199;
			$price = $off < 1 ? (((10)*($v*$v))*9) : (((5)*($v*$v)*3)*($off/2))*(5/0.2229919197);
			if(($price - $discount) > 0)
			{
				$price = $price - $discount;	
			}
			break;
		}
			return ($price);
	}
/*************************************************************************
	
			System Upgrades
	
*************************************************************************/
	function getSUpgrades($sid)
	{
		$sql = "SELECT hospital, warehouse, refineries, banks, defense FROM system_upgrades WHERE sid = :sid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':sid', $sid);
		$array = [];
		try { 
			$que->execute(); 
			while($row = $que->fetch(PDO::FETCH_ASSOC))
			{
				$array[] = $row;	
			}
			
			}catch(PDOexception $e) { echo $e->getMessage(); } 	
			return $array;
	}
	function SystemCost($upgrade,$sid)
	{
		$upgrade = $this->getSpecificSystem($upgrade, $sid);
		$cost = ($upgrade[0] * 1.777)*1000;
		return $cost;
	}
	function displaySUpgrades($sid)
	{

		$array = $this->getSUpgrades($sid);
		$html = "";
		foreach($array[0] as $key => $value)
		{
			$cost = $this->numberAbbreviation($this->SystemCost($key,$sid));
			$html .= "<button class='supgrade {$key}' data-sid='{$sid}' id= '{$key}'>{$key}: {$value} | {$cost}</button>";	
		}
		$html .= "";
		return $html;
	}
	function getSpecificSystem($upgrade, $sid)
	{
		$sql = "SELECT {$upgrade} FROM system_upgrades WHERE sid = {$sid}";	
		$que = $this->db->prepare($sql);
		try { $que->execute();  $row = $que->fetch(PDO::FETCH_NUM); return $row; } 
		catch(PDOException $e) { echo $e->getMessage(); } 
	}
	function upgradeSystem($sid, $upgrade)
	{
				$gsu = $this->getSpecificSystem($upgrade, $sid);
				$price = $this->SystemCost($upgrade,$sid);
				#$price = 1000;
				if($this->canAfford($price))
				{
				$sql = "UPDATE system_upgrades SET {$upgrade} = {$upgrade}+1 WHERE sid = :sid";
				
				$que = $this->db->prepare($sql);
				$que->bindParam(':sid', $sid);
					try { 
						if($que->execute())
						{
							$price = $price *-1;
							if($this->updateCoffers($price, $this->uid))
							{
								return 'true';	
							}
							else
							{
								
								return 'false';	
							}
						}
						else
						{
							echo 'false';	
						}
						}catch(PDOException $e) { echo $e->getMessage(); }	
				}
				else
				{
					$money = $this->getUserBanks();
					$money = $money['balance'];
					return 'false';
				}
		}	
}