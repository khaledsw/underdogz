<?php
/**
 * The main template file
 *
 * @package gmswebdesign
 * @subpackage Athlete
 * @since Athlete 1.0
 */
get_header();
?>
<?php if ($athlete_cfg['slide-id']) { ?>
    <div class="slider-container">
        <?php masterslider($athlete_cfg['slide-id']); ?>
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
    <div class="main-content our-blog">
        <div class="container">
            <div class="row">
                <div class="<?php echo ($athlete_cfg['sidebar-position'] == 'left' || $athlete_cfg['sidebar-position'] == 'right') ? 'col-lg-9 col-md-8' : 'col-md-12' ?> col-sm-12 col-xs-12 <?php echo $athlete_cfg['sidebar-position'] == 'left' ? 'pull-right' : '' ?>">
                    <?php if (have_posts()) : ?>
                        <?php /* Start the Loop */ ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <?php
                            /* Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part('content', get_post_format());
                            ?>
                        <?php endwhile; ?>
                        <?php include(get_template_directory() . '/blocks/paging.php'); ?>
                    <?php else : ?>
                        <?php get_template_part('content', 'none'); ?>
                    <?php endif; ?>
                </div>
                <?php if ($athlete_cfg['sidebar-position']) { ?>
                    <div class="<?php echo $athlete_cfg['sidebar-position'] == 'bottom' ? 'col-md-12' : 'col-lg-3 col-md-4' ?> col-sm-12 col-xs-12 <?php echo 'pull-' . $athlete_cfg['sidebar-position'] ?>">
                        <?php get_sidebar($athlete_cfg['sidebar-name']); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>