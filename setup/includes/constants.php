<?php
/*
Database Constants
*/
date_default_timezone_set('America/New_York'); 
define('STATUS', 'local');
define("siteName", "Reddact");
switch(STATUS)
{
case "local":
define("DB_HOST", 'localhost');
define("DB_USER", 'root');
error_reporting(0);
define("DB_PASS", '');
define("DB_NAME", "reddact");
define("MISSION_RATIO",400);
break;
	case 'live':
		define("DB_HOST",'localhost');
		define("DB_PASS", '4Da4LbVpOVRv');
		define("DB_USER",'reddact_base');
		define("DB_NAME", 'reddact');
		define("MISSION_RATIO",40000);
		break;
}
?>