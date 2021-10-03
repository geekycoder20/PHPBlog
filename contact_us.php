    <?php include("includes/header.php"); ?>
    
    <!-- Breadcrumb -->
    <section class="breadcrumb-outer text-center bg-orange">
        <div class="container">
        	
            <div class="breadcrumb-content">
                <h2>Contact Us</h2>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <!-- BreadCrumb Ends -->

    <section class="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div id="contact-form" class="contact-form">

                        <div id="contactform-error-msg"></div>

                        <form method="post" action="#" name="contactform" id="mycontactform">
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <label>Name:</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter full name">
                                </div>
                                <div class="form-group col-xs-6">
                                    <label>Email:</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="abc@xyz.com">
                                </div>
                                <div class="form-group col-xs-6 col-left-padding">
                                    <label>Phone Number:</label>
                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="+92XXXXXXXXXX">
                                </div>
                                <div class="form-group textarea col-xs-12">
                                    <label>Message:</label>
                                    <textarea name="message" id="message" class="form-control" placeholder="Enter a message"></textarea>
                                </div>
                                <div class="col-xs-12">
                                    <div class="comment-btn">
                                         <input type="submit" class="btn-blog" id="addquerybtn" value="Send Message">
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="query_result">
                                         
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <?php include("includes/footer.php"); ?>