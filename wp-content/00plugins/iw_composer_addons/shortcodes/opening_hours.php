<?php

/*
 * @package Inwave Athlete
 * @version 1.0.0
 * @created Mar 27, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of opening_hours
 *
 * @Developer duongca
 */
if (!class_exists('Inwave_Opening_Hours')) {

    class Inwave_Opening_Hours {

        private $style = '';

        function __construct() {
           
            // action init
            add_action('admin_init', array($this, 'opening_hours_init'));

            // action shortcode
            add_shortcode('inwave_opening_hours', array($this, 'inwave_opening_hours_shortcode'));
            add_shortcode('inwave_opening_hours_item', array($this, 'inwave_opening_hours_item_shortcode'));
        }

        /** define params */
        function opening_hours_init() {

            // Add infor list
            vc_map(
                    array(
                        "name" => __("Opening Hours",'inwavethemes'),
                        "base" => "inwave_opening_hours",
                        "content_element" => true,
                        'category' => 'InwaveThemes',
                        "description" => __("Add a set of list opening hours and give some custom style.", "inwavethemes"),
                        "as_parent" => array('only' => 'inwave_opening_hours_item'),
                        "show_settings_on_create" => true,
                        "js_view" => 'VcColumnView',
                        "params" => array(
                            array(
                                'type' => 'attach_image',
                                "heading" => __("Banner Image", "inwavethemes"),
                                "param_name" => "img"
                            ),
                            array(
                                'type' => 'textfield',
                                "holder" => "div",
                                "heading" => __("Title", "inwavethemes"),
                                "value" => "This is title",
                                "param_name" => "title"
                            ),
                            array(
                                'type' => 'textfield',
                                "heading" => __("Sub Title", "inwavethemes"),
                                "value" => "",
                                "param_name" => "sub_title"
                            ),
                            array(
                                "type" => "textarea",
                                "heading" => "Description",
                                "param_name" => "description",
                                "value" => "Lorem ipsum dolor sit amet, consectetur adi sollicitudin"
                            ),
                            array(
                                "type" => "textfield",
                                "class" => "",
                                "heading" => __("Extra Class", "inwavethemes"),
                                "param_name" => "class",
                                "value" => "",
                                "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                            )
                        )
                    )
            );
            // Add infor list
            vc_map(
                    array(
                        "name" => __("List Opening Item",'inwavethemes'),
                        "base" => "inwave_opening_hours_item",
                        "class" => "inwave_opening_hours_item",
                        "icon" => "inwave_opening_hours_item",
                        'category' => 'InwaveThemes',
                        "description" => __("Add a list of infor with some content and give some custom style.", "inwavethemes"),
                        "as_child" => array('only' => 'inwave_opening_hours'),
                        "show_settings_on_create" => true,
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                "holder" => "div",
                                "heading" => __("Title", "inwavethemes"),
                                "value" => "This is title",
                                "param_name" => "title"
                            ),
                            array(
                                "type" => "textarea",
                                "heading" => "Duration",
                                "param_name" => "duration",
                                "value" => "8 A.M - 8 P.M"
                            ),
                            array(
                                "type" => "textfield",
                                "class" => "",
                                "heading" => __("Extra Class", "inwavethemes"),
                                "param_name" => "class",
                                "value" => "",
                                "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                            ),
                        )
                    )
            );
        }

        // Shortcode handler function for list
        function inwave_opening_hours_shortcode($atts, $content = null) {
            $output = $class = $style = '';
            extract(shortcode_atts(array(
                "class" => "",
                "title" => "",
                "sub_title" => "",
                "img" => "",
                "description" => ""
                            ), $atts));
            $img = wp_get_attachment_image_src($img, 'large');
            $img = $img[0];
            $output .= '<div class="'.$class.' container">';
            $output .= '<div class="row">';
            $output .= '<div class="col-md-6 col-sm-12 col-xs-12">';
            $output .= '<div class="fit-strong-right">';
            $output .= '<div class="img-box-right" id="boxOpenTime">';
            $output .= '<img class="img-box" src="' . $img . '" alt=""/>';
            $output .= '<div class="open-hour">';
            $output .= '<i class="fa fa fa-clock-o"></i>';
            $output .= '<div class="open-hours-title">';
            $output .= '<h4>' . $title . '</h4>';
            $output .= '<p>' . $sub_title . '</p>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '<div class="img-box-right-border"></div>';
            $output .= '</div>';
            $output .= '<div class="bottomright"></div>';
            $output .= '<div class="text-box">';
            $output .= $description;
            $output .= do_shortcode($content);
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            return $output;
        }

        // Shortcode handler function for item
        function inwave_opening_hours_item_shortcode($atts, $content = null) {

            $output = $title = $duration = $class = '';
            extract(shortcode_atts(array(
                'title' => '',
                'duration' => '',
                'class' => ''
                            ), $atts));

            $output.='<div class="'.$class.'">';
            $output.='<h5>'.$title.'</h5>';
            $output.='<span class="open-hours">'.$duration.'</span>';
            $output.='</div>';
            return $output;
        }

    }

}

new Inwave_Opening_Hours;
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_Inwave_Opening_Hours extends WPBakeryShortCodesContainer {
        
    }

}