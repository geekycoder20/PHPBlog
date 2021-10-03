<?php include("includes/header.php");?>
<?php $currentpage="sociallinks"; ?>
<?php include("includes/sidebar.php"); ?>
<div class="dashboard-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="row">
              <div class="col-md-8 col-md-offset-2">
                <?php 
                $userid = $_SESSION['userid'];
                $links = $user->get_social_links($userid);
                $linkrow = $links->fetch();
                 ?>
                <h3>Social Links</h3>
                <div class="card">
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <b class="mb-0">Facebook</b>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <input type="text" name="fblink" id="fblink" class="form-control" placeholder="https://www.facebook.com/profile" value="<?php echo $linkrow['fb']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <b class="mb-0">Twitter</b>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <input type="text" name="twitterlink" id="twitterlink" class="form-control" placeholder="https://www.twitter.com/profile" value="<?php echo $linkrow['twitter']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <b class="mb-0">Google+</b>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <input type="text" name="gpluslink" id="gpluslink" class="form-control" placeholder="https://www.gplus.com/profile" value="<?php echo $linkrow['gplus']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <b class="mb-0">Linkedin</b>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <input type="text" name="linkedinlink" id="linkedinlink" class="form-control" placeholder="https://www.linkedin.com/profile" value="<?php echo $linkrow['linkedin']; ?>">
                      </div>
                    </div>
                    
                    
                    
                    <div class="row">
                      <div class="col-sm-3"></div>
                      <div class="col-sm-9 text-secondary">
                        <input type="button" class="btn btn-primary px-4" id="update_links_btn" value="Save Changes">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3"></div>
                      <div class="col-sm-9 text-secondary links_result">
                        
                      </div>
                    </div>
                    
                  </div>
                </div>

              </div>
            </div>  
        </div>
    </div>
</div>





 <!-- Modal -->
 <div class="modal fade" id="addcatmodal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <!-- add form -->
          <form id="addcatform">
            <div class="form-group">
                <label for="title">Category Title:</label>
              <input type="text" class="form-control" id="title" placeholder="Enter Title" name="title">
          </div>
          <button class="btn btn-primary" id="addcatbtn">Add</button>
      </form>


      <!-- edit form -->
      <form id="editcatform" style="display: none;">
            <div class="form-group">
                <label for="edit_title">Category Title:</label>
                <input type="hidden" name="" id="catid">
              <input type="text" class="form-control" id="edit_title" placeholder="Enter Title" name="edit_title">
          </div>
          <button class="btn btn-primary" id="updatecatbtn">Update</button>
      </form>

      </div>
      <div class="result">
          
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

    </div>
</div>


<?php include("includes/footer.php"); ?>