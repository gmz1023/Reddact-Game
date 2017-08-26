<?php
class ai extends encounters
{
	var  $xml;
	function __construct()
	{
		
	}
	function getAIspread()
	{
		$sql = "SELECT max(sid) as high, min(sid)as low, count(sid) AS total  FROM map WHERE currentOwner = -1";
		$que = $this->db->prepare($sql);
		try { 
				$que->execute(); 
				$row = $que->fetch(PDO::FETCH_ASSOC);
				return $row;
		}catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	function willItSpread()
	{
		$sid = $this->getAIspread();
		$aid = -1;
		$spd = $this->getVariables('stlupdate');
	#	$spd = $spd['stlupdate'];
		$high = $sid['high'];
		if ($sid['high'] + $spd > MAX_STAR) {
			$high = $sid['high'] + $spd;
		}
		$low = $sid['low'];
		if ($sid['low'] + $spd > MIN_STAR) {
			$high = $sid['low'] + $spd;
		}
		echo "<Pre>";
		#$sid['newHigh'] = $high;
		#$sid['newLow']  = $low;
		$sql = "UPDATE map SET currentOwner = {$aid} WHERE starType = 2 AND currentOwner = 0 AND sid BETWEEN {$low} and {$high} LIMIT 3";
		if($sid['total'] >= 1)
		{
			$que = $this->db->prepare($sql);
			$this->db->beginTransaction();
			try { 
				if($que->execute()) 
					{
						#echo 'hi';
						$count = $que->rowCount();
						echo $count;
						if($count > 0)
						{
							$this->db->commit();	
							echo "More Stars!";
							$this->updateVariables('stlupdate','18');
						}
						else
						{
							$this->db->rollBack();
							$this->updateVariables('stlupdate','32');
						}
						
					} 
				else
				{
					echo "Error";
					return false;
				}
			}catch(PDOException $e) 
			{ 
				die($e->getMessage());
			}
		}
	}

}