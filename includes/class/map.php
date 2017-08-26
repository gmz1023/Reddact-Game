<?php
class map extends warp
{
//* This function might be better off in Finance -2016
//* I agree, but I refuse to move it on prinicable -2017
	function lastMine($lm)
	{
		$date1 = new DateTime('NOW');
		$date2 = new DateTime($lm);
		//* Difference for enabling the mine button
		$diff = $date1->diff($date2);
		$min = $diff->days * 24 * 60;
		$min += $diff->h * 60;
		$min += $diff->i;	
		return $min;
	}
/*

	System Information  IS RIGHT HERE
	

*/
	function sinfor($sid)
	{
		if($sid > 0)
		{
		$sql = "SELECT * FROM map WHERE sid = :sid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':sid', $sid);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			$row['COName'] = $this->getUsername($row['currentOwner']);
			$row['rName'] = $this->getResourceName($row['resource']);
			return $row;
			} catch(PDOException $e){ echo $e->getMessage(); }		
		}
		else
		{
			$row['sid'] = $sid;
			$row['currentOwner'] = -1;
			$row['COName'] = "U̲͇̙̜̳ͯͯ̌̀͑ͨ͋ň̴̦͇̘͔͐̒̍ͮͧ̉k̟̾ͫ̃ͮ̔̅n̻͆̍ͧoͣw̸̪͎̫̯͎̯̩̐̏͐̓ͥn̻̯̫͈̏ͬ̊ͦͣ̅͛͟";
			$row['resource'] = '99';
			$row['rName'] = 'Tainted';
			$row['population'] = mt_rand(999,9999);
			$row['habitablePlanets'] = 9;
			return $row;
		}
	}
//* Display the Map
	function displayMap($x, $y, $z)
	{
		/* I shoudl really rewrite this. It looks like crap,'16 what the hell were you doing? There's so many differnt thigns that could make this better */
		$dtype ='';
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
		$sql = "SELECT starType,sid,currentOwner,lastMine,(SELECT resourceName FROM resources WHERE rid = resource) as rname FROM map WHERE mapX = :x AND mapY = :y";
		$que = $this->db->prepare($sql);
		$que->bindParam(':x', $this->x);
		$que->bindParam(':y', $this->y);
		try { 
			$que->execute(); 
			$html = "";
			$x = 0;
			$cnt = 0;
			$colnum = 0;
			$col = 1;
			$html .= "<div class='column $col'>";
			while($row = $que->fetch(PDO::FETCH_ASSOC))
			{
				if($cnt <= 15)
				{
					$cnt = $cnt+1;
				}
				else
				{
										$col = $col+1;
					$html .= "</div><div class='column $col'>";	

					$cnt = 1;
					

				}
				if($z != 0)
				{
					$class = 'hell ';
					$id = -666;
					switch($row['starType'])
					{
						case 1:
						if(mt_rand(1,2) == 9)
						{
							//* Story Driven Elements Here
							$type = 'trans';					
						}
						else
						{
							$type = 'nullSpace';
							$rname ='';
						}
						break;
						case 2: $type = 'star'; 
								$rname = $z != 0 ? 'unknown element' : $row['rname'];
						break;	
					}
				}
				else
				{
					$class = '';
					$id = $row['sid'];
					switch($row['starType'])
					{
						case 1:
						if(mt_rand(1,MISSION_RATIO) <= 1)
						{
							//* Story Driven Elements Here
							
							$count = $this->enCounter($x,$y);
							$count = $count-1;
							$type = 'trans';	
							$rname = 'Transmission';
							$dtype = mt_rand(0,$count);			
						}
						else
						{
							if($this->isRelay($row['sid']))
							{
								$type = 'warp';
								$rname = '';	
							}
							else
							{
							$type = 'space';
							$rname ='';
							}
						}
						break;
						case 2: $type = 'star'; 
								$rname = $z != 0 ? 'unknown element' : $row['rname'];
						break;	
					}
				}

				if($type == 'star')
				{
				switch($row['currentOwner'])
				{

					case $this->uid:
					$date1 = new DateTime('NOW');
					$date2 = new DateTime($row['lastMine']);
					//* Difference for enabling the mine button
					$diff = $date1->diff($date2);
					$min = $diff->days * 24 * 60;
					$min += $diff->h * 60;
					$min += $diff->i;
					if($min >= 5)
					{
						$class = ' owned unmined';
					}
					else
					{
						$class = ' owned';	
					}
					break;
					case 30:
					$class = ' store';
					break;  
					case 0:
					$class =' unowned';	
					break;
					case -1:
					$class = ' SL';
					break;
					default:
					$class = ' enemy';
					break;
				}
				}
				else
				{ $class = ''; } 
				$html .= "<div class='{$type}{$class}' id='{$id}' title='{$rname}' data-mtype='{$dtype}'>&nbsp;</div>";	
			}
			}catch(PDOException $e) { echo $e->getMessage(); }	
			return $html;
	}
}
?>
