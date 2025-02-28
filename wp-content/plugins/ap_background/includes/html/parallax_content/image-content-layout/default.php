<?php
/**
 * Front end: layout display for type image gallery
 *
 * @author gmswebdesign
 * @package AP Background
 * @version 1.0.0
 */
?>

<?php
list($thumb_width, $thumb_height, $row_number) = array($item->settings->layout_setting->thumb_width, $item->settings->layout_setting->thumb_height, $item->settings->layout_setting->rows);
$cols = ceil(count($media_items) / $row_number);
$item_index = 0;
?>
<?php for ($i = 0; $i < $cols; $i++): ?>
    <div class="parallax-col">
        <?php
        for ($j = 0; $j < $row_number; $j++):
            $media_item = $media_items[$item_index];
            if ($media_item) {
                $bt_utility->checkMediaItem($item->id, $media_item);
                list($width, $height) = getimagesize(ABSPATH . '/wp-content/uploads/ap_background/thumb/' . $item->id . '/' . $media_item->thumbnail);
                if ($width > $height) {
                    $attr = 'style="width:100%"';
                } else {
                    $attr = 'style="height:100%"';
                }
                echo '<div class="parallax-row in-pos" ' . (($j > 0) ? 'style="margin-top:' . $item->settings->layout_setting->spacing . 'px;"' : '') . '>';
                echo '<div class="thumb" style="width:' . $thumb_width . 'px; height:' . $thumb_height . 'px;"><img ' . $attr . ' src="' . site_url() . '/wp-content/uploads/ap_background/thumb/' . $item->id . '/' . $media_item->thumbnail . '" alt="' . __('Image thumbnail') . '"/></div>';
                echo '<div class="show_box hidden"><img class="image-show" src="' . (($media_item->media_source == 'image_upload') ? site_url() . $media_item->large : $media_item->large) . '"  alt="' . __('Image large view') . '"/></div>';
                echo '</div>';
                $item_index++;
            }
        endfor;
        ?>
    </div>
<?php
endfor;
