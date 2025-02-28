<body id="page-top" <?php body_class(); ?> data-offset="90" data-target=".navigation" data-spy="scroll">
<div class="wrapper hide-main-content">
    <section class="page index-store <?php echo esc_attr($athlete_cfg['page-classes']); ?>">
        <?php include(get_template_directory() . '/blocks/menu-store.php'); ?>
        <div class="content-wrapper">
            <!--Header-->
            <header id="header"
                    class="header header-container reveal <?php if ($athlete_cfg['page-classes'] != 'boxing-page') echo 'alt' ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2 col-sm-3 col-xs-3 logo">
                            <a href="<?php echo esc_url(home_url('/')); ?>"><img
                                    src="<?php echo esc_url($smof_data['store-logo']) ?>" alt="Store Logo"/></a>
                        </div>
                        <div class="col-md-10 col-sm-9 col-xs-9">
                            <button class="menu-button" id="open-button"></button>
                        </div>
                    </div>
                </div>
            </header>
            <!--End Header-->
            <?php if($smof_data['woocommerce_cart_top_nav'] && is_active_sidebar( 'sidebar-cart' )):  ?>
            <div class="cart-wishlist">
                <div class="cart-store">
                    <div class="icon-cart">
                        <div class="my-cart">
                            <button class="icon-fa"><i class="fa fa-shopping-cart"></i></button>
                        </div>
                        <div class="carts-store">
                            <div class="bag-cart product-popular">
                                <?php
                                    dynamic_sidebar( 'sidebar-cart' );
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>