<?php
/*
 * @package Inwave Athlete
 * @version 1.0.0
 * @created Mar 27, 2015
 * @author gmswebdesign
 * @email gmswebdesign@gmail.com
 * @website http://gmswebdesign.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 gmswebdesign. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of wp_posts
 *
 * @Developer duongca
 */
if (!class_exists('Inwave_WP_Posts')) {

    class Inwave_WP_Posts
    {

        function __construct()
        {

            add_action('admin_init', array($this, 'heading_init'));
            add_shortcode('inwave_wp_posts', array($this, 'inwave_wp_posts_shortcode'));
        }

        function heading_init()
        {

            // Add banner addon
            $_categories = get_categories();
            $cats = array(__("All", "gmswebdesign") => '');
            foreach ($_categories as $cat) {
                $cats[$cat->name] = $cat->term_id;
            }
            vc_map(array(
                'name' => 'WP Posts',
                'description' => __('Display a list of posts ', 'gmswebdesign'),
                'base' => 'inwave_wp_posts',
                // 'icon' => 'icon-wpb-gmswebdesign',
                'category' => 'gmswebdesign',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "gmswebdesign"),
                        "value" => "",
                        "param_name" => "title",
                        "description" => __('Title of wp_posts block.', "gmswebdesign")
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Sub Title", "gmswebdesign"),
                        "param_name" => "sub_title",
                        "description" => __('Sub Title of wp_posts block.', "gmswebdesign")
                    ),
                    array(
                        'type' => 'textarea',
                        "holder" => "div",
                        "heading" => __("Description", "gmswebdesign"),
                        "param_name" => "description",
                        "description" => __('Description of wp_posts block.', "gmswebdesign")
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Post Ids", "gmswebdesign"),
                        "value" => "",
                        "param_name" => "post_ids",
                        "description" => __('Id of posts you want to get. Separated by commas.', "gmswebdesign")
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Post Category", "gmswebdesign"),
                        "param_name" => "category",
                        "value" => $cats,
                        "description" => __('Category to get posts.', "gmswebdesign")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Post number", "gmswebdesign"),
                        "param_name" => "post_number",
                        "value" => "3",
                        "description" => __('Number of posts to display on box.', "gmswebdesign")
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Order By", "gmswebdesign"),
                        "param_name" => "order_by",
                        "value" => array(
                            'ID' => 'ID',
                            'Title' => 'title',
                            'Date' => 'date',
                            'Modified' => 'modified',
                            'Ordering' => 'menu_order',
                            'Random' => 'rand'
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Order Type", "gmswebdesign"),
                        "param_name" => "order_type",
                        "value" => array(
                            'ASC' => 'ASC',
                            'DESC' => 'DESC'
                        ),
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
                        "heading" => __("Style", "gmswebdesign"),
                        "param_name" => "layout",
                        "value" => array(
                            'Style 1 - Carousel' => 'style1',
                            'Style 2 - List' => 'style2',
                            'Style 3 - Grid' => 'style3'
                        )
                    )
                )
            ));
        }

        // Shortcode handler function for list Icon
        function inwave_wp_posts_shortcode($atts, $content = null)
        {
            extract(shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'description' => '',
                'post_ids' => '',
                'category' => '',
                'post_number' => 3,
                'order_by' => 'ID',
                'order_type' => 'DESC',
                'layout' => 'style1',
                'class' => ''
            ), $atts));
            return $this->htmlBoxRender($title, $sub_title, $description, $post_ids, $category, $post_number, $order_by, $order_type, $layout, $class);
        }

        function htmlBoxRender($title, $sub_title, $description, $post_ids, $category, $post_number, $order_by, $order_type, $layout, $class)
        {
            $args = array();
            if ($post_ids) {
                $args['post__in'] = explode(',', $post_ids);
            } else {
                if ($category) {
                    $args['category__in'] = $category;
                }
            }
            $args['posts_per_page'] = $post_number;
            $args['order'] = $order_type;
            $args['orderby'] = $order_by;

            $query = new WP_Query($args);
            if ($layout == 'style1') {
                $html = $this->loadStyle1Html($title, $sub_title, $description, $query, $class);
            } else if ($layout == 'style2') {
                $html = $this->loadStyle2Html($query->posts, $class);
            } else if ($layout == 'style3') {
                $html = $this->loadStyle3Html($title, $sub_title, $query, $class);
            }
            return $html;
        }

        public function loadStyle1Html($title, $sub_title, $description, $custom_query, $class)
        {
            ob_start();
            ?>
            <div class="container <?php echo $class; ?>">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="fit-strong-left">
                            <div class="fit-strong-top">
                                <h3 class="fit-strong-text"><?php echo $sub_title; ?></h3>

                                <h2 class="fit-strong-text"><?php echo $title; ?></h2>

                                <p class="fit-strong-sub"><?php echo $description; ?></p>
                            </div>
                            <div class="fit-strong-bottom">
                                <div class="fit-background"></div>

                                    <div class="carousel-image">
                                        <div id="carousel-image" class="owl-carousel"
                                             data-plugin-options='{"singleItem":true,"navigation":false,"autoPlay":false,"autoHeight":true}'>
                                            <?php
                                            foreach ($custom_query->posts as $post) :
                                                $img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
                                                echo '<div class="caroussel-slide">';
												if($img[0]){
													echo '<img src="' . $img[0] . '" alt="">';
												}
                                                echo '</div>';
                                            endforeach;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="owl-controls clickable">
                                        <div class="owl-pagination">
                                            <?php
                                            for ($i = 0; $i < count($custom_query->posts); $i++) {
                                                echo '<div class="owl-page ' . ($i == 0 ? 'active' : '') . '" data-page="' . $i . '"><span class=""></span></div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="carousel-text">
                                        <div id="carousel-text" class="owl-carousel"
                                             data-plugin-options='{"singleItem":true,"navigation":false,"autoPlay":false,"autoHeight":true}'
                                             data-pager='owl-page'>
                                            <?php
                                            while ($custom_query->have_posts()) : $custom_query->the_post();
                                                echo '<div class="slide-caption">';
                                                echo '<h4 class="caption-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h4>';
                                                echo '<p class="caption-slide">' . AthleteHelper::substrword(get_the_excerpt(), 20) . '</p>';
                                                echo '</div>';
                                            endwhile;
                                                wp_reset_postdata();
                                            ?>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

        public function loadStyle2Html($posts, $class)
        {
            ob_start();
            if ($posts):
                ?>
                <div class="container <?php echo $class; ?>">
                    <div class="row">
                        <?php
                        foreach ($posts as $post) :
                            $cats = get_the_category($post->ID);
                            if ($cats) {
                                $catName = $cats[0]->name;
                            }
                            $link = get_permalink($post->ID);
                            $date = date('F d, Y', strtotime($post->post_date));
                            $author = get_the_author();
                            ?>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="our-succes-top success">
                                    <h5><?php echo $catName; ?></h5>

                                    <div class="succes-link">
                                        <a href="<?php echo $link; ?>"><?php echo $post->post_title; ?></a>
                                    </div>
                                    <p><?php echo $date . __(' by ', 'gmswebdesign') . '<span>' . $author . '</span>' . __(' in ', 'gmswebdesign') . '<span>' . $catName . '</span>'; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php
            endif;
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

        // Style 3 function - (Sport News) block
        public function loadStyle3Html($title, $sub_title, $custom_query, $class)
        {
            ob_start();
            ?>
            <div class="<?php echo $class?>">
                <div class="title-page title-about">
                    <h4><?php echo $title?></h4>
                    <?php if ($sub_title): ?>
                        <h5><?php echo $sub_title ?></h5>
                    <?php endif;?>
                </div>
                <div class="row">
                    <?php
                    $i = 0;
                    while ($custom_query->have_posts()) : $custom_query->the_post();
                        if ($i % 3 == 0 && $i > 0) echo '</div><div class="row">';
                        $i++;

                        ?>
                        <div class="col-md-4 col-sm-4 col-xs-12 sport-box">
                            <div class="img-sport img-blog">
                                <?php switch (get_post_format()) {
                                    case 'gallery':
                                        echo get_post_gallery();
                                        ?>
                                        <div class="icon-sport">
                                            <i class="fa fa-picture-o"></i>
                                        </div>
                                        <?php
                                        break;
                                    case 'video':
                                        $contents = get_the_content();
                                        $video = getElementByTags('embed', $contents);
                                        if ($video) {
                                            echo apply_filters('the_content', $video[0]);
                                        }

                                        ?>
                                        <div class="icon-sport">
                                            <i class="fa fa-play"></i>
                                        </div>
                                        <?php
                                        break;
                                    default:
                                        $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
                                        if (count($img)) {
                                            $img = $img[0];
                                        } else {
                                            $img = '';
                                        }
                                        ?>

                                        <a href="<?php echo get_permalink() ?>"><img src="<?php echo $img; ?>"
                                                                                     alt=""></a>
                                        <div class="icon-sport">
                                            <i class="fa fa-camera"></i>
                                        </div>


                                        <?php
                                        break;
                                } ?>
                            </div>

                            <div class="sport-content">
                                <div class="title-sport"><a
                                        href="<?php echo get_permalink(); ?>"><?php the_title() ?></a>
                                </div>
                                <p><?php echo AthleteHelper::substrword(get_the_excerpt(), 30); ?></p>

                                <div class="read-more">
                                    <a href="<?php echo get_permalink(); ?>"><i
                                            class="fa fa-chevron-right"></i> Read more</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
            <?php
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

    }

}

new Inwave_WP_Posts();
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_WP_Posts extends WPBakeryShortCode
    {

    }

}