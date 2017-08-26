<?php
include('db.php');
$sql 	= "ALTER TABLE `map` ADD `wifi` BOOLEAN NOT NULL DEFAULT TRUE;";

$db->exec($sql);
?>