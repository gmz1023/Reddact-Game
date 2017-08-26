<?php
if(!defined('ADMIN'))
{
	die("<h1>Invalid Security Clearance</h1>");
}
else
{
	?>
    <form action='addUpgrade.php' method='post' class='addUpgrades'>
    <input type='text' name='title'>
    <select name='requires'>
    <option value='0'>None</option>
    <?php
	$sql = "SELECT uid, title FROM upgrades";
	$que = $db->prepare($sql); 
	try { $que->execute(); 
	while($row = $que->fetch(PDO::FETCH_ASSOC))
	{
		echo "hat";
		echo "<option value='{$row['uid']}'>{$row['title']}</option>";	
	}
	}catch(PDOException $e) { }
	?>
    </select>
    <textarea name='desc'></textarea>
    Eyes<input type='number' max="1" min='-1' value='0' name='eyes'>
    Mouth<input type='number' max='1' min='-1' value='0' name='mouth'>
    Coherence<input type='number' max='1' min='-1' value='0' name='coherence'>
    <input type='submit'>
    </form>
    <?php	
}