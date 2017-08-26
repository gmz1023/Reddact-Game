<?php
class upgrades
{
	function userUpgradeArray()
	{
		$sql = "SELECT upgradeID FROM user_upgrades_voted WHERE uid = :uid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $_SESSION['user']['uid']);
		try { 
			$que->execute(); 
			$array = [];
			while($row = $que->fetch(PDO::FETCH_ASSOC))
			{
				$array[] = $row['upgradeID'];	
			}
			return $array;
			} catch(PDOException $e) { echo $e->getMessage(); } 	
	}
}