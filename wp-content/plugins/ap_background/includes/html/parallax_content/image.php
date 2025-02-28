<?php
/**
 * Front end: Parallax view kieu image
 *
 * @author gmswebdesign
 * @package AP Background
 * @version 1.0.0
 */


$media_items = $item->settings->media_source->items;
?>

<div class="<?php echo $item->settings->layout_setting->layout; ?> layout">
    <?php include_once 'image-content-layout/' . $item->settings->layout_setting->layout . '.php'; ?>
</div>
