<?php
$words = array('revision','upgrade','overhaul','overclock','redistribution');
$otherwords = array('neural','network','computer','memory','storage','power');
$othercount = count($otherwords)-1;
$count = count($words)-1;
include('includes/parts/header.new.php');
function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
echo "<table>";
for($i = 0; $i < 4;)
{
	echo $i;
	for($e = 0; $e < 4;)
	{
		echo $e;
					$i = $i+1;	
	}
	$e = $e+1;
}
echo count($array[0]);
if (count($array) > 0): ?>
<table>
  <thead>
    <tr>
      <th><?php echo implode('</th><th>', array_keys(current($array))); ?></th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($array as $row): array_map('htmlentities', $row); ?>
    <tr>
      <td><?php echo implode('</td><td>', $row); ?></td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>