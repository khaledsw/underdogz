<?php global $product; ?>
<li>
    <div class="product-image">
        <a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>"><?php echo $product->get_image(); ?></a>
        <?php if ( ! empty( $show_rating ) ) echo $product->get_rating_html(); ?>
    </div>
    <div class="info-products">
        <a class="product-name" href="<?php echo esc_url( get_permalink( $product->id ) ); ?>"><?php echo $product->get_title(); ?></a>
        <div class="price-box">
            <?php echo str_replace('amount','price-box',wc_price($product->get_display_price())); ?>
        </div>
    </div>
</li>