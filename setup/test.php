<?php
include('includes/db.php');
#$base = new base($db);

define('MAX', 4);
$min = MAX*-1;
$x = $min;
$y = $min;
$i = 1;
 $sql ="INSERT INTO map (ssid, mapX, mapY, starType, resource, habitablePlanets) VALUES";
do
{
	for($s = 1; $s < 257;)
	{
		$r = mt_rand(1,118);
		$p = mt_rand(1,8);
		$t = mt_rand(1,64) <= 50 ? 1 : 2;
		echo "({$i},{$x},{$y},{$t},{$r},{$p}), \n";
		//usleep(1000);
		$sql .= "({$i},{$x},{$y},{$t},{$r},{$p}),";
		$i = $i+1;
		if($s == 256)
		{
			$s = 1;
			if($y == MAX)
			{
				$y = $min;
				$x = $x+1;
			}		
			else
			{
				$y = $y+1;
			}
		}
		else
		{
			$s = $s+1;
		}
		if($x == MAX+1)
		{
			break;
		}

	}
}while($x < MAX+1);

		$sql = trim($sql,',');
			try { $db->exec($sql);}catch(PDOException $e) { die($e->getMessage()); }
?>