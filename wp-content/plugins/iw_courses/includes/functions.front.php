<?php

/**
 *
 * @param unknown_type $atts
 * @return string
 */
function iwcCoursesListHtmlPage($theme, $cats, $item_per_page, $show_filter_bar) {
    $themes_dir = get_template_directory();
    $btport_theme = $themes_dir . '/iw_courses/';
    $themes = '';
    if (file_exists($btport_theme) && is_dir($btport_theme)) {
        $themes = $btport_theme;
    } else {
        $themes = WP_PLUGIN_DIR . '/iw_courses/themes/' . $theme;
    }
    $iwc_theme = $themes . '/list_courses.php';
    if (file_exists($iwc_theme)) {
        require_once $iwc_theme;
    } else {
        echo 'No theme was found';
    }
}

function iwcTeacherListHtmlPage($theme, $item_per_page) {
    $themes_dir = get_template_directory();
    $btport_theme = $themes_dir . '/iw_courses/';
    $themes = 'athlete';
    if (file_exists($btport_theme) && is_dir($btport_theme)) {
        $themes = $btport_theme;
    } else {
        $themes = WP_PLUGIN_DIR . '/iw_courses/themes/' . $theme;
    }
    $iwc_theme = $themes . '/list_teachers.php';
    if (file_exists($iwc_theme)) {
        require_once $iwc_theme;
    } else {
        echo 'No theme was found';
    }
}

function iwcAjaxVote() {
    require_once 'utility.php';
    global $wpdb;
    $result = array();
    $result['success'] = true;
    $utility = new iwcUtility();
    $bt_options = get_option('iw_courses_settings');
    $user = get_current_user_id();
    if ($user == 0 && $utility->getCoursesOption('allow_guest_vote', 0) == 0) {
        $result['success'] = false;
        $result['message'] = __('Only registered users can vote. Please login to cast your vote');
    } else {
        $postid = $_POST['id'];
        $rating = $_POST['rating'];

        $sqlQuery = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "posts WHERE id=%d", $postid);
        $post = $wpdb->get_row($sqlQuery);

        // Fake submit
        if (!$post || $rating == 0 || $rating > 5) {
            die();
        }
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($user) {
            $sqlQuery = $wpdb->prepare("SELECT COUNT(*) FROM " . $wpdb->prefix . "iw_courses_vote WHERE item_id=%d AND user_id=%d", $postid, $user);
        } else {
            $sqlQuery = $wpdb->prepare("SELECT COUNT(*) FROM " . $wpdb->prefix . "iw_courses_vote WHERE item_id=%d AND ip=%s AND user_id = 0", $postid, $ip);
        }
        if ($wpdb->get_var($sqlQuery) > 0) {
            $result['success'] = false;
            $result['message'] = __('You have already voted for this item');
        } else {
            $ins = $wpdb->insert($wpdb->prefix . "iw_courses_vote", array('item_id' => $postid, 'user_id' => $user, 'created' => time(), 'vote' => $rating, 'ip' => $ip));

            $result['message'] = __('Thanks for voting. You rock!!! ;o');
            $result['rating_sum'] = $media_item->vote_sum + $rating;
            $result['rating_count'] = $media_item->vote_count + 1;
            $result['rating'] = $result['rating_sum'] / $result['rating_count'];
            $result['rating_text'] = sprintf(__('%d votes'), $result['rating_count']);
            $result['rating_width'] = round(15 * $result['rating']);
        }
    }
    $utility->obEndClear();
    echo json_encode($result);
    exit();
}

add_action('wp_ajax_nopriv_iwcAjaxVote', 'iwcAjaxVote');
add_action('wp_ajax_iwcAjaxVote', 'iwcAjaxVote');

//Ajax vote for Athlete theme
function iwcAthleteAjaxVote() {
    require_once 'utility.php';
    global $wpdb;
    $result = array();
    $result['success'] = true;
    $utility = new iwcUtility();
    $user = get_current_user_id();
    if ($user == 0 && $utility->getCoursesOption('allow_guest_vote', 0) == 0) {
        $result['success'] = false;
        $result['message'] = __('Only registered users can vote. Please login to cast your vote');
    } else {
        $postid = $_POST['id'];
        $rating = $_POST['rating'];

        $sqlQuery = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "posts WHERE id=%d",$postid);
        $post = $wpdb->get_row($sqlQuery);

        // Fake submit
        if (!$post || $rating == 0 || $rating > 5) {
            die();
        }
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($user) {
            $sqlQuery = $wpdb->prepare("SELECT COUNT(*) FROM " . $wpdb->prefix . "iw_courses_vote WHERE item_id=%d AND user_id=%d", $postid, $user);
        } else {
            $sqlQuery = $wpdb->prepare("SELECT COUNT(*) FROM " . $wpdb->prefix . "iw_courses_vote WHERE item_id=%d AND ip=%s AND user_id = 0", $postid, $ip);
        }
        if ($wpdb->get_var($sqlQuery) > 0) {
            $result['success'] = false;
            $result['message'] = __('You have already voted for this item');
        } else {
            $wpdb->insert($wpdb->prefix . "iw_courses_vote", array('item_id' => $postid, 'user_id' => $user, 'created' => time(), 'vote' => $rating, 'ip' => $ip));
            $vote = $wpdb->get_row($wpdb->prepare('SELECT count(id) AS vote_count, SUM(vote) as vote_sum FROM ' . $wpdb->prefix . 'iw_courses_vote WHERE item_id=%d', $postid));

            $result['message'] = __('Thanks for voting. You rock!!! ;o');
            $result['rating_sum'] = $vote->vote_sum;
            $result['rating_count'] = $vote->vote_count;
            $result['rating'] = $result['rating_sum'] / $result['rating_count'];
            $result['rating_text'] = sprintf(__('%d votes'), $result['rating_count']);
            $result['rating_width'] = round(20 * $result['rating']);
        }
    }
    $utility->obEndClear();
    echo json_encode($result);
    exit();
}

add_action('wp_ajax_nopriv_iwcAthleteAjaxVote', 'iwcAthleteAjaxVote');
add_action('wp_ajax_iwcAthleteAjaxVote', 'iwcAthleteAjaxVote');

//Ajax iwcSendMailTakeCourse
function iwcSendMailTakeCourse() {
    $result = array();
    $teacher = get_post($_POST['temail']);
    $result['success'] = false;
    $admin_email = get_option('admin_email');
    $teacher_email = get_post_meta($teacher->ID, 'iw_teacher_email', true);
    $email = $_POST['email'];
    $title = $_POST['title'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $message = $_POST['message'];

    if ($teacher_email) {
        $recived_email = $teacher_email;
        $recived_name = $teacher->post_title;
    } else {
        $recived_email = $admin_email;
        $recived_name = __('Administrator', 'gmswebdesign');
    }

    $html = '
<html>
<head>
  <title>' . __('Email recived from "TAKE THIS COURSE" form:', 'gmswebdesign') . '</title>
</head>
<body>
  <p>' . __('Hi ' . $recived_name . ',', 'gmswebdesign') . '</p>
  <p>' . __('This email was sent from "TAKE THIS COURSE" form', 'gmswebdesign') . '</p>
  <table>
    <tr>
      <td>' . __('Name', 'gmswebdesign') . '</td>
            <td>' . $name . '</td>
    </tr>
    <tr>
      <td>' . __('Email', 'gmswebdesign') . '</td>
            <td>' . $email . '</td>
    </tr>
    <tr>
      <td>' . __('Mobile', 'gmswebdesign') . '</td>
            <td>' . $mobile . '</td>
    </tr>
    <tr>
      <td>' . __('Message', 'gmswebdesign') . '</td>
      <td>' . $message . '</td>
    </tr>
  </table>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
//    $headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
//    $headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";
//    $headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
//    $headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
// Mail it
    if (wp_mail($recived_email, $title, $html, $headers)) {
        $result['success'] = true;
        $result['message'] = __('Your message was sent, we will contact you soon');
    } else {
        $result['message'] = __('Can\'t send message, please try again');
    }
    echo json_encode($result);
    exit();
}

add_action('wp_ajax_nopriv_iwcSendMailTakeCourse', 'iwcSendMailTakeCourse');
add_action('wp_ajax_iwcSendMailTakeCourse', 'iwcSendMailTakeCourse');

function iwcAjaxRenderImage() {
    require_once 'utility.php';
    $utility = new iwcUtility();
    $utility->getImageWatermark();
    exit();
}

add_action('wp_ajax_nopriv_iwcAjaxRenderImage', 'iwcAjaxRenderImage');
add_action('wp_ajax_iwcAjaxRenderImage', 'iwcAjaxRenderImage');

function iwcLoadCoursesPosts() {
    $exids = rtrim($_POST['excids'], ',');
    $keysearch = $_POST['keyword'];
    $result = array('success' => false, 'msg' => '', 'data' => '');
    global $wpdb;
    if ($exids) {
        $rs = $wpdb->get_results($wpdb->prepare('SELECT ID, post_title FROM ' . $wpdb->prefix . 'posts WHERE post_status = "publish" AND post_type="iw_courses" AND post_title like %s AND ID NOT IN(' . $exids . ')', $keysearch.'%'));
    } else {
        $rs = $wpdb->get_results($wpdb->prepare('SELECT ID, post_title FROM ' . $wpdb->prefix . 'posts WHERE post_status = "publish" AND post_type="iw_courses" AND post_title like %s', $keysearch.'%'));
    }
    if ($rs) {
        $html = array();
        $html[] = '<ul>';
        for ($index = 0; $index < count($rs); $index++) {
            if ($index == 0) {
                $html[] = '<li class="selected" data-id="' . $rs[$index]->ID . '" data-title="' . $rs[$index]->post_title . '">' . $rs[$index]->post_title . '</li>';
            } else {
                $html[] = '<li data-id="' . $rs[$index]->ID . '" data-title="' . $rs[$index]->post_title . '">' . $rs[$index]->post_title . '</li>';
            }
        }
        $html[] = '</ul>';
        $result['msg'] = __('Loaded post successfully', 'gmswebdesign');
        $result['success'] = true;
        $result['data'] = implode($html);
    } else {
        $msg = $wpdb->last_error;
        if ($msg) {
            $result['msg'] = $msg;
        } else {
            $result['msg'] = __('No data was found', 'gmswebdesign');
        }
    }

    echo json_encode($result);
    exit();
}
