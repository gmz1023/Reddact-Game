<?php
require_once('bootstra.php');
if(!isset($_POST['type']))
{
	return false;	
}
else
{
	
	switch($_POST['type'])
	{
		case 'upgrade':
		echo $base->upgrade($_POST['upgrade']);;
		break;
		case 'supgrade':
		echo $base->upgradeSystem($_POST['sid'], $_POST['upgrade']);
		break;
	}
}
	
?>