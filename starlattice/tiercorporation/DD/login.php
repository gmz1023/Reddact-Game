<?php
include('../includes/parts/header.new.php');
if($base->login($_POST['username'], $_POST['password']))
{
	header('location:index.php');	
}
?>