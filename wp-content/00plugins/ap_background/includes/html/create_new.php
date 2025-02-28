<?php
/**
 * Page create new parallax.
 *
 * @author Inwavethemes
 * @package AP Background
 * @version 1.0.0
 */

require_once ABSPATH . 'wp-content/plugins/ap_background/includes/utility.php';
$bt_utility = new btParallaxBackgroundUtility();
?>

<div class="bt-parallax-wrap">
    <form id="parallax-create" method="post" action="<?php echo admin_url(); ?>admin-post.php">
        <div class="header">
            <div class="title">
                <?php echo __('Advanced Parallax Background', 'inwavethemes'); ?>
            </div>
            <div class="helper">
                <span class="button blue helper-link" title="<?php echo __('Find help', 'inwavethemes'); ?>"><i class="fa fa-question"></i></span>
                <span class="button blue download-link" title="<?php echo __('Find new update', 'inwavethemes'); ?>"><i class="fa fa-cloud-download"></i></span>
            </div>
            <div class="clear"></div>
        </div>
        <?php
        if (isset($_SESSION['bt_message'])) {
            echo $_SESSION['bt_message'];
            unset($_SESSION['bt_message']);
        }
        if (isset($_GET['id'])) {
            global $wpdb;
            $itemQuery = $wpdb->get_results($wpdb->prepare('SELECT id, name, alias, content, settings, modified, status FROM ' . $wpdb->prefix . 'ap_background WHERE id=%d', $_GET['id']));
            if (!empty($itemQuery)) {
                $item = $itemQuery[0];
                $item->settings = json_decode($item->settings);
            } else {
                echo $bt_utility->getMessage(__('No item with id (' . $_GET['id'] . ') found. Please add new slider', 'inwavethemes'), 'notice');
            }
        }
        ?>
        <div class="create-new-wrap">
            <?php
            if (isset($_GET['content_type'])):
                $content_type = $_GET['content_type'];
                if (in_array($content_type, array('video-background', 'image-gallery', 'woo-commerce', 'wordpress-posts'))):
                    ?>
                    <div class="tabs">
                        <ul class="tab-links">
                            <li class="active"><a href="#parallax-slide"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;&nbsp;<?php echo __('PARALLAX SLIDER', 'inwavethemes'); ?></a></li>
                            <?php if ($content_type == 'image-gallery'): ?>
                                <li class="dynamic-tab <?php echo ($item->settings->parallax_bg_type && $item->settings->parallax_bg_type != 'dynamic' ) ? 'hidden' : ''; ?>"><a href="#images"><i class="fa fa-cog"></i>&nbsp;&nbsp;&nbsp;<?php echo __('IMAGE GALLERY SETTING', 'inwavethemes'); ?></a></li>
                            <?php endif; ?>
                            <?php if ($content_type == 'video-background'): ?>
                                <li class="dynamic-tab <?php echo ($item->settings->parallax_bg_type && $item->settings->parallax_bg_type != 'dynamic' ) ? 'hidden' : ''; ?>"><a href="#videos"><?php echo __('VIDEO SETTING', 'inwavethemes'); ?></a></li>
                            <?php endif; ?>
                            <?php if ($content_type == 'woo-commerce'): ?>
                                <li class="dynamic-tab <?php echo ($item->settings->parallax_bg_type && $item->settings->parallax_bg_type != 'dynamic' ) ? 'hidden' : ''; ?>"><a href="#woo-commerce"><?php echo __('WOO COMMERCE SETTING', 'inwavethemes'); ?></a></li>
                            <?php endif; ?>
                            <?php if ($content_type == 'wordpress-posts'): ?>
                                <li class="dynamic-tab <?php echo ($item->settings->parallax_bg_type && $item->settings->parallax_bg_type != 'dynamic' ) ? 'hidden' : ''; ?>"><a href="#wp-posts"><?php echo __('POST SETTING', 'inwavethemes'); ?></a></li>
                            <?php endif; ?>
                        </ul>

                        <div class="tab-content">
                            <div id="parallax-slide" class="tab active">
                                <?php include_once 'create_new.parallax_slide.php'; ?>
                            </div>
                            <?php if ($content_type == 'image-gallery'): ?>
                                <div id="images" class="tab">
                                    <?php include_once 'create_new.images.php'; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($content_type == 'video-background'): ?>
                                <div id="videos" class="tab">
                                    <?php include_once 'create_new.videos.php'; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($content_type == 'woo-commerce'): ?>
                                <div id="woo-commerce" class="tab">
                                    <?php include_once 'create_new.woo_commerce.php'; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($content_type == 'wordpress-posts'): ?>
                                <div id="wp-posts" class="tab">
                                    <?php include_once 'create_new.wp_post.php'; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <?php echo 'Please select content type correct'; ?>
                <?php endif; ?>
            <?php else: ?>
                <?php echo 'Please select content type'; ?>
            <?php endif; ?>
        </div>
        <?php if (isset($_GET['content_type']) && in_array($_GET['content_type'], array('video-background', 'image-gallery', 'woo-commerce', 'wordpress-posts'))): ?>
            <div class="control-buttons">
                <input type="hidden" name="settings[content_type]" value="<?php echo $_GET['content_type']; ?>"/>
                    <?php if (isset($_GET['id'])): ?>
                        <input type="hidden" name="edit_id" value="<?php echo $_GET['id']; ?>"/>
                    <?php endif; ?>
                <div class="create-button">
                    <input type="hidden" name="after_save" value=""/>
                    <input type="hidden" name="action" value="bt_advParallaxBackAdminSaveSlider"/>
                    <span class="button blue" onclick="javascript:document.getElementsByName('after_save')[0].value = '';document.forms['parallax-create'].submit();"><i class="fa fa-plus"></i> <?php echo __('SAVE SLIDESHOW', 'inwavethemes'); ?></span>
                    <span class="button blue" onclick="javascript:document.getElementsByName('after_save')[0].value = 'return'; document.forms['parallax-create'].submit();"><i class="fa fa-plus"></i> <?php echo __('SAVE & CLOSE', 'inwavethemes'); ?></span>
                    <span class="button red" onclick="javascript:window.location.href = btAdvParallaxBackgroundCfg.siteUrl + 'admin.php?page=bt-advance-parallax-background'"><i class="fa fa-times"></i> <?php echo __('CANCEL', 'inwavethemes'); ?></span>
                </div>
<!--                <div class="delete-button">
                </div>-->
            </div>
        <?php endif; ?>
    </form>
</div>