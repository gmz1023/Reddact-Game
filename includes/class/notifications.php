<?php
class notifications extends messaging
{
	/* This System is Super Crude, needs to be changed in the near future */
	function unreadNotifications($uid)
	{
		$sql = "SELECT count(nid) as unread FROM notifications WHERE unread = 0 AND uid = :uid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		try { 
				$que->execute(); 
				$row = $que->fetch(PDO::FETCH_ASSOC);
				return $row['unread'];
				} catch(PDOException $e) { echo $e->getMessage(); } 	
	}
	function gatherNotifications($uid)
	{
		$sql = "SELECT * FROM notifications WHERE unread = 0 AND uid = :uid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		$array = [];
		try { 
				$que->execute(); 
				while($row = $que->fetch(PDO::FETCH_ASSOC))
				{
					$array[] = $row;	
				}

				} catch(PDOException $e) { echo $e->getMessage(); } 
		return $array;
	}
	function insertNotification($uid, $note)
	{
		$sql= "INSERT INTO notifications(uid, text) VALUES (:uid, :note)";
		$que= $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		$que->bindParam(':note', $note);
		try { if($que->execute()){ return true;} } catch(PDOException $e) { echo $e->getMessage(); }  	
	}
	function gatherMessages($uid)
	{
		
	}
	function displayMessages($uid)
	{
		$array = $this->gatherMessages($uid);
		$html = "<form action='noteAction.php' method='post'>";
		$html  .= "<table id='notifications'><tr><th colspan=6>User Notifications</th></tr>";

		$html .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><input type='checkbox' onClick='toggle(this)' name='all' value='true'/> Clear All<br/></td></tr>";
		if(empty($array[0]))
		{
			$html .= "<tr><th colspan='7'>No New Messages</th></tr>";	
		}
		else{
		foreach($array as $x=>$v)
		{
			$html .= "
			<tr><td class='r1'><img src='' width='25px' height=25px'></td><td class='r2'>{$v['text']}</td><td class='r1'>&nbsp;</td><td class='r1'>&nbsp;</td><td class='r1'><Input type='checkbox' name='nid[]' value='{$v['nid']}'></td></tr>";	
		}
		$html .= "<tr><th colspan='6'><input type='submit' value='Mark selected as read'></th></tr>";
		}
		return $html;
	}
	function displayNotifications($uid)
	{
		$array = $this->gatherNotifications($uid);
		$html = "<form action='noteAction.php' method='post'>";
		$html  .= "<table id='notifications'><tr><th colspan=6>User Notifications</th></tr>";

		$html .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><input type='checkbox' onClick='toggle(this)' name='all' value='true'/> Clear All<br/></td></tr>";
		if(empty($array[0]))
		{
			$html .= "<tr><th colspan='7'>No New Notifications</th></tr>";	
		}
		else{
		foreach($array as $x=>$v)
		{
			$html .= "
			<tr><td class='r1'><img src='' width='25px' height=25px'></td><td class='r2'>{$v['text']}</td><td class='r1'>&nbsp;</td><td class='r1'>&nbsp;</td><td class='r1'><Input type='checkbox' name='nid[]' value='{$v['nid']}'></td></tr>";	
		}
		$html .= "<tr><th colspan='6'><input type='submit' value='Mark selected as read'></th></tr>";
		}
		return $html;
	}
	/* Mark as Read */
	function markasread($array, $all, $uid)
	{
		if($all == true)
		{
			$sql = "UPDATE notifications SET unread = 1 WHERE uid = :uid";
		}
		else
		{
		$ind = "'".implode("','", $array)."'";
		$sql = "UPDATE notifications SET unread = 1 WHERE nid IN ({$ind}) AND uid = :uid";
		}
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		try { if($que->execute()) { return true; } } catch(PDOException $e) { echo $e->getMessage(); } 
		
	}
		
}

?>