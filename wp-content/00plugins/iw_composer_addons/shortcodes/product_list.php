<?php
/*
* Inwave_Product_List for Visual Composer
*/
if (!class_exists('Inwave_Product_List')) {
    class Inwave_Product_List
    {
        function __construct()
        {

            add_action('admin_init', array($this, 'product_list_init'));
            add_shortcode('inwave_product_list', array($this, 'inwave_product_list_shortcode'));
        }

        function product_list_init()
        {	
			if(!function_exists('WC')){
				return;
			}
            // Add banner addon
            vc_map(array(
                'name' => 'Woocommerce Product List',
                'description' => __('Add list of products', 'inwavethemes'),
                'base' => 'inwave_product_list',
                // 'icon' => 'icon-wpb-inwavethemes',
                'category' => 'InwaveThemes',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "This is title",
                        "param_name" => "title"
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Display",
                        "param_name" => "display",
                        "value" => array(
                            "All" => "",
                            "Recent Products" => "recent",
                            "Featured Products" => "featured",
                            "Top rated Products" => "top_rated",
                            "Products on sale" => "on_sale",
                            "Best selling products" => "best_sale"
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Product Category",
                        "param_name" => "category",
                        "value" => $this->get_categories()
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Order By",
                        "param_name" => "order_by",
                        "value" => array(
                            "Date" => "date",
                            "Title" => "title",
                            "Product ID" => "ID",
                            "Name" => "name",
                            "Price" => "price",
                            "Sales" => "sales",
                            "Random" => "rand",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Order Direction",
                        "param_name" => "order_dir",
                        "value" => array(
                            "Descending" => "desc",
                            "Ascending" => "asc"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Number of products", "inwavethemes"),
                        "param_name" => "limit",
                        "value" => 12
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "",
                        "heading" => "Style",
                        "param_name" => "layout",
                        "value" => array(
                            "Style 1 - Slider" => "layout1",
                            "Style 2 - Grid" => "layout2"
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

        // Shortcode handler function for list products woocommerce
        function inwave_product_list_shortcode($atts, $content = null)
        {
            global $woocommerce;
            $output = $title = $limit = $display = $category = $order_by = $order_dir = $class = $layout = '';
            extract(shortcode_atts(array(
                'title' => '',
                'limit' => 12,
                'display' => '',
                'category' => '',
                'order_by' => '',
                'order_dir' => '',
                'class' => '',
                'layout' => 'layout1'
            ), $atts));

            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => $limit,
                'orderby' => $order_by,
                'order' => $order_dir,
                'paged' => 1
            );
            switch ($display) {
                case 'recent':
                    $args['meta_query'] = WC()->query->get_meta_query();
                    break;
                case 'featured':
                    $args['meta_query'] = array(
                        array(
                            'key' => '_visibility',
                            'value' => array('catalog', 'visible'),
                            'compare' => 'IN'
                        ),
                        array(
                            'key' => '_featured',
                            'value' => 'yes'
                        )
                    );
                    break;
                case 'top_rated':
                    add_filter('posts_clauses', array(WC()->query, 'order_by_rating_post_clauses'));
                    $args['meta_query'] = WC()->query->get_meta_query();
                    break;
                case 'on_sale':
                    $product_ids_on_sale = wc_get_product_ids_on_sale();
                    $args['meta_query'] = array();
                    $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                    $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                    $args['post__in'] = $product_ids_on_sale;
                    break;
                case 'best_sale':
                    $args['meta_key'] = 'total_sales';
                    $args['orderby'] = 'meta_value_num';
                    $args['meta_query'] = array(
                        array(
                            'key' => '_visibility',
                            'value' => array('catalog', 'visible'),
                            'compare' => 'IN'
                        )
                    );
                    break;
            }
            if ($category) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'terms' => array(esc_attr($category)),
                        'field' => 'slug',
                        'operator' => 'IN'
                    )
                );
            }
            $query = new WP_Query($args);
            ob_start();
            switch ($layout) {
                case 'layout1':
                    ?>
                    <div class="popular-title">
                        <h3 class="text-title"><?php echo $title;?></h3>

                        <div class="next">
                            <button class="circle icon-wrap t-nav-prev">
                                <i class="fa fa-chevron-left"></i>
                            </button>
                            <button class="circle icon-wrap t-nav-next">
                                <i class="fa fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <div id="owl-popular" class="owl-carousel" data-nav="t-nav-"
                         data-plugin-options='{"autoPlay":false,"autoHeight":true,"singleItem":false,"navigation":false}'>
                        <?php
                        if ($query->have_posts()):
                            while ($query->have_posts()) : $query->the_post();
                                ?>
                                <div class="popular-product">
                                    <?php
                                    wc_get_template_part('content', 'product');
                                    ?>
                                </div>
                            <?php
                            endwhile;
                        endif;
                        ?>
                    </div>
                    <?php
                    break;
                case 'layout2':
                    ?>
                    <div class="title-page title-about">
                        <h4><?php echo $title;?></h4>
                    </div>
                    <div class="row product-row-grid">
                    <?php
                    $i = 0;
                    if ($query->have_posts()):
                        while ($query->have_posts()) : $query->the_post();

                            if($i%4==0 && $i>0) echo '</div><div class="row product-row-grid">';
                            $i++;
                            ?>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <?php
                                wc_get_template_part('content', 'product');
                                ?>
                            </div>
                        <?php
                        endwhile;
                    endif;
                    ?>
                    </div>
                    <?php
                    break;
            }

            if ($display == "top_rated") {
                remove_filter('posts_clauses', array(WC()->query, 'order_by_rating_post_clauses'));
            }

            wp_reset_postdata();
            $output .= ob_get_contents();
            ob_end_clean();
            return $output;
        }

        function get_categories()
        {
            $arg = array('taxonomy' => 'product_cat');
            $categories = get_categories($arg);
            $newCategories = array();
            $newCategories[__("All", "inwavethemes")] = '';
            foreach ($categories as $cat) {
                $newCategories[$cat->name] = $cat->slug;
            }
            return $newCategories;
        }
    }

}

new Inwave_Product_List;

// Inherit WPBakeryShortCode functions & attributes
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_Inwave_Product_List extends WPBakeryShortCode
    {
    }
}