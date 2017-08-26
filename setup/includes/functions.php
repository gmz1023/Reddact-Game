<?php
function __autoload($class_name) {
   #$class_name = strtolower($class_name);
   $path       = dirname(__FILE__)."/class/{$class_name}.php";
   if (file_exists($path)) {
       require_once($path);
	  echo $path;
   } else {
	   
       die("The file {$class_name}.php could not be found at {$path}! /n");
   }
}