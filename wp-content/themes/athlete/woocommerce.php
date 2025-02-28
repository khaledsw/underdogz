<?php
/**
 * The template for displaying Woocommerce pages
 * @package athlete
 */
global $athlete_cfg;
if(!isset($athlete_cfg['page-classes'])){
    $athlete_cfg['page-classes'] = '';
}
$athlete_cfg['page-classes'] .= ' page-product';
get_header();
?>
<section class="page-heading">
    <div class="title-slide">
        <div class="container">
            <div class="banner-content slide-container">
                <div class="page-title">
                    <?php if($athlete_cfg['show-pageheading']){ ?>
                        <h3><?php echo woocommerce_page_title() ?></h3>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="page-content">
    <?php woocommerce_breadcrumb(); ?>
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div
                    class="<?php echo ($athlete_cfg['sidebar-position'] == 'left' || $athlete_cfg['sidebar-position'] == 'right') ? 'col-lg-9 col-md-8' : 'col-md-12' ?> col-sm-12 col-xs-12 <?php echo $athlete_cfg['sidebar-position'] == 'left' ? 'pull-right' : '' ?>">
                    <?php
                    if ( is_singular( 'product' ) ) {
                        while ( have_posts() ) : the_post();
                            wc_get_template_part( 'content', 'single-product' );
                        endwhile;
                    } else {
                        wc_get_template_part( 'category', 'product' );
                    }
                    ?>
                    </div>
                <?php if ($athlete_cfg['sidebar-position']) { ?>
                    <div
                        class="<?php echo $athlete_cfg['sidebar-position'] == 'bottom' ? 'col-md-12' : 'col-lg-3 col-md-4' ?> col-sm-12 col-xs-12 <?php echo 'pull-' . $athlete_cfg['sidebar-position'] ?>">
                        <?php get_sidebar('woocommerce'); ?></div>
                <?php } ?>
            </div>
        </div>

    </div>
</div>

<?php get_footer(); ?>
