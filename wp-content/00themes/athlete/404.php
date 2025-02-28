<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package athlete
 */

get_header(); ?>
<section class="page-heading">
    <div class="title-slide">
        <div class="container">
            <div class="banner-content slide-container">
                <div class="page-title">
                    <?php if ($athlete_cfg['show-pageheading']) { ?>
                        <h3><?php _e( 'Oops! That page can&rsquo;t be found.', 'inwavethemes' ); ?></h3>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="page-content">
    <div class="container">
        <section class="error-404 not-found">
            <p>WPLOCKER.COM - <?php _e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'inwavethemes'); ?></p>
            <?php get_search_form(); ?>
        </section>
        <!-- .error-404 -->
    </div>
</div><!-- .page-content -->
<?php get_footer(); ?>
