<?php
include('includes/parts/header.new.php');
if(!isset($_GET['submit']))
{
	?>
<form action='register.php?submit=true' method="post">
<input type='text' name='username'>
<input type='password' name='password'>
<input type='submit'>
</form>
<?php
}
else
{
	if($base->registerUser($_POST['username'], $_POST['password']) ) { header('location:index.php'); } 
}