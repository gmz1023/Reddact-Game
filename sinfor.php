<?php
include('bootstra.php');
$sinfor = $base->sinfor($_POST['sid']); 
		$date1 = new DateTime('NOW');
$cost = $base->starCostMath($_SESSION['user']['uid']);
$costPretty = $base->numberAbbreviation($cost);
$sname = $_POST['sid'] != -666 ? $_POST['sid'] : 'nero';
?>

<div id='starinfo'>
  <h1>System Information</h1>
  <div class='row'>
    <div class='label'>Star ID</div>
    <div class='info'><?Php echo $sname; ?></div>
  </div>
  <div class='row'>
    <div class='label'>Current Owner</div>
    <div class='info'><?Php echo $sinfor['COName']; ?></div>
  </div>
  <div class='row'>
    <div class='label'>Resource</div>
    <div class='info'><?Php echo $sinfor['rName'].'('.$sinfor['resource'].')'; ?></div>
  </div>
  <?php if($sinfor['currentOwner'] <> 0) { ?>
  <div class='row'>
    <div class='label'>population</div>
    <div class='info'><?Php echo $base->planetPopulationMath($sinfor['population']); ?></div>
  </div>
<?php } ?>
  <div class='row'>
    <div class='label'>HabPlanets</div>
    <div class='info'><?Php echo $sinfor['habitablePlanets']; ?></div>
  </div>
<?php
	$coffers = $base->getUserBanks();
	switch($sinfor['currentOwner'])
	{
		case $_SESSION['user']['uid']:

		$date2 = new DateTime($sinfor['lastMine']);
		//* Difference for enabling the mine button
		$diff = $date1->diff($date2);
		$min = $diff->days * 24 * 60;
		$min += $diff->h * 60;
		$min += $diff->i;
		$sid = $_POST['sid'];
		if($min >= MINE_TIMEOUT)
		{
			$value = $base->miningReturns($sinfor['resource'],$sinfor['habitablePlanets'], $sinfor['population'], $_POST['sid']);
			$title = "It Will Cost ". MINE_DEPLETION ." Energy and ".(MINE_DEPLETION*1.5)." Fuel to Mine and you will recieve $ {$value}. To increase this number; invest in Technology & Economy upgrades as well as purchase Warehouse and Refineries";
			if(($coffers['energyCell'] - MINE_DEPLETION) >= MINE_DEPLETION 
			&& $coffers['fuelCell'] - (MINE_DEPLETION*1.5) >= 0)
			{
			echo "<div class='label button'>
			<button id='mine' class='mine' title='{$title}' data-sid='{$_POST['sid']}'>MINE</button>";
			//<a class='label' href='visitSystem.php?sid={$sid}&mode=home'>Visit System</a>
			echo "</div>";
			
			}
			else
			{
				echo 
				"<div class='label button'>
				<button id='mine' class='mine' title='{$title}' data-sid='{$_POST['sid']}' disabled>Insuffiecent Energy</button>
				";
					//<a class='label' href='visitSystem.php?sid={$sid}&mode=home'>Visit System</a>
				echo "</div>";
			}
		}
		else
		{
		$date1 = new DateTime('NOW');
		$date2 = new DateTime($sinfor['lastMine']);
		$diff = $date2->diff($date1);
		$comeback = abs(MINE_TIMEOUT-($diff->i));
		$seconds = $diff->s;
		$time = "Next Mine In {$comeback} Minutes";
		echo "<div class='label button'><b>{$time}</b>"; 
			  //<a class='label' href='visitSystem.php?sid={$_POST['sid']}'>Visit System</a>
			  echo "</div>";	
		}
		/*
			Begin the "Planet Upgrade Systems"
		*/
		echo "</div>";
		echo "<div id='SUHolder'>";
		include('supgrades.php');
		echo "</div>";
		break;
		/*case in_array($_POST['sid'], array(31,30)):
		echo "<a class='label' href='visitSystem.php?sid={$_POST['sid']}&mode=store'>Visit Store</a></div>";
		break;
		*/
		case 0:
		$title = "It Will Cost ". (MINE_DEPLETION*2.75)." Energy & ".(MINE_DEPLETION*2.5)." Fuel & $ {$costPretty} to Capture";
		if(($coffers['energyCell'] - MINE_DEPLETION*2.75) >= 0 
			&& $coffers['fuelCell'] - (MINE_DEPLETION*2.5) >= 0 && $base->canAfford(1000))
		{
			echo "<div class='label button'><button id='capture' data-sid='{$_POST['sid']}' class='capture' title='{$title}'>CAPTURE</button></div>";
		}
		else
		{
			echo 
			"<div class='label button'>
			<button id='capture' data-sid='{$_POST['sid']}' class='capture disabled' disabled title='{$title}'>INSUFFICENT RESOURCES</button>
			</div>";
		}
		break;
		case -666:
		
		break;
		default:
		$title = "It Will Cost $". $costPretty ." & ".(CONQUEST_COST*2)." Energy &".(CONQUEST_COST)." to Mine";
		if(
			($coffers['balance'] - $cost) >= 0
			 && 
			($coffers['fuelCell'] - CONQUEST_COST) >= 0 
			&& ($coffers['energyCell'] - CONQUEST_COST*1.5) >= 0 
			)
		{
			$chance = $base->chance($_SESSION['user']['uid'], $sinfor['currentOwner'], $_POST['sid']);
			if($chance == 0)
			{
				$ext = "This battle will be a stalemate";
			}
			else
			{
				$chanceP = number_format(($chance),0);
				if($_POST['sid'] == -666)
				{
					$ext = 'g͏̸̙̥̪̖͖̼̹ͅͅn̷̨͜͟͏͕̮̣̭̯̟̜̘̙̭̟̥̼͙̦̺̞̤̯á͖̯̝͈̦̕͘t̢͕̙̺͕̬͖̮͉̼͈̻̜̕a̧̛̲̹͙̻͕̠̞̯͕̮͞ ̵̢͚̻̮͉̙͕̹̠̜͙̞͖̯̲̠̞͉͟͢͟n̵̶̸̤̱̫͉͜͝e̫̤͕͖͇̝̲̕ ̡̰͖̹͔̘̕͟͠͡ò̭͖̺̜̪̖̕b͏̢҉҉̣̖͎̦̟̩͇͎l̵̶͙̝͈̩̘̲̩̀i͏̷̸͓̼͕̘͖̲̗̘̣͓̥̘̟͕̪̬̖͜͡v̵̧̢͎̹̦̫̗͚̞̣̘̘̟̦̲͍̫̳ͅͅi̷̧͎̙̺̺̥̘̹͉͉̤͖̖͍̙͇̩͙͡ͅo̵̙̬̭͓̮͍͕̤͖̣̝͎͟';

				}
				else
				{
				$ext = $chance > 50 ? "You are Likely to win this battle {$chanceP}%" : "you are unlikely to win this battle {$chanceP}%";
				}
			}
		echo "<div class='label button'><button id='attack' class='attack' data-sid='{$_POST['sid']}' title='{$ext}'>ATTACK</button></div>";
		}
		else
		{
		echo	"<div class='label button'><button id='attack' data-sid='{$_POST['sid']}' class='attack disabled' disabled title='not enough funds'>ATTACK</button></div>";
		}
		break;
	}


?>

</div>
