<!--Menu Mobile-->
<?php
    if(!has_nav_menu($athlete_cfg['theme-menu'])){
        return;
    }
?>

<div class="menu-wrap">
    <div class="main-menu">
        <h4 class="title-menu"><?php echo __('Main menu','gmswebdesign') ?></h4>
        <button class="close-button" id="close-button"><i class="fa fa-times"></i></button>
    </div>
    <?php wp_nav_menu(array(
        "container"         => "",
        'theme_location'  => $athlete_cfg['theme-menu'],
        "menu_class"         => "nav-menu",
        "walker"            => new Inwave_Nav_Mobile_Walker(),
    )); ?>
</div>