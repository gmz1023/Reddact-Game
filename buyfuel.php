<?php
header('Content-Type: application/json; charset=utf-8');
include('bootstra.php');
if(!isset($_POST['man']))
{
echo $base->replenishBanks($_POST['fuel'], false);
}
else
{
	if($base->replenishBanks($_POST['fuel'], $_POST['roam']))
	{
		header('Location: ' . $_SERVER['HTTP_REFERER']);	
	}
	else
	{
		header('Location: ' . $_SERVER['HTTP_REFERER']);	
	}
}
?>