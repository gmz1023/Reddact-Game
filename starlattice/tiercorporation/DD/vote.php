<?php
include('../includes/parts/header.new.php');
$vote = $_POST['vote'];
$sql = "UPDATE upgrades SET votes = votes+1 WHERE uid = :uid;";
$que = $db->prepare($sql);
$que->bindParam(':uid', $vote);
try { 
	if($que->execute())
	{
		$sql = "INSERT INTO enabled_upgrades(uid,mouth,eyes,coherence) 
				SELECT 
					uid, 
					eyes, 
					mouth, 
					coherence 
				FROM 
					upgrades U 
				WHERE 
					NOT EXISTS (SELECT * FROM enabled_upgrades EU WHERE U.uid = EU.uid) 
				AND
					  votes >= votes_required;";
		$sql .= "INSERT INTO user_upgrades_voted(uid,upgradeID) VALUES({$_SESSION['user']['uid']},{$vote})";
		try { $db->exec($sql);
		header('location:index.php');
		 } catch(PDOException $e) { echo $e->getMessage(); } 
	}
	
	} catch(PDOException $e) {} 