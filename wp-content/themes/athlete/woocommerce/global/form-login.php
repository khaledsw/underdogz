<?php
/**
 * Login form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( is_user_logged_in() ) {
	return;
}

?>
<div class="checkout-row col-md-6 pull-left">
    <div class="title"><?php esc_attr_e('Login', 'woocommerce'); ?><i class="fa fa-minus-square-o"></i></div>
    <div class="box">
<form method="post">

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php if ( $message ) echo wpautop( wptexturize( $message ) ); ?>
    <div class="row">
    <div class="col-md-6">


    <input type="text" class="input-text"  placeholder="<?php esc_attr_e( 'Username or email', 'woocommerce' ); ?>" name="username" id="username" />

    </div><div class="col-md-6"><input class="input-text" type="password" name="password" id="password" placeholder="<?php esc_attr_e( 'Password', 'woocommerce' ); ?>" />

    </div>
    </div>
        <div class="clear"></div>

	<?php do_action( 'woocommerce_login_form' ); ?>

	<div class="form-row">
		<?php wp_nonce_field( 'woocommerce-login' ); ?>
		<button type="submit" class="button" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>"><em class="fa-icon"><i class="fa fa-unlock"></i></em><?php _e( 'Login', 'woocommerce' ); ?></button>
		<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
		<label for="rememberme" class="inline">
			<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
		</label>
	</div>
	<div class="lost_password">
		<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
	</div>

	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
        </div>
        </div>
