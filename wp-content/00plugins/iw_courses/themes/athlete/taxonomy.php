<?php
/*
 * @package Courses Manager
 * @version 1.0.0
 * @created Mar 17, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of list_teacher
 *
 * @developer duongca
 */
get_header();
$get_term = get_term_by('slug', get_query_var('iw_courses_class'), 'iw_courses_class');
?>
<section class="page-heading">
    <div class="title-slide">
        <div class="container">
            <div class="banner-content slide-container">									
                <div class="page-title">
                    <h3><?php echo single_cat_title(); ?></h3>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="page-content" style="padding-top: 0;">
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul>
                        <li class="home"><a href="<?php echo site_url(); ?>"><i class="fa fa-home"></i> <?php _e('Home', 'inwavethemes'); ?></a></li>
                        <li><span>//</span></li>
                        <li><?php echo single_cat_title(); ?></li>                
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <!-- End Breadcrumbs -->
                <?php echo do_shortcode('[iw_courses_list theme="athlete" cats=' . $get_term->term_taxonomy_id . ' show_filter_bar="0"]'); ?>
                <!-- End Athlete Class -->
            </div>
        </div>
    </div>
</div>
<!-- End Page content Class -->
<?php
get_footer();
