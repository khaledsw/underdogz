<?php
/**
 * Template Name: Home Page
 * This is the template that is used for the Home page
 */
$athlete_cfg['header-option'] = 'page';
get_header();
?>
<?php if ($athlete_cfg['slide-id']) { ?>
    <section class="slide-container to-top">
        <?php masterslider($athlete_cfg['slide-id']); ?>
        <div id="to-bottom" class="to-bottom"><i class="fa fa-angle-down"></i></div>
    </section>
<?php } ?>
<div class="contents-main" id="contents-main">
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('content', 'page'); ?>
    <?php endwhile; // end of the loop. ?>
</div>

<?php get_footer(); ?>
