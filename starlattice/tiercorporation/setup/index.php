<?php
include('upgrades.php');
?>
<style>
table { width: 30%; border: 1px solid black; text-align:center; }
</style>
<?php
$upgrades = new upgrades;
$limit = isset($_GET['limit']) ? $_GET['limit'] : 2;
$array = $upgrades->compile($limit);
echo "<table><tr><th>Required</th><th>Id</th><th>Blocked By</th></tr>";
foreach($array as $k=>$x)
{
	foreach($x as $m=>$v)
	{
	$bb = implode(' ',$v['blockBy']);
	echo "<tr><td>{$v['required']}</td><td>{$v['id']}</td><td>{$bb}</td></tr>";	
	}
}