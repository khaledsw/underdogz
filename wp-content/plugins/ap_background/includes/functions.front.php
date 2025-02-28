<?php
/**
 * Cac ham xu ly phia front end.
 *
 * @author gmswebdesign
 * @package AP Background
 * @version 1.0.0
 */
require_once 'utility.php';

/**
 * Function add sctipt to page
 */
function adv_parallax_add_site_script() {
    /* Scripts */
    wp_enqueue_script('jquery');
    wp_enqueue_style('ap-paralax-css', plugins_url('ap_background/assets/css/adv_parallax_styles.css'));
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');
    wp_enqueue_script('ap-jquery-parallax', plugins_url('ap_background/assets/js/jquery.parallax-1.1.3.js'), array('jquery'), '1.0.0', true);
    wp_enqueue_script('jquery-easing', plugins_url('ap_background/assets/js/jquery.easing.1.3.js'), array('jquery'), '1.0.0', true);
    wp_register_script('ap-parallax-js', plugins_url('ap_background/assets/js/jquery.apparallax.js'), array('jquery'), '1.0.0', true);
    wp_localize_script('ap-parallax-js', 'btAdvParallaxBackgroundCfg', array('siteUrl' => admin_url(), 'baseUrl' => site_url(), 'ajaxUrl' => admin_url('admin-ajax.php')));
    wp_enqueue_script('ap-parallax-js');
}



/**
 * Function load content of parallax block when open parallax button is click
 */
function loadParallaxFrameContent() {
    //Khai bao va gan gia tri cho cac bien can thiet
    $bt_utility = new btParallaxBackgroundUtility();
    $result = array('success' => false, 'message' => '', 'data' => null);
    $alias = $_POST['item'];

    //Lay ve thong tin cua parallax theo alias
    $item = $bt_utility->getSliderByAlias($alias);

    //Kiem tra xem co lay duoc thong tin cua parallax slider ko
    if (!$item) {//Neu khong lay duoc thong tin cua parallax thi hien thi text thay the
        $result['message'] = __('No Parallax Background with alias <strong>' . $alias . '</strong> found');
    } else {//Neu thong tin cua parallax slider lay duoc thi thuc hien load noi dung cua parallax content
        $item->settings = json_decode($item->settings);
        ob_start();
        //Kiem tra kieu noi dung cua parallax
        //Xu ly load noi dung voi truong hop kieu noi dung image gallery
        if ($item->settings->content_type == 'image-gallery'):
            include_once 'html/parallax_content/image.php';
        endif;

        //Xu ly load noi dung voi truong hop kieu noi dung video
        if ($item->settings->content_type == 'video-background'):
            include_once 'html/parallax_content/video.php';
        endif;

        //Xu ly load noi dung voi truong hop kieu noi dung woo commerce
        if ($item->settings->content_type == 'woo-commerce'):
            include_once 'html/parallax_content/woo-commerce.php';
        endif;

        //Xu ly load noi dung voi truong hop kieu noi dung wp post
        if ($item->settings->content_type == 'wordpress-posts'):
            include_once 'html/parallax_content/wp-post.php';
        endif;

        $html = ob_get_contents();
        ob_end_clean();
        $result['success'] = true;
        $result['message'] = __('Content has been loaded');
        $result['data'] = $html;
    }
    $bt_utility->obEndClear();
    echo json_encode($result);
    exit();
}
