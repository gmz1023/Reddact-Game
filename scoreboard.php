<?php
include('bootstra.php');
$sql = "SELECT
		 username as name, uid as owner
		 , (
		 select starsCapturedCurrent FROM userscores as total WHERE uid = owner) as total,
		 (
		 select starsCapturedMax FROM userscores as total WHERE uid = owner) as max
		FROM 
			users
		ORDER BY total DESC
		LIMIT 10
			";
$que = $db->prepare($sql);
$html = '';
?>
<style>
table { 
	border-collapse:collapse;
	background-color: #333;
	border: 1px solid black;
	color: #fff;
}
table thead th { background-color: #111; color: #fff; font-size: 150%; padding: 2%; } 
table th, table td { border-bottom: 1px solid black; }
td { background-color: #f1f1f1; color: #000; } 
</style>
<?php

$html.= "<table style='width:50%; margin: 0 auto;'>";
$html.= "<thead><tr><th colspan='3'>Score Board</th></tr></thead>";
$html .= "<tr><th>Username</th><th>Current Total</th><th>Life Time Total</th></tr>
</thead>";
try { $que->execute(); 
	while($row = $que->fetch(PDO::FETCH_ASSOC))
	{
		$html .= "<tr><td>{$row['name']}</td><td>{$row['total']}</td><td>{$row['max']}</td></tr>";
	}
}catch(PDOException $e) { echo $e->getMessage(); }
/*
$html .= "<tr><th colspan='2'>Star Lattice Stats</th></tr>";
$sql = "SELECT count(ssid) as total FROM map WHERE currentOwner = -1 AND starType = 2";
$que = $db->prepare($sql);
try { 
	$que->execute(); 
	$row = $que->fetch(PDO::FETCH_ASSOC);
	$html.= "<td colspan='1'>Infected Systems</th><td>{$row['total']}</td></tr>";
	} catch(PDOException $e) { echo $e->getMessage(); } 

$html.= "<tr><th colspan=3><a style='color: #fff' href='index.php'>Home Page</a></th></tr>";
$html.- "</table>";
echo $html;
*/
echo $html;
/*****************************************************************

		Money Leader

******************************************************************/
/*
$sql = "SELECT
		 username as name, uid as owner
		 , (
		 select balance FROM user_coffers as total WHERE uid = owner) as total
		FROM 
			users
		GROUP BY name
		ORDER BY total DESC
			";
$que = $db->prepare($sql);
echo "<table style='width:50%; margin: 0 auto;'>";
echo "<thead><tr><th colspan='2'>Financial Leaders</th></tr></thead>";
echo "<tr><th colspan='2'>User Stats</th></tr>";
try { $que->execute(); 
	while($row = $que->fetch(PDO::FETCH_ASSOC))
	{
		echo "<tr><td>{$row['name']}</td></tr>";
	}
}catch(PDOException $e) { echo $e->getMessage(); }
*/
/*****************************************************************

		EXP Leader

******************************************************************/
/*$sql = "SELECT
		 username as name, uid as owner
		 , (
		 select userLevel FROM user_coffers as total WHERE uid = owner) as total
		FROM 
			users
		GROUP BY name
		ORDER BY total DESC
			";
$que = $db->prepare($sql);
echo "<table style='width:50%; margin: 0 auto;'>";
echo "<thead><tr><th colspan='2'>Experience</th></tr></thead>";
echo "<tr><th >Username</th><th>User Level</th></tr>";
try { $que->execute(); 
	while($row = $que->fetch(PDO::FETCH_ASSOC))
	{
		echo "<tr><td>{$row['name']}</td><td>{$row['total']}</td></tr>";
	}
}catch(PDOException $e) { echo $e->getMessage(); }
?>*/