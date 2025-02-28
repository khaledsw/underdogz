<?php
/*
* Inwave_Navigation for Visual Composer
*/
if (!class_exists('Inwave_Navigation')) {
    class Inwave_Navigation
    {
        function __construct()
        {
           
            // action init
            add_action('admin_init', array($this, 'navigation_init'));

            // action shortcode
            add_shortcode('inwave_navigation', array($this, 'inwave_navigation_shortcode'));
            add_shortcode('inwave_navigation_item', array($this, 'inwave_navigation_item_shortcode'));
        }

        /** define params */
        function navigation_init()
        {

            // Add infor list
            vc_map(
                array(
                    "name" => __("Navigation",'inwavethemes'),
                    "base" => "inwave_navigation",
                    "content_element" => true,
                    'category' => 'InwaveThemes',
                    "description" => __("Add a menu and give some custom style.", "inwavethemes"),
                    "as_parent" => array('only' => 'inwave_navigation_item'),
                    "show_settings_on_create" => true,
                    "js_view" => 'VcColumnView',
                    "params" => array(
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
            // Add infor list
            vc_map(
                array(
                    "name" => __("Navigation Item",'inwavethemes'),
                    "base" => "inwave_navigation_item",
                    "class" => "inwave_navigation_item",
                    "icon" => "inwave_navigation_item",
                    'category' => 'InwaveThemes',
                    "description" => __("Add a item for inwave navigation and give some custom style.", "inwavethemes"),
                     "as_child" => array('only' => 'inwave_navigation'),
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
                            "type" => "textfield",
                            "heading" => "href",
                            "param_name" => "href",
                            "value" => "#"
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
        function inwave_navigation_shortcode($atts,$content = null)
        {
            $class = '';
            extract(shortcode_atts(array(
                "class" => ""
            ),$atts));
            $output = '<div class="navbar-custom navbar '.$class.'">';
            $output .= '<div class="container"><div class="row"><div class="nav-container">';
            $output .= '<nav class="collapse navbar-collapse navbar-main-collapse mainnav" role="navigation">';
            $output .= '<ul class="nav-menu nav navbar-nav">';
            $output .= do_shortcode($content);
            $output .= '</ul></nav></div></div></div></div>';
            return $output;
        }

        // Shortcode handler function for item
        function inwave_navigation_item_shortcode($atts, $content = null)
        {
            $output = $title = $href = $class = '';
            extract(shortcode_atts(array(
                'title'        => '',
                'href'        => '',
                'class' => ''
            ), $atts));
            if($class){
                $class= 'class="'.$class.'"';
            }
            $output .= '<li '.$class.' ><a href="'.$href.'">'.$title.'</a></li>';

            return $output;
        }

    }
}

new Inwave_Navigation;
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Navigation extends WPBakeryShortCodesContainer
    {
    }
}
