<?php
class upgrades
{
	function compile($limit)
	{
		$array = $this->subUpgrades($limit);
		$returnArray = [];
		$returnArray[0] = $array;
		for($i = 0; $i < $limit; $i++)
		{
			$returnArray[0]= $this->subUpgrades($limit, $array);
		}
		return array_unique($returnArray);
	}
	function mainUpgrades($limit = 10, $array = array())
	{	
		$array = [];
		for($i = 1; $i < 6; $i++)
		{
			$array[] = array($i);
		}
		
		return $array;
	}
	function subUpgrades($limit = 10, $array= array())
	{
		$sU = [];
		$mu = $this->mainUpgrades($limit);
		$count = count($mu)+$limit+1;
		$upgradeArray = [];
		#print_r($mu);
		foreach($mu as $k=>$v)
		{
			foreach($v as $value=>$key)
			{
				for($i = 1; $i < $limit*2; $i++)
				{
					$pKey = $key+$limit;
					$id = count($mu)+($i+$key);
					$blocked = array($id+1,$id-1);
					$upgradeArray[] = array('required'=>$pKey,'id'=>(count($upgradeArray)+$count),'blockBy'=>$blocked);	
				}
			}
		}
		return $upgradeArray;
	}
}