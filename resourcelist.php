<?php
include('bootstra.php');
$html ='';
$sql = "SELECT rid,resourceName,value FROM resources";
$que = $db->prepare($sql);
try { 
	$que->execute();
	$html .= "<table><tr><th>rid</th><th>Resource</th><th>Value</th></tr>";
	while($row = $que->fetch(PDO::FETCH_ASSOC))
	{
		$html .= "<tr><td>{$row['rid']}</td><td>{$row['resourceName']}</td><td>{$row['value']}</td></tr>";		
	}
	$html .= "</table>";
 } catch(PDOException $e) { }
 
 echo $html;