<?php
class encounters extends ships
{
	/*
		Encount Notes
			Rewards : array(Resource=rid,ammount=>n);
	*/
	function __construct()
	{
	}
	function enCounter($x,$y)
	{
		$sql = "SELECT count(eid) as total FROM encounters WHERE (mapX = :x AND mapY = :y) OR (mapX is null AND mapY is null)  LIMIT 1;";
		$que = $this->db->prepare($sql);
		$que->bindParam(':x',$x);
		$que->bindParam(':y',$y);
		try { 
				$que->execute(); 
				$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row['total'];
		}catch(PDOException $e) { die($e->getMessage());}
	}
	/* Basic Encounter Functions */
	function getEncounter($eid)
	{
		$sql = "
				SELECT 
					text, 
					mapX, 
					mapY, 
					eid,
					acceptText,
					acceptButton,
					denyText,
					denyButton,
					type
				FROM 
					encounters 
				WHERE 
					eid = :eid 
				LIMIT 1";
		$que = $this->db->prepare($sql);
		$que->bindParam(':eid', $eid);
		try {
			$que->execute();
			$row = $que->fetch(PDO::FETCH_OBJ);
			return $row;
		}catch(PDOException $e) { die($e->getMessage());}
	}
}
?>