<?php
/**
 * EventON html
 *
 *
 * @author 		AJDE
 * @category 	Admin
 * @package 	EventON/html
 * @version     0.2
 * @updated 	2.2.28
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function eventon_html_yesnobtn($args=''){

	$defaults = array(
		'id'=>'',
		'var'=>'',
		'no'=>'',
		'default'=>'',
		'input'=>false,
		'label'=>'',
		'guide'=>'',
		'guide_position'=>'',
		'attr'=>'', // array
	);
	
	$args = shortcode_atts($defaults, $args);

	$_attr = $no = '';

	if(!empty($args['var'])){
		$no = ($args['var']	=='yes')? 
			 null: 
			 ( (!empty($args['default']) && $args['default']=='yes')? null:'NO');
	}else{
		$no = (!empty($args['default']) && $args['default']=='yes')? null:'NO';
	}

	if(!empty($args['attr'])){
		foreach($args['attr'] as $at=>$av){
			$_attr .= $at.'="'.$av.'" ';
		}
	}

	$input = '';
	if($args['input']){
		$input_value = (!empty($args['var']))? 
			$args['var']: (!empty($args['default'])? $args['default']:'no');
		$input = "<input type='hidden' name='{$args['id']}' value='{$input_value}'/>";
	}

	$guide = '';
	if(!empty($args['guide'])){
		global $eventon;
		$guide = $eventon->frontend->get_html_guide($args['guide'], $args['guide_position']);
	}

	$label = '';
	if(!empty($args['label']))
		$label = "<label for='{$args['id']}'>{$args['label']}{$guide}</label>";

	return '<span id="'.$args['id'].'" class="evo_yn_btn '.($no? 'NO':null).'" '.$_attr.'><span class="btn_inner" style=""><span class="catchHandle"></span></span></span>'.$input.$label;
	

}