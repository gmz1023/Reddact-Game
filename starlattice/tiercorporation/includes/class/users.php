<?php
class users extends upgrades
{
	function registerUser($username, $password)
	{
		$sql = "INSERT INTO users(username, password) VALUES (:username, :password)";
		$que = $this->db->prepare($sql);
		$pass = password_hash($password, PASSWORD_DEFAULT);
		$que->bindParam(':username', $username);
		$que->bindParam(':password', $pass);
		try { if($que->execute()) { return true; }  }catch(PDOException $e) { echo $e->getMessage(); } 
	}
	function getUserPassword($username)
	{
		$sql = "SELECT password FROM users WHERE username = :username LIMIT 1";
		$que = $this->db->prepare($sql);
		$que->bindParam(':username', $username);
		try { $que->execute(); $row = $que->fetch(PDO::FETCH_ASSOC); return $row['password']; } catch(PDOException $e) { echo $e->getMessage(); } 
	}
	function isAdmin()
	{
		$sql = "SELECT accountType as Level FROM users WHERE uid = :uid";
		$que = $this->db->prepare($sql);
		$que->bindParam(":uid", $_SESSION['user']['uid']);
		try { $que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC); 
			return $row['Level'] >= 3 ? true: false;
			} catch(PDOException $e) { echo $e->getMessage(); } 	
	}
	function login($username, $password)
	{
		$sql = "SELECT 
					uid,
					password
				FROM 
					users
					WHERE username = :username";
		$que = $this->db->prepare($sql);
		$que->bindParam(':username', $username);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			#print_r($row);
			if(password_verify($password, $row['password']))
			{
				$_SESSION['user']['uid'] = $row['uid'];	
				return true;
			}
			else
			{
				echo "failed";
			}
			} catch(PDOException $e){ echo $e->getMessage(); } 
	}
}