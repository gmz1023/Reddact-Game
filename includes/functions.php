<?php 
function __autoload($className) {
#	echo "Hello ".$variable;
	$file = dirname(__FILE__).'/class/'.$className.'.php';
	#echo $file.'<br />';
      if (file_exists($file)) {
          require_once($file);
          return true;
      }else
	  {
		  die("Class {$className} Not Found");
	  }
      return false;
} 
?>