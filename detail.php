    <?php include("includes/header.php"); ?>
    

    <?php 
    if (isset($_GET['id'])) {
    	$postid = $_GET['id'];
    	$post->update_view_count($postid);
    }
     ?>
    <!-- Banner -->
    <div id="mt_banner" class="innerbanner">
    	<div class="container-fluid">
    		<?php 
    		$res = $database->find_query("posts",$_GET['id'],"slug");
    		$row = $res->fetch();
    		?>
    		<div class="featured-image" style="background-image: url(images/blog-listing/<?php echo $row['thumbnail']?>)"></div>
			<div class="banner-caption">
				<div class="banner_caption_text">
                    <div class="post-category">
                        <ul>
                        	<?php 
                        	$catlinks = $category->postcategories($row['id']);
                        	foreach ($catlinks as $cat) :
                        		?>
                            <li class="cat-blue"><a href="javascript:void" class="white"><?php echo $cat['cat_title']; ?></a></li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                    <h3><?php echo $row['title']; ?></h3>
                    <div class="item-meta">
                        <span>by</span>
                        <a href="javascript:void"><?php echo $row['author']; ?></a><br>
                        <time datetime="2018-02-15">Posted on: <?php echo date("d-M-Y",strtotime($row['date'])); ?></time>
                    </div>
                </div>
			</div>
    	</div>	
    </div>
    <!-- End Banner -->

    <!--* Blog Main Sec*-->
    <section id="blog_main_sec" class="section-inner">
        <div class="container">
            <!--*Blog Content Sec*-->
            <div class="blog-detail-main">
            	<div class="post_body">
         
                <p></p>
                <p></p>
                <?php echo $row['content']; ?>
            	</div>

                
            	<?php 
            	$author = $database->find_query("users",$row['author'],"username");
            	$authorrow = $author->fetch();

            	$authorlinks = $user->get_social_links($authorrow['id']);
            	$linksrow = $authorlinks->fetch();
            	 ?>
	            <div class="author_box">
	                <div class="author_img">
	                	<?php 
	                	if (!empty($authorrow['image'])) {
	                		echo "<img src='images/blog/{$authorrow['image']}'>";
	                	}else{
	                		echo "<img src='images/blog/profile.png'>";
	                	}

	                	 ?>	                    
	                </div>
	                <div class="author_bio">
	                    <h5><?php echo $authorrow['username']; ?></h5>
	                    <p><?php echo $authorrow['about']; ?></p>
	                    <ul>
	                        <li>
	                            <a href="<?php echo $linksrow['fb'] ?>" target="_blank">
	                                <i class="fa fa-facebook"></i>
	                            </a>
	                        </li>
	                        <li>
	                            <a href="<?php echo $linksrow['twitter'] ?>" target="_blank">
	                                <i class="fa fa-twitter"></i>
	                            </a>
	                        </li>
	                        <li>
	                            <a href="<?php echo $linksrow['gplus'] ?>" target="_blank">
	                                <i class="fa fa-google-plus"></i>
	                            </a>
	                        </li>
	                        <li>
	                            <a href="<?php echo $linksrow['linkedin'] ?>" target="_blank">
	                                <i class="fa fa-linkedin"></i>
	                            </a>
	                        </li>
	                    </ul>
	                </div>
	            </div>


	            <!--=========================* Comment Sec*===========================-->
	            <div id="comments">
	                <div class="comments-wrap">
	                	<?php 
	                	$postid = $row['id'];
	                    $comments = $comment->approved_comments($postid);
	                    $commentcount = $comments->rowCount();
	                	 ?>
	                    <h3 class="single-post_heading blog_heading_border">Comments (<?php echo $commentcount; ?>)</h3>
	                    <ol class="comments-lists">

	                    	<?php 
	                    	while ($commentrow = $comments->fetch()):
	                    	 ?>
	                        <li class="comment">
	                            <div class="activity_rounded">
	                                <img src="images/blog/man.png" alt="image" /> </div>
	                            <div class="comment-body">
	                                <h4 class="text-left"> <?php echo $commentrow['username']; ?> &nbsp;&nbsp;
	                                    <small class="date-posted pull-right"><?php echo $commentrow['created_at']; ?></small>
	                                </h4>
	                                <p><?php echo $commentrow['body']; ?></p>
	                                <a href="javascript:void" comment-id="<?php echo $commentrow['id'];?>" class="pull-left btn-blog btn-reply">Reply</a>
	                                
	                                <div class="clearfix"></div>
	                                
	                            </div>


	                            <?php 
	                            $replies = $comment->show_replies($commentrow['id']);
	                            while($replyrow = $replies->fetch()):
	                             ?>
	                            <ol class="children">
	                                <li class="comment">
	                                    <div class="activity_rounded">
	                                        <img src="images/blog/user.png" alt="image" /> </div>
	                                    <div class="comment-body">
	                                        <h4 class="text-left"> <?php echo $replyrow['username']; ?> &nbsp;&nbsp;
	                                            <small class="date-posted pull-right"><?php echo $replyrow['created_at']; ?></small>
	                                        </h4>
	                                        <p><?php echo $replyrow['body']; ?></p>
	                                        <div class="clearfix"></div>
	                                    </div>
	                                </li>
	                            </ol>
	                        <?php endwhile; ?>
	                        </li>
	                       <?php endwhile; ?>
	                    </ol>
	                    <div class="leave_comment" id="leave_comment">
	                        <h3 class="blog_heading_border"> Leave a Comment </h3>
	                        <form action="#" method="post" id="commentform">
	                        	<input type="hidden" id="post_id" value="<?php echo $row['id']; ?>" name="">
	                        	<input type="hidden" id="comment-id" name="">
	                            <div class="row">
	                                <div class="col-sm-6">
	                                    <div class="form-group">
	                                        <input placeholder="Name" id="name" class="form-control" type="text" required> </div>
	                                </div>
	                                <div class="col-sm-6">
	                                    <div class="form-group">
	                                        <input placeholder="Email" id="email" class="form-control" type="email" required> </div>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="col-sm-12">
	                                    <textarea placeholder="Message" id="body" class="form-control" required></textarea>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="col-md-12">
	                                    <button type="submit" class="btn-blog" id="addcommentbtn">Submit</button>
	                                    <button type="submit" class="btn-blog" id="addreplybtn" style="display: none;">Reply</button>
	                                </div>
	                            </div>
	                            <div class="row" style="margin-top: 5px;">
	                                <div class="col-md-12" id="result_comment">

	                                </div>
	                            </div>

	                        </form>
	                    </div>
	                </div>
	            </div>
	            <!--=========================*End Comment Sec*===========================-->
	            <!--* End Blog Content Sec*-->
	        </div>    
    	</div>
    </section>
    <!--*End Blog Main Sec*-->

    <?php include("includes/footer.php"); ?>