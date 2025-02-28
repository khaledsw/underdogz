<?php
/**
 * Template Name: Inner Page (Normal width)
 * This is the template that is used for the contact page, about page ...
 */
get_header();
?>
<?php if ($athlete_cfg['slide-id']) { ?>
    <div class="container">
        <div class="slider-container">
            <?php masterslider($athlete_cfg['slide-id']); ?>
        </div>
    </div>
<?php } ?>
<section class="page-heading">
    <div class="title-slide">
        <div class="container">
            <div class="banner-content slide-container">
                <div class="page-title">
                    <?php if ($athlete_cfg['show-pageheading']) { ?>
                        <?php the_title('<h3>','</h3>') ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="page-content">
    <?php include(get_template_directory() . '/blocks/breadcrumb.php'); ?>
<div class="container">
<div class="row">
        <div class="<?php echo ($athlete_cfg['sidebar-position'] == 'left' || $athlete_cfg['sidebar-position'] == 'right') ? 'col-lg-9 col-md-8' : 'col-md-12' ?> col-sm-12 col-xs-12 <?php echo $athlete_cfg['sidebar-position'] == 'left' ? 'pull-right' : '' ?>">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('content', 'page'); ?>
            <?php endwhile; // end of the loop. ?>
            <?php
            // If comments are open or we have at least one comment, load up the comment template
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
        </div>
        <?php if ($athlete_cfg['sidebar-position']) { ?>
            <div class="<?php echo $athlete_cfg['sidebar-position'] == 'bottom' ? 'col-md-12' : 'col-lg-3 col-md-4' ?> col-sm-12 col-xs-12 <?php echo 'pull-' . $athlete_cfg['sidebar-position'] ?>">
                <?php get_sidebar($athlete_cfg['sidebar-name']); ?>
            </div>
        <?php } ?>

    </div>
    </div>
</div>
<?php get_footer(); ?>
