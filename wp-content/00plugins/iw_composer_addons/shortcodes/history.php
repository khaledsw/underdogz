<?php
/*
* Inwave_History for Visual Composer
*/
if (!class_exists('Inwave_History')) {
    class Inwave_History
    {
        function __construct()
        {

            // action init
            add_action('admin_init', array($this, 'history_init'));

            // action shortcode
            add_shortcode('inwave_history', array($this, 'inwave_history_shortcode'));
            add_shortcode('inwave_history_item', array($this, 'inwave_history_item_shortcode'));
        }

        /** define params */
        function history_init()
        {

            // Add infor list
            vc_map(
                array(
                    "name" => __("History",'inwavethemes'),
                    "base" => "inwave_history",
                    "content_element" => true,
                    'category' => 'InwaveThemes',
                    "description" => __("Add a set of history info and give some custom style.", "inwavethemes"),
                    "as_parent" => array('only' => 'inwave_history_item'),
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
                    "name" => __("History Item",'inwavethemes'),
                    "base" => "inwave_history_item",
                    "class" => "inwave_history_item",
                    "icon" => "inwave_history_item",
                    'category' => 'InwaveThemes',
                    "description" => __("Add a item of history with some content and give some custom style.", "inwavethemes"),
                     "as_child" => array('only' => 'inwave_history'),
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
                            'type' => 'textfield',
                            "holder" => "div",
                            "heading" => __("Time point", "inwavethemes"),
                            "value" => "2015",
                            "param_name" => "timepoint"
                        ),
                        array(
                            "type" => "textarea",
                            "heading" => "Description",
                            "param_name" => "description",
                            "value" => "Lorem ipsum dolor sit amet, consectetur adi sollicitudin"
                        ),
                        array(
                            "type" => "textarea",
                            "heading" => "Declare your history",
                            "param_name" => "features",
                            "value" => "Energy Case\nDoctors Timetables\nVaccinations Travel Health\nWomen's Health\nFree Online Consultation\nGeneral Illness or Injury\nPrescription Refills"
                        ),
                        array(
                            'type' => 'textarea_raw_html',
                            "heading" => __("Video/image embed code", "inwavethemes"),
                            "param_name" => "media",
                            "value" => '<iframe width="550" height="400" src="http://www.youtube.com/embed/ptJWKnQmPWI"> </iframe>'
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
        function inwave_history_shortcode($atts,$content = null)
        {
            $class = $output = '';
            extract(shortcode_atts(array(
                "class" => ""
            ),$atts));
            $output .= '<div class="our-team-tabs our-team-bottom our-team-fit tab-history '.$class.'"  data-active="1">';
            $output .= '<div class="our-team-panes">';
            $output .= do_shortcode($content);
            $output .= '</div>';

            $matches = array();
            $count = preg_match_all( '/timepoint="([^\"]+)"/i', $content, $matches );
            $output.= '<div class="our-team-nav">';
            if($count) {
                foreach ($matches[1] as $key => $value){
                    $output.= '<span>'.$value.'</span>';
                }
            }
            $output .= '</div>';
            $output .= '</div>';
            return $output;
        }

        // Shortcode handler function for item
        function inwave_history_item_shortcode($atts, $content = null)
        {
            $output = $media = $title = $timepoint = $features = $description = $class = '';
            extract(shortcode_atts(array(
                'media'        => '',
                'title'        => '',
                'timepoint'        => '',
                'features'        => '',
                'description'        => '',
                'class' => ''
            ), $atts));

            $output .= '<div class="our-team-pane our-team-clear '.$class.'">';
            $output .= '<div class="our-history"><div class="container"><div class="row">';
            if($media) {
                $media = rawurldecode(base64_decode(strip_tags($media)));
                $output .= '<div class="video-history col-md-6 col-sm-12 col-xs-12">';
                $output .= '<div class="media-responsive">'.$media.'</div></div>';
            }
            $output .= '<div class="history-details col-md-6 col-sm-12 col-xs-12">';
            if($title){
                $output .= '<h3>Our history</h3>';
            }
            if($description){
                $output.='<div class="history_desc">'.$description.'</div>';
            }

            if($features){
                $output .= '<div class="history-skill"><ul>';
                $features = explode("<br />",$features);

                foreach($features as $feature){
                    $output.= '<li>'.$feature.'</li>';
                }
                $output.= '</ul></div>';
            }
            $output .= '</div>';

            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';

            return $output;
        }

    }
}

new Inwave_History;
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_History extends WPBakeryShortCodesContainer
    {
    }
}
