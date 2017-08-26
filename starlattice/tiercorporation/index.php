<?php include('includes/parts/header.new.php');

echo $html; 
if(!SITE_LIVE and !isset($_GET['mode']))
{
	include('includes/parts/home/coming_soon.php');	
}
else
{
	#include('includes/parts/home/homepage.php');
}
?>
</div>
</body>
</html>