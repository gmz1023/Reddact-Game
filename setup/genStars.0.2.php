<?php
include('/includes/db.php');
define('map_max', 1);
define('stars_per_section', 1000);
$sql = "INSERT INTO `map`(
	`ssid`, 
	`mapX`, 
	`mapY`, 
	`starType`, 
	`currentOwner`, 
	`previousOwner`, 
	`resource`, 
	`habitablePlanets`
	) VALUES ";
$ssid = 1;
$y = map_max*-1;
$x = map_max*-1;
$l = 1;
$stars = (map_max*2)*stars_per_section;
echo $stars;
$lY = $y;
$lX = $x;
ini_set('max_execution_time', 300);
for($i = 1; $i <= $stars;)
{
	$ssid = $i;
	if($lY > $y)
	{
		$lY = $y;
		$lX = $x+1;	
	}
	else
	{
		$lY = $lY+1;	
	}
	if($lX > $x)
	{
		$lX = $x;
	}
	else
	{
				
	}
	$i = $i+1;
	$planets = mt_rand(0,8);
	$sql .= "({$ssid},{$lx},{$ly},1,0, 0, 0, {$planets}),";
	if($l >= $stars)
	{
		$sql = trim($sql, ',');
		$que = $db->prepare($sql);
		try { 
			$que->execute();
			$sql = 
				"INSERT INTO `map`(
				`ssid`, `mapX`, `mapY`, `starType`, `currentOwner`, `previousOwner`, `resource`) VALUES ";
			 }catch(PDOException $e) { echo $e->getMessage(); }
		$l = 0;	
	}
	else 
	{
		$l = $l+1;	
	}
}
$sql = trim($sql,',');
echo $sql;

//$f = fopen("sql.txt", "w");
//fwrite($f, $sql);
//fclose($f);  
?>```