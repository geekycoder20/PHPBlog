<?php include("../config/init.php"); ?>

<?php 
$checklogin = $auth->check_login();

if ($checklogin==1) {
    $found_user = $auth->fetch_logged_in_user();
}
else{
    header('location: ../login.php');
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">

<!-- Developed by Abdul Razzaq -- ab.razzaq32@yahoo.com -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ARBLOGS is an online blog, news & technology dedicated to different categories html template">

    <title>AR Backend</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!--Default CSS-->
    <link href="css/default.css" rel="stylesheet" type="text/css">
    <!--Custom CSS-->
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <!--Flaticons CSS-->
    <link href="font/flaticon.html" rel="stylesheet" type="text/css">
    <!--Plugin CSS-->
    <link href="css/plugin.css" rel="stylesheet" type="text/css">
    <!--Dashboard CSS-->
    <link href="css/dashboard.css" rel="stylesheet" type="text/css">

    <link href="css/icons.css" rel="stylesheet" type="text/css">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/mystyles.css">
    <!-- editor -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<body>
    <div class="loader_ajax" style="display: none;">
        <div class="loader__element"></div>
    </div>
    <!--PRELOADER-->
    <div id="preloader">
        <div id="status"></div>
    </div>
    <!-- start Container Wrapper -->
    <div id="container-wrapper">
        <!-- Dashboard -->
        <div id="dashboard">

            <!-- Responsive Navigation Trigger -->
            <a href="#" class="dashboard-responsive-nav-trigger"><i class="fa fa-reorder"></i> Dashboard Navigation</a>  

            <div class="dashboard-sticky-nav">
                <div class="content-left pull-left">
                    <a href="../index.php"><img src="images/logo.png" alt="logo"></a>
                </div>
                <div class="content-right pull-right">
                    <div class="search-bar">
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" id="search" placeholder="Search Now">
                                <a href="#"><span class="search_btn"><i class="fa fa-search" aria-hidden="true"></i></span></a>
                            </div>
                        </form>
                    </div>
                    <div class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <div class="profile-sec">
                                <div class="dash-image">
                                    <?php 
                                    if (!empty($found_user['image'])) {
                                        echo "<img src='../images/blog/{$found_user['image']}'>";
                                    }else{
                                        echo "<img src='../images/blog/profile.png'>";
                                    }

                                    ?>
                                </div>
                                <div class="dash-content">
                                    <h4><?php echo $found_user['username']; ?></h4>
                                    <span>&nbsp;</span>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="social_links.php"><i class="fa fa-facebook"></i>Social Links</a></li>
                            <li><a href="profile.php"><i class="sl sl-icon-user"></i>Profile</a></li>
                            <li><a href="changepassword.php"><i class="sl sl-icon-lock"></i>Change Password</a></li>
                            <li><a href="javascript:void" id="logout_btn"><i class="sl sl-icon-power"></i>Logout</a></li>
                        </ul>
                    </div>

                    <?php 
                    $role = $_SESSION['role'];
                    if ($role=="Admin"):
                       ?>
                       <div class="dropdown">
                        <?php 
                        $msgs = $database->find_query("contact_queries","unread","status");
                        $msgcount = $msgs->rowCount();
                        ?>
                        <a class="dropdown-toggle" href="messages.php">
                            <div class="dropdown-item">
                                <i class="sl sl-icon-envelope-open"></i>
                                <span class="notify" id="msg_count"><?php echo $msgcount; ?></span>
                            </div>
                        </a>  
                    </div>
                <?php endif; ?>
            </div>
        </div>
        