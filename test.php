<?php
include('bootstra.php');
$value =77; //mt_rand(1,300);
$hab = 8;
		#$upgrade = $this->getSpecificUpgrade('offense', $uid);
		#$count = $this->activeTotalControled($uid);
echo "<pre>";
for($i = 1; $i < 1500; $i++)
{
	$up = $base->fetchUpgrades();
	#$updiff = (($up['economy'])-($up['offense']*($up['offense']+1)))*($i/10);
	#$updiff = floor(((($up['offense']*($up['offense']+$i))-($up['economy']*$i))*1.75)*(($i/700)+1));
	$safe = 5;
	$updiff = $i < $safe ? 1 : ceil(($i-$safe/5)+($up['offense']*0.1));
	#$updiff = ($i / 250)*($up['offense']*4)-($up['economy']);
	#$count = $this->activeTotalControled($uid);
	$total = $i+1;
	echo "[".$updiff."]";
	$cost = floor(((($total/175)+1)*1000)*$updiff);
	$cost = $cost < 1000 ? 1000 : $cost;
	echo "[Planets Owned {$i} would Cost $ ".number_format($cost)." to Capture]<br />";
}
