<?php
/**
 * Front end: layout display for type image gallery
 *
 * @author Inwavethemes
 * @package AP Background
 * @version 1.0.0
 */
?>

<?php
list($width, $spacing) = array($item->settings->layout_setting->thumb_width, $item->settings->layout_setting->spacing);
$cols = ceil(count($media_items) / 10);

$item_index = 0;
?>
<?php for ($i = 0; $i < $cols; $i++): ?>
    <div class="parallax-col">
        <?php
        for ($j = 1; $j <= 10; $j++):
            $media_item = $media_items[$item_index];
            echo $bt_utility->flexibleItemRender($item, $media_item, $j);
            $item_index++;
        endfor;
        ?>
    </div>
    <?php
endfor;

