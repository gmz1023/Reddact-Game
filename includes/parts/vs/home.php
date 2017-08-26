<?php
	$d1 = new DateTime('NOW');
	$d2 = new DateTime($sinfor['CapturedOn']);
	$diff = $d1->diff($d2);
	$days= $diff->days;
	$username = $base->getUsername($sinfor['currentOwner']);
?>
<?php if($sinfor['currentOwner'] == $_SESSION['user']['uid']) { ?>
<div class='hwwelcome'>
<h1>Welcome Back Commander</h1>
<div class='hwUserStat'>
<div class='hwrow'>Sphere Of Infulence: <?php echo $base->spehereOfInfluence($_SESSION['user']['uid']); ?></div>
<div class='hwrow'>Pending Missions: 0</div>
<div class='hwrow'>Current Alliance: Unaligned</div>
</div>
<div class='newsfromtier'>
<h3>News From Tier Corporation</h3>
<dl>
<dt>New Item!
<dd>New Item allows you to do Old Action with Easier Ease</dd>
</dt>
</dl>
</div>
</div>
<?php } ?>