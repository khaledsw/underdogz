<?php
/*
* Inwave_Heading for Visual Composer
*/
if (!class_exists('Inwave_Heading')) {
    class Inwave_Heading
    {
        function __construct()
        {
           
            add_action('admin_init', array($this, 'heading_init'));
            add_shortcode('inwave_heading', array($this, 'inwave_heading_shortcode'));
        }

        function heading_init()
        {

            // Add banner addon
            vc_map(array(
                'name' => 'Heading',
                'description' => __('Add a heading', 'gmswebdesign'),
                'base' => 'inwave_heading',
                // 'icon' => 'icon-wpb-gmswebdesign',
                'category' => 'gmswebdesign',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "span",
                        "heading" => __("Title", "gmswebdesign"),
                        "value" => "This is title",
                        "param_name" => "title"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "span",
                        "heading" => __("Sub Title", "gmswebdesign"),
                        "value" => "",
                        "param_name" => "sub_title"
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => __("Heading type", "gmswebdesign"),
                        "param_name" => "heading_type",
                        "value" => array(
                            "default" => "",
                            "h1" => "h1",
                            "h2" => "h2",
                            "h3" => "h3",
                            "h4" => "h4",
                            "h5" => "h5",
                            "h6" => "h6",
                        ),
                        "description" => __("Select heading type.", "gmswebdesign")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "gmswebdesign"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "gmswebdesign")
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Normal heading" => "style1",
                            "Style 2 - Our pricing" => "style2",
                            "Style 3 - Pricing plan" => "style3",
                            "Style 4 - Contact Us" => "style4"
                        )
                    ),
                )
            ));
        }
        // Shortcode handler function for list Icon
        function inwave_heading_shortcode($atts, $content = null)
        {
            $output = $title = $sub_title = $heading_type = $class = $style = '';
            extract(shortcode_atts(array(
                'title'        => '',
                'sub_title'        => '',
                'heading_type'        => 'h3',
                'style'        => 'style1',
                'class' => ''
            ), $atts));

            switch($style){
                // Normal style
                case 'style1':
                    $output .= '<div class="title-page '.$class.'">';
                    $output .= '<'.$heading_type.'>'.$title.'</'.$heading_type.'>';
                    if($sub_title) {
                        $output .= '<p>'.$sub_title.'</p>';
                    }
                    $output .= '</div>';
                    break;

                // Our pricing heading style
                case 'style2':
                    $output .= '<div class="our-pricing-title '.$class.'"><div class="ch-item"><div class="ch-info-wrap"><div class="ch-info">';

                    $output .= '<div class="ch-info-front">';
                    $output .= '<'.$heading_type.'>'.$title.'</'.$heading_type.'>';
                    $output .= '<h3>'.$sub_title.'</h3>';
                    $output .= '</div>';

                    $output .= '<div class="ch-info-back">';
                    $output .= '<'.$heading_type.'>'.$title.'</'.$heading_type.'>';
                    $output .= '<h3>'.$sub_title.'</h3>';
                    $output .= '</div>';

                    $output .= '</div></div></div></div>';

                    break;
                case 'style3':
                    $output .= '<div class="price-table-title '.$class.'">';
                    $output .= '<h3>'.$sub_title.'</h3>';
                    $output .= '<'.$heading_type.'>'.$title.'</'.$heading_type.'>';
                    $output .= '</div>';
                    break;
                case 'style4':
                    $output .= '<div class="headding-title '.$class.'">';
                    $output .= '<'.$heading_type.'>'.$title.'</'.$heading_type.'>';
                    $output .= '<div class="headding-bottom"></div>';
                    $output .= '</div>';
                    break;
            }


            return $output;
        }
    }
}

new Inwave_Heading;
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_Inwave_Heading extends WPBakeryShortCode
    {
    }
}