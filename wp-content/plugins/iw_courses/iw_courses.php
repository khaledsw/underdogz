<?php
/*
  Plugin Name: Courses Manager
  Plugin URI: http://courses.gmswebdesign.com
  Description: Courses and teachers manager
  Version: 1.3.0
  Author: gmswebdesign
  Author URI: http://www.gmswebdesign.com
  License: GNU General Public License v2 or later
 */

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Flushes rewrite rules on plugin activation to ensure custom posts don't 404.
 *
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
 */
defined('ABSPATH') or die();

// translate plugin
add_action('plugins_loaded', 'iw_course_load_textdomain');
function iw_course_load_textdomain() {
	load_plugin_textdomain( 'gmswebdesign', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
} 

//start session
if(session_id() == ''){session_start();}

include_once 'includes/functions.admin.php';
include_once 'includes/functions.front.php';


register_activation_hook(__FILE__, 'iw_courses_install');
register_uninstall_hook(__FILE__, 'iw_courses_uninstall');

add_action('init', 'iw_courses_add_post_types_courses');
add_action('init', 'iw_courses_add_post_types_teacher');

add_action('init', 'iw_courses_add_taxonomy_class');

if (is_admin()) {
    add_action('load-post.php', 'addTeacherBox');
    add_action('load-post-new.php', 'addTeacherBox');
    add_action('load-post.php', 'addCoursesBox');
    add_action('load-post-new.php', 'addCoursesBox');
    add_action('delete_post', 'iwc_post_delete', 10);
}

// Add the fields to the "Class" taxonomy, using our callback function  
add_action('iw_courses_class_add_form_fields', 'class_metabox_add', 10, 1);
add_action('iw_courses_class_edit_form_fields', 'class_metabox_edit', 10, 2);

// Save the changes made on the "Class" taxonomy, using our callback function  
add_action('edited_iw_courses_class', 'save_class_taxonomy_iw_courses', 10, 2);
add_action('created_iw_courses_class', 'save_class_taxonomy_iw_courses', 10, 2);

// Add the fields to the "Teacher" taxonomy, using our callback function  
add_action('iw_courses-teacher_add_form_fields', 'teacher_metabox_add', 10, 1);
add_action('iw_courses-teacher_edit_form_fields', 'teacher_metabox_edit', 10, 2);

// Save the changes made on the "Teacher" taxonomy, using our callback function  
add_action('edited_iw_courses-teacher', 'save_class_taxonomy_iw_courses', 10, 2);
add_action('created_iw_courses-teacher', 'save_class_taxonomy_iw_courses', 10, 2);

add_action('init', 'iwcAddImageSize');


add_action('admin_enqueue_scripts', 'adminAddScript');

function extrafield_screen_add_option() {
    $option = 'per_page';

    $args = array(
        'label' => 'Movies',
        'default' => 10,
        'option' => 'iw_courses_per_page'
    );

    add_screen_option($option, $args);
}

function iwcAddAdminMenu() {
    add_options_page(__('IWC Settings', 'gmswebdesign'), __('IWC Settings', 'gmswebdesign'), 'manage_options', 'iw_courses_settings', 'optionRenderPage');
    add_submenu_page('edit.php?post_type=iw_courses', __('Extra Fields', 'gmswebdesign'), __('Extra Fields', 'gmswebdesign'), 'manage_options', 'extra-field', 'iwcExtrafieldRenderPage');
    add_submenu_page(null, null, __('Add Extra Field', 'gmswebdesign'), 'manage_options', 'add-extra-field', 'iwcAddExtrafieldRenderPage');
    add_submenu_page('edit.php?post_type=iw_courses', __('Teachers', 'gmswebdesign'), __('Teachers', 'gmswebdesign'), 'manage_options', 'edit.php?post_type=iw_teacher');
    add_submenu_page('edit.php?post_type=iw_courses', __('IWC Settings', 'gmswebdesign'), __('Settings', 'gmswebdesign'), 'manage_options', 'settings', 'optionRenderPage');
}

add_action('admin_menu', 'iwcAddAdminMenu');

add_action('admin_post_iw_courses_setting', 'saveSetting');
add_action('admin_post_iw_courses_extrafield', 'saveExtraField');
add_action('admin_post_iw_courses_extrafields_delete', 'deleteExtraFields');
add_action('admin_post_delete_extrafield', 'deleteExtraField');


/**
 * Add sort page.
 * 
 * @since 1.0.0
 */
add_action('wp_ajax_iw_courses_sort', 'iw_courses_sort');



/* ----------------------------------------------------------------------------------
  FRONTEND FUNCTIONS
  ---------------------------------------------------------------------------------- */

/**
 * Register and enqueue scripts and styles for frontend.
 *
 * @since 1.0.0
 */
function iw_courses_front_scripts_styles() {
    /* Scripts */
    wp_enqueue_script('jquery');
    wp_enqueue_style('iwc-css', plugin_dir_url(__FILE__) . 'assets/css/iw_courses_style.css');
    wp_enqueue_style('fancybox-css', plugin_dir_url(__FILE__) . 'assets/lib/fancyBox/source/jquery.fancybox.css');
    wp_enqueue_script('fancybox-js', plugin_dir_url(__FILE__) . 'assets/lib/fancyBox/source/jquery.fancybox.js');
    wp_register_script('iwc-js', plugin_dir_url(__FILE__) . 'assets/js/iw_courses_js.js', array(), '1.0.0', true);
    wp_localize_script('iwc-js', 'iwcCfg', array('siteUrl' => admin_url(), 'baseUrl' => site_url(), 'ajaxUrl' => admin_url('admin-ajax.php')));

    /* Styles */
}

add_action('wp_enqueue_scripts', 'iw_courses_front_scripts_styles');

/**
 * Set excerpt length.
 *
 * @since 1.0.0
 */
function iw_courses_excerpt_length($length) {

    global $post;

    if ($post->post_type == 'iw_courses')
        return 20;
    else
        return $length;
}

add_filter('excerpt_length', 'iw_courses_excerpt_length');

/**
 * Set excerpt more.
 */
function iw_courses_excerpt_more($more) {
    global $post;

    if ($post->post_type == 'iw_courses')
        return ' ...';
    else
        return $more;
}

add_filter('excerpt_more', 'iw_courses_excerpt_more');

// Add Shortcode
function iw_courses_list_shortcode($atts) {
    $bt_options = get_option('iw_courses_settings');
    // Attributes
    extract(shortcode_atts(
                    array(
        'theme' => ($bt_options['theme']) ? $bt_options['theme'] : 'default',
        'cats' => '0',
        'item_per_page' => $bt_options['port_limit'] ? $bt_options['port_limit'] : '6',
        'show_filter_bar' => isset($bt_options['show_category_menu']) && $bt_options['show_category_menu'] ? $bt_options['show_category_menu'] : '1'
                    ), $atts)
    );

    // Code
    return iwcCoursesListHtmlPage($theme, $cats, $item_per_page, $show_filter_bar);
}

// Add Shortcode
function iw_courses_list__teacher_shortcode($atts) {
    $bt_options = get_option('iw_courses_settings');
    // Attributes
    extract(shortcode_atts(
                    array(
        'theme' => ($bt_options['theme']) ? $bt_options['theme'] : 'default',
        'item_per_page' => $bt_options['port_limit'] ? $bt_options['port_limit'] : '6'
                    ), $atts)
    );

    // Code
    return iwcTeacherListHtmlPage($theme, $item_per_page);
}

add_shortcode('iw_courses_list', 'iw_courses_list_shortcode');
add_shortcode('iw_courses_list_teacher', 'iw_courses_list__teacher_shortcode');

/**
 * Make embeds more generic by setting parameters to remove
 * related videos, set neutral colors, reduce branding, etc.
 *
 * @since 1.0.0
 * @link http://marquex.es/763/removing-youtube-embed-title-in-wordpress-automatically
 *
 * @param string $embed Embed HTML code
 * @return string Modified embed HTML code
 */
function iw_courses_generic_embeds($embed) {

// YouTube
    if (strpos($embed, 'youtu.be') !== false || strpos($embed, 'youtube.com') !== false) {

        return preg_replace("@src=(['\"])?([^'\">\s]*)@", "src=$1$2&showinfo=0&rel=0&hd=1", $embed);
    }
// Vimeo
    elseif (strpos($embed, 'vimeo.com') !== false) {

        return preg_replace("@src=(['\"])?([^'\">\s]*)@", "src=$1$2?title=0&byline=0", $embed);
    }
    return $embed;
}

add_filter('embed_oembed_html', 'iw_courses_generic_embeds');


//add ajax action iwcLoadCoursesPosts
add_action('wp_ajax_nopriv_iwcLoadCoursesPosts', 'iwcLoadCoursesPosts');
add_action('wp_ajax_iwcLoadCoursesPosts', 'iwcLoadCoursesPosts');


