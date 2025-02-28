<?php
/** 
 * Helper functions to be used by eventon or its addons
 * front-end only
 *
 * @version 0.1
 * @since  2.2.28
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class evo_helper{

	function test(){	echo 'tt';	}

	// Create posts 
		function create_posts($args){
			if(!empty($args) && is_array($args)){
				$valid_type = (function_exists('post_type_exists') &&  post_type_exists($args['post_type']));

				if(!$valid_type)
					return false;

				$__post_content = !empty($_POST['post_content'])? $_POST['post_content']: $args['post_content'];
				$__post_content = (!empty($__post_content))?
			        	wpautop(convert_chars(stripslashes($__post_content))): null;

			    // author id
			    $current_user = wp_get_current_user();
		        $author_id =  (($current_user instanceof WP_User)) ? $current_user->ID : $args['author_id'];

			    $new_post = array(
		            'post_title'   => wp_strip_all_tags($args['post_title']),
		            'post_content' => $__post_content,
		            'post_status'  => $args['post_status'],
		            'post_type'    => $args['post_type'],
		            'post_name'    => sanitize_title($args['post_title']),
		            'post_author'  => $author_id,
		        );

			    return wp_insert_post($new_post);

			}else{
				return false;
			}
		}

		function create_custom_meta($post_id, $field, $value){
			add_post_meta($post_id, $field, $value);
		}

	// Eventon Settings helper
		function get_html($type, $args){
			switch($type){
				case 'email_preview':
					ob_start();
					echo '<div class="evo_email_preview"><p>Headers: '.$args['headers'].'</p>';
					echo '<p>To: '.$args['to'].'</p>';
					echo '<p>Subject: '.$args['subject'].'</p>';
					echo '<div class="evo_email_preview_body">'.$args['message'].'</div></div>';
					return ob_get_clean();
				break;
			}
		}

	// ADMIN & Frontend Helper
		public function send_email($args){
			$defaults = array(
				'html'=>'yes',
				'preview'=>'no',
			);
			$args = array_merge($defaults, $args);

			if($args['html']=='yes'){
				add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
			}

			$headers = 'From: '.$args['from'];

			if($args['preview']=='yes'){
				return array(
					'to'=>$args['to'],
					'subject'=>$args['subject'],
					'message'=>$args['message'],
					'headers'=>htmlspecialchars($headers)
				);
			// bcc version of things
			}else if(!empty($args['type']) && $args['type']=='bcc' ){
				$headers['Bcc'] = "Bcc: ".$args['to'];
				return wp_mail($args['from'], $args['subject'], $args['message'], $headers);	
			}else{
				return wp_mail($args['to'], $args['subject'], $args['message'], $headers);
			}
		}

		

}