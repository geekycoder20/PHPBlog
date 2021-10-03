<?php include("includes/header.php");?>
<?php $currentpage="index"; ?>
<?php include("includes/sidebar.php"); ?>
<div class="dashboard-content">
    <?php 
    $role = $_SESSION['role'];
    $currentuser = $_SESSION['username'];
    $catcount = $category->show_categories()->rowCount();
    $postcount = $post->all_posts()->rowCount();
    $userpostscount = $database->find_query("posts",$currentuser,"author")->rowCount();
    $commentcount = $comment->all_comments()->rowCount();
    $usercount = $user->all_users()->rowCount();
     ?>
    <div class="row">
        <?php if($role=="Admin"): ?>
        <!-- Item -->
        <div class="col-lg-3 col-md-6 col-xs-6">
            <div class="dashboard-stat color-1">
                <div class="dashboard-stat-content"><h4><?php echo $catcount; ?></h4> <span>Total Categories</span></div>
                <div class="dashboard-stat-icon"><i class="im im-icon-Map2"></i></div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($role=="Admin" OR $role=="Moderator"): ?>
        <!-- Item -->
        <div class="col-lg-3 col-md-6 col-xs-6">
            <div class="dashboard-stat color-2">
                <div class="dashboard-stat-content"><h4><?php echo $postcount; ?></h4> <span>Total Posts</span></div>
                <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($role=="Author"): ?>
        <!-- Item -->
        <div class="col-lg-3 col-md-6 col-xs-6">
            <div class="dashboard-stat color-2">
                <div class="dashboard-stat-content"><h4><?php echo $userpostscount; ?></h4> <span>Your Posts</span></div>
                <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
            </div>
        </div>
        <?php endif; ?>


        <?php if($role=="Admin" OR $role=="Moderator"): ?>
        <!-- Item -->
        <div class="col-lg-3 col-md-6 col-xs-6">
            <div class="dashboard-stat color-3">
                <div class="dashboard-stat-content"><h4><?php echo $commentcount; ?></h4> <span>Total Comments</span></div>
                <div class="dashboard-stat-icon"><i class="im im-icon-Big-Data"></i></div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($role=="Admin"): ?>
        <div class="col-lg-3 col-md-6 col-xs-6">
            <div class="dashboard-stat color-4">
                <div class="dashboard-stat-content"><h4><?php echo $usercount; ?></h4> <span>Total Users</span></div>
                <div class="dashboard-stat-icon"><i class="im im-icon-User"></i></div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php if($role=="Admin" or $role=="Moderator"): ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12 traffic">
            <div class="dashboard-list-box">
                <h4 class="gray">Recent Posts</h4>
                <div class="table-box">
                    <table class="basic-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Author</th>
                                <th>Views</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $res = $database->select_query("posts","id","DESC",5);
                            while ($row = $res->fetch()):
                             ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td class="t-id"><?php echo substr($row['title'],0,40)."..."; ?></td>
                                <td><?php echo substr(strip_tags($row['content']),0,50)."..."; ?></td>
                                <td><?php echo $row['author']; ?></td>
                                <td><?php echo $row['view_count']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
    </div>
    <?php endif; ?>

</div>
<?php include("includes/footer.php"); ?>