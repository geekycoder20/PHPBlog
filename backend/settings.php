<?php include("includes/header.php");?>

<?php 
$role = $_SESSION['role'];
if ($role!="Admin") {
  header('location: index.php');
}

 ?>

<?php $currentpage="settings"; ?>
<?php include("includes/sidebar.php"); ?>
<div class="dashboard-content">
      <h2>Settings</h2>
      <?php 
      $res = $setting->find_limits();
      $row = $res->fetch();
       ?>
       <form id="savelimitform">
      <div class="row">
        <div class="col-md-4">
          <b>Posts Per Page on blog</b>
        </div>
        <div class="col-md-8">
          <input type="number" value="<?php echo $row['postsblog'] ?>" name="postsblog" id="postsblog">
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <b>Posts Per Page in admin</b>
        </div>
        <div class="col-md-8">
          <input type="number" value="<?php echo $row['postsadmin'] ?>" name="postsadmin" id="postsadmin">
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <b>Posts Limit in Slider</b>
        </div>
        <div class="col-md-8">
          <input type="number" value="<?php echo $row['slider'] ?>" name="sliderlimit" id="sliderlimit">
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <b>Load More Posts Limit</b>
        </div>
        <div class="col-md-8">
          <input type="number" value="<?php echo $row['loadmore'] ?>" name="loadmorelimit" id="loadmorelimit">
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <b>Popular Posts Limit</b>
        </div>
        <div class="col-md-8">
          <input type="number" value="<?php echo $row['popular'] ?>" name="popularlimit" id="popularlimit">
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <b>Random Posts Limit</b>
        </div>
        <div class="col-md-8">
          <input type="number" value="<?php echo $row['random'] ?>" name="randomlimit" id="randomlimit">
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <b>Max Categories Limit Per Post</b>
        </div>
        <div class="col-md-8">
          <input type="number" value="<?php echo $row['postcats'] ?>" name="catslimit" id="catslimit">
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <b>Comments per page on admin</b>
        </div>
        <div class="col-md-8">
          <input type="number" value="<?php echo $row['comments'] ?>" name="commentslimit" id="commentslimit">
        </div>
      </div>
      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-8">
          <input type="button" class="btn btn-primary" value="Save Changes" name="savelimitsbtn" id="savelimitsbtn">
        </div>
      </div>
      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-8 result_limits"></div>
      </div>
      </form>
</div>



<?php include("includes/footer.php"); ?>