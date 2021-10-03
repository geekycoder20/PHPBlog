<?php include("includes/header.php");?>
<?php $currentpage="profile"; ?>
<?php include("includes/sidebar.php"); ?>
<div class="dashboard-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="row">
              <?php 
              $user = $user->show_profile();
              $user = $user->fetch();
               ?>

              <div class="col-md-8 col-md-offset-2">
                <h3>Profile</h3>
                <form id="update_profile_form">
                <div class="card">
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <b class="mb-0">Full Name</b>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <input type="text" name="fullname" id="fullname" class="form-control" value="<?php echo $user['fullname']?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <b class="mb-0">Username</b>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" value="<?php echo $user['username']?>" disabled>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <b class="mb-0">Email</b>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" value="<?php echo $user['email']?>" disabled>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <b class="mb-0">Role</b>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" value="<?php echo $user['role'] ?>" disabled>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <b class="mb-0">Image</b>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <input type="file" id="userimage" name="userimage" class="form-control">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <b class="mb-0">About</b>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <textarea class="form-control" id="about" name="about"><?php echo $user['about'] ?></textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3"></div>
                      <div class="col-sm-9 text-secondary">
                        <input type="button" class="btn btn-primary px-4" id="update_profile_btn" value="Save Changes">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3"></div>
                      <div class="col-sm-9 text-secondary profile_result">
                        
                      </div>
                    </div>
                    
                  </div>
                </div>
                </form>
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