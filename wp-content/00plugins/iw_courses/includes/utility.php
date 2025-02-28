<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!class_exists('iwcUtility')) {

    class iwcUtility {

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

        function categoryField($value, $multiple = true) {
            $categories = get_terms('iw_courses_class', 'hide_empty=0');
            $html = array();
            $multiselect = '';
            if ($multiple) {
                $multiselect = 'multiple="multiple"';
                $html[] = '<select name="port_category[]" ' . $multiselect . '>';
                $html[] = '<option value="">' . __('Select all') . '</option>';
            } else {
                $html[] = '<select name="port_category">';
                $html[] = '<option value="">' . __('Select category') . '</option>';
            }
            foreach ($categories as $category) {
                if (is_array($value)) {
                    if (in_array($category->term_id, $value)) {
                        $html[] = '<option value="' . $category->term_id . '" selected="selected">' . $category->name . '</option>';
                    } else {
                        $html[] = '<option value="' . $category->term_id . '">' . $category->name . '</option>';
                    }
                } else {
                    $html[] = '<option value="' . $category->term_id . '" ' . (($category->term_id == $value) ? 'selected="selected"' : '') . '>' . $category->name . '</option>';
                }
            }
            $html[] = '</select>';

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

        public function updatePostCommentStatus($status = false) {
            global $wpdb;
            if ($status) {
                $wpdb->update($wpdb->prefix . "posts", array('comment_status' => 'open'), array('post_type' => 'iw_courses'));
            } else {
                $wpdb->update($wpdb->prefix . "posts", array('comment_status' => 'closed'), array('post_type' => 'iw_courses'));
            }
        }

        public function obEndClear() {
            $obLevel = ob_get_level();
            while ($obLevel > 0) {
                ob_end_clean();
                $obLevel--;
            }
        }

        public function themeField($value = 'default') {
            $path = WP_PLUGIN_DIR . '/iw_courses/themes/';
            $dirs = array_filter(glob(WP_PLUGIN_DIR . '/iw_courses/themes/*'), 'is_dir');
            $html = array();
            $html[] = '<select name="theme" id="theme">';
            foreach ($dirs as $dir) {
                $theme = substr($dir, strrpos($dir, '/') + 1);
                $html[] = '<option value="' . $theme . '" ' . (($theme == $value) ? 'selected="selected"' : '') . '>' . $theme . '</option>';
            }
            $html[] = '</select>';

            return implode($html);
        }

        function getCoursesOptions() {
            $btOptions = get_option('iw_courses_settings');
            $options = new stdClass();
            foreach ($btOptions as $key => $option) {
                $options->$key = $option;
            }
            return $options;
        }

        function getCoursesOption($name, $defaultValue = '') {
            $btOptions = get_option('iw_courses_settings');
            $rs = $defaultValue;
            if (isset($btOptions[$name]) && $btOptions[$name]) {
                $rs = $btOptions[$name];
            }
            return $rs;
        }

        public function getRatingPanel($itemid, $rating_sum, $rating_count, $canRate = true, $showCount = true) {
            $width = 15;
            $height = 15;
            $numOfStar = 5;

            if ($rating_count == 0)
                $rating = 0;
            else
                $rating = ($rating_sum / $rating_count);

            $backgroundWidth = $numOfStar * $width;
            $currentWidth = round($rating * $width);

            $html = '<div class="btp-rating-container-' . $itemid . '"><div class="btp-rating-background" style="width: ' . $backgroundWidth . 'px"><div class="btp-rating-current" style="width: ' . $currentWidth . 'px"></div>';

            if ($canRate) {
                for ($i = $numOfStar; $i > 0; $i--) {
                    $starWidth = $width * $i;
                    $html .= '<a onclick="javascript:rate(' . $itemid . ', ' . $i . ')" href="javascript:void(0);" style="width:' . $starWidth . 'px"></a>';
                }
            }

            $html .= '</div>';
            if ($showCount) {
                $html .= '<div class="btp-rating-notice">' . sprintf(__('%0.1f/5 (%d votes)'), $rating, $rating_count) . '</div>';
            }

            $html .= '</div>';

            return $html;
        }

        public function getAthleteRatingPanel($itemid, $rating_sum, $rating_count, $canRate = true, $showCount = true) {
            $width = 20;
            $numOfStar = 5;

            if ($rating_count == 0)
                $rating = 0;
            else
                $rating = ($rating_sum / $rating_count);

            $currentWidth = round($rating * $width);

            $html = '<div class="btp-rating-container-' . $itemid . '">';
            if ($showCount) {
                $html .= '<div class="btp-rating-notice">' . sprintf(__('%d votes'), $rating_count) . '</div>';
            }
            $html .= '<div class="btp-rating-background" style="width: 63px"><div class="btp-rating-current" style="width: ' . $currentWidth . '%"></div>';

            if ($canRate) {
                for ($i = $numOfStar; $i > 0; $i--) {
                    $starWidth = $width * $i;
                    $html .= '<span onclick="javascript:rateAthlete(' . $itemid . ', ' . $i . ')" style="width:' . $starWidth . '%"></span>';
                }
            }

            $html .= '</div>';

            $html .= '</div>';

            return $html;
        }

        public function getPathImage($imageType, $image_id) {
            $watermask = $this->getCoursesOption('enable_watemark', 0);
            $file_path = get_attached_file($image_id);
            if ($imageType == 'thumb' && $this->getCoursesOption('enable_watemark_thumbnail', 0) == 0) {
                $watermask = 0;
            }
            if (!$file_path) {
                if ($imageType == 'thumb') {
                    return plugins_url('iw_courses/themes/' . $this->getCoursesOption('theme', 'default') . '/assets/images/photo_default.png');
                }
                if ($imageType == 'large') {
                    return plugins_url('iw_courses/themes/' . $this->getCoursesOption('theme', 'default') . '/assets/images/photo_default.png');
                }
            }
            if ($watermask == 0) {
                if ($imageType == 'thumb') {
                    if (!file_exists($file_path)) {
                        $imagePath = plugins_url('iw_courses/themes/' . $this->getCoursesOption('theme', 'default') . '/assets/images/photo_default.png');
                    } else {
                        $image_thumb = wp_get_attachment_image_src($image_id, 'iw_courses-thumb');
                        $imagePath = $image_thumb[0];
                    }
                }
                if ($imageType == 'large') {
                    if (!file_exists($imageObj->guid)) {
                        $imagePath = plugins_url('iw_courses/themes/' . $this->getCoursesOption('theme', 'default') . '/assets/images/photo_default.png');
                    } else {
                        $image_large = wp_get_attachment_image_src($image_id, 'iw_courses-large');
                        $imagePath = $image_large[0];
                    }
                }
            } else {
                $imagePath = admin_url('admin-ajax.php?action=iwcAjaxRenderImage&src=' . $image_id . '&imagetype=' . $imageType);
            }

            return $imagePath;
        }

        public function getImageWatermark() {
            $file = $_GET['src'];
            $file_path = get_attached_file($file);
            $imgType = $_GET['imagetype'];
            $source = '';
            if ($imgType == 'large') {
                if (!$file_path) {
                    $source = ABSPATH . 'wp-content/plugins/bt_portfoli/themes/' . $this->getCoursesOption('theme', 'default') . '/assets/images/photo_default.png';
                } else {
                    $source = $file_path;
                }
            }
            if ($imgType == 'thumb') {
                if (!$file_path) {
                    $source = ABSPATH . 'wp-content/plugins/bt_portfoli/themes/' . $this->getCoursesOption('theme', 'default') . '/assets/images/photo_default.png';
                } else {
                    $source = $file_path;
                }
            }
            if ($this->getCoursesOption('enable_watemark', 0) == 1) {
                include(dirname(__FILE__) . '/watermask/watermask.php');
                $iwcWaterMask = new iwcWaterMask();
                $options = $iwcWaterMask->getWaterMarkOptions();
                $options['padding'] = $this->getCoursesOption('wm_padding', $options['padding']);
                $options['font'] = $this->getCoursesOption('wm_font') ? ABSPATH . 'wp-content/plugins/iw_courses/includes/watermask/fonts/' . $this->getCoursesOption('wm_font') . '.ttf' : $options['font'];
                $options['text'] = $this->getCoursesOption('wm_text', $options['text']);
                $options['image'] = $this->getCoursesOption('wm_image') ? JPATH_ROOT . '/' . $this->getCoursesOption('wm_image') : $options['image'];
                $options['type'] = $this->getCoursesOption('wm_type', $options['type']);
                $options['fcolor'] = $this->getCoursesOption('wm-fcolor', $options['fcolor']);
                $options['fsize'] = $this->getCoursesOption('wm-fsize', $options['fsize']);
                $options['bg'] = $this->getCoursesOption('wm_bg', $options['bg']);
                $options['bgcolor'] = $this->getCoursesOption('wm-bgcolor', $options['bgcolor']);
                $options['factor'] = $this->getCoursesOption('wm-factor', $options['factor']);
                $options['position'] = $this->getCoursesOption('wm_position', $options['position']);
                $options['opacity'] = $this->getCoursesOption('wm_opacity', $options['opacity']);
                $options['rotate'] = $this->getCoursesOption('wm_rotate', $options['rotate']);
                $iwcWaterMask->createWaterMark($source, $options);
            } else {
                $size = getimagesize($source);
                $imagetype = $size[2];
                switch ($imagetype) {
                    case(1):
                        header('Content-type: image/gif');
                        $image = imagecreatefromgif($source);
                        imagegif($image);
                        break;

                    case(2):
                        $image = imagecreatefromjpeg($source);
                        header('Content-type: image/jpeg');
                        imagejpeg($image);
                        break;

                    case(3):
                        header('Content-type: image/png');
                        $image = imagecreatefrompng($source);
                        imagepng($image);
                        break;

                    case(6):
                        header('Content-type: image/bmp');
                        $image = imagecreatefrombmp($source);
                        imagewbmp($image);
                        break;
                }
            }
            exit;
        }

        public function getSocialShare($social_buttons) {
            wp_enqueue_script('sharethis', 'http://w.sharethis.com/button/buttons.js');
            if (!is_array($social_buttons)) {
                $social_buttons = array($social_buttons);
            }
            foreach ($social_buttons as $button) {
                switch ($button) {
                    case 1:
                        //echo "<span class='st_twitter_hcount' displayText='Tweet' st_via='YourTwitterHandleName' st_msg='#YourHashTag and #YourOtherHashTag'></span>";
                        echo "<span class='st_twitter_hcount' displayText='Tweet'></span> ";

                        break;
                    case 2:
                        echo "<span class='st_plusone_hcount' displayText='Google +1'></span>";
                        break;
                    case 3:
                        echo "<span class='st_linkedin_hcount' displayText='LinkedIn'></span>";
                        break;
                    case 4:
                        echo "<span class='st_email_hcount' displayText='Email'></span>";
                        break;
                    case 5:
                        echo "<span class='st_facebook_hcount' displayText='Facebook'></span>";
                        break;
                    case 6:
                        echo "<span class='st_fbsend_hcount' displayText='Facebook Send'></span>";
                        break;
                    case 7:
                        echo "<span class='st_fblike_hcount' displayText='Facebook Like'></span>";
                        break;
                    case 8:
                        echo "<span class='st_fbrec_hcount' displayText='Facebook Recommend'></span>";
                        break;
                    case 9:
                        echo "<span class='st_pinterest_hcount' displayText='Pinterest'></span>";
                        break;
                }
            }
        }

        public function callBackAllChild($id) {
            global $wpdb;
            $r = $wpdb->get_results($wpdb->prepare("SELECT term_id FROM " . $wpdb->prefix . "term_taxonomy WHERE parent = %d",$id));
            $ids = $id;
            foreach ($r as $i) {
                $ids .= "," . self::callBackAllChild($i->term_id);
            }
            return $ids;
        }

        // Function get list categories for mod_iw_courses_categories
        public function getListChildCategories($categoryId) {
            global $wpdb;
            $query = $wpdb->prepare('SELECT a.term_id, a.name, a.slug, b.parent, b.description FROM ' . $wpdb->prefix . 'terms as a INNER JOIN ' . $wpdb->prefix . 'term_taxonomy as b ON a.term_id = b.term_id WHERE b.parent = %d', $categoryId);
            return $wpdb->get_results($query, object);
        }

        public function courses_display_pagination($query = '') {
            if (!$query) {
                global $wp_query;
                $query = $wp_query;
            }

            $big = 999999999; // need an unlikely integer

            $paginate_links = paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $query->max_num_pages,
                'next_text' => '&raquo;',
                'prev_text' => '&laquo'
            ));
            // Display the pagination if more than one page is found
            if ($paginate_links) :
                ?>

                <div class="post-pagination clearfix">
                    <?php echo $paginate_links; ?>
                </div>

                <?php
            endif;
        }

        public function courses_display_pagination_none($query = '') {
            $rs = array('success'=>false, 'data'=>'');
            if (!$query) {
                global $wp_query;
                $query = $wp_query;
            }

            $paginate_links = paginate_links(array(
                'format' => '?page=%#%',
                'current' => max(1, get_query_var('page')),
                'total' => $query->max_num_pages
            ));
            // Display the pagination if more than one page is found
            if ($paginate_links) :
                $html = array();
                $html[] = '<div class="post-pagination clearfix" style="display: none;">';
                $html[] = $paginate_links;
                $html[] = '</div>';
                $rs['success'] = true;
                $rs['data'] = implode($html);
            endif;
            return $rs;
        }

        public function getSkitterScript() {
            $html = array();
            $html[] = '<script type="text/javascript" language="javascript">';
            $html[] = 'jQuery(document).ready(function () {';
            $html[] = 'jQuery(".box_skitter_large").skitter({';
            $html[] = "theme: 'clear',";
            $html[] = 'numbers: false,';
            $html[] = 'responsive: true,';
            $html[] = "thumbs: " . ($this->getCoursesOption('media_show_thumbnail', 0) == 1 ? 'true' : 'false') . ",";
            $html[] = 'animation: "' . $this->getCoursesOption('slideshow_skitter_effect', 'randomSmart') . '",';
            $html[] = 'interval: ' . $this->getCoursesOption('interval', '4000') . ',';
            $html[] = "navigation: " . ($this->getCoursesOption('next_button', 0) == 1 ? 'true' : 'false') . ",";
            $html[] = '});';
            $html[] = '});';
            $html[] = '</script>';
            return implode($html);
        }

        public function filterHtmlForm() {
            $html = array();
            $html[] = '<div class="p-filter">';
            $html[] = '<form action="" method="post">';
            $html[] = '<input class="p-first-input" placeholder="' . __('Enter keyword...') . '" type="text" name="keyword" value="' . $_SESSION['filter']['keyword'] . '"/>';
            $html[] = $this->categoryField($_SESSION['filter']['catid'], false);
            $order_data = array(
                array('value' => 'ID', 'text' => 'ID'),
                array('value' => 'post_title', 'text' => 'Title'),
                array('value' => 'post_comment', 'text' => 'Comment'),
                array('value' => 'rand', 'text' => 'Random')
            );
            $html[] = $this->selectFieldRender('port_order', $_SESSION['filter']['port_order'], $order_data, 'Order by', false);
            $direction_data = array(
                array('value' => 'ASC', 'text' => 'ASC'),
                array('value' => 'DESC', 'text' => 'DESC')
            );
            $html[] = $this->selectFieldRender('port_order_direction', ($_SESSION['filter']['port_order_direction']) ? $_SESSION['filter']['port_order_direction'] : 'ASC', $direction_data, 'Direction', false);
            $html[] = '<input type="submit" value="submit"/>';
            $html[] = '</form>';
            $html[] = '</div>';
            return implode($html);
        }

        public function getCoursesList($cats, $item_per_page) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
            $terms = '';
            $keyword = '';
            $order_by = '';
            $direction = '';
            $cat_array = explode(',', $cats);
            $new_cats = array();
            if (in_array('0', $cat_array)) {
                global $wpdb;
                $res = $wpdb->get_results("SELECT term_id FROM " . $wpdb->prefix . "term_taxonomy WHERE taxonomy='iw_courses_class'");
                foreach ($res as $value) {
                    $new_cats[] = $value->term_id;
                }
            }else{
                $new_cats = $cat_array;
            }
            if (!empty($_POST)) {
                if ($_POST['keyword']) {
                    $keyword = $_POST['keyword'];
                    $_SESSION['filter']['keyword'] = $_POST['keyword'];
                } else {
                    unset($_SESSION['filter']['keyword']);
                }
                if ($_POST['port_category']) {
                    $terms = $_POST['port_category'];
                    $_SESSION['filter']['catid'] = $_POST['port_category'];
                } else {
                    unset($_SESSION['filter']['catid']);
                }
                if ($_POST['port_order']) {
                    $order_by = $_POST['port_order'];
                    $_SESSION['filter']['port_order'] = $_POST['port_order'];
                } else {
                    unset($_SESSION['filter']['port_order']);
                }
                if ($_POST['port_order_direction']) {
                    $direction = $_POST['port_order_direction'];
                    $_SESSION['filter']['port_order_direction'] = $_POST['port_order_direction'];
                } else {
                    unset($_SESSION['filter']['port_order_direction']);
                }
            }
            $args = array(
                'post_type' => 'iw_courses',
                's' => $keyword,
                'order' => ($direction) ? $direction : $this->getCoursesOption('port_order_direction', 'ASC'),
                'orderby' => ($order_by) ? $order_by : $this->getCoursesOption('port_order', 'ID'),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'iw_courses_class',
                        'terms' => ($terms) ? $terms : $new_cats,
                        'include_children' => false
                    ),
                ),
                'posts_per_page' => $item_per_page,
                'paged' => $paged
            );
            return new WP_Query($args);
        }

        public function getCoursesTeacherList($item_per_page) {
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $keyword = '';
            $order_by = '';
            $direction = '';
            if (!empty($_POST)) {
                if ($_POST['keyword']) {
                    $keyword = $_POST['keyword'];
                }
                if ($_POST['port_category']) {
                    $terms = $_POST['port_category'];
                }
                if ($_POST['port_order']) {
                    $order_by = $_POST['port_order'];
                }
                if ($_POST['port_order_direction']) {
                    $direction = $_POST['port_order_direction'];
                }
            }
            $args = array(
                'post_type' => 'iw_teacher',
                's' => $keyword,
                'order' => ($direction) ? $direction : $this->getCoursesOption('port_order_direction', 'ASC'),
                'orderby' => ($order_by) ? $order_by : $this->getCoursesOption('port_order', 'ID'),
                'posts_per_page' => $item_per_page,
                'paged' => $paged
            );
            return new WP_Query($args);
        }

        public function getCoursesByClass($item_per_page, $term_slug) {
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $keyword = '';
            $order_by = '';
            $direction = '';
            if (!empty($_POST)) {
                if ($_POST['port_category']) {
                    $terms = $_POST['port_category'];
                }
                if ($_POST['port_order']) {
                    $order_by = $_POST['port_order'];
                }
                if ($_POST['port_order_direction']) {
                    $direction = $_POST['port_order_direction'];
                }
            }
            $args = array(
                'post_type' => 'iw_courses',
                's' => $keyword,
                'order' => ($direction) ? $direction : $this->getCoursesOption('port_order_direction', 'ASC'),
                'orderby' => ($order_by) ? $order_by : $this->getCoursesOption('port_order', 'ID'),
                'posts_per_page' => $item_per_page,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'iw_courses_class',
                        'field' => 'slug',
                        'terms' => $term_slug,
                    ),
                ),
                'paged' => $paged
            );
            return new WP_Query($args);
        }

        /**
         * Function truncate string by number of word
         * @param string $string
         * @param type $length
         * @param type $etc
         * @return string
         */
        public function truncateString($string, $length, $etc = '...') {
            $string = strip_tags($string);
            if (str_word_count($string) > $length) {
                $words = str_word_count($string, 2);
                $pos = array_keys($words);
                $string = substr($string, 0, $pos[$length]) . $etc;
            }
            return $string;
        }

    }

}
