<?php
require_once('../bootstra.php');
#require_once('../includes/parts/head.php');
if($base->is_logged_in())
{
	echo "not loggedin";
}
else
{
	echo "oop";
}
/* The Menu System should probably converted to a drop down menu at some point */