<?php
include('../ARchive-New/includes/db.php');
define('MAP_MAX', 1);
define('stars_per_section', 1000);
$sql = "INSERT INTO `map`(`ssid`, `mapX`, `mapY`, `starType`, `currentOwner`, `previousOwner`, `resource`) VALUES ";
$ssid = 1;
$y = MAP_MAX*-1;
$x = MAP_MAX*-1;
$l = 1;
$stars = (MAP_MAX*2)*stars_per_section;
echo $stars;
$lY = $y;
$lX = $x;
ini_set('max_execution_time', 300);
$cSid = 1;
for($i = 1; $i <= $stars;)
{
	if($cSid <= stars_per_section)
	{
		$cSid = $cSid +1;		
	}
	else
	{
		if($lY >= MAP_MAX)
		{
			$lY = $y;
			$lX = $lX +1;	
		}
		else
		{
			$lY = $lY+1;	
		}
		if($lX >= MAP_MAX)
		{
			break;	
		}
	$i = $i+1;
	$sql .= "({$ssid},{$lX},{$lY},1,0, 0, 0),";
	}
}
$sql = trim($sql,',');
$f = fopen("sql.txt", "w");
fwrite($f, $sql);
fclose($f);  
?>```