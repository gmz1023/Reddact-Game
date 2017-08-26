<?php include('header.php'); 
echo $html;
	echo "<div id='hw'>";
    if(isset($_GET['mode']))
    {
         $file = $_GET['mode'];
            $path       = "{ABSPATH}/parts/{$file}.php";
           if (file_exists($path)) {
               require_once($path);
			   
           } else {

               die("The Page Requested could not be found!");
           }
    } 
	else
	{
		echo "Hello World!";
		require_once('parts/home.php');	
	}
	echo "</div>";
	?>