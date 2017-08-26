<?php

if(!isset($_GET['mode']) && !isset($_SESSION['user']))
{
	header('location:'.$_SERVER['HTTP_REFERER']);	
}
else
{
	switch($_GET['mode'])
	{
		case 'nt':	
		if(!is_numeric($_GET['fid']))
		{
			header('location:index.php');	
		}
		else
		{
		include('../bootstra.php');
		include('../includes/parts/head.php');
		include('../includes/parts/header.new.php');
			echo $html;
		?>
    	
        <form action='newtopic.php' method="post" class='post'>
       	<div class='forum new-topic'>
        <input type='hidden' value='<?php echo $_GET['fid']; ?>' name='fid'>
        <div class='forum new-topic title'> <input type='text' name='title' /></div>
        <div class='forum new-topic body'><textarea name='body'></textarea></div>
        <div class='forum new-topic submit'><input type="submit"></div>
        </form>
        </div>
        <?php
		}
		break;
		case 'tr':
		echo "Topic Reply";
		break;	
	}
}