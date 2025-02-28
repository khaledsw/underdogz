<?php
/**
 * Template Name: Calendar View
 * This is the template that is used for the calendar full view page...
 */
get_header();
?>
<div class="page-heading calendar-banner"></div>
<div class="page-content">
<div class="iw-calendar">
    <div class="container">
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('content', 'page'); ?>

        <?php
        // If comments are open or we have at least one comment, load up the comment template
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>

    <?php endwhile; // end of the loop. ?>
    </div>
</div>
</div>
<?php get_footer(); ?>
