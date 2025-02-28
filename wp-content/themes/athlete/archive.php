<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
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
                    <?php if ($athlete_cfg['show-pageheading']) { ?>
                        <h3><?php
                            if (is_day()) :
                                printf(__('Daily Archives: %s', 'gmswebdesign'), get_the_date());

                            elseif (is_month()) :
                                printf(__('Monthly Archives: %s', 'gmswebdesign'), get_the_date(_x('F Y', 'monthly archives date format', 'gmswebdesign')));

                            elseif (is_year()) :
                                printf(__('Yearly Archives: %s', 'gmswebdesign'), get_the_date(_x('Y', 'yearly archives date format', 'gmswebdesign')));

                            else :
                                _e('Archives', 'gmswebdesign');

                            endif;
                            ?></h3>
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
                        get_template_part('content', 'none');
                    endif; ?>
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
