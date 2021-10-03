<?php 
class Setting extends Database{
	public function find_limits(){
		$id = 1;
		$res = $this->find_query("limits",$id);
		return $res;
	}

	public function update_limits($cols,$vals,$id){
		$res = $this->update_query("limits",$cols,$vals,$id);
		return $res;
	}




}


$setting = new Setting();

?>