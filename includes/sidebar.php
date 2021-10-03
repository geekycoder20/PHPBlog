<div class="col-md-3 width30">
    <div class="sidebar">
        <!-- widget category -->
        <div class="widget widget-category">
            <div class="widget-content">
                <div class="widget-title">
                    <h3 class="white">Category</h3>
                </div>
                <div class="widget-category-main" id="mycatsbody">
                    <ul class="widget-category-list">
                        <?php 
                        $categories = $category->show_categories();
                        while ($row = $categories->fetch()) :
                         ?>
                         <form>
                            <li><a class="cat_link" cat_id="<?php echo $row['id']?>" href="javascript:void(0)"><?php echo $row['cat_title']; ?></a></li>
                        </form>                         
                        
                    <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- widget popular post -->
        <div class="widget widget-popular-post">
            <div class="widget-content">
                <div class="widget-title">
                    <h3 class="white">Popular Posts</h3>
                </div>
                <div class="widget-popular-post-main">
                    <?php 
                    $limits = $setting->find_limits();
                    $alllimits = $limits->fetch();
                    $limit = $alllimits['popular'];
                    $posts = $post->pouplar_posts($limit);
                    while ($row = $posts->fetch()) :
                     ?>

                    <div class="widget-posts">
                        <div class="post-thumb">
                            <img style="height: 64px; width: 64px;" src="images/blog-listing/<?php echo $row['thumbnail']?>" alt=".....">
                        </div>
                        <div class="post-title">
                            <div class="widget-cats">
                                <?php 
                                $cats = $category->postcategories($row['id']);
                                foreach ($cats as $cat) :
                                 ?>
                                <a href="javascript:void"><?php echo $cat['cat_title']; ?></a>
                            <?php endforeach; ?>
                            </div>
                            <h4><a href="post/<?php echo $row['slug']?>"><?php echo substr($row['title'],0,40)."..." ?></a></h4>
                        </div>
                    </div>
                <?php endwhile; ?>

                    
                </div>
            </div>
        </div>


        <div class="widget widget-popular-post">
            <div class="widget-content">
                <div class="widget-title">
                    <h3 class="white">Random Posts</h3>
                </div>
                <div class="widget-popular-post-main">
                    <?php 
                    $limits = $setting->find_limits();
                    $alllimits = $limits->fetch();
                    $limit = $alllimits['random'];
                    $posts = $post->random_posts($limit);
                    while ($row = $posts->fetch()) :
                     ?>

                    <div class="widget-posts">
                        <div class="post-thumb">
                            <img style="height: 64px; width: 64px;" src="images/blog-listing/<?php echo $row['thumbnail']?>" alt=".....">
                        </div>
                        <div class="post-title">
                            <div class="widget-cats">
                                <?php 
                                $cats = $category->postcategories($row['id']);
                                foreach ($cats as $cat) :
                                 ?>
                                <a href="javascript:void"><?php echo $cat['cat_title']; ?></a>
                            <?php endforeach; ?>
                            </div>
                            <h4><a href="post/<?php echo $row['slug']?>"><?php echo substr($row['title'],0,40)."..."; ?></a></h4>
                        </div>
                    </div>
                <?php endwhile; ?>

                    
                </div>
            </div>
        </div>
    </div>

    
</div>
</div> 