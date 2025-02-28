<?php
/**
 * Page create new parallax type video.
 *
 * @author Inwavethemes
 * @package AP Background
 * @version 1.0.0
 */
?>

<!--Image source-->
<div class="group-content">
    <h2 class="title"><?php echo __('Video Sources', 'inwavethemes'); ?></h2>
    <div class="content">
        <div class="item-source from-media">
            <span class="icon"><i class="fa fa-plus fa-3x"></i></span>
        </div>
        <div class="item-source from-youtube">
            <span class="icon"><i class="fa fa-youtube-square fa-3x"></i></span>
        </div>
        <div class="item-source from-vimeo">
            <span class="icon"><i class="fa fa-vimeo-square fa-3x"></i></span>
        </div>
        <div class="item-source from-embed-code">
            <span class="icon"><i class="fa fa-xing-square fa-3x"></i></span>
        </div>
        <div style="clear: both"></div>
    </div>
</div>

<!--Image list items-->
<div class="group-content video">
    <h2 class="title"><?php echo __('Video Gallery', 'inwavethemes'); ?><span class="bt-ajax-loading add-item-ajax"><i class="fa fa-circle-o-notch fa-spin"></i></span></h2>
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
                        <?php if ($media_item->large): ?>
                            <img width="130" src="<?php echo $media_item->large; ?>"  alt="<?php echo __('Thumbnail image');?>"/>
                        <?php else: ?>
                            <div class="thumb-img"><span><i class="fa fa-file-video-o fa-3x"></i></span></div>
                        <?php endif; ?>
                            <input type="hidden" name="settings[media_source][items][]" value="<?php echo htmlspecialchars(stripslashes(json_encode($media_item))); ?>">
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div style="clear: both"></div>
        <div class="control-buttons">
            <div class="create-list-button">
                <span class="button blue delete-selected"><i class="fa fa-times"></i> <?php echo __('DELETE SELECTED', 'inwavethemes'); ?></span>
            </div>
            <div class="delete-list-button">
                <span class="button red delete-all"><i class="fa fa-times"></i> <?php echo __('DELETE ALL', 'inwavethemes'); ?></span>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>
    <input type="hidden" id="ap_background_google_api" name="ap_background_google_api" value="<?php echo get_option('ap_background_google_api'); ?>"/>
</div>


<div class="bt-parallax-get-media-item hidden">
    <div class="bg-type-list-wrap">
        <div class="get-from-wrap youtube" style="display: none;">
            <div class="header-title"><?php echo __('GET VIDEO FROM YOUTUBE', 'inwavethemes'); ?></div>
            <div class="control-group">
                <div class="label"><?php echo __('Google API', 'inwavethemes'); ?></div>
                <div class="control">
                    <input id="media_source_google_api" name="media_source_google_api" value="<?php echo get_option('ap_background_google_api'); ?>" type="text"/>
                </div>
                <div style="clear: both"></div>
            </div>
            <div class="control-group">
                <div class="label"><?php echo __('Youtube URL', 'inwavethemes'); ?></div>
                <div class="control">
                    <input id="youtube_url" name="youtube_url" value="" type="text"/>
                </div>
                <div style="clear: both"></div>
                <div class="descript"><?php echo __('We are support three youtube url format: <br/> - Single video: https://www.youtube.com/watch?v=nlXbu32mXzI<br/> - Playlist: https://www.youtube.com/playlist?list=PLswJ5Pgi5hDezucQ3I64dWTbwai2XC1I_ <br/>(Require Google API)<br/> - Channel: https://www.youtube.com/channel/UCDQeIiQSdMFKAntX-1HY9mA <br/>(Require Google API)'); ?></div>
            </div>
        </div>
        <div class="get-from-wrap vimeo" style="display: none;">
            <div class="header-title"><?php echo __('GET VIDEO FROM VIMEO', 'inwavethemes'); ?></div>
            <div class="control-group">
                <div class="label"><?php echo __('Vimeo URL', 'inwavethemes'); ?></div>
                <div class="control">
                    <input id="vimeo_url" name="vimeo_url" value="" type="text"/>
                </div>
                <div style="clear: both"></div>
                <div class="descript"><?php echo __('We are support three vimeo url format: <br/> - Single video: https://vimeo.com/56974406<br/> - Album: https://vimeo.com/album/2210627<br/> - User: https://vimeo.com/user15700123'); ?></div>
            </div>
        </div>
        <div class="get-from-wrap embedcode" style="display: none;">
            <div class="header-title"><?php echo __('GET VIDEO WITH EMBED CODE', 'inwavethemes'); ?></div>
            <div class="control-group">
                <div class="label"><?php echo __('Embed code', 'inwavethemes'); ?></div>
                <div class="control">
                    <textarea id="video_embedcode" name="video_embedcode"></textarea>
                </div>
                <div style="clear: both"></div>
            </div>
        </div>
        <div class="create-slideshow">
            <span class="button blue get-video"><?php echo __('GET VIDEO', 'inwavethemes'); ?></span>
        </div>
    </div>
</div>
 <script>
jQuery(function() {
jQuery( "#list-items" ).sortable();
jQuery( "#list-items" ).disableSelection();
});
</script>
