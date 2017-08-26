<?php
include('../bootstra.php');
include('../includes/parts/head.php');
include('../includes/parts/header.new.php');
error_reporting(E_ALL);
if($base->forumExists($_GET['fid']))
{
$html .= $base->displayTopics($_GET['fid']);
echo $html;
}
else
{
	header('location:index.php');	
}
