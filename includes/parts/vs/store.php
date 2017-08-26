</nav>
<h1>Welcome to store</h1>
<p>Here you can buy, sell, and trade almost any item in your inventory</p>
<div id='resource'>
<h1>Resources</h1>
<?php
	$inv = $base->fullInventory($_SESSION['user']['uid']);
	echo "<select name='resource'>";
	foreach($inv as $k)
	{
		echo "<option value='{$k['iid']}' data-max='{$k['item_count']}'>{$k['rname']}</option>";	
	}
	echo "</select>";
?>
<input type='number' max="0" min="0" id='resale'>
</div>
<script>
$( "#resource select" ).change(function() {
   var input = document.getElementById("resale");
   var maxV = $('#resource select :selected').attr('data-max');
   var minV = maxV*-1;
   input.setAttribute("max", maxV);
   input.setAttribute("min", minV);
});
</script>