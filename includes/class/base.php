<?php
class base extends math
/* Final Extends: Ships */
{
	function __construct($db)
	{
		/* This needs to be upgraded to better fit the number of AI's but i'm to lazy to figure out a quick way to do it */
		$this->storeAI = array(30,31);
		$this->upgradeArray = array('technology', 'economy', 'medicine', 'offense', 'defense','biology');
		$this->db = $db;
		$this->uid = isset($_SESSION['user']['uid']) ? $_SESSION['user']['uid'] : NULL; 
		$this->forcedEncounter = mt_rand(0,3) == 0 &&(isset( $_SESSION['z'] ) && $_SESSION['z']  != 1) ? 1 : 0;
	}
	function numberAbbreviation($number) {
		$abbrevs = array(12 => "T", 9 => "B", 6 => "M", 3 => "K", 0 => "");
		if($number == 0)
		{
			return number_format($number,0);	
		}
		foreach($abbrevs as $exponent => $abbrev) {
			if($number >= pow(10, $exponent)) {
				$display_num = $number / pow(10, $exponent);
				$decimals = ($exponent >= 3 && round($display_num) < 100) ? 1 : 0;
				return number_format($display_num,$decimals) . $abbrev;
			}
		}
	}
	function countSystems()
	{
		$sql = "SELECT count(suid) as total FROM system_upgrades";
		$que = $this->db->prepare($sql);
		try { 
			$que->execute(); 
				$row = $que->fetch(PDO::FETCH_ASSOC);
			}catch(PDOException $e) { echo $e->getMessage(); } 
		return $row['total'];	
	}
	function lastRegisteredUser()
	{
		$sql = "SELECT username FROM users ORDER BY uid DESC LIMIT 1";
		$que = $this->db->prepare($sql);
		try { $que->execute(); $row = $que->fetch(PDO::FETCH_ASSOC); return $row['username']; } catch(PDOException $e) { echo $e->getMessage(); } 	
	}
	function userPermission($uid)
	{
		/* This Function might be Dead */
		if($this->uid == NULL)
		{
			$permArr = array('user'=>0,'map'=>0,'news'=>0,'misc'=>0);
		}
		else
		{
		$sql = "SELECT permissions FROM users WHERE uid = :uid LIMIT 1";
		$que= $this->db->prepare($sql);
		$que->bindParam(":uid", $uid);
		try { $que->execute();
				$row = $que->fetch(PDO::FETCH_ASSOC);
				$perm = explode(',',$row['permissions']);
				$permArr = array('user'=>$perm[0],'map'=>$perm[1],'news'=>$perm[2],'misc'=>$perm[3]);
				return $permArr;
			 exit;
		} catch(PDOExcetpion$e) { echo $e->GetMessage(); } 	
		}
	}
	function userCount()
	{
		$sql = "SELECT count(uid) as users FROM users";
		$que = $this->db->prepare($sql);
		try { $que->execute(); $row = $que->fetch(PDO::FETCH_ASSOC); return $row['users']; }catch(PDOException $e) { echo $e->getMessage(); } 	
	}
	function planetPopulationMath($val)
	{
		
		//* Needs to be modified at some point to actually do what i want it to do, just fixing it for now
		$val = $val.' Million';
		return $val;
	}
	function is_logged_in()
	{
		if(isset($_SESSION['user']))
		{
			return true;
			
		}
		else
		{
			return false;
		}
	}
	function getUsername($uid)
	{
		switch($uid)
		{
			case '0':
			$name = 'unowned';
			break;
			case '-1':
			$name = 'Star Lattice';
			break;
			case '-2':
			$name = 'Tier Corporation';
			break;
			default:
			$sql = "SELECT username FROM users WHERE uid = :uid";
			$que = $this->db->prepare($sql);
			$que->bindParam(':uid', $uid);
			try { 
				$que->execute(); 
				$row = $que->fetch(PDO::FETCH_ASSOC);
				$name = $row['username'];
				}catch(PDOException $e) { echo $e->getMessage(); }	
			break;	
		}

		return $name;
	}
/* Game Variables */
	function getVariables($vName)
	{
		$sql = "SELECT variable_info from game_variables WHERE variable_name = '{$vName}' LIMIT 1";
		$que = $this->db->prepare($sql);
		try { 
				$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC); 
			return $row['variable_info'];
		}catch(PDOException $e) 
		{ die($e->getMessage());}
	}
	function updateVariables($vName,$value)
	{
		$sql = "UPDATE game_variables SET variable_info = variable_info+{$value} where variable_name = '{$vName}'";
		$que = $this->db->prepare($sql);
		$this->db->beginTransaction();
		try{ 
			if($que->execute())
			{
				$this->db->commit();
			}
		}catch(PDOException $e) { die($e->getMessage());}
	}
}
?>