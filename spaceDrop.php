<?php
include('bootstra.php');
$x = $_POST['x']; 
$y = $_POST['y'];
$relays = $base->checkUserRelays($x, $y);
$count  = $base->numberAbbreviation($base->relayCost());
#$relays <= 0
if($relays == 0)
{
?>
<div id='spacedrop'>
<h3>Drop a Warp Relay</h3>
<p>Cost: <?php echo $count; ?></p>
<button value='<?php echo $_POST['sid'];?>' id='relay'>Drop Relay</button>
<?php
}
else 
{
	echo "<h3> Relay already exists in this sector of space</h3>";	
}
echo "</div>";
?>