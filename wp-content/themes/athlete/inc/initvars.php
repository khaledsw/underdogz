<?php
/***********
 * LOAD THEME CONFIGURATION FILE
 */


global $athlete_cfg,$smof_data;

// Declare variables
$postId = get_the_ID();

/** body font */
if(!$smof_data['gf_body']){
	$smof_data['gf_body'] = 'Montserrat';
}
if(!$smof_data['gf_settings']){
	$smof_data['gf_settings'] = '400,700';
}

// get master slider id from post meta
$athlete_cfg['slide-id'] = get_post_meta( $postId, 'inwave_masterslider', true );

// get show or hide heading from post meta
$athlete_cfg['show-pageheading']= get_post_meta( $postId, 'inwave_show_pageheading', true );
if(!$athlete_cfg['show-pageheading']){
	$athlete_cfg['show-pageheading'] = $smof_data['show_page_heading'];
}
if($athlete_cfg['show-pageheading'] =='no' || empty($athlete_cfg['show-pageheading'])){
    $athlete_cfg['show-pageheading']= 0;
}
else{
	$athlete_cfg['show-pageheading']= 1;
}

// get heading background
$athlete_cfg['pageheading_bg'] = get_post_meta( $postId, 'inwave_pageheading_bg', true );
if($athlete_cfg['pageheading_bg']){
    $athlete_cfg['pageheading_bg']= wp_get_attachment_image_src($athlete_cfg['pageheading_bg'],'large');
    $athlete_cfg['pageheading_bg']= $athlete_cfg['pageheading_bg'][0];
}

// get sidebar position from post meta
$athlete_cfg['sidebar-position']= get_post_meta( $postId, 'inwave_sidebar_position',true);
if(!$athlete_cfg['sidebar-position']){
	$athlete_cfg['sidebar-position'] = $smof_data['sidebar_position'];
}
if(!$athlete_cfg['sidebar-position']){
    $athlete_cfg['sidebar-position'] = 'right';
}
if($athlete_cfg['sidebar-position']=='none'){
    $athlete_cfg['sidebar-position'] = '';
}

// get sidebar name
$athlete_cfg['sidebar-name']= get_post_meta( $postId, 'inwave_sidebar_name',true);


// get Page Class from post meta
if(!isset($athlete_cfg['page-classes'])) {
    $athlete_cfg['page-classes'] = '';
}
$athlete_cfg['page-classes'] .= get_post_meta($postId, 'inwave_page_class', true);

if (!$athlete_cfg['sidebar-name'] && class_exists('WooCommerce') && (is_cart() || is_checkout())) {
    $athlete_cfg['page-classes'] .= ' page-product';
    $athlete_cfg['sidebar-name'] = 'woocommerce';
}

// header layout
if($smof_data['header_layout']){
    $athlete_cfg['header-option'] = $smof_data['header_layout'];
}
$headerOption = get_post_meta( $postId, 'inwave_header_option',true );
if($headerOption){
    $athlete_cfg['header-option'] = $headerOption;
}
if(!isset($athlete_cfg['header-option']) || $athlete_cfg['header-option']==''){
    $athlete_cfg['header-option'] = 'default';
}

// footer layout
if(!isset($athlete_cfg['footer-option'])){
	$athlete_cfg['footer-option'] = '';
}
if($smof_data['footer_option']){
	$athlete_cfg['footer-option'] = $smof_data['footer_option'];
}
$footerOption = get_post_meta( $postId, 'inwave_footer_option',true );
if($footerOption){
	$athlete_cfg['footer-option'] = $footerOption;
}

/* add body class: support white color and boxed layout */
add_filter( 'body_class','athlete_add_body_class');


/** Get quick access block control */
$athlete_cfg['show-quick-access']= get_post_meta( $postId, 'inwave_show_quick_access',true);
if(!$athlete_cfg['show-quick-access']){
    $athlete_cfg['show-quick-access'] = $smof_data['show_quick_access'];
}

/** defined primary theme menu */
$athlete_cfg['theme-menu'] = 'primary';

/* Logo */
if(!substr_count($smof_data['logo'],'http://')){
    $smof_data['logo'] = site_url() .'/'.$smof_data['logo'];
}
if(!substr_count($smof_data['store-logo'],'http://')){
    $smof_data['store-logo'] = site_url() .'/'.$smof_data['store-logo'];
}

function athlete_add_body_class($classes){
    global $athlete_cfg,$smof_data;
    $themeStyle = get_post_meta( get_the_ID(), 'inwave_theme_style',true );
	if(!$themeStyle){
		$themeStyle = $smof_data['theme_style'];
	}
    if($themeStyle=='light'){
        $classes[] = 'index-white';
    }
    if($athlete_cfg['panel-settings']->layout=='boxed'){
        $classes[] = 'body-boxed';
    }
    return $classes;
}