<?php
$html = '';
include('bootstra.php');
define('DirectAccess', true);
include('includes/parts/head.php');
if(!isset($_SESSION['user']['uid']))
{
	header('location:index.php');
}
else
{
		$l = $base->progressPercent($_SESSION['user']['uid']);

				$html .= "<script type='text/javascript'> ";
						if(!isset($_SESSION['z']))
						{
							$html.= 'var z = 0';	
						}
						else
						{
							$html .= "var z = {$_SESSION['z']};";
						}
				$html .=
						"var uid = {$_SESSION['user']['uid']};
						var x = {$_SESSION['x']};
						var y = {$_SESSION['y']};
						var xp = {$l};
						$(document).ready(function(){ 
						loadMap(x, y,z);});";

						$html .= "var forcedEncounter = {$base->forcedEncounter};";
				$html .= 
						"</script>";
echo $html;
$coffers = $base->getUserBanks();
?>

<div id="interface">
  <div id="sidebar">
	<?php include('upgrade.php'); ?>
  </div>
  <div id="map">

  </div>
    <div id='sinfor' class='hidden'><div id='exit'><a>X</a></div><div id='holder'></div></div>
  	<div class='tutorial hidden'><h1>Welcome to Reddact</h1></div>
  <div id="navigation">
  <?php
  include('cmenu-new.php');
   ?>
  
  </div>
</div>
<?php } ?>