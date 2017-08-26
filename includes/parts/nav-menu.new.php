<div class='navbox' >
<form action='move.php' method='get'>
<Div class='nav-actual'>

<?php if($coffers['fuelCell'] >= MOVE_COST)
{
	?>
<button name='d' value='left' class='dir left'>Left</button>
<button name='d' value='up' class='dir up'>Up</button>
<?php         
	echo "<button name='d' value='home' class='dir home' title='{HOME_TIP}'>Home</button>";
	echo "<button name='d' value='warp' class='dir warp' title='".WARP_TIP."'>Warp</button>";
?>
<button name='d' value='down' class='dir down'>Down</button>
<button name='d' value='right' class='dir right'>Right</button>

<?php
}
else
{
?>
<button name='d' value='up' class='dir up' disabled>Up</button>
<button name='d' value='left' class='dir left' disabled>Left</button>
<?php echo "<button name='d' value='warp' class='dir warp' title='".WARP_TIP."' disabled>Warp</button>
        <button name='d' value='home' class='dir home' title='".HOME_TIP."'>Home</button>"; ?>
<button name='d' value='down' class='dir down' disabled>Down</button>
<button name='d' value='right' class='dir right' disabled>Right</button>
<?Php
}
?>
<button name='p' value='fuel' class='dir fuel'>Fuel</button>
</Div>
</form>
</div>
