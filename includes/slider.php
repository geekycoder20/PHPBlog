<section id="mt_banner">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php 
                $limits = $setting->find_limits();
                $alllimits = $limits->fetch();
                $limit = $alllimits['slider'];
                $res = $slider->show_sliders($limit);
                while ($row = $res->fetch()) :
                    $postid = $row['postid'];
                 ?>

                <div class="swiper-slide">
                    <div class="slide-inner" style="background-image:url(images/blog-listing/<?php echo $row['thumbnail']?>)"></div>
                    <div class="banner_caption_text">
                        <div class="post-category">
                            <ul>
                                
                                <?php 
                                $cats = $category->postcategories($postid);
                                foreach($cats as $cat):
                                 ?>
                                <li class="cat-blue"><a href="javascript:void" class="white"><?php echo $cat['cat_title']; ?></a></li>
                            <?php endforeach; ?>


                            </ul>
                        </div>
                        <h1><a href="post/<?php echo $row['slug']?>"><?php echo $row['title']; ?></a></h1>
                        <div class="item-meta">
                            <span>by</span>
                            <a href="javascript:void"><?php echo $row['author']; ?></a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
                
            </div>
            <div class="swiper-button-next swiper-button-white"></div>
            <div class="swiper-button-prev swiper-button-white"></div>
        </div>
</section>