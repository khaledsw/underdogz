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
 * Description of ethlete_facts
 *
 * @Developer duongca
 */
if (!class_exists('Inwave_Ethlete_Facts')) {

    class Inwave_Ethlete_Facts {

        function __construct() {

            // action init
            add_action('admin_init', array($this, 'ethlete_facts_init'));

            // action shortcode
            add_shortcode('inwave_ethlete_facts', array($this, 'inwave_ethlete_facts_shortcode'));
            add_shortcode('inwave_ethlete_facts_item', array($this, 'inwave_ethlete_facts_item_shortcode'));
        }

        /** define params */
        function ethlete_facts_init() {

            // Add infor list
            vc_map(
                    array(
                        "name" => __("Ethlete Facts",'gmswebdesign'),
                        "base" => "inwave_ethlete_facts",
                        "content_element" => true,
                        'category' => 'gmswebdesign',
                        "description" => __("Add a set of list facts and give some custom style.", "gmswebdesign"),
                        "as_parent" => array('only' => 'inwave_ethlete_facts_item'),
                        "show_settings_on_create" => true,
                        "js_view" => 'VcColumnView',
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                "holder" => "div",
                                "heading" => __("Title", "gmswebdesign"),
                                "value" => "This is title",
                                "param_name" => "title"
                            ),
                            array(
                                'type' => 'textfield',
                                "heading" => __("Sub Title", "gmswebdesign"),
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
                                "heading" => __("Extra Class", "gmswebdesign"),
                                "param_name" => "class",
                                "value" => "",
                                "description" => __("Write your own CSS and mention the class name here.", "gmswebdesign"),
                            )
                        )
                    )
            );
            // Add infor list
            vc_map(
                    array(
                        "name" => __("List Facts Item",'gmswebdesign'),
                        "base" => "inwave_ethlete_facts_item",
                        "class" => "inwave_ethlete_facts_item",
                        "icon" => "inwave_ethlete_facts_item",
                        'category' => 'gmswebdesign',
                        "description" => __("Add a list of infor with some content and give some custom style.", "gmswebdesign"),
                        "as_child" => array('only' => 'inwave_ethlete_facts'),
                        "show_settings_on_create" => true,
                        "params" => array(
                            array(
                                "type" => "iwicon",
                                "class" => "",
                                "heading" => __("Select Icon", "gmswebdesign"),
                                "param_name" => "icon",
                                "value" => "",
                                "admin_label" => true,
                                "description" => __("Click and select icon of your choice.", "gmswebdesign"),
                            ),
                            array(
                                'type' => 'textfield',
                                "heading" => __("Count Number", "gmswebdesign"),
                                "value" => rand(100, 1000),
                                "param_name" => "count_number"
                            ),
                            array(
                                "type" => "textfield",
                                "heading" => "Title",
                                "param_name" => "title",
                                "holder" => "div",
                                "value" => ""
                            ),
                            array(
                                "type" => "textfield",
                                "class" => "",
                                "heading" => __("Extra Class", "gmswebdesign"),
                                "param_name" => "class",
                                "value" => "",
                                "description" => __("Write your own CSS and mention the class name here.", "gmswebdesign"),
                            ),
                        )
                    )
            );
        }

        // Shortcode handler function for list
        function inwave_ethlete_facts_shortcode($atts, $content = null) {
            $output = $class = $style = '';
            extract(shortcode_atts(array(
                "class" => "",
                "title" => "",
                "sub_title" => "",
                "description" => ""
                            ), $atts));


            $output.='<div class="background-overlay"></div>';
            $output.='<div class="container" ' . $class . '>';
            $output.='<div class="row">';
            $output.='<div class="facts-page">';
            $output.='<div class="title-page title-facts">';
            $output.='<h3 class="module-title-h3">' . $title . '</h3>';
            $output.='<p>' . $description . '</p>';
            $output.='</div>';
            $output.=do_shortcode($content);
            $output.='</div>';
            $output.='</div>';
            $output.='</div>';
            return $output;
        }

        // Shortcode handler function for item
        function inwave_ethlete_facts_item_shortcode($atts, $content = null) {

            $output = $icon = $title = $count_number = $class = '';
            extract(shortcode_atts(array(
                'title' => '',
                'count_number' => '',
                'icon' => '',
                'class' => ''
                            ), $atts));
            $output .='<div class="col-md-3 col-sm-6 col-xs-12 ' . $class . '">';
            $output .='<div class="facts-content">';
            $output .='<div class="facts-icon"><i class="fa fa-' . $icon . '"></i></div>';
            $output .='<div class="count">';
            $output .='<span>' . intval($count_number) . '</span>';
            $output .='<div class="facts-border"></div>';
            $output .='</div>';
            $output .='<p class="facts-text">' . $title . '</p>';
            $output .='</div>';
            $output .='</div>';
            return $output;
        }

    }

}

new Inwave_Ethlete_Facts;
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_Inwave_Ethlete_Facts extends WPBakeryShortCodesContainer {
        
    }

}