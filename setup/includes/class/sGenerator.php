<?php
class sGenerator
{
	function doesStarExist($x, $y, $ssid)
	{
		$sql = "SELECT count(*) as total from map WHERE mapX = :x AND mapY = :y AND ssid = :ssid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':x', $x);
		$que->bindParam(':y', $y);
		$que->bindParam(':ssid', $ssid);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			echo $row['total'];
			if($row['total'] <= 0)
			{
				return true;	
			}
			else
			{
				return false;	
			}
			}catch(PDOException $e) { echo $e->getMessage(); }	
	}
function generateStarInfo()
{
	$sql = "INSERT INTO map (ssid, mapX, mapY, starType, resource, habitablePlanets) VALUES";

}

	function generateStarInfo2() {
	  $s = 1;
	  $m = 32;
	  $owner = 0;
	  $sql ="INSERT INTO map (ssid, mapX, mapY, starType, resource, habitablePlanets) VALUES";
	  for($x = $m*-1; $x<=$m; $x++) {
		for($y = MAPMAX*-1; $y<=MAPMAX; $y++) {
		  if($s >= 256) {
			$s = 1;
			$owner = (mt_rand(1,256) == 4) ? -3 : 0;  
		  } else {
			$s = $s+1;  
		  }
			$type = (mt_rand(0,10) <= 1) ? 2 : 1;
			$res = mt_rand(1,118);
			$hab = mt_rand(0,9);
			$sql .= "({$s},{$x},{$y},{$type},{$res},{$hab}),";
			#$this->insertStar($x, $y, $s, $type, $res, $hab, $owner);
		}
	  } 
	  $sql = trim($sql,',');
	  #echo $sql;
	  $sql .= ';';
	  echo $sql;
	  #try { $this->db->exec($sql); }catch(PDOexception $e) { echo $e->getMessage(); } 
	}

	function insertStar($x, $y, $ssid, $type, $res, $hab,$owner)
	{
		print_r(array('x'=>$x,'y'=>$y,'ssid'=>$ssid,'type'=>$type,'res'=>$res));
		$sql = "INSERT INTO map (ssid, mapX, mapY, starType, resource, habitablePlanets) VALUES (:ssid, :x, :y, :type, :res, :hab)";
		$que = $this->db->prepare($sql);
		$que->bindParam(':ssid', $ssid);
		$que->bindParam(':x', $x);
		$que->bindParam(':y', $y);
		$que->bindParam(':type', $type);
		$que->bindParam(':res', $res);
		$que->bindParam(':hab', $hab);
		try { if($que->execute()) { if($type == 2){ $this->insertSystem(); }} }catch(PDOExceptioN $e) { echo $e->getMessage(); echo "\n"; }
				
	}
	function insertSystem()
	{
		$sql = "INSERT INTO system_upgrades(sid) VALUES (:sid)";
		$que = $this->db->prepare($sql);
		$id = $this->db->lastInsertId();
		$que->bindParam(':sid', $id);
		try { $que->execute(); } catch(PDOException $e) { echo $e->getMessage(); } 
	}
	function moveable_objects($sid)
	{
		$sql = "UPDATE map SET ssid = ssid+1 WHERE sid = :sid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':sid', $sid);
		try { $que->execute(); } catch(PDOException $e) { echo $e->getMessage(); } 	
	}
	}
