<?php
$f = fopen('s.csv','r');
$_elements = [];
$i = 1;
while($row = fgetcsv($f))
{
	$value = ceil($row[3]);
	//echo $row[3].'<br />';
	$_elements[] = array('rid'=>$i,'name'=>$row[0],'value'=>$value);
	$i++;
}


$sql = "INSERT INTO resources(resourceName, value) VALUES ";
foreach($_elements as $k=>$v)
{
	$sql.= "('{$v['name']}',{$v['value']}),";	
}
$sql = trim($sql, ',');


echo "<pre>";
print_r($sql);
echo "<pre>";