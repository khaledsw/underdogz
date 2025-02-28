<?php
/*
  Plugin Name: IW Visual Composer Addons
  Plugin URI: http://inwavethemes.com
  Description: Includes advanced addon elements for Visual Composer
  Version: 1.3.0
  Author: Inwavethemes
  Author URI: http://www.inwavethemes.com
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
add_action('plugins_loaded', 'iw_composer_load_textdomain');
function iw_composer_load_textdomain() {
	load_plugin_textdomain( 'inwavethemes', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
} 

class InwaveVC_Support {

    // declare custom shortcodes
    private $shortCodes;

    function __construct() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
		if(is_plugin_active('js_composer/js_composer.php')){
			require_once(WP_PLUGIN_DIR.'/js_composer/include/classes/shortcodes/shortcodes.php');
		}else{
			return;
		}

        $this->shortCodes = array(
            'infor_banner',
            'infor_list',
            'heading',
            'navigation',
            'history',
            'price_box',
            'faq',
            'product_list',
            'tabs',
            'opening_hours',
            'events',
            'wp_posts',
            'ethlete_facts',
            'courses_list',
            'athlete_map',
            'iw_contact',
            'layers_effect',
            'countdown',
            'courses'
        );

        add_action('init', array($this, 'addParamsForRow'));
        add_action('admin_init', array($this, 'generate_shortcode_params'));

        add_action('admin_enqueue_scripts', array($this, 'athlete_scripts_admin'));
        add_action('wp_enqueue_scripts', array($this, 'athlete_scripts'));

        // include shortcodes
        foreach ($this->shortCodes as $shortCode) {
            include_once(dirname(__FILE__) . '/shortcodes/' . $shortCode . '.php');
        }
    }

    function generate_shortcode_params() {
        /* Generate param type "iwicon" */
        if (function_exists('add_shortcode_param')) {
            add_shortcode_param('iwicon', array($this, 'iwicon'));
        }

        /* Generate param type "courses_categories" */
        if (function_exists('add_shortcode_param')) {
            add_shortcode_param('courses_categories', array($this, 'iwcourses_categories'));
        }
    }

    /* add parameter for rows */

    function addParamsForRow() {
        // init new params
        $newParams = array(array(
                "type" => "dropdown",
                "group" => "Inwavethemes",
                "class" => "",
                "heading" => "Add Container",
                "param_name" => "add_container",
                "value" => array(
                    "No" => "0",
                    "Yes" => "1"
                )
            ), array(
                "type" => "dropdown",
                "group" => "Inwavethemes",
                "class" => "",
                "heading" => "Remove Default Class",
                "param_name" => "no_default_class",
                "value" => array(
                    "No" => "0",
                    "Yes" => "1"
                )
            ), array(
                "type" => "textfield",
                "group" => "Inwavethemes",
                "class" => "",
                "heading" => "Row ID",
                "param_name" => "row_id"
            )
        );

        // add to row
        vc_add_params("vc_row", $newParams);
        // add to inner row
        vc_add_params("vc_row_inner", $newParams);
    }

    function iwicon($settings, $value) {
        $font_data = 'adjust;anchor;archive;area-chart;arrows;arrows-h;arrows-v;asterisk;at;automobile;ban;bank;bar-chart;bar-chart-o;barcode;bars;bed;beer;bell;bell-o;bell-slash;bell-slash-o;bicycle;binoculars;birthday-cake;bolt;bomb;book;bookmark;bookmark-o;briefcase;bug;building;building-o;bullhorn;bullseye;bus;cab;calculator;calendar;calendar-o;camera;camera-retro;car;caret-square-o-down;caret-square-o-left;caret-square-o-right;caret-square-o-up;cart-arrow-down;cart-plus;cc;certificate;check;check-circle;check-circle-o;check-square;check-square-o;child;circle;circle-o;circle-o-notch;circle-thin;clock-o;close;cloud;cloud-download;cloud-upload;code;code-fork;coffee;cog;cogs;comment;comment-o;comments;comments-o;compass;copyright;credit-card;crop;crosshairs;cube;cubes;cutlery;dashboard;database;desktop;diamond;dot-circle-o;download;edit;ellipsis-h;ellipsis-v;envelope;envelope-o;envelope-square;eraser;exchange;exclamation;exclamation-circle;exclamation-triangle;external-link;external-link-square;eye;eye-slash;eyedropper;fax;female;fighter-jet;file-archive-o;file-audio-o;file-code-o;file-excel-o;file-image-o;file-movie-o;file-pdf-o;file-photo-o;file-picture-o;file-powerpoint-o;file-sound-o;file-video-o;file-word-o;file-zip-o;film;filter;fire;fire-extinguisher;flag;flag-checkered;flag-o;flash;flask;folder;folder-o;folder-open;folder-open-o;frown-o;futbol-o;gamepad;gavel;gear;gears;genderless;gift;glass;globe;graduation-cap;group;hdd-o;headphones;heart;heart-o;heartbeat;history;home;hotel;image;inbox;info;info-circle;institution;key;keyboard-o;language;laptop;leaf;legal;lemon-o;level-down;level-up;life-bouy;life-buoy;life-ring;life-saver;lightbulb-o;line-chart;location-arrow;lock;magic;magnet;mail-forward;mail-reply;mail-reply-all;male;map-marker;meh-o;microphone;microphone-slash;minus;minus-circle;minus-square;minus-square-o;mobile;mobile-phone;money;moon-o;mortar-board;motorcycle;music;navicon;newspaper-o;paint-brush;paper-plane;paper-plane-o;paw;pencil;pencil-square;pencil-square-o;phone;phone-square;photo;picture-o;pie-chart;plane;plug;plus;plus-circle;plus-square;plus-square-o;power-off;print;puzzle-piece;qrcode;question;question-circle;quote-left;quote-right;random;recycle;refresh;remove;reorder;reply;reply-all;retweet;road;rocket;rss;rss-square;search;search-minus;search-plus;send;send-o;server;share;share-alt;share-alt-square;share-square;share-square-o;shield;ship;shopping-cart;sign-in;sign-out;signal;sitemap;sliders;smile-o;soccer-ball-o;sort;sort-alpha-asc;sort-alpha-desc;sort-amount-asc;sort-amount-desc;sort-asc;sort-desc;sort-down;sort-numeric-asc;sort-numeric-desc;sort-up;space-shuttle;spinner;spoon;square;square-o;star;star-half;star-half-empty;star-half-full;star-half-o;star-o;street-view;suitcase;sun-o;support;tablet;tachometer;tag;tags;tasks;taxi;terminal;thumb-tack;thumbs-down;thumbs-o-down;thumbs-o-up;thumbs-up;ticket;times;times-circle;times-circle-o;tint;toggle-down;toggle-left;toggle-off;toggle-on;toggle-right;toggle-up;trash;trash-o;tree;trophy;truck;tty;umbrella;university;unlock;unlock-alt;unsorted;upload;user;user-plus;user-secret;user-times;users;video-camera;volume-down;volume-off;volume-up;warning;wheelchair;wifi;wrench';
        $fontArray = explode(';', $font_data);
        $name = $settings['param_name'] ? $settings['param_name'] : '';
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = $settings['class'] ? $settings['class'] : '';
//            $class .= implode(' ', $settings['vc_single_param_edit_holder_class']);
        $class .= ' wpb_vc_param_value ' . $name . " " . $type;
        ob_start();
        ?>
        <div class="control-icon" onclick="jQuery('.iw-list-icon-wrap').slideToggle();">
            <div class="icon-preview">
                <i class="fa fa-<?php echo $value; ?>"></i>
            </div>
            <div class="icon-filter">
                <input class="filter-input" placeholder="<?php echo __('Click to select new or search...', 'inwavethemes'); ?>" type="text"/>
            </div>
        </div>
        <div style="clear:both;"></div>
        <div class="iw-list-icon-wrap" style="display:none;">
		<input name="<?php echo $name; ?>" type="text" placeholder="<?php echo __('Input font Awesome name exclude \'fa-\', Ex: desktop, diamond...', 'inwavethemes'); ?>" value="<?php echo $value; ?>" class="iw-icon-input-cs <?php echo $class; ?>">
        <ul id="iw-list-icon" class="list-icon">
            <?php
            foreach ($fontArray as $icon) {
                echo '<li class="icon-item ' . ($icon == $value ? 'selected' : '') . '" data-icon="' . $icon . '" title="' . $icon . '"><span class="icon"><i class="fa fa-' . $icon . '"></i></span></li>';
            }
            ?>
        </ul>
		</div>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                var icons = <?php echo json_encode($fontArray); ?>;
                jQuery('.icon-filter .filter-input').on('input', function () {
                    var filterVal = jQuery(this).val();
                    var newIcons = jQuery.grep(icons, function (value, i) {
                        return (value.indexOf(filterVal) == 0);
                    });
                    var html = '', iconLength = newIcons.length, value = jQuery('input[name="<?php echo $name; ?>"]').val();

                    for (var i = 0; i < iconLength; i++) {
                        var icon = newIcons[i];
                        html += '<li class="icon-item ' + (icon == value ? 'selected' : '') + '" data-icon="' + icon + '" title="' + icon + '"><span class="icon"><i class="fa fa-' + icon + '"></i></span></li>';
                    }
                    jQuery('#iw-list-icon').html(html);
                });
                jQuery('.icon-item').live('click', function () {
                    var value = jQuery(this).data('icon');
                    var html = '<i class="fa fa-' + value + '"></i>';
                    jQuery('.control-icon .icon-preview').html(html);
                    jQuery('input[name="<?php echo $name; ?>"]').val(value);
                    jQuery('.icon-item').removeClass('selected');
                    jQuery(this).addClass('selected');
					jQuery('.iw-list-icon-wrap').slideUp();
                });
				jQuery('.iw-icon-input-cs').live('change',function(){
					var value = jQuery(this).val();
                    var html = '<i class="fa fa-' + value + '"></i>';
                    jQuery('.control-icon .icon-preview').html('').html(html);
				})
            });
        </script>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function athlete_scripts() {
        $theme_info = wp_get_theme();
        wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css', array(), $theme_info->get('Version'));
        wp_enqueue_style('iwicon', get_template_directory_uri() . '/css/iwicon.css', array(), $theme_info->get('Version'));
    }

    function athlete_scripts_admin() {
        $theme_info = wp_get_theme();
        wp_deregister_style('font-awesome');
		wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css', array(), $theme_info->get('Version'));
        wp_enqueue_style('iwicon', get_template_directory_uri() . '/css/iwicon.css', array(), $theme_info->get('Version'));
        wp_enqueue_script('select2-script', get_template_directory_uri() . '/js/select2.min.js', array('jquery'), $theme_info->get('Version'), true);
        wp_enqueue_style('select2-style', get_template_directory_uri() . '/css/select2.min.css', array(), $theme_info->get('Version'));
    }

    function iwcourses_categories($settings, $value) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = isset($settings['class']) ? $settings['class'] : '';
        $product_categories = get_terms('iw_courses_class');
        $output = $selected = $ids = '';
        if ($value !== '') {
            $ids = explode(',', $value);
            $ids = array_map('trim', $ids);
        } else {
            $ids = array();
        }
        $output .= '<select id="sel2_cat" multiple="multiple" style="min-width:200px;">';
        foreach ($product_categories as $cat) {
            if (in_array($cat->term_id, $ids)) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $output .= '<option ' . $selected . ' value="' . $cat->term_id . '">' . $cat->name . '</option>';
        }
        $output .= '</select>';

        $output .= "<input type='hidden' name='" . $param_name . "' value='" . $value . "' class='wpb_vc_param_value " . $param_name . " " . $type . " " . $class . "' id='sel_cat'>";
        $output .= '<script type="text/javascript">
							jQuery("#sel2_cat").select2({
								placeholder: "Select Categories",
								allowClear: true
							});
							jQuery("#sel2_cat").on("change",function(){
								jQuery("#sel_cat").val(jQuery(this).val());
							});
						</script>';
        return $output;
    }

}

new InwaveVC_Support();