<?php
class users extends CMAC
{
/*

	Future Functions

*/
	function userTerms()
	{
		$array['civType'] = 'Republic';
		
		return $array;	
	}
/* 


	Registration Function
	
	
*/
	function registerUser($array)
	{
			if(strlen($array['username']) <= 1)
			{
				$_POST['message'] = "Username not long enough";
			}
			elseif(strlen($array['password']) < 8)
			{
				$_POST['message'] = "Password not long enough";
			}
			else
			{
				if($this->createUser($array))
				{
					$id =$this->db->lastInsertId();
					if($this->createCoffers() && $this->createScoreboard($id))
					{
						if($this->upgradesInsert())
						{
							$_POST['message'] = "Registration was successful";		
						}
						else
						{
							$_POST['message'] = "Something Went Wrong [Error: Upin1]";		
						}	
					}
					else
					{
						$_POST['message'] = "Something Went Wrong [Error: coffin1]";		
					}
				}
				else
				{
					$_POST['message'] = "Something Went Wrong [Error: 1111]";		
				}
			}
		
	}
	function createUser($array)
	{
			$sql = 
			"INSERT INTO 
				`users`
					(
					`username`, 
					`email`,
					`password`, 
					`homeX`, 
					`homeY`, 
					`first_time`, 
					`avatar`, 
					`joinDate`
					) 
				VALUES (
					:username,
					:email, 
					:pswd, 
					:hX, 
					:hY, 
					1,
					:avatar, 
					now()
					);";
			if($_POST['uver'])
			{
			$pass =  password_hash($array['password'], PASSWORD_BCRYPT);
			$que= $this->db->prepare($sql);
			$que->bindParam(':email', $array['email']);
			$que->bindParam(':username', $array['username']);
			$que->bindParam(':pswd',$pass);
			/* Until Weird Java Script Error is solved, this is static
				Comment out when solved
			*/
				$array['hX'] = -1;
				$array['hY'] = -1;
			
			$que->bindParam(':hX', $array['hX']);
			$que->bindParam(':hY', $array['hY']);
			
			$que->bindParam(':avatar', $array['avatar']);
			try { 
					if($que->execute())
					{
						return true;	
					}
					else
					{
						return false;	
					}
				 }catch(PDOException $e){ echo $e->getMessage(); }
			}
			else
			{
				$_POST['message'] = "Username or Email already exists";
			}	
	}
	function registrationTo($array)
	{
		
		$this->registerUser($array);
	}
	function userLogin($username, $password)
	{
		$sql = "SELECT 
					u.uid as uid,
					u.password as password,
					u.homeX as homeX,
					u.homeY as homeY,
					u.firstTime as firstTime
				FROM 
					users as u
					WHERE u.username = :username
					AND
					u.accountType <> 0;";
		$que = $this->db->prepare($sql);
		$que->bindParam(':username', $username);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			#print_r($row);
			if(password_verify($password, $row['password']))
			{
				$_SESSION['user']['uid'] = $row['uid'];	
				$_SESSION['user']['x']= $row['homeX'];
				$_SESSION['user']['y']= $row['homeY'];
				$_SESSION['firstTime'] = $row['firstTime'];
				$_SESSION['user']['lastLogin'] = 0;
				$_SESSION['user']['starsLost'] = 0;
				return true;
			}
			else
			{
				
			}
			} catch(PDOException $e) { echo $e->getMessage(); }
	}
	function doesUserExist($username, $email)
	{
		$sql = "SELECT count(*) as total FROM users WHERE email = :email OR username = :username";	
		$que = $this->db->prepare($sql);
		$que->bindParam(':email', $email);
		$que->bindParam(':username', $username);
		try { 
			$que->execute(); 
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row['total'] == 0;
			}catch(PDOException $e) { echo $e->getMessage(); }
	}
/* 

	
	Password Functions
	
	
*/
	private function getPassword($uid)
	{
		$sql = "SELECT password FROM users WHERE uid = :uid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		try { 
			$que->execute();
			$row = $que->fetch(PDO::FETCH_ASSOC);
			return $row['password'];
			 }catch(PDOException $e) { echo $e->getMessage(); } 	
	}
	private function updatePass($uid, $pass)
	{
		$sql = "UPDATE users SET password = :pass WHERE uid = :uid";
		$que = $this->db->prepare($sql);
		$que->bindParam(':uid', $uid);
		$que->bindParam(':pass', $pass);
		try { 
			if($que->execute())
		 	{
				return true;	
			}
		 } catch(PDOException $e) { echo $e->getMessage(); } 	
	}
	function changePassword($cPass,$nPass)
	{
		if($nPass[0] == $nPass[1])
		{
			
			if(password_verify($cPass, $this->getPassword($this->uid)))
			{
			$pass = password_hash($nPass[0], PASSWORD_BCRYPT);
			$this->updatePass($this->uid, $pass);
			}
			else
			{
				return false;	
			}
		}
		else
		{
			return false;	
		}
	}

	function userPermissions()
	{
			$sql = "SELECT permissions FROM users WHERE uid = :uid";
			$que = $this->db->prepare($sql);
			$que->bindParam(':uid', $this->uid);
			try { 
				$que->execute(); 
				$row = $que->fetch(PDO::FETCH_ASSOC);
				$pm = explode(',',$row['permissions']);
				$pm = array('admin'=>$pm[0],'mod'=>$pm[1],'starmap'=>$pm[2],'forum'=>$pm[3]);
				return $pm;
				} catch(PDOException $e) { echo $e->getMessage(); } 	
	}
	function isAdmin()
	{
		if(isset($_SESSION['user']['uid']))
		{
			$pm = $this->userPermissions();
			if($pm['admin'] >= 1)
			{
				return true;	
			}
			else
			{
				return false;	
			}
		}
		else
		{
			return false;	
		}
	}
}