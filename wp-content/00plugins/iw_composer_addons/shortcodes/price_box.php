<?php
/*
* Inwave_Price_Box for Visual Composer
*/
if (!class_exists('Inwave_Price_Box')) {
    class Inwave_Price_Box
    {
        function __construct()
        {
      
            add_action('admin_init', array($this, 'price_box_init'));
            add_shortcode('inwave_price_box', array($this, 'inwave_price_box_shortcode'));
        }

        function price_box_init()
        {

            // Add banner addon
            vc_map(array(
                'name' => 'Price Box',
                'description' => __('Add a price box & some information', 'inwavethemes'),
                'base' => 'inwave_price_box',
                'wrapper_class' => 'clearfix',
                // 'icon' => 'icon-wpb-inwavethemes',
                'category' => 'InwaveThemes',
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Image", "inwavethemes"),
                        "param_name" => "img"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Package name/Title", "inwavethemes"),
                        "value" => "Lorem ipsum dolor sit amet",
                        "param_name" => "title"
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Package type/Sub Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "sub_title"
                    ),

                    array(
                        "type" => "textfield",
                        "heading" => __("Price", "inwavethemes"),
                        "param_name" => "price"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Read more text", "inwavethemes"),
                        "param_name" => "readmore_text"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Read more link", "inwavethemes"),
                        "param_name" => "readmore_link"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Purchase text", "inwavethemes"),
                        "param_name" => "purchase_text"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Purchase link", "inwavethemes"),
                        "param_name" => "purchase_link"
                    ),
                    array(
                        "type" => "textarea",
                        "heading" => "Description",
                        "param_name" => "description",
                        "value" => "Lorem ipsum dolor sit amet, consectetur adi sollicitudin"
                    ),
                    array(
                        "type" => "textarea_html",
                        "heading" => "Features",
                        "param_name" => "content",
                        "value" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )

            ));

        }

        // Shortcode handler function for list Icon
        function inwave_price_box_shortcode($atts, $content = null)
        {
            $output = $img = $title = $sub_title = $class = $readmore_link = $readmore_text = $purchase_text = $purchase_link =  $price = $description = '';
            extract(shortcode_atts(array(
                'img' => '',
                'title' => '',
                'sub_title' => '',
                'class' => '',
                'description' => '',
                'readmore_link' => '',
                'readmore_text' => '',
                'purchase_link' => '',
                'purchase_text' => '',
                'price' => ''

            ), $atts));
            $output .= '<div class="price-tb">';
            $output .= '<div class="col-md-12 price-table-content">';
            if ($img) {
                $img = wp_get_attachment_image_src($img, 'large');
                $img = $img[0];
                $output .= '<div class="price-table-img">';
                $output .= '<img src="' . $img . '" alt="">';
                $output .= '</div>';
            }
            $output .= '<div class="price-table-text">';
            $output .= '<h3>' . $sub_title . '</h3>';
            $output .= '<h2>' . $title . '</h2>';
            $output .= '<div class="border-bottom"></div>';
            $output .= '<p>' . $description . '</p>';
            if ($price) {
                $output .= '<div class="price"><span>' . $price . '</span></div>';
            }
            if ($readmore_text) {
                $output .= '<a href="' . $readmore_link . '"><span>' . $readmore_text . '</span></a>';
            }
            $output .= '</div></div>';
            $output .= '<div class="col-md-12 price-list"><div class="price-table-1">' . str_replace(array('<p>','</p>'),'',$content) . '</div>';
            if ($purchase_text) {
           $output .= '<div class="plan"><a href="'.$purchase_link.'">'.$purchase_text.'</a></div>';
}
            $output .= '</div></div>';
            return $output;

        }
    }
}

new Inwave_Price_Box;
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_Inwave_Price_Box extends WPBakeryShortCode
    {
    }
}