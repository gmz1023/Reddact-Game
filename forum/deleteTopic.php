<?php
		include('../bootstra.php');
		include('../ARchive-New/includes/parts/head.php');
$base->deleteTopic($_GET['tid']);
header('location:index.php');