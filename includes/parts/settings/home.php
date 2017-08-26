<div class='hwwelcome'>
<h1>Settings Page</h1>
<form name='security' method='post'>
<table>
<tr>
    <td><label for='cPass'>Current Password</label></td>
    <td><input type='password' name='cPass'/></td>
</tr>
<tr>
    <td><label for='nPass'>New Password</label></td>
    <td><input type='password' name='nPass[]' /></td>
</tr><tr>
<td><label for='nPass'>New Password, Again</label></td>
<td><input type='password' name='nPass[]' /></td>
</tr>
<tr><th><input type='submit' value='change password'></th></tr>
</table>


</form>

<?php

if(isset($_POST['cPass']))
{
	if($_POST['nPass'][0] == $_POST['nPass'][1])
	{
		$base->changePassword($_POST['cPass'],$_POST['nPass']);	
	}
	else
	{
		echo "Passwords did not match";	
	}
}

?>
</div>