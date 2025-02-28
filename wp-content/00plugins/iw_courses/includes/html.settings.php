<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include_once 'utility.php';
if (isset($_SESSION['bt_message'])) {
    echo $_SESSION['bt_message'];
    unset($_SESSION['bt_message']);
}
$bt_options = (get_option('iw_courses_settings')) ? get_option('iw_courses_settings') : null;
$utility = new iwcUtility();
?>
<div class="tabs">
    <ul class="tab-links">
        <li class="active"><a href="#display"><?php echo __('Display Options'); ?></a></li>
        <li><a href="#review"><?php echo __('Review Options'); ?></a></li>
        <li><a href="#advanced"><?php echo __('Advanced Options'); ?></a></li>
    </ul>

    <form action="<?php echo admin_url(); ?>admin-post.php" method="post">
        <div class="tab-content">
            <div id="display" class="tab active">
                <h3 class="header-text"><?php echo __("Theme Options"); ?></h3>
                <div class="control-group">
                    <div class="label"><?php echo __('Select theme'); ?></div>
                    <div class="control">
                        <?php echo $utility->themeField($bt_options['theme']); ?>
                    </div>
                    <div style="clear: both"></div>
                </div>
				<h3 class="header-text"><?php echo __("Permalink settings"); ?></h3>
                <div class="control-group">
                    <div class="label"><?php echo __('Courses slug'); ?></div>
                    <div class="control">
                        <input type="text" name="courses_slug" value="<?php echo ($bt_options['courses_slug']) ? $bt_options['courses_slug'] : 'iw-courses'; ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
				<div class="control-group">
                    <div class="label"><?php echo __('Teachers slug'); ?></div>
                    <div class="control">
                        <input type="text" name="teacher_slug" value="<?php echo ($bt_options['teacher_slug']) ? $bt_options['teacher_slug'] : 'iw-teacher'; ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
				<div class="control-group">
                    <div class="label"><?php echo __('Categories slug'); ?></div>
                    <div class="control">
                        <input type="text" name="category_slug" value="<?php echo ($bt_options['category_slug']) ? $bt_options['category_slug'] : 'iw-class'; ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
				<p><?php printf(__('Please go to Settings -> %s, click save to flush rewrite rules and apply changes'),'<a href="options-permalink.php">'.__("Permalink").'</a>'); ?></p>
                <h3 class="header-text"><?php echo __("Listing options"); ?></h3>
                <div class="control-group">
                    <div class="label"><?php echo __('Courses listing limit'); ?></div>
                    <div class="control">
                        <input type="text" name="port_limit" value="<?php echo ($bt_options['port_limit']) ? $bt_options['port_limit'] : '5'; ?>"/>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('Courses order'); ?></div>
                    <div class="control">
                        <?php
                        $order_data = array(
                            array('value' => 'ID', 'text' => 'ID'),
                            array('value' => 'post_title', 'text' => 'Title'),
                            array('value' => 'post_comment', 'text' => 'Comment'),
							array('value' => 'menu_order', 'text' => 'Ordering'),
                            array('value' => 'rand', 'text' => 'Random')
                        );
                        echo $utility->selectFieldRender('port_order', 'port_order', $bt_options['port_order'], $order_data, 'Select a value', '', false);
                        ?>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('Courses order direction'); ?></div>
                    <div class="control">
                        <?php
                        $direction_data = array(
                            array('value' => 'ASC', 'text' => 'ASC'),
                            array('value' => 'DESC', 'text' => 'DESC')
                        );
                        echo $utility->selectFieldRender('port_order_direction', 'port_order_direction', $bt_options['port_order_direction'], $direction_data, 'Select a value', '', false);
                        ?>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('Category order'); ?></div>
                    <div class="control">
                        <select name="cat_order">
                            <option <?php echo ($bt_options['cat_order'] == 'id') ? 'selected = "selected"' : ''; ?> value="id"><?php echo __("ID"); ?></option>
                            <option <?php echo ($bt_options['cat_order'] == 'title') ? 'selected = "selected"' : ''; ?> value="title"><?php echo __("Title"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('Category order direction'); ?></div>
                    <div class="control">
                        <select name="cat_order_direction">
                            <option <?php echo ($bt_options['cat_order_direction'] == 'ASC') ? 'selected = "selected"' : ''; ?> value="ASC"><?php echo __("Asc"); ?></option>
                            <option <?php echo ($bt_options['cat_order_direction'] == 'DESC') ? 'selected = "selected"' : ''; ?> value="DESC"><?php echo __("Desc"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <h3 class="header-text"><?php echo __("Category layout"); ?></h3>
                <div class="control-group">
                    <div class="label"><?php echo __('Category layout'); ?></div>
                    <div class="control">
                        <select name="cat_layout">
                            <option <?php echo ($bt_options['cat_layout'] == 'flat') ? 'selected = "selected"' : ''; ?> value="flat"><?php echo __("Flat list"); ?></option>
                            <option <?php echo ($bt_options['cat_layout'] == 'grid') ? 'selected = "selected"' : ''; ?> value="grid"><?php echo __("Grid list"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('Grid column'); ?></div>
                    <div class="control">
                        <input type="text" name="grid_column" value="<?php echo ($bt_options['grid_column']) ? $bt_options['grid_column'] : '3'; ?>"/>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('Sub-categories'); ?></div>
                    <div class="control">
                        <select name="cat_sub">
                            <option <?php echo ($bt_options['cat_sub'] == 'show') ? 'selected = "selected"' : ''; ?> value="show"><?php echo __("Show"); ?></option>
                            <option <?php echo ($bt_options['cat_sub'] == 'hide') ? 'selected = "selected"' : ''; ?> value="hide"><?php echo __("Hide"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('Courses'); ?></div>
                    <div class="control">
                        <select name="cat_show_ports">
                            <option <?php echo ($bt_options['cat_show_ports'] == 'show') ? 'selected = "selected"' : ''; ?> value="show"><?php echo __("Show"); ?></option>
                            <option <?php echo ($bt_options['cat_show_ports'] == 'hide') ? 'selected = "selected"' : ''; ?> value="hide"><?php echo __("Hide"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <h3 class="header-text"><?php echo __("Image options"); ?></h3>
                <div class="control-group">
                    <div class="label"><?php echo __('Large img processing'); ?></div>
                    <div class="control">
                        <select name="large_image_proc">
                            <option <?php echo ($bt_options['large_image_proc'] == 'crop') ? 'selected = "selected"' : ''; ?> value="crop"><?php echo __("Crop"); ?></option>
                            <option <?php echo ($bt_options['large_image_proc'] == 'resize') ? 'selected = "selected"' : ''; ?> value="resize"><?php echo __("Resize"); ?></option>
                            <option <?php echo ($bt_options['large_image_proc'] == 'resize_keep_ratio') ? 'selected = "selected"' : ''; ?> value="resize_keep_ratio"><?php echo __("Resize and Keep ratio"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('Thumbnail img processing'); ?></div>
                    <div class="control">
                        <select name="thumb_image_proc">
                            <option <?php echo ($bt_options['thumb_image_proc'] == 'crop') ? 'selected = "selected"' : ''; ?> value="crop"><?php echo __("Crop"); ?></option>
                            <option <?php echo ($bt_options['thumb_image_proc'] == 'resize') ? 'selected = "selected"' : ''; ?> value="resize"><?php echo __("Resize"); ?></option>
                            <option <?php echo ($bt_options['thumb_image_proc'] == 'resize_keep_ratio') ? 'selected = "selected"' : ''; ?> value="resize_keep_ratio"><?php echo __("Resize and Keep ratio"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('Crop position'); ?></div>
                    <div class="control">
                        <select name="crop_position">
                            <option <?php echo ($bt_options['crop_position'] == 'center') ? 'selected = "selected"' : ''; ?> value="center"><?php echo __("Center"); ?></option>
                            <option <?php echo ($bt_options['crop_position'] == 'top_left') ? 'selected = "selected"' : ''; ?> value="top_left"><?php echo __("Top Left"); ?></option>
                            <option <?php echo ($bt_options['crop_position'] == 'top_middle') ? 'selected = "selected"' : ''; ?> value="top_middle"><?php echo __("Top Middle"); ?></option>
                            <option <?php echo ($bt_options['crop_position'] == 'top_right') ? 'selected = "selected"' : ''; ?> value="top_right"><?php echo __("Top Right"); ?></option>
                            <option <?php echo ($bt_options['crop_position'] == 'buttom_left') ? 'selected = "selected"' : ''; ?> value="buttom_left"><?php echo __("Buttom Left"); ?></option>
                            <option <?php echo ($bt_options['crop_position'] == 'buttom_middle') ? 'selected = "selected"' : ''; ?> value="buttom_middle"><?php echo __("Buttom Middle"); ?></option>
                            <option <?php echo ($bt_options['crop_position'] == 'buttom_right') ? 'selected = "selected"' : ''; ?> value="buttom_right"><?php echo __("Buttom Right"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('JPEG Quality'); ?></div>
                    <div class="control">
                        <input name="jpeg_quality" max="100" min="0" type="number" value="<?php echo ($bt_options['jpeg_quality'] ? $bt_options['jpeg_quality'] : '100'); ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('Image width'); ?></div>
                    <div class="control">
                        <input name="image_width"  type="text" value="<?php echo ($bt_options['image_width'] ? $bt_options['image_width'] : '600'); ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('Image height'); ?></div>
                    <div class="control">
                        <input name="image_height"  type="text" value="<?php echo ($bt_options['image_height'] ? $bt_options['image_height'] : '400'); ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('Thumbnail width'); ?></div>
                    <div class="control">
                        <input name="thumb_width"  type="text" value="<?php echo ($bt_options['thumb_width'] ? $bt_options['thumb_width'] : '370'); ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('Thumbnail height'); ?></div>
                    <div class="control">
                        <input name="thumb_height"  type="text" value="<?php echo ($bt_options['thumb_height'] ? $bt_options['thumb_height'] : '250'); ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
            </div>

            <div id="review" class="tab">
                <h3 class="header-text"><?php echo __("Voting System"); ?></h3>  
                <div class="control-group">
                    <div class="label"><?php echo __('Enable voting'); ?></div>
                    <div class="control">
                        <select name="enable_voting">
                            <option <?php echo ($bt_options['enable_voting'] == '0') ? 'selected = "selected"' : ''; ?> value="0"><?php echo __("No"); ?></option>
                            <option <?php echo ($bt_options['enable_voting'] == '1') ? 'selected = "selected"' : ''; ?> value="1"><?php echo __("Yes"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('Allow guest votes'); ?></div>
                    <div class="control">
                        <select name="allow_guest_vote">
                            <option <?php echo ($bt_options['allow_guest_vote'] == '0') ? 'selected = "selected"' : ''; ?> value="0"><?php echo __("No"); ?></option>
                            <option <?php echo ($bt_options['allow_guest_vote'] == '1') ? 'selected = "selected"' : ''; ?> value="1"><?php echo __("Yes"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <h3 class="header-text"><?php echo __("Review System"); ?></h3>  
                <div class="control-group">
                    <div class="label"><?php echo __('Enable Review'); ?></div>
                    <div class="control">
                        <select name="enable_review">
                            <option <?php echo ($bt_options['enable_review'] == '0') ? 'selected = "selected"' : ''; ?> value="0"><?php echo __("No"); ?></option>
                            <option <?php echo ($bt_options['enable_review'] == '1') ? 'selected = "selected"' : ''; ?> value="1"><?php echo __("Yes"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
            </div>

            <div id="advanced" class="tab">
                <h3 class="header-text"><?php echo __("Watermark System"); ?></h3> 
                <div class="control-group">
                    <div class="label"><?php echo __('Watemark system'); ?></div>
                    <div class="control">
                        <select name="enable_watemark">
                            <option <?php echo ($bt_options['enable_watemark'] == '0') ? 'selected = "selected"' : ''; ?> value="0"><?php echo __("No"); ?></option>
                            <option <?php echo ($bt_options['enable_watemark'] == '1') ? 'selected = "selected"' : ''; ?> value="1"><?php echo __("Yes"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('Watemark on thumbnail'); ?></div>
                    <div class="control">
                        <select name="enable_watemark_thumbnail">
                            <option <?php echo ($bt_options['enable_watemark'] == '0') ? 'selected = "selected"' : ''; ?> value="0"><?php echo __("No"); ?></option>
                            <option <?php echo ($bt_options['enable_watemark'] == '1') ? 'selected = "selected"' : ''; ?> value="1"><?php echo __("Yes"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('WM type'); ?></div>
                    <div class="control">
                        <select name="wm_type">
                            <option <?php echo ($bt_options['wm_type'] == 'image') ? 'selected = "selected"' : ''; ?> value="image"><?php echo __("Image"); ?></option>
                            <option <?php echo ($bt_options['wm_type'] == 'text') ? 'selected = "selected"' : ''; ?> value="text"><?php echo __("Text"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>

                <div class="control-group">
                    <div class="label"><?php echo __('WM Text'); ?></div>
                    <div class="control">
                        <input name="wm_text"  type="text" value="<?php echo ($bt_options['wm_text'] ? $bt_options['wm_text'] : '@inwavethemes.com'); ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('WM Font'); ?></div>
                    <div class="control">
                        <select name="wm_font">
                            <option <?php echo ($bt_options['wm_font'] == 'arial') ? 'selected = "selected"' : ''; ?> value="arial"><?php echo __("Arial"); ?></option>
                            <option <?php echo ($bt_options['wm_font'] == 'tahoma') ? 'selected = "selected"' : ''; ?> value="tahoma"><?php echo __("Tahoma"); ?></option>
                            <option <?php echo ($bt_options['wm_font'] == 'times') ? 'selected = "selected"' : ''; ?> value="times"><?php echo __("Times"); ?></option>
                            <option <?php echo ($bt_options['wm_font'] == 'verdana') ? 'selected = "selected"' : ''; ?> value="verdana"><?php echo __("Verdana"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('WM Font color'); ?></div>
                    <div class="control">
                        <input name="wm-fcolor"  type="text" value="<?php echo ($bt_options['wm-fcolor'] ? $bt_options['wm-fcolor'] : 'ffffff'); ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('WM Font Size'); ?></div>
                    <div class="control">
                        <input name="wm-fsize"  type="text" value="<?php echo ($bt_options['wm-fsize'] ? $bt_options['wm-fsize'] : '11'); ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('WM Background'); ?></div>
                    <div class="control">
                        <select name="wm_bg">
                            <option <?php echo ($bt_options['wm_bg'] == '0') ? 'selected = "selected"' : ''; ?> value="0"><?php echo __("No"); ?></option>
                            <option <?php echo ($bt_options['wm_bg'] == '1') ? 'selected = "selected"' : ''; ?> value="1"><?php echo __("Yes"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('WM Background color'); ?></div>
                    <div class="control">
                        <input name="wm-bgcolor"  type="text" value="<?php echo ($bt_options['wm-bgcolor'] ? $bt_options['wm-bgcolor'] : '000000'); ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('WM Image'); ?></div>
                    <div class="control">
                        <input name="wm_image"  type="text" value="<?php echo ($bt_options['wm_image'] ? $bt_options['wm_image'] : ''); ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('WM position'); ?></div>
                    <div class="control">
                        <select name="wm_position">
                            <option <?php echo ($bt_options['wm_position'] == 'top_left') ? 'selected = "selected"' : ''; ?> value="top_left"><?php echo __("Top Left"); ?></option>
                            <option <?php echo ($bt_options['wm_position'] == 'top_right') ? 'selected = "selected"' : ''; ?> value="top_right"><?php echo __("Top Right"); ?></option>
                            <option <?php echo ($bt_options['wm_position'] == 'buttom_left') ? 'selected = "selected"' : ''; ?> value="buttom_left"><?php echo __("Buttom Left"); ?></option>
                            <option <?php echo ($bt_options['wm_position'] == 'buttom_right') ? 'selected = "selected"' : ''; ?> value="buttom_right"><?php echo __("Buttom Right"); ?></option>
                            <option <?php echo ($bt_options['wm_position'] == 'center') ? 'selected = "selected"' : ''; ?> value="center"><?php echo __("Center"); ?></option>
                        </select>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('WM Padding'); ?></div>
                    <div class="control">
                        <input name="wm_padding"  type="text" value="<?php echo ($bt_options['wm_padding'] ? $bt_options['wm_image'] : '4'); ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('WM Opacity'); ?></div>
                    <div class="control">
                        <input name="wm_opacity"  type="text" value="<?php echo ($bt_options['wm_opacity'] ? $bt_options['wm_opacity'] : '70'); ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="control-group">
                    <div class="label"><?php echo __('WM Rotate'); ?></div>
                    <div class="control">
                        <input name="wm_rotate"  type="text" value="<?php echo ($bt_options['wm_rotate'] ? $bt_options['wm_rotate'] : '0'); ?>" />
                    </div>
                    <div style="clear: both"></div>
                </div>
            </div>
        </div>
        <input type="hidden" name="action" value="iw_courses_setting">
        <input type="submit" value="<?php echo __("Save"); ?>"/>
    </form>
</div>
<script tpe="text/javascript">
    jQuery(document).ready(function () {
        jQuery('select[name="cat_layout"]').change(function () {
            var select = jQuery(this).val();
            if (select === 'grid') {
                jQuery('input[name="grid_column"]').parent().parent().show();
            } else {
                jQuery('input[name="grid_column"]').parent().parent().hide();
            }
        }).trigger('change');

        jQuery('select[name="default_slideshow"]').change(function () {
            var select = jQuery(this).val();
            if (select === 'skitter') {
                jQuery('select[name="slideshow_skitter_effect"]').parent().parent().show();
                jQuery('select[name="slideshow_media_effect"]').parent().parent().hide();
            } else if (select === 'media') {
                jQuery('select[name="slideshow_skitter_effect"]').parent().parent().hide();
                jQuery('select[name="slideshow_media_effect"]').parent().parent().show();
            } else {
                jQuery('select[name="slideshow_skitter_effect"]').parent().parent().hide();
                jQuery('select[name="slideshow_media_effect"]').parent().parent().hide();
            }
        }).trigger('change');


        jQuery('select[name="wm_type"]').change(function () {
            var select = jQuery(this).val();
            if (select === 'text') {
                jQuery('input[name="wm_text"]').parent().parent().show();
                jQuery('select[name="wm_font"]').parent().parent().show();
                jQuery('input[name="wm-fcolor"]').parent().parent().show();
                jQuery('input[name="wm-fsize"]').parent().parent().show();
                jQuery('select[name="wm_bg"]').parent().parent().show();
                jQuery('input[name="wm-bgcolor"]').parent().parent().show();
                jQuery('input[name="wm_image"]').parent().parent().hide();
            } else {
                jQuery('input[name="wm_text"]').parent().parent().hide();
                jQuery('select[name="wm_font"]').parent().parent().hide();
                jQuery('input[name="wm-fcolor"]').parent().parent().hide();
                jQuery('input[name="wm-fsize"]').parent().parent().hide();
                jQuery('select[name="wm_bg"]').parent().parent().hide();
                jQuery('input[name="wm-bgcolor"]').parent().parent().hide();
                jQuery('input[name="wm_image"]').parent().parent().show();
            }
        }).trigger('change');


        jQuery('select[name="social_share"]').change(function () {
            var select = jQuery(this).val();
            if (select === '0') {
                jQuery('#social_share_buttons').parent().parent().hide();
            } else {
                jQuery('#social_share_buttons').parent().parent().show();
            }
        }).trigger('change');
    });
</script>