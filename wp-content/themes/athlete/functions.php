<?php
/**
 * athlete functions and definitions
 *
 * @package athlete
 */

/** define config data */
$athlete_cfg = array();

/** define content width */
$content_width = 1024;

// admin option
require_once ('admin/index.php');

if (!is_admin()) {
    include("inc/custom-nav.php");
    add_filter('nav_menu_css_class', 'special_nav_class', 10, 2);

    function special_nav_class($classes, $item) {
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'selected active ';
        }
        return $classes;
    }
}

// require main class for theme;
require get_template_directory() . '/inc/main-class.php';

if (!function_exists('athlete_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function athlete_setup() {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on athlete, use a find and replace
         * to change 'gmswebdesign' to the name of your theme in all the template files
         */
        load_theme_textdomain('gmswebdesign', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'gmswebdesign'),
            'onepage' => __('OnePage Menu', 'gmswebdesign'),
                # 'information' => __('Information', 'gmswebdesign'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
        ));

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'image', 'gallery', 'video', 'quote', 'link'
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('athlete_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));
    }

endif; // athlete_setup
add_action('after_setup_theme', 'athlete_setup');

/**
 * Enqueue scripts and styles.
 */
function athlete_scripts() {
	global $smof_data;
	
    $theme_info = wp_get_theme();
	if($smof_data['fix_woo_jquerycookie']){
		wp_deregister_script( 'jquery-cookie' );
		wp_register_script( 'jquery-cookie', get_template_directory_uri() . '/js/jquery-cookie-min.js', array( 'jquery' ), $theme_info->get('Version'),true );	
	}

    /** Theme style */
    wp_enqueue_style( 'athlete-style', get_stylesheet_uri() );
	
	// Deregister some link
	wp_deregister_style('yith-wcwl-font-awesome');
	wp_deregister_style('font-awesome');
	
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), $theme_info->get('Version'));
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), $theme_info->get('Version'));
    wp_enqueue_style('jquery-custombox', get_template_directory_uri() . '/css/jquery.custombox.css', array(), $theme_info->get('Version'));
    

    // Don't load css3 effect in mobile device
	if(!(isset($_REQUEST['vc_editable']) && $_REQUEST['vc_editable'])){
		if (!wp_is_mobile() ) {
			wp_enqueue_style('athlete-effect', get_template_directory_uri() . '/css/effect.css', array(), $theme_info->get('Version'));
			wp_enqueue_style('athlete-animation', get_template_directory_uri() . '/css/animation.css', array(), $theme_info->get('Version'));
		}else{
			wp_enqueue_style('athlete-mobile', get_template_directory_uri() . '/css/mobile.css', array(), $theme_info->get('Version'));
		}
	}

    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css', array(), $theme_info->get('Version'));
    wp_enqueue_style('owl-transitions', get_template_directory_uri() . '/css/owl.transitions.css', array(), $theme_info->get('Version'));

	/* Load jquery lib*/
	wp_enqueue_script( 'jquery' );
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), $theme_info->get('Version'), true);
    wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/js/jquery-ui.js', array(), $theme_info->get('Version'), true);
    wp_enqueue_script('jquery-easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array(), $theme_info->get('Version'), true);

    /* Load only page request*/
    if(is_page()) {
        wp_enqueue_script('waypoints', get_template_directory_uri() . '/js/waypoints.js', array(), $theme_info->get('Version'), true);
        wp_enqueue_script('scrollTo', get_template_directory_uri() . '/js/jquery.scrollTo.js', array(), $theme_info->get('Version'), true);
    }
    wp_enqueue_script('athlete-shortcode-frontend', get_template_directory_uri() . '/js/shortcode-frontend.js', array(), $theme_info->get('Version'), true);

    wp_enqueue_script('jquery-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array(), $theme_info->get('Version'), true);
    wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), $theme_info->get('Version'), true);
    wp_enqueue_script('jquery-custombox', get_template_directory_uri() . '/js/jquery.custombox.js', array(), $theme_info->get('Version'), true);
    wp_enqueue_script('athlete-dropdown', get_template_directory_uri() . '/js/dropdown.js', array(), $theme_info->get('Version'), true);
    wp_enqueue_script('jquery-isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array(), $theme_info->get('Version'), true);
    wp_enqueue_script('athlete-filtering', get_template_directory_uri() . '/js/filtering.js', array(), $theme_info->get('Version'), true);
    wp_enqueue_script('athlete-themes', get_template_directory_uri() . '/js/theme.js', array(), $theme_info->get('Version'), true);
    wp_enqueue_script('classie', get_template_directory_uri() . '/js/classie.js', array(), $theme_info->get('Version'), true);
    wp_register_script('athlete-main', get_template_directory_uri() . '/js/main.js', array(), $theme_info->get('Version'), true);
    wp_enqueue_script('athlete-template', get_template_directory_uri() . '/js/template.js', array(), $theme_info->get('Version'), true);
    wp_localize_script('athlete-main', 'athleteCfg', array('siteUrl' => admin_url(), 'baseUrl' => site_url(), 'ajaxUrl' => admin_url('admin-ajax.php')));
    wp_enqueue_script('athlete-main');
	
	if($smof_data['retina_support']){
		wp_enqueue_script( 'retina_js', get_template_directory_uri() . '/js/retina.min.js', array(), $theme_info->get('Version'), true);
	}

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
	
	$themeStyle = get_post_meta( get_the_ID(), 'inwave_theme_style',true );
	if(!$themeStyle){
		$themeStyle = $smof_data['theme_style'];
	}
	if($themeStyle == 'light'){
		wp_enqueue_style('athlete-light', get_template_directory_uri() . '/css/light.css', array(), $theme_info->get('Version'));
	}
	/** Dynamic css color */
    wp_enqueue_style('athlete-color', admin_url('admin-ajax.php') . '?action=athlete_color', array(), $theme_info->get('Version'));
}

add_action('wp_enqueue_scripts', 'athlete_scripts');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

if (!function_exists('athlete_comment')) {

    /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own athlete_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.

     */
    function athlete_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
                // Display trackbacks differently than normal comments.
                ?>
                <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                    <p><?php _e('Pingback:', 'gmswebdesign'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('(Edit)', 'twentytwelve'), '<span class="edit-link">', '</span>'); ?></p>
                    <?php
                    break;
                default :
                    // Proceed with normal comments.
                    global $post;
                    ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <div id="comment-<?php comment_ID(); ?>" class="comment answer">
                        <div class="col-md-2 col-sm-2 col-xs-3">
                            <?php echo get_avatar(get_comment_author_email() ? get_comment_author_email() : $comment, 91); ?>
                        </div>
                        <!-- .comment-meta -->

                        <?php if ('0' == $comment->comment_approved) : ?>
                            <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'gmswebdesign'); ?></p>
                        <?php endif; ?>

                        <div class="col-md-10">
                            <div class="content-cmt">
                                <span class="name-cmt"><?php echo get_comment_author_link() ?></span>
                                <span class="date-cmt"><?php echo get_comment_date() ?></span>
                                <span><?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply', 'gmswebdesign'), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?></span>
                                <div class="content-reply">
                                    <?php comment_text(); ?>
                                </div>
                            </div>

                            <?php edit_comment_link(__('Edit', 'gmswebdesign'), '<p class="edit-link">', '</p>'); ?>
                        </div>
                        <!-- .comment-content -->

                    </div>
                    <!-- #comment-## -->
                    <?php
                    break;
            endswitch; // end comment_type check
        }

    }

    if (!function_exists('getHtmlByTags')) {

        /**
         * Function to get element by tag
         * @param string $tag tag name. Eg: embed, iframe...
         * @param string $content content to find
         * @param int $type type of tag. <br/> 1. [tag_name settings]content[/tag_name]. <br/>2. [tag_name settings]. <br/>3. HTML tags.
         * @return type
         */
        function getElementByTags($tag, $content, $type = 1) {
            if ($type == 1) {
                $pattern = "/\[$tag(.*)\](.*)\[\/$tag\]/";
            } elseif ($type == 2) {
                $pattern = "/\[$tag(.*)\]/";
            } elseif ($type == 3) {
                $pattern = "/<$tag(.*)>(.*)<\/$tag>/";
            } else {
                $pattern = null;
            }
            $find = null;
            if ($pattern) {
                preg_match($pattern, $content, $matches);
                if ($matches) {
                    $find = $matches;
                }
            }
            return $find;
        }

    }


    if (!function_exists('getSocialSharing')) {

        /**
         *
         * @global type $smof_data
         * @param String $link Link to share
         * @param String $text the text content to share
         * @param String $title the title to share
         * @param String $tag the wrap html tag
         */
        function getSocialSharing($link, $text, $title, $tag='') {
            global $smof_data;
            $newWindow = 'onclick="return iwOpenWindow(this.href);"';
            $title = urlencode($title);
            $text = urlencode($text);
            $link = urlencode($link);
            if ($smof_data['sharing_facebook']) {
                $shareLink = 'https://www.facebook.com/sharer.php?s=100&amp;p[title]=' . $title . '&amp;p[url]=' . $link . '&amp;p[summary]=' . $text;
                echo ($tag?'<'.$tag.'>':'').'<a target="_blank" href="#" title="' . esc_attr_x('Share on Facebook', 'gmswebdesign') . '" onclick="return iwOpenWindow(\''.esc_js($shareLink).'\')"><i class="fa fa-facebook"></i></a>'.($tag?'</'.$tag.'>':'');
            }
            if ($smof_data['sharing_twitter']) {
                $shareLink = 'https://twitter.com/share?url=' . $link . '&amp;text=' . $text;
                echo ($tag?'<'.$tag.'>':'').'<a target="_blank" href="'.esc_url($shareLink).'" title="' . esc_attr_x('Share on Twitter', 'gmswebdesign') . '" '.$newWindow.'><i class="fa fa-twitter"></i></a>'.($tag?'</'.$tag.'>':'');
            }
            if ($smof_data['sharing_linkedin']) {
                $shareLink = 'https://www.linkedin.com/shareArticle?mini=true&amp;url=' . $link . '&amp;title=' . $title . '&amp;summary=' . $text;
                echo ($tag?'<'.$tag.'>':'').'<a class="in" target="_blank" href="'.esc_url($shareLink).'" title="' . esc_attr_x('Share on Linkedin', 'gmswebdesign') . '" '.$newWindow.'><i class="fa fa-linkedin"></i></a>'.($tag?'</'.$tag.'>':'');
            }
            if ($smof_data['sharing_google']) {
                $shareLink = 'https://plus.google.com/share?url=' . $link . '&amp;title=' . $title;
                echo ($tag?'<'.$tag.'>':'').'<a target="_blank" href="'.esc_url($shareLink).'" title="' . esc_attr_x('Google Plus', 'gmswebdesign') . '" '.$newWindow.'><i class="fa fa-google-plus"></i></a>'.($tag?'</'.$tag.'>':'');
            }
            if ($smof_data['sharing_tumblr']) {
                $shareLink = 'http://www.tumblr.com/share/link?url=' . $link . '&amp;description=' . $text . '&amp;name=' . $title;
                echo ($tag?'<'.$tag.'>':'').'<a target="_blank" href="'.esc_url($shareLink).'" title="' . esc_attr_x('Share on Tumblr', 'gmswebdesign') . '" '.$newWindow.'><i class="fa fa-tumblr-square"></i></a>'.($tag?'</'.$tag.'>':'');
            }
            if ($smof_data['sharing_pinterest']) {
                $shareLink = 'http://pinterest.com/pin/create/button/?url=' . $link . '&amp;description=' . $text . '&amp;media=' . $link;
                echo ($tag?'<'.$tag.'>':'').'<a target="_blank" href="'.esc_url($shareLink).'" title="' . esc_attr_x('Pinterest', 'gmswebdesign') . '" '.$newWindow.'><i class="fa fa-pinterest"></i></a>'.($tag?'</'.$tag.'>':'');
            }
            if ($smof_data['sharing_email']) {
                $shareLink = 'mailto:?subject=' . esc_attr_x('I wanted you to see this site', 'gmswebdesign') . '&amp;body=' . $link . '&amp;title=' . $title;
                echo ($tag?'<'.$tag.'>':'').'<a href="'.esc_url($shareLink).'" title="' . esc_attr_x('Email', 'gmswebdesign').'"><i class="fa fa-envelope"></i></a>'.($tag?'</'.$tag.'>':'');
            }
        }

    }

    if (!function_exists('generateData')) {

        function generateData() {
            WP_Filesystem();
            global $wpdb,$wp_filesystem;

            $theme_dir = get_theme_root();
            $data_dir = $theme_dir . '/athlete/admin/importer/data/';

            //Create apbackground data file
            $ap_file = $data_dir . 'apbackground.json';

            // safe query: no input data
            $apdatas = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'ap_background');
            if ($apdatas) {
                if (file_exists($ap_file)) {
                    unlink($ap_file);
                }
                $content = json_encode($apdatas);
                $wp_filesystem->put_contents($ap_file,$content);
            }
            //Create iwc data file
            $iwc_file = $data_dir . 'iwcourse.json';
            $iwcdatas = array();

            // safe query: no input data
            $iwcextrafield = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'iw_courses_extrafields');

            // safe query: no input data
            $iwcextrafieldcat = $wpdb->get_results('SELECT a.slug as category_alias, b.extrafields_id FROM ' . $wpdb->prefix . 'iw_courses_extrafields_category as b LEFT JOIN '.$wpdb->prefix.'terms as a ON a.term_id = b.category_id');
            $iwcextrafieldval = $wpdb->get_results('SELECT a.post_name as couser_slug, b.extrafields_id, b.value FROM ' . $wpdb->prefix . 'iw_courses_extrafields_value as b LEFT JOIN ' . $wpdb->prefix . 'posts as a ON a.ID = b.courses_id');

            if ($iwcextrafield) {
                $iwcdatas['iw_courses_extrafields'] = $iwcextrafield;
            }
            if ($iwcextrafieldcat) {
                $iwcdatas['iw_courses_extrafields_category'] = $iwcextrafieldcat;
            }
            if ($iwcextrafieldval) {
                $iwcdatas['iw_courses_extrafields_value'] = $iwcextrafieldval;
            }
            $iwcontent = json_encode($iwcdatas);
            if ($iwcontent) {
                if(file_exists($iwc_file)){
                    unlink($iwc_file);
                }
                $wp_filesystem->put_contents($iwc_file,$iwcontent);
            }

            echo 'Data exported success<br/>';
            echo '<a href="'.admin_url().'">CLICK HERE</a> to back admin home';
        }

    }

