<?php 
include("../config/init.php");

// Developed by Abdul Razzaq -- ab.razzaq32@yahoo.com

// Show blog Posts
if (isset($_GET['action']) AND $_GET['action']=='showblogposts') {
	$limits = $setting->find_limits();
	$alllimits = $limits->fetch();
	$limit = $alllimits['postsblog'];
	$res = $post->published_posts($limit);
	$postrow = $res->fetchAll(PDO::FETCH_ASSOC);
	$json = json_encode($postrow);
	echo $json;
	exit;
}


//show quick view post
if (isset($_POST['action']) AND $_POST['action']=='showquickview') {
	$id = $_POST['id'];
	$mypost = $database->find_query("posts",$id);
	$results = $mypost->fetchAll(PDO::FETCH_ASSOC);
	$results2 = $category->postcategories($id); //categories of post
	//update view count
	$mypost = $database->find_query("posts",$id);
	$postrow = $mypost->fetch();
	$postslug = $postrow['slug'];
	$post->update_view_count($postslug);//end of update view count

	$json = json_encode([$results,$results2]);
	echo $json;
	exit;
}




//Load More Posts
if (isset($_GET['action']) AND $_GET['action']=='loadmoreposts') {
	$limits = $setting->find_limits();
	$alllimits = $limits->fetch();
	$limit = $alllimits['loadmore'];
	$dataid = $_GET['dataid'];
	$loadby = $_GET['loadby'];

	if ($loadby=="loadbysearch") {
		$res = $post->load_posts($dataid,$limit,$_GET['searchtext']);
	}
	elseif($loadby=="loadbycat"){
		$res = $post->load_posts($dataid,$limit,"",$_GET['cat_id']);
	}
	else{
		$res = $post->load_posts($dataid,$limit);
	}

	$postrow = $res->fetchAll(PDO::FETCH_ASSOC);
	$json = json_encode($postrow);
	echo $json;
	exit;
}


//Show Posts by category
if (isset($_POST['action']) AND $_POST['action']=='showpostsbycat') {
	$limits = $setting->find_limits();
	$alllimits = $limits->fetch();
	$limit = $alllimits['postsblog'];
	$catid = $_POST['categoryid'];
	$res = $post->catposts($catid,$limit);
	$json = json_encode($res);
	echo $json;
}


//Search Posts
if (isset($_POST['action']) AND $_POST['action']=='searchposts') {
	$limits = $setting->find_limits();
	$alllimits = $limits->fetch();
	$limit = $alllimits['postsblog'];
	$search = $_POST['search'];
	$posts = $database->where_query("posts","title","LIKE","%$search%","","","","","id","DESC",$limit);
	$postrow = $posts->fetchAll(PDO::FETCH_ASSOC);
	$json = json_encode($postrow);
	echo $json;
	exit;
}



//Add Comments
if (isset($_POST['action']) AND $_POST['action']=='addcomment') {
	$postid = $_POST['postid'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$body = $_POST['body'];
	$checkempty = $functions->check_empty(array($postid,$name,$email,$body));
	$cols = array("postid","username","useremail","body");
	$vals = array($postid,$name,$email,$body);
	$res = $comment->insert_comment($cols,$vals);
	echo $res==true ? 1 : 0;
	exit;
}


//Add replies
if (isset($_POST['action']) AND $_POST['action']=='addreply') {
	$commentid = $_POST['commentid'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$body = $_POST['body'];
	$checkempty = $functions->check_empty(array($commentid,$name,$email,$body));
	$cols = array("commentid","username","useremail","body");
	$vals = array($commentid,$name,$email,$body);
	$res = $comment->insert_reply($cols,$vals);
	echo $res==true ? 1 : 0;
	exit;
}



//Add Queries message
if (isset($_POST['action']) AND $_POST['action']=='addquerymsg') {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$msg = $_POST['message'];
	$checkempty = $functions->check_empty(array($name,$email,$phone,$msg));
	$cols = array("name","email","phone","message");
	$vals = array($name,$email,$phone,$msg);
	$res = $message->insert_message($cols,$vals);
	echo $res==true ? 1 : 0;
	exit;
}



//Login
if (isset($_POST['action']) AND $_POST['action']=='login') {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$res = $auth->login($username,$password);
	echo $res;
	exit;
}


// Developed by Abdul Razzaq -- ab.razzaq32@yahoo.com

 ?>