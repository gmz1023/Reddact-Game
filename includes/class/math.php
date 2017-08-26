<?php
class math extends paginator
{
/********************************************************
/*
/*	Math Class -- To keep math where it belongs, together, in groups.
/*
/*******************************************************/
	
	
/*
*
*
*	Control Specific -- Used to dictate a users control over the rest of the map. 
*
*/
	function starCostMath($uid)
	{
		$upgrade = $this->getSpecificUpgrade('offense', $uid);
		$count = $this->activeTotalControled($uid);
		$total = $count;
		$cost = ((1000/$total)+1)+1000;
		return $cost;
	}
	function activeTotalControled($uid)
	{
		$sql = "SELECT count(sid) as total FROM map WHERE starType = 2 AND currentOwner = :uid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		try { $que->execute(); $row = $que->fetch(PDO::FETCH_ASSOC); return $row['total'];}catch(PDOException $e) { die($e->getMessage());}
	}
	function countTotalStars()
	{
		/* This Function is used in multiple functions:
			Sphere of Control and some CMAC functions
		*/
		$sql = "SELECT count(sid) as total FROM map WHERE starType = 2";
		$que = $this->db->prepare($sql);
		try { 
		$que->execute(); 
		$row = $que->fetch(PDO::FETCH_ASSOC);
		return $row['total'];
		}catch(PDOException $e) { echo $e->getMessage(); } 
	}
	function countTotalControlledStars($uid)
	{
		/* This Function is used in multiple functions:
			Sphere of Control and some CMAC functions
		*/
		$sql = "SELECT 
				(SELECT starsCapturedCurrent FROM userscores WHERE uid = :uid) as controlled, 
				(SELECT variable_info FROM game_variables WHERE vid =1) as total";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		try { 
		$que->execute(); 
		$row = $que->fetch(PDO::FETCH_ASSOC);
		return $row;
		}catch(PDOException $e) { echo $e->getMessage(); } 
	}
	function spehereOfInfluence($uid)
	{
		//* This function will become obsolete once i get the "Big Map" up
		//* Dear 2016 me, What the fuck is "The Big Map" and why did you never get it up?... you know they make a pill for tha tnow
		$stars = $this->countTotalControlledStars($uid);
		$controlled = $stars['controlled'];
		$total = $stars['total'];
		$sphere =($controlled/$total)*100;
		return number_format($sphere,3).'%';
	}
	function costOfConquest()
	{
		
	}
}