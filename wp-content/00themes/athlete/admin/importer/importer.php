<?php
/**
 * athlete import demo data content
 *
 * @package athlete
 */
defined( 'ABSPATH' ) or die( 'You cannot access this script directly' );
// Sample Data Importer

// Hook importer into admin init
add_action( 'admin_init', 'athlete_importer' );
function athlete_importer() {
	WP_Filesystem();
    global $wpdb,$wp_filesystem;

    if ( current_user_can( 'manage_options' ) && isset( $_GET['import_data_content'] ) ) {
        if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true); // we are loading importers

        if ( ! class_exists( 'WP_Importer' ) ) { // if main importer class doesn't exist
            include ABSPATH . 'wp-admin/includes/class-wp-importer.php';
        }

        if ( ! class_exists('WP_Import') ) { // if WP importer doesn't exist
            include get_template_directory() . '/admin/importer/wordpress-importer.php';
        }

        if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) { // check for main import class and wp import class

			//update option before importing
			if( class_exists('Woocommerce') ) {
				//update_option('shop_thumbnail_image_size',array('width'=>230,'height'=>230,'crop'=>1));
				update_option('yith_wcmg_zoom_position','inside');
			}

            $importer = new WP_Import();

            /* First Import Posts, Pages, Portfolio Content, FAQ, Images, Menus */
            $theme_xml = get_template_directory() . '/admin/importer/data/athlete.xml';

            $importer->fetch_attachments = true;
            ob_start();
            $importer->import($theme_xml);
            ob_end_clean();

            // Import Theme Options
            $theme_options_txt = get_template_directory() . '/admin/importer/data/theme_options.txt'; // theme options data file
            $theme_options_txt = $wp_filesystem->get_contents( $theme_options_txt );
            $data = unserialize( base64_decode( $theme_options_txt));  /* decode theme options data */

            of_save_options($data); // update theme options

            if( class_exists('Woocommerce') ) {
                // Set pages
                $woopages = array(
                    'woocommerce_shop_page_id' => 'Shop',
                    'woocommerce_cart_page_id' => 'Cart',
                    'woocommerce_checkout_page_id' => 'Checkout',
                    'woocommerce_pay_page_id' => 'Checkout &#8594; Pay',
                    'woocommerce_thanks_page_id' => 'Order Received',
                    'woocommerce_myaccount_page_id' => 'My Account',
                    'woocommerce_edit_address_page_id' => 'Edit My Address',
                    'woocommerce_view_order_page_id' => 'View Order',
                    'woocommerce_change_password_page_id' => 'Change Password',
                    'woocommerce_logout_page_id' => 'Logout',
                    'woocommerce_lost_password_page_id' => 'Lost Password'
                );
                foreach($woopages as $woo_page_name => $woo_page_title) {
                    $woopage = get_page_by_title( $woo_page_title );
                    if(isset($woopage->ID) && $woopage->ID) {
                        update_option($woo_page_name, $woopage->ID); // Front Page
                    }
                }

                // We no longer need to install pages
                delete_option( '_wc_needs_pages' );
                delete_transient( '_wc_activation_redirect' );

                // Flush rules after install
                flush_rewrite_rules();
            }



            // Set imported menus to registered theme locations
            $locations = get_theme_mod( 'nav_menu_locations' ); // registered menu locations in theme
            $menus = wp_get_nav_menus(); // registered menus

            if($menus) {
                foreach($menus as $menu) { // assign menus to theme locations
                    if( $menu->name == 'Main Menu' ) {
                        $locations['primary'] = $menu->term_id;
                    }
                    if( $menu->name == 'OnePage' ) {
                        $locations['onepage'] = $menu->term_id;
                    }
                }
            }

            set_theme_mod( 'nav_menu_locations', $locations ); // set menus to locations


            // Set reading options
            $homepage = get_page_by_title( 'Homepage' );
            if($homepage->ID) {
                update_option('show_on_front', 'page');
                update_option('page_on_front', $homepage->ID); // Front Page
            }

            //update wrong url in metadata:
            $wpdb->query($wpdb->prepare("update wp_postmeta set meta_value = replace(meta_value,'http://inwavethemes.com/demo-images/athlete/wp-content','%s')",content_url()));


            // Add sidebar widget areas
            $sidebars = array(
                'sidebar-default' => 'Sidebar Default',
                'sidebar-woocommerce' => 'Sidebar Product Page',
                'sidebar-cart' => 'Slidebar Cart',
                'sidebar-eventon' => 'Sidebar Eventon',
                'sidebar-footer1' => 'Sidebar Footer Default',
                'sidebar-footer2' => 'Sidebar Footer Store'
            );
            update_option( 'sbg_sidebars', $sidebars );

            iwMainClass::widgets_init();

            // Add data to widgets
            $widgets_json = get_template_directory() . '/admin/importer/data/widget_data.json'; // widgets data file
            $widget_data = $wp_filesystem->get_contents( $widgets_json ); 
            athlete_import_widget_data( $widget_data );

            // import master slider
            if( class_exists('MSP_Importer') ) {
                $ms_importer = new MSP_Importer();
                $sliderdata = get_template_directory() . '/admin/importer/data/masterslider.json';

                $sliderdata = $wp_filesystem->get_contents( $sliderdata );
                $export_array =  $ms_importer->decode_import_data( $sliderdata);

                $ms_importer->last_new_slider_id = null;

                if( isset( $export_array['preset_styles'] ) && ! empty( $export_array['preset_styles'] ) ) {
                    msp_update_option( 'preset_style'  , $export_array['preset_styles'] );
                }
                if( isset( $export_array['preset_effects'] ) && ! empty( $export_array['preset_effects'] ) ) {
                    msp_update_option( 'preset_effect'  , $export_array['preset_effects'] );
                }
                global $mspdb,$wpdb;
                $table_name = $wpdb->prefix . "postmeta";
                foreach ( $export_array['sliders_data'] as $slider_id => $slider_fields ) {
                    $slider_fields['status'] = current_user_can( 'publish_masterslider' ) ? 'published' : 'draft';
                    $new_slider_id = $mspdb->add_slider( $slider_fields );
                    $wpdb->update($table_name, array('meta_value'=> intval($new_slider_id)), array('meta_key' =>'inwave_masterslider', 'meta_value'=>intval($slider_id)));

                    msp_update_slider_custom_css_and_fonts( $new_slider_id );
                }

                $uploads   = wp_upload_dir();
                $css_dir   = apply_filters( 'masterslider_custom_css_dir', $uploads['basedir'] . '/' . MSWP_SLUG );
                $css_file  = $css_dir . '/custom.css';
                @unlink($css_file);
                msp_save_custom_styles();

                // Import advanced background
                $apb_data = get_template_directory() . '/admin/importer/data/apbackground.json';
                $apb_data = $wp_filesystem->get_contents( $apb_data );
                $export_array =  $ms_importer->decode_import_data( $apb_data);
                foreach ( $export_array as $item ) {
                    $wpdb->insert($wpdb->prefix.'ap_background', $item);
                }

                // Import inwave courses
                $iw_data = get_template_directory() . '/admin/importer/data/iwcourse.json';
                $iw_data = $wp_filesystem->get_contents( $iw_data );
                $export_array =  $ms_importer->decode_import_data( $iw_data);
                foreach ( $export_array as $table => $list ) {
                    foreach($list as $item) {
                        switch($table){

                            case 'iw_courses_extrafields_category':
                                if($item['category_alias']){
                                    $category = get_term_by('slug', $item['category_alias'], 'iw_courses_class');
                                    $catid = $category->term_id;
                                }else{
                                    $catid = 0;
                                }
                                unset($item['category_alias']);
                                $item['category_id'] = $catid;
								$wpdb->insert($wpdb->prefix . $table, $item);
                                break;
                            case 'iw_courses_extrafields_value':
                                $courseid = '';
                                if($item['couser_slug']){
                                    $course = $posts = get_posts(array(
                                        'name' => $item['couser_slug'],
                                        'posts_per_page' => 1,
                                        'post_type' => 'iw_courses'
                                    ));
                                    $courseid = $course[0]->ID;

                                }
                                if($courseid){
									unset($item['couser_slug']);
									$item['courses_id'] = $courseid;
									$wpdb->insert($wpdb->prefix . $table, $item);
								}

                                break;
							default:
								$wpdb->insert($wpdb->prefix . $table, $item);
								break;
                        }
                    }

                }
            }
            echo '<html><head><script type="text/javascript">window.location.href="'.admin_url( 'themes.php?page=optionsframework&imported=success' ) .'"</script></head><body></body></html>';
			exit();
        }
    }
}

// Parsing Widgets Function
// Thanks to http://wordpress.org/plugins/widget-settings-importexport/
function athlete_import_widget_data( $widget_data ) {
    $json_data = $widget_data;
    $json_data = json_decode( $json_data, true );

    $sidebar_data = $json_data[0];
    $widget_data = $json_data[1];

    // binding menu id again for custom menu widget
    $menus = wp_get_nav_menus();
    $new_wg = array();
    foreach($widget_data as $key=> $tp_widgets){
        if($key=='nav_menu'){
            foreach($tp_widgets as $key=> $tp_widget){
                foreach($menus as $menu){
                    if($tp_widget['title']==$menu->name){
                        $tp_widget['nav_menu'] = $menu->term_id;
                        break;
                    }
                }
                $new_wg[$key] = $tp_widget;
            }
            $widget_data['nav_menu'] = $new_wg;
        }
    }

    foreach ( $widget_data as $widget_data_title => $widget_data_value ) {
        $widgets[ $widget_data_title ] = '';
        foreach( $widget_data_value as $widget_data_key => $widget_data_array ) {
            if( is_int( $widget_data_key ) ) {
                $widgets[$widget_data_title][$widget_data_key] = 'on';
            }
        }
    }
    unset($widgets[""]);

    foreach ( $sidebar_data as $title => $sidebar ) {
        $count = count( $sidebar );
        for ( $i = 0; $i < $count; $i++ ) {
            $widget = array( );
            $widget['type'] = trim( substr( $sidebar[$i], 0, strrpos( $sidebar[$i], '-' ) ) );
            $widget['type-index'] = trim( substr( $sidebar[$i], strrpos( $sidebar[$i], '-' ) + 1 ) );
            if ( !isset( $widgets[$widget['type']][$widget['type-index']] ) ) {
                unset( $sidebar_data[$title][$i] );
            }
        }
        $sidebar_data[$title] = array_values( $sidebar_data[$title] );
    }

    foreach ( $widgets as $widget_title => $widget_value ) {
        foreach ( $widget_value as $widget_key => $widget_value ) {
            $widgets[$widget_title][$widget_key] = $widget_data[$widget_title][$widget_key];
        }
    }

    $sidebar_data = array( array_filter( $sidebar_data ), $widgets );

    athlete_parse_import_data( $sidebar_data );
}

function athlete_parse_import_data( $import_array ) {
    global $wp_registered_sidebars;
    $sidebars_data = $import_array[0];
    $widget_data = $import_array[1];
    $current_sidebars = get_option( 'sidebars_widgets' );
    $new_widgets = array( );

    foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

        foreach ( $import_widgets as $import_widget ) :
            //if the sidebar exists
            if ( isset( $wp_registered_sidebars[$import_sidebar] ) ) :
                $title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
                $index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
                $current_widget_data = get_option( 'widget_' . $title );
                $new_widget_name = athlete_get_new_widget_name( $title, $index );
                $new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

                if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
                    while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
                        $new_index++;
                    }
                }
                $current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
                if ( array_key_exists( $title, $new_widgets ) ) {
                    $new_widgets[$title][$new_index] = $widget_data[$title][$index];
                    $multiwidget = $new_widgets[$title]['_multiwidget'];
                    unset( $new_widgets[$title]['_multiwidget'] );
                    $new_widgets[$title]['_multiwidget'] = $multiwidget;
                } else {
                    $current_widget_data[$new_index] = $widget_data[$title][$index];

                    $current_multiwidget = isset($current_widget_data['_multiwidget'])? $current_widget_data['_multiwidget'] : '';
                    $new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
                    $multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
                    unset( $current_widget_data['_multiwidget'] );
                    $current_widget_data['_multiwidget'] = $multiwidget;
                    $new_widgets[$title] = $current_widget_data;
                }

            endif;
        endforeach;
    endforeach;

    if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
        update_option( 'sidebars_widgets', $current_sidebars );

        foreach ( $new_widgets as $title => $content )
            update_option( 'widget_' . $title, $content );

        return true;
    }

    return false;
}

function athlete_get_new_widget_name( $widget_name, $widget_index ) {
    $current_sidebars = get_option( 'sidebars_widgets' );
    $all_widget_array = array( );
    foreach ( $current_sidebars as $sidebar => $widgets ) {
        if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
            foreach ( $widgets as $widget ) {
                $all_widget_array[] = $widget;
            }
        }
    }
    while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
        $widget_index++;
    }
    $new_widget_name = $widget_name . '-' . $widget_index;
    return $new_widget_name;
}


// Rename sidebar
function athlete_name_to_class($name){
    $class = str_replace(array(' ',',','.','"',"'",'/',"\\",'+','=',')','(','*','&','^','%','$','#','@','!','~','`','<','>','?','[',']','{','}','|',':',),'',$name);
    return $class;
}