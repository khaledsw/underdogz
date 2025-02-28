<?php
/*
 * @package Courses Manager
 * @version 1.0.0
 * @created Mar 18, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of courses
 *
 * @developer duongca
 */
require (ABSPATH . 'wp-content/plugins/iw_courses/includes/utility.php');
get_header();
$utility = new iwcUtility();
wp_enqueue_script('iwc-js');
?>
<section class="page-heading">
    <div class="title-slide">
        <div class="container">
            <div class="banner-content slide-container">									
                <div class="page-title">
                    <h3><?php the_title(); ?></h3>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="page-content">					
    <!-- Breadcrumbs -->
    <?php include(get_template_directory() . '/blocks/breadcrumb.php'); ?>
    <!-- End Breadcrumbs -->
    <!-- Main Content -->
    <div class="main-content class-detail">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                    <!-- Banner Content -->
                    <?php
                    $image_gallery_data = get_post_meta($post->ID, 'iw_courses_image_gallery', true);
                    $image_gallery = unserialize($image_gallery_data);
                    if ($image_gallery):
                        ?>
                        <section class="banner-details">
                            <div data-ride="carousel" class="carousel slide" id="carousel">											
                                <!-- Wrapper for slides -->
                                <div role="listbox" class="carousel-inner">
                                    <?php for ($i = 0; $i < count($image_gallery); $i++): ?>
                                        <div class="item<?php echo $i == 0 ? ' active' : ''; ?>">
                                            <img alt="" src="<?php echo site_url() . $image_gallery[$i]; ?>">
                                        </div>
                                    <?php endfor; ?>
                                </div>
                                <?php if (count($image_gallery) > 1): ?>
                                    <!-- Left and right controls -->
                                    <a data-slide="prev" role="button" href="#carousel" class="left carousel-control">
                                        <span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span>
                                        <span class="sr-only"><?php echo __('Previous', 'inwavethemes'); ?></span>
                                    </a>
                                    <a data-slide="next" role="button" href="#carousel" class="right carousel-control">
                                        <span aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span>
                                        <span class="sr-only"><?php echo __('Next', 'inwavethemes'); ?></span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                    <!-- End Banner Content -->

                    <!--  Desc -->
                    <div class="content-page">
                        <section class="class-details">
                            <div class="details-desc-title">
                                <h5><?php echo __('Class details', 'inwavethemes'); ?></h5>
                                <?php if ($utility->getCoursesOption('enable_voting', '0') == 1): ?>
                                    <div class="btp-detail-voting">
                                        <?php
                                        if ($utility->getCoursesOption('enable_voting', '0') == 1):
                                            $results = $wpdb->get_row($wpdb->prepare('SELECT COUNT(id) as vote_count, SUM(vote) as vote_sum FROM ' . $wpdb->prefix . 'iw_courses_vote WHERE item_id=%d', get_the_ID()));
                                            $voteSum = $results->vote_sum;
                                            $voteCount = $results->vote_count;
                                            echo $utility->getAthleteRatingPanel(get_the_ID(), $voteSum, $voteCount);
                                        endif;
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php the_content(); ?>
                        </section>
                        <div class="share">
                            <div class="share-title">
                                <h5><?php echo __('Share This Class', 'inwavethemes'); ?></h5>										
                            </div>
                            <div class="social-icon">
                                <?php getSocialSharing(get_permalink(), $utility->truncateString(get_the_excerpt(), 10), get_the_title()); ?>
                            </div>
                        </div>
                    </div>
                    <!-- End Desc -->

                    <!--  Comments -->
                    <?php if (comments_open()) : ?>
                        <section class="comments">
                            <?php comments_template(); ?> 
                        </section>
                    <?php endif; ?>
                    <!-- End Comments -->	

                </div>		
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <?php
                    $courses_teacher = get_post_meta($post->ID, 'iw_courses_teacher', true);
                    if ($courses_teacher):
                        $teacher = get_post($courses_teacher);
                        if ($teacher):
                            $permalink = get_permalink($teacher->ID);
                            $feature_img = wp_get_attachment_image_src(get_post_thumbnail_id($teacher->ID), 'single-post-thumbnail');
                            ?>
                            <section class="class-trainer">
                                <div class="class-trainer-title">
                                    <h4><?php echo __('Class Trainer', 'inwavethemes'); ?></h4>
                                    <div class="img-trainer">
                                        <img alt="<?php echo $permalink; ?>" src="<?php echo $feature_img[0]; ?>">
                                    </div>
                                </div>
                                <div class="class-trainer-content">
                                    <h4><?php echo $teacher->post_title; ?></h4>
                                    <p>
                                        <?php echo $utility->truncateString($teacher->post_content, 15); ?>
                                    </p>
                                    <a href="<?php echo $permalink; ?>" class="profile"><?php echo __('Profile', 'inwavethemes'); ?></a>
                                </div>
                            </section>
                            <?php
                        endif;
                    endif;
                    ?>
                    <?php
                    $extrafiels_data = $wpdb->get_results($wpdb->prepare("SELECT b.name, a.value, b.type FROM " . $wpdb->prefix . "iw_courses_extrafields_value as a INNER JOIN " . $wpdb->prefix . "iw_courses_extrafields as b ON a.extrafields_id = b.id WHERE a.courses_id=%d", get_the_ID()));
                    if ($extrafiels_data):
                        ?>
                        <section class="class-info">
                            <div class="class-info-title">
                                <h4><?php echo __('Class Information', 'inwavethemes'); ?></h4>
                            </div>
                            <?php
                            foreach ($extrafiels_data as $field):
                                $name = $field->name;
                                $value = $field->value;
                                ?>
                                <?php
                                switch ($field->type):
                                    case 'link':
                                        $link_data = unserialize(html_entity_decode($value));
                                        if ($link_data['link_value_link']):
                                            ?>
                                            <div class="class-info-content">
                                                <div class="info-content">
                                                    <span class="extrafield-name"><?php echo $name; ?>: </span>
                                                    <span class="extrafield-value">
                                                        <a href="<?php echo $link_data['link_value_link']; ?>"target="<?php echo $link_data['link_value_target']; ?>"><?php echo $link_data['link_value_text']; ?></a>
                                                    </span>
                                                </div>
                                            </div>
                                            <?php
                                        endif;
                                        break;
                                    case 'image':
                                        if ($value):
                                            ?>
                                            <div class="class-info-content">
                                                <div class="info-content">
                                                    <span class="extrafield-name"><?php echo $name; ?>: </span>
                                                    <span class="extrafield-value">
                                                        <img src="<?php echo $value ?>" width="150px" />
                                                    </span>
                                                </div>
                                            </div>
                                            <?php
                                        endif;
                                        break;
                                    case 'measurement':
                                        $measurement_data = unserialize(html_entity_decode($value));
                                        if ($measurement_data['measurement_value']):
                                            ?>
                                            <div class="class-info-content">
                                                <div class="info-content">
                                                    <span class="extrafield-name"><?php echo $name; ?>: </span>
                                                    <span class="extrafield-value">
                                                        <?php echo $measurement_data['measurement_value'] . ' ' . $measurement_data['measurement_unit']; ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <?php
                                        endif;
                                        break;
                                    case 'dropdown_list':
                                        $drop_data = unserialize(html_entity_decode($value));
                                        if (!empty($drop_data)):
                                            ?>
                                            <div class="class-info-content">
                                                <div class="info-content">
                                                    <span class="extrafield-name"><?php echo $name; ?>: </span>
                                                    <span class="extrafield-value">
                                                        <?php echo implode(', ', $drop_data); ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <?php
                                        endif;
                                        break;
                                    default:
                                        if ($value):
                                            ?>
                                            <div class="class-info-content">
                                                <div class="info-content">
                                                    <span class="extrafield-name"><?php echo stripslashes(($name)); ?>: </span>
                                                    <span class="extrafield-value">
                                                        <?php echo htmlentities($value); ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <?php
                                        endif;
                                        break;
                                endswitch;
                                ?>
                                <?php
                            endforeach;
                            ?>
                            <div class="course">
                                <span><?php echo __('Take This Course', 'inwavethemes'); ?></span>
                            </div>
                            <div id="take-this-courses" style="display:none;">
                                <?php
                                $post_cat = wp_get_post_terms(get_the_ID(), 'iw_courses_class');
                                ?>
                                <div class="ajax-overlay">
                                    <span class="ajax-send-loading"><i class="fa fa-spinner fa-spin fa-2x"></i></span>
                                </div>
                                <form action="#" method="post">
                                    <div class="take-header">
                                        <div class="title"><?php echo __('TAKE THIS COURSE FORM', 'inwavethemes'); ?></div>
                                        <button type="button" class="take-close" onclick="jQuery.fn.custombox('close')">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <div style="clear: both;"></div>
                                    </div>
                                    <div class="take-message">
                                        <ul class="list-message">
                                        </ul>
                                        <div style="clear: both;"></div>
                                    </div>
                                    <div class="take-content">
                                        <div class="take-left">
                                            <a href="<?php echo get_term_link($post_cat[0]); ?>"><span><?php echo __('CHANGE COURSE', 'inwavethemes'); ?></span></a>
                                            <input type="text" name="post_title" value="<?php echo get_the_title(); ?>" disabled="disabled" class="disabled">
                                            <input type="text" name="yname" required="required" placeholder="<?php echo __('Your name', 'inwavethemes'); ?>">
                                            <input type="email" name="yemail" required="required" placeholder="<?php echo __('Your email', 'inwavethemes'); ?>">
                                            <input type="text" name="ymobile" placeholder="<?php echo __('Your mobile', 'inwavethemes'); ?>">
                                            <input type="hidden" name="teacher_email" value="<?php echo $courses_teacher; ?>">
                                        </div>
                                        <div class="take-right">
                                            <textarea name="ymessage"  required="required" placeholder="<?php echo __('Your message', 'inwavethemes'); ?>"></textarea>
                                            <input onclick="sendTakeCourse();
                                                    return false" type="submit" value="<?php echo __('TAKE THIS COURSE', 'inwavethemes'); ?>"/>
                                        </div>
                                    </div>
                                </form>
                                <div style="clear: both"></div>
                            </div>
                        </section>
                        <?php
                    endif;
                    $courses_value = get_post_meta(get_the_ID(), 'iw_courses_related_couses', true);
                    $courses = unserialize($courses_value);
                    if ($courses):
                        ?>
                        <section class="class-related">
                            <div class="class-related-title">
                                <h4><?php echo __('Class Related', 'inwavethemes'); ?></h4>											
                            </div>
                            <div class="classes-content">
                                <?php
                                foreach ($courses as $cour):
                                    $courses_post = get_post($cour['key_value']);
                                    $permalink = get_permalink($cour['key_value']);
                                    $feature_img = wp_get_attachment_image_src(get_post_thumbnail_id($cour['key_value']), 'single-post-thumbnail');
                                    ?>
                                    <div class="related-product related-product-1">
                                        <div class="box-inner">
                                            <img alt="" src="<?php echo $feature_img[0]; ?>">
                                            <div class="box-content">
                                                <div class="table">
                                                    <div class="box-cell">
                                                        <div class="title">
                                                            <a href="<?php echo $permalink; ?>">
                                                                <span><?php echo $courses_post->post_title; ?></span>
                                                            </a>
                                                        </div>
                                                        <div class="box-text"><?php echo $utility->truncateString($courses_post->post_content, 5); ?></div>
                                                        <div class="box-details">
                                                            <a href="<?php echo $permalink; ?>"><?php echo __('Details', 'inwavethemes'); ?></a>
                                                        </div>
                                                    </div>
                                                </div>	
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                endforeach;
                                ?>

                            </div>
                        </section>
                        <?php
                    endif;
                    ?>

                </div>								
            </div>
        </div>
    </div>
    <!-- Main Content -->
</div>

<?php
get_footer();
