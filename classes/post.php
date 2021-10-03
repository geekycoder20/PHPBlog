<?php 
class Post extends Database{
	
	//////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////Post Backend functions///////////////////////////
	//////////////////////////////////////////////////////////////////////////////////
	public function insert_post($cols,$vals){
		$res = $this->insert_query("posts",$cols,$vals);
		return $res;
	}


	public function show_posts_pagination($offset,$limit){
		$role = $_SESSION['role'];
		$author = $_SESSION['username'];
		$newlimit = $offset.",".$limit;
		if ($role=="Admin" OR $role=="Moderator") {
			$res = $this->select_query("posts","id","DESC",$newlimit);
			return $res;
		}else{
			$res = $this->where_query("posts","author","=",$author,"","","","","id","DESC",$newlimit);
			return $res;
		}
	}


	public function edit_post($id){
		$role = $_SESSION['role'];
		$author = $_SESSION['username'];
		if ($role=="Admin" OR $role=="Moderator") {
			$res = $this->find_query("posts",$id);
			return $res;
		}
		else{
			$res = $this->where_query("posts","id","=",$id,"AND","author","=",$author,"id","ASC","");
			return $res;
		}
		
	}


	public function update_post($cols,$vals,$id){
		$res = $this->update_query("posts",$cols,$vals,$id);
		return $res;
	}


	public function delete_post($id){
		$role = $_SESSION['role'];
		$author = $_SESSION['username'];
		if ($role=="Admin" OR $role=="Moderator") {
			//delete post
			$res = $this->delete_query("posts",$id);
			//delete categories linked with post
			if ($res) {
				$this->delete_query("cat_links",$id,"postid");
			}
			return $res;
		}
		else{
			$stmt = $this->con->prepare("DELETE FROM posts WHERE id=:id AND author=:author");
			$stmt->execute([':id'=>$id,':author'=>$author]);
			if ($stmt) {
				$this->delete_query("cat_links",$id,"postid");
			}
			return $stmt;
			
		}
		
	}


	public function search_posts($value){
		$res = $this->search_query("posts","title",$value);
		return $res;
	}

	public function all_posts(){
		$res = $this->select_query("posts");
		return $res;
	}


	//////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////Post Frontend functions//////////////////////////
	//////////////////////////////////////////////////////////////////////////////////

	public function published_posts($limit){
		$res = $this->where_query("posts","status","=","Published","","","","","id","DESC",$limit);
		return $res;
	}


	public function load_posts($dataid,$limit,$searchtext=null,$searchcat=null){
		if (isset($searchtext) AND $searchtext!="") {
			$stmt = $this->con->prepare("SELECT * FROM posts WHERE title LIKE '%$searchtext%' AND status=:status AND id<:id ORDER BY id DESC LIMIT $limit");
		}
		elseif(isset($searchcat) AND $searchcat!=""){
			$stmt = $this->con->prepare("SELECT * FROM posts,cat_links WHERE posts.id=cat_links.postid AND status=:status AND cat_links.catid=$searchcat AND cat_links.postid<:id ORDER BY posts.id DESC LIMIT $limit");
		}
		else{
			$stmt = $this->con->prepare("SELECT * FROM posts WHERE id<:id AND status=:status ORDER BY id DESC LIMIT $limit");
		}
		$stmt->execute([':id'=>$dataid,':status'=>"Published"]);
		return $stmt;
	}


	public function update_view_count($postid){
		$post = $this->find_query("posts",$postid,"slug");
		$post = $post->fetch();
		$post_views = $post['view_count'];
		$cols = array("view_count");
		$vals = array($post_views+1);
		$res = $this->update_query("posts",$cols,$vals,$postid,"slug");
	}


	public function pouplar_posts($limit){
		$res = $this->select_query("posts","view_count","DESC",$limit);
		return $res;
	}

	public function random_posts($limit){
		$res = $this->where_query("posts","status","=","Published","","","","","","rand()",$limit);
		return $res;
	}


	public function catposts($id,$limit){
		$stmt =  $this->con->prepare("SELECT * FROM posts,categories,cat_links WHERE posts.id=cat_links.postid AND posts.status=:status AND categories.id=cat_links.catid AND cat_links.catid=:catid ORDER BY posts.id DESC LIMIT $limit");
		$result = $stmt->execute([':catid'=>$id,':status'=>"Published"]);
		$catrow = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $catrow;
	}





}


$post = new Post();

 ?>