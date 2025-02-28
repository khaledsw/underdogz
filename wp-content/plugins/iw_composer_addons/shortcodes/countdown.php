<?php
/*
* Inwave_Heading for Visual Composer
*/
if (!class_exists('Inwave_Countdown')) {
    class Inwave_Countdown
    {
        function __construct()
        {
          
            add_action('admin_init', array($this, 'heading_init'));
            add_shortcode('inwave_countdown', array($this, 'inwave_countdown_shortcode'));
            add_action('wp_enqueue_scripts', array($this, 'add_scripts'));
        }
        function add_scripts(){
            $theme_info = wp_get_theme();
            wp_enqueue_script('cdtime', get_template_directory_uri() . '/js/cdtime.js', array(), $theme_info->get('Version'), true);
        }

        function heading_init()
        {

            // Add banner addon
            vc_map(array(
                'name' => 'Countdown timer',
                'description' => __('Schedule a countdown until a time in the future', 'gmswebdesign'),
                'base' => 'inwave_countdown',
                // 'icon' => 'icon-wpb-gmswebdesign',
                'category' => 'gmswebdesign',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Time to end:", "gmswebdesign"),
						'description' => __('Example: February 24, 2017 00:00:00', 'gmswebdesign'),
                        "value" => "February 24, 2016",
                        "param_name" => "end_date"
                    ),
					array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Format day:", "gmswebdesign"),
						'description' => __('Example: % Days'),
                        "value" => "% Days",
                        "param_name" => "format_day"
                    ),
					array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Format hour:", "gmswebdesign"),
						'description' => __('Example: % Hours'),
                        "value" => "% Hours",
                        "param_name" => "format_hour"
                    ),
					array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Format minute:", "gmswebdesign"),
						'description' => __('Example: % Mins'),
                        "value" => "% Mins",
                        "param_name" => "format_minute"
                    ),
					array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Format second:", "gmswebdesign"),
						'description' => __('Example: % Secs'),
                        "value" => "% Secs",
                        "param_name" => "format_second"
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
        function inwave_countdown_shortcode($atts, $content = null)
        {
            $output = $end_date =  $class = '';
            extract(shortcode_atts(array(
                'end_date'        => '',
                'format_day'        => '% Days',
                'format_hour'        => '% Hours',
                'format_minute'        => '% Mins',
                'format_second'        => '% Secs',
                'class' => ''
            ), $atts));

            $output .= '<span class="defaultCountdown '.$class.'"'
					.' data-fday="'.esc_attr($format_day).'"'
					.' data-fhour="'.esc_attr($format_hour).'"'
					.' data-fmin="'.esc_attr($format_minute).'"'
					.' data-fsec="'.esc_attr($format_second).'"'
					.' data-enddate="'.esc_attr($end_date).'">';
            $output .= '</span>';
            return $output;
        }
    }
}

new Inwave_Countdown;
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_Inwave_Countdown extends WPBakeryShortCode
    {
    }
}