<?php

/**
 * Class contains useful functions of the plugin
 *
 * @author  Inwavethemes
 * @package AP Background
 * @version 1.0.0
 */
class btParallaxBackgroundUtility {

    /**
     * 
     * @param String $message
     * @param String $type
     * @return String create message.
     * 
     */
    function getMessage($message, $type = 'success') {
        $html = array();
        $class = 'success';
        if ($type == 'error') {
            $class = 'error';
        }
        if ($type == 'notice') {
            $class = 'notice';
        }
        $html[] = '<div class="bt-message ' . $class . '">';
        $html[] = '<div class="message-text">' . $message . '</div>';
        $html[] = '</div>';
        return implode($html);
    }

    /**
     * Function create select option field
     * 
     * @param type $id
     * @param String $name Name of field
     * @param String $value The value field
     * @param Array $data list data option of field
     * @param String $text Default value of field
     * @param String $class Class of field
     * @param Bool $multi Field allow multiple select of not
     * @return String Select option field
     * 
     */
    function selectFieldRender($id, $name, $value, $data, $text = '', $class = '', $multi = true) {
        $html = array();
        $multiselect = '';
        //Kiem tra neu bien class ton tai thi them class vao field
        if ($class) {
            $class = 'class="' . $class . '"';
        }

        //Kiem tra neu field can tao cho phep multiple
        if ($multi) {
            $multiselect = 'multiple="multiple"';
            $html[] = '<select id="' . $id . '" ' . $class . ' name="' . $name . '[]" ' . $multiselect . '>';
            if ($text) {
                $html[] = '<option value="">' . __($text) . '</option>';
            }
        } else {
            $html[] = '<select ' . $class . ' name="' . $name . '" id="' . $id . '">';
            if ($text) {
                $html[] = '<option value="">' . __($text) . '</option>';
            }
        }

        //Duyet qua tung phan tu cua mang du lieu de tao option tuong ung
        foreach ($data as $option) {
            if (is_array($value)) {
                if (in_array($option['value'], $value)) {
                    $html[] = '<option value="' . $option['value'] . '" selected="selected">' . $option['text'] . '</option>';
                } else {
                    $html[] = '<option value="' . $option['value'] . '">' . __($option['text']) . '</option>';
                }
            } else {
                $html[] = '<option value="' . $option['value'] . '" ' . (($option['value'] == $value) ? 'selected="selected"' : '') . '>' . __($option['text']) . '</option>';
            }
        }
        $html[] = '</select>';

        return implode($html);
    }

    /**
     * Clean (erase) the output buffer and turn off output buffering
     */
    public function obEndClear() {
        $obLevel = ob_get_level();
        while ($obLevel > 0) {
            ob_end_clean();
            $obLevel--;
        }
    }

    /**
     * Function check and create alias
     * @param type $title
     * @param type $isCopy
     * @return type
     */
    public static function createAlias($title, $isCopy = FALSE) {
        require_once 'unicodetoascii.php';
        if (class_exists('unicodetoascii')) {
            $calias = new unicodetoascii();
            $alias = $calias->asciiAliasCreate($title);
        } else {
            $alias = str_replace(' ', '-', strtolower($title));
        }
        //xu ly truong hop alias duoc tao ra do copy tu 1 item khac
        if ($isCopy) {
            $newAlias = explode('-', $alias);
            if (count($newAlias) > 1 && is_numeric(end($newAlias))) {
                unset($newAlias[count($newAlias) - 1]);
            }
            $alias = implode('-', $newAlias);
        }
        $listAlias = self::getAllAlias($alias);
        $alias = self::generateAlias($alias, $listAlias);
        return $alias;
    }

    /**
     * function create alias
     * 
     * @param String $alias
     * @param Array $listAlias
     * @return string
     */
    static function generateAlias($alias, $listAlias) {
        if ($listAlias) {
            $listEndAlias = array();
            foreach ($listAlias as $value) {
                $parseAlias = explode("-", $value['alias']);
                if (is_numeric(end($parseAlias))) {
                    $listEndAlias[] = end($parseAlias);
                }
            }
            if (empty($listEndAlias)) {
                $alias = $alias . '-2';
            } else {
                $endmax = max($listEndAlias);
                $alias = $alias . '-' . ($endmax + 1);
            }
        }
        return $alias;
    }

    /**
     * function takes on all the alias alias similar to the present
     * @global type $wpdb
     * @param String $alias
     * @return Array list alias
     */
    static function getAllAlias($alias) {
        global $wpdb;
        $listAlias = $wpdb->get_results($wpdb->prepare('SELECT id, alias FROM ' . $wpdb->prefix . 'ap_background WHERE alias LIKE "%s"', $alias . '%'));

        foreach ($listAlias as $value) {
            $rs[] = array('id' => $value->id, 'alias' => $value->alias);
        }
        return $rs;
    }

    /**
     * Function get video from Youtube
     * @param String $video_id
     * @return type
     */
    function youtubeGetVideo($video_id, $api) {
        //Khai bao va gan gia tri cho cac bien can thiet
        $result = array('success' => false, 'message' => '', 'data' => null);
        $videoObj = array();
        $video_image = 'http://img.youtube.com/vi/' . $video_id . '/0.jpg';
        if ($api) {
            $urlFeed = 'https://www.googleapis.com/youtube/v3/videos?id=' . $video_id . '&key=' . $api . '&part=snippet,contentDetails,statistics,status';
            //lay noi dung video tu url feed
            $video = json_decode(@file_get_contents($urlFeed));
            //Kiem tra xem video co lay duoc khong
            if (!empty($video->items)) {//Xu ly neu video lay ve thanh cong
                $videoObj['video_url'] = $video_id;
                $videoObj['large'] = $video_image;
                $videoObj['media_source'] = 'youtube';

                $rs_html = self::createHTML(json_encode($videoObj));

                $result['success'] = TRUE;
                $result['message'] = __('File has been gotten successfully');
                $result['data'] = $rs_html;
            } else {//Xu ly neu video khong lay duoc
                $result['message'] = __('This video has been removed by the user.');
            }
        } else {
            $videoObj['video_url'] = $video_id;
            $videoObj['large'] = $video_image;
            $videoObj['media_source'] = 'youtube';

            $rs_html = self::createHTML(json_encode($videoObj));

            $result['success'] = TRUE;
            $result['message'] = __('File has been gotten successfully');
            $result['data'] = $rs_html;
        }
        return $result;
    }

    /**
     * Function get video from vimeo
     * @param type $video_id
     * @return type
     */
    public static function vimeoGetVideo($video_id) {
        //Khai bao va gan gia tri cho cac bien can thiet
        $result = array('success' => false, 'message' => '', 'data' => null);
        $videoObj = array();
        $urlFeed = 'http://vimeo.com/api/v2/video/' . $video_id . '.xml';
        //Get noi dung vidoe tu video url feed
        $video = @simplexml_load_file($urlFeed);

        //Kiem tra xem video co get thanh cong hay khong
        if ($video) {//Xu ly neu video get thanh cong
            $videoObj['video_url'] = $video_id;
            $videoObj['large'] = (string) $video->video->thumbnail_large;
            $videoObj['media_source'] = 'vimeo';


            $rs_html = self::createHTML(json_encode($videoObj));

            $result['success'] = TRUE;
            $result['message'] = __('Video has been gotten');
            $result['data'] = $rs_html;
        } else {//Xu ly neu video khong lay duoc
            $result['message'] = __('This video has been removed by the user.');
        }
        return $result;
    }

    /**
     * Function get image and create html to append into list item
     * @param type $image_id
     * @param type $source
     * @return type
     */
    public static function getImage($image_id, $source) {
        $result = array('success' => false, 'message' => '', 'data' => null);
        $videoObj = array();
        $videoObj['large'] = $image_id;
        $videoObj['thumbnail'] = $image_id;
        $videoObj['media_source'] = $source;
        $rs_html = self::createHTML(json_encode($videoObj));
        $result['success'] = TRUE;
        $result['message'] = __('Image has been gotten');
        $result['data'] = $rs_html;
        return $result;
    }

    /**
     * 
     * @param type $playlistId
     * @return type
     */
    function youtubeGetVideoFromPlaylist($playlistId, $api) {
        //Lay ve thong tin cua playlist theo id
//        $pl_info = @simplexml_load_file("http://gdata.youtube.com/feeds/api/playlists/" . $playlistId);
        $pl_info = json_decode(@file_get_contents('https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=' . $playlistId . '&key=' . $api));
        //Khai bao bien de luu tru danh sach video id lay duoc tu playlist
        $list_video = array();
        //Kiem tra xem co lay duoc thong tin tu playlist hay khong
        if (!empty($pl_info->items)) {//Xu ly voi truong hop lay duoc thong tin cua playlist
            //Lay ve danh sach video
            $videos = $pl_info->items;
            //Duyet qua tumg phan tu cua mang video
            //Xu ly de lay ve video id va gan vao bien $list_video
            foreach ($videos as $video) {
                $list_video[] = $video->snippet->resourceId->videoId;
            }
        }

        return $list_video;
    }

    /**
     * 
     * @param type $username
     * @return type
     */
    public function youtubeGetVideoByUser($username, $api) {
//        Lay ve thong tin danh sach cac video duong nguoi dung upload len
        $pl_info = json_decode(@file_get_contents('https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=' . $username . '&key=' . $api));
        //Khai bao bien de luu tru danh sach video id
        $list_video = array();
        //Kiem tra xem co lay duoc thong tin cac video ma nguoi dung da upload len hay khong
        if ($pl_info->items) {//Neu cac video lay duoc
            //Lay ve danh sach cac video
            $videos = $pl_info->items;
//            Duyet qua tung phan tu cua mang danh sahc video va gan video id vao $list_video
            foreach ($videos as $video) {
                $list_video[] = $video->id->videoId;
            }
        }

        return $list_video;
    }

    /**
     * 
     * @param type $username
     * @return type
     */
    public function vimeoGetVideoByUser($username) {
        $pl_info = @simplexml_load_file("http://vimeo.com/api/v2/$username/videos.xml");
        $list_video = array();
        if ($pl_info) {
            $videos = $pl_info->video;
            foreach ($videos as $video) {
                $list_video[] = (string) $video->id;
            }
        }
        return $list_video;
    }

    /**
     * 
     * @param type $albumId
     * @return type
     */
    public function vimeoGetVideoFromAlbum($albumId) {
        $dataURL = 'http://vimeo.com/api/v2/album/' . $albumId . '/videos.xml';
        $videos = @simplexml_load_file($dataURL);
        $list_video = array();
        if ($videos) {
            foreach ($videos as $video) {
                $videoid = (string) $video->id;
                $list_video[] = $videoid;
            }
        }

        return $list_video;
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    static function createHTML($data) {
        $html = array();
        $datas = json_decode($data);
        list($width, $height) = getimagesize($datas->large);
        if ($width > $height) {
            $attr = 'width="130"';
        } else {
            $attr = 'height="130"';
        }
        $html[] = '<div class="media-item">';
        $html[] = '<div class="item-control">';
        $html[] = '<div class="inner-control">';
        $html[] = '<span class="delete"><i class="fa fa-times"></i></span>';
        $html[] = '<span class="edit"><i class="fa fa-pencil"></i></span>';
        $html[] = '<span class="select"><i class="fa fa-check"></i></span>';
        $html[] = '</div>';
        $html[] = '</div>';
        $html[] = '<img ' . $attr . ' src="' . $datas->large . '"  alt="' . __('image preview') . '"/>';
        $html[] = '<input type="hidden" name="settings[media_source][items][]" value="' . htmlspecialchars(stripslashes($data)) . '">';
        $html[] = '</div>';
        return implode($html);
    }

    /**
     * 
     * @param type $params
     * @return type
     */
    public function flickrGetData($params) {
        $encoded_params = array();
        foreach ($params as $k => $v) {
            $encoded_params[] = urlencode($k) . '=' . urlencode($v);
        }
        $url = "https://api.flickr.com/services/rest/?" . implode('&', $encoded_params);
        $rsp = file_get_contents($url);
        $rsp_obj = unserialize($rsp);
        return $rsp_obj;
    }

    /**
     * 
     * @param type $url
     * @return string
     */
    public function getHostFromUrl($url) {
        $host = __('URL invalid or not support');
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $urlinfo = parse_url($url);
            if ($urlinfo['host'] == 'youtube.com' || $urlinfo['host'] == 'www.youtube.com') {
                $host = 'youtube';
            } else if ($urlinfo['host'] == 'vimeo.com' || $urlinfo['host'] == 'www.vimeo.com') {
                $host = 'vimeo';
            } else {
                $host = 'direct';
            }
        }
        return $host;
    }

    /**
     * Function get parallax infomation by alias
     * @global type $wpdb
     * @param type $alias
     * @return type
     */
    public function getSliderByAlias($alias) {
        global $wpdb;
        $rs = null;
        $result = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'ap_background WHERE alias=%s', $alias));
        if ($result) {
            $rs = $result[0];
        }
        return $rs;
    }

    /**
     * Function get file extension
     * @param type $file
     * @return type
     */
    public function getFileExtension($file) {
        if (strpos($file, '?')) {
            $file = substr($file, 0, strpos($file, '?'));
        }
        $extension = explode('.', $file);
        return strtolower($extension[count($extension) - 1]);
    }

    /**
     * Function truncate string by number of word
     * @param string $string
     * @param type $length
     * @param type $etc
     * @return string
     */
    public function truncateString($string, $length, $etc = '...') {
        if (str_word_count($string) > $length) {
            $words = str_word_count($string, 2);
            $pos = array_keys($words);
            $string = substr($string, 0, $pos[$length]) . $etc;
        }
        return $string;
    }

    //Ham lay ve danh sach ids cua post vaf sap xem theo rate
    public function getPostIdsbyrateAvg($direction, $content_type = 'none') {
        global $wpdb;
        $ids = array();

        //Cau tru van de lay ve danh sach san pham theo rate (woo commerce product)
        $query = 'SELECT c.comment_post_ID, AVG(cm.meta_value) AS avg_rate FROM ' . $wpdb->prefix . 'comments as c';
        $query .= ' INNER JOIN ' . $wpdb->prefix . 'commentmeta as cm ON c.comment_ID = cm.comment_id';
        $query .= ' INNER JOIN ' . $wpdb->prefix . 'posts as p ON p.ID = c.comment_post_ID';
        $query .= ' WHERE p.post_type = "product" AND c.comment_approved=1  AND cm.meta_key="rating" group by p.ID ORDER BY avg_rate ' . $direction;
        $results = $wpdb->get_results($query);
        if (!empty($results)) {
            foreach ($results as $result) {
                if ($content_type == 'nomal') {// Loc lay cac product co kieu nomal
                    if (!in_array($result->comment_post_ID, wc_get_product_ids_on_sale()) && !in_array($result->comment_post_ID, wc_get_featured_product_ids())) {
                        $ids[] = (int) $result->comment_post_ID;
                    }
                } elseif ($content_type == 'sale') {// Loc lay cac product co kieu sale
                    if (in_array($result->comment_post_ID, wc_get_product_ids_on_sale())) {
                        $ids[] = (int) $result->comment_post_ID;
                    }
                } elseif ($content_type == 'featured') {// Loc lay cac product co kieu featured
                    if (in_array($result->comment_post_ID, wc_get_featured_product_ids())) {
                        $ids[] = (int) $result->comment_post_ID;
                    }
                } else {// lay ve tat ca cac san pham
                    $ids[] = (int) $result->comment_post_ID;
                }
            }
        }
        return $ids;
    }

    /**
     * 
     * @param type $array
     * @param type $array1
     * @return type
     */
    public function arrayGroupValue($array, $array1) {
        $new_array = $array;
        foreach ($array1 as $value) {
            if (!in_array($value, $new_array)) {
                array_push($new_array, $value);
            }
        }
        return $new_array;
    }

    /**
     * Function to check product in wishlist
     * @global type $wpdb
     * @param type $product_id
     * @return boolean
     */
    public function is_product_in_wishlist($product_id) {
        global $wpdb;

        $exists = false;

        if (is_user_logged_in()) {
            $sql = $wpdb->prepare("SELECT COUNT(*) as `cnt` FROM `" . YITH_WCWL_TABLE . "` WHERE `prod_id` = %d AND `user_id` = %d", $product_id, $this->details['user_id']);
            $results = $wpdb->get_results($sql);
            $exists = $results[0]->cnt > 0 ? true : false;
        } else {
            if (yith_usecookies()) {
                $tmp_products = yith_getcookie('yith_wcwl_products');
            } elseif (isset($_SESSION['yith_wcwl_products'])) {
                $tmp_products = $_SESSION['yith_wcwl_products'];
            } else {
                $tmp_products = array();
            }

            if (isset($tmp_products[$product_id])) {
                $exists = true;
            } else {
                $exists = false;
            }
        }
        return $exists;
    }

    /**
     * 
     * @param type $css
     * @param type $pid
     * @return string
     */
    public function getParallaxCss($css, $pid) {
        if ($css) {
            $new_css = trim(preg_replace('/\s+/', ' ', $css));
            $new_css = str_replace(' }', '} ' . $pid, $new_css);
            $new_css = str_replace('{ ', '{', $new_css);
            $new_css = $pid . ' ' . rtrim($new_css, $pid);
            return $new_css;
        } else {
            return '';
        }
    }

    /**
     * Function get css effect content
     * @param type $out
     * @param type $in
     * @param type $type
     * @return css content if true or false if not
     */
    public function loadContentEffectCss($out, $in, $type) {
        if ($type == 'content') {
            $direct_path = ABSPATH . 'wp-content/plugins/ap_background/includes/css/parrallax-content/';
        }
        if ($type == 'item') {
            $direct_path = ABSPATH . 'wp-content/plugins/ap_background/includes/css/item/';
        }

        $default_content = file_get_contents($direct_path . 'default.css');
        $i_content = file_get_contents($direct_path . 'in.css');
        $o_content = file_get_contents($direct_path . 'out.css');
        $in_content = file_get_contents($direct_path . $in . '.css');
        $out_content = file_get_contents($direct_path . $out . '.css');
        if ($default_content && $in_content && $out_content && $i_content && $o_content) {
            return $default_content . $in_content . $i_content . $out_content . $o_content;
        } else {
            return false;
        }
    }

    /**
     * Function get list parallax
     * @global type $wpdb
     * @param type $preoption
     * @return type
     */
    public static function getParallaxListOptions($preoption) {
        global $wpdb;
        $options = array();
        if ($preoption) {
            $options = array('Select a parallax background' => 'none');
        }
        $results = $wpdb->get_results('SELECT name, alias FROM ' . $wpdb->prefix . 'ap_background');
        if (!empty($results)) {
            foreach ($results as $value) {
                $options[$value->name] = $value->alias;
            }
        }
        return $options;
    }

    /**
     * Function create folder if not exist
     * @param type $folder
     * @return boolean
     */
    public function createFolder($folder) {
        if (!is_dir($folder)) {
            if (@mkdir($folder, 0755, TRUE)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Function create list image with flexible layout
     * @param type $item
     * @param type $media_item
     * @param type $index
     */
    public function flexibleItemRender($item, $media_item, $index) {
//        Kiem tra xem media item co ton tai hay khong
        if ($media_item) {//Neu ton tai thi lay kich thuoc cua file media item
            $this->checkMediaItem($item->id, $media_item);
            list($width, $height) = getimagesize(ABSPATH . 'wp-content/uploads/ap_background/thumb/' . $item->id . '/' . $media_item->thumbnail);
        } else {//Nguoc lai khong ton tai thi lay kich thuoc cua file mac dinh
            list($width, $height) = getimagesize(ABSPATH . '/wp-content/plugins/ap_background/images/default/default_' . $index . '.png');
        }
        //Khai bao va gan gia tri cho bien cau hinh.
        list($cell_width, $spacing) = array($item->settings->layout_setting->thumb_width, $item->settings->layout_setting->spacing);
        $item_style = '';
        $attr = '';

        //Kiem tra va xu ly doi voi moi vij tri item xac dinh.
        //Truong hop vi tri cua item = 1,2,4,8,9 (kich thuoc width = height)
        if ($index == 1 || $index == 2 || $index == 4 || $index == 8 || $index == 9) {
            $item_style = 'width:' . $cell_width . 'px;height:' . $cell_width . 'px;';
            if ($width > $height) {
                $attr = 'style="height:100%;"';
            } else {
                $attr = 'style="width:100%;"';
            }
        }

        //Truong hop vi tri item = 3,7,6 (Kich thuoc width = 2 lan kich thuoc height)
        if ($index == 3 || $index == 7 || $index == 6) {
            $item_style = 'width:' . ($cell_width * 2 + $spacing) . 'px;height:' . $cell_width . 'px;';
            $attr = 'style="width:100%;"';
        }

        //Truong hop vi tri item = 5,10 (Kich thuoc height = 2 lan kich thuoc width)
        if ($index == 5 || $index == 10) {
            $item_style = 'width:' . $cell_width . 'px;height:' . ($cell_width * 2 + $spacing) . 'px;';
            $attr = 'style="height:100%;"';
        }

        //tao style dat vi tri cho moi item dua vao vi tri cua item
        switch ($index) {
            case 1:
                $item_style .= 'top: 0; left: 0;';
                break;
            case 2:
                $item_style .= 'top: 0; left: ' . ($cell_width + $spacing) . 'px;';
                break;
            case 3:
                $item_style .= 'top: ' . ($cell_width + $spacing) . 'px; left: 0;';
                break;
            case 4:
                $item_style .= 'top: ' . (($cell_width + $spacing) * 2) . 'px; left: 0;';
                break;
            case 5:
                $item_style .= 'top: 0; left: ' . (($cell_width + $spacing) * 2) . 'px;';
                break;
            case 6:
                $item_style .= 'top: ' . (($cell_width + $spacing) * 2) . 'px; left: ' . ($cell_width + $spacing) . 'px;';
                break;
            case 7:
                $item_style .= 'top: 0; left: ' . (($cell_width + $spacing) * 3) . 'px;';
                break;
            case 8:
                $item_style .= 'top: ' . ($cell_width + $spacing) . 'px; left: ' . (($cell_width + $spacing) * 3) . 'px;';
                break;
            case 9:
                $item_style .= 'top: ' . (($cell_width + $spacing) * 2) . 'px; left: ' . (($cell_width + $spacing) * 3) . 'px;';
                break;
            case 10:
                $item_style .= 'top: ' . ($cell_width + $spacing) . 'px; left: ' . (($cell_width + $spacing) * 4) . 'px;';
                break;
            default:
                break;
        }

        //Tao html cho item tuong ung.
        echo '<div class="parallax-row in-pos row-' . $index . '" style="' . $item_style . '">';
        if ($media_item) {
            echo '<div class="thumb" ><img ' . $attr . ' src="' . site_url() . '/wp-content/uploads/ap_background/thumb/' . $item->id . '/' . $media_item->thumbnail . '" alt="' . __('Image thumbnail') . '"/></div>';
            echo '<div class="show_box hidden"><img class="image-show" src="' . (($media_item->media_source == 'image_upload') ? site_url() . $media_item->large : $media_item->large) . '" alt="' . __('Image large preview') . '"/></div>';
        } else {
            echo '<div class="thumb" ><img ' . $attr . ' src="' . plugins_url() . '/ap_background/images/default/default_' . $index . '.png" alt="' . __('Image thumbnail') . '"/></div>';
            echo '<div class="show_box hidden"><img class="image-show" src="' . plugins_url() . '/ap_background/images/default/default_large.png" alt="' . __('Image large preview') . '"/></div>';
        }
        echo '</div>';
    }

    /**
     * 
     * @param type $content
     * @return First of image find
     */
    public function getFirstImageFromContent($content) {
        $result = null;
        preg_match_all('/<img[^>]+>/i', $content, $result);
        return $result[0][0];
    }

    /**
     * Function to check media item, if not exist then rebuild
     * @param type $item
     */
    function checkMediaItem($id, $item) {
        $image_save = ABSPATH . 'wp-content/uploads/ap_background/';
        if (!file_exists($image_save . 'original/temp')) {
            $this->createFolder($image_save . 'original/temp');
        }
        if (!file_exists($image_save . 'thumb/temp')) {
            $this->createFolder($image_save . 'thumb/temp');
        }
        if (!file_exists($image_save . 'video/temp')) {
            $this->createFolder($image_save . 'video/temp');
        }
        if (!file_exists($image_save . 'original/' . $id)) {
            $this->createFolder($image_save . 'original/' . $id);
        }
        if (!file_exists($image_save . 'thumb/' . $id)) {
            $this->createFolder($image_save . 'thumb/' . $id);
        }
        if (!file_exists($image_save . 'video/' . $id)) {
            $this->createFolder($image_save . 'video/' . $id);
        }

        if (!file_exists(ABSPATH . '/wp-content/uploads/ap_background/thumb/' . $id . '/' . $item->thumbnail)) {
            if ($item->media_source == 'image_upload') {
                $image_path = ABSPATH . $item->large;
            } else {
                $image_path = $item->large;
            }
            $file_content = @file_get_contents($image_path);
            file_put_contents(ABSPATH . 'wp-content/uploads/ap_background/thumb/' . $id . '/' . $item->thumbnail, $file_content);
        }
    }

}
