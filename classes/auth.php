<?php 
class Auth extends Database{
	public function login($user,$pass){
		$checkuser = $this->find_query("users",$user,"username");
		if ($checkuser->rowCount()>0) {
			$found_user = $checkuser->fetch();
			$found_password = $found_user['password'];
			if (md5($pass)===$found_password) {
				$userid = $found_user['id'];
				$username = $found_user['username'];
				$role = $found_user['role'];
				$_SESSION['userid'] = $userid;
				$_SESSION['username'] = $username;
				$_SESSION['role'] = $role;
				echo true;
			}
			else{
				echo "Username or password is incorrect";
			}
		}
		else{
			echo "User not found";
		}
	}



	public function check_login(){
		if (!isset($_SESSION['userid'])) {
			return false;
		}else{
			return true;
		}
	}


	public function fetch_logged_in_user(){
		$userid = $_SESSION['userid'];
		$user = $this->find_query("users",$userid);
		$logged_in_user = $user->fetch();
		return $logged_in_user;
	}



	public function logout(){
		unset($_SESSION['userid']);
		unset($_SESSION['username']);
		unset($_SESSION['role']);
		session_destroy();
		return 1;
		// session_destroy();
	}



	
}


$auth = new Auth();

?>