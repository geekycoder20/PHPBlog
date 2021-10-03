<?php include("includes/header.php");?>
<?php $currentpage="posts"; ?>
<?php include("includes/sidebar.php"); ?>
<div class="dashboard-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
          <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#home">All Posts</a></li>
            <li><a data-toggle="tab" href="#menu1" id="addtab">Add / Update Posts</a></li>
          </ul>

          
          <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
              <div class="dashboard-list-box">
                <h4 class="gray">All Posts</h4>
                <div class="table-box">
                    <table class="basic-table booking-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="postsbody">
                            
                        </tbody>

                    </table>

                </div>

            </div>
            <div class="pagination__wrapper mar-top-30">
                <ul class="pagination pagination_posts">
                  
                </ul>
            </div>  
            </div>

            <div id="menu1" class="tab-pane fade">
              <h3 id="addtabhead">Add / Update Post</h3>
              <form class="form-horizontal" method="post" id="postform">
                <input type="hidden" name="postid" id="postid">
                <div class="form-group">
                  <label class="control-label col-sm-2" for="title">Post Title:
                    <span style="color:#ff0000">*</span>
                  </label>
                  <div class="col-sm-10" id="post_title_sec">
                    <input type="text" class="form-control" id="title" placeholder="Enter Title" name="title">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="slug">Post Slug:
                    <span style="color:#ff0000">*</span>
                  </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="slug" placeholder="Enter Slug" name="slug">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2" for="cats">Post Categoris:
                    <span style="color:#ff0000">*</span>
                  </label>
                  <div class="col-sm-10 postcats">
                    <?php 
                    $res = $category->show_categories();
                    while($row = $res->fetch()):
                     ?>
                    <label class="checkbox-inline">
                      <input type="checkbox" name="catlinks[]" id="cat_link" value="<?php echo $row['id'];?>"><?php echo $row['cat_title']; ?>
                    </label>
                  <?php endwhile; ?>
                  </div>
                </div>


                <div class="form-group">
                  <label class="control-label col-sm-2" for="image">Post Image:
                    <span style="color:#ff0000">*</span>
                  </label>
                  <div class="col-sm-5">
                    <input type="file" class="form-control" id="image" name="image">
                  </div>
                  <div class="col-sm-5">
                    <img src="" id="post_img" style="height: 50px; width: 50px; display: none;">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="content">Post Content:
                    <span style="color:#ff0000">*</span>
                  </label>
                  <div class="col-sm-10">
                    <textarea name="content" id="content" placeholder="Post Description"></textarea>
                  </div>
                </div>

                <div class="form-group">        
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="addpostbtn">Add</button>
                    <button type="button" class="btn btn-primary" id="updatepostbtn" style="display: none;">Update</button>
                  </div>
                </div>
              </form>
              <div class="result_post">

              </div>
            </div>
            
          </div>


        </div>
    </div>
</div>





  <!-- Modal -->
  <div class="modal fade" id="postmodal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <div class="row p-2 bg-white border rounded">
            <h3 id="post_title" style="margin-left: 10px;">Post Title</h3>
            <div class="row">
              <div class="col-md-3 mt-1">

                <img class="img-fluid img-responsive rounded product-image" src="" id="post_image"></div>
                <?php 
                $role = $_SESSION['role'];
                 ?>
                <div class="col-md-9 text-right">
                <?php if ($role=="Admin"): ?>
                  <button class="btn btn-warning" style="margin-right: 5px;" post-id="" id="addsliderbtn">Add to Slider</button>
                <?php endif; ?>

                <?php if ($role=="Admin" or $role=="Moderator"): ?>
                  <button class="btn btn-warning" style="margin-right: 5px;" post-id="" id="apprallcomments">Approve all Comments</button>
                <?php endif; ?>
                  <p style="margin-right: 5px;" id="result_slider"></p>
                </div>

              </div>
                
                <div class="col-md-12 mt-1">
                    
                    <div class="d-flex flex-row" style="margin-top: 10px; margin-bottom: 10px;">
                        <div class="ratings mr-2" id="post_cats">
                          
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <b>Post Slug:</b>
                      </div>
                      <div class="col-md-9" id="post_slug">
                        
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <b>Post Author:</b>
                      </div>
                      <div class="col-md-9" id="post_author">
                        
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <b>Post Date:</b>
                      </div>
                      <div class="col-md-9" id="post_date">
                        
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <b>Post Status:</b>
                      </div>
                      <div class="col-md-9" id="post_status">
                        
                      </div>
                    </div>

                    <div class="mt-1 mb-1 spec-1" id="post_content">
                      
                    </div>
                    
                </div>
                
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


<?php include("includes/footer.php"); ?>