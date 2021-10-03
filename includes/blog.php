<section id="mt_blog" class="">
    <div class="container">
        <div class="row">
            <div class="col-md-9 width70" id="blog_area">
                <div class="blog_post_sec blog_post_inner">
                    <div class="row">
                        <p style="margin-left: 15px;" id="category_text"></p>
                    <div id="homeposts">
                        
                    </div>
                        

                    <div class="col-xs-12 text-center load_more_div">
                        <button class="btn btn-primary btn-lg load_more" data-id="" cat-id="" load-type="">Load More</button> 
                    </div> 
                </div>    
            </div>
        </div>
        <?php include("sidebar.php"); ?>   
    </div>  
</div>
</section>


<!-- Modal -->
<div id="quickviewmodal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Quick View</h4>
      </div>
      <div class="modal-body">
        <div class="row p-2 bg-white border rounded">
            <div style="margin-left: 10px;">
                <h3 id="post_title">Post Title</h3>
                <span>By: <b id="post_author">paklover786</b></span><br>
                <span>On: <b id="post_date">25 Dec 2021</b></span><br>
            </div>

            <div class="row">
              <div class="col-md-3 mt-1" style="margin-left: 10px;">
                <img class="img-fluid img-responsive rounded product-image" src="" id="post_image"></div>
              </div>
                
                <div class="col-md-12 mt-1">
                    
                    <div class="d-flex flex-row" style="margin-top: 10px; margin-bottom: 10px;">
                        <div class="ratings mr-2" id="post_cats">
                          
                        </div>
                    </div>
                    

                    <div class="mt-1 mb-1 spec-1" id="post_content">
                      
                    </div>
                    
                </div>
                
            </div>
        </div>
      </div>
      
    </div>

  </div>
</div>