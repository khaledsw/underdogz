<?php
/*
 * @package Inwave Athlete
 * @version 1.0.0
 * @created Mar 30, 2015
 * @author gmswebdesign
 * @email gmswebdesign@gmail.com
 * @website http://gmswebdesign.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 gmswebdesign. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of courses_list
 *
 * @Developer duongca
 */
if (!class_exists('Inwave_Courses_List')) {

    class Inwave_Courses_List {

        function __construct() {

            add_action('admin_init', array($this, 'heading_init'));
            add_shortcode('inwave_courses_list', array($this, 'inwave_courses_list_shortcode'));
        }


        function heading_init() {

            // Add banner addon
            vc_map(array(
                'name' => 'Courses List',
                'description' => __('Display a list of courses', 'gmswebdesign'),
                'base' => 'inwave_courses_list',
                'category' => 'gmswebdesign',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "gmswebdesign"),
                        "value" => "",
                        "param_name" => "title",
                        "description" => __('Title of courses_list block.', "gmswebdesign")
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Sub Title", "gmswebdesign"),
                        "param_name" => "sub_title",
                        "description" => __('Sub Title of courses_list block.', "gmswebdesign")
                    ),
                    array(
                        'type' => 'textarea',
                        "holder" => "div",
                        "heading" => __("Description", "gmswebdesign"),
                        "param_name" => "description",
                        "description" => __('Description of courses_list block.', "gmswebdesign")
                    ),
                    array(
                        "type" => "courses_categories",
                        "heading" => __("Post Category", "gmswebdesign"),
                        "param_name" => "category",
                        "value" => '',
                        "multiple" => 'multiple',
                        "description" => __('Category to get courses.', "gmswebdesign")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Post per Page", "gmswebdesign"),
                        "param_name" => "item_per_page",
                        "value" => "5",
                        "description" => __('Number of post to display on per page, then use this field to add a class name and then refer to it in your css file.', "gmswebdesign")
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
        function inwave_courses_list_shortcode($atts, $content = null) {
            extract(shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'description' => '',
                'category' => '0',
                'item_per_page' => '5',
                'class' => ''
                            ), $atts));
            return $this->htmlBoxRender($title, $sub_title, $description, $category, $item_per_page, $class);
        }

        function htmlBoxRender($title, $sub_title, $description, $category, $item_per_page, $class) {
            ob_start();
            ?>
            <div class="classes-content <?php echo $class; ?>">
                <div class="classes-wapper">
                    <div class="title-page">
                        <h3 class="module-title-h3"><?php echo $title; ?></h3>
                        <h4 class="module-title-h4"><?php echo $sub_title; ?></h4>
                        <p><?php echo $description; ?></p>
                    </div>
                </div>

                <?php 
                do_shortcode('[iw_courses_list theme="athlete" cats="' . $category . '" item_per_page="' . $item_per_page . '"]'); ?>
            </div>
            <?php
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

    }

}

new Inwave_Courses_List();
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_Courses_List extends WPBakeryShortCode {
        
    }

}