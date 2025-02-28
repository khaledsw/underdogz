<?php
/*
* Inwave_Tabs for Visual Composer
*/
if (!class_exists('Inwave_Tabs')) {
    class Inwave_Tabs
    {
        function __construct()
        {
           
            // action init
            add_action('admin_init', array($this, 'tabs_init'));

            // action shortcode
            add_shortcode('inwave_tabs', array($this, 'inwave_tabs_shortcode'));
            add_shortcode('inwave_tab_item', array($this, 'inwave_tab_item_shortcode'));
        }

        /** define params */
        function tabs_init()
        {

            // Add infor list
            vc_map(
                array(
                    "name" => __("Tabs",'inwavethemes'),
                    "base" => "inwave_tabs",
                    "content_element" => true,
                    'category' => 'InwaveThemes',
                    "description" => __("Add a set of tabs and give some custom style.", "inwavethemes"),
                    "as_parent" => array('only' => 'inwave_tab_item'),
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
                    "name" => __("Tab Item",'inwavethemes'),
                    "base" => "inwave_tab_item",
                    "class" => "inwave_tab_item",
                    "icon" => "inwave_tab_item",
                    'category' => 'InwaveThemes',
                    "description" => __("Add a list of tabs with some content and give some custom style.", "inwavethemes"),
                     "as_child" => array('only' => 'inwave_tabs'),
                    "show_settings_on_create" => true,
                    "params" => array(
                        array(
                            'type' => 'attach_image',
                            "heading" => __("Tab Image", "inwavethemes"),
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
                            "value" => "This is sub title",
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
                        ),
                    )
                )
            );
        }


        // Shortcode handler function for list
        function inwave_tabs_shortcode($atts,$content = null)
        {
            $output = $class = '';
            extract(shortcode_atts(array(
                "class" => ""
            ),$atts));
            $output .= '<div class="our-team-tabs our-team-bottom our-team-fit content-our-team '.$class.'"  data-active="1">';
            $output .= '<div class="our-team-panes">';
            $output .= do_shortcode($content);
            $output .= '</div>';

            $matches = array();
            $count = preg_match_all( '/inwave_tab_item title="([^\"]+)"(\ssub_title\=\"([^\"]+)\"){0,1}/i', $content, $matches );

            $output.= '<div class="our-team-nav">';
            if($count) {
                foreach ($matches[1] as $key => $value){
                    $output.= '<span style="width:'.(100/$count).'%">';
                    $output.= '<span class="our-team-name">'.$matches[3][$key].'</span>';
                    $output.= '<span class="our-team-position">'.$value.'</span>';
                    $output.= '</span>';
                }
            }
            $output .= '</div>';
            $output .= '</div>';
            return $output;
        }

        // Shortcode handler function for item
        function inwave_tab_item_shortcode($atts, $content = null)
        {
            $output = $img = $title = $sub_title = $description = $class = '';
            extract(shortcode_atts(array(
                'img'        => '',
                'title'        => '',
                'sub_title'        => '',
                'description'        => '',
                'class' => ''
            ), $atts));

            $output .= '<div class="our-team-pane our-team-clear '.$class.'">';
            $output .= '<div class="our-team-img col-md-4 col-sm-4 col-xs-12">';
            if($img) {
                $img = wp_get_attachment_image_src($img, 'large');
                $img = $img[0];
                $output .= '<img src="'.$img.'" alt="' . $title . '" />';
            }
            $output .= '</div>';
            $output .= '<div class="detail-our-team col-md-8 col-sm-8 col-xs-12">';
            $output .= '<div class="detail-our-team-inner">';
            $output .= '<div class="detail-our-team-desc">'.$description.'</div>';
            $output .= '<div class="detail-our-team-user">'.$sub_title.'</div>';
            $output .= '<div class="detail-our-team-pos">'.$title.'</div>';
            $output .= '</div>';
            $output .= '</div>';

            $output .= '</div>';

            return $output;
        }

    }
}

new Inwave_Tabs;
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Tabs extends WPBakeryShortCodesContainer
    {
    }
}
