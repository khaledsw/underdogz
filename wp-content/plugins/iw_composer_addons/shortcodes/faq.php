<?php
/*
* Inwave_Heading for Visual Composer
*/
if (!class_exists('Inwave_Faq')) {
    class Inwave_Faq
    {
        function __construct()
        {
          
            add_action('admin_init', array($this, 'heading_init'));
            add_shortcode('inwave_faq', array($this, 'inwave_faq_shortcode'));
        }

        function heading_init()
        {

            // Add banner addon
            vc_map(array(
                'name' => 'FAQ',
                'description' => __('Frequently asked question', 'gmswebdesign'),
                'base' => 'inwave_faq',
                // 'icon' => 'icon-wpb-gmswebdesign',
                'category' => 'gmswebdesign',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Question", "gmswebdesign"),
                        "value" => "This is question",
                        "param_name" => "question"
                    ),
                    array(
                        'type' => 'textarea',
                        "heading" => __("Answer", "gmswebdesign"),
                        "value" => "This is Answer",
                        "param_name" => "answer"
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
                            "Style 3 - Pricing plan" => "style3"
                        )
                    ),
                )
            ));
        }
        // Shortcode handler function for list Icon
        function inwave_faq_shortcode($atts, $content = null)
        {
            $output = $answer = $question =  $class = '';
            extract(shortcode_atts(array(
                'answer'        => '',
                'question'        => '',
                'class' => ''
            ), $atts));

            $output .= '<div class="ask-question-content '.$class.'">';
            $output .= '<div class="question"><div class="question-content">';
            $output .= '<p>'.$question.'</p>';
            $output .= '</div></div>';
            $output .= '<div class="answer"><div class="answer-content">';
            $output .= '<p>'.$answer.'</p>';
            $output .= '</div></div>';
            $output .= '</div>';
            return $output;
        }
    }
}

new Inwave_Faq;
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_Inwave_Faq extends WPBakeryShortCode
    {
    }
}