<?php include('bootstra.php');
$sql = "SELECT rid, mapX,mapY FROM user_relays WHERE uid = :uid";
$que = $db->prepare($sql);
$que->bindParam(':uid', $_POST['uid']);
$html = "<form action='move.php' method='post'>";
$html .= "<select name='rid' id='rid'>";
try { 
	$que->execute();
	while($row = $que->fetch(PDO::FETCH_ASSOC))
	{
		$html .= "<option value='".$row['rid']."'>X".$row['mapX']."Y".$row['mapY']."</option>";	
	}
}catch(PDOException $e) { echo $e->getMessage(); } 
echo $html;
?>

<input type="hidden" name='warpRelay' value='true'>
<input type='submit'>
</form>