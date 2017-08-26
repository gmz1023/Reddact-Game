<div class='coeus'>
<div class='head'>
<div class='eyes'><video width='100%' height='100%' autoplay loop><source src="../../../../ARchive-New/starlattice/tiercorporation/DD/coeus/coeus/videos/BrokenArrowSoundless.mp4" type="video/mp4"></video></div>
<div class='mouth'><?php include('../../../../ARchive-New/starlattice/tiercorporation/DD/coeus/mouth.php'); ?></div>
</div>
<div class='deployment'>
<?php
$sql = "SELECT 
			title, 
			description,
			votes_required,
			votes, 
			U.uid 
		FROM 
			upgrades as U, 
			enabled_upgrades as EU 
		WHERE NOT EXISTS (SELECT * FROM enabled_upgrades EU WHERE (U.uid = EU.uid) OR (U.blockedBy = EU.uid)) AND U.requires = EU.uid";
$que = $db->prepare($sql);
try { $que->execute();
$html = '';
while($row = $que->fetch(PDO::FETCH_ASSOC))
{
	$alreadyVote = $base->userUpgradeArray();
	$disabled = in_array($row['uid'], $alreadyVote) ? 'disabled' : '';
	$html .= "<div class='upgrade'>
<div class='title'>
	<h1>{$row['title']}</h1>
</div>
<div class='meta'>
	<div class='info'>{$row['description']}</div><div class='vote'><form action='vote.php' method='POST'><input type='hidden' value='{$row['uid']}' name='vote'><input type='submit' value='Vote' {$disabled}>{$row['votes']}/{$row['votes_required']}</form> </div>
</div></div>";
}
}catch(PDOException $e) { } 
echo $html;
?>

</div>
</div>
</div>