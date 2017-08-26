<?php
include('bootstra.php');
include('includes/parts/head.php');
include('includes/parts/header.new.php');
echo $html;
$root = 'includes/parts/settings/';
if(isset($_GET['mode']))
{
switch($_GET['mode'])
{
	default: include($root.'feats.php'); break;	
}
}
else
{
	include($root.'home.php');	
}
?>