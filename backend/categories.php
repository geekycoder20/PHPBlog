<?php include("includes/header.php");?>

<?php 
$role = $_SESSION['role'];
if ($role!="Admin") {
  header('location: index.php');
}

 ?>

<?php $currentpage="categories"; ?>
<?php include("includes/sidebar.php"); ?>
<div class="dashboard-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="dashboard-list-box">
                <button class="btn btn-danger btn-cat-add" style="margin-bottom: 5px;" data-toggle="modal" data-target="#addcatmodal">Add Category</button>
                <h4 class="gray">All Categories</h4>
                <div class="table-box">
                    <table class="basic-table booking-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="catsbody">
                            
                        </tbody>
                    </table>
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