<?php
include('bootstra.php');
$value =77; //mt_rand(1,300);
$hab = 8;
		#$upgrade = $this->getSpecificUpgrade('offense', $uid);
		#$count = $this->activeTotalControled($uid);
echo "<ul>";
for($i = 1; $i < 500; $i++)
{
		$upgrade = $base->getSpecificUpgrade('offense', 1);
		#$count = $this->activeTotalControled($uid);
		$total = $i+1;
		$cost = floor((($total/175)+1)*1000);
		echo "[Planets Owned {$i} would Cost $ {$cost} to Capture]<br />";
}
