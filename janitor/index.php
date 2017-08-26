<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php 
if(!isset($_POST['text']))
{
	?>
<style>
form { 
	border: 1px solid black; 
	width: 33%;
	margin: 0 auto;
	padding: 1%;
	} 
textarea { 
	width: 100%;
	display: block;
	resize:none;
}
input { width: 100%; display: block; } 
</style>
<form method="post">
<h1>Janitorize</h1>
<textarea name='text'></textarea>
<input type='submit' value='janitorize'>
</form>
<?php
}
else
{
	require_once("nbbc.php");
	$bbcode = new BBCode;
	$str = $bbcode->Parse($_POST['text']);
	$str = explode(' ',$str);
	$count = count($str)-1;
	$r = mt_rand(0,$count);
	foreach($str as $x)
	{
		if(mt_rand(0,$count) == $count)
		{
		echo 'janitor ';	
		}
		else
		{
			echo $x.' ';	
		}
	}
}
?>
</body>
</html>