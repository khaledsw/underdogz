<?php

/**
 * Front end: Parallax view kieu woocommerce product
 *
 * @author gmswebdesign
 * @package AP Background
 * @version 1.0.0
 */


//global $wpdb;
$contentSource = $item->settings->content_source;
$index = 0;
$post_in = array();
$post_not_in = array();
$args = array();
$args['post_type'] = 'product';
if ($contentSource->content_ids) {
    $post_in = array_intersect($post_in, explode(',', $contentSource->content_ids));
} elseif ($contentSource->categories) {
    $post_not_in = $bt_utility->arrayGroupValue($post_not_in, explode(',', $contentSource->content_ex_ids));
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'id',
            'terms' => $contentSource->categories
        )
    );
}


//Filter by content type
if ($contentSource->product_content_type == 'nomal') {
    $post_not_in = $bt_utility->arrayGroupValue($post_not_in, wc_get_featured_product_ids());
    $post_not_in = $bt_utility->arrayGroupValue($post_not_in, wc_get_product_ids_on_sale());
}
$args['posts_per_page'] = $contentSource->content_settings->limit;
if ($contentSource->product_content_type == 'sale') {
    $post_in = $bt_utility->arrayGroupValue($post_in, wc_get_product_ids_on_sale());
}
if ($contentSource->product_content_type == 'featured') {
    $post_in = $bt_utility->arrayGroupValue($post_in, wc_get_featured_product_ids());
}

//Order process
if ($contentSource->content_settings->order == 'price') {
    $args['meta_key'] = '_price';
    $args['orderby'] = 'meta_value_num';
} else if ($contentSource->content_settings->order == 'popularity') {
    $args['meta_key'] = 'total_sales';
    $args['orderby'] = 'meta_value_num';
} else if ($contentSource->content_settings->order == 'rate') {
    $post_in = $bt_utility->getPostIdsbyrateAvg($contentSource->content_settings->direction, $contentSource->product_content_type);
} else {
    $args['orderby'] = $contentSource->content_settings->order;
}

if (!empty($post_in)) {
    $args['post__in'] = $post_in;
}
if (!empty($post_not_in)) {
    $args['post__not_in'] = $post_not_in;
}
$args['order'] = $contentSource->content_settings->direction;
$query = new WP_Query($args);
?>
<?php if ($query->have_posts()) : ?>
    <div class="<?php echo $contentSource->content_settings->layout; ?>">
        <?php include_once 'woo-content-layout/' . $contentSource->content_settings->layout . '.php'; ?>
    </div>
<?php else : ?>
    <div class="nodata">
        <div class="title"><?php echo __('Message'); ?></div>
        <div class="msg-content">
            <?php _e('Sorry, no posts matched your criteria.'); ?>
        </div>
    </div>
<?php endif; 
