<?php
#echo "<h1>Coming Soon!</h1>";
#exit;
include('../bootstra.php');
include('../includes/parts/head.php');
include('../includes/parts/header.new.php');
error_reporting(E_ALL);

$html .= $base->displayForum();
include('foot.php');
echo $html;