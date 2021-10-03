<?php include("includes/header.php");?>

<?php 
$role = $_SESSION['role'];
if ($role!="Admin") {
  header('location: index.php');
} ?>

<?php $currentpage="messages"; ?>
<?php include("includes/sidebar.php"); ?>
<div class="dashboard-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="dashboard-list-box">
                <h4 class="gray">All Messages</h4>
                <div class="table-box">
                    <table class="basic-table booking-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="msgsbody">
                            
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
    </div>
</div>


<!-- Modal -->
<div id="msgmodal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Quick View</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-3">
              <b>Name</b>
            </div>
            <div class="col-md-9">
              <p id="msg_name"></p>
            </div>
            <div class="col-md-3">
              <b>Email</b>
            </div>
            <div class="col-md-9">
              <p id="msg_email"></p>
            </div>
            <div class="col-md-3">
              <b>Phone</b>
            </div>
            <div class="col-md-9">
              <p id="msg_phone"></p>
            </div>
          </div>
        </div>
        <h4>Message:</h4>
        <p id="msg_content"></p>
        <div class="row">
          <div class="col-md-12">
            <textarea class="form-control" placeholder="Type Your Reply" id="reply_msg"></textarea>
            <button class="btn btn-primary" id="reply_btn">Reply</button>
            <div class="result_reply">
              
            </div>
          </div>
        </div>
      </div>
      
    </div>

  </div>
</div>






<?php include("includes/footer.php"); ?>