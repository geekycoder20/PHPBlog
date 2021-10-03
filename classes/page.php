<?php 
class Page extends Database{
	public function insert_page($cols,$vals){
		$res = $this->insert_query("pages",$cols,$vals);
		return $res;
	}

	public function show_pages($limit=null){
		if (!empty($limit)) {
			$res = $this->select_query("pages","id","ASC",$limit);
		}else{
			$res = $this->select_query("pages");
		}
		return $res;
	}


	public function delete_page($id){
		$res = $this->delete_query("pages",$id);
		return $res;
	}


	public function edit_page($id){
		$res = $this->find_query("pages",$id);
		return $res;
	}


	public function update_page($cols,$vals,$id){
		$res = $this->update_query("pages",$cols,$vals,$id);
		return $res;
	}




}


$page = new Page();

?>