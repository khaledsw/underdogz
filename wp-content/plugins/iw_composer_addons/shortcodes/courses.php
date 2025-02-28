<?php
/*
 * @package Courses Manager
 * @version 1.0.0
 * @created Mar 25, 2015
 * @author gmswebdesign
 * @email gmswebdesign@gmail.com
 * @website http://gmswebdesign.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 gmswebdesign. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of courses
 *
 * @developer duongca
 */

if (!class_exists('Inwave_Courses')) {

    class Inwave_Courses {

        function __construct() {
            add_action('admin_init', array($this, 'heading_init'));
            add_shortcode('inwave_courses', array($this, 'inwave_courses_shortcode'));
        }

        function heading_init() {

            // Add banner addon
            vc_map(array(
                'name' => 'Latest Courses',
                'description' => __('Show latest courses', 'gmswebdesign'),
                'base' => 'inwave_courses',
                // 'icon' => 'icon-wpb-gmswebdesign',
                'category' => 'gmswebdesign',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "gmswebdesign"),
                        "value" => "Athlete online",
                        "param_name" => "title",
                        "description" => __('Title of courses block.', "gmswebdesign")
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Sub Title", "gmswebdesign"),
                        "value" => "",
                        "param_name" => "sub_title",
                        "description" => __('Sub Title of courses block.', "gmswebdesign")
                    ),
                    array(
                        'type' => 'textarea',
                        "holder" => "div",
                        "heading" => __("Description", "gmswebdesign"),
                        "value" => "",
                        "param_name" => "description",
                        "description" => __('Description of courses block.', "gmswebdesign")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Number of Courses", "gmswebdesign"),
                        "param_name" => "courses_count",
                        "value" => "2",
                        "description" => __('Number of courses to display on list.', "gmswebdesign")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "gmswebdesign"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "gmswebdesign")
                    )
                )
            ));
        }

        // Shortcode handler function for list Icon
        function inwave_courses_shortcode($atts, $content = null) {
            $output = $answer = $question = $class = '';
            extract(shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'description' => '',
                'courses_count' => 2,
                'class' => ''
                            ), $atts));
            return $this->htmlBoxCoursesRender($title, $sub_title, $description, $courses_count, $class);
        }

        function htmlBoxCoursesRender($title, $sub_title, $description, $courses_count, $class) {
            $utility = new iwcUtility();
            $args = array();
            $args['post_type'] = 'iw_courses';
            $args['post_status'] = 'publish';
            $args['posts_per_page'] = $courses_count;
            $args['order'] = 'DESC';
            $args['orderby'] = 'post_date';
            $query = new WP_Query($args);
            ob_start();
            ?>
            <div class="iw-courses <?php echo $class; ?>">
                <div class="container">
                    <div class="row">							
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="news-cont">
                                <div class="title-page">
                                    <h4><?php echo $sub_title; ?></h4>
                                    <h3><?php echo $title; ?></h3>									
                                </div>
                                <p class="news-text"><?php echo $description; ?></p>
                                <?php
                                if ($query->posts):
                                    foreach ($query->posts as $post):
                                        $img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
                                        $p_title = $post->post_title;
                                        $p_des = $utility->truncateString($post->post_content, 12);
                                        $p_link = get_permalink($post->ID);
                                        $terms = wp_get_post_terms($post->ID, 'iw_courses_class');
                                        if ($terms) {
                                            $cat_name = $terms[0]->name;
                                            $t_link = get_term_link($terms[0],'iw_courses_class');
                                        }
                                        ?>
                                        <div class="news-wapper">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <div class="img-news">
                                                    <img alt="" src="<?php echo $img[0]; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <div class="details-news">
                                                    <?php echo $cat_name ? '<a href="'.$t_link.'"><h6>' . $cat_name . '</h6></a>' : ''; ?>
                                                    <a href="<?php echo $p_link; ?>"><?php echo $p_title; ?></a>
                                                    <p><?php echo $p_des; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

    }

}

new Inwave_Courses();
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_Courses extends WPBakeryShortCode {
        
    }

}
