<?php
include('../includes/parts/header.new.php');
$sql = "INSERT INTO upgrades(requires, title, description, eyes, mouth, coherence,votes_required) VALUES (:requires, :title, :desc, :eyes, :mouth, :coh,:vr)";
$que = $db->prepare($sql);
$que->bindParam(":requires", $_POST['requires']);
$que->bindParam(":title", $_POST['title']);
$que->bindParam(":desc", $_POST['desc']);
$que->bindParam(":eyes", $_POST['eyes']);
$que->bindParam(":mouth", $_POST['mouth']);
$que->bindParam(":coh", $_POST['coherence']);
$vr = mt_rand(0,15);
$que->bindParam(':vr', $vr); 
try { if($que->execute()) { header('location:index.php?mode=upgrade');} } catch(PDOException $e ) { echo $e->getMessage(); } 