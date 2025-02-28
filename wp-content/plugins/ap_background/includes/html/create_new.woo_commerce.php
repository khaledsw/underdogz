<?php
/**
 * Page create new parallax type woocommerce product.
 *
 * @author gmswebdesign
 * @package AP Background
 * @version 1.0.0
 */
?>

<!--WP Post setting-->
<div class="group-content">
    <h2 class="title"><?php echo __('Woo Commerce Setting', 'gmswebdesign'); ?></h2>
    <div class="content">
        <div class="control-group">
            <div class="label"><?php echo __('Widget title', 'gmswebdesign'); ?></div>
            <div class="control">
                <input type="text" name="settings[content_source][title]" value="<?php echo ($item->settings->content_source->title) ? $item->settings->content_source->title : ''; ?>"/>
                <span class="descript"><?php echo __('What text use as a widget title. Leave blank if no title is needed.', 'gmswebdesign'); ?></span>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Product categories', 'gmswebdesign'); ?></div>
            <div class="control">
                <?php
                $postCats = get_categories(array('type' => 'product', 'taxonomy' => 'product_cat'));
                $cats = array();
                if (!empty($postCats)) {
                    foreach ($postCats as $cat) {
                        $cats[] = array('value' => $cat->term_id, 'text' => $cat->name);
                    }
                } else {
                    $cats[] = array('value' => '', 'text' => __('No categories find'));
                }
                echo $bt_utility->selectFieldRender('content_source_categories', 'settings[content_source][categories]', $item->settings->content_source->categories, $cats, '', '', true);
                ?>
                <span class="descript"><?php echo __('Select product categories.', 'gmswebdesign'); ?></span>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Product IDs', 'gmswebdesign'); ?></div>
            <div class="control">
                <input type="text" name="settings[content_source][content_ids]" value="<?php echo ($item->settings->content_source->content_ids) ? $item->settings->content_source->content_ids : ''; ?>"/>
                <span class="descript"><?php echo __('Fill this field with pages IDs separated by commas (,) to retrieve only them.', 'gmswebdesign'); ?></span>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Exclude Products IDs', 'gmswebdesign'); ?></div>
            <div class="control">
                <input type="text" name="settings[content_source][content_ex_ids]" value="<?php echo ($item->settings->content_source->content_ex_ids) ? $item->settings->content_source->content_ex_ids : ''; ?>"/>
                <span class="descript"><?php echo __('Fill this field with products IDs separated by commas (,) to exclude them from query.', 'gmswebdesign'); ?></span>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Product types', 'gmswebdesign'); ?></div>
            <div class="control">
                <?php
                $posttype = array(
                    array('value' => 'none', 'text' => __('None', 'gmswebdesign')),
                    array('value' => 'nomal', 'text' => __('Nomal Product', 'gmswebdesign')),
                    array('value' => 'sale', 'text' => __('Sale Product', 'gmswebdesign')),
                    array('value' => 'featured', 'text' => __('Featured Product', 'gmswebdesign'))
                );
                echo $bt_utility->selectFieldRender('content_source_content_type', 'settings[content_source][product_content_type]', $item->settings->content_source->product_content_type, $posttype, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Order by', 'gmswebdesign'); ?></div>
            <div class="control">
                <?php
                $orderdata = array(
                    array('value' => 'menu_order', 'text' => __('Ordering', 'gmswebdesign')),
                    array('value' => 'title', 'text' => __('Title', 'gmswebdesign')),
                    array('value' => 'date', 'text' => __('Date', 'gmswebdesign')),
                    array('value' => 'popularity', 'text' => __('Popularity (sales)', 'gmswebdesign')),
                    array('value' => 'rate', 'text' => __('Rating', 'gmswebdesign')),
                    array('value' => 'price', 'text' => __('Price', 'gmswebdesign')),
                    array('value' => 'rand', 'text' => __('Random', 'gmswebdesign'))
                );
                if(get_option( 'woocommerce_enable_review_rating' ) === 'no'){
                    unset($orderdata[4]);
                }
                echo $bt_utility->selectFieldRender('content_source_content_settings_order', 'settings[content_source][content_settings][order]', $item->settings->content_source->content_settings->order, $orderdata, '', 'input-medium', false);
                ?>
                <span><?php echo __('Order way', 'gmswebdesign'); ?></span>
                <?php
                $orderwaydata = array(
                    array('value' => 'DESC', 'text' => __('DESC', 'gmswebdesign')),
                    array('value' => 'ASC', 'text' => __('ASC', 'gmswebdesign'))
                );
                echo $bt_utility->selectFieldRender('content_source_content_settings_order', 'settings[content_source][content_settings][direction]', $item->settings->content_source->content_settings->direction, $orderwaydata, '', 'input-medium', false);
                ?>
                <span><?php echo __('Limit', 'gmswebdesign'); ?></span>
                <input class="input-medium" type="text" value="<?php echo ($item->settings->content_source->content_settings->limit) ? $item->settings->content_source->content_settings->limit : '20'; ?>" name="settings[content_source][content_settings][limit]"/>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>
</div>

<!--Layout setting-->
<div class="group-content">
    <h2 class="title"><?php echo __('Layout Setting', 'gmswebdesign'); ?></h2>
    <div class="content">
        <div class="control-group">
            <div class="label" style="margin-bottom: 15px;"><?php echo __('Select our layout templates', 'gmswebdesign'); ?></div>
            <div class="layout-list">
                <?php
                $layout = $item->settings->content_source->content_settings->layout;
                ?>
                <div class="item-layout layout1<?php echo ($layout == 'layout1' || !$layout) ? ' selected' : ''; ?>" data-layout="layout1">
                    <span class="item-selected"><i class="fa fa-check"></i></span>
                </div>
                <div class="item-layout layout2<?php echo ($layout == 'layout2') ? ' selected' : ''; ?>" data-layout="layout2">
                    <span class="item-selected"><i class="fa fa-check"></i></span>
                </div>
                <input type="hidden" value="<?php echo ($layout) ? $layout : 'layout1'; ?>" name="settings[content_source][content_settings][layout]"/>
                <div style="clear: both"></div>
            </div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Item width', 'gmswebdesign'); ?></div>
            <div class="control">
                <input class="input-short" value="<?php echo ($item->settings->content_source->content_settings->item_width) ? $item->settings->content_source->content_settings->item_width : '250'; ?>" type="text" name="settings[content_source][content_settings][item_width]"/> px
                <span><?php echo __('Height', 'gmswebdesign'); ?></span>
                <input class="input-short" value="<?php echo ($item->settings->content_source->content_settings->item_height) ? $item->settings->content_source->content_settings->item_height : '300'; ?>" type="text" name="settings[content_source][content_settings][item_height]"/> px
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Number of row', 'gmswebdesign'); ?></div>
            <div class="control">
                <input class="input-short" type="text" value="<?php echo ($item->settings->content_source->content_settings->rows) ? $item->settings->content_source->content_settings->rows : '2'; ?>" name="settings[content_source][content_settings][rows]"/>
                <span><?php echo __('Spacing', 'gmswebdesign'); ?></span>
                <input class="input-short" value="<?php echo ($item->settings->content_source->content_settings->spacing) ? $item->settings->content_source->content_settings->spacing : '15'; ?>" type="text" name="settings[content_source][content_settings][spacing]"/> px
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Show image', 'gmswebdesign'); ?></div>
            <div class="control">
                <?php
                $show_imagedata = array(
                    array('value' => '1', 'text' => __('Yes', 'gmswebdesign')),
                    array('value' => '0', 'text' => __('No', 'gmswebdesign'))
                );
                echo $bt_utility->selectFieldRender('content_settings_show_image', 'settings[content_source][content_settings][show_image]', $item->settings->content_source->content_settings->show_image, $show_imagedata, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Show title', 'gmswebdesign'); ?></div>
            <div class="control">
                <?php
                $show_titledata = array(
                    array('value' => '1', 'text' => __('Yes', 'gmswebdesign')),
                    array('value' => '0', 'text' => __('No', 'gmswebdesign'))
                );
                echo $bt_utility->selectFieldRender('content_settings_show_title', 'settings[content_source][content_settings][show_title]', $item->settings->content_source->content_settings->show_title, $show_titledata, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Show product Infomation', 'gmswebdesign'); ?></div>
            <div class="control">
                <?php
                $show_infodata = array(
                    array('value' => '1', 'text' => __('Yes', 'gmswebdesign')),
                    array('value' => '0', 'text' => __('No', 'gmswebdesign'))
                );
                echo $bt_utility->selectFieldRender('content_settings_show_info', 'settings[content_source][content_settings][show_info]', $item->settings->content_source->content_settings->show_info, $show_infodata, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Show Product Description', 'gmswebdesign'); ?></div>
            <div class="control">
                <?php
                $show_desdata = array(
                    array('value' => '1', 'text' => __('Yes', 'gmswebdesign')),
                    array('value' => '0', 'text' => __('No', 'gmswebdesign'))
                );
                echo $bt_utility->selectFieldRender('content_settings_show_des', 'settings[content_source][content_settings][show_des]', $item->settings->content_source->content_settings->show_des, $show_desdata, '', 'input-medium', false);
                ?>
                <span><?php echo __('Number of word', 'gmswebdesign'); ?></span>
                <input class="input-short" value="<?php echo ($item->settings->content_source->content_settings->number_word) ? $item->settings->content_source->content_settings->number_word : '15'; ?>" type="text" name="settings[content_source][content_settings][number_word]"/>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Show Add to cart', 'gmswebdesign'); ?></div>
            <div class="control">
                <?php
                $show_moredata = array(
                    array('value' => '1', 'text' => __('Yes', 'gmswebdesign')),
                    array('value' => '0', 'text' => __('No', 'gmswebdesign'))
                );
                echo $bt_utility->selectFieldRender('content_settings_show_add_to_cart', 'settings[content_source][content_settings][add_to_cart]', $item->settings->content_source->content_settings->add_to_cart, $show_moredata, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Show Add to wishlist', 'gmswebdesign'); ?></div>
            <div class="control">
                <?php
                $show_wishlistdata = array(
                    array('value' => '1', 'text' => __('Yes', 'gmswebdesign')),
                    array('value' => '0', 'text' => __('No', 'gmswebdesign'))
                );
                echo $bt_utility->selectFieldRender('content_settings_show_add_to_wishlist', 'settings[content_source][content_settings][add_to_wishlist]', $item->settings->content_source->content_settings->add_to_wishlist, $show_wishlistdata, '', '', false);
                ?>
                <span class="descript"><?php echo __('This option only use when <strong>yith-woocommerce-wishlist</strong> installed.', 'gmswebdesign'); ?></span>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>
</div>

<!--Effect setting-->
<div class="group-content">
    <h2 class="title"><?php echo __('Effect setting', 'gmswebdesign'); ?></h2>
    <div class="content">
        <div class="label" style="margin-bottom: 15px;"><?php echo __('Select effect for product list', 'gmswebdesign'); ?></div>
        <div class="control-group">
            <div class="label"><?php echo __('Content appare', 'gmswebdesign'); ?></div>
            <div class="control">
                <?php
                $data = array(
                    array('value' => 'fade_left', 'text' => __('Fade from left', 'gmswebdesign')),
                    array('value' => 'fade_top', 'text' => __('Fade from top', 'gmswebdesign')),
                    array('value' => 'fade_right', 'text' => __('Fade from right', 'gmswebdesign')),
                    array('value' => 'fade_bottom', 'text' => __('Fade from bottom', 'gmswebdesign'))
                );
                echo $bt_utility->selectFieldRender('item_source_effect_settings_effect_in', 'settings[content_source][content_settings][effect_settings][effect_in]', $item->settings->content_source->content_settings->effect_settings->effect_in, $data, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Content disappare', 'gmswebdesign'); ?></div>
            <div class="control">
                <?php
                echo $bt_utility->selectFieldRender('item_source_effect_settings_effect_out', 'settings[content_source][content_settings][effect_settings][effect_out]', $item->settings->content_source->content_settings->effect_settings->effect_out, $data, '', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="label" style="margin-bottom: 15px;"><?php echo __('Custom content effect setting code', 'gmswebdesign'); ?></div>
        <div class="custom-effect">
            <textarea id="content_settings_effect_settings_custom_effect_code" name="settings[content_source][content_settings][effect_settings][custom_effect_code]"><?php echo ($item->settings->content_source->content_settings->effect_settings->custom_effect_code) ? $item->settings->content_source->content_settings->effect_settings->custom_effect_code : $bt_utility->loadContentEffectCss('out-fade_left','in-fade_left','item'); ?></textarea>
            <input type="hidden" value="woo_commerce" name="settings[content_source][content_type]"/>
        </div>
    </div>
</div>