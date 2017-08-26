<?php
class inventory extends notifications
{
	/*************************************
	
		Combined Inventory
	
	***************************************/
	function fullInventory($uid)
	{
		$array = [];
		$sql = "SELECT 
					i.item_id as iid,
					r.resourceName as rname,
					i.item_count
				FROM
					user_inventory as i,
					resources as r
				WHERE 
					r.rid = i.item_id
					AND
					i.uid = :uid
					";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		try { 
				$que->execute();
				while($row = $que->fetch(PDO::FETCH_ASSOC))
				{
					$array[] = $row;	
				}
			} 
		catch(PDOException $e) { echo $e->getMessage(); } 
		
		return $array;
	}
	/*************************************
		Resource Inventory 
	***************************************/
	function gatherResourceInv($uid)
	{
		$array = [];
		$sql = "SELECT 
					i.item_id as iid,
					r.resourceName as rname,
					i.item_count
				FROM
					user_inventory as i,
					resources as r
				WHERE 
					r.rid = i.item_id
					AND
					i.uid = :uid
					AND
					i.item_type = 'resource'
					";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		try { 
				$que->execute();
				while($row = $que->fetch(PDO::FETCH_ASSOC))
				{
					$array[] = $row;	
				}
			} 
		catch(PDOException $e) { echo $e->getMessage(); } 
		
		return $array;
	}
	function userResourceInv($uid)
	{
		$array = $this->gatherResourceInv($uid);
		echo "<table class='resource'><tr><th>Resource Name</th><th>Resource Count</th></tr>";
		foreach($array as $x=>$v)
		{
			echo "<tr><td>{$v['rname']}</td><td>{$v['item_count']}</td></tr>";	
		}
		echo "</table>";
	}
	/***************************************
	
		Inventory Inventory
	
	***************************************/
	function gatherItemInv($uid)
	{
		$array = [];
		$sql = "SELECT 
					i.item_id as iid,
					r.resourceName as rname,
					i.item_count
				FROM
					user_inventory as i,
					resources as r
				WHERE 
					r.rid = i.item_id
					AND
					i.uid = :uid
					AND
					i.item_type = 'item'
					";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		try { 
				$que->execute();
				while($row = $que->fetch(PDO::FETCH_ASSOC))
				{
					$array[] = $row;	
				}
			} 
		catch(PDOException $e) { echo $e->getMessage(); } 
		
		return $array;
	}
	function checkUserInv($uid, $iid)
	{
		$sql = "SELECT count(item_count) as total FROM user_inventory WHERE uid = :uid AND item_id = :iid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		$que->bindParam(':iid', $iid);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row['total'];
			}catch(PDOException $e) { echo $e->getMessage(); } 
	}
	function userItemInv($uid)
	{
		$array = $this->gatherItemInv($uid);
		$html = "";
		if(!empty($array))
		{
		foreach($array as $x=>$v)
		{
			$html .="
					<div class='whIone'><img src='../assets/imgs/items/tempimage.png' height='150px' width='150px'>
    				<span>Dank Meme</span><span>$420</span>
    				<button>Equip</button><button>Sell</button><button>Break Down</button></div>";
		}
		}
		else
		{	
				$html.= "<h1>There Appears to be Nothing Here!</h1>";
		}
		$html .= "";
		return $html;
	}
	function updateUserInv($uid, $iid, $ammount)
	{
		/* Insert Items into Users Inventory; 
			Probably can also be used to remove items, but I've yet to actually test that */
		$sql = "INSERT INTO user_inventory(item_id, uid) 
				VALUES ( :iid, :uid) 
				ON DUPLICATE KEY 
				UPDATE item_count = item_count+1;";
		$this->db->setAttribute( PDO::ATTR_EMULATE_PREPARES, true );
		$que = $this->db->prepare($sql);
		$que->bindParam(':iid', $iid);
		$que->bindParam(':uid', $uid);
		try { if($que->execute()) { return true;} }catch(PDOException $e) { echo $e->getMessage(); }  	
	}
}