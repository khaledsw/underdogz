<?php
/*
* Inwave_Layers_Effect for Visual Composer
*/
if (!class_exists('Inwave_Layers_Effect')) {
    class Inwave_Layers_Effect
    {
        function __construct()
        {
           
            // action init
            add_action('admin_init', array($this, 'layers_effect_init'));

            // action shortcode
            add_shortcode('inwave_layers_effect', array($this, 'inwave_layers_effect_shortcode'));
            add_shortcode('inwave_layer', array($this, 'inwave_layer_shortcode'));
            add_action('wp_enqueue_scripts', array($this, 'add_scripts'));
        }
        function add_scripts(){
            $theme_info = wp_get_theme();
            wp_enqueue_script('scroll-parallax', get_template_directory_uri() . '/js/parallax/scroll.parallax.js', array(), $theme_info->get('Version'), true);
        }

        /** define params */
        function layers_effect_init()
        {

            // Add infor list
            vc_map(
                array(
                    "name" => __("Layers Effect",'gmswebdesign'),
                    "base" => "inwave_layers_effect",
                    "content_element" => true,
                    'category' => 'gmswebdesign',
                    "description" => __("Add a set of layers and give a scene parallax effect.", "gmswebdesign"),
                    "as_parent" => array('only' => 'inwave_layer'),
                    "show_settings_on_create" => true,
                    "js_view" => 'VcColumnView',
                    "params" => array(
                        array(
                            "type" => "dropdown",
                            "heading" => __("Position", "gmswebdesign"),
                            "param_name" => "position",
                            "description" => __("Choose position fix or absolute", 'gmswebdesign'),
                            "value" => array(
                                'Fixed' => 'fixed',
                                'Absolute' => 'absolute'
                            )
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Z-Index", "gmswebdesign"),
                            "param_name" => "zindex",
                            "value" => "-1",
                            "description" => __("Enter integer number number. (-1) value means that the Layers Effect is behind other objects", 'gmswebdesign')
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Height", "gmswebdesign"),
                            "param_name" => "height",
                            "value" => "100%",
                            "description" => __("Height in pixel. Example:500px. Default value is 100%", 'gmswebdesign')
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
                    "name" => __("Layer",'gmswebdesign'),
                    "base" => "inwave_layer",
                    "class" => "inwave_layer",
                    "icon" => "inwave_layer",
                    'category' => 'gmswebdesign',
                    "description" => __("Add a list of layers_effect with some content and give some custom style.", "gmswebdesign"),
                    "as_child" => array('only' => 'inwave_layers_effect'),
                    "show_settings_on_create" => true,
                    "params" => array(
                        array(
                            'type' => 'attach_image',
                            "heading" => __("Layer Background", "gmswebdesign"),
                            "holder" => "div",
                            "param_name" => "img"
                        ),
						array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Data Depth", "gmswebdesign"),
                            "param_name" => "data_depth",
                            "value" => "",
                            "description" => __("Depth of the layer. A depth of 0 will cause the layer to remain stationary, and a depth of 1 will cause the layer to move by the total effect of the calculated motion. Values inbetween 0 and 1 will cause the layer to move by an amount relative to the supplied ratio.", "gmswebdesign"),
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => __("Opacity", "gmswebdesign"),
                            "param_name" => "opacity",
                            "value" => "",
                            "description" => __("Opacity of the layer", "gmswebdesign"),
                        ),
                        array(
                            "type" => "textarea_html",
                            "heading" => "Text",
                            "param_name" => "content"
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
        }


        // Shortcode handler function for list
        function inwave_layers_effect_shortcode($atts,$content = null)
        {
            $output =$height = $zindex = $position = $class = '';
            extract(shortcode_atts(array(
                "class" => "",
                "height" => "100%",
                "zindex" => "-1",
                "position"=>"fixed"
            ),$atts));
            $style = '';
            if($position){
                $style .= 'position:'.$position.';';
            }
            $style .= 'z-index:'.$zindex.';';
            if($height){
                $style .= 'height:'.$height.';';
            }

            if($zindex){
                $style .= 'z-index:'.$zindex.';';
            }
            $output .= '<ul id="scene" class="layers-effect '.$class.'" style="'.$style.'">';
            $output .= do_shortcode($content);
            $output .= '</ul>';
            
            return $output;
        }

        // Shortcode handler function for item
        function inwave_layer_shortcode($atts, $content = null)
        {
            $output = $img = $data_depth= $class = $opacity = '';
            extract(shortcode_atts(array(
                'img'        => '',
                'class'        => '',
                'opacity'        => '',
                'data_depth'        => '0'
            ), $atts));

            $output .= '<li class="layer" data-depth="'.$data_depth.'">';

            if($img) {
                $img = wp_get_attachment_image_src($img, 'large');
                $img = $img[0];
                $img = 'background-image:url('.$img.');';
            }
            if($opacity){
                $opacity ='opacity:'.$opacity.';"';
            }
            $output .= '<div class="layer-img '.$class.'" style="'.$img.$opacity.'">';
			$output .= $content;
			$output .= '</div>';
			$output .= '</li>';
            return $output;
        }

    }
}

new Inwave_Layers_Effect;
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Layers_Effect extends WPBakeryShortCodesContainer
    {
    }
}
