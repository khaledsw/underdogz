<?php
/*
  Plugin Name: Advanced Parallax Background
  Plugin URI: http://apbackground.gmswebdesign.com
  Description: AP Background is a responsive WordPress advanced parallax background plugin. It allows users to easily create background blocks with parallax effect of background and content (Image & video gallery, WordPress posts and Woo Commerce). AP Background makes your site be impressive and professional.
  Version: 1.3
  Author: gmswebdesign
  Author URI: http://www.gmswebdesign.com
  License: GNU General Public License v2 or later
 */

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

defined('ABSPATH') or die();

// translate plugin
add_action('plugins_loaded', 'ap_bg_load_textdomain');
function ap_bg_load_textdomain() {
	load_plugin_textdomain( 'gmswebdesign', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
} 

if (!session_id()) {
    session_start();
}

include_once 'includes/functions.admin.php';
include_once 'includes/functions.front.php';
include_once 'includes/shortCodeClass.php';


register_activation_hook(__FILE__, 'ap_background_install');
register_uninstall_hook(__FILE__, 'ap_background_uninstall');

//Add plugin menu to admin sidebar
function btParallaxBackgroundAddAdminMenu() {
    add_object_page(__('BT Advanced Parallax Background', 'gmswebdesign'), __('AP Background', 'gmswebdesign'), 'manage_options', 'bt-advance-parallax-background', 'pluginIndexRenderPage', plugins_url('assets/images/ap_icon.png',__FILE__));
    add_submenu_page(NULL, __('Add new', 'gmswebdesign'),NULL, 'manage_options', 'bt-advance-parallax-background/create-new', 'pluginAddnewRenderPage');
}

//Add editer bt parallax background button
add_action('admin_init', 'btAddButton');

//Add BT Parallax Background button to Visual Composer
add_action('init','addVisualComposerButton');

//Add parralax menu
add_action('admin_menu', 'btParallaxBackgroundAddAdminMenu');

//add script for admin page
add_action('admin_enqueue_scripts', 'advParallaxBackAdminAddScript');

//Post action save slider || save and close
add_action('admin_post_bt_advParallaxBackAdminSaveSlider', 'advParallaxBackAdminSaveSlider', 10, FALSE);

//add ajax action
add_action('wp_ajax_nopriv_getFlickrAlbums', 'getFlickrAlbums');
add_action('wp_ajax_getFlickrAlbums', 'getFlickrAlbums');

//add ajax action get video ids from url
add_action('wp_ajax_nopriv_getVideoFromUrl', 'getVideoFromUrl');
add_action('wp_ajax_getVideoFromUrl', 'getVideoFromUrl');

//add ajax action get video from url
add_action('wp_ajax_nopriv_getVideo', 'getVideo');
add_action('wp_ajax_getVideo', 'getVideo');

//add ajax action get Images from username
add_action('wp_ajax_nopriv_getImages', 'getImages');
add_action('wp_ajax_getImages', 'getImages');

//add ajax action get Image by id
add_action('wp_ajax_nopriv_getImage', 'getImage');
add_action('wp_ajax_getImage', 'getImage');

//add ajax action get Image Albums by id
add_action('wp_ajax_nopriv_getImageAlbums', 'getImageAlbums');
add_action('wp_ajax_getImageAlbums', 'getImageAlbums');

//add ajax action listDeleteSingleItem
add_action('wp_ajax_nopriv_listDeleteSingleItem', 'listDeleteSingleItem');
add_action('wp_ajax_listDeleteSingleItem', 'listDeleteSingleItem');

//add ajax action listDeleteSelectedItem
add_action('wp_ajax_nopriv_listDeleteSelectedItem', 'listDeleteSelectedItem');
add_action('wp_ajax_listDeleteSelectedItem', 'listDeleteSelectedItem');

//add ajax action listCopyItem
add_action('wp_ajax_nopriv_listCopyItem', 'listCopyItem');
add_action('wp_ajax_listCopyItem', 'listCopyItem');

//add ajax action getVideobackground
add_action('wp_ajax_nopriv_getVideobackground', 'getVideobackground');
add_action('wp_ajax_getVideobackground', 'getVideobackground');

//add ajax action getVideobackground
//add_action('wp_ajax_nopriv_editVideoAjax', 'editVideoAjax');
//add_action('wp_ajax_editVideoAjax', 'editVideoAjax');

//add ajax action loadContentEffectCssAjax
add_action('wp_ajax_nopriv_loadContentEffectCssAjax', 'loadContentEffectCssAjax');
add_action('wp_ajax_loadContentEffectCssAjax', 'loadContentEffectCssAjax');

//add ajax action parallaxItemPreview
add_action('wp_ajax_nopriv_parallaxItemPreview', 'parallaxItemPreview');
add_action('wp_ajax_parallaxItemPreview', 'parallaxItemPreview');


/* ----------------------------------------------------------------------------------
  FRONTEND FUNCTIONS
  ---------------------------------------------------------------------------------- */

/**
 * Register and enqueue scripts and styles for frontend.
 *
 * @since 1.0.0
 */

//Add site script
add_action('wp_enqueue_scripts', 'adv_parallax_add_site_script');

// Add Shortcode
//add_shortcode( 'adv_parallax_back', 'generateParallaxBackground');
$s = new shortCodeClass();

//add ajax action loadContentEffectCssAjax
add_action('wp_ajax_nopriv_loadParallaxFrameContent', 'loadParallaxFrameContent');
add_action('wp_ajax_loadParallaxFrameContent', 'loadParallaxFrameContent');