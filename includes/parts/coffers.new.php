<?php	
echo "<div class='coffers'>";
echo "<table>";
$html = '</tr><tr>';
$html1 = '<tr>';
	foreach($coffers as $x=>$y)
	{
		$name = $x;
		$y = number_format($y);
		$class = $y > 100 ? '' : 'low';
		if($x != 'balance')
		{
		$x = substr($x,0,-4);
		}
		$x = strtoupper($x);
		$html1 .= "<th>{$x}</th>";
		$html .= "<td>{$y}</td>";
	}
$html1 .= "<th>Coords</th>";

	if($_SESSION['z'] != 0)
	{
		$coords = "X".mt_rand(-64,64)."Y".mt_rand(-64,64);	
	}
	else
	{ $coords = "X{$_SESSION['x']}Y{$_SESSION['y']}"; }
	$coords = "X{$_SESSION['x']}Y{$_SESSION['y']}";
	$html .= "<td>{$coords}</td>";
	$l = $base->progressPercent($_SESSION['user']['uid']);
	#echo "<td class='pbar'><div id='progressbar'>Level ".$l['CL'].'|'.$l['XP']."XP/".$l['NL']."XP</div></td></tr>";
	#echo "<dt>Ship HP</dt><dd class='health'>100/100</dd>";
	#echo "</dl></div>";
echo $html1.$html;
	?>