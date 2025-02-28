<?php
/**
 * Page create new parallax type image gallery
 *
 * @author Inwavethemes
 * @package AP Background
 * @version 1.0.0
 */
?>

<!--Image source-->
<div class="group-content">
    <h2 class="title"><?php echo __('Image Sources', 'inwavethemes'); ?></h2>
    <div class="content image">
        <div class="item-source from-media">
            <span class="icon"><i class="fa fa-plus fa-3x"></i></span>
        </div>
        <div class="item-source from-flickr">
            <span class="icon"><i class="fa fa-flickr fa-3x"></i></span>
        </div>
        <div class="item-source from-facebook">
            <span class="icon"><i class="fa fa-facebook-square fa-3x"></i></span>
        </div>
        <div class="item-source from-google">
            <span class="icon"><i class="fa fa-google-plus-square fa-3x"></i></span>
        </div>
        <div style="clear: both"></div>
    </div>
</div>

<!--Image list items-->
<div class="group-content image">
    <h2 class="title"><?php echo __('Image Gallery', 'inwavethemes'); ?><span class="bt-ajax-loading add-item-ajax"><i class="fa fa-circle-o-notch fa-spin"></i></span></h2>
    <div class="content">
        <div class="list-items" id="list-items">
            <?php if ($item->settings->media_source->items): ?>
                <?php
                foreach ($item->settings->media_source->items as $media_item):
                    ?>
                    <div class="media-item">
                        <div class="item-control">
                            <div class="inner-control">
                                <span class="delete"><i class="fa fa-times"></i></span>
                                <span class="edit"><i class="fa fa-pencil"></i></span>
                                <span class="select"><i class="fa fa-check"></i></span>
                            </div>
                        </div>
                        <img width="130" src="<?php echo ($media_item->media_source == 'image_upload') ? site_url() . $media_item->large : $media_item->large; ?>"  alt="<?php echo __('Image upload');?>"/>
                        <input type="hidden" name="settings[media_source][items][]" value="<?php echo htmlspecialchars(stripslashes(json_encode($media_item))); ?>">
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div style="clear: both"></div>
        <div class="control-buttons">
            <div class="create-button">
                <span class="button blue delete-selected"><i class="fa fa-times"></i> <?php echo __('DELETE SELECTED', 'inwavethemes'); ?></span>
            </div>
            <div class="delete-button">
                <span class="button red delete-all"><i class="fa fa-times"></i> <?php echo __('DELETE ALL', 'inwavethemes'); ?></span>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>
</div>

<!--Image Layout setting-->
<div class="group-content">
    <h2 class="title"><?php echo __('Layout settings', 'inwavethemes'); ?></h2>
    <div class="content">
        <div class="control-group">
            <div class="label" style="margin-bottom: 15px;"><?php echo __('Select our layout templates', 'inwavethemes'); ?></div>
            <div class="layout-list">
                <?php
                $layout = $item->settings->layout_setting->layout;
                ?>
                <div class="item-layout default<?php echo ($layout == 'default' || !$layout) ? ' selected' : ''; ?>" data-layout="default">
                    <span class="item-selected"><i class="fa fa-check"></i></span>
                </div>
                <div class="item-layout flexible<?php echo ($layout == 'flexible') ? ' selected' : ''; ?>" data-layout="flexible">
                    <span class="item-selected"><i class="fa fa-check"></i></span>
                </div>
                <input type="hidden" value="<?php echo ($layout) ? $layout : 'default'; ?>" name="settings[layout_setting][layout]"/>
                <div style="clear: both"></div>
            </div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Auto resize gallery', 'inwavethemes'); ?></div>
            <div class="control">
                <?php
                $autozesizegallery = array(
                    array('value' => '0', 'text' => __('No', 'inwavethemes')),
                    array('value' => '1', 'text' => __('Yes', 'inwavethemes'))
                );
                echo $bt_utility->selectFieldRender('auto_resize_gallery', 'settings[layout_setting][auto_resize_gallery]', $item->settings->layout_setting->auto_resize_gallery, $autozesizegallery, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Thumbnail width', 'inwavethemes'); ?></div>
            <div class="control">
                <input class="input-short" value="<?php echo ($item->settings->layout_setting->thumb_width) ? $item->settings->layout_setting->thumb_width : '200'; ?>" type="text" name="settings[layout_setting][thumb_width]"/> px
                <span><?php echo __('Height', 'inwavethemes'); ?></span>
                <input class="input-short" value="<?php echo ($item->settings->layout_setting->thumb_height) ? $item->settings->layout_setting->thumb_height : '200'; ?>" type="text" name="settings[layout_setting][thumb_height]"/> px
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Number of row', 'inwavethemes'); ?></div>
            <div class="control">
                <input class="input-short" type="text" value="<?php echo ($item->settings->layout_setting->rows) ? $item->settings->layout_setting->rows : '2'; ?>" name="settings[layout_setting][rows]"/>
                <span><?php echo __('Spacing', 'inwavethemes'); ?></span>
                <input class="input-short" value="<?php echo ($item->settings->layout_setting->spacing) ? $item->settings->layout_setting->spacing : '5'; ?>" type="text" name="settings[layout_setting][spacing]"/> px
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Thumbnail process', 'inwavethemes'); ?></div>
            <div class="control">
                <?php
                $thumProcess = array(
                    array('value' => 'none', 'text' => __('None', 'inwavethemes')),
                    array('value' => 'crop', 'text' => __('Crop', 'inwavethemes')),
                    array('value' => 'resize', 'text' => __('Resize', 'inwavethemes')),
                    array('value' => 'resizekeepratio', 'text' => __('Resize keep ratio', 'inwavethemes'))
                );
                echo $bt_utility->selectFieldRender('layout_setting_thumb_process', 'settings[layout_setting][thumb_process]', $item->settings->layout_setting->thumb_process, $thumProcess, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>
</div>

<!--Effect setting-->
<div class="group-content">
    <h2 class="title"><?php echo __('Effect setting', 'inwavethemes'); ?></h2>
    <div class="content">
        <div class="label" style="margin-bottom: 15px;"><?php echo __('Select effect for image gallery', 'inwavethemes'); ?></div>
        <div class="control-group">
            <div class="label"><?php echo __('Content appare', 'inwavethemes'); ?></div>
            <div class="control">
                <?php
                $data = array(
                    array('value' => 'fade_left', 'text' => __('Fade from left', 'inwavethemes')),
                    array('value' => 'fade_top', 'text' => __('Fade from top', 'inwavethemes')),
                    array('value' => 'fade_right', 'text' => __('Fade from right', 'inwavethemes')),
                    array('value' => 'fade_bottom', 'text' => __('Fade from bottom', 'inwavethemes'))
                );
                echo $bt_utility->selectFieldRender('item_source_effect_settings_effect_in', 'settings[media_source][effect_settings][effect_in]', $item->settings->media_source->effect_settings->effect_in, $data, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Content disappare', 'inwavethemes'); ?></div>
            <div class="control">
                <?php
                $data = array(
                    array('value' => 'fade_left', 'text' => __('Fade from left', 'inwavethemes')),
                    array('value' => 'fade_top', 'text' => __('Fade from top', 'inwavethemes')),
                    array('value' => 'fade_right', 'text' => __('Fade from right', 'inwavethemes')),
                    array('value' => 'fade_bottom', 'text' => __('Fade from bottom', 'inwavethemes'))
                );
                echo $bt_utility->selectFieldRender('item_source_effect_settings_effect_out', 'settings[media_source][effect_settings][effect_out]', $item->settings->media_source->effect_settings->effect_out, $data, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Scroll direction', 'inwavethemes'); ?></div>
            <div class="control">
                <?php
                $scrolldata = array(
                    array('value' => 'rtl', 'text' => __('Right to Left', 'inwavethemes')),
                    array('value' => 'ltr', 'text' => __('Left to Right', 'inwavethemes'))
                );
                echo $bt_utility->selectFieldRender('item_source_effect_settings_scroll_direction', 'settings[media_source][effect_settings][scroll_direction]', $item->settings->media_source->effect_settings->scroll_direction, $scrolldata, '', '', false);
                ?>
                <span class="descript"><?php echo __('List image scroll direction.', 'inwavethemes'); ?></span>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="label" style="margin-bottom: 15px;"><?php echo __('Custom content effect setting code', 'inwavethemes'); ?></div>
        <div class="custom-effect">
            <textarea id="content_settings_effect_settings_custom_effect_code" name="settings[media_source][effect_settings][custom_effect_code]"><?php echo ($item->settings->media_source->effect_settings->custom_effect_code) ? $item->settings->media_source->effect_settings->custom_effect_code : $bt_utility->loadContentEffectCss('out-fade_left', 'in-fade_left', 'item'); ?></textarea>
            <input type="hidden" id="ap_background_flickr_api" name="ap_background_flickr_api" value="<?php echo get_option('ap_background_flickr_api'); ?>"/>
        </div>
    </div>
</div>

<div class="bt-parallax-get-media-item hidden">
    <div class="bg-type-list-wrap">
        <div class="get-from-wrap flickr" style="display: none;">
            <div class="header-title"><?php echo __('GET IMAGE FROM FLICKR', 'inwavethemes'); ?></div>
            <div class="control-group">
                <div class="label"><?php echo __('Flickr API', 'inwavethemes'); ?></div>
                <div class="control">
                    <input id="media_source_flickr_api" name="media_source_flickr_api" value="<?php echo get_option('ap_background_flickr_api'); ?>" type="text"/>
                </div>
                <div style="clear: both"></div>
            </div>
            <div class="control-group">
                <div class="label"><?php echo __('Username', 'inwavethemes'); ?></div>
                <div class="control">
                    <input id="flickr_uname" name="flickr_umame" value="" type="text"/>
                </div>
                <div style="clear: both"></div>
            </div>
            <div class="control-group">
                <div class="label">
                    <?php echo __('Flickr Album', 'inwavethemes'); ?>
                    <span class="bt-ajax-loading load-album-item-ajax"><i class="fa fa-circle-o-notch fa-spin"></i></span>
                </div>
                <div class="control">
                    <select id="flickr_album" name="flickr_album" type="text">
                        <option value="">Please select an album</option>
                    </select>
                </div>
                <div style="clear: both"></div>
            </div>
        </div>
        <div class="get-from-wrap facebook" style="display: none;">
            <div class="header-title"><?php echo __('GET IMAGE FROM FACEBOOK', 'inwavethemes'); ?></div>
            <div class="control-group">
                <div class="label"><?php echo __('Facebook URL', 'inwavethemes'); ?></div>
                <div class="control">
                    <input placeholder="<?php echo __('Facebook page profile URL', 'inwavethemes'); ?>" id="facebook_uname" name="facebook_umame" value="" type="text"/>
                </div>
                <div style="clear: both"></div>
            </div>
            <div class="control-group">
                <div class="label">
                    <?php echo __('Facebook Album', 'inwavethemes'); ?>
                    <span class="bt-ajax-loading load-album-item-ajax"><i class="fa fa-circle-o-notch fa-spin"></i></span>
                </div>
                <div class="control">
                    <select id="facebook_album" name="facebook_album" type="text">
                        <option value="">Please select an album</option>
                    </select>
                </div>
                <div style="clear: both"></div>
            </div>
        </div>
        <div class="get-from-wrap picasa" style="display: none;">
            <div class="header-title"><?php echo __('GET IMAGE FROM GOOGLE', 'inwavethemes'); ?></div>
            <div class="control-group">
                <div class="label"><?php echo __('Username', 'inwavethemes'); ?></div>
                <div class="control">
                    <input id="picasa_uname" name="picasa_uname" value="" type="text"/>
                </div>
                <div style="clear: both"></div>
            </div>
            <div class="control-group">
                <div class="label">
                    <?php echo __('Picasa Album', 'inwavethemes'); ?>
                    <span class="bt-ajax-loading load-album-item-ajax"><i class="fa fa-circle-o-notch fa-spin"></i></span>
                </div>
                <div class="control">
                    <select id="picasa_album" name="picasa_album" type="text">
                        <option value="">Please select an album</option>
                    </select>
                </div>
                <div style="clear: both"></div>
            </div>
        </div>
        <div class="create-slideshow">
            <span class="button blue get-video"><?php echo __('GET IMAGES', 'inwavethemes'); ?></span>
        </div>
    </div>
</div>
 <script>
jQuery(function() {
jQuery( "#list-items" ).sortable();
jQuery( "#list-items" ).disableSelection();
});
</script>