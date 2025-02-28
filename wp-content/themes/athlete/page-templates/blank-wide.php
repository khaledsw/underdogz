<?php
/**
 * Template Name: Blank template - Wide
 * This is the template that is used for custom page
 */
get_header();
?>
<div class="page-content" style="margin-top:100px;">
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('content', 'page'); ?>
    <?php endwhile; // end of the loop. ?>
</div>
<?php get_footer(); ?>
