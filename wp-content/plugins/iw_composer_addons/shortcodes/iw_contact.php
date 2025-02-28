<?php
/*
 * @package Inwave Athlete
 * @version 1.0.0
 * @created Mar 31, 2015
 * @author gmswebdesign
 * @email gmswebdesign@gmail.com
 * @website http://gmswebdesign.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 gmswebdesign. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of iw_contact
 *
 * @Developer duongca
 */
if (!class_exists('Inwave_IW_Contact')) {

    class Inwave_IW_Contact {

        function __construct() {
         
            add_action('admin_init', array($this, 'heading_init'));
            add_shortcode('inwave_iw_contact', array($this, 'inwave_iw_contact_shortcode'));
            add_action('wp_ajax_nopriv_sendMessageContact', array($this, 'sendMessageContact'));
            add_action('wp_ajax_sendMessageContact', array($this, 'sendMessageContact'));
        }

        function heading_init() {

            // Add banner addon
            vc_map(array(
                'name' => 'IW Contact',
                'description' => __('Show contact form', 'gmswebdesign'),
                'base' => 'inwave_iw_contact',
                // 'icon' => 'icon-wpb-gmswebdesign',
                'category' => 'gmswebdesign',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "gmswebdesign"),
                        "value" => "Athlete online",
                        "param_name" => "title",
                        "description" => __('Title of iw_contact block.', "gmswebdesign")
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Sub Title", "gmswebdesign"),
                        "value" => "",
                        "param_name" => "sub_title",
                        "description" => __('Sub Title of iw_contact block.', "gmswebdesign")
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show name", "gmswebdesign"),
                        "param_name" => "show_name",
                        "description" => __("Show field name on form", 'gmswebdesign'),
                        "value" => array(
                            'Yes' => 'yes',
                            'No' => 'no',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show email", "gmswebdesign"),
                        "param_name" => "show_email",
                        "description" => __("Show field email on form", 'gmswebdesign'),
                        "value" => array(
                            'Yes' => 'yes',
                            'No' => 'no',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show message", "gmswebdesign"),
                        "param_name" => "show_message",
                        "description" => __("Show field message on form", 'gmswebdesign'),
                        "value" => array(
                            'Yes' => 'yes',
                            'No' => 'no',
                        ),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "gmswebdesign"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "gmswebdesign")
                    )
                )
            ));
        }

        // Shortcode handler function for list Icon
        function inwave_iw_contact_shortcode($atts, $content = null) {
            $output = $answer = $question = $class = '';
            extract(shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'show_name' => 'yes',
                'show_email' => 'yes',
                'show_message' => 'yes',
                'class' => ''
                            ), $atts));
            return $this->htmlBoxIW_ContactRender($title, $sub_title, $show_name, $show_email, $show_message, $class);
        }

        function htmlBoxIW_ContactRender($title, $sub_title, $show_name, $show_email, $show_message, $class) {
            ob_start();
            ?>
            <div class="contact-submit">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="contact">
                                <div class="contact-ajax-overlay">
                                    <span class="ajax-contact-loading"><i class="fa fa-spinner fa-spin fa-2x"></i></span>
                                </div>
                                <h4><?php echo $title; ?></h4>
                                <div class="headding-bottom"></div>
                                <form method="post" name="contact-form" class="main-contact-form row" id="main-contact-form">
                                    <?php if ($show_name == 'yes'): ?>
                                        <div class="form-group col-md-12">
                                            <input type="text" placeholder="<?php echo __('Your Name', 'gmswebdesign'); ?>" required="required" class="control" name="name">
                                        </div>
                                        <?php
                                    endif;
                                    if ($show_email == 'yes'):
                                        ?>
                                        <div class="form-group col-md-12">
                                            <input type="email" placeholder="<?php echo __('Your Email', 'gmswebdesign'); ?>" required="required" class="control" name="email">
                                        </div>
                                        <?php
                                    endif;
                                    if ($show_message == 'yes'):
                                        ?>
                                        <div class="form-group col-md-12">
                                            <textarea placeholder="<?php echo __('Your Message', 'gmswebdesign'); ?>" rows="8" class="control" required="required" id="message" name="message"></textarea>
                                        </div>  
                                    <?php endif; ?>
                                    <div class="form-group form-submit col-md-12">
                                        <input name="action" type="hidden" value="sendMessageContact">
                                        <button class="btn-submit" name="submit" type="submit"><?php echo __('Send Message', 'gmswebdesign'); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

        //Ajax iwcSendMailTakeCourse
        function sendMessageContact() {
            $result = array();
            $result['success'] = false;
            $admin_email = get_option('admin_email');
            $email = $_POST['email'];
            $name = $_POST['name'];
            $message = $_POST['message'];
            $title = __('Email from Contact','gmswebdesign');

            $html = '
<html>
<head>
  <title>' . __('Email recived from "CONTACT" form:', 'gmswebdesign') . '</title>
</head>
<body>
  <p>' . __('Hi Admin,', 'gmswebdesign') . '</p>
  <p>' . __('This email was sent from "CONTACT" form', 'gmswebdesign') . '</p>
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
      <td>' . __('Message', 'gmswebdesign') . '</td>
      <td>' . $message . '</td>
    </tr>
  </table>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
		add_filter( 'wp_mail_content_type', array($this, 'set_html_content_type') );
        if (wp_mail($admin_email, $title, $html, $headers)) {
                $result['success'] = true;
                $result['message'] = __('Your message was sent, we will contact you soon','gmswebdesign');
            } else {
                $result['message'] = __('Can\'t send message, please try again','gmswebdesign');
            }
			remove_filter('wp_mail_content_type', array($this, 'set_html_content_type') );
            echo json_encode($result);
            exit();
        }
		
		function set_html_content_type() {
		return 'text/html';
	}

    }
	
}

new Inwave_IW_Contact();
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_IW_Contact extends WPBakeryShortCode {
        
    }

}
