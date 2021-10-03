<?php include("includes/header.php");?>

<?php 
$role = $_SESSION['role'];
if ($role!="Admin") {
  header('location: index.php');
}
 ?>

<?php $currentpage="sliders"; ?>
<?php include("includes/sidebar.php"); ?>
<div class="dashboard-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="dashboard-list-box">
              <button class="btn btn-danger btn-cat-add" style="margin-bottom: 5px;" data-toggle="modal" data-target="#addslidermodal">Add Slider</button>
                <h4 class="gray">All Sliders</h4>
                <div class="table-box">
                    <table class="basic-table booking-table">
                        <thead>
                            <tr>
                                <th>Slider ID</th>
                                <th>Post Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="sliderbody">
                            
                        </tbody>
                    </table>
                </div>
            </div>   
        </div>
    </div>
</div>





 <!-- Modal -->
 <div class="modal fade" id="addslidermodal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <input id="searchslider" type="text" placeholder="Search Posts">
        <table class="table">
          <thead>
            <tr>
              <th>Post Id</th>
              <th>Post Title</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="searchsliderbody">
            
          </tbody>
        </table>

      </div>
      <div id="result_slider" style="margin-left: 5px;">
          
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

    </div>
</div>


<?php include("includes/footer.php"); ?>