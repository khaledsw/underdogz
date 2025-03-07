<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="product-check-out ">
<div class="checkout">
    <div class="row">
<?php
wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php //do_action( 'woocommerce_checkout_before_customer_details' ); ?>
		<div class="" id="customer_details">
            <?php
            if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
                ?>
                <div class="checkout-row col-md-6 pull-left">
                    <?php do_action( 'woocommerce_checkout_billing' ); ?>
                </div>
				<!--
                <div class="checkout-row col-md-6 pull-right">
                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                </div>
				-->
            <?php
            }else{
                ?>
				<!--
                <div class="checkout-row col-md-6 pull-right">
                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                </div>
				-->
                <div class="checkout-row col-md-6 pull-left">
                    <?php do_action( 'woocommerce_checkout_billing' ); ?>
                </div>

            <?php
            }
            ?>


		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>


	<?php endif; ?>


	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
        <div class="checkout-row col-md-6 pull-left">
            <div id="order_review_heading" class="title"><?php _e( 'Your order', 'woocommerce' ); ?><i class="fa fa-minus-square-o"></i></div>
            <div class="box">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
            </div>
        </div>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
</div>
</div>
</div>