$(document).ready(function(){
	// Developed by Abdul Razzaq -- ab.razzaq32@yahoo.com
////////////////////////////////////////////////////////////////////////////////////////////////////////
//												Categories 											  //
////////////////////////////////////////////////////////////////////////////////////////////////////////
	//show categories using ajax
	function showcategories(){
		let output = "";
		$.ajax({
			url:'./ajax/myajax.php',
			data:{action:'showcats'},
			dataType:'json',
			success:function(data){
				for (var i = 0; i < data.length; i++) {
					output += "<tr><td>"+data[i].id+"</td><td>"+data[i].cat_title+"</td><td>"+"<button class='button gray btn-edit' edit-id="+data[i].id+" style='margin-right:5px;'><i class='sl sl-icon-pencil'></i></button>"+"<button class='button gray btn-del' del-id="+data[i].id+"><i class='sl sl-icon-close'></i></button>"+"</td></tr>";
				}
				$("#catsbody").html(output);
			}
		});
	}
	showcategories();
	


	//delete categories using ajax
	$("#catsbody").on("click",".btn-del",function(){
		let id = $(this).attr("del-id");
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'deletecat',delid:id},
			success:function(data){
				if (data==1) {
					showcategories();
				}else{
					alert("Something went wrong");
				}
			}
		});
	});


	//edit categories using ajax
	$("#catsbody").on("click",".btn-edit",function(){
		let id = $(this).attr("edit-id");
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'editcat',editid:id},
			dataType:'json',
			success:function(data){
				$('#addcatmodal').modal('show');
				$("#addcatform").hide();
				$("#editcatform").show();
				$("#edit_title").val(data[0].cat_title);
				$("#catid").val(data[0].id);
				
			}
		});
	});



	//update categories using ajax
	$("#updatecatbtn").click(function(e){
		e.preventDefault();
		let cat_id = $("#catid").val();
		let cat_title = $("#edit_title").val();
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'updatecat',title:cat_title,id:cat_id},
			success:function(data){
				if (data==1) {
					$(".result").html("<div class='alert alert-success'>Updated Successfully.</div>");
					$("#addcatform")[0].reset();
					showcategories();
					autoclosealert();
				}else if(data==0){
					$(".result").html("<div class='alert alert-danger'>Something went wrong.</div>");
					autoclosealert();
				}else{
					$(".result").html("<div class='alert alert-danger'>"+data+"</div>");
				}
			}
		});
	});



	//add categories using ajax
	$("#addcatbtn").click(function(e){
		e.preventDefault();
		let cat_title = $("#title").val();
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'addcat',title:cat_title},
			success:function(data){
				if (data==1) {
					$(".result").html("<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Added Successfully.</div>");
					$("#addcatform")[0].reset();
					autoclosealert();
					showcategories();
				}else if (data==0){
					$(".result").html("<div class='alert alert-danger'>Something went wrong.</div>");
					autoclosealert();
				}else{
					$(".result").html("<div class='alert alert-danger'>"+data+"</div>");
				}
			}
		});
	})



	//Hide update form when click on add category button
	$(".btn-cat-add").click(function(){
		$("#addcatform")[0].reset();
		$("#editcatform").hide();
		$("#addcatform").show();
	});







////////////////////////////////////////////////////////////////////////////////////////////////////////
//												Posts 											  //
////////////////////////////////////////////////////////////////////////////////////////////////////////
//add posts
	$("#addpostbtn").click(function(e){
		let content = CKEDITOR.instances['content'].getData();
		e.preventDefault();
		var formdata = new FormData($("#postform")[0]);
		formdata.append('action', 'addpost');
		formdata.append('content', content);
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data: formdata,
			contentType:false,
			processData:false,
			success:function(data){
				if (data==1) {
					$(".result_post").html("<div class='alert alert-success'>Post Added Successfully</div>");
					$("#postform")[0].reset();
					CKEDITOR.instances['content'].setData("");
					showposts();
					autoclosealert();
				}else if (data==0){
					$(".result_post").html("<div class='alert alert-danger'>Something went wrong</div>");
					autoclosealert();
				}else{
					$(".result_post").html("<div class='alert alert-danger'>"+data+"</div>");
				}
			}
		});
	})



//show posts with pagination using ajax
	function showposts(page){
		let output = "";
		let output2 = "";
		let myclass = "";
		let currentstatus = "";
		$.ajax({
			url:'./ajax/myajax.php',
			data:{action:'showposts',page_no:page},
			dataType:'json',
			beforeSend:function(){
				$(".loader_ajax").show();
			},
			success:function(data){
				for (var i = 0; i < data[0].length; i++) {
					if ((data[0][i].status=='draft') && (data[2]=='Admin' || data[2]=='Moderator')) {
						currentstatus = "<button class='btn btn-primary' id='pub_btn' pub-id="+data[0][i].id+">Publish</button>";
					}else{
						currentstatus = data[0][i].status;
					}

					output += "<tr><td>"+data[0][i].id+"</td><td><a href='#postmodal' class='post-link' link-id="+data[0][i].id+" style='color:blue' data-toggle='modal' data-target='#postmodal'>"+substr(data[0][i].title,40)+"</a></td><td>"+substr($(data[0][i].content).text(),40)+"</td><td>"+currentstatus+"</td><td>"+"<button class='button gray btn-edit' edit-id="+data[0][i].id+" style='margin-right:5px;'><i class='sl sl-icon-pencil'></i></button>"+"<button class='button gray btn-del' del-id="+data[0][i].id+"><i class='sl sl-icon-close'></i></button>"+"</td></tr>";
				}
				$("#postsbody").html(output);

				//show pagination pages if pages are more than 1
				if(data[1]>1){
					for(var x = 1; x<=data[1]; x++){
						if(page==x){
							myclass = 'active';
						}else{
							myclass = '';
						}
						output2+= "<li><button class='"+myclass+" page_btn' page-no="+x+">"+x+"</button></li>";
					}
					$(".pagination_posts").html(output2);
				}
				$(".loader_ajax").hide();
			}
		});
	}
	showposts();
	$(".pagination_posts").on("click",".page_btn",function(){
		let pageno = $(this).attr("page-no");
		showposts(pageno);
	});




//publish posts
	$("#postsbody").on("click","#pub_btn",function(){
		let id = $(this).attr("pub-id");
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'publishpost',pubid:id},
			success:function(data){
				if (data==1) {
					showposts();
				}else{
					alert("Something went wrong");
				}
			}
		});
	});



//delete posts using ajax
	$("#postsbody").on("click",".btn-del",function(){
		let id = $(this).attr("del-id");
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'deletepost',delid:id},
			success:function(data){
				if (data==1) {
					showposts();
				}else{
					alert("Something went wrong");
				}
			}
		});
	});


//show single post detail
	$("#postsbody").on("click",".post-link",function(){
		let id = $(this).attr("link-id");
		let output = "";
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'showsinglepost',id:id},
			dataType:'json',
			success:function(data){
				if (data[0].length>0) {
					$("#post_title").text(data[0][0].title);
					$("#post_slug").text(data[0][0].slug);
					$("#post_author").text(data[0][0].author);
					$("#post_date").text(data[0][0].date);
					$("#post_status").text(data[0][0].status);
					$("#post_image").attr("src","../images/blog-listing/"+data[0][0].thumbnail);
					$("#post_content").html(data[0][0].content);
					$("#addsliderbtn").attr("post-id",data[0][0].id);
					$("#apprallcomments").attr("post-id",data[0][0].id);
					for(var i =0;i<data[1].length;i++){
						output+= "<button type='button' style='border-radius:17px' class='btn btn-primary'>"+data[1][i].cat_title+"</button> ";
					}
					$("#post_cats").html(output);

				}else{
					alert("Something went wrong");
				}
			}
		});
	});



//edit posts using ajax
	$("#postsbody").on("click",".btn-edit",function(){
		let id = $(this).attr("edit-id");
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'editpost',editid:id},
			dataType:'json',
			success:function(data){
				$('.nav-tabs a[href="#menu1"]').tab('show')
				$("#addpostbtn").hide();
				$("#updatepostbtn").show();
				$("#postid").val(data[0][0].id);
				$("#title").val(data[0][0].title);
				$("#slug").val(data[0][0].slug);
				$("#post_img").show();
				$("#post_img").attr("src","../images/blog-listing/"+data[0][0].thumbnail);
				// $("#content").val(data[0][0].content);
				CKEDITOR.instances['content'].setData(data[0][0].content);
				$(".postcats").html(data[1]);
			}
		});
	});




//update posts
	$("#updatepostbtn").click(function(e){
		e.preventDefault();
		let content = CKEDITOR.instances['content'].getData();
		let post_id = $("#postid").val();
		var formdata = new FormData($("#postform")[0]);
		formdata.append('action', 'updatepost');
		formdata.append('id', post_id);
		formdata.append('content', content);
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data: formdata,
			contentType:false,
			processData:false,
			success:function(data){
				if (data==1) {
					$(".result_post").html("<div class='alert alert-success'>Post Updated Successfully</div>");
					showposts();
					autoclosealert();
				}else if (data==0){
					$(".result_post").html("<div class='alert alert-danger'>Something went wrong</div>");
					autoclosealert();
				}else{
					$(".result_post").html("<div class='alert alert-danger'>"+data+"</div>");

				}
			}
		});
	})





//Hide update button when click on add post tab
	$("#addtab").click(function(){
		$("#postform")[0].reset();
		$("#updatepostbtn").hide();
		$("#addpostbtn").show();
		$("input[name='catlinks[]']").attr("checked",false);
		$("#post_img").hide();
		CKEDITOR.instances['content'].setData("");
	});







////////////////////////////////////////////////////////////////////////////////////////////////////////
//									    			Pages 											  //
////////////////////////////////////////////////////////////////////////////////////////////////////////
//add pages using ajax
	$("#addpagebtn").click(function(e){
		e.preventDefault();
		let page_title = $("#title").val();
		let page_slug = $("#slug").val();
		let page_content = CKEDITOR.instances['content'].getData();
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'addpage',title:page_title,slug:page_slug,content:page_content},
			success:function(data){
				if (data==1) {
					$(".result_page").html("<div class='alert alert-success'>Added Successfully.</div>");
					$("#pageform")[0].reset();
					CKEDITOR.instances['content'].setData("");
					showpages();
					autoclosealert();
				}else if(data==0){
					$(".result_page").html("<div class='alert alert-danger'>Something went wrong.</div>");
					autoclosealert();
				}else{
					$(".result_page").html("<div class='alert alert-danger'>"+data+"</div>");
				}
			}
		});
	})


//show pages using ajax
	function showpages(){
		let output = "";
		$.ajax({
			url:'./ajax/myajax.php',
			data:{action:'showpages'},
			dataType:'json',
			success:function(data){
				for (var i = 0; i < data.length; i++) {
					output += "<tr><td>"+data[i].id+"</td><td>"+substr(data[i].title,70)+"</td><td>"+substr($(data[i].content).text(),50)+"</td><td>"+"<button class='button gray btn-edit' edit-id="+data[i].id+" style='margin-right:5px;'><i class='sl sl-icon-pencil'></i></button>"+"<button class='button gray btn-del' del-id="+data[i].id+"><i class='sl sl-icon-close'></i></button>"+"</td></tr>";
				}
				$("#pagesbody").html(output);
			}
		});
	}
	showpages();
	


//delete pages using ajax
	$("#pagesbody").on("click",".btn-del",function(){
		let id = $(this).attr("del-id");
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'deletepage',delid:id},
			success:function(data){
				if (data==1) {
					showpages();
				}else{
					alert("Something went wrong");
				}
			}
		});
	});




//edit pages using ajax
	$("#pagesbody").on("click",".btn-edit",function(){
		let id = $(this).attr("edit-id");
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'editpage',editid:id},
			dataType:'json',
			success:function(data){
				$('.nav-tabs a[href="#menu1"]').tab('show')
				$("#addpagebtn").hide();
				$("#updatepagebtn").show();
				$("#pageid").val(data[0][0].id);
				$("#title").val(data[0][0].title);
				$("#slug").val(data[0][0].slug);
				CKEDITOR.instances['content'].setData(data[0][0].content);
			}
		});
	});



//update pages
	$("#updatepagebtn").click(function(e){
		e.preventDefault();
		let content = CKEDITOR.instances['content'].getData();
		let page_id = $("#pageid").val();
		var formdata = new FormData($("#pageform")[0]);
		formdata.append('action', 'updatepage');
		formdata.append('id', page_id);
		formdata.append('content', content);
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data: formdata,
			contentType:false,
			processData:false,
			success:function(data){
				if (data==1) {
					$(".result_page").html("<div class='alert alert-success'>Page Updated Successfully</div>");
					showpages();
					autoclosealert();
				}else if (data==0){
					$(".result_page").html("<div class='alert alert-danger'>Something went wrong</div>");
					autoclosealert();
				}else{
					$(".result_page").html("<div class='alert alert-danger'>"+data+"</div>");
				}
			}
		});
	})



	//Hide update button when click on add page tab
	$("#addpagetab").click(function(){
		$("#pageform")[0].reset();
		$("#updatepagebtn").hide();
		$("#addpagebtn").show();
		CKEDITOR.instances['content'].setData("");
	});







////////////////////////////////////////////////////////////////////////////////////////////////////////
//									    			Slider 											  //
////////////////////////////////////////////////////////////////////////////////////////////////////////
//show sliders using ajax
	function showsliders(){
		let output = "";
		$.ajax({
			url:'./ajax/myajax.php',
			data:{action:'showsliders'},
			dataType:'json',
			success:function(data){
				for (var i = 0; i < data.length; i++) {
					output += "<tr><td>"+data[i].id+"</td><td>"+substr(data[i].title,70)+"</td><td><button class='button gray btn-del-slider' del-id="+data[i].postid+"><i class='sl sl-icon-close'></i></button></td></tr>";
				}
				$("#sliderbody").html(output);
			}
		});
	}
	showsliders();



//add slider using ajax
function addslider(postid){
	$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'addslider',postid:postid},
			success:function(data){
				if (data==1) {
					$("#result_slider").text("Post is Added into Slider");
					$("#result_slider").css("color","green");
					showsliders();
					autoclosealert();
				}else{
					$("#result_slider").text(data);
					$("#result_slider").css("color","red");
				}
			}
		});
}
$("#addsliderbtn").click(function(){
	let postid = $(this).attr("post-id");
	addslider(postid);
});
$("#searchsliderbody").on("click",".btn-add-slider",function(){
	let postid = $(this).attr("post-id");
	addslider(postid);
});




//delete slider using ajax
	$("#sliderbody").on("click",".btn-del-slider",function(){
		let postid = $(this).attr("del-id");
		var btn = event.target;
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'deleteslider',postid:postid},
			success:function(data){
				$(btn).closest("tr").fadeOut("fast");
				if (data==1) {
					$(btn).closest("tr").fadeOut("fast");
				}else{
					alert("Something went wrong");
				}
			}
		});
	});


//search posts for slider using ajax
$("#searchslider").on("keyup", function() {
    var searchvalue = $(this).val().toLowerCase();
    let output = "";
	$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'searchslider',search_val:searchvalue},
			dataType:'json',
			success:function(data){
				for(var i = 0; i<data.length; i++){
					output+= "<tr><td>"+data[i].id+"</td><td>"+substr(data[i].title,50)+"</td><td>"+"<button class='btn btn-sm btn-primary btn-add-slider' post-id="+data[i].id+">Add</button>"+"</td></tr>";
				}
				$("#searchsliderbody").html(output);
			}
		});   
  });







////////////////////////////////////////////////////////////////////////////////////////////////////////
//									    			Users 											  //
////////////////////////////////////////////////////////////////////////////////////////////////////////
//add users using ajax
	$("#adduserbtn").click(function(e){
		e.preventDefault();
		let full_name = $("#fullname").val();
		let username = $("#username").val();
		let password = $("#password").val();
		let conpassword = $("#conpassword").val();
		let email = $("#email").val();
		let role = $("#role").val();
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'adduser',fullname:full_name,username:username,password:password,conpassword:conpassword,email:email,role:role},
			success:function(data){
				if (data==1) {
					$(".result_user").html("<div class='alert alert-success'>Added Successfully.</div>");
					$("#userform")[0].reset();
					showusers();
					autoclosealert();
				}else if(data==0){
					$(".result_user").html("<div class='alert alert-danger'>Something went wrong.</div>");
					autoclosealert();
				}else{
					$(".result_user").html("<div class='alert alert-danger'>"+data+"</div>");
				}
			}
		});
	})



//show users using ajax
	function showusers(){
		let output = "";
		$.ajax({
			url:'./ajax/myajax.php',
			data:{action:'showusers'},
			dataType:'json',
			success:function(data){
				for (var i = 0; i < data.length; i++) {
					output += "<tr><td>"+data[i].id+"</td><td>"+data[i].fullname+"</td><td>"+data[i].username+"</td><td>"+data[i].email+"</td><td>"+data[i].role+"</td><td>"+"<button class='button gray btn-del' del-id="+data[i].id+"><i class='sl sl-icon-close'></i></button>"+"</td></tr>";
				}
				$("#usersbody").html(output);
			}
		});
	}
	showusers();


//delete user using ajax
	$("#usersbody").on("click",".btn-del",function(){
		let userid = $(this).attr("del-id");
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'deleteuser',userid:userid},
			success:function(data){
				if (data==1) {
					showusers();
				}else{
					alert("Something went wrong");
				}
			}
		});
	});


//update user profile
	$("#update_profile_btn").click(function(e){
		e.preventDefault();
		var formdata = new FormData($("#update_profile_form")[0]);
		formdata.append('action', 'updateprofile');
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data: formdata,
			contentType:false,
			processData:false,
			success:function(data){
				if (data==1) {
					$(".profile_result").html("<p style='color:green; font-weight: bold;'>Successfully Saved</p>");
					autoclosealert();
				}else if(data==0){
					$(".profile_result").html("<p style='color:red; font-weight: bold;'>Unable to Save</p>");
				}else{
					$(".profile_result").html("<div class='alert alert-danger'>"+data+"</div>");
				}
			}
		});

	})



//update social links
	$("#update_links_btn").click(function(e){
		let fblink = $("#fblink").val();
		let twitterlink = $("#twitterlink").val();
		let gpluslink = $("#gpluslink").val();
		let linkedinlink = $("#linkedinlink").val();
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'updatesociallinks',fb:fblink,twitter:twitterlink,gplus:gpluslink,linkedin:linkedinlink},
			success:function(data){
				if (data==1) {
					$(".links_result").html("<p style='color:green; font-weight: bold;'>Successfully Saved</p>");
				}else if(data==0){
					$(".links_result").html("<p style='color:red; font-weight: bold;'>Unable to Save</p>");
				}else{
					$(".links_result").html("<div class='alert alert-danger'>"+data+"</div>");
				}
			}
		});	
	})




//Change user password
	$("#changepwdbtn").click(function(e){
		let currentpwd = $("#currentpwd").val();
		let newpwd = $("#newpwd").val();
		let connewpwd = $("#connewpwd").val();
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'changepwd',currentpwd:currentpwd,newpwd:newpwd,connewpwd:connewpwd},
			success:function(data){
				if (data==1) {
					$(".pwd_result").html("<p style='color:green; font-weight: bold;'>Successfully Changed</p>");
					$("#changepwdform")[0].reset();
				}else if(data==0){
					$(".pwd_result").html("<p style='color:red; font-weight: bold;'>Unable to Change</p>");
				}else{
					$(".pwd_result").html("<div class='alert alert-danger'>"+data+"</div>");
				}
			}
		});	
	})



//logout user
$("#logout_btn").click(function(){
	$.ajax({
		url:'./ajax/myajax.php',
		data:{action:'logout'},
		type:'post',
		success:function(data){
			if (data==1) {
				window.location.href = "../login.php";
			}
		}
	});
});




////////////////////////////////////////////////////////////////////////////////////////////////////////
//									    			Comments 											  //
////////////////////////////////////////////////////////////////////////////////////////////////////////
//show comments using ajax
	showcomments();

	$(".pagination_comments").on("click",".page_btn",function(){
		let page_no = $(this).attr("page-no");
		showcomments(page_no)
	});

	function showcomments(page_no){
		let output = "";
		let output2 = "";
		let myclass = "";
		let currentstatus = "";
		$.ajax({
			url:'./ajax/myajax.php',
			data:{action:'showcomments',page:page_no},
			dataType:'json',
			success:function(data){
				for (var i = 0; i < data[0].length; i++) {
					if (data[0][i].status=="draft") {
						currentstatus = "<button class='btn btn-primary' id='appr_btn' appr-id="+data[0][i].id+">Approve</button>";
					}else{
						currentstatus = data[0][i].status;
					}
					output += "<tr><td>"+data[0][i].id+"</td><td>"+substr(data[0][i].body,80)+"</td><td>"+substr(data[0][i].title,40)+"</td><td>"+data[0][i].username+"</td><td>"+data[0][i].useremail+"</td><td>"+currentstatus+"</td><td>"+"<button class='button gray btn-del' del-id="+data[0][i].id+"><i class='sl sl-icon-close'></i></button>"+"</td></tr>";
				}
				$("#commentsbody").html(output);

				//show pagination
				for(var j =1; j <= data[1]; j++){
					if(page_no==j){
						myclass='active';
					}else{
						myclass='';
					}
					output2+="<li><button page-no="+[j]+" class='"+myclass+" page_btn'>"+[j]+"</button></li>";
				}

				$(".pagination_comments").html(output2);
			}
		});
	}





//approve comments
	$("#commentsbody").on("click","#appr_btn",function(){
		let id = $(this).attr("appr-id");
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'approvecomment',apprid:id},
			success:function(data){
				if (data==1) {
					showcomments();
				}else{
					alert("Something went wrong");
				}
			}
		});
	});


//approve all comments
$("#apprallcomments").click(function(){
	let postid = $(this).attr("post-id");
	$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'approveallcomments',postid:postid},
			success:function(data){
				if (data==1) {
					$("#result_slider").text("All comments approved Successfully");
					$("#result_slider").css("color","green");
					showsliders();
				}else{
					$("#result_slider").text(data);
					$("#result_slider").css("color","red");
				}
			}
		});
});


//delete comments using ajax
	$("#commentsbody").on("click",".btn-del",function(){
		let id = $(this).attr("del-id");
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'deletecomment',delid:id},
			success:function(data){
				if (data==1) {
					showcomments();
				}else{
					alert("Something went wrong");
				}
			}
		});
	});






////////////////////////////////////////////////////////////////////////////////////////////////////////
//									    		Messages 											  //
////////////////////////////////////////////////////////////////////////////////////////////////////////
//show messages using ajax
	function showmsgs(){
		let output = "";
		let color = "";
		$.ajax({
			url:'./ajax/myajax.php',
			data:{action:'showmsgs'},
			dataType:'json',
			success:function(data){
				for (var i = 0; i < data.length; i++) {
					if (data[i].status=='read') {
						color = 'green';
					}else{
						color = 'red';
					}
					output += "<tr><td>"+data[i].id+"</td><td>"+data[i].name+"</td><td>"+data[i].email+"</td><td><a href='javascript:void' style='color:"+color+"' class='msg-link' msg-link="+data[i].id+">"+substr(data[i].message,20)+"</a></td><td>"+"<button class='button gray btn-del' del-id="+data[i].id+"><i class='sl sl-icon-close'></i></button>"+"</td></tr>";
				}
				$("#msgsbody").html(output);
			}
		});
	}
	showmsgs();



	//delete messages using ajax
	$("#msgsbody").on("click",".btn-del",function(){
		let id = $(this).attr("del-id");
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'deletemsg',delid:id},
			success:function(data){
				if (data==1) {
					showmsgs();
				}else{
					alert("Something went wrong");
				}
			}
		});
	});


//show single message detail
	$("#msgsbody").on("click",".msg-link",function(){
		let id = $(this).attr("msg-link");
		let output = "";
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data:{action:'showsinglemsg',id:id},
			dataType:'json',
			success:function(data){
				if (data.length>0) {
					$("#msg_content").html(data[0].message);
					$("#msg_name").text(data[0].name);
					$("#msg_email").text(data[0].email);
					$("#msg_phone").text(data[0].phone);
					$("#msgmodal").modal("show");

					if (data[0].status=="unread") {
						let msgcount = $("#msg_count").text();
						$("#msg_count").text(msgcount-1);
					}
					
				}else{
					alert("Something went wrong");
				}
			}
		});
	});



//reply (send email) on message
	$("#reply_btn").click(function(e){
		e.preventDefault();
		let subject = "Re: "+substr($("#msg_content").text(),50);
		let email = $("#msg_email").text();
		let reply = $("#reply_msg").val();
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data: {subject:subject,email:email,reply:reply,action:"sendreply"},
			success:function(data){
				if (data==1) {
					$(".result_reply").html("<div class='alert alert-success'>Email Sent Successfully</div>");
					autoclosealert();
				}else if (data==0){
					$(".result_reply").html("<div class='alert alert-danger'>Something went wrong</div>");
				}else{
					$(".result_reply").html("<div class='alert alert-danger'>"+data+"</div>");
				}
			}
		});
	})




////////////////////////////////////////////////////////////////////////////////////////////////////////
//									    		Settings 											  //
////////////////////////////////////////////////////////////////////////////////////////////////////////
//update limits
	$("#savelimitsbtn").click(function(e){
		e.preventDefault();
		var formdata = new FormData($("#savelimitform")[0]);
		formdata.append('action', 'updatelimits');
		$.ajax({
			url:'./ajax/myajax.php',
			type:'POST',
			data: formdata,
			contentType:false,
			processData:false,
			success:function(data){
				if (data==1) {
					$(".result_limits").html("<div class='alert alert-success'>Successfully Updated</div>");
					autoclosealert();
				}else if (data==0){
					$(".result_limits").html("<div class='alert alert-danger'>Something went wrong</div>");
					autoclosealert();
				}else{
					$(".result_limits").html("<div class='alert alert-danger'>"+data+"</div>");
				}
			}
		});
	})






//function for limit string length
function substr(text, count){
    return text.slice(0, count) + (text.length > count ? "..." : "");
}

//change slug text based on post title
$("#title").on("input", function() {
	let title = $(this).val();
   $("#slug").val(convertToSlug(title));
});

//jquery slug function
function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}

//auto close alert box
function autoclosealert(){
	window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
	}, 2000);
}



CKEDITOR.replace( 'content' );


// Developed by Abdul Razzaq -- ab.razzaq32@yahoo.com	

});