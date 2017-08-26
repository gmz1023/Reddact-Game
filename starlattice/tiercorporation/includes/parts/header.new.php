<?php
include($_SERVER['DOCUMENT_ROOT'].'/includes/db.php');
$base = new base($db);
$html = "<html>
<head>
<title>Tier Corporation</title>";
$html .= "<link rel='stylesheet' href='../assets/css/style.css'>";
$html .= '<script src="https://use.typekit.net/xvd7dfx.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>';
$html .="</head>";

$html .= "<body>";
$html .= "<div class='container'>";

include($_SERVER['DOCUMENT_ROOT'].'/includes/parts/head.php');
