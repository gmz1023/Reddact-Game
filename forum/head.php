<?php
define("FPATH", dirname( dirname(__FILE__) ));
echo FPATH;
exit;
#require_once("../bootstra.php")or die('ERROR');
#include(FPATH."/bootstra.php");
if(file_exists(FPATH.'/includes/parts/head.php'))
{
require_once(FPATH.'/includes/parts/head.php');
}
else
{
}
if(!$base->is_logged_in())
{
	header('location:../index.php');	
}
$alerts = $base->unreadNotifications($_SESSION['user']['uid']);
$html .= "
<div id='container'>
<div id='header'>
<img src='/assets/imgs/REDDACT.png'>
<div class='forum menu'>
<nav>
<a href='../homeworld'>Home World</a>
<a href='index.php'>Board Index</a>
<a href=''>Something &trade;</a>
</nav>
<nav class='personal'>
<a href=''>Messages[0]</a>
<a href='../index.php?mode=notes'>Notifications[{$alerts}]</a>
<a href='../settings.php'>Settings</a>
<a href='../logout.php'>Logout</a>
</nav>
</div>
</div>";
