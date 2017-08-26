<?php
include('../includes/parts/header.new.php');
echo $html;
if(!isset($_SESSION['user']['uid']) and !isset($_GET['debug']))
{
	include('../includes/parts/login.php');	
}
else
{
	include('coeus/main.php');	
}
?>

