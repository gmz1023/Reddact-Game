<?php
include('bootstra.php');
if(!isset($_POST['warpRelay']))
{
if(!isset($_SESSION['user']['x']) || !isset($_SESSION['user']['y']))
{
	header('location:index.php');	
}
switch($_GET['d'])
{
	case 'up':
	if($base->depleteCells(MOVE_COST, 'fuel'))
	{
	$_SESSION['y'] =$_SESSION['y']+1;
	}
	break;
	case 'down':
	if($base->depleteCells(MOVE_COST, 'fuel'))
	{
	$_SESSION['y'] = $_SESSION['y']-1;
	}
	break;
	case 'left':
	if($base->depleteCells(MOVE_COST, 'fuel'))
	{
	$_SESSION['x'] = $_SESSION['x']-1;
	}
	break;
	case 'right':
	if($base->depleteCells(MOVE_COST, 'fuel'))
	{
	$_SESSION['x'] = $_SESSION['x']+1;
	}
	break;	
	case 'warp':
	if($base->depleteCells(WARP_COST, 'energy') && $base->depleteCells(WARP_COST, 'fuel'))
	{
		$relayCount = $base->countTotalRelays();
		if(mt_rand(1,10000) <= $relayCount)
		{
			$relay = $base->getRelayCoords();
			if(empty($relay) || mt_rand(0,100) <= 9)
			{
				$_SESSION['y']= mt_rand(MAPMAX*-1,MAPMAX);
				$_SESSION['x']= mt_rand(MAPMAX*-1,MAPMAX);
				$_SESSION['z'] = mt_rand(0,40) <= 6 ? '1' : '0';	
			}
			else
			{
			$_SESSION['y'] = $relay['mapY'];
			$_SESSION['x'] = $relay['mapX'];
			$_SESSION['z'] = 0;
			}
		}
		else
		{
			$_SESSION['y']= mt_rand(MAPMAX*-1,MAPMAX);
			$_SESSION['x']= mt_rand(MAPMAX*-1,MAPMAX);
			$_SESSION['z'] = mt_rand(0,40) <= 10 ? '1' : '0';	
		}
	}
	else
	{
		$_SESSION['x'] = $_SESSION['x'];
		$_SESSION['y'] = $_SESSION['y'];
		$_SESSION['z'] = 0;
	}
	break;
	case 'home':
			$_SESSION['y'] = $_SESSION['user']['y'];
			$_SESSION['x'] = $_SESSION['user']['x'];
			$_SESSION['z'] = 0;	
	break;
}
if($_SESSION['x'] > MAPMAX)
{
	 $_SESSION['x'] = MAPMAX*-1;
}
if($_SESSION['x'] < MAPMAX*-1)
{
	$_SESSION['x'] = MAPMAX;
}
if($_SESSION['y'] > MAPMAX)
{
	 $_SESSION['y'] = MAPMAX*-1;
}
if($_SESSION['y'] < MAPMAX*-1)
{
	$_SESSION['y'] = MAPMAX;
}
}
else
{
	$sql = "SELECT rid, mapX,mapY FROM user_relays WHERE rid = :rid";
	$que = $db->prepare($sql);
	$que->bindParam(':rid', $_POST['rid']);
try { $que->execute(); 
		$row = $que->fetch(PDO::FETCH_ASSOC);
			$_SESSION['y'] = $row['mapY'];
			$_SESSION['x'] = $row['mapX'];
			$_SESSION['z'] = 0;	
}catch(PDOException $e) { echo $e->getMessage(); }

}
header('location:starmap.php');	
?>
