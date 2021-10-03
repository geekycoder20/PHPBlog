<?php 
class Category extends Database{
	public function insert_category($cols,$vals){
		$res = $this->insert_query("categories",$cols,$vals);
		return $res;
	}


	public function show_categories(){
		$res = $this->select_query("categories");
		return $res;
	}


	public function find_category($id){
		$res = $this->find_query("categories",$id);
		return $res;
	}


	public function edit_category($id){
		$res = $this->find_query("categories",$id);
		return $res;
	}


	public function update_category($cols,$vals,$id){
		$res = $this->update_query("categories",$cols,$vals,$id);
		return $res;
	}


	public function delete_category($id){
		$res = $this->delete_query("categories",$id);
		return $res;
	}


	public function postcategories($id){
		$stmt =  $this->con->prepare("SELECT * FROM categories,cat_links WHERE categories.id=cat_links.catid AND cat_links.postid=:postid");
		$result = $stmt->execute([':postid'=>$id]);
		$catrow = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $catrow;
	}



}


$category = new Category();

?>