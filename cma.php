<?php
header('Content-Type: application/json; charset=utf-8');
include('bootstra.php');
#$_POST['sid'] = 7698;
#$_POST['uid'] = 1;
#$_POST['method'] = 'mine';
#$_POST['z'] = 1;
$array = $base->CMA($_POST['uid'], $_POST['sid'], $_POST['method'], $_POST['z']);
#echo 'hi';
print_r( $array );
exit();
?>