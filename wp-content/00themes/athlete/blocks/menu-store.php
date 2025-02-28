<!--Menu Store-->
<?php
    if(!has_nav_menu($athlete_cfg['theme-menu'])){
        return;
    }
?>
<div class="menu-wrap menu-store">
    <div class="main-menu container">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-3 logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($smof_data['store-logo']) ?>" alt="Store Logo"/></a>
            </div>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <button class="close-button" id="close-button"><i class="fa fa-times"></i></button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
    <?php wp_nav_menu(array(
        "container"         => "",
        'theme_location'  => $athlete_cfg['theme-menu'],
        "menu_class"         => "nav-menu nav-store",
        "walker"            => new Inwave_Nav_Mobile_Walker(),
    )); ?>
        </div>
    </div>
</div>