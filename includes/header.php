<?php include("./config/init.php"); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">


<!-- Developed by Abdul Razzaq -- ab.razzaq32@yahoo.com -->
<head>
<base href="http://localhost/blog/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ARBLOGS is an online blog, news & technology dedicated to different categories html template">

    <title>AR Blogs</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!--Default CSS-->
    <link href="css/default.css" rel="stylesheet" type="text/css">

    <!--Custom CSS-->
    <link href="css/style.css" rel="stylesheet" type="text/css">

    <!--Plugin CSS-->
    <link href="css/plugin.css" rel="stylesheet" type="text/css">

    <!--Font Icons-->
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/mystyles.css">
    <!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>



<body>
    <!--PRELOADER-->
    <div id="preloader">
        <div id="status"></div>
    </div>
        <header id="inner-navigation">
        <!-- navbar start -->
        <nav class="navbar navbar-default navbar-fixed-top navbar-sticky-function navbar-arrow">

            <div class="container">

                <div class="logo pull-left">
                    <h1><a href="index.php"><img src="images/logo.png"></a></h1>
                </div>
                
                <div id="navbar" class="navbar-nav-wrapper text-center">
                    <ul class="nav navbar-nav navbar-right" id="responsive-menu">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="contact_us.php">Contact Us</a></li>

                        <li><a href="javascript:void">Pages <i class="fa fa-angle-down"></i></a>
                            <ul>
                                <?php 
                                $res = $page->show_pages();
                                while ($row = $res->fetch()):
                                 ?>
                                <li><a href="page/<?php echo $row['slug']?>"><?php echo $row['title']; ?></a></li>
                            <?php endwhile; ?>
                                        
                            </ul>
                        </li> 

                        <?php 
                        $check = $auth->check_login();
                        if ($check==true) {
                            echo "<li><a href='backend'>Dashboard</a></li>";
                        }else{
                            echo "<li><a href='login.php'>Login</a></li>";
                        }

                         ?>
                        

                        <li><a href="#search" class="mt_search"><i class="fa fa-search"></i></a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
            
            <div id="slicknav-mobile"></div>
        </nav>
        <!-- navbar end -->
    </header>