<?php 
class User extends Database{
	public function insert_user($cols,$vals){
		$res = $this->insert_query("users",$cols,$vals);
		return $res;
	}


	public function all_users(){
		$res = $this->select_query("users");
		return $res;
	}


	public function delete_user($id){
		$res = $this->delete_query("users",$id);
		return $res;
	}


	public function show_profile(){
		$userid = $_SESSION['userid'];
		$res = $this->find_query("users",$userid);
		return $res;
	}

	public function update_profile($cols,$vals,$id){
		$res = $this->update_query("users",$cols,$vals,$id);
		return $res;
	}

	public function change_password($cols,$vals,$id){
		$res = $this->update_query("users",$cols,$vals,$id);
		return $res;
	}


	public function get_social_links($userid){
		$res = $this->find_query("social_links",$userid,"userid");
		return $res;
	}

	public function update_social_links($cols,$vals,$id){
		$res = $this->update_query("social_links",$cols,$vals,$id,"userid");
		return $res;
	}



}


$user = new User();

?>