<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package athlete
 */

if ( ! is_active_sidebar( 'sidebar-woocommerce' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-woocommerce' ); ?>
</div><!-- #secondary -->
