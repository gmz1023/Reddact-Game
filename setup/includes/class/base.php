<?php
class base extends sGenerator
{
	function __construct($db)
	{
		$this->db = $db;
	}
	function displayMap()
	{
		$this->x = $_GET['x'];
		$this->y = $_GET['y'];
		$sql = "SELECT * FROM map WHERE mapX = :x AND mapY = :y";
		$que = $this->db->prepare($sql);
		$que->bindParam(':x', $this->x);
		$que->bindParam(':y', $this->y);
		try { 
			$que->execute(); 
			echo "<div id='map'>";
			$x = 0;
			while($row = $que->fetch(PDO::FETCH_ASSOC))
			{
				
				echo "<div class='space' id='{$row['ssid']}'>*</div>";	
			}
			echo "</div>";
			}catch(PDOException $e) { echo $e->getMessage(); }	
	}
	function truncateMap()
	{
		$sql = 'truncate map;';
		$que = $this->db->prepare($sql);
		try { $que->execute(); }catch(PDOException $e) { echo $e->getMessage(); }	
	}

}
?>