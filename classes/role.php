<?php 
class Role extends Database{
	public function insert_role($cols,$vals){
		$res = $this->insert_query("pages",$cols,$vals);
		return $res;
	}


	public function show_roles($limit=null){
		$res = $this->select_query("roles");
		return $res;
	}


	
	

}


$role = new Role();

?>