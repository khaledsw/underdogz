<?php
/*
 * @package Courses Manager
 * @version 1.0.0
 * @created Mar 11, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of teacher
 *
 * @developer duongca
 */
require(ABSPATH . 'wp-content/plugins/iw_courses/includes/utility.php');

get_header();
$utility = new iwcUtility();
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

            <div class="profile-details">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                        <section class="banner-details">
                            <div class="carousel slide" id="carousel">
                                <!-- Wrapper for slides -->
                                <div role="listbox" class="carousel-inner">
                                    <?php
                                    $image_gallery_data = get_post_meta(get_the_ID(), 'iw_teacher_image_gallery', true);
                                    $image_gallery = unserialize($image_gallery_data);
                                    if ($image_gallery):
                                        for ($i = 0; $i < count($image_gallery); $i++) {
                                            if ($i == 0) {
                                                echo '<div class="item active">';
                                            } else {
                                                echo '<div class="item">';
                                            }
                                            echo '<img alt="" src="' . (site_url() . $image_gallery[$i]) . '">';
                                            echo '</div>';
                                        }
                                    endif;
                                    ?>
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
                        <!-- End Banner Content -->
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">
                        <section class="profile">
                            <div class="profile-title">
                                <div class="row">
                                    <div class="img-profile1">
                                        <?php $feature_img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail'); ?>
                                        <img alt="" src="<?php echo $feature_img[0]; ?>">
                                    </div>
                                    <div class="profile-info">
                                        <?php
                                        $basic_info_date = get_post_meta(get_the_ID(), 'iw_teacher_basic_info', true);
                                        $basic_info = unserialize($basic_info_date);
                                        if ($basic_info):
                                            for ($i = 0; $i < count($basic_info); $i++):
                                                if ($i == 0):
                                                    ?>
                                                    <div class="profile-info-top">
                                                        <span><?php echo $basic_info[$i]['key_title']; ?></span>
                                                        <span
                                                            class="profile-info-right">: <?php echo $basic_info[$i]['key_value']; ?></span>
                                                    </div>
                                                    <?php
                                                elseif ($i == count($basic_info) - 1):
                                                    ?>
                                                    <div class="profile-info-bottom">
                                                        <span><?php echo $basic_info[$i]['key_title']; ?></span>
                                                        <span
                                                            class="profile-info-right">: <?php echo $basic_info[$i]['key_value']; ?></span>
                                                    </div>
                                                    <?php
                                                else:
                                                    ?>
                                                    <div class="profile-info-top">
                                                        <span><?php echo $basic_info[$i]['key_title']; ?></span>
                                                        <span
                                                            class="profile-info-right">: <?php echo $basic_info[$i]['key_value']; ?></span>
                                                    </div>
                                                <?php
                                                endif;
                                            endfor;
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-content">
                                <div class="profile-icon">
                                    <?php
                                    $teacher_rate = get_post_meta(get_the_ID(), 'iw_teacher_rate', true);
                                    if ($teacher_rate):
                                        ?>

                                        <div class="rating">
                                            <?php
                                            for ($i = 0; $i < $teacher_rate; $i++) {
                                                echo '<span style="padding: 0 2px;"><i class="fa fa-star"></i></span>';
                                            }
                                            ?>
                                        </div>

                                        <?php
                                    endif;
                                    ?>
                                </div>
                                <div class="profile-text">
                                    <p>
                                        <?php the_content(); ?>
                                    </p>
                                        <div class="share">
                                            <div class="share-title">
                                                <h5><?php echo __('Share This profile', 'inwavethemes'); ?></h5>
                                            </div>
                                            <div class="social-icon">
                                                <?php getSocialSharing(get_permalink(), $utility->truncateString(get_the_excerpt(), 10), get_the_title());?>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                        <!--  Training Experience -->
                        <div class="content-pages">
                            <section class="experience">
                                <div class="experience-content">
                                    <div class="experience-title">
                                        <h5><?php echo __('Training Experience', 'inwavethemes'); ?></h5>
                                    </div>
                                    <?php
                                    $training_xperience_data = get_post_meta(get_the_ID(), 'iw_teacher_training_experience', true);
                                    $training_xperience = unserialize($training_xperience_data);
                                    if ($training_xperience):
                                        for ($i = 0; $i < count($training_xperience); $i++):
                                            if ($i == 0):
                                                ?>
                                                <div data-active-first="yes"
                                                     class="experience-main experience-main-plus">
                                                    <div class="experience-spoiler experience-spoiler-opened">
                                                        <div class="experience-details-title">
                                                            <i class="fa fa-plus"></i>
                                                            <?php echo $training_xperience[$i]['key_title']; ?>
                                                            <span class="experience-details-collapse"></span>
                                                        </div>
                                                        <div class="experience-details-content"
                                                             style="display: block;"><?php echo $training_xperience[$i]['key_value']; ?> </div>
                                                    </div>
                                                </div>
                                                <?php
                                            else:
                                                ?>
                                                <div class="experience-main experience-main-plus">
                                                    <div class="experience-spoiler">
                                                        <div class="experience-details-title">
                                                            <i class="fa fa-plus"></i>
                                                            <?php echo $training_xperience[$i]['key_title']; ?>
                                                            <span class="experience-details-collapse"></span>
                                                        </div>
                                                        <div class="experience-details-content"
                                                             style="display: none;"><?php echo $training_xperience[$i]['key_value']; ?></div>
                                                    </div>
                                                </div>
                                            <?php
                                            endif;
                                        endfor;
                                    endif;
                                    ?>
                                </div>

                            </section>
                        </div>
                        <!-- End Training Experience -->
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">
                        <section class="experience skills">
                            <div class="experience-content">
                                <div class="experience-title">
                                    <h5><?php echo __('Training Skills', 'inwavethemes'); ?></h5>
                                </div>
                                <ul class="counted">
                                    <?php
                                    $training_skills_data = get_post_meta(get_the_ID(), 'iw_teacher_training_skills', true);
                                    $training_skills = unserialize($training_skills_data);
                                    if ($training_skills):
                                        for ($i = 0; $i < count($training_skills); $i++):
                                            if ($i == 0):
                                                ?>
                                                <li class="skill skill-top">
                                                    <span
                                                        class="skill-title"><?php echo $training_skills[$i]['key_title']; ?></span>
                                                    <span
                                                        class="skill-percent skill-percent-callout"><?php echo $training_skills[$i]['key_value']; ?>
                                                        %</span>

                                                    <div class="progress-indicator"
                                                         data-value="<?php echo $training_skills[$i]['key_value']; ?>">
                                                        <div class="bg-red"
                                                             style="width: <?php echo $training_skills[$i]['key_value']; ?>%;"></div>
                                                    </div>
                                                </li>
                                            <?php else: ?>
                                                <li class="skill">
                                                    <span
                                                        class="skill-title"><?php echo $training_skills[$i]['key_title']; ?></span>
                                                    <span
                                                        class="skill-percent skill-percent-callout"><?php echo $training_skills[$i]['key_value']; ?>
                                                        %</span>

                                                    <div class="progress-indicator"
                                                         data-value="<?php echo $training_skills[$i]['key_value']; ?>">
                                                        <div class="bg-red"
                                                             style="width: <?php echo $training_skills[$i]['key_value']; ?>%;"></div>
                                                    </div>
                                                </li>
                                            <?php
                                            endif;
                                        endfor;
                                    endif;
                                    ?>
                                </ul>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <!--End Profile Details-->
            <!--Meet Trainer-->
            <?php
            global $wpdb;
            $rand_teachers = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'posts WHERE post_type="iw_teacher" AND post_status="publish" AND ID != %d ORDER BY RAND() LIMIT 3', get_the_ID()));
            if (!empty($rand_teachers)):
                ?>
                <section class="meet-trainer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title-page">
                                <h3><?php echo __('Meet Other Trainers', 'inwavethemes'); ?></h3>

                                <p><?php echo __('Working from home meant we could vary snack and coffee breaks, change our desks or view, goof off, drink on the job, even spend the day in pajamas', 'inwavethemes'); ?></p>
                            </div>
                            <section class="our-trainers" id="our-trainers">
                                <div class="row">
                                    <?php
                                    foreach ($rand_teachers as $teacher):
                                        $permalink = get_permalink($teacher->ID);
                                        ?>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="product-image-wrapper">
                                                <div class="product-content">
                                                    <div class="product-image">
                                                        <?php
                                                        $image_gallery_data = get_post_meta($teacher->ID, 'iw_teacher_image_gallery', true);
                                                        $image_gallery = unserialize($image_gallery_data);
                                                        if ($image_gallery):
                                                            $image = site_url() . $image_gallery[0];
                                                            echo '<a href="' . $permalink . '"><img alt="" src="' . $image . '"></a>';
                                                        endif;
                                                        ?>
                                                    </div>
                                                    <div class="info-products">
                                                        <div class="img-trainers">
                                                            <img alt="" src="<?php echo esc_url(get_template_directory_uri()); ?>/iw_courses/assets/images/boxing-icon-1.png">
                                                        </div>
                                                        <div class="product-name">
                                                            <a href="<?php echo $permalink; ?>"><?php echo $teacher->post_title; ?></a>

                                                            <div class="product-bottom"></div>
                                                        </div>
                                                        <div class="product-info">
                                                            <?php echo $teacher->post_content; ?>
                                                        </div>
                                                        <div class="actions">
                                                            <?php
                                                            $social_link_data = get_post_meta($teacher->ID, 'iw_teacher_social_link', true);
                                                            $social_link = unserialize($social_link_data);
                                                            if ($social_link) {
                                                                echo '<ul>';
                                                                foreach ($social_link as $link) {
                                                                    if ($link['key_value']) {
                                                                        echo '<li><a target="_blank" href="' . $link['key_value'] . '"><i class="fa fa-' . $link['key_title'] . '"></i></a></li>';
                                                                    }
                                                                }
                                                                echo '</ul>';
                                                            }
                                                            ?>
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
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            <!--End Meet Trainer-->
        </div>
    </div>
    <!-- Main Content -->
</div>
<?php
get_footer();
