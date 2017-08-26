<?php
/*
Database Constants
*/
date_default_timezone_set('America/New_York'); 
define('STATUS', 'live');
define('SITE_LIVE', false);
switch(STATUS)
{
case "local":
define("DB_HOST", 'localhost');
define("DB_USER", 'root');
error_reporting(0);
define("DB_PASS", '');
define("DB_NAME", "reddact");

break;
case "live":
define("DB_HOST", 'localhost');
error_reporting(E_ALL);
define("DB_USER", 'game');
define("DB_PASS", 'Xse4aT7fBSbM0PZg');
define("DB_NAME", "tier_corporation");
break;
case 'dev':
define("DB_HOST", 'reddactgame.com');

define("DB_USER", 'game');
define("DB_PASS", 'Xse4aT7fBSbM0PZg');
define("DB_NAME", "tier_corporation");
break;
case 'down':
echo "<h1>Site Down For Maintance</h1>";
exit;
break;
}
/* GAme Information Constants */
define('VERSION_SEQ', "SUPER ALPHA 3.0.01");

/* Simulation Constants */
define("TIME_STEP", '+10 day');
define('ABSPATH',dirname(__FILE__));
?>