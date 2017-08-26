<?php
require_once('bootstra.php');
if(isset($_POST['nid']))
{
	if($base->markasread($_POST['nid'],false, $_SESSION['user']['uid']))
	{
	header('location:index.php?mode=notes');		
	}
}
else
{
	if($base->markasread(false,true, $_SESSION['user']['uid']));
	{
		header('location:index.php?mode=notes');	
	}
}