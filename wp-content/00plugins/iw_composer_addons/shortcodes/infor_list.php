<?php
/*
* Inwave_Infor_List for Visual Composer
*/
if (!class_exists('Inwave_Infor_List')) {
    class Inwave_Infor_List
    {
        private $style = '';

        function __construct()
        {
           
            // action init
            add_action('admin_init', array($this, 'infor_list_init'));

            // action shortcode
            add_shortcode('inwave_infor_list', array($this, 'inwave_infor_list_shortcode'));
            add_shortcode('inwave_infor_list_item', array($this, 'inwave_infor_list_item_shortcode'));
        }

        /** define params */
        function infor_list_init()
        {

            // Add infor list
            vc_map(
                array(
                    "name" => __("Info List",'inwavethemes'),
                    "base" => "inwave_infor_list",
                    "content_element" => true,
                    'category' => 'InwaveThemes',
                    "description" => __("Add a set of list info and give some custom style.", "inwavethemes"),
                    "as_parent" => array('only' => 'inwave_infor_list_item'),
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
                        array(
                            "type" => "dropdown",
                            "group" => "Style",
                            "class" => "",
                            "heading" => "Style",
                            "param_name" => "style",
                            "value" => array(
                                "Style 1" => "style1",
                                "Style 2" => "style2",
                                "Style 3" => "style3"
                            )
                        )
                    )
                )
            );
            // Add infor list
            vc_map(
                array(
                    "name" => __("Info Item",'inwavethemes'),
                    "base" => "inwave_infor_list_item",
                    "class" => "inwave_infor_list_item",
                    "icon" => "inwave_infor_list_item",
                    'category' => 'InwaveThemes',
                    "description" => __("Add a list of info with some content and give some custom style.", "inwavethemes"),
                    "as_child" => array('only' => 'inwave_infor_list'),
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
                            "heading" => "Description",
                            "param_name" => "description",
                            "value" => "Lorem ipsum dolor sit amet, consectetur adi sollicitudin"
                        ),
						array(
                            "type" => "iwicon",
                            "class" => "",
                            "heading" => __("Select Icon", "inwavethemes"),
                            "param_name" => "icon",
                            "value" => "",
                            "admin_label" => true,
                        ),
						array(
                        "type" => "textfield",
                        "heading" => __("Link", "inwavethemes"),
                        "param_name" => "link"
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
        function inwave_infor_list_shortcode($atts, $content = null)
        {
            $class = $style = '';
            extract(shortcode_atts(array(
                "class" => "",
                "style" => "style1"

            ), $atts));
            $this->style = $style;
            switch ($this->style) {
                case 'style1':
                case 'style2':
                    $output = '<div class="infor-list ' . $class . '">';
                    $output .= do_shortcode($content);
                    $output .= '</div>';
                    break;
                case 'style3':
                    $output = '<ul class="headding-content ' . $class . '">';
                    $output .= do_shortcode($content);
                    $output .= '</ul>';
                    break;
            }
            return $output;
        }

        // Shortcode handler function for item
        function inwave_infor_list_item_shortcode($atts, $content = null)
        {

            $output = $icon = $title = $description = $class = '';
            extract(shortcode_atts(array(
                'icon' => '',
                'title' => '',
                'link' => '',
                'description' => '',
                'class' => ''
            ), $atts));

            switch ($this->style) {
                case 'style1':
                    $output .= '<div class="infor-item ' . $class . '">';
                    if ($icon) {
						if($link){
							$output .= '<div class="icon"><a href="' . $link . '"><i class="fa fa-' .  $icon . '"></i></a></div>';
						}else{
							$output .= '<div class="icon"><i class="fa fa-' .  $icon . '"></i></div>';
						}
                    }
                    $output .= '<div class="infor-item-content">';
                    if ($title) {
						if($link){
							$output .= '<h4 class="infor-item-title"><a href="' . $link . '">' . $title . '</a></h4>';
						}else{
							$output .= '<h4 class="infor-item-title">' . $title . '</h4>';
						}
                    }
                    $output .= '<p>' . $description . '</p>';
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
                case 'style2':
                    $output .= '<div class="about-info ' . $class . '">';
                    if ($icon) {
						if($link){
							$output .= '<div class="icon-block"><a href="' . $link . '"><i class="fa fa-' .  $icon . '"></i></a></div>';
						}else{
							$output .= '<div class="icon-block"><i class="fa fa-' .  $icon . '"></i></div>';
						}
                    }
                    $output .= '<div class="about-details">';
                    if ($title) {
						if($link){
							$output .= '<h4 class="about-details-title"><a href="' . $link . '">' . $title . '</a></h4>';
						}else{
							$output .= '<h4 class="about-details-title">' . $title . '</h4>';
						}
                    }
                    $output .= '<p>' . $description . '</p>';
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
                case 'style3':
                    $output .= '<li class="' . $class . '">';
                    if ($icon) {
						if($link){
							$output .= '<div class="icon-headding"><a href="' . $link . '"><i class="fa fa-' .  $icon . '"></i></a></div>';
						}else{
							$output .= '<div class="icon-headding"><i class="fa fa-' .  $icon . '"></i></div>';
						}
                    }
                    $output .= '<div class="cont-headding">';
                    if ($title) {
						if($link){
							$output .= '<h5><a href="' . $link . '">' . $title . '</a></h5>';
						}else{
							$output .= '<h5>' . $title . '</h5>';
						}
                    }
                    $output .= '<p>' . $description . '</p>';
                    $output .= '</div>';
                    $output .= '</li>';
                    break;
            }
            return $output;
        }
    }
}

new Inwave_Infor_List;
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Infor_List extends WPBakeryShortCodesContainer
    {
    }
}
