<?php
class forum extends inventory
{
	function __construct()
	{
		/* I really, really, really need to work on this, but god damn if I can be bothered to actually do it;
			I can't use PHPBB because I hate that system and I need something that will be 100% intergrated with the current system (And that is modable enough for future features). I really wish i still had access to the old reddact forum system because that had 95% of everything i need. - '16
			
			I really, really, really wish you'd kept the old system too -- because I know how that one worked. -17
		*/
	}
	function isAdmin()
	{
		
		$this->userPerm = $this->userPermission($this->uid);
		if($this->userPerm['user'] >= 3)
		{
			return true;
		}
		else
		{
			return false;	
		}
	}
	function isValid($item)
	{
		if(strlen($item) >= 1 && !empty($item))
		{
			return true;	
		}
		else
		{
			return false;	
		}
	}
	function deleteTopic($tid)
	{
		if($this->isAdmin() || $this->topicOwner($tid) == $this->uid)
		{
		$this->db->setAttribute( PDO::ATTR_EMULATE_PREPARES, true );
		$sql = "DELETE FROM forum_topics WHERE topicID = :tid;";
		$sql .= "DELETE FROM forum_replies WHERE tid = :tid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':tid', $tid);
		try { $que->execute(); } catch(PDOException $e) { echo $e->getMessage(); } 
		}
		else
		{
			header('location:index.php');	
		}
			
	}
	function forumExists($fid)
	{
		$sql = "SELECT count(forumID) as total FROM forum_name WHERE forumID = :fid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':fid',$fid);
		try { $que->execute(); 
				$row = $que->fetch(PDO::FETCH_ASSOC);
				return $row['total'] >= 1 ? true : false;
		} catch(PDOException $e) { echo $e->getMessage(); }
	}
	function insertTopic($fid, $uid, $body, $title)
	{
		if($this->forumExists($fid))
		{
		if($uid == 1)
		{
		$sql = "
				INSERT INTO forum_topics(forumID, topicTitle, topicOwner, postType) VALUES (:fid, :title, :uid,3);";
		}
		else
		{
			$sql = "
				INSERT INTO forum_topics(forumID, topicTitle, topicOwner, postType) VALUES (:fid, :title, :uid, 1);";	
		}
		$que = $this->db->prepare($sql);
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/nbbc.php');
		$this->bbcode = new BBcode; //* I need to look into it.
		$title = $this->bbcode->Parse($title);
		$que->bindParam(':title', $title);
		$que->bindParam(':uid', $uid);
		$que->bindParam(':fid', $fid);
		try { 
			if($que->execute())
			{
				$fid = $this->db->lastInsertId();
				if($this->insertReply($fid, $uid, $body))
				{
					return $fid;	
				}
			}} catch(PDOException $e) { echo $e->getMessage(); } 
		}else { echo "You can't do that!"; }
	}
	function topicExists($tid)
	{
		$sql = "SELECT count(topicID) as total FROM forum_topics WHERE topicID = :tid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':tid',$tid);
		try { $que->execute(); 
				$row = $que->fetch(PDO::FETCH_ASSOC);
				return $row['total'] == 1 ? true : false;

		} catch(PDOException $e) { echo $e->getMessage(); }	
	}
	function insertReply($tid, $uid, $body)
	{
			
		if($this->topicExists($tid))
		{
			if($this->isValid($body))
			{

			require_once($_SERVER['DOCUMENT_ROOT'].'/includes/nbbc.php');
			$this->bbcode = new BBcode;
			$body = $this->bbcode->Parse($body);
			$sql = "INSERT INTO forum_replies(bodyText, uid, tid) VALUES(:body, :uid, :tid)";
			$que = $this->db->prepare($sql);
			$que->bindParam(":tid", $tid);
			$que->bindParam(":body", $body);
			$que->bindParam(":uid", $uid);
			try { 
				if($que->execute()) { 
					if($this->userLevelMath($uid,POST_XP))
					{
						return true; 
					}
				}
				else { return false;} }
			catch(PDOException $e) { echo $e->getMessage(); } 
			}
			else
			{
				die('invalid reply length');	
			}
		}else{ echo "You can't do that!"; exit; }
	}
	function frontPage()
	{
		$sql= "SELECT 
				topicTitle as title,
				topicID,
				(SELECT bodyText FROM forum_replies WHERE tid = topicID ORDER BY rid ASC LIMIT 1) as body
			  FROM
			  	forum_topics
				WHERE forumID IN (1,7) AND postType IN (3,4) AND topicOwner = 1
				ORDER BY postType DESC, topicID DESC";
		$que = $this->db->prepare($sql);
		try { 
			$que->execute();
			$html = '';
			while($row = $que->fetch(PDO::FETCH_ASSOC))
			{
				$html .= "
				<article>
				<h1>{$row['title']}</h1><p>{$row['body']}</p>
				<a href='forum/viewTopic.php?tid={$row['topicID']}&page=1'>Join the conversation!</a>
				</article>";
			}
			 } catch(PDOException $e) { echo $e->getMessage(); } 	
			return $html;
	}
	function topicOwner($tid)
	{
		$sql = "SELECT topicOwner FROM forum_topics WHERE topicID = :tid LIMIT 1";
		$que = $this->db->prepare($sql);
		$que->bindParam(':tid', $tid);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row;
			} catch(PDOException $e) { echo $e->getMessage(); } 	
	}
	function topicReplyCount($tid)
	{
		$sql = "SELECT count(tid) as total FROM forum_replies WHERE tid = :tid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':tid', $tid);
		try { 
			$que->execute();
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row['total'];
			}catch(PDOException $e) { echo $e->getMessage(); } 
	}
	function gatherReplies($tid,$offset, $limit)
	{
		$sql = "SELECT
					f.bodyText as body,
					f.tid as topic,
					f.uid as user,
					f.postedOn,
					(SELECT topicTitle FROM forum_topics WHERE topicID = topic) as title, 
					(SELECT username FROM users WHERE uid = user) as username,
					(SELECT avatar FROM users WHERE uid = user) as avatar,
					(SELECT joinDate FROM users WHERE uid = user) as joined,
					(SELECT exp FROM user_coffers WHERE uid = user) as exp
				FROM 
					forum_replies as f
				WHERE tid = :tid
				ORDER BY f.postedOn
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
	function displayReplies($tid, $type = 'public')
	{
		
		$html = "<div class='forum'>";
		$html .= "<div class='forum controls'><a href='index.php'>Return to Board Index</a>";
		if($this->isAdmin() || $this->topicOwner($tid) == $this->uid)
		{
			$html .= "<a href='deleteTopic.php?tid={$tid}'>Delete Topic</a>";	
		}
		$html .= "</div>";
		$limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 15;
    	$page       = $_GET['page']+1;
		$offset = $page*$limit;
		$total = $this->topicReplyCount($tid);
		$pages = new Paginator($total,9);
    	$end = min(($offset + $limit), $total);
		if($type != 'public')
		{
			$n = $this->gatherPMreplies($tid,$pages->limit_start, $pages->limit_end);
		}
		else
		{
		$n = $this->gatherReplies($tid,$pages->limit_start, $pages->limit_end);
		}
		foreach($n as $k=>$v)
		{
			$html .="<div class='reply'><div class='userinfo'>
								<h1>{$v['username']}</h1>
								<img src='{$v['avatar']}' />
								<h2>Joined On {$v['joined']}</h2>
								<h2>{$v['exp']}XP</h2>
								</div><div class='body'>
								<div class='metainfo'>{$v['postedOn']}</div>
								<p>{$v['body']}</p></div></div>";	
		}
		$html .= "<div class='forum controls'>{$pages->display_pages()}</div>";
		if($this->uid != NULL)
		{
		$html .= "<div class='reply form'>
				<form method='get' action='reply.php'>
				<textarea name='body'></textarea>
				<input type='hidden' name='tid' value='{$_GET['tid']}'>
				<input type='submit'>
		
		</div>";
		}
		$html .= "</div>";
		return $html;
	}
	function gatherTopics($fid)
	{
		$sql = "SELECT 
					topicTitle, 
					topicID,
					posted,
					(SELECT username FROM users WHERE uid = topicOwner) as username,
					(SELECT postedOn FROM forum_replies WHERE tid = topicID ORDER BY postedON DESC LIMIT 1) as lastReply
				FROM 
					forum_topics 
				WHERE forumID = :fid ORDER BY lastReply DESC";
		$que = $this->db->prepare($sql);
		$que->bindParam(':fid', $fid);
		$array = [];
		try { 
			$que->execute();
			while($row = $que->fetch(PDO::FETCH_ASSOC))
			{
				$array[] = $row;	
			}
			 }catch(PDOException $e) { return $e->getMessage(); } 	
		return $array;
	}
	function dateConverse($date)
	{
		$date = new DateTime($date);
		$date2 = new DateTime('now');
		
	}
	function displayTopics($fid)
	{
	
		$array = $this->gatherTopics($fid);	
		$html = "<div class='forum topic-holder'>";
		$html .= "<div class='forum controls'><a href='post.php?mode=nt&fid={$fid}'>New Topic</a>
		<a href='index.php'>Return to Board Index</a></div>";
		#$html .= "<tr><th>&nbsp;</th><th>Topic</th><th>Poster</th><th>Date Posted</th><th>last reply</th></tr>";
		foreach($array as $x=>$v)
		{
			#$date = $this->dateConverse($v['posted']); // Until The Time Bug is fixed, this is disabled
			$html .= "<div class='topic'>
						<div class='status'>read</div>
						<div class='link'><a href='viewTopic.php?tid={$v['topicID']}'>{$v['topicTitle']}</a></div>
						<div class='data'>
							<div class='poster'>{$v['username']}</div>
							<div class='posted'>{$v['posted']}</div>
							<div class='lastpost'>{$v['lastReply']}</div>
					</div></div>";
		}
		$html .= "</table>";
		return $html;
	}
	function lastTopicReply($fid)
	{
		$sql = "SELECT 
					ft.topicTitle,
					fr.rid,
					ft.topicID as tid,
					fr.postedOn as posted
				FROM 
					forum_topics as ft,
					forum_replies as fr
				WHERE
					fr.tid = ft.topicID
					AND
					ft.forumID = :fid
				ORDER BY
					fr.rid DESC
					
				
		";
		$que = $this->db->prepare($sql);
		$que->bindParam(':fid', $fid);
		try { $que->execute(); $row = $que->fetch(PDO::FETCH_ASSOC); return $row; }
		catch(PDOException $e) { echo $e->getMessage(); }  
		
		}
	function gatherForum($cid)
	{
		$sql = "SELECT
					f.forumName,
					f.forumID
				FROM
					forum_name as f
				WHERE
					catID = :cid
					 ";
		$que = $this->db->prepare($sql);
		$que->bindParam(":cid", $cid);
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
	function gatherCatagories()
	{
		$sql = "SELECT 
					catID as CID,
					catName as CName
				FROM
					forum_catagories";
		$que = $this->db->prepare($sql);
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
	function displayForum()
	{

		$array = $this->gatherCatagories();	
		$html = "<div class='forum'>";
		$html .= "<ul>";
		foreach($array as $x=>$v)
		{

			$html .= "<li class='forum catagory'><div class='catagoryTitle'>{$v['CName']}</div><ul>";
			$n = $this->gatherForum($v['CID']);
			foreach($n as $x=>$v){
			$ltr = $this->lastTopicReply($v['forumID']); 
			if(empty($ltr))
			{
				$topicTitle = '<i>Nothing New</i>';	
				$link = $topicTitle;
			}
			else
			{
				$topicTitle = $ltr['topicTitle'];	
				$link = "<a href='viewTopic.php?tid={$ltr['tid']}' class='small'>{$topicTitle}</a>";
			}
			$html .= "<li class='subforum'>
						<div class='link'><a href='viewForum.php?fid={$v['forumID']}'>{$v['forumName']}</a></div>
						<div class='info'>
						{$link}
						{$ltr['posted']}</div>
					</li>";}
		}
		$html .= "</ul>";
		return $html;
	}
	function getNews()
	{

	}
}

?>