<?php 
if(!isset($_SESSION['user']))
{

 }
else
{

}
$html .="
<div class='main-sequence'>";
if(!isset($_SESSION['user']))
{
	$html .="
<div class='welcome signup'>
	<div class='main-sign-up'>
	<h1>Welcome to <img src='../assets/imgs/logo-small.png' /></h1>
	<p>The Exodus Index is a registry of space-faring colonists who survived the fall of Earth.
	Enroll now to contribute toward humanity’s next chapter.
</p>
";
}
else
{
	$banks = $base->getUserBanks();
	$banks = array_map(function($num){return number_format($num,2);}, $banks);
	$html .= 
	"<div class='unihud'> 
	<div class='hud-item money'><div class='hud-item-label'>$</div><div class='hud-item-value'>{$banks['balance']}</div></div>
	<div class='hud-item money'><div class='hud-item-label'>E</div><div class='hud-item-value'>{$banks['energyCell']}</div></div>
	<div class='hud-item money'><div class='hud-item-label'>F</div><div class='hud-item-value'>{$banks['fuelCell']}</div></div>
	</div>		
	";
	$html .="<div class='welcome loggedin logo'>
	<img src='./assets/imgs/logo-small.png' >
	</div>";
}
if(!isset($_SESSION['user']) || (defined('login_options') && login_options != true))
{
$html .= "
	<p>Signing up is a zero-effort action</p>
	<div class='link-holder'>
	<a href='index.php?mode=register' class='do-your-part'>Sign Up</a> <a href='index.php?mode=login'  class='do-your-part'>Login</a>
	</div>";

#$html .= "<p>Registration is currently closed</p>";
}
 $html .="
	</div>
</div>";
if(isset($_SESSION['user']))
{
	$unread = $base->unreadmessages();
$alerts = $base->unreadNotifications($_SESSION['user']['uid']);
$html .= "<div class='new-menu'><nav class='left'>
<a href='../homeworld'>Home World</a>
<a href='../starmap.php' id='smbut'>StarMap</a>
<a href='../forum'>Forum</a>
<a href='../index.php'>Change Log</a>
</nav>
<nav class='right'>
<a href='settings.php'>Settings</a>
<a href='logout.php'>Logout</a>
<a href='?mode=pm'>Messages[{$unread}]</a>
<a href='index.php?mode=notes'>Notifications[{$alerts}]</a>


</nav></div>";
}
else
{
		
}
$html .="
</div>
";
?>