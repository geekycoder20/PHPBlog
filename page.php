    <?php include("includes/header.php"); ?>
    
    <!-- Breadcrumb -->
    <section class="breadcrumb-outer text-center bg-orange">
        <div class="container">
        	<?php 
    		$res = $database->find_query("pages",$_GET['id'],"slug");
    		$row = $res->fetch();
    		?>
            <div class="breadcrumb-content">
                <h2><?php echo $row['title']; ?></h2>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void">Page</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $row['title']; ?></li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <!-- BreadCrumb Ends -->

    <!-- checkout -->
    <section class="about-us">
        <div class="container">
            <div class="about-main">
                <?php echo $row['content']; ?>
            </div>
        </div>
    </section>
    <!-- End checkout -->

    <?php include("includes/footer.php"); ?>