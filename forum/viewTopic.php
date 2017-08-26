<?php
include('../bootstra.php');
include('../includes/parts/head.php');
include('../includes/parts/header.new.php');
error_reporting(E_ALL);
if(!isset($_GET['tid']))
{
	header('location:index.php');
}
if(!isset($_GET['page']))
{
	header("location:viewTopic.php?tid={$_GET['tid']}&page=1");	
}
if($base->topicExists($_GET['tid']))
{
$html .=$base->displayReplies($_GET['tid']);
echo $html;
}
else
{
	header('location:index.php');	
}
