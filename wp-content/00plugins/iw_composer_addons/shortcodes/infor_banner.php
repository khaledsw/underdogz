<?php
/*
* Inwave_Infor_Banner for Visual Composer
*/
if (!class_exists('Inwave_Infor_Banner')) {
    class Inwave_Infor_Banner
    {
        function __construct()
        {
            add_action('admin_init', array($this, 'infor_banner_init'));
            add_shortcode('inwave_infor_banner', array($this, 'inwave_infor_banner_shortcode'));
        }

        function infor_banner_init()
        {

            // Add banner addon
            vc_map(array(
                'name' => 'Info Banner',
                'description' => __('Add a banner & some information', 'inwavethemes'),
                'base' => 'inwave_infor_banner',
                // 'icon' => 'icon-wpb-inwavethemes',
                'category' => 'InwaveThemes',
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Banner Image", "inwavethemes"),
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
                        "value" => "",
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
                        "heading" => __("Banner Size", "inwavethemes"),
                        "param_name" => "img_size",
                        "description" => __("Enter image size. Example in pixels: 200x100 (Width x Height)", "inwavethemes")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Text", "inwavethemes"),
                        "param_name" => "button_text"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Link", "inwavethemes"),
                        "param_name" => "link"
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "",
                        "heading" => "Style",
                        "param_name" => "layout",
                        "value" => array(
                            "Style 1 - Men Women" => "layout1",
                            "Style 2 - Don't give up" => "layout2",
                            "Style 3 - Athlete Services" => "layout3",
                            "Style 4 - Our pricing" => "layout4",
                            "Style 5 - Match Reviews" => "layout5",
                            "Style 6 - Open Gallery" => "layout6",
                            "Style 7 - Collection small" => "layout7",
                            "Style 8 - Collection large" => "layout8",
                        )
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
        function inwave_infor_banner_shortcode($atts, $content = null)
        {
            $output = $img = $img_size = $title = $sub_title = $class = $link = $description = $button_text = $layout = '';
            extract(shortcode_atts(array(
                'img'        => '',
                'img_size'        => '',
                'title'        => '',
                'sub_title'        => '',
                'class' => '',
                'link'      => '',
                'description'         => '',
                'button_text'   => '',
                'layout'   => 'layout1'
            ), $atts));

            $img_tag = '';
            if ($img) {
                $img = wp_get_attachment_image_src($img, 'large');
                $img = $img[0];
                $size = '';
                if ($img_size) {
                    $img_size = explode('x', $img_size);
                    $size = 'style="width:' . $img_size[0] . 'px!important;height:' . $img_size[1] . 'px!important"';
                }
                $img_tag .= '<img ' . $size . ' src="' . $img . '" alt="' . $title . '">';
            }

            switch($layout) {
                case 'layout1':
                    $output .= '<div class="img-class">';
                    $output .= $img_tag;
                    $output .= '</div>';
                    $output .= '<div class="class-content">';

                    if ($title) {
                        $output .= '<div class="title"><h3 class="title-men">' . $title . '</h3>';
                        if ($sub_title) {
                            $output .= '<h4>' . $sub_title . '</h4>';
                        }
                        $output .='</div>';
                    }
                    $output .= '<div class="class-content-text">';
                    if ($description) {
                        $output .= '<p class="desc-content">' . $description . '</p>';
                    }
                    if ($button_text) {
                        $output .= '<div class="join"><a href="' . $link . '">' . $button_text . '</a></div>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
                case 'layout2':
                    $output .= '<div class="intro-content">';
                    $output .= '<div class="icon-img">';
                    $output .= $img_tag;
                    $output .= '</div>';
                    if ($title) {
                        $output .= '<h4 class="intro-text">' . $title . '</h4>';
                    }
                    if ($sub_title) {
                        $output .= '<h4 class="sub-title">' . $sub_title . '</h4>';
                    }
                    if ($description) {
                        $output .= '<p class="intro-text">' . $description . '</p>';
                    }
                    if ($button_text) {
                        $output .= '<div class="join"><a href="' . $link . '">' . $button_text . '</a></div>';
                    }
                    $output .= '</div>';
                    break;
                case 'layout3':
                    $output .= '<div class="sevices-wapper">';
                    $output .= '<div class="services-content">';
                    $output .= '<div class="intro-img">';
                    $output .= $img_tag;
                    $output .= '</div>';
                    if ($sub_title) {
                        $output .= '<h4 class="services-title">' . $sub_title . '</h4>';
                    }
                    $output .= '<hr class="border-title">';
                    if ($title) {
                        $output .= '<h3 class="services-title">' . $title . '</h3>';
                    }
                    $output .= '<hr class="border-title-1">';
                    $output .= '<div class="actions">';
                    if ($description) {
                        $output .= '<p>' . $description . '</p>';
                    }
                    if ($button_text) {
                        $output .= '<div class="join"><a href="' . $link . '">' . $button_text . '</a></div>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';

                    break;
                case 'layout4':
                    $output .= '<div class="'.$class.'">';
                    $output .= '<div class="our-price">';
                    $output .= '<div class="image-price-right">';

                    $output .= $img_tag;
                    $output .= '</div>';

                    if($class=='yoga-card'){
                        $output.= '<div class="yoga-content">';
                    }
                    $output .= '<div class="'.$class.'-content">';

                    if ($title) {
                        $output .= '<h3>' . $title . '</h3>';
                    }
                    if ($sub_title) {
                        $output .= '<h4>' . $sub_title . '</h4>';
                    }
                    if ($description) {
                        $output .= '<p class="desc-content">' . $description . '</p>';
                    }
                    if ($button_text) {
                        $output .= '<div class="price"><a class="shopping-buy" href="' . $link . '"><span>' . $button_text . '</span></a></div>';
                    }
                    if($class=='yoga-card') {
                        $output .= '</div>';
                    }
                    $output .= '</div>';

                    $output .= '</div>';
                    $output .= '</div>';
                    break;
                case 'layout5':
                    $output .= '<div class="reviews-content col-md-12 col-sm-12 col-xs-12 '.$class.'">';
                    $output .= '<div class="match-reviews match col-md-6 col-sm-6 col-xs-12">';
                    if ($title) {
                        $output .= '<h3>' . $title . '</h3>';
                    }
                    if ($sub_title) {
                        $output .= '<h4>' . $sub_title . '</h4>';
                    }
                    $output .= '<div class="border"></div>';
                    if ($description) {
                        $output .= '<h2>' . $description . '</h2>';
                    }
                    if ($button_text) {
                        $output .= '<div class="join"><a href="' . $link . '">' . $button_text . '</a></div>';
                    }
                    $output .= '</div>';
                    $output .= '<div class="match-img col-md-6 col-sm-6 col-xs-12">';
                    $output .= $img_tag;
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
                case 'layout6':

                    $output .= '<div class="gallery col-md-12 col-sm-12 col-xs-12 '.$class.'">';
                    $output .= '<div class="gallery-background">';
                    $output .= $img_tag;
                    $output .= '</div>';
                    $output .= '<div class="gallery-content match-reviews col-md-12 col-sm-12 col-xs-12">';
                    if ($title) {
                        $output .= '<a href="' . $link . '"><h3 class="title-gallery">' . $title . '</h3>'.'</a>';
                    }
                    if ($description) {
                        $output .= '<h2>' . $description . '</h2>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';

                    break;
                case 'layout7':
                    $output .= '<div class="masonry-small">';
                    $output .= '<div class="price-table-img">';
                    $output .= $img_tag;
                    $output .= '</div>';
                    $output .= '<div class="price-table-text">';
                    if ($sub_title) {
                        $output .= '<h3>' . $sub_title . '</h3>';
                    }
                    if ($title) {
                        $output .= '<h2>' . $title . '</h2>';
                    }
                    $output .= '<div class="border-bottom"></div>';
                    if ($description) {
                        $output .= '<p>' . $description . '</p>';
                    }
                    if($button_text){
                        $output .= '<a href="' . $link . '"><span>'.$button_text.'</span></a>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';


                    break;


                case 'layout8':
                    $output .= '<div class="masonry-lagar">';
                    $output .= '<div class="price-table-img">';
                    $output .= $img_tag;
                    $output .= '</div>';
                    $output .= '<div class="price-table-text">';
                    $output .= '<div class="masonry-lagar-content">';
                    $output .= '<div class="title-masory">';

                    if ($sub_title) {
                        $output .= '<h3>' . $sub_title . '</h3>';
                    }
                    if ($title) {
                        $output .= '<h2>' . $title . '</h2>';
                    }
                    $output .= '<div class="border-bottom"></div>';
                    $output .= '</div>';
                    if ($description) {
                        $output .= '<div class="text-masony">' . $description . '</div>';
                    }
                    if($button_text){
                        $output .= '<a href="' . $link . '"><span>'.$button_text.'</span></a>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
            }
            return $output;
        }
    }
}

new Inwave_Infor_Banner;
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_Inwave_Infor_Banner extends WPBakeryShortCode
    {
    }
}