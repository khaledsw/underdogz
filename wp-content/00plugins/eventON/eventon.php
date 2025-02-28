<?php
/**
 * Plugin Name: EventON
 * Plugin URI: http://www.myeventon.com/
 * Description: A beautifully crafted minimal calendar experience
 * Version: 2.3.5
 * Author: AshanJay
 * Author URI: http://www.ashanjay.com
 * Requires at least: 3.8
 * Tested up to: 4.2.2
 *
 * Text Domain: eventon
 * Domain Path: /lang/languages/
 *
 * @package EventON
 * @category Core
 * @author AJDE
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



// main eventon class
if ( ! class_exists( 'EventON' ) ) {

class EventON {
	public $version = '2.3.5';
	/**
	 * @var evo_generator
	 */
	public $evo_generator;	
	
	public $template_url;
	public $print_scripts=false;

	public $lang = '';

	/**
	 * Constructor.
	 */
	public function __construct() {

		// Define constants
		$this->define_constants();	
		
		// Installation
		register_activation_hook( __FILE__, array( $this, 'activate' ) );


		// Updates
		add_action( 'admin_init', array( $this, 'verify_plugin_version' ), 5 );
		
		// Include required files
		$this->includes();
				
		// Hooks
		add_action( 'init', array( $this, 'init' ), 0 );
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
		add_action( 'after_setup_theme', array( $this, 'setup_environment' ) );
		
		// Deactivation
		register_deactivation_hook( AJDE_EVCAL_FILE, array($this,'deactivate'));
		
		
	}

	/**
	 * Define EVO Constants
	 */
	public function define_constants() {
		if(!defined('EVO_VERSION'))
			define('EVO_VERSION', $this->version);

		define( "AJDE_EVCAL_DIR", WP_PLUGIN_DIR ); //E:\xampp\htdocs\WP/wp-content/plugins
		define( "AJDE_EVCAL_PATH", dirname( __FILE__ ) );// E:\xampp\htdocs\WP/wp-content/plugins/eventON/
		define( "AJDE_EVCAL_FILE", ( __FILE__ ) );
		define( "AJDE_EVCAL_URL", path_join(plugins_url(), basename(dirname(__FILE__))) );
		define( "AJDE_EVCAL_BASENAME", plugin_basename(__FILE__) ); //eventON/eventon.php
		define( "EVENTON_BASE", basename(dirname(__FILE__)) ); //eventON
		define( "BACKEND_URL", get_bloginfo('url').'/wp-admin/' ); 

		// save addon class file url so addons can access this
		$this->evo_url();

	}
	public function evo_url($resave=false){
		$init = get_option('eventon_addon_urls');
		if(empty($init) || $resave){
			$path = AJDE_EVCAL_PATH;
			$arr = array(
				'addons'=>$path.'/classes/class-evo-addons.php',
				'date'=> time()
			);
			update_option('eventon_addon_urls',$arr);
			$init = $arr;
		}
		return $init;
	}
	
	
	/**
	 * Include required files
	 * 
	 * @access private
	 * @return void
	 * @since  0.1
	 */
	private function includes(){		

		// post types
		include_once( 'includes/class-evo-post-types.php' );
		include_once( 'includes/class-evo-datatime.php' );
		include_once( 'includes/class-evo-helper.php' );
			
		include_once( 'includes/eventon-core-functions.php' );
		include_once( 'includes/class-frontend.php' );		
		include_once( 'includes/class-map-styles.php' );		
		include_once( 'includes/class-calendar-shell.php' );
		include_once( 'includes/class-calendar-body.php' );		
		include_once( 'includes/class-calendar-helper.php' );
		include_once( 'includes/class-calendar_generator.php' );			

		if ( is_admin() ){
			include_once('includes/admin/eventon-admin-functions.php' );
			include_once('includes/admin/eventon-admin-html.php' );
			include_once('includes/admin/eventon-admin-taxonomies.php' );

			include_once('includes/admin/post_types/ajde_events.php' );
			include_once('includes/admin/welcome.php' );			
			include_once('includes/admin/eventon-admin-init.php' );	
			include_once('includes/admin/class-evo-event.php' );
			include_once('includes/admin/class-evo-admin.php' );
			$this->evo_event = new evo_event();
			$this->evo_admin = new evo_admin();
		}
		if ( ! is_admin() || defined('DOING_AJAX') ){
			// Functions
			include_once( 'includes/eventon-functions.php' );

			include_once( 'includes/class-evo-shortcodes.php' );
			include_once( 'includes/class-evo-template-loader.php' );
		}
		if ( defined('DOING_AJAX') ){
			include_once( 'includes/class-evo-ajax.php' );	
		}
		
	}
	
	
	/** register_widgets function. */
		function register_widgets() {
			// Include - no need to use autoload as WP loads them anyway
			include_once( 'includes/class-evo-widget-main.php' );
		}
	
	/**
	 * Init eventON when WordPress Initialises.
	 */
	public function init() {
		
		// Set up localisation
		$this->load_plugin_textdomain();
		
		$this->template_url = apply_filters('eventon_template_url','eventon/');
		
		$this->evo_generator	= new EVO_generator();	
		$this->frontend	= new evo_frontend();	

		// Classes/actions loaded for the frontend and for ajax requests
		if ( ! is_admin() || defined('DOING_AJAX') ) {
			// Class instances		
			$this->shortcodes		= new EVO_Shortcodes();		
					
			// Hooks
			add_action( 'init', array( $this, 'register_scripts' ), 10 );
			add_action( 'wp_enqueue_scripts', array( $this, 'load_default_evo_styles' ), 10 );
			add_action( 'wp_head', array( $this, 'load_dynamic_evo_styles' ), 50 );
					
		}
		
		
		// roles and capabilities
		eventon_init_caps();
		
		global $pagenow;
		$__needed_pages = array('update-core.php','plugins.php', 'admin.php','admin-ajax.php', 'plugin-install.php','index.php');

		// only for admin Eventon updater
			if(is_admin() && !empty($pagenow) && in_array($pagenow, $__needed_pages) ){

				// Initiate eventon updater	
				require_once( 'includes/admin/class-evo-updater.php' );		
				$this->evo_updater = new evo_updater ( 
					array(
						'version'=>$this->version, 
						'slug'=> strtolower(EVENTON_BASE),
						'plugin_slug'=> AJDE_EVCAL_BASENAME,
						'name'=>EVENTON_BASE,
					)
				);						
			}
		
		// Init action
		do_action( 'eventon_init' );
	}
	
	// MOVED functions
		/*** output the inpage popup window for eventon	 */
			public function output_eventon_pop_window($arg){
				$this->frontend->popup_window($arg);			
			}		
		
		/*	Legend popup box across wp-admin	*/
			public function throw_guide($content, $position='', $echo=true){
				$content = $this->frontend->get_html_guide($content, $position);
				if($echo){ echo $content;  }else{ return $content; }			
			}	
			
		/* EMAIL functions */
			public function get_email_part($part){
				return $this->frontend->get_email_part($part);
			}

		/**
		 * body part of the email template loading
		 * @update 2.2.24
		 */
			public function get_email_body($part, $def_location, $args='', $paths=''){
				return $this->frontend->get_email_body($part, $def_location, $args='', $paths='');
			}

	/** Register/queue frontend scripts. */
		public function register_scripts() {
			global $post;
			
			$evo_opt= get_option('evcal_options_evcal_1');
			
			
			// Google gmap API script -- loadded from class-calendar_generator.php		

			//wp_register_script('add_to_cal', AJDE_EVCAL_URL. '/assets/js/add_to_calendar.js', array('jquery'),'1.0',true ); -- 2.2.17

			
			wp_register_script('evo_mobile',AJDE_EVCAL_URL.'/assets/js/jquery.mobile.min.js', array('jquery'), $this->version, true ); // 2.2.17
			wp_register_script('evcal_easing', AJDE_EVCAL_URL. '/assets/js/jquery.easing.1.3.js', array('jquery'),'1.0',true );//2.2.24
			wp_register_script('evcal_functions', AJDE_EVCAL_URL. '/assets/js/eventon_functions.js', array('jquery'), $this->version ,true );// 2.2.22
			wp_register_script('evcal_ajax_handle', AJDE_EVCAL_URL. '/assets/js/eventon_script.js', array('jquery'), $this->version ,true );
			wp_localize_script( 
				'evcal_ajax_handle', 
				'the_ajax_script', 
				array( 
					'ajaxurl' => admin_url( 'admin-ajax.php' ) , 
					'postnonce' => wp_create_nonce( 'eventon_nonce' )
				)
			);


			// google maps	
			wp_register_script('eventon_gmaps', AJDE_EVCAL_URL. '/assets/js/maps/eventon_gen_maps.js', array('jquery'), $this->version ,true );	
			wp_register_script('eventon_init_gmaps', AJDE_EVCAL_URL. '/assets/js/maps/eventon_init_gmap.js', array('jquery'),'1.0',true );
			wp_register_script( 'eventon_init_gmaps_blank', AJDE_EVCAL_URL. '/assets/js/maps/eventon_init_gmap_blank.js', array('jquery'), $this->version ,true ); // load a blank initiate gmap javascript

			wp_register_script( 'evcal_gmaps', apply_filters('eventon_google_map_url', 'https://maps.googleapis.com/maps/api/js?sensor=false'), array('jquery'),'1.0',true);



			// STYLES
			wp_register_style('evo_font_icons',AJDE_EVCAL_URL.'/assets/fonts/font-awesome.css');		
			
			// select the current skin
			$skin  = (!empty($evo_opt['evcal_skin']))? $evo_opt['evcal_skin'] : 'slick';		
					
			// Defaults styles and dynamic styles
			wp_register_style('evcal_cal_default',AJDE_EVCAL_URL.'/assets/css/eventon_styles.css');	
			//wp_register_style('evo_dynamic_css', admin_url('admin-ajax.php').'?action=evo_dynamic_css');


			global $is_IE;
			if ( $is_IE ) {
				wp_register_style( 'ieStyle', AJDE_EVCAL_URL.'/assets/css/ie.css', array(), '1.0' );
				wp_enqueue_style( 'ieStyle' );
			}


			// LOAD custom google fonts for skins	
			//$gfonts = (is_ssl())? 'https://fonts.googleapis.com/css?family=Oswald:400,300|Open+Sans:400,300': 'http://fonts.googleapis.com/css?family=Oswald:400,300|Open+Sans:400,300';	
			$gfonts="//fonts.googleapis.com/css?family=Oswald:400,300|Open+Sans:400,300";
			wp_register_style( 'evcal_google_fonts', $gfonts, '', '', 'screen' );
			
			$this->register_evo_dynamic_styles();

		}	

		public function register_evo_dynamic_styles(){
			$opt= get_option('evcal_options_evcal_1');
			if(!empty($opt['evcal_css_head']) && $opt['evcal_css_head'] =='no' || empty($opt['evcal_css_head'])){
				if(is_multisite()) {
					$uploads = wp_upload_dir();
					wp_register_style('eventon_dynamic_styles', $uploads['baseurl'] . '/eventon_dynamic_styles.css', 'style');
				} else {
					wp_register_style('eventon_dynamic_styles', 
						AJDE_EVCAL_URL. '/assets/css/eventon_dynamic_styles.css', 'style');
				}
			}

		}
		
		public function load_dynamic_evo_styles(){
			$opt= get_option('evcal_options_evcal_1');
			if(!empty($opt['evcal_css_head']) && $opt['evcal_css_head'] =='yes'){
				
				$dynamic_css = get_option('evo_dyn_css');
				if(!empty($dynamic_css)){
					echo '<style type ="text/css">'.$dynamic_css.'</style>';
				}				
			}else{
				wp_enqueue_style( 'eventon_dynamic_styles');
			}
		}
		public function load_default_evo_scripts(){
			//wp_enqueue_script('add_to_cal');
			wp_enqueue_script('evcal_functions');
			wp_enqueue_script('evo_mobile');
			wp_enqueue_script('evcal_ajax_handle');			
			wp_enqueue_script('eventon_gmaps');

			do_action('eventon_enqueue_scripts');
			
		}
		public function load_default_evo_styles(){
			$opt= get_option('evcal_options_evcal_1');
			if(empty($opt['evo_googlefonts']) || $opt['evo_googlefonts'] =='no')
				wp_enqueue_style( 'evcal_google_fonts' );

			wp_enqueue_style( 'evcal_cal_default');	
			if(empty($opt['evo_fontawesome']) || $opt['evo_fontawesome'] =='no')
				wp_enqueue_style( 'evo_font_icons' );
		}
		public function load_evo_scripts_styles(){
			$this->load_default_evo_scripts();
			$this->load_default_evo_styles();
		}
		public function evo_styles(){
			add_action('wp_head', array($this, 'load_default_evo_scripts'));
		}
	
	/**
	 * Activate function to store version.
	 */
	public function activate(){
		set_transient( '_evo_activation_redirect', 1, 60 * 60 );		
		do_action('eventon_activate');
	}
	
	// update function
	public function update(){
		//set_transient( '_evo_activation_redirect', 1, 60 * 60 );		
	}
	
	
	/** check plugin version **/
	public function verify_plugin_version(){
		
		$plugin_version = $this->version;
			
		// check installed version
		$installed_version = get_option('eventon_plugin_version');
		
		if($installed_version != $plugin_version){
			if (  isset( $_GET['page'] ) && 'eventon' == $_GET['page']   ){
				

				update_option('eventon_plugin_version', $plugin_version);
				wp_safe_redirect( admin_url( 'index.php?page=evo-about&evo-updated=true' ) );
			}
			//set_transient( '_evo_update_redirect', 1, 60 * 60 );
			//update_option( '_evo_updated', 'true');
			
		}else if(!$installed_version ){
			add_option('eventon_plugin_version', $plugin_version);			
		}else{
			update_option('eventon_plugin_version', $plugin_version);			
		}
		
		// delete options saved on previous version
		delete_option('evcal_plugin_version');
	}
	
	public function is_eventon_activated(){
		$licenses =get_option('_evo_licenses');

		if(!empty($licenses)){
			$status = $licenses['eventon']['status'];
			return ($status=='active')? true:false;
		}else{
			return false;
		}
		
	}
	
	public function deactivate(){
		//delete_option('evcal_options');		
		do_action('eventon_deactivate');
	}
	

	
	/**
	 * Ensure theme and server variable compatibility and setup image sizes..
	 */
	public function setup_environment() {
		// Post thumbnail support
		if ( ! current_theme_supports( 'post-thumbnails', 'ajde_events' ) ) {
			add_theme_support( 'post-thumbnails' );
			remove_post_type_support( 'post', 'thumbnail' );
			remove_post_type_support( 'page', 'thumbnail' );
		} else {
			add_post_type_support( 'ajde_events', 'thumbnail' );
		}

		// IIS
		if ( ! isset($_SERVER['REQUEST_URI'] ) ) {
			$_SERVER['REQUEST_URI'] = substr( $_SERVER['PHP_SELF'], 1 );
			if ( isset( $_SERVER['QUERY_STRING'] ) ) {
				$_SERVER['REQUEST_URI'].='?'.$_SERVER['QUERY_STRING'];
			}
		}

		// NGINX Proxy
		if ( ! isset( $_SERVER['REMOTE_ADDR'] ) && isset( $_SERVER['HTTP_REMOTE_ADDR'] ) ) {
			$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_REMOTE_ADDR'];
		}

		if ( ! isset( $_SERVER['HTTPS'] ) && ! empty( $_SERVER['HTTP_HTTPS'] ) ) {
			$_SERVER['HTTPS'] = $_SERVER['HTTP_HTTPS'];
		}

		// Support for hosts which don't use HTTPS, and use HTTP_X_FORWARDED_PROTO
		if ( ! isset( $_SERVER['HTTPS'] ) && ! empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) {
			$_SERVER['HTTPS'] = '1';
		}
	}
	
	
	/** LOAD Backender UI and functionalities for settings. */
		public function load_ajde_backender(){
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');

			wp_enqueue_script('backender_colorpicker');
			wp_enqueue_script('ajde_backender_script');

			include_once(AJDE_EVCAL_PATH.'/includes/admin/ajde_backender.php');
			
		}
	
		public function enqueue_backender_styles(){
			wp_enqueue_style( 'ajde_backender_styles',AJDE_EVCAL_URL.'/assets/css/admin/ajde_backender_style.css');
			wp_enqueue_style( 'colorpicker_styles',AJDE_EVCAL_URL.'/assets/css/colorpicker_styles.css');
			
		}
		public function register_backender_scripts(){
			wp_register_script('backender_colorpicker',AJDE_EVCAL_URL.'/assets/js/colorpicker.js' ,array('jquery'),'1.0', true);
			wp_register_script('ajde_backender_script',AJDE_EVCAL_URL.'/assets/js/ajde_backender_script.js', array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'), '1.0', true );
			
		}
	
	
	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present
	 * Admin Locale. Looks in:
	 * - WP_LANG_DIR/eventon/eventon-admin-LOCALE.mo
	 * - WP_LANG_DIR/plugins/eventon-admin-LOCALE.mo
	 *
	 * @access public
	 * @return void
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'eventon' );
		
		load_textdomain( 'eventon', WP_LANG_DIR . "/eventon/eventon-admin-".$locale.".mo" );
		load_textdomain( 'eventon', WP_LANG_DIR . "/plugins/eventon-admin-".$locale.".mo" );
		
		
		if ( is_admin() ) {
			load_plugin_textdomain( 'eventon', false, plugin_basename( dirname( __FILE__ ) ) . "/lang" );
		}

		// frontend
		/*
			this is controlled by myeventon settings> language		
		*/
	}
	
	public function get_current_version(){
		return $this->version;
	}	
	
	/** return eventon option settings values **/
	public function evo_get_options($field, $array_field=''){
		if(!empty($array_field)){
			$options = get_option($field);
			$options = $options[$array_field];
		}else{
			$options = get_option($field);
		}		
		return !empty($options)?$options:null;
	}

	// deprecated function after 2.2.12
		public function addon_has_new_version($values){}

}

}// class exists

/**
 * Init eventon class
 */
$GLOBALS['eventon'] = new EventON();

//include_once('admin/update-notifier.php');	
?>