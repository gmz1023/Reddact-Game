<?php
include('bootstra.php');
$x = $_POST['dtype'];
$action = $_POST['action'];
switch($action)
{
	case 'pos':
		$money = mt_rand(0,100000);
		$xp = mt_rand(0,200);
	break;
	case 'neg':
		$money = mt_rand(-3000,-100);
		$xp = 0;
	break;
}
		$base->increaseUserXP($_SESSION['user']['uid'], $xp);
		#$base->giveUserItem($_SESSION['user']['uid'], $l->reward); //* This will be set up soon as the DB is back up.	
		$base->updateCoffers($money, $_SESSION['user']['uid']);
return true;
