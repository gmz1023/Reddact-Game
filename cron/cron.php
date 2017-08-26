<?php
include('db.php');
$sql = "UPDATE 
	user_coffers as UC, 
    user_upgrades AS UU
	
SET 
	UC.energyCell = UC.energyCell+(FLOOR(UU.technology/2 *150)+100),
	UC.fuelCell = UC.fuelCell+(FLOOR(UU.technology/4 * 150)+100);
";

$sql .= 
		"UPDATE
			map
		SET
			currentOwner = -1
		WHERE
			homeworld <> 1
		ORDER BY rand()
		LIMIT 1	;
	";
$sql .= "UPDATE
			scoreboard
		 SET
		 	starsCurrentCaptured = (SELECT count(sid) FROM map WHERE map.uid = scoreboard.uid);
";
try{$db->exec($sql);}catch(PDOException $e) { echo $e->getMessage();}

#echo (memory_get_usage()/1048576).'|'.(memory_get_peak_usage()/1048576);
#$base->selectOwnedSystems();
#include('slinfect.php');
?>

