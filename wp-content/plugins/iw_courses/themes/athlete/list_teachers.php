<?php
/*
 * @package Courses Manager
 * @version 1.0.0
 * @created Mar 17, 2015
 * @author gmswebdesign
 * @email gmswebdesign@gmail.com
 * @website http://gmswebdesign.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 gmswebdesign. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of list_teacher
 *
 * @developer duongca
 */
global $wpdb;
$utility = new iwcUtility();
$query = $utility->getCoursesTeacherList($item_per_page);

if ($query->have_posts()) {
    
} else {
    echo __('No course was found','gmswebdesign');
}
?>
<section class="classes teachers" id="classes">
    <div class="our-class-main">
        <section class="our-trainers" id="our-trainers">
            <div class="row">
                <?php
                $i = 0;
                while ($query->have_posts()) :
                    $query->the_post();
                    $post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'iw_courses-thumb');
                    if ($i % 3 == 0 && $i > 0)
                        echo '</div><div class="row">';
                    $i++;
                    ?>
                    <div class="element-item our-trainer-box col-md-4 col-sm-6 col-xs-12">
                        <div class="product-image-wrapper">
                            <div class="product-content">
                                <div class="product-image product-trainer">
                                    <?php
                                    $image_gallery_data = get_post_meta(get_the_ID(), 'iw_teacher_image_gallery', true);
                                    $image_gallery = unserialize($image_gallery_data);
                                    if ($image_gallery):
                                        $image = site_url() . $image_gallery[0];
                                        echo '<a href="' . get_the_permalink() . '"><img alt="" src="' . $image . '"></a>';
                                    endif;
                                    ?>
                                </div>
                                <div class="info-products">
                                    <div class="img-trainers">
                                        <img alt="" src="<?php echo esc_url(get_template_directory_uri()); ?>/iw_courses/assets/images/boxing-icon-1.png">
                                    </div>
                                    <div class="product-name">
                                        <a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a>
                                        <div class="product-bottom"></div>
                                    </div>
                                    <div class="product-info">																										
                                        <?php the_excerpt(); ?>
                                    </div>												
                                    <div class="actions">
                                        <?php
                                        $social_link_data = get_post_meta(get_the_ID(), 'iw_teacher_social_link', true);
                                        $social_link = unserialize($social_link_data);
                                        if ($social_link) {
                                            echo '<ul>';
                                            foreach ($social_link as $link) {
                                                if ($link['key_value']) {
                                                    echo '<li><a target="_blank" href="' . $link['key_value'] . '"><i class="fa fa-' . $link['key_title'] . '"></i></a></li>';
                                                }
                                            }
                                            echo '</ul>';
                                        }
                                        ?>
                                    </div>
                                </div>												
                            </div>								
                        </div>						
                    </div>
                    <?php
                endwhile;
                ?>
            </div>
        </section>
    </div>
    <div class="load-product">
        <div class="row">
            <div class="col-md-12">
                <?php
                $rs = $utility->courses_display_pagination_none($query);
                if ($rs['success']) {
                    echo '<button class="load-more load-teacher" id="load-more-class"><span class="ajax-loading-icon" style="margin-right: 10px; display: none;"><i class="fa fa-spinner fa-spin fa-2x"></i></span>' . __('Load More', 'gmswebdesign') . '</button>';
                    echo $rs['data'];
                } else {
                    echo '<button class="load-more load-teacher all-loaded" id="load-more-class"><span class="ajax-loading-icon" style="margin-right: 10px; display: none;"><i class="fa fa-spinner fa-spin fa-2x"></i></span>' . __('All loaded', 'gmswebdesign') . '</button>';
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
</section>
<!-- End Athlete Class -->