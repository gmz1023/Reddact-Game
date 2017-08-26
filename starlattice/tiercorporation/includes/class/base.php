<?php
class base extends users
{
	function __construct($db)
	{
	$this->db = $db;
	}
}