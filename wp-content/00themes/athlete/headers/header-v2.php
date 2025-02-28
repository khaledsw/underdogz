<body id="page-top" <?php body_class(); ?> data-offset="90" data-target=".navigation" data-spy="scroll">
<div class="wrapper hide-main-content">
    <section class="page cms-home header-option <?php echo esc_attr($athlete_cfg['page-classes']);?>">
        <?php include(get_template_directory() . '/blocks/menu-mobile.php'); ?>
        <div class="content-wrapper">
<!--Header-->
<header id="header" class="header header-container header-container-3 alt reveal">
    <div class="top-links">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <div class="top-link">
                        <?php if($smof_data['contactinfo']){
                            $smof_data['contactinfo'] = explode("|",$smof_data['contactinfo']);
                            if(isset($smof_data['contactinfo'][0])){
                                echo '<span class="address-top"><i class="fa fa-map-marker "></i>'.esc_html($smof_data['contactinfo'][0]).'</span>';
                            }
                            if(isset($smof_data['contactinfo'][1])){
                                echo '<span class="call-top"><i class="fa fa-phone"></i>'.esc_html($smof_data['contactinfo'][1]).'</span>';
                            }
                        } ?>
                    </div>
                </div>
                <?php include(get_template_directory() . '/blocks/quick-access.php'); ?>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-3 col-xs-3 logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($smof_data['logo']) ?>" alt="Logo"/></a>
            </div>
            <div class="col-md-9 nav-container">
                <?php include(get_template_directory() . '/blocks/menu-desktop.php'); ?>
            </div>
            <button class="menu-button" id="open-button"></button>
        </div>
    </div>
</header>
<!--End Header-->