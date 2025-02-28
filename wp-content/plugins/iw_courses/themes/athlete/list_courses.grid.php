<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
if ($utility->getCoursesOption('show_category_menu', 1) == 1):
    echo $utility->filterHtmlForm();
endif;
?>
<div class="btp-grid-view">
    <?php
    while ($query->have_posts()) :
        $query->the_post();
        $post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'iw_courses-thumb');
        ?>
        <div class="btp-grid-item" style="width: <?php echo ((100 / $utility->getCoursesOption('grid_column', 3)) - 0.5) . '%'; ?>">
            <div class="btp-item-image">
                <a href="<?php the_permalink(); ?>" class="img-link-custom-btp" style="background-color: rgb(0, 0, 0);">
                    <?php if ($post_thumb[0]): ?>
                        <?php the_post_thumbnail('iw_courses-thumb'); ?>
                    <?php else: ?>
                        <img src="<?php echo plugins_url('iw_courses/themes/' . $utility->getCoursesOption('theme', 'athlete') . '/assets/images/photo_default.png'); ?>" style="width:<?php echo $utility->getCoursesOption('thumb_width', 370); ?>px; height:<?php echo $utility->getCoursesOption('thumb_height', 250); ?>px" />
                    <?php endif; ?>
                </a>
            </div>
            <h3 class="btp-item-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a>
            </h3>
        </div>
    <?php endwhile; ?>
    <div class="clr"></div>
    <!-- Show pagination -->
    <?php
    $utility->courses_display_pagination($query);
    wp_reset_postdata();
    ?>
</div>
