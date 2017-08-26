<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
require_once(dirname(__FILE__).'/includes/db.php');
$base = new base($db);

if(file_exists(ABSPATH.'/nbbc.php'))
{
	
require_once(ABSPATH.'/nbbc.php');
if(!defined('MAPMAX') && isset($_SESSION['user']))
{
require_once(ABSPATH."/game_rules.php");
}
}
else
{
	echo "ERROR";	
}
include(dirname(__FILE__).'/includes/gamevar.php');
?>
