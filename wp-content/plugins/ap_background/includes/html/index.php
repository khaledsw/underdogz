<?php
/**
 * List AP Background item's layout.
 *
 * @author gmswebdesign
 * @package AP Background
 * @version 1.0.0
 */
?>

<div class="bt-parallax-wrap">
    <div class="header">
        <div class="title">
            <?php echo __('Advanced Parallax Background', 'gmswebdesign'); ?>
        </div>
        <div class="helper">
            <span class="button blue download-link" title="<?php echo __('Find new update', 'gmswebdesign'); ?>"><i class="fa fa-cloud-download"></i></span>
            <span class="button blue helper-link" title="<?php echo __('Find help', 'gmswebdesign'); ?>"><i class="fa fa-question"></i></span>
        </div>
        <div class="clear"></div>
    </div>
    <?php
    if (isset($_SESSION['bt_message'])) {
        echo $_SESSION['bt_message'];
        unset($_SESSION['bt_message']);
    }
    ?>
    <div class="control-buttons">
        <div class="create-button">
            <span class="button blue"><i class="fa fa-plus"></i> <?php echo __('CREATE NEW', 'gmswebdesign'); ?></span>
        </div>
        <div class="delete-button">
            <span class="button red delete-items-list"><i class="fa fa-times"></i> <?php echo __('DELETE', 'gmswebdesign'); ?></span>
        </div>
        <div style="position: relative; float: left;"><span class="bt-ajax-loading list-item-ajax-delete-select"><i class="fa fa-spinner fa-spin fa-2x"></i></span></div>
    </div>
    <div class="clear"></div>
    <div class="list-item">
        <div class="header">
            <div scope="col" id="cb" class="column manage-column column-cb check-column" style="">
                <label class="screen-reader-text" for="cb-select-all-1"><?php __('Select All', 'gmswebdesign'); ?></label>
                <input id="cb-select-all-1" type="checkbox">
            </div>
            <div scope="col" class="column manage-column column-id" style=""><?php echo __('ID', 'gmswebdesign'); ?></div>
            <div scope="col" class="column manage-column column-title" style=""><?php echo __('Name', 'gmswebdesign'); ?></div>
            <div scope="col" class="column manage-column column-short-code" style=""><?php echo __('Short Code', 'gmswebdesign'); ?></div>
            <div scope="col" class="column manage-column column-type" style=""><?php echo __('Type'); ?></div>
            <div scope="col" class="column manage-column column-last-modify" style="">
                <span><?php echo __('Last Modify', 'gmswebdesign'); ?></span>
            </div>
            <div scope="col" class="column manage-column column-published" style="">
                <span><?php echo __('Published', 'gmswebdesign'); ?></span>
            </div>	
            <div scope="col" class="column manage-column column-action" style="">
                <span><?php echo __('Action', 'gmswebdesign'); ?></span>
            </div>
            <div class="clear"></div>
        </div>
        <?php
        global $wpdb;
        $items = $wpdb->get_results('SELECT id, name, alias, settings, modified, status FROM ' . $wpdb->prefix . 'ap_background');
        if (!empty($items)):
            foreach ($items as $item):
                $itemSettings = json_decode($item->settings);
                $item_type = '';
                switch ($itemSettings->content_type) {
                    case 'image-gallery':
                        $item_type = 'Image Gallery';
                        break;
                    case 'video-background':
                        $item_type = 'Video Background';
                        break;
                    case 'woo-commerce':
                        $item_type = 'Woo Commerce';
                        break;
                    default:
                        $item_type = 'Wordpress Posts';
                        break;
                }
                ?>
                <div class="item">
                    <div class="row row-checkbox" style="">
                        <input type="checkbox" name="fields[]" value="<?php echo $item->id; ?>"/>
                    </div>
                    <div scope="row" class="row row-id" style=""><?php echo $item->id; ?></div>
                    <div scope="row" class="row row-title" style="">
                        <a href="<?php echo admin_url('admin.php?page=bt-advance-parallax-background/create-new&content_type=' . $itemSettings->content_type . '&id=' . $item->id); ?>">
                            <?php echo $item->name; ?>
                        </a>
                    </div>
                    <div scope="row" class="row row-short-code" style=""><?php echo '[adv_parallax_back alias=' . $item->alias . ']'; ?></div>
                    <div scope="row" class="row row-type" style=""><?php echo $item_type; ?></div>
                    <div scope="row" class="row row-last-modify" style="">
                        <span><?php echo date('m/d/Y', $item->modified); ?></span>
                    </div>
                    <div scope="row" class="row row-published" style="">
                        <span><?php echo ($item->status == 1) ? 'Yes' : 'No'; ?></span>
                    </div>	
                    <div scope="row" class="row row-action" style="">
                        <a href="<?php echo admin_url('admin.php?page=bt-advance-parallax-background/create-new&content_type=' . $itemSettings->content_type . '&id=' . $item->id); ?>">
                            <span class="button green" title="<?php echo __('Edit', 'gmswebdesign'); ?>"><i class="fa fa-pencil"></i></span>
                        </a>
                        <span class="button red delete" title="<?php echo __('Delete', 'gmswebdesign'); ?>"><i class="fa fa-times"></i></span>
                        <span class="button blue copy" title="<?php echo __('Copy', 'gmswebdesign'); ?>"><i class="fa fa-copy"></i></span>
                        <span class="button original preview" title="<?php echo __('Preview', 'gmswebdesign'); ?>"><i class="fa fa-desktop"></i></span>
                        <span class="bt-ajax-loading list-item-ajax"><i class="fa fa-circle-o-notch fa-spin"></i></span>
                    </div>
                    <div class="clear"></div>
                </div>
                <?php
            endforeach;
        else:
            ?>
            <?php echo __('No slider created', 'gmswebdesign'); ?>
        <?php endif; ?>
    </div>
    <div class="control-buttons">
        <div class="create-button">
            <span class="button blue"><i class="fa fa-plus"></i> <?php echo __('CREATE NEW', 'gmswebdesign'); ?></span>
        </div>
        <div class="delete-button">
            <span class="button red delete-items-list"><i class="fa fa-times"></i> <?php echo __('DELETE', 'gmswebdesign'); ?></span>
        </div>
        <div style="position: relative; float: left;"><span class="bt-ajax-loading list-item-ajax-delete-select"><i class="fa fa-spinner fa-spin fa-2x"></i></span></div>
    </div>
</div>
<div class="bt-parallax-select-slide-type hidden">
    <div class="bg-type-list-wrap">
        <div class="header-title"><?php echo __('BACKGROUND CONTENT TYPES', 'gmswebdesign'); ?></div>
        <div class="bg-content-type-list">
            <div class="content-type-item selected video-background">
                <div class="item-image">
                    <span class="item-selected" style="display:none;"><i class="fa fa-check"></i></span>
                    <span class="item-icon"><i class="fa fa-play-circle-o fa-4x"></i></span>
                </div>
                <div class="item-title"><span><?php echo __('VIDEO BACKGROUND', 'gmswebdesign'); ?></span></div>
            </div>
            <div class="content-type-item image-gallery end-row">
                <div class="item-image">
                    <span class="item-selected" style="display:none;"><i class="fa fa-check"></i></span>
                    <span class="item-icon"><i class="fa fa-picture-o fa-4x"></i></span>
                </div>
                <div class="item-title"><span><?php echo __('IMAGE GALLERY', 'gmswebdesign'); ?></span></div>
            </div>
            <div class="content-type-item woo-commerce">
                <div class="item-image">
                    <span class="item-selected" style="display:none;"><i class="fa fa-check"></i></span>
                    <span class="item-icon"><i class="fa fa-shopping-cart fa-4x"></i></span>
                </div>
                <div class="item-title"><span><?php echo __('WOO COMMERCE', 'gmswebdesign'); ?></span></div>
            </div>
            <div class="content-type-item wordpress-posts end-row">
                <div class="item-image">
                    <span class="item-selected" style="display:none;"><i class="fa fa-check"></i></span>
                    <span class="item-icon"><i class="fa fa-wordpress fa-4x"></i></span>
                </div>
                <div class="item-title"><span><?php echo __('WORDPRESS POSTS', 'gmswebdesign'); ?></span></div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="create-slideshow">
            <a href="<?php echo admin_url('admin.php?page=bt-advance-parallax-background/create-new&content_type=video-background'); ?>"><span class="button blue"><?php echo __('CREATE NEW SLIDESHOW', 'gmswebdesign'); ?></span></a>
        </div>
    </div>
</div>
<div id="btp-item-preview" class="hidden">
    <div class="preview-close">
        <span class="button btn-none" title="<?php echo __('Close', 'gmswebdesign'); ?>"><i class="fa fa-times"></i></span>
    </div>
    <div class="overlay-loading"><span class="loading"><img src="<?php echo plugins_url() . "/ap_background/assets/images/loading-black.gif"; ?>"  alt="<?php echo __('Loading...');?>"/></span></div>
    <div class="preview-content">
        <div class="preview-content-in"></div>
    </div>

</div>