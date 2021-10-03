<?php include("includes/header.php");?>

<?php 
$role = $_SESSION['role'];
if ($role!="Admin") {
  header('location: index.php');
}

 ?>

<?php $currentpage="pages"; ?>
<?php include("includes/sidebar.php"); ?>
<div class="dashboard-content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
          <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#home">All Pages</a></li>
            <li><a data-toggle="tab" href="#menu1" id="addpagetab">Add / Update Pages</a></li>
          </ul>

          <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
              <div class="dashboard-list-box">
                <h4 class="gray">All Pages</h4>
                <div class="table-box">
                    <table class="basic-table booking-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="pagesbody">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
            <div id="menu1" class="tab-pane fade">
              <h3 id="addtabhead">Add / Update Pages</h3>
              <form class="form-horizontal" method="post" id="pageform">
                <input type="hidden" name="pageid" id="pageid">
                <div class="form-group">
                  <label class="control-label col-sm-2" for="title">Page Title:
                    <span style="color:#ff0000">*</span>
                  </label>
                  <div class="col-sm-10" id="page_title_sec">
                    <input type="text" class="form-control" id="title" placeholder="Enter Title" name="title">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="slug">Page Slug:
                    <span style="color:#ff0000">*</span>
                  </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="slug" placeholder="Enter Slug" name="slug">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="content">Page Content:
                    <span style="color:#ff0000">*</span>
                  </label>
                  <div class="col-sm-10">
                    <textarea name="content" id="content" placeholder="Page Description"></textarea>
                  </div>
                </div>

                <div class="form-group">        
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="addpagebtn">Add</button>
                    <button type="button" class="btn btn-primary" id="updatepagebtn" style="display: none;">Update</button>
                  </div>
                </div>
              </form>
              <div class="result_page">

              </div>
            </div>
            
          </div>

            <!-- <div class="pagination__wrapper mar-top-30">
                <ul class="pagination">
                    <li><button class="prev" title="previous page">&#10094;</button></li>
                    <li><button title="first page - page 1">1</button></li>
                    <li><button>2</button></li>
                    <li><button class="active" title="current page">2</button></li>
                    <li><button>3</button></li>
                    <li><button>4</button></li>
                    <li><button class="next" title="next page">&#10095;</button></li>
                </ul>
            </div>    --> 
        </div>
    </div>
</div>



<?php include("includes/footer.php"); ?>