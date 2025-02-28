<?php
/**
 * The template for displaying Author archive pages
 * @package athlete
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
                    <?php if($athlete_cfg['show-pageheading']){ ?>
                     <h3><?php printf( __( 'All posts by %s', 'gmswebdesign' ), get_the_author() ); ?></h3>
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
                    <?php if ( have_posts() ) : ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <?php
                            $post_format = get_post_format();
                            switch ($post_format) {
                                case 'link':
                                    $p_format = 'link';
                                    break;
                                case 'video':
                                    $p_format = 'video';
                                    break;
                                case 'quote':
                                    $p_format = 'quote';
                                    break;
                                case 'gallery':
                                    $p_format = 'gallery';
                                    break;
                                default:
                                    $p_format = 'atdefault';
                                    break;
                            }
                            get_template_part('content', $p_format); ?>
                        <?php endwhile; // end of the loop. ?>
                    <?php include(get_template_directory() . '/blocks/paging.php'); ?>
                    <?php else :
                        // If no content, include the "No posts found" template.
                        get_template_part( 'content', 'none' );

                    endif;?>
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
