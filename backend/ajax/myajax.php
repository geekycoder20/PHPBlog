<?php 
include("../../config/init.php");
$project_path = "/blog/";

// Developed by Abdul Razzaq -- ab.razzaq32@yahoo.com

//////////////////////////////////////////////////////////////////////////////////////////////
//										 Categories 										//
/////////////////////////////////////////////////////////////////////////////////////////////
//Show Categories
if (isset($_GET['action']) AND $_GET['action']=='showcats') {
	$res = $category->show_categories();
	$results = $res->fetchAll(PDO::FETCH_ASSOC);
	$json = json_encode($results);
	echo $json;
	exit;
}


//add categories
if (isset($_POST['action']) AND $_POST['action']=='addcat') {
	$cat_title = htmlspecialchars($_POST['title']);
	$checkempty = $functions->check_empty(array($cat_title));
	$cols = array("cat_title");
	$vals = array($cat_title);
	$res = $category->insert_category($cols,$vals);
	echo $res==true ? 1 : 0;
	exit;
}


//delete categories
if (isset($_POST['action']) AND $_POST['action']=='deletecat') {
	$id = $_POST['delid'];
	$res = $category->delete_category($id);
	echo $res==true ? 1 : 0;
	exit;
}


//edit categories
if (isset($_POST['action']) AND $_POST['action']=='editcat') {
	$id = $_POST['editid'];
	$res = $category->edit_category($id);
	$results = $res->fetchAll(PDO::FETCH_ASSOC);
	$json = json_encode($results);
	echo $json;
	exit;
}


//update categories
if (isset($_POST['action']) AND $_POST['action']=='updatecat') {
	$cat_id = $_POST['id'];
	$cat_title = $_POST['title'];
	$checkempty = $functions->check_empty(array($cat_title));
	$cols = array("cat_title");
	$vals = array($cat_title);
	$res = $category->update_category($cols,$vals,$cat_id);
	echo $res==true ? 1 : 0;
	exit;
}





//////////////////////////////////////////////////////////////////////////////////////////////
//									           Posts 										//
/////////////////////////////////////////////////////////////////////////////////////////////
//add post
	if (isset($_POST['action']) AND $_POST['action']=='addpost') {
		$post_title = $_POST['title'];
		$post_content = $_POST['content'];
		$post_slug = $functions->slug($_POST['slug']);
		$post_author = $_SESSION['username'];
		$post_cat_links = isset($_POST['catlinks']) ? $_POST['catlinks'] : "";
		$checkempty = $functions->check_empty(array($post_title,$post_content,$post_slug,$post_author,$post_cat_links));
		$limits = $setting->find_limits();
        $alllimits = $limits->fetch();
        $limit = $alllimits['postcats'];
		if (count($post_cat_links)>$limit) {
			echo "Max ".$limit." cats are allowed";
			exit;
		}

		//check if slug already exists
		$res = $database->find_query("posts",$post_slug,"slug");
		$rows = $res->rowCount(); 
		if ($rows>0) {
			echo "Slug already exists. Please try some different slug";
			exit;
		}

		//upload image
		$path = $_SERVER['DOCUMENT_ROOT'].$project_path;
		$img_name = time().".";
		$img_name .= pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
		$tmp_name = $_FILES['image']['tmp_name'];
		$img_size = $_FILES['image']['size'];
		$img_type = $_FILES['image']['type'];
		$uploadok = true;
		$target_dir = $path."images/blog-listing/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$check = getimagesize($tmp_name);
		//check if image is actually an image
		if ($check==false) {
			echo "File must be an image";
			exit;
		}
		//check file extenstions
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			echo "Only jpg,png,jpeg,gig extentions are allowed";
			exit;
		}
		if ($uploadok == true) {
			move_uploaded_file($tmp_name, $target_dir.$img_name);
		}

		//insert data into table
		$cols = array("title","content","slug","author","thumbnail");
		$vals = array($post_title,$post_content,$post_slug,$post_author,$img_name);
		$res_array = $post->insert_post($cols,$vals);
		if ($res_array[0]!=1) {
			echo 0;
			exit;
		}
		$last_post_id = $res_array[1];

		// insert cat links 
		$cols = array("catid","postid");
		for ($i=0; $i < count($post_cat_links) ; $i++) { 
			$vals = array($post_cat_links[$i],$last_post_id);
			$res = $database->insert_query("cat_links",$cols,$vals);
			if ($res != true ) {
				echo 0;
				exit;
			}
		}
		echo $res_array[0];
		exit;
	}


//Show Posts with pagination
if (isset($_GET['action']) AND $_GET['action']=='showposts') {
	$userrole = $_SESSION['role'];
	if (isset($_GET['page_no'])) {
		$page_no = $_GET['page_no'];
	}else{
		$page_no = 1;
	}
	$limits = $setting->find_limits();
	$alllimits = $limits->fetch();
	$posts_per_page = $alllimits['postsadmin'];
	
	$offset = ($page_no-1)*$posts_per_page;
	$res = $post->show_posts_pagination($offset,$posts_per_page);
	if ($_SESSION['role']=="Admin" OR $_SESSION['role']=="Moderator") {
		$allposts = $post->all_posts();
	}else{
		$allposts = $database->find_query("posts",$_SESSION['username'],"author");
	}
	$total_posts = $allposts->rowCount();
	$total_pages = ceil($total_posts/$posts_per_page);
	$results = $res->fetchAll(PDO::FETCH_ASSOC);
	$json = json_encode([$results,$total_pages,$userrole]);
	echo $json;
	exit;
}


//delete posts
if (isset($_POST['action']) AND $_POST['action']=='deletepost') {
	$id = $_POST['delid'];
	$res = $post->delete_post($id);
	echo $res==true ? 1 : 0;
	exit;
}


//publish posts
if (isset($_POST['action']) AND $_POST['action']=='publishpost') {
	$userrole = $_SESSION['role'];
	if ($userrole!="Admin" AND $userrole!="Moderator") {
		echo "Not Allowed";
		exit;
	}
	$id = $_POST['pubid'];
	$cols = array("status");
	$vals = array("Published");
	$res = $database->update_query("posts",$cols,$vals,$id);
	echo $res==true ? 1 : 0;
	exit;
}


//edit posts
if (isset($_POST['action']) AND $_POST['action']=='editpost') {
	$id = $_POST['editid'];
	$res = $post->edit_post($id);
	$results = $res->fetchAll(PDO::FETCH_ASSOC);

	//code for marking categories checkbox on edit post
	$myattr = "";
	$mycats = "";
	$myres = $category->show_categories();
	while ($row = $myres->fetch()) {
		$stmt = $database->con->prepare("SELECT * FROM posts,categories,cat_links WHERE posts.id=cat_links.postid AND categories.id=cat_links.catid AND cat_links.postid=:postid");
		$myres2 = $stmt->execute([':postid'=>$id]);
		while ($row2 = $stmt->fetch()) {
			if ($row['id']==$row2['catid']) {
				$myattr = "checked";
			}
		}
		$mycats .= "<label class='checkbox-inline'><input type='checkbox' $myattr name='catlinks[]' id='cat_link' value='{$row['id']}'>{$row['cat_title']}</label>";
		$myattr = "";	
	}

	$json = json_encode([$results,$mycats]);
	echo $json;
	exit;
}




//show single post
if (isset($_POST['action']) AND $_POST['action']=='showsinglepost') {
	$role = $_SESSION['role'];
	$author = $_SESSION['username'];
	$id = $_POST['id'];
	if ($role=="Admin" OR $role=="Moderator") {
		$stmt = $database->find_query("posts",$id);
	}
	else{
		$stmt = $database->where_query("posts","id","=",$id,"AND","author","=",$author,"id","ASC","");
	}
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$results2 = $category->postcategories($id); //categories of post
	$json = json_encode([$results,$results2]);
	echo $json;
	exit;
}



//update post
if (isset($_POST['action']) AND $_POST['action']=='updatepost') {
		$post_id = $_POST['id'];
		$post_title = $_POST['title'];
		$post_slug = $functions->slug($_POST['slug']);
		$post_content = $_POST['content'];
		$post_cat_links = isset($_POST['catlinks']) ? $_POST['catlinks'] : "";
		$checkempty = $functions->check_empty(array($post_title,$post_cat_links,$post_content,$post_slug));
		$limits = $setting->find_limits();
        $alllimits = $limits->fetch();
        $limit = $alllimits['postcats'];
		if (count($post_cat_links)>$limit) {
			echo "Max ".$limit." cats are allowed";
			exit;
		}

		//check if slug already exists
		$stmt = $database->where_query("posts","slug","=",$post_slug,"AND","id","!=",$post_id,"id","ASC","");
		$rows = $stmt->rowCount(); 
		if ($rows>0) {
			echo "Slug already exists. Please try some different slug";
			exit;
		}

		if (!empty($_FILES['image']['name'])){
		$path = $_SERVER['DOCUMENT_ROOT'].$project_path;
		$img_name = time().".";
		$img_name .= pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
		$tmp_name = $_FILES['image']['tmp_name'];
		$img_size = $_FILES['image']['size'];
		$img_type = $_FILES['image']['type'];
		$uploadok = true;
		$target_dir = $path."images/blog-listing/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$check = getimagesize($tmp_name);
		//check if image is actually an image
		if ($check==false) {
			echo "File must be an image";
			exit;
		}
		//check file extenstions
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			echo "Only jpg,png,jpeg,gig extentions are allowed";
			exit;
		}
		if ($uploadok == true) {
			move_uploaded_file($tmp_name, $target_dir.$img_name);
		}

		$cols = array("title","content","slug","thumbnail");
		$vals = array($post_title,$post_content,$post_slug,$img_name);
	}else{
		$cols = array("title","content","slug");
		$vals = array($post_title,$post_content,$post_slug);
	}
		//update data into table
		$res = $post->update_post($cols,$vals,$post_id);
		//delete old cat links
		$database->delete_query("cat_links",$post_id,"postid");
		// insert new cat links 
		$cols = array("catid","postid");
		for ($i=0; $i < count($post_cat_links) ; $i++) { 
			$vals = array($post_cat_links[$i],$post_id);
			$res = $database->insert_query("cat_links",$cols,$vals);
			if ($res != true ) {
				echo 0;
				exit;
			}
		}
		echo $res==true ? 1 : 0;
		exit;
	}






//////////////////////////////////////////////////////////////////////////////////////////////
//									           Pages 										//
/////////////////////////////////////////////////////////////////////////////////////////////
//add pages
if (isset($_POST['action']) AND $_POST['action']=='addpage') {
	$page_title = $_POST['title'];
	$page_slug = $functions->slug($_POST['slug']);
	$page_content = $_POST['content'];
	$checkempty = $functions->check_empty(array($page_title,$page_slug,$page_content));
	//check if slug already exists
	$res = $database->find_query("pages",$page_slug,"slug");
	$rows = $res->rowCount(); 
	if ($rows>0) {
		echo "Slug already exists. Please try some different slug";
		exit;
	}

	$cols = array("title","slug","content");
	$vals = array($page_title,$page_slug,$page_content);
	$res = $page->insert_page($cols,$vals);
	echo $res==true ? 1 : 0;
	exit;
}


//Show Pages
if (isset($_GET['action']) AND $_GET['action']=='showpages') {
	$res = $page->show_pages();
	$results = $res->fetchAll(PDO::FETCH_ASSOC);
	$json = json_encode($results);
	echo $json;
	exit;
}


//delete Pages
if (isset($_POST['action']) AND $_POST['action']=='deletepage') {
	$id = $_POST['delid'];
	$res = $page->delete_page($id);
	echo $res==true ? 1 : 0;
	exit;
}


//edit Pages
if (isset($_POST['action']) AND $_POST['action']=='editpage') {
	$id = $_POST['editid'];
	$res = $page->edit_page($id);
	$results = $res->fetchAll(PDO::FETCH_ASSOC);
	$json = json_encode([$results]);
	echo $json;
	exit;
}



//update page
if (isset($_POST['action']) AND $_POST['action']=='updatepage') {
		$page_id = $_POST['id'];
		$page_title = $_POST['title'];
		$page_slug = $functions->slug($_POST['slug']);
		$page_content = $_POST['content'];
		$checkempty = $functions->check_empty(array($page_title,$page_slug,$page_content));
		//check if slug already exist
		$stmt = $database->where_query("pages","slug","=",$page_slug,"AND","id","!=",$page_id,"id","ASC","");
		$rows = $stmt->rowCount(); 
		if ($rows>0) {
			echo "Slug already exists. Please try some different slug";
			exit;
		}

		$cols = array("title","content","slug");
		$vals = array($page_title,$page_content,$page_slug);
		$res = $page->update_page($cols,$vals,$page_id);
		echo $res==true ? 1 : 0;
		exit;
	}





//////////////////////////////////////////////////////////////////////////////////////////////
//									           Sliders 										//
/////////////////////////////////////////////////////////////////////////////////////////////
//Show Sliders
if (isset($_GET['action']) AND $_GET['action']=='showsliders') {
	$res = $slider->show_sliders();
	$results = $res->fetchAll(PDO::FETCH_ASSOC);
	$json = json_encode($results);
	echo $json;
	exit;
}


//add slider
if (isset($_POST['action']) AND $_POST['action']=='addslider') {
	$postid = $_POST['postid'];
	//check if post is already added into slider
	$slider_res = $slider->find_slider($postid);
	$row = $slider_res->rowCount();
	if ($row>0) {
		echo "Post is already added into slider";
		exit;
	}
	//check if posts are greater than slider limit
	$slider_res = $slider->all_sliders();
	$row = $slider_res->rowCount();
	if ($row==5) {
		echo "Max 5 sliders are allowed";
		exit;
	}
	//insert slider
	$cols = array("postid");
	$vals = array($postid);
	$res = $slider->insert_slider($cols,$vals);
	echo $res==true ? 1 : 0;
	exit;
}


//Search Posts for slider
if (isset($_POST['action']) AND $_POST['action']=='searchslider') {
	$search_val = $_POST['search_val'];
	$res = $post->search_posts($search_val);
	$results = $res->fetchAll(PDO::FETCH_ASSOC);
	$json = json_encode($results);
	echo $json;
	exit;
}


//delete slider
if (isset($_POST['action']) AND $_POST['action']=='deleteslider') {
	$postid = $_POST['postid'];
	$res = $slider->delete_slider($postid);
	echo $res==true ? 1 : 0;
	exit;
}






//////////////////////////////////////////////////////////////////////////////////////////////
//									           Users 										//
/////////////////////////////////////////////////////////////////////////////////////////////
//add users
if (isset($_POST['action']) AND $_POST['action']=='adduser') {
	$fullname = $_POST['fullname'];
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$conpassword = md5($_POST['conpassword']);
	$email = $_POST['email'];
	$role = $_POST['role'];
	$checkempty = $functions->check_empty(array($fullname,$username,$password,$conpassword,$email,$role));
	if (!preg_match('/^[a-z0-9]{6,20}$/',$username)) {
      echo "Please enter a valid username between 6 to 20 characters";
      exit;
    }

	if ($password!=$conpassword) {
		echo "Passwords don't match";
		exit;
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "Email is not a valid email address";
		exit;
	}

	//check if username already exists
	$users = $user->all_users();
	while ($row = $users->fetch()) {
		if ($row['username']==$username or $row['email']==$email) {
			echo "Username or email already exists";
			exit;
		}
	}

	$cols = array("fullname","username","password","email","role");
	$vals = array($fullname,$username,$password,$email,$role);
	$res = $user->insert_user($cols,$vals);

	//insert social links for last inserted user
	if ($res[0]!=1) {
		echo 0;
		exit;
	}
	$last_user_id = $res[1];
	$cols2 = array("userid","fb","twitter","gplus","linkedin");
	$vals2 = array($last_user_id,"","","","");
	$res2 = $database->insert_query("social_links",$cols2,$vals2);
	echo $res==true ? 1 : 0;
	exit;
}


//Show Users
if (isset($_GET['action']) AND $_GET['action']=='showusers') {
	$res = $user->all_users();
	$results = $res->fetchAll(PDO::FETCH_ASSOC);
	$json = json_encode($results);
	echo $json;
	exit;
}



//delete user
if (isset($_POST['action']) AND $_POST['action']=='deleteuser') {
	$userid = $_POST['userid'];
	$res = $user->delete_user($userid);
	$res2 = $database->delete_query("social_links",$userid,"userid"); //delete social links of user
	echo $res==true ? 1 : 0;
	exit;
}



//update user profile
if (isset($_POST['action']) AND $_POST['action']=='updateprofile') {
	$userid = $_SESSION['userid'];
	$fullname = $_POST['fullname'];
	$about = $_POST['about'];
	$checkempty = $functions->check_empty(array($fullname,$about));
	//upload image
	$path = $_SERVER['DOCUMENT_ROOT'].$project_path;
	$upload_dir = $path."images/blog/";
	$img_name = $_FILES['userimage']['name'];
	$new_name = time().$img_name;
	$img_tmp = $_FILES['userimage']['tmp_name'];
	$img_size = $_FILES['userimage']['size'];
	$img_type = $_FILES['userimage']['type'];
	$ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
	if ($ext!="jpg" and $ext!="png" and $ext!="jpeg" and $ext!="gif") {
		echo "Only jpg, png or gif files are allowed";
		exit;
	}else{
		move_uploaded_file($img_tmp, $upload_dir.$new_name);
	}
	
	$cols = array("fullname","about","image");
	$vals = array($fullname,$about,$new_name);
	$res = $user->update_profile($cols,$vals,$userid);
	echo $res==true ? 1 : 0;
	exit;
}



//update social links
if (isset($_POST['action']) AND $_POST['action']=='updatesociallinks') {
	$userid = $_SESSION['userid'];
	$fb = $_POST['fb'];
	$twitter = $_POST['twitter'];
	$gplus = $_POST['gplus'];
	$linkedin = $_POST['linkedin'];
	if (!filter_var($fb, FILTER_VALIDATE_URL) or !filter_var($twitter, FILTER_VALIDATE_URL) or !filter_var($gplus, FILTER_VALIDATE_URL) or !filter_var($linkedin, FILTER_VALIDATE_URL)) {
		echo "Please type valid urls";
		exit;
	}
	$cols = array("fb","twitter","gplus","linkedin");
	$vals = array($fb,$twitter,$gplus,$linkedin);
	$res = $user->update_social_links($cols,$vals,$userid);
	echo $res==true ? 1 : 0;
	exit;
}



//Change user password
if (isset($_POST['action']) AND $_POST['action']=='changepwd') {
	$userid = $_SESSION['userid'];
	$currentpwd = md5($_POST['currentpwd']);
	$newpwd = $_POST['newpwd'];
	$connewpwd = $_POST['connewpwd'];
	$checkempty = $functions->check_empty(array($currentpwd,$newpwd,$connewpwd));
	$myuser = $database->find_query("users",$userid);
	$userrow = $myuser->fetch();
	if ($userrow['password']!=$currentpwd) {
		echo "Current Password is wrong";
		exit;
	}
	if ($newpwd!=$connewpwd) {
		echo "Passwords don't match";
		exit;
	}

	$cols = array("password");
	$vals = array(md5($newpwd));
	$res = $user->change_password($cols,$vals,$userid);
	echo $res==true ? 1 : 0;
	exit;
}



//////////////////////////////////////////////////////////////////////////////////////////////
//									           Comments 									//
/////////////////////////////////////////////////////////////////////////////////////////////
//Show Comments with pagination
if (isset($_GET['action']) AND $_GET['action']=='showcomments') {
	$limits = $setting->find_limits();
	$alllimits = $limits->fetch();
	$comments_per_page = $alllimits['comments'];
	$pageno = isset($_GET['page']) ? $_GET['page'] : 1;
	$offset = ($pageno - 1)*$comments_per_page;
	$allcomments = $comment->all_comments()->rowCount();
	$totalpages = ceil($allcomments/$comments_per_page);
	$res = $comment->comments_with_pagination($offset,$comments_per_page);
	$results = $res->fetchAll(PDO::FETCH_ASSOC);
	$json = json_encode([$results,$totalpages]);
	echo $json;
	exit;
}


//approve comments
if (isset($_POST['action']) AND $_POST['action']=='approvecomment') {
	$id = $_POST['apprid'];
	$cols = array("status");
	$vals = array("Approved");
	$res = $database->update_query("comments",$cols,$vals,$id);
	echo $res==true ? 1 : 0;
	exit;
}



//approve all comments
if (isset($_POST['action']) AND $_POST['action']=='approveallcomments') {
	$postid = $_POST['postid'];
	$comments = $database->find_query("comments",$postid,"postid");
	$cmtcount = $comments->rowCount();
	if ($cmtcount<1) {
		echo "No comments to approve";
		exit;
	}
	$cols = array("status");
	$vals = array("Approved");
	$res = $database->update_query("comments",$cols,$vals,$postid,"postid");
	echo $res==true ? 1 : 0;
	exit;
}



//delete comments
if (isset($_POST['action']) AND $_POST['action']=='deletecomment') {
	$id = $_POST['delid'];
	$res = $comment->delete_comment($id);
	echo $res==true ? 1 : 0;
	exit;
}






//////////////////////////////////////////////////////////////////////////////////////////////
//										 Messages 										//
/////////////////////////////////////////////////////////////////////////////////////////////
//Show messages
if (isset($_GET['action']) AND $_GET['action']=='showmsgs') {
	$res = $message->show_msgs();
	$results = $res->fetchAll(PDO::FETCH_ASSOC);
	$json = json_encode($results);
	echo $json;
	exit;
}


//delete messages
if (isset($_POST['action']) AND $_POST['action']=='deletemsg') {
	$id = $_POST['delid'];
	$res = $message->delete_msg($id);
	echo $res==true ? 1 : 0;
	exit;
}



//show single message
if (isset($_POST['action']) AND $_POST['action']=='showsinglemsg') {
	$id = $_POST['id'];
	$res = $database->find_query("contact_queries",$id);

	$cols = array("status");
	$vals = array("read");
	$res2 = $database->update_query("contact_queries",$cols,$vals,$id);
	
	$results = $res->fetchAll(PDO::FETCH_ASSOC);
	$json = json_encode($results);
	echo $json;
	exit;
}


//Send Reply
if (isset($_POST['action']) AND $_POST['action']=='sendreply') {
	$subject = $_POST['subject'];
	$email = $_POST['email'];
	$reply = $_POST['reply'];
	$reply = wordwrap($reply,70);
	$checkempty = $functions->check_empty(array($subject,$email,$reply));
	if(mail($email,$subject,$reply)){
		echo 1;
	}else{
		echo 0;
	}
	exit;
}





//////////////////////////////////////////////////////////////////////////////////////////////
//										  Settings  										//
/////////////////////////////////////////////////////////////////////////////////////////////
//update limits
if (isset($_POST['action']) AND $_POST['action']=='updatelimits') {
	$limitid = 1;
	$postsblog = $_POST['postsblog'];
	$postsadmin = $_POST['postsadmin'];
	$sliderlimit = $_POST['sliderlimit'];
	$loadmorelimit = $_POST['loadmorelimit'];
	$popularlimit = $_POST['popularlimit'];
	$randomlimit = $_POST['randomlimit'];
	$catslimit = $_POST['catslimit'];
	$commentslimit = $_POST['commentslimit'];

	$checkempty = $functions->check_empty(array($postsblog,$postsadmin,$sliderlimit,$loadmorelimit,$popularlimit,$randomlimit,$catslimit,$commentslimit));

	if (!is_numeric($postsblog) or !is_numeric($postsadmin) or !is_numeric($sliderlimit) or !is_numeric($loadmorelimit) or !is_numeric($popularlimit) or !is_numeric($randomlimit) or !is_numeric($catslimit) or !is_numeric($commentslimit)) {
		echo "Please type numeric values";
		exit;
	}

	$cols = array("postsblog","postsadmin","slider","loadmore","popular","random","postcats","comments");
	$vals = array($postsblog,$postsadmin,$sliderlimit,$loadmorelimit,$popularlimit,$randomlimit,$catslimit,$commentslimit);
	$res = $setting->update_limits($cols,$vals,$limitid);
	echo $res==true ? 1 : 0;
	exit;
}






//Logout
if (isset($_POST['action']) AND $_POST['action']=='logout') {
	$res = $auth->logout();
	echo $res==true ? 1 : 0;
}



// Developed by Abdul Razzaq -- ab.razzaq32@yahoo.com

 ?>