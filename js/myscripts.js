$(document).ready(function(){
	// Developed by Abdul Razzaq -- ab.razzaq32@yahoo.com
//show posts using ajax
	function showblogposts(){
		let lastid = "";
		let output = "";
		$.ajax({
			url:'./ajax/myajax.php',
			data:{action:'showblogposts'},
			dataType:'json',
			success:function(data){
				for (var i = 0;i < data.length; i++) {
					output+= "<div class='col-md-6 col-sm-12 mar-bottom-30'><div class='blog-post_wrapper image-wrapper blog-wrapper-list'><div class='blog-post-image'><a href='javascript:void' post-id="+data[i].id+" class='quickview'><img src='images/blog-listing/"+data[i].thumbnail+"' alt='image' class='img-responsive center-block post_img' /></a><div class='post-category'></div></div><div class='post-content'><div class='post-date'><p><a href='javascript:void'>"+data[i].date+"</a></p></div><h2 class='entry-title'><a href='post/"+data[i].slug+"' class=''>"+data[i].title+"</a></h2><div class='item-meta'><span>by </span><a class='author-name' href='javascript:void'>"+data[i].author+"</a></div></div></div></div>";
					lastid = data[i].id;
				}
				if (data.length>0) {
					$("#homeposts").html(output);
					$(".load_more").attr("data-id",lastid);
				}
				else{
					$("#homeposts").html("<div class='alert alert-danger'>No Posts!!</div>");
					$(".load_more").hide();
				}
				
			}
		});
	}	
	
	showblogposts();



$("#homeposts").on("click",".quickview",function(){
	let id = $(this).attr("post-id");
	// alert(id);
		let output = "";
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'showquickview',id:id},
			dataType:'json',
			success:function(data){
				if (data[0].length>0) {
					$("#post_title").text(data[0][0].title);
					$("#post_slug").text(data[0][0].slug);
					$("#post_author").text(data[0][0].author);
					$("#post_date").text(data[0][0].date);
					$("#post_status").text(data[0][0].status);
					$("#post_image").attr("src","images/blog-listing/"+data[0][0].thumbnail);
					$("#post_content").html(data[0][0].content);
					for(var i =0;i<data[1].length;i++){
						output+= "<button type='button' style='border-radius:17px' class='btn btn-primary'>"+data[1][i].cat_title+"</button> ";
					}
					$("#post_cats").html(output);
					$('#quickviewmodal').modal('show');

				}else{
					alert("Something went wrong");
				}
			}
		});
});


//Load More Posts
	$(".load_more_div").on("click",".load_more",function(){
		let load_type = $(this).attr("load-type");
		let load_by = "";
		if (load_type=="searchload") {
			load_by = "loadbysearch";
		}else if(load_type=="searchcat"){
			load_by = "loadbycat";
		}
		let searchtext = $("#searchtext").val();
		let catid = $(this).attr("cat-id");
		let dataid = $(this).attr("data-id");
		let output = "";
		$.ajax({
			url:'./ajax/myajax.php',
			data:{action:'loadmoreposts',dataid:dataid,searchtext:searchtext,cat_id:catid,loadby:load_by},
			dataType:'json',
			beforeSend : function(){
				if (dataid>1) {
					$(".load_more").text("Loading...");
				}
			},
			success:function(data){
				for (var i = 0;i < data.length; i++) {
					if (data[i].postid) {
						var p_id = data[i].postid;
					}else{
						var p_id = data[i].id;
					}
					output+= "<div class='col-md-6 col-sm-12 mar-bottom-30'><div class='blog-post_wrapper image-wrapper blog-wrapper-list'><div class='blog-post-image'><a href='javascript:void' post-id="+p_id+" class='quickview'><img src='images/blog-listing/"+data[i].thumbnail+"' alt='image' class='img-responsive center-block post_img' /></a><div class='post-category'></div></div><div class='post-content'><div class='post-date'><p><a href='javascript:void'>"+data[i].date+"</a></p></div><h2 class='entry-title'><a href='post/"+data[i].slug+"' class=''>"+data[i].title+"</a></h2><div class='item-meta'><span>by</span><a class='author-name' href='javascript:void'>"+data[i].author+"</a></div></div></div></div>";
					if (data[i].postid>0) {
						lastid = data[i].postid;
					}else{
						lastid = data[i].id;
					}
					
				}
				if (data.length>0) {
					$("#homeposts").append(output);
					$(".load_more").attr("data-id",lastid);
					$(".load_more").text("Load More");
				}
				else{
					$(".load_more").hide();
				}
			}
		});
	});


		

//show posts by category
	$("#mycatsbody").on("click",".cat_link",function(){
		let output = "";
		let catid = $(this).attr("cat_id");
		$.ajax({
			url:'./ajax/myajax.php',
			data:{action:'showpostsbycat',categoryid:catid},
			dataType:'json',
			method:'post',
			success:function(data){
				for (var i = 0;i < data.length; i++) {
					output+= "<div class='col-md-6 col-sm-12 mar-bottom-30'><div class='blog-post_wrapper image-wrapper blog-wrapper-list'><div class='blog-post-image'><a href='javascript:void' post-id="+data[i].postid+" class='quickview'><img src='images/blog-listing/"+data[i].thumbnail+"' alt='image' class='img-responsive center-block post_img' /></a><div class='post-category'></div></div><div class='post-content'><div class='post-date'><p><a href='javascript:void'>"+data[i].date+"</a></p></div><h2 class='entry-title'><a href='post/"+data[i].slug+"' class=''>"+data[i].title+"</a></h2><div class='item-meta'><span>by</span><a class='author-name' href='javascript:void'>"+data[i].author+"</a></div></div></div></div>";
					lastid = data[i].postid;
				}
				if (data.length>0) {
					$("#homeposts").hide().html(output).fadeIn(2000);
					$("#category_text").html("Posts Under: <b>"+data[0].cat_title+"</b>");
					$(".load_more").show();
					$(".load_more").attr("data-id",lastid);
					$(".load_more").attr("load-type","searchcat");
					$(".load_more").attr("cat-id",catid);
					$(".load_more").text("Load More");
				}else{
					$("#homeposts").html("");
					$("#category_text").html("<div class='alert alert-danger'>No Posts in this category</div>");
					$(".load_more").hide();
				}
			}
			
		});
	});
	


//search posts
	$(".btn-search").click(function(){
		let searchtext = $("#searchtext").val();
		let output = "";
		$.ajax({
			url:'./ajax/myajax.php',
			data:{action:'searchposts',search:searchtext},
			dataType:'json',
			method:'post',
			success:function(data){
				for (var i = 0;i < data.length; i++) {
					output+= "<div class='col-md-6 col-sm-12 mar-bottom-30'><div class='blog-post_wrapper image-wrapper blog-wrapper-list'><div class='blog-post-image'><a href='javascript:void' post-id="+data[i].id+" class='quickview'><img src='images/blog-listing/"+data[i].thumbnail+"' alt='image' class='img-responsive center-block post_img' /></a><div class='post-category'></div></div><div class='post-content'><div class='post-date'><p><a href='javascript:void'>"+data[i].date+"</a></p></div><h2 class='entry-title'><a href='post/"+data[i].slug+"' class=''>"+data[i].title+"</a></h2><div class='item-meta'><span>by</span><a class='author-name' href='javascript:void'>"+data[i].author+"</a></div></div></div></div>";
					lastid = data[i].id;
				}
				$(".close").click();
				if (data.length>0) {
					$("#category_text").html("Search Results For: <b>"+searchtext+"</b>");
					$("#homeposts").html(output);
					$(".load_more").attr("data-id",lastid);
					$(".load_more").attr("load-type","searchload");
					$(".load_more").show();
					$(".load_more").text("Load More");
				}else{
					$("#homeposts").html("");
					$(".load_more").hide();
					$("#category_text").html("<div class='alert alert-danger'>No Search Results</div>");
				}
			}
			
		});
	})



//add comments
	$("#addcommentbtn").click(function(){
		let postid = $("#post_id").val();
		let name = $("#name").val();
		let email = $("#email").val();
		let body = $("#body").val();
		$.ajax({
			url:'./ajax/myajax.php',
			data:{action:'addcomment',postid:postid,name:name,email:email,body:body},
			method:'post',
			success:function(data){
				if (data==1) {
					$("#result_comment").html("<div class='alert alert-info'>Comment will be shown after approval</div>");
					$("#commentform")[0].reset();
				}else{
					$("#result_comment").html("<div class='alert alert-danger'>"+data+"</div>");
				}
				
			}
		});
	});


//add replies
	$(".comments-lists").on("click",".btn-reply",function(){
		let commentid = $(this).attr("comment-id");
		$("#comment-id").val(commentid);
		$("#addcommentbtn").hide();
		$("#addreplybtn").show();
		
	});


	$("#addreplybtn").click(function(){
		let commentid = $("#comment-id").val();
		let name = $("#name").val();
		let email = $("#email").val();
		let body = $("#body").val();
		$.ajax({
			url:'./ajax/myajax.php',
			data:{action:'addreply',commentid:commentid,name:name,email:email,body:body},
			method:'post',
			success:function(data){
				if (data==1) {
					$("#result_comment").html("<div class='alert alert-info'>Reply Added Successfully</div>");
					$("#commentform")[0].reset();
					$("#addcommentbtn").show();
					$("#addreplybtn").hide();
				}else{
					$("#result_comment").html("<div class='alert alert-danger'>"+data+"</div>");
				}
				
			}
		});
	});





//add contact queries messages
	$("#addquerybtn").click(function(){
		let name = $("#name").val();
		let email = $("#email").val();
		let phone = $("#phone").val();
		let message = $("#message").val();
		$.ajax({
			url:'./ajax/myajax.php',
			data:{action:'addquerymsg',name:name,email:email,phone:phone,message:message},
			method:'post',
			success:function(data){
				if (data==1) {
					$(".query_result").html("<div class='alert alert-info'>Thanks for contacting us we will get back to you soon</div>");
					$("#mycontactform")[0].reset();
				}else{
					$(".query_result").html("<div class='alert alert-danger'>"+data+"</div>");
				}
				
			}
		});
	});



//login
$("#login_btn").click(function(){
	let username = $("#username").val();
	let password = $("#password").val();
	$.ajax({
		url:'./ajax/myajax.php',
		data:{action:'login',username:username,password:password},
		method:'post',
		success:function(data){
			if (data==1) {
				window.location.href = "backend";
			}else{
				$("#login_result").html("<div class='alert alert-danger'>"+data+"</div>");
			}
		}
	});
});


	


if ($(window).width() < 975) {
	$('#blog_area').removeClass('pull-right');
} else {
    $('#blog_area').addClass('pull-right');
}



// Developed by Abdul Razzaq -- ab.razzaq32@yahoo.com

});