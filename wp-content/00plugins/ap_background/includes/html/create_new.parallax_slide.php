<?php
/**
 * Page create new parallax tab general settings for parallax.
 *
 * @author Inwavethemes
 * @package AP Background
 * @version 1.0.0
 */
?>

<!--General setting-->
<div class="group-content">
    <h2 class="title"><?php echo __('General setting', 'inwavethemes'); ?></h2>
    <div class="content">
        <div class="label" style="margin-bottom: 15px;"><?php echo __('Slider name and Dimentions', 'inwavethemes'); ?></div>
        <div class="control-group">
            <div class="label"><?php echo __('Slider name', 'inwavethemes'); ?></div>
            <div class="control">
                <input type="text" name="slide_name" value="<?php echo ($item->name) ? $item->name : ''; ?>"/>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Alias name', 'inwavethemes'); ?></div>
            <div class="control">
                <input type="text" value="<?php echo ($item->alias) ? $item->alias : ''; ?>" placeholder="<?php echo __('Auto generate from slider name', 'inwavethemes'); ?>" name="alias_name"/>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Slider width', 'inwavethemes'); ?></div>
            <div class="control">
                <?php
                $slider_size = array(
                    array('value' => 'auto', 'text' => __('Auto', 'inwavethemes')),
                    array('value' => 'fixed', 'text' => __('Fixed width', 'inwavethemes')),
                    array('value' => 'full', 'text' => __('Full width', 'inwavethemes'))
                );
                echo $bt_utility->selectFieldRender('slider_size_width-type', 'settings[slider_size][width][type]', $item->settings->slider_size->width->type, $slider_size, '', 'input-medium slider-size-width-type', false);
                ?>
                <span class="slider-size-width-size" style="<?php echo $item->settings->slider_size->width->type ? ($item->settings->slider_size->width->type == 'fixed' ? 'display:none;' : '') : 'display:none;'; ?>">
                    <input placeholder="<?php echo __('Slider width'); ?>" class="input-short" value="<?php echo ($item->settings->slider_size->width->size) ? $item->settings->slider_size->width->size : ''; ?>" type="text" name="settings[slider_size][width][size]"/> px
                </span>
                <span><?php echo __('Slider height', 'inwavethemes'); ?></span>
                <input class="input-short" value="<?php echo ($item->settings->slider_size->height) ? $item->settings->slider_size->height : '300'; ?>" type="text" name="settings[slider_size][height]"/> px
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Background type', 'inwavethemes'); ?></div>
            <div class="control">
                <?php
                $bgdata = array(
                    array('value' => 'img', 'text' => __('Image background', 'inwavethemes')),
                    array('value' => 'video', 'text' => __('Video background', 'inwavethemes'))
                );
                echo $bt_utility->selectFieldRender('bg_type', 'settings[bg_type]', $item->settings->bg_type, $bgdata, '', 'bt-type', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Parallax background type', 'inwavethemes'); ?></div>
            <div class="control">
                <?php
                $pbgdata = array(
                    array('value' => 'dynamic', 'text' => __('Dynamic parallax', 'inwavethemes')),
                    array('value' => 'static', 'text' => __('Static parallax', 'inwavethemes'))
                );
                echo $bt_utility->selectFieldRender('parallax_bg_type', 'settings[parallax_bg_type]', $item->settings->parallax_bg_type, $pbgdata, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Background content color', 'inwavethemes'); ?></div>
            <div class="control">
                <div class="input-color-bgcontent-box">
                    <input name="settings[background_settings][bg_content_color]" value="<?php echo ($item->settings->background_settings->bg_content_color) ? $item->settings->background_settings->bg_content_color : ''; ?>" type="text" style="<?php echo ($item->settings->background_settings->bg_content_color) ? 'background-color:'.$item->settings->background_settings->bg_content_color.';color:#fff;' : ''; ?>" placeholder="None" class="input-color-bgcontent"/>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Enable parallax effect', 'inwavethemes'); ?></div>
            <div class="control">
                <?php
                $enpadata = array(
                    array('value' => '1', 'text' => __('Yes', 'inwavethemes')),
                    array('value' => '0', 'text' => __('No', 'inwavethemes'))
                );
                echo $bt_utility->selectFieldRender('enable_parallax_effect', 'settings[enable_parallax_effect]', $item->settings->enable_parallax_effect, $enpadata, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Hide slider under width', 'inwavethemes'); ?></div>
            <div class="control">
                <input type="text" name="settings[min_width_allow]" value="<?php echo ($item->settings->min_width_allow) ? $item->settings->min_width_allow : '400'; ?>"/>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>
</div>

<!--Image background setting-->
<div class="group-content img-background" style="<?php echo ($item->settings->bg_type == 'img') ? '' : 'display:none;'; ?>">
    <h2 class="title no-spacing-bottom"><?php echo __('Images background setting', 'inwavethemes'); ?></h2>
    <div class="content">
        <div class="control-group">
            <div class="group-inner">
                <div class="label"><?php echo __('Background image', 'inwavethemes'); ?></div>
                <div class="control">
                    <div class="background-act select-image">
                        <div class="image-preview">
                            <?php
                            if ($item->settings->background_settings->image->background_image) {
                                $ratio = 0.68;
                                list($width, $height) = getimagesize(site_url() . $item->settings->background_settings->image->background_image);
                                if ($height / $width > $ratio) {
                                    $style_img = 'style="width:100%;"';
                                } else {
                                    $style_img = 'style="height:100%;"';
                                }
                            }
                            ?>
                            <div class="inner-image"><?php echo ($item->settings->background_settings->image->background_image) ? '<img ' . $style_img . ' src="' . site_url() . $item->settings->background_settings->image->background_image . '"  alt="'.__('Loading...').'"/>' : ''; ?></div>
                        </div>
                        <div class="control-button one-row"><span><i class="fa fa-plus"></i></span></div>
                        <input class="background_image" type="hidden" name="settings[background_settings][image][background_image]" value="<?php echo ($item->settings->background_settings->image->background_image) ? $item->settings->background_settings->image->background_image : ''; ?>"/>
                    </div>
                </div>
            </div>
            <div class="group-inner">
                <div class="label last"><?php echo __('Textured or color', 'inwavethemes'); ?></div>
                <div class="control">
                    <div class="background-act colorbox">
                        <?php
                        $style = '';
                        if ($item->settings->background_settings->image->textured) {
                            $style = 'background-image: url(' . site_url() . '/wp-content/plugins/ap_background/assets/images/' . $item->settings->background_settings->image->textured . '.png);';
                        }
                        if ($item->settings->background_settings->image->color) {
                            if ($style) {
                                $style .= 'background-color: ' . $item->settings->background_settings->image->color . ';';
                            } else {
                                $style = 'background-color: ' . $item->settings->background_settings->image->color . ';';
                            }
                        }
                        if ($style) {
                            $style = 'style="' . $style . '"';
                        }
                        ?>
                        <div class="image-preview">
                            <div class="inner-image" <?php echo $style; ?>></div>
                        </div>
                        <div class="control-button two-row">
                            <div class="control-top"><span><i class="fa fa-plus"></i></span></div>
                            <div class="control-buttom"><span><i class="fa fa-caret-down"></i></span></div>
                        </div>
                    </div>
                    <div class="input-color-box">
                        <input name="settings[background_settings][image][color]" value="<?php echo ($item->settings->background_settings->image->color) ? $item->settings->background_settings->image->color : ''; ?>" type="text" placeholder="Select color" class="input-color"/>
                    </div>
                    <ul class="list-textured">
                        <li class="textured-item"><div class="pattern-0"><span>None</span></div></li>
                        <li class="textured-item"><div class="pattern-1"></div></li>
                        <li class="textured-item"><div class="pattern-2"></div></li>
                        <li class="textured-item"><div class="pattern-3"></div></li>
                        <li class="textured-item"><div class="pattern-4"></div></li>
                        <li class="textured-item"><div class="pattern-5"></div></li>
                        <li class="textured-item"><div class="pattern-6"></div></li>
                        <li class="textured-item"><div class="pattern-7"></div></li>
                        <li class="textured-item"><div class="pattern-8"></div></li>
                        <li class="textured-item"><div class="pattern-9"></div></li>
                        <li class="textured-item"><div class="pattern-10"></div></li>
                        <li class="textured-item"><div class="pattern-11"></div></li>
                        <li class="textured-item"><div class="pattern-12"></div></li>
                        <li class="textured-item"><div class="pattern-13"></div></li>
                        <li style="display: none;"><input type="hidden" value="<?php echo ($item->settings->background_settings->image->textured) ? $item->settings->background_settings->image->textured : ''; ?>" name="settings[background_settings][image][textured]"/></li>
                    </ul>
                </div>
            </div>
            <div class="group-inner">
                <div class="label last"><?php echo __('Opacity', 'inwavethemes'); ?></div>
                <div class="control">
                    <div class="background-act opacity">
                        <div class="image-preview">
                            <div class="inner-image">
                                <?php
                                $style2 = '';
                                if ($item->settings->background_settings->image->textured) {
                                    $style2 = 'background-image: url(' . site_url() . '/wp-content/plugins/ap_background/assets/images/' . $item->settings->background_settings->image->textured . '.png);';
                                }
                                if ($item->settings->background_settings->image->color) {
                                    if ($style2) {
                                        $style2 .= 'background-color: ' . $item->settings->background_settings->image->color . ';';
                                    } else {
                                        $style2 = 'background-color: ' . $item->settings->background_settings->image->color . ';';
                                    }
                                }
                                if ($style2) {
                                    $style2 = 'style="' . $style2 . ' opacity: ' . $item->settings->background_settings->image->opacity . '"';
                                }
                                ?>
                                <div class="image"><?php echo ($item->settings->background_settings->image->background_image) ? '<img ' . $style_img . ' src="'.  site_url() . $item->settings->background_settings->image->background_image . '"  alt="'.__('Loading...').'"/>' : ''; ?></div>
                                <div class="pattern" <?php echo ($style2) ? $style2 : ''; ?>></div>
                            </div>
                        </div>
                        <div class="control-button one-row"><span><i class="fa fa-caret-down"></i></span></div>
                    </div>
                    <div class="input-slider">
                        <input class="change-opacity" name="settings[background_settings][image][opacity]" type="range" min="0" max="1" step="0.01" value="<?php echo ($item->settings->background_settings->image->opacity) ? $item->settings->background_settings->image->opacity : '0.5'; ?>"/>
                        <input class="change-opacity-text" style="text-align: center;" name="change-opacity-text" type="text" value="<?php echo ($item->settings->background_settings->image->opacity) ? $item->settings->background_settings->image->opacity * 100 : '50'; ?>"/>
                        <div class="opacity-unit"><span>%</span></div>
                    </div>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>
</div>

<!--Video background setting-->
<div class="group-content video-background"  style="<?php echo ($item->settings->bg_type == 'video') ? '' : 'display:none;'; ?>">
    <h2 class="title no-spacing-bottom"><?php echo __('Video background setting', 'inwavethemes'); ?></h2>
    <div class="content">
        <div class="control-group">
            <div class="group-inner">
                <div class="label first">
                    <?php echo __('Background video', 'inwavethemes'); ?>
                    <span class="bt-ajax-loading load-bgimage-ajax"><i class="fa fa-circle-o-notch fa-spin"></i></span>
                    <div style="clear: both"></div>
                </div>
                <div class="control">
                    <div class="background-act select-image">
                        <?php
                        $videobg = $item->settings->background_settings->video->video_url;
                        ?>
                        <div class="image-preview">
                            <div class="inner-image">
                                <?php if ($videobg): ?>
                                    <?php if ($videobg->large): ?>
                                        <img src="<?php echo $videobg->large; ?>"  alt="<?php echo __('Image preview');?>"/>
                                    <?php else: ?>
                                        <div class="video-file"><span><i class="fa fa-file-video-o fa-3x"></i></span></div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="control-button two-row">
                            <div class="control-top"><span><i class="fa fa-arrow-up"></i></span></div>
                            <div class="control-buttom"><span><i class="fa fa-plus"></i></span></div>
                        </div>
                        <input class="background_video" value="<?php echo ($item->settings->background_settings->video->video_url) ? stripslashes(htmlspecialchars(json_encode($item->settings->background_settings->video->video_url))) : ''; ?>" type="hidden" name="settings[background_settings][video][video_url]"/>
                    </div>
                </div>
            </div>
            <div class="group-inner">
                <div class="label last"><?php echo __('Textured or color', 'inwavethemes'); ?></div>
                <div class="control">
                    <div class="background-act colorbox">
                        <?php
                        $style3 = '';
                        if ($item->settings->background_settings->video->textured) {
                            $style3 = 'background-image: url(' . site_url() . '/wp-content/plugins/ap_background/assets/images/' . $item->settings->background_settings->image->textured . '.png);';
                        }
                        if ($item->settings->background_settings->video->color) {
                            if ($style3) {
                                $style3 .= 'background-color: ' . $item->settings->background_settings->video->color . ';';
                            } else {
                                $style3 = 'background-color: ' . $item->settings->background_settings->video->color . ';';
                            }
                        }
                        if ($style3) {
                            $style3 = 'style="' . $style3 . '"';
                        }
                        ?>
                        <div class="image-preview">
                            <div class="inner-image" <?php echo $style3; ?>></div>
                        </div>
                        <div class="control-button two-row">
                            <div class="control-top"><span><i class="fa fa-plus"></i></span></div>
                            <div class="control-buttom"><span><i class="fa fa-caret-down"></i></span></div>
                        </div>
                    </div>
                    <div class="input-color-box">
                        <input name="settings[background_settings][video][color]" value="<?php echo ($item->settings->background_settings->video->color) ? $item->settings->background_settings->video->color : ''; ?>" type="text" placeholder="Select color" class="input-color"/>
                    </div>
                    <ul class="list-textured">
                        <li class="textured-item"><div class="pattern-0"><span>None</span></div></li>
                        <li class="textured-item"><div class="pattern-1"></div></li>
                        <li class="textured-item"><div class="pattern-2"></div></li>
                        <li class="textured-item"><div class="pattern-3"></div></li>
                        <li class="textured-item"><div class="pattern-4"></div></li>
                        <li class="textured-item"><div class="pattern-5"></div></li>
                        <li class="textured-item"><div class="pattern-6"></div></li>
                        <li class="textured-item"><div class="pattern-7"></div></li>
                        <li class="textured-item"><div class="pattern-8"></div></li>
                        <li class="textured-item"><div class="pattern-9"></div></li>
                        <li class="textured-item"><div class="pattern-10"></div></li>
                        <li class="textured-item"><div class="pattern-11"></div></li>
                        <li class="textured-item"><div class="pattern-12"></div></li>
                        <li class="textured-item"><div class="pattern-13"></div></li>
                        <li style="display: none;"><input type="hidden" value="<?php echo ($item->settings->background_settings->video->textured) ? $item->settings->background_settings->video->textured : ''; ?>" name="settings[background_settings][video][textured]"/></li>
                    </ul>
                </div>
            </div>
            <div class="group-inner">
                <div class="label last">
                    <?php echo __('Opacity', 'inwavethemes'); ?>
                    <span class="bt-ajax-loading load-bgimage-ajax"><i class="fa fa-circle-o-notch fa-spin"></i></span></div>
                <div class="control">
                    <div class="background-act opacity">
                        <?php
                        $style4 = '';
                        if ($item->settings->background_settings->video->textured) {
                            $style4 = 'background-image: url(' . site_url() . '/wp-content/plugins/ap_background/assets/images/' . $item->settings->background_settings->image->textured . '.png);';
                        }
                        if ($item->settings->background_settings->video->color) {
                            if ($style4) {
                                $style4 .= 'background-color: ' . $item->settings->background_settings->video->color . ';';
                            } else {
                                $style4 = 'background-color: ' . $item->settings->background_settings->video->color . ';';
                            }
                        }
                        if ($style4) {
                            $style4 = 'style="' . $style4 . ' opacity: ' . $item->settings->background_settings->video->opacity . '"';
                        }
                        ?>
                        <div class="image-preview">
                            <div class="inner-image">
                                <div class="image">
                                    <?php if ($videobg): ?>
                                        <?php if ($videobg->large): ?>
                                            <img src="<?php echo $videobg->large; ?>"  alt="<?php echo __('Image preview');?>"/>
                                        <?php else: ?>
                                            <div class="video-file"><span><i class="fa fa-file-video-o fa-3x"></i></span></div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="pattern" <?php echo $style4; ?>></div>
                            </div>
                        </div>
                        <div class="control-button one-row"><span><i class="fa fa-caret-down"></i></span></div>
                    </div>
                    <div class="input-slider">
                        <input class="change-opacity" name="settings[background_settings][video][opacity]" type="range" min="0" max="1" step="0.01" value="<?php echo ($item->settings->background_settings->video->opacity) ? $item->settings->background_settings->video->opacity : '0.5'; ?>"/>
                        <input class="change-opacity-text" style="text-align: center;" name="change-opacity-text" type="text" value="<?php echo ($item->settings->background_settings->video->opacity) ? $item->settings->background_settings->video->opacity * 100 : '50'; ?>"/>
                        <div class="opacity-unit"><span>%</span></div>
                    </div>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label" style="margin-top: 8px; text-align: left;"><?php echo __('Mute video', 'inwavethemes'); ?></div>
            <div class="control">
                <?php
                $videodata = array(
                    array('value' => '1', 'text' => __('Yes', 'inwavethemes')),
                    array('value' => '0', 'text' => __('No', 'inwavethemes'))
                );
                echo $bt_utility->selectFieldRender('background_settings_video_mute', 'settings[background_settings][video][mute]', $item->settings->background_settings->video->mute, $videodata, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>
</div>

<!--Content setting-->
<div class="group-content">
    <h2 class="title"><?php echo __('Content setting', 'inwavethemes'); ?></h2>
    <div class="content">
        <div class="control-group">
            <div class="label"><?php echo __('Content width', 'inwavethemes'); ?></div>
            <div class="control">
                <input class="input-short" value="<?php echo ($item->settings->content_settings->content_width) ? $item->settings->content_settings->content_width : ''; ?>" type="text" name="settings[content_settings][content_width]"/> px
                <span style="color: #c12c30; font-weight: bold;"><?php echo __('(Blank: 100%)', 'inwavethemes'); ?></span>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="label"><?php echo __('Insert the text content here, for a better SEO result you can use heading tags for important contents', 'inwavethemes'); ?></div>
        <div class="control-group">
            <?php
            wp_editor((stripslashes($item->content)) ? html_entity_decode(stripslashes($item->content)) : '', 'side_content', array('textarea_name' => 'side_content', 'editor_class' => 'slide-content', 'textarea_rows' => 5));
            ?>    
            <div style="clear: both"></div>
        </div>
    </div>
</div>

<!--Effect setting-->
<div class="group-content">
    <h2 class="title"><?php echo __('Effect setting', 'inwavethemes'); ?></h2>
    <div class="content">
        <div class="label" style="margin-bottom: 15px;"><?php echo __('Select effect for content text', 'inwavethemes'); ?></div>
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
                echo $bt_utility->selectFieldRender('content_settings_effect_in', 'settings[content_settings][effect_in]', $item->settings->content_settings->effect_in, $data, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Content disappare', 'inwavethemes'); ?></div>
            <div class="control">
                <?php
                echo $bt_utility->selectFieldRender('content_settings_effect_out', 'settings[content_settings][effect_out]', $item->settings->content_settings->effect_out, $data, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="label" style="margin-bottom: 15px;"><?php echo __('Custom content effect setting code', 'inwavethemes'); ?></div>
        <div class="custom-effect">
            <textarea id="content_settings_custom_effect_code" name="settings[content_settings][custom_effect_code]"><?php echo ($item->settings->content_settings->custom_effect_code) ? $item->settings->content_settings->custom_effect_code : $bt_utility->loadContentEffectCss('out-fade_left', 'in-fade_left', 'content'); ?></textarea>
        </div>
    </div>
</div>

<div class="bt-parallax-select-bg-type hidden">
    <div class="bg-type-list-wrap">
        <div class="header-title"><?php echo __('GET VIDEO BACKGROUND', 'inwavethemes'); ?></div>
        <div class="control-group">
            <div class="label"><?php echo __('Video Url', 'inwavethemes'); ?></div>
            <div class="control">
                <input id="video_url" style="width: 262px;" name="video_url" value="" type="text"/>
            </div>
            <div style="clear: both"></div>
            <div class="descript"><?php echo __('We are support three video url format: <br/> - Direct video: http://domain.com/video-name.mp4<br/> - Youtube: https://www.youtube.com/watch?v=nlXbu32mXzI<br/> - Vimeo: https://vimeo.com/56974406'); ?></div>
        </div>
        <div class="create-slideshow">
            <span class="button blue get-video-bg"><?php echo __('GET VIDEO', 'inwavethemes'); ?></span>
        </div>
    </div>
</div>

<div class="bt-parallax-edit-media-gallery-item hidden">
    <div class="bg-type-list-wrap">
        <div class="get-from-wrap youtube" style="display: none;">
            <div class="header-title"><?php echo __('GET VIDEO FROM YOUTUBE', 'inwavethemes'); ?></div>
            <div class="control-group">
                <div class="label"><?php echo __('Youtube URL', 'inwavethemes'); ?></div>
                <div class="control">
                    <input id="youtube_url_edit" name="youtube_url_edit" value="" type="text"/>
                </div>
                <div style="clear: both"></div>
                <div class="descript"><?php echo __('We are support single youtube url format: <br/> - https://www.youtube.com/watch?v=nlXbu32mXzI'); ?></div>
            </div>
        </div>
        <div class="get-from-wrap vimeo" style="display: none;">
            <div class="header-title"><?php echo __('EDIT VIDEO', 'inwavethemes'); ?></div>
            <div class="control-group">
                <div class="label"><?php echo __('Vimeo URL', 'inwavethemes'); ?></div>
                <div class="control">
                    <input id="vimeo_url_edit" name="vimeo_url_edit" value="" type="text"/>
                </div>
                <div style="clear: both"></div>
                <div class="descript"><?php echo __('We are support a single video: <br/> - https://vimeo.com/56974406'); ?></div>
            </div>
        </div>
        <div class="get-from-wrap embedcode" style="display: none;">
            <div class="header-title"><?php echo __('EDIT VIDEO', 'inwavethemes'); ?></div>
            <div class="control-group">
                <div class="label"><?php echo __('Embed code', 'inwavethemes'); ?></div>
                <div class="control">
                    <textarea id="video_embedcode_edit" name="video_embedcode_edit"></textarea>
                </div>
                <div style="clear: both"></div>
            </div>
        </div>
        <div class="get-from-wrap upload" style="display: none;">
            <div class="header-title"><?php echo __('EDIT VIDEO', 'inwavethemes'); ?></div>
            <div class="control-group">
                <div class="label"><?php echo __('Video URL', 'inwavethemes'); ?></div>
                <div class="control">
                    <input id="video_upload_edit" name="video_upload_edit" type="text"/>
                </div>
                <div style="clear: both"></div>
            </div>
        </div>
        <div class="get-from-wrap image-edit" style="display: none;">
            <div class="header-title"><?php echo __('EDIT IMAGE', 'inwavethemes'); ?></div>
            <div class="control-group">
                <div class="label"><?php echo __('Image URL', 'inwavethemes'); ?></div>
                <div class="control">
                    <input id="image_new_url" name="image_url" type="text"/>
                </div>
                <div style="clear: both"></div>
            </div>
        </div>
        <div class="create-slideshow">
            <span class="button blue edit-update-item"><?php echo __('OK', 'inwavethemes'); ?></span>
        </div>
    </div>
</div>