<?php
/**
 * athlete Theme Customizer
 *
 * @package athlete
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function athlete_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    // Add custom header and sidebar background color setting and control.
    $wp_customize->add_setting( 'header_background_color', array(
        'default'           => $color_scheme[1],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
}
add_action( 'customize_register', 'athlete_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function athlete_customize_preview_js() {
	wp_enqueue_script( 'athlete_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'athlete_customize_preview_js' );
