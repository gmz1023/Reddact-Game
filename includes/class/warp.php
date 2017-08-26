<?php
class warp extends users
{
/*
*
*
*	Warp Relay Functions
*	Moved here because there are some features I'd like to improve upon and they need to be their own class
*
*/
	function relayCost()
	{
		$count = $this->countTotalRelays();
		$cost = RELAY_COST*($count+1);
		return $cost;
	}
	function createUserRelay($x,$y,$sid)
	{
		$cost = $this->relayCost();
		if($this->canAfford($cost) && $this->updateCoffers(($cost*-1), $this->uid))
		{
		$sql = "INSERT INTO user_relays(mapX,mapY,sid,uid) VALUES (:x,:y,:sid,:uid)";
		$que = $this->db->prepare($sql);
		$que->bindParam(':x', $x);
		$que->bindParam(':y', $y);
		$que->bindParam(':sid', $sid);
		$que->bindParam(':uid', $this->uid);
		try { 
			if($que->execute()){return 1;}
			else{return false;} }catch(PDOException $e) { echo $e->getMessage(); } 	
		}
		else
		{
			return 0;	
		}
	}
	function isRelay($sid)
	{
		$sql= "SELECT count(rid) AS relay FROM user_relays WHERE sid = :sid AND uid = :uid";	
		$que = $this->db->prepare($sql);
		$que->bindParam(':sid', $sid);
		$que->bindParam(':uid', $this->uid);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row['relay'] >= 1 ? true : false;
		}catch(PDOException $e) { echo $e->getMessage(); }
	}
	function checkUserRelays($x,$y)
	{
		$sql= "SELECT count(rid) as relay FROM user_relays WHERE mapX = :x AND mapY = :y AND mapZ = 0 AND uid = :uid";	
		$que =$this->db->prepare($sql);
		$que->bindParam(':x', $x);
		$que->bindParam(':y', $y);
		$que->bindParam(':uid', $this->uid);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row['relay'];
		}catch(PDOException $e) { echo $e->getMessage(); }
					
	}
	function countTotalRelays()
	{
	$sql= "SELECT count(rid) as relay FROM user_relays WHERE uid = :uid";
	$que =$this->db->prepare($sql);
	$que->bindParam(':uid', $this->uid);
	try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row['relay'];
	}catch(PDOException $e) { echo $e->getMessage(); }
	
	}
	function getRelayCoords()
	{
		$sql= "
			SELECT mapX,mapY
			FROM user_relays 
			WHERE uid = :uid
			ORDER BY RAND()
			LIMIT 1";
		$que =$this->db->prepare($sql);
		$que->bindParam(':uid', $this->uid);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC); 
			return $row; 
			}catch(PDOException $e) { echo $e->getMessage(); } 
	}
}