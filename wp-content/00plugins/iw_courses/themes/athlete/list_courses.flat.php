<section class="classes" id="classes">
    <?php
    if ($show_filter_bar):
        $cat_array = explode(',', $cats);
        if (in_array('0', $cat_array)) {
            $categories = get_terms('iw_courses_class', 'hide_empty=1');
        } else {
            $categories = get_terms('iw_courses_class', array('hide_empty'=>'1', 'include'=>$cat_array));
        }
        ?>
        <div class="categories">
            <div class="filters button-group" id="filters">
                <?php
                if (!empty($categories)) {
                    echo '<button class="filter is-checked" data-filter="*">' . __('All Class', 'inwavethemes') . '</button>';
                    foreach ($categories as $cat) {
                        echo '<button class="filter" data-filter=".' . $cat->slug . '">' . $cat->name . '</button>';
                    }
                }
                ?>
            </div>
        </div>
        <?php
    endif;
    ?>
    <div class="our-class-main">
        <div class="row">
            <div class="classes-athlete">
                <div class="classes-inner">
                    <div class="classes-content" id="filtering-demo">
                        <section class="isotope" id="our-class-main" style="">
                            <?php
                            while ($query->have_posts()) :
                                $query->the_post();
                                $post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'iw_courses-thumb');
                                $terms = wp_get_post_terms(get_the_ID(), 'iw_courses_class');
                                if (!empty($terms)) {
                                    $data_cat = $terms[0]->slug;
                                    $class = array();
                                    foreach ($terms as $cat) {
                                        $class[] = $cat->slug;
                                    }
                                }
                                ?>
                                <div data-category="<?php echo $data_cat ? $data_cat : ''; ?>" class="<?php echo $class ? implode(' ', $class) : ''; ?> mix element-item col-xs-12 col-sm-6 col-md-4" style="">
                                    <div class="box-inner">
                                        <?php if ($post_thumb[0]): ?>
                                            <img alt="" src="<?php echo $utility->getPathImage('thumb', get_post_thumbnail_id(get_the_ID())); ?>">
                                        <?php endif; ?>
                                        <div class="box-content">
                                            <div class="table">
                                                <div class="box-cell">
                                                    <div class="title">
                                                        <a href="<?php echo get_the_permalink(); ?>">
                                                            <span><?php the_title(); ?></span>
                                                        </a>
                                                    </div>
                                                    <div class="box-text"><?php echo $utility->truncateString(get_the_content(), 15); ?></div>
                                                    <div class="box-details">
                                                        <a href="<?php echo get_the_permalink(); ?>"><?php echo __('Details', 'inwavethemes'); ?></a>
                                                    </div>
                                                </div>
                                            </div>	
                                        </div>
                                    </div>										
                                </div>
                                <?php
                            endwhile;
                            ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="load-product">
        <?php
        $rs = $utility->courses_display_pagination_none($query);
        if ($rs['success']) {
            echo '<button class="load-more load-courses" id="load-more-class"><span class="ajax-loading-icon" style="margin-right: 10px; display: none;"><i class="fa fa-spinner fa-spin fa-2x"></i></span>' . __('Load More', 'inwavethemes') . '</button>';
            echo $rs['data'];
        } else {
            echo '<button class="load-more load-courses all-loaded" id="load-more-class"><span class="ajax-loading-icon" style="margin-right: 10px; display: none;"><i class="fa fa-spinner fa-spin fa-2x"></i></span>' . __('All loaded', 'inwavethemes') . '</button>';
        }
        wp_reset_postdata();
        ?>
    </div>
</section>
<!-- End Athlete Class -->