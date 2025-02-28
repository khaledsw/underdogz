<?php

/**
 * File contain functions process in admin
 *
 * @author gmswebdesign
 * @package AP Background
 * @version 1.0.0
 */
require_once 'utility.php';
require_once 'images.php';



/**
 * Function create table and version when install plugin
 */
if (!function_exists('ap_background_install')) {

    function ap_background_install() {
        global $wpdb;
        global $ap_background_db_version;

        $charset_collate = '';
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        if (!empty($wpdb->charset)) {
            $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
        }

        if (!empty($wpdb->collate)) {
            $charset_collate .= " COLLATE {$wpdb->collate}";
        }
        //Add table ap_background
        $sql = "CREATE TABLE " . $wpdb->prefix . "ap_background (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `name` varchar(255) DEFAULT NULL,
                    `alias` varchar(255) DEFAULT NULL,
                    `settings` text DEFAULT NULL,
                    `content` text DEFAULT NULL,
                    `created` int(20) DEFAULT NULL,
                    `modified` int(20) DEFAULT NULL,
                    `status` tinyint(1) DEFAULT NULL,
                    PRIMARY KEY (`id`)
	) $charset_collate;";


        dbDelta($sql);

//        add bt parallax table version
        add_option('ap_background_db_version', $ap_background_db_version);
        flush_rewrite_rules();
    }

}


/**
 * Function create list parallax page
 */
if (!function_exists('pluginIndexRenderPage')) {

    function pluginIndexRenderPage() {
        include_once 'html/index.php';
    }

}

/**
 * Function create page add new parallax
 */
if (!function_exists('pluginAddnewRenderPage')) {

    function pluginAddnewRenderPage() {
        include_once 'html/create_new.php';
    }

}

//Ham tao trang preview
if (!function_exists('pluginPreviewPage')) {

    function pluginPreviewPage() {
        include_once 'html/preview.php';
    }

}

/**
 * Function add script to page
 */
if (!function_exists('advParallaxBackAdminAddScript')) {

    function advParallaxBackAdminAddScript() {
        $lisParallax = (btParallaxBackgroundUtility::getParallaxListOptions(false));
        $lisp = array();
        foreach ($lisParallax as $key => $value) {
            $lisp[] = '["' . $key . '","' . $value . '"]';
        }
        $lisp = '[' . implode(',', $lisp) . ']';
        wp_enqueue_style('jquery-ui-style', plugins_url('ap_background/assets/css/admin_style.css'));
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');
        wp_enqueue_style('wp-color-picker');

        wp_enqueue_media();
        wp_register_script('apb-admin-script', plugins_url('ap_background/assets/js/admin_script.js'), array('jquery', 'wp-color-picker'));
        wp_register_script('apb-admin-script', plugins_url('ap_background/assets/js/jquery-ui.min.js'), array('jquery'));
        wp_localize_script('apb-admin-script', 'btAdvParallaxBackgroundCfg', array('siteUrl' => admin_url(), 'baseUrl' => site_url(), 'ajaxUrl' => admin_url('admin-ajax.php'), 'parallaxs' => $lisp));
        wp_enqueue_script('apb-admin-script');
        $screen = get_current_screen();
        if ($screen->id == 'toplevel_page_bt-advance-parallax-background') {
            wp_enqueue_style('bt-adv-paralax-css', plugins_url('ap_background/assets/css/adv_parallax_styles.css'));
            wp_enqueue_script('jquery-parallax', plugins_url('ap_background/assets/js/jquery.parallax-1.1.3.js'), array('jquery'), '1.0.0', true);
            wp_enqueue_script('jquery-easing', plugins_url('ap_background/assets/js/jquery.easing.1.3.js'), array('jquery'), '1.0.0', true);
            wp_enqueue_script('bt-adv-parallax-js', plugins_url('ap_background/assets/js/jquery.apparallax.js'), array('jquery'), '1.0.0', true);
        }
    }

}



/**
 * Function process and save parallax
 */
if (!function_exists('advParallaxBackAdminSaveSlider')) {

    function advParallaxBackAdminSaveSlider() {
        $bt_utility = new btParallaxBackgroundUtility();
        if (isset($_POST)) {
            global $wpdb;
            $msg = '';
            $alias = $_POST['alias_name'];

            //Kiem tra silde name, neu chua duoc nhap thi gan message cho bien $msg
            if ($_POST['slide_name'] == '') {
                $msg .= '- Please input slider name';
            }

            //Ham kiem tra va khoi tao alias cho parallax slide neu chua duoc nhap
            if ($alias == '') {
                $alias = $bt_utility->createAlias($_POST['slide_name']);
            }

            //Kiem tra va xu ly form dua vao bien msg
            //Neu bien msg la rong thi form hop le vaf thuc hien luu du lieu vaof database nguoc lai tra ve thong bao loi tren form
            if ($msg == '') {
                $items = $_POST['settings']['media_source']['items'];
                $content_type = $_POST['settings']['content_type'];

                //Xu ly anh doi voi kieu noi dung la image gallery
                $btImageProcess = new APImageHelper();
                $url_return_if_false = admin_url('admin.php?page=bt-advance-parallax-background/create-new&content_type=' . $_POST['settings']['content_type']) . (isset($_POST['edit_id']) ? '&id=' . $_POST['edit_id'] : '');
                if (!empty($items) && $content_type == 'image-gallery') {
//                    Khoi tao duong dan va thu muc chua anh
                    $image_save = ABSPATH . 'wp-content/uploads/ap_background/';
                    $original = $image_save . 'original';
                    $thumb = $image_save . 'thumb';
                    $oTemp = $original . '/temp';
                    $tTemp = $thumb . '/temp';
                    $new_msg = '';
                    if (!file_exists($image_save)) {
                        $bt_utility->createFolder($image_save);
                    }
                    if (file_exists($image_save) && !is_writable($image_save)) {
                        $new_msg.= '- Folder <strong>' . $image_save . '</strong> can not be written. Check chmod, please.<br/>';
                    }
                    if (!file_exists($original)) {
                        if (!$bt_utility->createFolder($original)) {
                            $new_msg.= '- Can not create <strong>' . $original . '</strong>. Check chmod, please.<br/>';
                        }
                    }
                    if (file_exists($original) && !is_writable($original)) {
                        $new_msg.= '- Folder <strong>' . $original . '</strong> can not be written. Check chmod, please.<br/>';
                    }
                    if (!file_exists($thumb)) {
                        if (!$bt_utility->createFolder($thumb)) {
                            $new_msg.= '- Can not create <strong>' . $thumb . '</strong>. Check chmod, please.<br/>';
                        }
                    }
                    if (file_exists($thumb) && !is_writable($thumb)) {
                        $new_msg.= '- Folder <strong>' . $thumb . '</strong> can not be written. Check chmod, please.<br/>';
                    }
                    if (!file_exists($tTemp)) {
                        if (!$bt_utility->createFolder($tTemp)) {
                            $new_msg.= '- Can not create <strong>' . $tTemp . '</strong>. Check chmod, please.<br/>';
                        }
                    }
                    if (file_exists($tTemp) && !is_writable($tTemp)) {
                        $new_msg.= '- Folder <strong>' . $tTemp . '</strong> can not be written. Check chmod, please.<br/>';
                    }
                    if (!file_exists($oTemp)) {
                        if (!$bt_utility->createFolder($oTemp)) {
                            $new_msg.= '- Can not create <strong>' . $oTemp . '</strong>. Check chmod, please.<br/>';
                        }
                    }
                    if (file_exists($oTemp) && !is_writable($oTemp)) {
                        $new_msg.= '- Folder <strong>' . $oTemp . '</strong> can not be written. Check chmod, please.';
                    }
                    if ($new_msg) {
                        $_SESSION['bt_message'] = $bt_utility->getMessage(__($new_msg), 'error');
                        wp_redirect($url_return_if_false);
                        return false;
                    }

                    //Khai bao bien danh sach item moi de luu lai gia tri cua danh sach item sau khi da duoc xu ly.
                    $new_items = array();
                    //Duyet qua va xu lytung phan tu cua mang item, sau do lu gia tri da duoc xu ly vao mang $new_items
                    foreach ($items as $item) {
                        $item_data = json_decode(stripslashes($item));
                        if ($item_data->large) {
                            $largeFile = $item_data->large;
                            if (strpos($largeFile, '?')) {
                                $largeFile = substr($largeFile, 0, strpos($largeFile, '?'));
                            }
                            $extension = $bt_utility->getFileExtension($largeFile);
                            $filename = md5($largeFile) . '.' . $extension;
                            $url = str_replace(site_url(), ABSPATH, $item_data->large, $count);
                            if ($count) {
                                $url = str_replace('//', '/', $url);
                            } else {
                                if (substr($url, 0, 4) != 'http') {
                                    $url = ABSPATH . $url;
                                    $url = str_replace('//', '/', $url);
                                }
                            }
                            $file_content = file_get_contents($url);
                            file_put_contents($oTemp . '/' . $filename, $file_content);
                            if (file_exists($oTemp . '/' . $filename)) {
                                $process = $_POST['settings']['layout_setting']['thumb_process'];
                                $btImageProcess->loadImage($oTemp . '/' . $filename);

                                //Xu ly anh voi tuy chonj khong xu ly (anh duoc giu nguyen kich thuoc)
                                if ($process == 'none') {
                                    copy($oTemp . '/' . $filename, $tTemp . '/' . $filename);
                                }

                                //Xu ly anh voi tuy chon crop (anh duoc crop theo kich thuoc da thiet lap)
                                if ($process == 'crop') {
                                    $btImageProcess->resize($tTemp . '/' . $filename, $_POST['settings']['layout_setting']['thumb_width'], $_POST['settings']['layout_setting']['thumb_height'], 100, TRUE);
                                }

                                //Xu ly anh voi tuy chon resize and keep ratio (Anh duoc resize sau do crop theo chieu co kich thuoc nho de dat duoc kich thuoc da thiet lap)
                                if ($process == 'resizekeepratio') {
                                    list($iWidth, $iHeight) = getimagesize($oTemp . '/' . $filename);
                                    if ($iWidth > $iHeight) {
                                        $btImageProcess->resizeToWidth($tTemp . '/' . $filename, $_POST['settings']['layout_setting']['thumb_width']);
                                    } else {
                                        $btImageProcess->resizeToHeight($tTemp . '/' . $filename, $_POST['settings']['layout_setting']['thumb_height']);
                                    }
                                }

                                //Xu ly anh voi tuy chon resize(Anh duoc resize ve kich thuoc duoc thiet lap - co lam meo anh)
                                if ($process == 'resize') {
                                    $btImageProcess->resize($tTemp . '/' . $filename, $_POST['settings']['layout_setting']['thumb_width'], $_POST['settings']['layout_setting']['thumb_height']);
                                }
                                $item_data->thumbnail = $filename;
                            }
                            $item_data->large = str_replace(site_url(), '', $item_data->large);

                            $new_items[] = $item_data;
                        }
                    }
                    $_POST['settings']['media_source']['items'] = $new_items;
                }
                if (!empty($items) && $content_type == 'video-background') {
//                    Khoi tao duong dan va thu muc chua anh
                    $image_save = ABSPATH . 'wp-content/uploads/ap_background/';
                    $original = $image_save . 'video';
                    $oTemp = $original . '/temp';
                    $new_msg = '';
                    if (!file_exists($image_save)) {
                        $bt_utility->createFolder($image_save);
                    }
                    if (file_exists($image_save) && !is_writable($image_save)) {
                        $new_msg.= '- Folder <strong>' . $image_save . '</strong> can not be written. Check chmod, please.<br/>';
                    }
                    if (!file_exists($original)) {
                        if (!$bt_utility->createFolder($original)) {
                            $new_msg.= '- Can not create <strong>' . $original . '</strong>. Check chmod, please.<br/>';
                        }
                    }
                    if (file_exists($original) && !is_writable($original)) {
                        $new_msg.= '- Folder <strong>' . $original . '</strong> can not be written. Check chmod, please.<br/>';
                    }
                    if (!file_exists($oTemp)) {
                        if (!$bt_utility->createFolder($oTemp)) {
                            $new_msg.= '- Can not create <strong>' . $oTemp . '</strong>. Check chmod, please.<br/>';
                        }
                    }
                    if (file_exists($oTemp) && !is_writable($oTemp)) {
                        $new_msg.= '- Folder <strong>' . $oTemp . '</strong> can not be written. Check chmod, please.';
                    }
                    if ($new_msg) {
                        $_SESSION['bt_message'] = $bt_utility->getMessage(__($new_msg), 'error');
                        wp_redirect($url_return_if_false);
                        return false;
                    }

                    //Khai bao bien danh sach item moi de luu lai gia tri cua danh sach item sau khi da duoc xu ly.
                    $new_items = array();

                    //Duyet qua va xu lytung phan tu cua mang item, sau do lu gia tri da duoc xu ly vao mang $new_items
                    foreach ($items as $item) {
                        $item_data = json_decode(stripslashes($item));
                        if ($item_data->media_source == 'upload') {
                            $item_data->video_url = str_replace(site_url(), '', $item_data->video_url);
                        }
                        $new_items[] = $item_data;
                    }
                    $_POST['settings']['media_source']['items'] = $new_items;
                }

                //Xu ly background parallax
                if ($_POST['settings']['background_settings']['image']['background_image'] != '') {
                    $_POST['settings']['background_settings']['image']['background_image'] = str_replace(site_url(), '', $_POST['settings']['background_settings']['image']['background_image']);
                }
                if ($_POST['settings']['background_settings']['video']['video_url'] != '') {
                    $video_background = json_decode(stripslashes($_POST['settings']['background_settings']['video']['video_url']));
                    $video_background->video_url = str_replace(site_url(), '', $video_background->video_url);
                    $_POST['settings']['background_settings']['video']['video_url'] = $video_background;
                }

                //CHuan bi du lieu de luu vao database
                $data = array(
                    'name' => $_POST['slide_name'],
                    'alias' => $alias,
                    'content' => $_POST['side_content'],
                    'created' => time(),
                    'modified' => time(),
                    'settings' => json_encode($_POST['settings']),
                    'status' => 1
                );

                //
                if (isset($_POST['ap_background_flickr_api'])) {
                    if (!get_option('ap_background_flickr_api')) {
                        add_option('ap_background_flickr_api', $_POST['ap_background_flickr_api']);
                    } else {
                        update_option('ap_background_flickr_api', $_POST['ap_background_flickr_api']);
                    }
                }
                if (isset($_POST['ap_background_google_api'])) {
                    if (!get_option('ap_background_google_api')) {
                        add_option('ap_background_google_api', $_POST['ap_background_google_api']);
                    } else {
                        update_option('ap_background_google_api', $_POST['ap_background_google_api']);
                    }
                }
                if (isset($_POST['edit_id'])) {
                    $id = $_POST['edit_id'];
                    unset($data['created']);
                    if (!empty($items) && $content_type == 'image-gallery') {
                        //Xoa file trong thu muc thumb theo id
                        $tFiles = glob($thumb . '/' . $id . '/*'); // get all file names
                        foreach ($tFiles as $tfile) { // iterate files
                            if (is_file($tfile)) {
                                unlink($tfile);
                            } // delete file
                        }
                        //Xoa thu muc thumb theo id
                        if (is_dir($thumb . '/' . $id)) {
                            rmdir($thumb . '/' . $id);
                        }

                        //Doi ten thu muc temb thanh thu muc thumb id
                        if (is_dir($tTemp)) {
                            rename($tTemp, $thumb . '/' . $id);
                        }

                        //Xoa file trong thu muc original theo id
                        $oFiles = glob($original . '/' . $id . '/*'); // get all file names
                        foreach ($oFiles as $ofile) { // iterate files
                            if (is_file($ofile))
                                unlink($ofile); // delete file
                        }

                        //Xoa thu muc original theo id
                        if (is_dir($original . '/' . $id)) {
                            rmdir($original . '/' . $id);
                        }

                        //Doi ten thu muc temb thanh thu muc original id
                        if (is_dir($oTemp)) {
                            rename($oTemp, $original . '/' . $id);
                        }
                    }

                    //Update gia tri moi cho parallax slider
                    $up = $wpdb->update($wpdb->prefix . "ap_background", $data, array('id' => $id));
                    if ($up) {
                        $_SESSION['bt_message'] = $bt_utility->getMessage(__('Slider data has been updated'));
                    } else {
                        $_SESSION['bt_message'] = $bt_utility->getMessage(__($wpdb->last_error), 'error');
                    }
                } else {
                    //Them moi parallax slider
                    $ins = $wpdb->insert($wpdb->prefix . "ap_background", $data);
                    if ($ins) {
                        $id = $wpdb->insert_id;
                        //Doi ten thu muc temp thanh thu muc id tuong ung
                        if (!empty($items) && $content_type == 'image-gallery') {
                            rename($tTemp, $thumb . '/' . $id);
                            rename($oTemp, $original . '/' . $id);
                        }
                        $_SESSION['bt_message'] = $bt_utility->getMessage(__('Slider has been created'));
                    } else {
                        $_SESSION['bt_message'] = $bt_utility->getMessage(__($wpdb->last_error), 'error');
                    }
                }
            } else {
                $_SESSION['bt_message'] = $bt_utility->getMessage($msg, 'error');
            }
            if (isset($_POST['after_save']) && $_POST['after_save']) {
                wp_redirect(admin_url('admin.php?page=bt-advance-parallax-background'));
            } else {
                wp_redirect(admin_url('admin.php?page=bt-advance-parallax-background/create-new&content_type=' . $_POST['settings']['content_type']) . (isset($id) ? '&id=' . $id : ''));
            }
        } else {
            $_SESSION['bt_message'] = $bt_utility->getMessage(__('There is some error occurred, please try again later'), 'error');
            wp_redirect(admin_url('admin.php?page=bt-advance-parallax-background'));
        }
    }

}

/**
 * Function get list of album image from internet (Facebook, Flickr, Google)
 */
function getImageAlbums() {
    $bt_utility = new btParallaxBackgroundUtility();
    $result = array('success' => false, 'message' => '', 'data' => null);
    $api = $_POST['api'];
    $source = $_POST['source'];
    $username = $_POST['username'];

    //Xu ly du lieu voi truong hop get image tu flickr
    if ($source == 'flickr') {
        //Kiem tra neu chua co flickr ipi thi tra ve thong bao loi
        if ($api == '') {
            $result['message'] = __('Please input Flickr API');
            $bt_utility->obEndClear();
            echo json_encode($result);
        } else {//Neu flickr api da co thi thuc hien xu ly du lieu
            //Set param de chuan bi lay du lieu tu flick
            $params = array();
            $params['api_key'] = $api;
            $params['format'] = 'php_serial';
            //Kiem tra du lieu nhap vao laf email hay username de gan gia tri cho param tuong ung
            if (filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
                $params['method'] = 'flickr.people.findByEmail';
                $params['find_email'] = $_POST['username'];
            } else {
                $params['method'] = 'flickr.people.findByUsername';
                $params['username'] = $_POST['username'];
            }

            //Get data tu flick tu cac param da thiet lap
            $auth = $bt_utility->flickrGetData($params);

            //Thiet lap param de lay ve danh sach album
            $listParams = array();
            $listParams['api_key'] = $api;
            $listParams['format'] = 'php_serial';
            $listParams['method'] = 'flickr.photosets.getList';
            $listParams['user_id'] = $auth['user']['id'];
            $listParams['per_page'] = 500;

            //Thuc hien lay ve danh sach album tu Flickr
            $list_album = $bt_utility->flickrGetData($listParams);
            if (count($list_album['photosets']['photoset']) > 0) {
                $albums = array();
                $albums[] = '<option value="">' . __('Please select an album') . '</option>';
                foreach ($list_album['photosets']['photoset'] as $album) {
                    $albums[] = '<option value="' . $album['id'] . '">' . $album['title']['_content'] . '</option>';
                }
                $data = implode($albums);
                $result['success'] = true;
                $result['message'] = __('Albums have been gotten');
                $result['data'] = $data;
            } else {
                $result['success'] = true;
                $result['message'] = __('No album was found');
                $result['data'] = '<option value="">' . __('Please select an album') . '</option>';
            }
        }
    }

    //Get album tu picasa
    if ($source == 'picasa') {
        //Thiet lap url data de lay du lieu
        $feedURL = 'http://picasaweb.google.com/data/feed/api/user/' . $username . '?alt=rss&kind=album';
        //Get data from url
        @$list_album = simplexml_load_file($feedURL);
        //Kiem tra du lieu lay ve, neu co album duoc tim thay thi dao danh sach cac album
        if (isset($list_album) && $list_album) {
            $albums = array();
            $albums[] = '<option value="">' . __('Please select an album') . '</option>';
            foreach ($list_album->channel->item as $album) {
                $guid = (string) $album->guid;
                $albumID = substr($guid, strrpos($guid, '/') + 1, strrpos($guid, '?') - 1 - strrpos($guid, '/'));
                $albums[] = '<option value="' . $albumID . '">' . $album->title . '</option>';
            }
            $data = implode($albums);
            $result['success'] = TRUE;
            $result['message'] = __('All albums have been gotten');
            $result['data'] = $data;
        } else {//Khong tim thay album thi tra ve danh sach rong
            $result['success'] = TRUE;
            $result['message'] = __('No album was found');
            $result['data'] = '<option value="">' . __('Please select an album') . '</option>';
        }
    }

    //Get data from facebook
    if ($source == 'facebook') {
        //Xu ly gia tri va tao url de lay du lieu
        $furl = rtrim($username, '/');
        $funame = end(explode('/', $furl));
        $feedURL = 'https://graph.facebook.com/' . $funame . '/albums';

        //Lay du lieu tu url da duoc tao
        $list_album = file_get_contents($feedURL);

        //Kiem tra du lieu lay ve, neu co album duoc thim thay thi tao danh sach album
        if (isset($list_album) && $list_album) {
            $albums = array();
            $listAlbum = json_decode($list_album);
            $albums[] = '<option value="">' . __('Please select an album') . '</option>';
            foreach ($listAlbum->data as $album) {
                $albums[] = '<option value="' . $album->id . '">' . $album->name . '</option>';
            }
            $data = implode($albums);
            $result['success'] = TRUE;
            $result['message'] = __('All albums have been gotten');
            $result['data'] = $data;
        } else {//Khong co album nao duoc tim thay thi tao danh sach rong
            $result['success'] = TRUE;
            $result['message'] = __('No album was found');
            $result['data'] = '<option value="">' . __('Please select an album') . '</option>';
        }
    }

    //Xoa ob va echo ket qua tra ve.00
    $bt_utility->obEndClear();
    echo json_encode($result);
    exit();
}

/**
 * Function get video from URL
 */
function getVideoFromUrl() {
    $source = $_POST['source'];
    $url = rtrim($_POST['url'], '/');
    $bt_utility = new btParallaxBackgroundUtility();
    $result = array('success' => false, 'message' => '', 'data' => null);
    //Lay video tu Youtube
    if ($source == 'youtube') {
        $api = $_POST['api'];
        //Kiem tra xem url nhap vao co dung dinh dang hay khong
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $parse_url_1 = explode("?", $url);
            //Kiem tra url nhap vao la username hay video url
            if (count($parse_url_1) > 1) {
                $parse_url = explode("&", $parse_url_1[1]);
                //Kiem tra url nhap vao la video hay playlist
                foreach ($parse_url as $value) {//Truong hop url nhap vao la video
                    $param = explode('=', $value);
                    if ($param[0] == 'v') {
                        $video_id = $param[1];
                        if (strpos($video_id, '#')) {
                            $video_id = substr($video_id, 0, strpos($video_id, '#'));
                        }
                        $result['success'] = TRUE;
                        $result['message'] = __('Video has been gotten');
                        $result['data'] = array($video_id);
                        break;
                    }
                    if ($param[0] == "list") {
                        if (!$api) {
                            $result['message'] = __('Please input google api', 'gmswebdesign');
                        } else {
                            $playlist_id = $param[1];
                            $result['success'] = TRUE;
                            $result['message'] = __('Videos in playlist have been gotten');
                            $result['data'] = $bt_utility->youtubeGetVideoFromPlaylist($playlist_id, $api);
                        }
                        break;
                    }
                }
            } else {//xu ly truong hop url nhap vao la username
                if ($api) {
                    $username = end(explode('/', $parse_url_1[0]));
                    $result['success'] = TRUE;
                    $result['message'] = __('Videos of channel have been gotten');
                    $result['data'] = $bt_utility->youtubeGetVideoByUser($username, $api);
                } else {
                    $result['message'] = __('Please input google api');
                }
            }
        } else {
            $result['success'] = FALSE;
            $result['message'] = __('Youtube url invalid');
        }
    }

//    Get video tu vimeo
    if ($source == 'vimeo') {
        //Kiem tra tinh hop le cua url nhap vao
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $parse_url = explode("/", $url);
            $is_album = $parse_url[count($parse_url) - 2];
            //Kiem tra url nhap vao laf cua album hay video
            if ($is_album == "album") {//Truong hop la album
                $album_id = $parse_url[count($parse_url) - 1];
                $result['success'] = TRUE;
                $result['message'] = __('All videos have been gotten');
                $result['data'] = $bt_utility->vimeoGetVideoFromAlbum($album_id);
            } else {//Truong hop la video
                $video_id = $parse_url[count($parse_url) - 1];
                if (is_numeric($video_id)) {
                    $result['success'] = TRUE;
                    $result['message'] = __('Video has been gotten');
                    $result['data'] = array($video_id);
                } else {
                    $result['success'] = TRUE;
                    $result['message'] = __('Video has been gotten');
                    $result['data'] = $bt_utility->vimeoGetVideoByUser($video_id);
                }
            }
        } else {
            $result['message'] = __('Vimeo url invalid');
        }
    }
    $bt_utility->obEndClear();
    echo json_encode($result);
    exit();
}

/**
 * Function get video
 */
function getVideo() {
    $bt_utility = new btParallaxBackgroundUtility();
    $result = array('success' => false, 'message' => '', 'data' => null);
    $source = $_POST['source'];
    $videoid = $_POST['videoid'];
    //Kiem tra video ID co duoc truyen vao hay khong
    if ($videoid) {//Neu video id dc set thi thuc hien lay video ve theo nguon du lieu tuong ung
        if ($source == 'youtube') {
            $api = $_POST['api'];
            $result = $bt_utility->youtubeGetVideo($videoid, $api);
        }
        if ($source == 'vimeo') {
            $result = $bt_utility->vimeoGetVideo($videoid);
        }
    } else {//Neu video ID khong duocset thi tra ve thong bao loi
        $result['message'] = __('No video ID was set');
    }
    $bt_utility->obEndClear();
    echo json_encode($result);
    exit();
}

/**
 * Function get list image
 */
function getImages() {
    $bt_utility = new btParallaxBackgroundUtility();
    $result = array('success' => false, 'message' => '', 'data' => null);
    $source = $_POST['source'];
    $username = $_POST['username'];
    $api = $_POST['api'];
    $albumid = $_POST['albumid'];
    //Lay anh tu album anh cua picasa google
    if ($source == 'picasa') {
        $feedURL = 'http://picasaweb.google.com/data/feed/base/user/' . $username . '/albumid/' . $albumid . '?max-results=100&alt=rss';
        $photos = @simplexml_load_file($feedURL);
        if (count($photos->channel->item) > 0) {
            $images = array();
            foreach ($photos->channel->item as $photo) {
                $image_url = (string) $photo->enclosure->attributes()->url;
                $images[] = $image_url;
            }
            $result['success'] = TRUE;
            $result['message'] = __('All items have been gotten');
            $result['data'] = $images;
        } else {
            $result['message'] = __('No item was found');
        }
    }

    //Lay anh tu album anh cua facebook
    if ($source == 'facebook') {
        $feedURL = 'https://graph.facebook.com/' . $albumid . '/photos';
        $photosData = json_decode(file_get_contents($feedURL));
        if (count($photosData->data) > 0) {
            $images = array();
            foreach ($photosData->data as $photo) {
                $images[] = $photo->source;
            }
            $result['success'] = TRUE;
            $result['message'] = __('All items have been gotten');
            $result['data'] = $images;
        } else {
            $result['message'] = __('No item was found');
        }
    }

    //Lay anh tu flickr
    if ($source == 'flickr') {
        $listParams = array();
        $listParams['api_key'] = $api;
        $listParams['format'] = 'php_serial';
        $listParams['method'] = 'flickr.photosets.getPhotos';
        $listParams['photoset_id'] = $albumid;
        $listParams['per_page'] = 500;
        $listImages = $bt_utility->flickrGetData($listParams);
        if (count($listImages['photoset']['photo']) > 0) {
            $images = array();
            foreach ($listImages['photoset']['photo'] as $photo) {
                $image_url = 'http://farm' . $photo['farm'] . '.staticflickr.com/' . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '_b.jpg';
                $images[] = $image_url;
            }
            $result['success'] = TRUE;
            $result['message'] = __('All items have been gotten');
            $result['data'] = $images;
        } else {
            $result['message'] = __('No item was found');
        }
    }
    $bt_utility->obEndClear();
    echo json_encode($result);
    exit();
}

/**
 * Function get image
 */
function getImage() {
    $bt_utility = new btParallaxBackgroundUtility();
    $result = array('success' => false, 'message' => '', 'data' => null);
    $source = $_POST['source'];
    $imageid = $_POST['imageid'];
    $result = $bt_utility->getImage($imageid, $source);
    $bt_utility->obEndClear();
    echo json_encode($result);
    exit();
}

/**
 * Function delete single parallax from list
 * 
 * @global type $wpdb
 * 
 */
function listDeleteSingleItem() {
    //Khai bao bien
    global $wpdb;
    $id = $_POST['id'];
    $bt_utility = new btParallaxBackgroundUtility();
    $result = array('success' => false, 'message' => '', 'data' => null);
    //Xoa parallax slider theo id
    $delete = $wpdb->delete($wpdb->prefix . "ap_background", array('id' => $id));
    //Kiem tra viec xoa du lieu thanh cong hay khong
    if ($delete) {//Neu xoa thanh cong thi thuc hien xoa cac du lieu lien quan den parallax slider
        //Khai bao duong dan va thu muc luu tru anh cua parallax slider
        $image_save = ABSPATH . 'wp-content/plugins/ap_background/images/';
        $original = $image_save . 'original';
        $thumb = $image_save . 'thumb';

        //Thuc hien xoa anh thumbnail cua parallax
        if (is_dir($thumb . '/' . $id)) {
            $tFiles = glob($thumb . '/' . $id . '/*'); // get all file names
            foreach ($tFiles as $tfile) { // iterate files
                if (is_file($tfile))
                    unlink($tfile); // delete file
            }
            rmdir($thumb . '/' . $id);
        }

        //Thuc hien xoa anh orighinal cua parallax
        if (is_dir($original . '/' . $id)) {
            $oFiles = glob($original . '/' . $id . '/*'); // get all file names
            foreach ($oFiles as $ofile) { // iterate files
                if (is_file($ofile))
                    unlink($ofile); // delete file
            }
            rmdir($original . '/' . $id);
        }

        $result['success'] = true;
        $result['message'] = __('Item deleted');
    } else {
        $result['message'] = __('Can\'t delete this item');
    }
    $bt_utility->obEndClear();
    echo json_encode($result);
    exit();
}

/**
 * Function delete selected parallax item from list
 * 
 * @global type $wpdb
 */
function listDeleteSelectedItem() {
    //Khai bao cac bien can thiet
    global $wpdb;
    $ids = $_POST['ids'];
    $bt_utility = new btParallaxBackgroundUtility();
    $result = array('success' => false, 'message' => '', 'data' => null);

    //Thuc hien xoa cac parallax duoc chon theo ids
    $delete = $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'ap_background WHERE id IN (' . implode(',', wp_parse_id_list($ids)) . ')');
    //Kiem tra viec xoa du lieu thanh cong hay khong
    if ($delete) {//Neu xoa du lieu thanh cong thi thuc hien xoa cac du lieu lien quan.
        //Khai bao bien duong dan va thu muc luu gia anh cua parallax
        $image_save = ABSPATH . 'wp-content/plugins/ap_background/images/';
        $original = $image_save . 'original';
        $thumb = $image_save . 'thumb';

        //Duy qua tung id cua mang ids vaf thuc hien xoa anh cua parallax tuong ung
        foreach ($ids as $id) {
            //Xoa anh thumbnail
            if (is_dir($thumb . '/' . $id)) {
                $tFiles = glob($thumb . '/' . $id . '/*'); // get all file names
                foreach ($tFiles as $tfile) { // iterate files
                    if (is_file($tfile))
                        unlink($tfile); // delete file
                }
                rmdir($thumb . '/' . $id);
            }
            //Xoa anh original
            if (is_dir($original . '/' . $id)) {
                $oFiles = glob($original . '/' . $id . '/*'); // get all file names
                foreach ($oFiles as $ofile) { // iterate files
                    if (is_file($ofile))
                        unlink($ofile); // delete file
                }
                rmdir($original . '/' . $id);
            }
        }
        $result['success'] = true;
        $result['message'] = __('All Items were deleted');
    } else {
        $result['message'] = __('Can\'t delete this item');
    }
    $bt_utility->obEndClear();
    echo json_encode($result);
    exit();
}

/**
 * Function process copy parallax item 
 * 
 * @global type $wpdb
 */
function listCopyItem() {
    //Khai bao cac bien can thiet
    global $wpdb;
    $id = $_POST['id'];
    $bt_utility = new btParallaxBackgroundUtility();
    $result = array('success' => false, 'message' => '', 'data' => null);

    //Lay ve thong tin cua parallax item can copy theo id
    $itemCopyQuery = $wpdb->get_results(
            $wpdb->prepare('SELECT name,alias,content,settings,status FROM ' . $wpdb->prefix . 'ap_background WHERE id=%d', $id)
    );
    $itemCopy = $itemCopyQuery[0];

    //Khoi tao gia tri cho item moi (coppy)
    $data = array(
        'name' => $itemCopy->name . ' (Copy)',
        'alias' => $bt_utility->createAlias($itemCopy->name, true),
        'content' => $itemCopy->content,
        'created' => time(),
        'modified' => time(),
        'settings' => $itemCopy->settings,
        'status' => $itemCopy->status
    );
    //Them parallax slider moi vao bang du lieu
    $ins = $wpdb->insert($wpdb->prefix . "ap_background", $data);

    //Xu ly du lieu neu viec them moi thanh cong
    if ($ins) {
        $settings = json_decode($data['settings']);
        switch ($settings->content_type) {
            case 'image-gallery':
                $item_type = 'Image Gallery';
                break;
            case 'video-background':
                $item_type = 'Video Background';
                break;
            case 'woo-commerce':
                $item_type = 'Woo Commerce';
                break;
            default:
                $item_type = 'Wordpress Posts';
                break;
        }
        //Tao html output de them moi row vao danh sach
        $idNew = $wpdb->insert_id;
        $html = array();
        $html[] = '<div class="item">';
        $html[] = '<div class="row row-checkbox" style="">';
        $html[] = '<input type="checkbox" name="fields[]" value="' . $idNew . '"/>';
        $html[] = '</div>';
        $html[] = '<div scope="row" class="row row-id" style="">' . $idNew . '</div>';
        $html[] = '<a href="' . admin_url('admin.php?page=bt-advance-parallax-background/create-new&content_type=' . $settings->content_type . '&id=' . $idNew) . '">';
        $html[] = '<div scope="row" class="row row-title" style="">' . $data['name'] . '</div>';
        $html[] = '</a>';
        $html[] = '<div scope="row" class="row row-short-code" style="">[adv_parallax_back alias=' . $data['alias'] . ']</div>';
        $html[] = '<div scope="row" class="row row-type" style="">' . $item_type . '</div>';
        $html[] = '<div scope="row" class="row row-last-modify" style="">';
        $html[] = '<span>' . date('m/d/Y', $data['modified']) . '</span>';
        $html[] = '</div>';
        $html[] = '<div scope="row" class="row row-published" style="">';
        $html[] = '<span>' . ($data['status'] == 1) ? 'Yes' : 'No' . '</span>';
        $html[] = '</div>';
        $html[] = '<div scope="row" class="row row-action" style="">';
        $html[] = '<a href="' . admin_url('admin.php?page=bt-advance-parallax-background/create-new&content_type=' . $settings->content_type . '&id=' . $idNew) . '">';
        $html[] = '<span class="button green" title="' . __('Edit', 'gmswebdesign') . '"><i class="fa fa-pencil"></i></span>';
        $html[] = '</a>';
        $html[] = '<span class="button red delete" title="' . __('Delete', 'gmswebdesign') . '"><i class="fa fa-times"></i></span>';
        $html[] = '<span class="button blue copy" title="' . __('Copy', 'gmswebdesign') . '"><i class="fa fa-copy"></i></span>';
        $html[] = '<a href="' . admin_url('admin.php?page=bt-advance-parallax-background/preview&id=' . $idNew) . '" target="_blank">';
        $html[] = '<span class="button original preview" title="' . __('Preview', 'gmswebdesign') . '"><i class="fa fa-desktop"></i></span>';
        $html[] = '</a>';
        $html[] = '<span class="bt-ajax-loading list-item-ajax"><i class="fa fa-circle-o-notch fa-spin"></i></span>';
        $html[] = '</div>';
        $html[] = '<div class="clear"></div>';
        $html[] = '</div>';
        $result['success'] = true;
        $result['message'] = __('Slider has been copied');
        $result['data'] = implode($html);
    } else {//Them moi that bai, tra ve thong bao loi
        $result['message'] = __('Can\'t save sider');
    }
    $bt_utility->obEndClear();
    echo json_encode($result);
    exit();
}

/**
 * Function get video background
 */
function getVideobackground() {
    $bt_utility = new btParallaxBackgroundUtility();
    $result = array('success' => false, 'message' => '', 'data' => null);
    $url = $_POST['url'];
    //Kiem tra url nhap vao va xu ly neu la url video cua youtube
    if ($bt_utility->getHostFromUrl($url) == 'youtube') {
        $parse_url_1 = explode("?", $url);
        $api = get_option('ap_background_google_api');
        if (count($parse_url_1) > 1) {
            $parse_url = explode("&", $parse_url_1[1]);
            foreach ($parse_url as $value) {
                $param = explode('=', $value);
                if ($param[0] == 'v') {
                    $video_id = $param[1];
                    if (strpos($video_id, '#')) {
                        $video_id = substr($video_id, 0, strpos($video_id, '#'));
                    }
                    $videoObj = array();
                    $video_image = 'http://img.youtube.com/vi/' . $video_id . '/0.jpg';
                    if ($api) {
                        $urlFeed = 'https://www.googleapis.com/youtube/v3/videos?id=' . $video_id . '&key=' . $api . '&part=snippet,contentDetails,statistics,status';
                        //lay noi dung video tu url feed
                        $video = json_decode(@file_get_contents($urlFeed));
                        if (!empty($video->items)) {
                            $videoObj['video_url'] = $video_id;
                            $videoObj['large'] = $video_image;
                            $videoObj['media_source'] = 'youtube';

                            $result['success'] = TRUE;
                            $result['message'] = __('File has been gotten successfully');
                            $result['data'] = json_encode($videoObj);
                        } else {
                            $result['message'] = __('This video has been removed by the user.');
                        }
                    } else {
                        $videoObj['video_url'] = $video_id;
                        $videoObj['large'] = $video_image;
                        $videoObj['media_source'] = 'youtube';

                        $result['success'] = TRUE;
                        $result['message'] = __('File has been gotten successfully');
                        $result['data'] = json_encode($videoObj);
                    }
                    break;
                } else {
                    $result['message'] = __('Please input youtube video url');
                }
            }
        }
    } else if ($bt_utility->getHostFromUrl($url) == 'vimeo') {//Xu ly truong hop url nhap vao la cua vimeo
        $parse_url = explode("/", $url);
        $is_album = $parse_url[count($parse_url) - 2];
        if ($is_album == "album") {
            $result['message'] = __('This is a vimeo album url, please input a video url to get it.');
        } else {
            $video_id = $parse_url[count($parse_url) - 1];
            if (is_numeric($video_id)) {
                $videoObj = array();
                $urlFeed = 'http://vimeo.com/api/v2/video/' . $video_id . '.xml';
                $video = @simplexml_load_file($urlFeed);
                if ($video) {
                    $videoObj['video_url'] = $video_id;
                    $videoObj['large'] = (string) $video->video->thumbnail_large;
                    $videoObj['media_source'] = 'vimeo';
                    $result['success'] = TRUE;
                    $result['message'] = __('Video has been gotten');
                    $result['data'] = json_encode($videoObj);
                }
            } else {
                $result['message'] = __('Please input a single video url.');
            }
        }
    } else if ($bt_utility->getHostFromUrl($url) == 'direct') {//Xu ly get video voi truong hop la video url truc tiep
        $videoObj['video_url'] = $url;
        $videoObj['large'] = '';
        $videoObj['media_source'] = 'direct';
        $result['success'] = TRUE;
        $result['message'] = __('Video has been gotten');
        $result['data'] = json_encode($videoObj);
    } else {//Neu khong phai 1 trong 3 truong hop tren thi bao loi
        $result['message'] = $bt_utility->getHostFromUrl($url);
    }
    $bt_utility->obEndClear();
    echo json_encode($result);
    exit();
}

/**
 * Function get default css effect content
 */
function loadContentEffectCssAjax() {
    //Khai bao va gan gia tri cho cac bien can thiet
    $bt_utility = new btParallaxBackgroundUtility();
    $result = array('success' => false, 'message' => '', 'data' => null);
    $effect_in = 'in-' . $_POST['effect_in'];
    $effect_out = 'out-' . $_POST['effect_out'];
    $type = $_POST['type'];

    //Lay noi dung css
    $css_content = $bt_utility->loadContentEffectCss($effect_out, $effect_in, $type);
    //Kiem tra xem co lay duoc noi dung css khong
    if ($css_content) {//Neu lay duoc thi tra ve ket qua dung kem noi dung css
        $result['success'] = true;
        $result['message'] = __('Content was loaded successfully');
        $result['data'] = $css_content;
    } else {//Neu khong lay duoc tra ve ket qua sai va thong bao loi
        $result['message'] = __('Can\'t get content');
    }
    $bt_utility->obEndClear();
    echo json_encode($result);
    exit();
}

/**
 * Function create button on imce, allow user create open parallax content
 */
function btAddButton() {
    add_filter("mce_external_plugins", "ap_add_buttons");
    add_filter('mce_buttons', 'ap_register_buttons');
}

/**
 * Function add js for button on imce
 * 
 * @param type $plugin_array
 * @return type
 */
function ap_add_buttons($plugin_array) {
    $screen = get_current_screen();
    if ($screen->id == 'admin_page_bt-advance-parallax-background/create-new') {
        $plugin_array['ap_background_buttons'] = plugins_url('ap_background/assets/js/ap_editor_buttons.js');
    } else {
        $plugin_array['ap_background_buttons'] = plugins_url('ap_background/assets/js/ap_editor_ins_buttons.js');
    }
    return $plugin_array;
}

/**
 * Function register button name 
 * @param type $buttons
 * @return type
 */
function ap_register_buttons($buttons) {
    array_push($buttons, 'ap_add_button');
    return $buttons;
}

/**
 * Function Integration parallax plugin with Visual composer
 * @return type
 */
function addVisualComposerButton() {
    // Check if Visual Composer is installed
    if (!defined('WPB_VC_VERSION')) {
        return;
    }

    vc_map(array(
        "name" => __("AP Background", 'gmswebdesign'),
        "description" => __("BT Advanced Parallax Background", 'gmswebdesign'),
        "base" => "adv_parallax_back",
        "class" => "",
        "controls" => "full",
        "icon" => plugins_url('ap_background/assets/images/btparallax_visualcompose_icon.png'), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
        "category" => __('Content', 'js_composer'),
        //'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
        //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
        //Khai bao va khoi tao cac truong gia tri cho plugin
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => __("Select Background", 'gmswebdesign'),
                "param_name" => "alias",
                "value" => btParallaxBackgroundUtility::getParallaxListOptions(true),
                "description" => __("Choose BT Advenced Parallax Background", 'gmswebdesign')
            )
        )
    ));
}

/**
 * Function parallax Preview
 * @global type $wpdb
 */
function parallaxItemPreview() {
    $bt_utility = new btParallaxBackgroundUtility();
    $result = array('success' => false, 'message' => '', 'data' => null);
    if (isset($_POST['id']) && $_POST['id'] != 0) {
        global $wpdb;
        $get_result = $wpdb->get_results($wpdb->prepare('SELECT alias FROM ' . $wpdb->prefix . 'ap_background WHERE id=%d', $_POST['id']));
        if (!empty($get_result)) {
            $result['message'] = __('Parallax content preview loaded successfully');
            $result['success'] = true;
            $result['data'] = do_shortcode('[adv_parallax_back alias=' . $get_result[0]->alias . ']');
        }
    } else {
        $result['message'] = __('No parallax id');
    }
    $bt_utility->obEndClear();
    echo json_encode($result);
    exit();
}
