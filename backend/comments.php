<?php include("includes/header.php");?>

<?php 
$role = $_SESSION['role'];
if ($role!="Admin" AND $role!="Moderator") {
  header('location: index.php');
}

 ?>

<?php $currentpage="comments"; ?>
<?php include("includes/sidebar.php"); ?>
<div class="dashboard-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
          <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
              <div class="dashboard-list-box">
                <h4 class="gray">All Comments</h4>
                <div class="table-box">
                    <table class="basic-table booking-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Comment</th>
                                <th>Post</th>
                                <th>Username</th>
                                <th>Useremail</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="commentsbody">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
           
            
          </div>

            <div class="pagination__wrapper mar-top-30">
                <ul class="pagination pagination_comments">
                    
                </ul>
            </div>    
        </div>
    </div>
</div>



<?php include("includes/footer.php"); ?>