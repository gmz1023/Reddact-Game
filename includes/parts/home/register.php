<?php
if(isset($_GET['sub']))
{
		$_POST['validEmail'] = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); 
		$_POST['hX'] = mt_rand(-8,8);
		$_POST['hY'] = mt_rand(-8,8);
		$_POST['uver'] = $base->doesUserExist($_POST['username'], $_POST['email']);
		$_POST['avatar']= '/users/uploads/generic/avatar.png';
		$base->registerUser($_POST);
		$html.= "<div id='message'>";
		$html.= "<h1>{$_POST['message']}</h1>";
		$html.= "<p>If you are not redirected immediately, <a href='index.php'>click here</a></p>";
		$html.= "</div>";
}
else
{
	$html .="
    <div class='cta-register'>
	<a href='index.php?mode=signup'>Return To Info Page</a>
	<div class='cta-content'>
    <h1>User Registration Form</h1>
    <form action='?mode=register&sub=1' method='POST'>
    <label for='username'>Username:</label>
    <input name='username' id='username' type='text'>
    <label for='password'>Password:</label>
    <input name='password' type='password'>
    <label for='email'>Email:</label>
    <input name='email' type='email'>
    <input type='submit' class='rif-submit' value='register'>
    </form>
    </div>
	</div>";
}