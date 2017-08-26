<?php
include('includes/constants.php');
$base = new base($db);
define('MAX', 2);
$min = MAX*-1;
$x = 0;
 $sql ="INSERT INTO map (ssid, mapX, mapY, starType, resource, habitablePlanets) VALUES";
for($i = 1; $i <= 2;)
{
	echo $x;
	$x++;
	if($x <= 16)
	{
		$i++;
	}
}
