<?php
if(isset($_GET['mode']))
{
	set_include_path('../includes/parts/CPANEL/parts');
	$file = $_GET['mode'].'.php';
	if(file_exists($file))
	{
		include($file);	
	}
	else
	{
		echo "no File";	
	}
}