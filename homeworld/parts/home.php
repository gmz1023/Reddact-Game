<?php
#echo $base->spehereOfInfluence($_SESSION['user']['uid']);
$term = $base->userTerms();
?>
<div class='newUser'>
<h1>Welcome to Reddact Game!</h1>
<p>Welcome to Reddact Game, to get started; click on the "Star Map" tab at the top of your screen</p>
</div>
<div class='hwwelcome'>
<h1>Welcome Back Commander</h1>
<div class='hwUserStat'>
<div class='hwrow'>Sphere Of Infulence: <?php echo $base->spehereOfInfluence($_SESSION['user']['uid']); ?></div>
<div class='hwrow'>Pending Missions: 0</div>
<div class='hwrow'>Current Alliance: Unaligned</div>
</div>

<div class='hw-updates changes'>
	<h3>Changes to the <?php echo $term['civType']; ?></h3>
	<p>
    Since You're Last Visit you have lost <?php echo $_SESSION['user']['starsLost']; ?>
     systems.
    </p>
</div>
<div class='hw-updates tier'>
<h3>News From Tier Corporation</h3>
<dl>
<dt>New Item!
<dd>New Item allows you to do Old Action with Easier Ease</dd>
</dt>
</dl>
</div>
</div>