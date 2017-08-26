<?php
class CMAC extends finance
{
/* New Features */
function starsLostSinceLastLogin($uid)
{
	return 0;	
}

/* Old Features */
	function getStarOwner($sid)
	{
		$sql = "SELECT currentOwner, previousOwner FROM map WHERE sid = :sid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':sid', $sid);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row;
			} catch(PDOException $e){ echo $e->getMessage(); }	
	}
	function getResourceName($rid)
	{
		$sql = "SELECT resourceName FROM resources WHERE rid = :rid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':rid', $rid);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return ucfirst($row['resourceName']);
			} catch(PDOException $e){ echo $e->getMessage(); }	
	}
	function CMA($uid, $sid, $method)
	{
		$coffers = $this->getUserBanks(); // in finance
		if($sid > 0)
		{

			$owners = $this->getStarOwner($sid); // in this class
			if($owners['currentOwner'] == $uid)
			{
			if(($coffers['energyCell'] - MINE_DEPLETION) >= 0 
			&& $coffers['fuelCell'] - (MINE_DEPLETION*1.5) >= 0
			&&
			$this->userLevelMath($uid,MINE_XP)
			)
			{
				//* Mine Function
				if($this->mineSystem($sid, $uid))
				{
					if($this->depleteCells(MINE_DEPLETION, 'energy') 
					&& $this->depleteCells((MINE_DEPLETION*1.5), 'fuel'))
					{
					return '1';
					}
				}
				else
				{
					return '0';
				}
			}
				else
				{
					return '0';	
				}
				
			}
			if($owners['previousOwner'] == $uid)
			{
				//* Conquer Planet, chance of "civil" advantage	
				return 'mine';
				
			}
			else
			{
				//* Capture Planet
				if($method == 'capture')
				{
					$cCost =$this->starCostMath($this->uid);
					$cost = (ceil($cCost));
					if(($coffers['energyCell'] - MINE_DEPLETION*2.75) > 0 
					&& $coffers['fuelCell'] - (MINE_DEPLETION*1.5) > 0
					&& $this->canAfford($cost)
					)
					{
						if(
							$this->CaptureSystem($uid, $sid, $owners['currentOwner']))
						{
							if(	$this->depleteCells(MINE_DEPLETION*2.75, 'energy') )
							{
								if($this->depleteCells((MINE_DEPLETION*2.5), 'fuel'))
								{
									if($this->updateCoffers(($cost*-1), $this->uid))
									{
										if($this->userLevelMath($uid,CPT_XP))
										{
											return '1';
										}
									}
									else
									{
										return 'money';
									}
								}
								else
								{
									return 'fuel';
								}
							}
							else
							{
								return 'energy';
							}
						}
					
						else
						{
							return '0';
						}
					}
				}
				/* 
				
					Everything Relevant to the Attack Method goes here	
				
				*/
				if($method == 'attack')
				{
					if(
						$this->depleteCells(CONQUEST_COST, 'fuel') 
						&& 
						$this->depleteCells(CONQUEST_COST, 'energy')
						&& 
						$this->updateCoffers((CONQUEST_COST*3)*-1, $this->uid)
						&&
						$this->userLevelMath($uid,WAR_XP)
						)
					{
						$attack = $this->diceRoll($uid, $owners['currentOwner'], $sid);
						switch($attack)
						{
							case 'true':
							if($this->CaptureSystem($uid, $sid, $owners['currentOwner']))
							{
										$username= $this->getUsername($uid);
										$date = new DateTime();
										$date = $date->format(DateTime::ISO8601);
										$note = "SYSTEM {$sid} WAS CAPTURED BY {$username} on {$date}";
										if($this->insertNotification($owners['currentOwner'], $note))
										{
											return '1';
										}
										else
										{
											return '1';	
										}	
							}
								else
								{
									return 0;
								}
							break;
							case 'false':
							//* this function should make the attacker loose some of their stuff
							return '0';
							case 'stalemate':
							//* this function should make both loose stuff
							return '0';
							break;
						}
					}
				}
				$array['chance'] = mt_rand(0,1);
				
				}
			}
				/* 
				
					Hell Glitch	
				
				*/
		if($sid == -666)
					{
						if(($coffers['energyCell'] - MINE_DEPLETION*5) >0 &&
						($coffers['energyCell'] - MINE_DEPLETION*5) > 0)
						{
						if(
							$this->updateCoffers(1000000, $this->uid) && 
							$this->depleteCells(CONQUEST_COST*5, 'energy') && 
							$this->depleteCells(CONQUEST_COST*5, 'fuel'))
						{
							if($this->updateUserInv($uid, 99, mt_rand(1,3)))
							{
								return  '1';
							}
						}
						else
						{
							return '1';	
						}
						if(isset($_SESSION['user']['mlimit']))
						{
							$_SESSION['user']['mlimit'] = $_SESSION['user']['mlimit']+1; 	
						}
						else{ $_SESSION['user']['mlimit'] = 1; }
						if($_SESSION['user']['mlimit'] <= 3)
						{
							$_SESSION['z'] = 0;	
							return '2';
								
						}
						}
						else
						{
							return '0';	
						}
					}
	}
	function attack($uid, $sid)
	{
		$this->CMAction($uid, $sid);	
	}

	function CaptureSystem($uid, $sid,$pid)
	{
		//* This Function needs to be changed to "CaptureSystem" at some point
		$pop = $uid > 0 ? 1000 : 0;
		$sql = "UPDATE 
					map as m,
					system_upgrades as s
				SET 
					m.currentOwner = '{$uid}', 
					m.CapturedOn = CURRENT_TIMESTAMP, 
					m.population = '{$pop}',
					s.current_owner = '{$uid}'
				WHERE 
					m.sid = '{$sid}' AND s.sid = '{$sid}' AND homeworld = 0; ";
		try { 
			$this->db->beginTransaction();
			if($this->db->exec($sql))
			{
				$this->db->commit();
				if($this->updatestarCount($uid,$pid))
				{

				return true;
				}
				else
				{
					die('failed to update star charts');
				}
			}
			else
			{
				$this->db->rollback();
				die('failed to update star charts');
			}
			
		 } catch(PDOExceptioN $e) { echo $e->getMessage(); }	
	}
}