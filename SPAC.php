<?php
header('Content-Type: application/json; charset=utf-8');
include('bootstra.php');
$array = $base->createUserRelay($_POST['x'],$_POST['y'],$_POST['sid']);
echo $array;
exit();
?>