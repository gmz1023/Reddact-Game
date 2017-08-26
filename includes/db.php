<?php
include(dirname(__FILE__).'/constants.php');
header('Cache-Control: no-cache');
header('Pragma: no-cache');
//////// Do not Edit below /////////
try {
$db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}
session_start();

?>