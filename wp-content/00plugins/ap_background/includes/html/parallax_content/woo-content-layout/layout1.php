<?php
/**
 * Front end: layout display for type woocommerce product
 *
 * @author Inwavethemes
 * @package AP Background
 * @version 1.0.0
 */
?>

<?php while ($query->have_posts()) : $query->the_post(); ?>
    <?php if ($index % $contentSource->content_settings->rows == 0): ?>
        <div class="parallax-col">
        <?php endif; ?>
        <div class="parallax-row in-pos" <?php echo ($index % $contentSource->content_settings->rows == 0) ? '' : 'style="margin-top:' . $contentSource->content_settings->spacing . 'px;"'; ?>>
            <?php $images = $bt_utility->getFirstImageFromContent(get_the_content());?>
            <?php if ($contentSource->content_settings->show_image  && (has_post_thumbnail()||!empty($images))): ?>
            <div class="feature-image" style="<?php echo 'height:'.$contentSource->content_settings->item_width.'px;';?>">
                    <?php if ($contentSource->content_settings->add_to_cart || $contentSource->content_settings->add_to_wishlist): ?>
                        <div class="product-overlay">
                            <div class="product-action">
                                <?php if ($contentSource->content_settings->add_to_wishlist): ?>
                                    <?php if ($bt_utility->is_product_in_wishlist(get_the_ID())): ?>
                                        <span class="view-wishlist" title="<?php echo __(' View Wishlist'); ?>" data-link="<?php echo get_permalink(get_option('yith_wcwl_wishlist_page_id')); ?>"><i class="fa fa-heart"></i></span>
                                    <?php else: ?>
                                        <span class="wishlist" title="<?php echo __(' Add wishlist'); ?>" data-pid="<?php echo get_the_ID(); ?>"><i class="fa fa-heart"></i></span>
                                        <span class="view-wishlist hidden" title="<?php echo __(' View Wishlist'); ?>" data-link="<?php echo get_permalink(get_option('yith_wcwl_wishlist_page_id')); ?>"><i class="fa fa-heart"></i></span>
                                    <?php endif; ?>
                                <?php endif ?>
                                <?php
                                if ($contentSource->content_settings->add_to_cart):
                                    $product_type = wp_get_post_terms(get_the_ID(), 'product_type');
                                    if ($product_type[0]->name == 'simple'):
                                        ?>
                                        <span class="addcart last" title="<?php echo __(' Add cart'); ?>" data-pid="<?php echo get_the_ID(); ?>"><i class="fa fa-shopping-cart"></i></span>
                                    <?php else: ?>
                                        <span class="viewproduct last" title="<?php echo ($product_type[0]->name == 'variable') ? __(' Select option') : __(' View product'); ?>" data-link="<?php echo the_permalink(); ?>"><?php echo ($product_type[0]->name == 'variable') ? '<i class="fa fa-bars"></i>' : '<i class="fa fa-info"></i>'; ?></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="ajax-content">
                                <span class="loadding"><img src="<?php echo plugins_url('ap_background/assets/images/loading.gif'); ?>"  alt="<?php echo __('Loading...');?>"/></span>
                                <span class="text"></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php if(has_post_thumbnail()):?>
                        <?php the_post_thumbnail('medium'); ?>
                        <?php else:?>
                        <?php echo $images;?>
                        <?php endif;?>
                    </a>
                </div>
            <?php endif; ?>
            <div class="post-content-info">
                <div class="left-info">
                    <?php if ($contentSource->content_settings->show_title): ?>
                        <a href="<?php echo the_permalink(); ?>"><h3 class="title"><?php the_title(); ?></h3></a>
                        <div style="clear: both;"></div>
                    <?php endif; ?>
                    <?php if ($contentSource->content_settings->show_info): ?>
                        <div class="post-info">
                            <?php
                            $post_categories = wp_get_post_terms(get_the_ID(), 'product_cat');
                            if (!empty($post_categories)) {
                                for ($i = 0; $i < count($post_categories); $i++) {
                                    $pcat = $post_categories[$i];
                                    if ($i > 0) {
                                        echo ' / ';
                                    }
                                    echo '<span class="link"><a href="' . get_term_link($pcat) . '">' . $pcat->name . '</a></span> ';
                                }
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="right-info">
                    <div class="price">
                        <span>
                            <?php
                            $c_pos = get_option('woocommerce_currency_pos');
                            $price = get_post_meta(get_the_ID(), '_price', true);
                            $c_symbol = get_woocommerce_currency_symbol();
                            switch ($c_pos) {
                                case 'left':
                                    echo $c_symbol . $price;
                                    break;
                                case 'right':
                                    echo $price . $c_symbol;
                                    break;
                                case 'left_space':
                                    echo $c_symbol . ' ' . $price;
                                    break;
                                default:
                                    echo $price . ' ' . $c_symbol;
                                    break;
                            }
                            ?>
                        </span>
                    </div>
                </div>
                <div style="clear:both"></div>
            </div>
        </div>
        <?php if (($index + 1) % $contentSource->content_settings->rows == 0 || $index == $query->post_count - 1): ?>
        </div>
    <?php endif; ?>
    <?php $index++; ?>
<?php endwhile; ?>
<div style="clear: both;"></div>
<?php wp_reset_postdata(); ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('span.wishlist').click(function () {
<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php');
if (is_plugin_active('yith-woocommerce-wishlist/init.php')) :
    ?>
                var id = jQuery(this).data('pid');
                var itemtarget = jQuery(this);
                jQuery.ajax({
                    url: btAdvParallaxBackgroundCfg.ajaxUrl,
                    data: {action: 'add_to_wishlist', add_to_wishlist: id},
                    type: 'post',
                    beforeSend: function () {
                        itemtarget.parents('.product-overlay').find('.ajax-content, .loadding').fadeIn(0);
                    },
                    success: function () {
                        itemtarget.parents('.product-overlay').find('.ajax-content .loadding').fadeOut(0, function () {
                            itemtarget.parents('.product-overlay').find('.ajax-content .text').text('Product added').fadeIn(200, function () {
                                setTimeout(function () {
                                    itemtarget.parents('.product-overlay').find('.ajax-content').fadeOut(200);
                                    itemtarget.parents('.product-overlay').find('.ajax-content .text').fadeOut(200, function () {
                                        itemtarget.addClass('hidden');
                                        itemtarget.parents('.product-overlay').find('.view-wishlist').removeClass('hidden');
                                        jQuery(this).text('');
                                    });
                                }, 1000);
                            });
                        });
                    }
                });
<?php else: ?>
                alert("<?php echo __('Please install or active yith woocommerce wishlist plugin'); ?>");
<?php endif; ?>
        });
        jQuery('span.addcart').click(function () {
            var id = jQuery(this).data('pid');
            var itemtarget = jQuery(this);
            jQuery.ajax({
                url: btAdvParallaxBackgroundCfg.ajaxUrl,
                data: {action: 'woocommerce_add_to_cart', quantity: 1, product_id: id},
                type: "post",
                beforeSend: function () {
                    itemtarget.parents('.product-overlay').find('.ajax-content, .loadding').fadeIn(0);
                },
                success: function () {
                    itemtarget.parents('.product-overlay').find('.ajax-content .loadding').fadeOut(0, function () {
                        itemtarget.parents('.product-overlay').find('.ajax-content .text').text('Product added').fadeIn(200, function () {
                            setTimeout(function () {
                                itemtarget.parents('.product-overlay').find('.ajax-content').fadeOut(200);
                                itemtarget.parents('.product-overlay').find('.ajax-content .text').fadeOut(200, function () {
                                    jQuery(this).text('');
                                });
                            }, 1000);
                        });
                    });
                }
            });
        });
        jQuery('span.viewproduct').click(function () {
            var link = jQuery(this).data('link');
            window.location.assign(link);
        });
        jQuery('span.view-wishlist').click(function () {
            var link = jQuery(this).data('link');
            window.location.assign(link);
        });
    });
</script>
