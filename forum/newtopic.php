<?php
include('../bootstra.php');
if(isset($_SESSION['user']))
{
if(!$base->isValid($_POST['body']) && !$base->isValid($_POST['title']))
{
	header('Location: ' . $_SERVER['HTTP_REFERER']);

}
else
{
	$fid = $base->insertTopic($_POST['fid'], $_SESSION['user']['uid'], $_POST['body'], $_POST['title']);
	if(is_numeric($fid))
	{
		header("location:viewTopic.php?tid={$fid}");
	}
}
}