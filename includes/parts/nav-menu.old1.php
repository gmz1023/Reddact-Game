<div id='navbox'>
<!--<h1 class='clickable' title="Allows you to navigate around the map" >Navigation</h1> !-->

<form action='move.php' method='get'>
<?php if($coffers['fuelCell'] >= 40)
{
	?>
<button name='d'  value='up' class='dir up'>Up</button>
<button name='d' value='right' class='dir right'>Right</button>
<button name='d' value='down' class='dir down'>Down</button>
<button name='d' value='left' class='dir left'>Left</button>

<?php
}
else
{
?>
<button name='d'  value='up' class='dir' disabled>Up</button>
<button name='d' value='right' class='dir' disabled>Right</button>
<button name='d' value='down' class='dir' disabled>Down</button>
<button name='d' value='left' class='dir' disabled>Left</button>
<!--
<?php 	
}
echo "<div class='homerow'>";
$tech = $base->getSpecificUpgrade('technology', $_SESSION['user']['uid']);
if($tech >= 5)
{
	if($coffers['energyCell'] >= WARP_COST & $coffers['fuelCell'] >= WARP_COST & $tech >= WARP_TECH_LVL)
	{
	echo "<button name='d' value='warp' class='dir warp' title='".WARP_TIP."'>Warp</button>	";
	}
	else
	{
	echo "<button name='d' value='warp' class='dir warp' disabled title='".WARP_TIP."'>Warp</button>	";
	}
	if($coffers['energyCell'] >= WARP_COST/10)
	{
	echo "<button name='d' value='home' class='dir home' title='".HOME_TIP."'>Home</button>";
	}
	else
	{
	echo "<button name='d' value='home' class='dir home' disabled title='".HOME_TIP."'>Home</button>	";
	}
echo "</div>";
}
?>
</form>

<form id='bresource'>
<?php if($_SESSION['z'] == 0){ ?>

<h1 class='small clickable' title="When you are low on resources; you can buy them here">Buy Resources</h1>
<div id='dres'>
<?php 

if($coffers['energyCell'] >= (((TECHLEV* 50)+1000)*2) && $base->canAfford((ENERGY_COST)))
{
	echo "<button id='energy' value='energy' title='".number_format(ENERGY_COST,0)."' disabled>Energy</button>";
}
else
{
	echo "<button id='energy' value='energy' title='".number_format(ENERGY_COST,0)."'>Energy</button>";	
}
if($coffers['fuelCell'] >= (((TECHLEV* 100)+1000)*2) && $base->canAfford(FUEL_COST))
{
	echo "<button id='fuel' value='fuel' disabled title='".number_format(FUEL_COST,0)."'>Fuel</button>";
}
else
{
	echo "<button id='fuel' value='fuel' title='".number_format(FUEL_COST,0)."'>Fuel</button>";
}
echo "</div>";
}
else
{
?> 
<h3>Resource Connection Unavailable </h3>

<?php	
}
?>