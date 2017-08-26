<?php
$html .= "
<div id='container'>
<div id='header'>
<img src='/assets/imgs/REDDACT.png'>
<div class='forum menu'>
";
if(isset($_SESSION['user']))
{
	$alerts = $base->unreadNotifications($_SESSION['user']['uid']);
$html .="
<nav>
<a href='/homeworld'>Home World</a>
<a href='../starmap.php' id='smbut'>StarMap</a>
<a href='/forum'>Forum</a>
<a href=''>Something &trade;</a>
</nav>
<nav class='personal'>
<a href='?mode=pm'>Messages[0]</a>
<a href='../index.php?mode=notes'>Notifications[{$alerts}]</a>
<a href='settings.php'>Settings</a>
<a href='../logout.php'>Logout</a>
</nav>
</div>
</div>";
}
else
{	$html .= "
<nav>
<form action='login.php' method='post'>
<input type='text' name='username' />
<input type='password' name='password'>
<input type='submit' value='login'>
</form>
</nav>
<nav class='personal'>
<a href='?mode=register'>Register</a>
</nav></div></div>";
}
