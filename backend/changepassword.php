<?php include("includes/header.php");?>
<?php $currentpage="chpassword"; ?>
<?php include("includes/sidebar.php"); ?>
<div class="dashboard-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="row">
              <div class="col-md-8 col-md-offset-2">
                <h3>Change Password</h3>
                <form action="" id="changepwdform">
                  <div class="form-group">
                    <label for="currentpwd">Current Password:</label>
                    <input type="password" class="form-control" id="currentpwd" placeholder="Enter Current Password" name="currentpwd">
                  </div>
                  <div class="form-group">
                    <label for="newpwd">New Password:</label>
                    <input type="password" class="form-control" id="newpwd" placeholder="Enter New password" name="newpwd">
                  </div>
                  <div class="form-group">
                    <label for="connewpwd">Confirm New Password:</label>
                    <input type="password" class="form-control" id="connewpwd" placeholder="Confirm New password" name="connewpwd">
                  </div>

                  <button type="submit" class="btn btn-primary" id="changepwdbtn">Change</button>
                </form>
                <div class="pwd_result">

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