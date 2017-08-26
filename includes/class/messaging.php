<?php
class messaging extends ai
{
/*
*
*
*	Messaging Class
*	Shoudl be cleaned up and secured; though as it is, it's pretty good.
*
*/
	function unreadmessages()
	{
		$sql = "SELECT  count(unread) as unread FROM privatemessages WHERE unread = '0' AND toUser = :uid;";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $this->uid);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row['unread'];
			} catch(PDOException $e) { echo $e->getMessage(); } 	
	}
	function displayPMs($uid)
	{
		$html = '';
		$sql = "SELECT 
					subject as title, 
					threadid as ID,
					(SELECT username FROM users WHERE uid = fromUser) as username 
				FROM privatemessages WHERE toUser = :uid";	
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $this->uid);
		try { 
			$que->execute(); 
			$html .= "<div class='forum topic-holder'>";
			while($row = $que->fetch(PDO::FETCH_ASSOC))
			{
				$html .= "<div class='topic'><a href='?mode=pm&tid={$row['ID']}'>{$row['title']}</a> FROM {$row['username']}</div>";	
			}
			} catch(PDOException $e) { echo $e->getMessage(); } 
		return $html;
	}
	function gatherPMreplies($tid,$offset, $limit)
	{
		$sql = "SELECT
					f.body,
					f.subject,
					f.uid as fromUser,
				FROM 
					privatemessages as f
				WHERE threadid = :tid
				LIMIT
					:limit
				OFFSET
					:offset";
		$que = $this->db->prepare($sql);
		$que->bindParam(':tid', $tid);
		$que->bindParam(':offset', $offset, PDO::PARAM_INT);
		$que->bindParam(':limit', $limit, PDO::PARAM_INT);
		$array = [];
		try { 
			$que->execute();
			while($row = $que->fetch(PDO::FETCH_ASSOC))
			{
				$array[] = $row;	
			}
			 }catch(PDOException $e) { echo $e->getMessage(); } 	
		return $array;
	}
	function displayMessage($uid, $tid)
	{
				$html = "<div class='forum'>";
		$sql = "SELECT 
					body,
					(SELECT username FROM users WHERE uid = fromUser) as username 
				FROM
					privatemessages
				WHERE
					threadid = :tid 
				AND
					(toUser = :uid
				OR
					fromUser = :uid2)";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		$que->bindParam(':uid2', $uid);
		$que->bindParam(':tid', $tid);
		try { 
			$que->execute(); 
			while($row = $que->fetch(PDO::FETCH_ASSOC))
			{
				$html .= "<div class='reply'><div class='userinfo'></div><div class='body'>{$row['body']}</div></div>";	
			}
		}catch(PDOException $e) { echo $e->getMessage(); } 	
		$html .= "</div>";
		return $html;		
	}
}

?>