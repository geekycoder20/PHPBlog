<?php 
class Slider extends Database{
	public function insert_slider($cols,$vals){
		$res = $this->insert_query("slider",$cols,$vals);
		return $res;
	}

	public function find_slider($postid){
		$res = $this->find_query("slider",$postid,"postid");
		return $res;
	}


	public function show_sliders($limit=null){
		if ($limit!=null) {
			$stmt = $this->con->prepare("SELECT * FROM posts,slider WHERE posts.id=slider.postid AND posts.status=:status LIMIT $limit");
		}else{
			$stmt = $this->con->prepare("SELECT * FROM posts,slider WHERE posts.id=slider.postid AND posts.status=:status");
		}

		$res = $stmt->execute([":status"=>"Published"]);
		return $stmt;
	}


	public function all_sliders(){
		$res = $this->select_query("slider");
		return $res;
	}


	public function delete_slider($id){
		$res = $this->delete_query("slider",$id,"postid");
		return $res;
	}




}


$slider = new Slider();

?>