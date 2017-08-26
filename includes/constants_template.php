<?php
/*
Database Constants
*/
date_default_timezone_set('America/New_York'); 
define('STATUS', 'live');
define("siteName", "Reddact");
switch(STATUS)
{
case "local":
define("DB_HOST", 'localhost');
define("DB_USER", 'root');
error_reporting(0);
define("DB_PASS", '');
define("DB_NAME", "reddact");

break;
	case 'live':
		define("DB_HOST",'localhost');
		define("DB_PASS", '');
		define("DB_USER",'reddact_base');
		define("DB_NAME", 'reddact');
		break;
}
/* GAme Information Constants */
define('VERSION_SEQ', "SUPER ALPHA 3.0.01");

/* Simulation Constants */
define("TIME_STEP", '+10 day');
define('ABSPATH',dirname(__FILE__));
include('functions.php');

/* Game Related Constants */
define('TIERID', 30);
define('HEPID', 31);
/* Rest of the Rules */
define("MAPMAX", 2);
define("MISSION_RATIO",100000000);
define('TECHLEV', 1); 
/* This some how is supposed to tie with the users current tech level. But it won't work if they're not signed in and is causing issues. 
define("MINE_TIMEOUT", 3);
/* DEPLETION COSTS FOR FUNCTIONS */
define('MINE_DEPLETION', 50); // Used as a base line for many of the CMAC functions
define("CONQUEST_COST", 100);
define("STAR_LATTICE", false);
/* WARP SETTINGS */
define('WARP_COST', 600);
define('WARP_TECH_LVL', 10);
define('WARP_TIP', 'Transport yourself to a random sector of space');
define('HOME_TIP', 'Phone Home');
define('MOVE_COST', 33);
/* COSTS */
define('ENERGY_COST', TECHLEV*775);
define('FUEL_COST', TECHLEV*550);
define('RELAY_COST', 1000000);
/* LIMITS */
define("POPULATION_MAX", 1000);
define("POPULATION_PERFECT", 750);
define("POPULATION_MIN", 500);
/* CMAC EXP POINTS */
define("CPT_XP", 200);
define("WAR_XP", 100);
define("MINE_XP", 100);
define("MINE_TIMEOUT",3);
define("UPGRADE_XP", 150);
/* MISC EXP POINTS */
define("POST_XP", 10);
/* Map Limits */

?>