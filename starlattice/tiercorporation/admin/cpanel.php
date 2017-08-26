<?php
if(!defined('ADMIN'))
{
	die("<h1>Invalid Security Clearance</h1>");
}
else
{
	echo $html;
		?>

<div class='admin'>
<a href='../../../ARchive-New/starlattice/tiercorporation/admin/?mode=upgrade'>Add Upgrades</a>
<a href=''>Alter Users</a>
<a href=''>Others</a>
</div>
<?php 
switch($_GET['mode'])
{
	case 'upgrade':
	include('upgrades.php');
	break;	
}
}
 ?>