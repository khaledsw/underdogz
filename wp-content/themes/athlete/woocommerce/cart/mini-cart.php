<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<ul class="widget_products <?php echo $args['list_class']; ?>">

	<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					?>
					<li>
                        <div class="product-image">
                            <a href="<?php echo esc_url( get_permalink( $_product->id ) ); ?>"><?php echo $_product->get_image(); ?></a>
                            <?php if ( ! empty( $show_rating ) ) echo $_product->get_rating_html(); ?>
                        </div>
                        <div class="info-products">
                            <a class="product-name" href="<?php echo esc_url( get_permalink( $_product->id ) ); ?>"><?php echo $_product->get_title(); ?></a>
                            <div class="price-box">
                                <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="amount">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
                            </div>
                        </div>
					</li>
					<?php
				}
			}
		?>

	<?php else : ?>

		<li class="empty"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></li>
	<?php endif; ?>
</ul><!-- end product list -->
<p class="total pull-right"><?php _e( 'Subtotal', 'woocommerce' ); ?>:&nbsp; <?php echo WC()->cart->get_cart_subtotal(); ?></p>
<div class="clearfix"></div>
<p class="buttons">
    <a href="<?php echo WC()->cart->get_cart_url(); ?>" class="button wc-forward"><?php _e( 'View Cart', 'woocommerce' ); ?></a>
    <a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="button checkout wc-forward"><?php _e( 'Checkout', 'woocommerce' ); ?></a>
</p>
<?php do_action( 'woocommerce_after_mini_cart' ); ?>
