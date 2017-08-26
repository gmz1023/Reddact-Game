<?php
class feats extends forum
{
	function __construct()
	{
		$this->featList = '';	
	}
	function moneyFeats($uid)
	{
		$balance = $this->getUserBanks();
		if($balance['balance'] >= 1000*1000)
		{
			$this->increaseFeat($this->uid, '1');	
		}
	}
	function featCompleted($uid, $feat)
	{
		$sql = "SELECT uid FROM userfeats WHERE uid = :uid AND feat = :feat LIMIT 1";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		$que->bindParam(':feat', $feat);	
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			if(empty($row['uid']) || !isset($row['uid']))
			{
				return false;	
			}
			else
			{
				return true;	
			}
			}catch(PDOException $e){ return false; }
	}
	function increaseFeat($uid, $feat)
	{
		$sql = "UPDATE userfeats SET level = level+1 WHERE uid = :uid AND feat = :feat";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		$que->bindParam(':feat', $feat);
		try { if($que->execute()) { return true; } else { return false; } }catch(PDOException $e) { return false; } 
	}
	function unlockFeat($uid, $feat)
	{
		if($this->featCompleted($uid, $feat))
		{
			$this->increaseFeat($uid, $feat);	
		}
		else
		{
			$sql = "INSERT INTO userfeats(uid,feat,level) VALUES (:uid, :feat, 1)";
			$que = $this->db->prepare($sql);
			$que->bindParam(':uid', $uid);
			$que->bindParam(':feat', $feat);
			try { 
				if($que->execute())
				{
					return true;
				}
				else
				{
					return false;	
				}
				}catch(PDOException $e) { echo $e->getMessage(); return false; }   	
		}
	}
	/* INsert Score Board Shiiit */
	function createScoreboard($uid)
	{
		$sql = "INSERT INTO userscores(uid, lastLogin)  VALUES (:uid, CURRENT_TIMESTAMP)";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		try { if($que->execute()){return true;} } catch(PDOException $e) { echo $e->getMessage(); }  	
	}
	function updatestarCount($uid,$pid)
	{
		
				$sql="
				UPDATE 
					userscores as no,
					userscores as oo
				SET 
					no.starsCapturedCurrent = no.starsCapturedCurrent+1,  
					oo.starsCapturedCurrent = oo.starsCapturedCurrent-1,
					no.starsCapturedMax = no.starsCapturedMax+1
				WHERE no.uid = '{$uid}' AND oo.uid = '{$pid}'";
		try { 
			$this->db->beginTransaction();
			if($this->db->exec($sql))
			{
				$this->db->commit();
				return true;
			}
			else
			{
				$this->db->rollback();
				die("somethign went wrong: scoreboard; echo {$uid}, {$pid}");
			}}catch(PDOException $e) { $e->getMessage();}
	}
	function increaseUserXP($uid, $xp)
	{
		$sql = "UPDATE user_coffers SET exp = CEIL(exp+:xp) WHERE uid = :uid";
		$que = $this->db->prepare($sql);
		$que->bindParam(":uid", $uid);
		$que->bindParam(":xp", $xp);
		try { $que->execute(); } catch(PDOException $e) { }	
	}
	function increaseUserLevel($uid, $nl)
	{
		$sql = "UPDATE user_coffers SET userLevel = userLevel+1, nextLevel = :nl WHERE uid = :uid";
		$que = $this->db->prepare($sql);
		$que->bindParam(":uid", $uid);
		$que->bindParam(":nl", $nl);
		try { $que->execute(); } catch(PDOException $e) { }
	}
	function userLevelMath($uid,$xp)
	{
		$li = $this->getUserLevel($uid);
		$xp = $xp/($li['CL']+1);
		$uX = ceil($li['XP']+$xp);
		if($uX-$li['NL'] >= 0)
		{
			$nextLevel = $li['NL'];	
			$nextLevel = floor($nextLevel+(($nextLevel/2)+$nextLevel));
			$this->increaseUserLevel($uid, $nextLevel);
		}
		
		$this->increaseUserXP($uid, $xp);
		return true;
	}
	function progressPercent($uid)
	{
		$l = $this->getUserLevel($uid);
		$per = ceil(($l['XP']/$l['NL'])*100);
		return $per;	
	}
	function getUserLevel($uid)
	{
		$sql = "SELECT userLevel as CL, nextLevel as NL, exp as XP FROM user_coffers WHERE uid = :uid";
		$que = $this->db->Prepare($sql);
		$que->bindParam(':uid', $uid);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row;
			} catch(PDOException $e) { echo $e->getMessage(); } 	
	}
}