<?php
class ships
{
function getShipStat($type)
{
	$type = 'ship'.ucfirst($type);
	$sql = "SELECT * FROM ships WHERE shipID = (SELECT currentShip FROM user_coffers WHERE uid = :uid) LIMIT 1";
	$que = $this->db->prepare($sql);
	#$que->bindParam(':type', $type);
	$que->bindParam(':uid', $this->uid);
	try { 
		$que->execute(); 
		$row = $que->fetch(PDO::FETCH_ASSOC);
		return $row[$type];
		} catch(PDOException $e) { $e->getMessage(); } 
}
	
}