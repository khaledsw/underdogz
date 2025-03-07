<?php
/**
 * EVO_Shortcodes class.
 *
 * @class 		EVO_Shortcodes
 * @version		1.0.0
 * @package		EventON/Classes
 * @category	Class
 * @author 		AJDE
 */

class EVO_Shortcodes {
	public function __construct(){
		// regular shortcodes
		add_shortcode('add_ajde_evcal',array($this,'eventon_show_calendar'));	// for eventon ver < 2.0.8	
		add_shortcode('add_eventon',array($this,'eventon_show_calendar'));
		add_shortcode('add_eventon_list',array($this,'events_list'));
		
	}
	
	
	/*
		Show multiple month calendar
	*/
	public function events_list($atts){
		
		global $eventon;
		
		add_filter('eventon_shortcode_defaults', array($this,'event_list_shortcode_defaults'), 10, 1);
		
		// connect to support arguments
		$supported_defaults = $eventon->evo_generator->get_supported_shortcode_atts();
		
		$args = shortcode_atts( $supported_defaults, $atts ) ;	
		
		
		// OUT PUT		
		ob_start();
			
		echo $eventon->evo_generator->generate_events_list($args);
		
		return ob_get_clean();
		
	}
	
	// add new default shortcode arguments
	public function event_list_shortcode_defaults($arr){
		
		return array_merge($arr, array(
			'hide_empty_months'=>'no',
			'show_year'=>'no',
		));
		
	}
	
	/**
	 * Show single month calendar shortcode
	 */
	public function eventon_show_calendar($atts){
		global $eventon;
		
		// connect to support arguments
		$supported_defaults = apply_filters('eventon_shortcode_default_values', $eventon->evo_generator->shell->get_supported_shortcode_atts());	
		
		$args = shortcode_atts( $supported_defaults, $atts ) ;	
		
		$args = apply_filters('eventon_shortcode_argument_update', $args);	
		
		// OUT PUT
		
		ob_start();
			
		echo $eventon->evo_generator->eventon_generate_calendar($args);
		
		return ob_get_clean();
	}
}



?>