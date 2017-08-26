<?php
include('bootstra.php');
include('includes/parts/head.php');
ini_set('display_errors', 'On');
error_reporting(E_ALL);
if($base->userLogin($_POST['username'], $_POST['password']))
{
	$_SESSION['user']['z'] = 0;
	if(isset($_SESSION['user']['x']) && isset($_SESSION['user']['y']))
	{
		$_SESSION['x'] = $_SESSION['user']['x'];
		$_SESSION['y'] = $_SESSION['user']['y'];
		$_SESSION['z'] = $_SESSION['user']['z'];
	}
	else
	{
		$link = "index.php";
	}
	
	header('location:starmap.php');	
}
else
{
	header('location:index.php?login=fail');	
}
?>