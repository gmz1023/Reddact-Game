<?php
#die("<h1>Down For Maintance</h1>");
include('bootstra.php');
ob_start();
require_once(ABSPATH.'/nbbc.php');
include(ABSPATH.'/parts/head.php');
include(ABSPATH.'/parts/header.new.php');
		$html .= "<div class='holder'>";
    if(isset($_GET['mode']))
    {
         $file = $_GET['mode'];
            $path       = ABSPATH."/parts/home/{$file}.php";
           if (file_exists($path)) {
               require_once($path);

           } else {
				echo "file doesn't exists";
              include(ABSPATH.'/parts/home/frontpage.php');
           }
    } 
	else
	{
			if(!isset($_SESSION['user']['uid']))
			{
				include(ABSPATH.'/parts/home/signup.php');	
			}
	        elseif(file_exists(ABSPATH.'/parts/home/frontpage.php'))
			{include(ABSPATH.'/parts/home/frontpage.php');}
			else{ echo "file doesn't exists"; } 
	}
	$html .= "</div>";
ob_flush();
	echo $html;	

?>
