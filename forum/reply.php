<?php
include('../bootstra.php');
if(!isset($_GET['body']) || !isset($_SESSION['user']))
{
	#echo "Here's the error";
	header('Location: ' . $_SERVER['HTTP_REFERER']);

}
else
{
	if(strlen($_GET['body']) > 10)
	{
		if($base->insertReply($_GET['tid'], $_SESSION['user']['uid'], $_GET['body']))
		{
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	}
	else
	{
		echo "<h1>Post wasn't long enough</h1>";
	}	
}