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
 * Description of athlete_map
 *
 * @Developer duongca
 */
if (!class_exists('Athlete_Map')) {

    class Athlete_Map {

        function __construct() {
            add_action('admin_init', array($this, 'heading_init'));
            add_action('wp_enqueue_scripts', array($this, 'athlete_map_scripts'));
            add_shortcode('athlete_map', array($this, 'athlete_map_shortcode'));
        }

        function heading_init() {

            // Add banner addon
            vc_map(array(
                'name' => 'Map',
                'description' => __('Display a Google Map', 'gmswebdesign'),
                'base' => 'athlete_map',
                // 'icon' => 'icon-wpb-gmswebdesign',
                'category' => 'gmswebdesign',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "gmswebdesign"),
                        "value" => "Map",
                        "param_name" => "title",
                        "description" => __('Title of map block.', "gmswebdesign")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Latitude", "gmswebdesign"),
                        "param_name" => "latitude",
                        "value" => "40.6700",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Longitude", "gmswebdesign"),
                        "param_name" => "longitude",
                        "value" => "-73.9400",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Zoom", "gmswebdesign"),
                        "param_name" => "zoom",
                        "value" => "11",
                    ),
                    array(
                        "type" => "textfield",
                        "group" => "Marker",
                        "heading" => __("Title", "gmswebdesign"),
                        "param_name" => "marker_title",
                    ),
                    array(
                        "type" => "attach_image",
                        "group" => "Marker",
                        "heading" => __("Image", "gmswebdesign"),
                        "param_name" => "marker_image",
                    ),
                    array(
                        "type" => "textarea",
                        "group" => "Marker",
                        "heading" => __("Info", "gmswebdesign"),
                        "param_name" => "info",
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

        function athlete_map_scripts() {
            $theme_info = wp_get_theme();
            wp_enqueue_script('athlete-map-script', get_template_directory_uri() . '/js/athlete_map.js', array(), $theme_info->get('Version'), true);
            wp_deregister_script('evcal_gmaps');
            wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?sensor=false', array(), $theme_info->get('Version'), true);
        }

        // Shortcode handler function for list Icon
        function athlete_map_shortcode($atts, $content = null) {
            extract(shortcode_atts(array(
                'title' => '',
                'latitude' => '40.6700',
                'longitude' => '-73.9400',
                'marker_title' => 'gmswebdesign',
                'marker_image' => '',
                'zoom' => '11',
                'info' => '',
                'class' => ''
                            ), $atts));
            $img = wp_get_attachment_image_src($marker_image, 'large');
            if(count($img)){
				$img = $img[0];
			}else{
				$img = $marker_image;
			}
            $html = '';
            $html = '<div class="contact-map ' . $class . '">';
            $html .= '<div class="map-contain" data-title="'.$marker_title.'" data-image="'.$img.'" data-lat="'.$latitude.'" data-long="'.$longitude.'" data-zoom="'.$zoom.'" data-info="'.$info.'"><div class="map-view map-frame"></div></div>';
            $html .= '<script type="text/javascript">';
            $html .= 'jQuery(document).ready(function(){';
            $html .= 'jQuery("'.($class ? '.'.$class.' ':'').'.map-contain").iwMap();';
            $html .= '});';
            $html .= '</script>';
            $html .='</div>';
            return $html;
        }

    }

}

new Athlete_Map();
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Athlete_Map extends WPBakeryShortCode {
        
    }

}