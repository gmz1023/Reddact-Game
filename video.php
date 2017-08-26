<?php
/*

	Transmission Version 0.1
		Delegated to a class

*/
include('bootstra.php');
/*

	This should be delegated to a class. There's way too much going on here for just a file.

*/

$x = 0;
$y = 0;
$count =$base->enCounter($x,$y);
$num = mt_rand(1,$count);
$mText = $base->getEncounter($num);
?> 
<h1 class='mission-header'>Incoming Transmission</h1>

<div class='mission-text'>
<?php 
/* Modify Text */
echo "<div class='text int'>".$mText->text."</div>";
echo "<div class='text pos hidden'>".$mText->acceptText."</div>";
echo "<div class='text neg hidden'>".$mText->denyText."</div>";
?>
</div>

<div class='mission-actions'>
<div class='hidden' id='levels'  data-levels="0"/>
<button class='mission accept' data-action="pos" data-missiontype="
	<?php echo $mText->eid; ?>"><?php echo $mText->acceptButton; ?></button>
<button class='mission ignore' data-action="neg" data-missiontype="<?php echo $mText->id;  ?>"><?php echo $mText->denyButton; ?></button>
</div>