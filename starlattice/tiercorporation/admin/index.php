<?php
include('../includes/parts/header.new.php');
if($base->isAdmin())
{
	define('ADMIN', true);
	include('cpanel.php');
}
else
{
	header('location:../index.php');	
}