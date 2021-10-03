    <?php include("includes/header.php"); ?>

    <?php 
    $check = $auth->check_login();
    if ($check==1) {
        header('location: backend');
    }

     ?>
    <section class="breadcrumb-outer text-center bg-orange">
        <div class="container">
            <div class="breadcrumb-content">
                <h2>Login Page</h2>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login</li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

    <h1></h1>
    <!-- BreadCrumb Ends -->

    <section class="login">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="login-form">
                        <form>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-title">
                                        <h2>Login</h2>
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <label>Username</label>
                                    <input type="text" class="form-control" id="username" placeholder="Enter username">
                                </div>
                                <div class="form-group col-xs-12">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Enter password">
                                </div>
                                
                                <div class="col-xs-12">
                                    <div class="comment-btn mar-bottom-20">
                                        <a href="javascript:void" class="btn-blog" id="login_btn">Login</a>
                                    </div>
                                </div>
                                
                                <div class="col-xs-12">
                                    <div class="checkbox-outer pull-left">
                                        <input type="checkbox" name="vehicle2" value="Car"> Remember Me?
                                    </div>
                                    <div class="login-accounts pull-right">
                                        <a href="forgot-password.html" class="forgotpw">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div id="login_result">
                        
                    </div>
                </div>


            </div>
        </div>
    </section>

    <?php include("includes/footer.php"); ?>