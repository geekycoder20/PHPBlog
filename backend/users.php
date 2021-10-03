<?php include("includes/header.php");?>

<?php 
$role = $_SESSION['role'];
if ($role!="Admin") {
  header('location: index.php');
}

 ?>

<?php $currentpage="users"; ?>
<?php include("includes/sidebar.php"); ?>
<div class="dashboard-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
          <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#home">All Users</a></li>
            <li><a data-toggle="tab" href="#menu1" id="addusertab">Add Users</a></li>
          </ul>

          <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
              <div class="dashboard-list-box">
                <h4 class="gray">All Users</h4>
                <div class="table-box">
                    <table class="basic-table booking-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="usersbody">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
            <div id="menu1" class="tab-pane fade">
              <h3 id="addtabhead">Add Users</h3>
              <form class="form-horizontal" method="post" id="userform">
                <input type="hidden" name="userid" id="userid">
                <div class="form-group">
                  <label class="control-label col-sm-2" for="title">Full Name:
                    <span style="color:#ff0000">*</span>
                  </label>
                  <div class="col-sm-10" id="user_title_sec">
                    <input type="text" class="form-control" id="fullname" placeholder="Enter Full Name" name="fullname">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="username">UserName:
                    <span style="color:#ff0000">*</span>
                  </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" placeholder="Enter Username" name="username">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="password">Password:
                    <span style="color:#ff0000">*</span>
                  </label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="conpassword">Confirm Password:
                    <span style="color:#ff0000">*</span>
                  </label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="conpassword" placeholder="Confirm Password" name="conpassword">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="email">Email:
                    <span style="color:#ff0000">*</span>
                  </label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" placeholder="abc@gmail.com" name="email">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="role">Role:
                    <span style="color:#ff0000">*</span>
                  </label>
                  <div class="col-sm-10">
                    <select name="role" id="role">
                      <option value="Admin">Admin</option>
                      <option value="Author">Author</option>
                      <option value="Moderator">Moderator</option>
                    </select>
                  </div>
                </div>
                

                <div class="form-group">        
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="adduserbtn">Add</button>
                  </div>
                </div>
              </form>
              <div class="result_user">

              </div>
            </div>
            
          </div>
        </div>
    </div>
</div>



<?php include("includes/footer.php"); ?>