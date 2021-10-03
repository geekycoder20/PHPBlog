<?php 
class Comment extends Database{
	
	public function insert_comment($cols,$vals){
		$res = $this->insert_query("comments",$cols,$vals);
		return $res;
	}

	public function insert_reply($cols,$vals){
		$res = $this->insert_query("replies",$cols,$vals);
		return $res;
	}

	public function approved_comments($postid){
		$stmt = $this->where_query("comments","status","=","Approved","AND","postid","=",$postid,"id","ASC","");
		return $stmt;
	}

	public function show_replies($commentid){
		$res = $this->find_query("replies",$commentid,"commentid");
		return $res;
	}

	public function all_comments(){
		$stmt = $this->con->prepare("SELECT * FROM posts,comments WHERE comments.postid=posts.id");
		$stmt->execute();
		return $stmt;
	}

	public function comments_with_pagination($offset,$limit){
		$stmt = $this->con->prepare("SELECT * FROM posts,comments WHERE comments.postid=posts.id ORDER BY comments.id DESC LIMIT $offset,$limit");
		$stmt->execute();
		return $stmt;
	}


	public function delete_comment($id){
		$res = $this->delete_query("comments",$id);
		$res2 = $this->delete_query("replies",$id,"commentid"); //delete replies linked with comment
		return $res;
	}



}


$comment = new Comment();

?>