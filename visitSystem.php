<?php
include('bootstra.php');
include('includes/parts/head.php');
include('includes/parts/header.new.php');
if(isset($_GET['sid']) && is_numeric($_GET['sid']))
{
	$sid = $_GET['sid'];
	
	echo $html;
	$base = new base($db);
	$sinfor = $base->sinfor($_GET['sid']);
	echo "<div id='ls'>";
	if($base->is_logged_in())
	{
		$page = isset($_GET['mode']) ? $_GET['mode'] : '0';
		$path = 'includes/parts/vs/';
		$link = "starmap.php";
	switch($page)
	{
		case 'store':
		echo "<nav><a href='?sid={$sid}&mode=home'>System Home</a> |<a>Store</a> | <a href={$link}>Back to Map</a>";
		include($path.'store.php');
		break;
		default:
		echo "<nav><a>System Home</a> |<a href='?sid={$sid}&mode=store'>Store</a> | <a href={$link}>Back to Map</a>"; 
		include($path.'home.php');
		break;	
	}
	}
	else
	{
		header('location:index.php');	
	}
}
else
{
	header("location:index.php");	
}
echo "</div>";

