<?php 
$html ="<!DOCTYPE html>
<html>
<head>
<title>Reddact Game</title>
<meta name='keywords' content='reddact, reddact game, game, 4x, Haven, story, webbased, free to play, free' /> 
<link rel='stylesheet' href='../assets/primary/base.css' type='text/css'>
<link rel='stylesheet' href='../assets/jquery/jquery-ui.css' type='text/css'>
<script src='../assets/jquery.js' type='text/javascript'></script>
<script src='../assets/jquery/jquery-ui.js' type='text/javascript'></script>
<script src='../assets/jquery/jquery.cookie.js' type='text/javascript'></script>

";
if(isset($_SESSION['firstTime']))
{
	$html .="
		<script> var newUser = {$_SESSION['firstTime']}; </script>";
}
else
{
	$html .="<script> var newUser = 0; </script>";
}
if(isset($_SESSION['user']) && $_SESSION['user']['uid'] == 1)
{
$html.="<script src='../assets/reddact.js' type='text/javascript'></script>
</head>
<body>";
}
else
{
$html.="<script src='../assets/reddact.js' type='text/javascript'></script>
</head>
<body>";	
}
/* 
	There needs to be some sort of standardized "Resource" bar across all pages; This is something I know but
	something that needs to be done already. The "Context_Menu" on the map side needs to be dropped and the ubanks	
	needs to be added to head.php
*/

?>
