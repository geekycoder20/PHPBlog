<?php 
class Message extends Database{
	public function insert_message($cols,$vals){
		$res = $this->insert_query("contact_queries",$cols,$vals);
		return $res;
	}

	public function show_msgs(){
		$res = $this->select_query("contact_queries");
		return $res;
	}


	public function delete_msg($id){
		$res = $this->delete_query("contact_queries",$id);
		return $res;
	}



}


$message = new Message();

?>