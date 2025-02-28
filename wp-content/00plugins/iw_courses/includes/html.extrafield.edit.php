<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include_once 'utility.php';
$utility = new iwcUtility();
if (isset($_SESSION['bt_message'])) {
    echo $_SESSION['bt_message'];
    unset($_SESSION['bt_message']);
}

$id = $_GET['id'];
if ($id) {
    global $wpdb;
    $extrafield = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'iw_courses_extrafields where id =%d', $id));
    $_SESSION['extrafield']['name'] = htmlentities(stripslashes($extrafield->name));
    $_SESSION['extrafield']['fieldtype'] = $extrafield->type;
    $_SESSION['extrafield']['description'] = htmlentities(stripslashes($extrafield->description));
    $_SESSION['extrafield']['staus'] = $extrafield->status;
    if ($extrafield->type == 'textarea') {
        $_SESSION['extrafield']['text_value'] = htmlentities(stripslashes($extrafield->default_value));
    }

    $categories = $wpdb->get_results($wpdb->prepare('SELECT a.category_id FROM ' . $wpdb->prefix . 'iw_courses_extrafields_category as a where a.extrafields_id =%d', $id));
    $cats = array();
    foreach ($categories as $value) {
        $cats[] = $value->category_id;
    }
    $_SESSION['extrafield']['categories'] = $cats;
    if ($extrafield->type == 'link') {
        $link_data = unserialize($extrafield->default_value);
        $_SESSION['extrafield']['link_value_text'] = htmlentities(stripslashes($link_data['link_value_text']));
        $_SESSION['extrafield']['link_value_link'] = htmlentities(stripslashes($link_data['link_value_link']));
        $_SESSION['extrafield']['link_value_target'] = $link_data['link_value_target'];
    }
    if ($extrafield->type == 'measurement') {
        $measurement_data = unserialize($extrafield->default_value);
        $_SESSION['extrafield']['measurement_value'] = htmlentities(stripslashes($measurement_data['measurement_value']));
        $_SESSION['extrafield']['measurement_unit'] = htmlentities(stripslashes($measurement_data['measurement_unit']));
    }
    if ($extrafield->type == 'image') {
        $_SESSION['extrafield']['image_text'] = $extrafield->default_value;
    }
    if ($extrafield->type == 'text') {
        $_SESSION['extrafield']['string_value'] = htmlentities(stripslashes($extrafield->default_value));
    }
    if ($extrafield->type == 'dropdown_list') {
        $drop_value = unserialize($extrafield->default_value);
        $_SESSION['extrafield']['drop_value'] = htmlentities(stripslashes($drop_value[0]));
        $_SESSION['extrafield']['drop_multiselect'] = $drop_value[1];
    }
    if ($extrafield->type == 'date') {
        $_SESSION['extrafield']['date_value'] = $extrafield->default_value;
    }
} else {
    unset($_SESSION['extrafield']);
}
?>

<form action="<?php echo admin_url(); ?>admin-post.php" method="post">
    <div class="wrap">
        <?php if ($id): ?>
            <h2 class="bt-title header-text"><?php echo __('Edit Extrafield'); ?>
                <a class="bt-button add-new-h2" href ="<?php echo admin_url('edit.php?post_type=iw_courses&page=add-extra-field'); ?>"><?php echo __("Add New Other"); ?></a>
            </h2>
        <?php else: ?>
            <h3 class="header-text"><?php echo __("Add new Extrafield"); ?></h3>
        <?php endif; ?>
        <div class="control-group">
            <div class="label"><?php echo __('Title'); ?></div>
            <div class="control">
                <input name="title"  type="text" value="<?php echo ($_SESSION['extrafield']['name']) ? $_SESSION['extrafield']['name'] : ''; ?>" />
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Categories'); ?></div>
            <div class="control">
                <?php echo $utility->categoryField($_SESSION['extrafield']['categories']); ?>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Type'); ?></div>
            <div class="control">
                <?php
                $data = array(
                    array('value' => 'textarea', 'text' => __('Textarea')),
                    array('value' => 'link', 'text' => __('Link')),
                    array('value' => 'image', 'text' => __('Image')),
                    array('value' => 'measurement', 'text' => __('Measurement')),
                    array('value' => 'text', 'text' => __('Text')),
                    array('value' => 'dropdown_list', 'text' => __('Dropdown list')),
                    array('value' => 'date', 'text' => __('Date'))
                );
                echo $utility->selectFieldRender('field_type', 'field_type', $_SESSION['extrafield']['fieldtype'], $data, 'Select field type', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>

        <div class="control-group field-type field-textarea" style="display: none;">
            <div class="label"><?php echo __('Default value'); ?></div>
            <div class="control">
                <textarea placeholder="<?php echo __('Some Text value here'); ?>" cols="25" rows="4" name="text_value"><?php echo ($_SESSION['extrafield']['text_value']) ? htmlentities($_SESSION['extrafield']['text_value']) : ''; ?></textarea>
            </div>
            <div style="clear: both"></div>
        </div>

        <div class="control-group field-type field-link" style="display: none;">
            <div class="label"><?php echo __('Default value'); ?></div>
            <div class="control">
                <input placeholder="<?php echo __('URL'); ?>" name="link_value_link" value="<?php echo ($_SESSION['extrafield']['link_value_link']) ? $_SESSION['extrafield']['link_value_link'] : ''; ?>" type="text"/>
                <input placeholder="<?php echo __('Text'); ?>" name="link_value_text" value="<?php echo ($_SESSION['extrafield']['link_value_text']) ? $_SESSION['extrafield']['link_value_text'] : ''; ?>" type="text"/>
                <?php
                $datas = array(
                    array('value' => '_blank', 'text' => 'Blank'),
                    array('value' => '_self', 'text' => 'Self')
                );
                echo $utility->selectFieldRender('link_value_target', 'link_value_target', $_SESSION['extrafield']['link_value_target'], $datas, 'Select Target', '', false);
                ?>
            </div>
            <div style="clear: both"></div>
        </div>

        <div class="control-group field-type field-measurement" style="display: none;">
            <div class="label"><?php echo __('Default value'); ?></div>
            <div class="control">
                <input placeholder="<?php echo __('Value'); ?>" name="measurement_value" value="<?php echo ($_SESSION['extrafield']['measurement_value']) ? $_SESSION['extrafield']['measurement_value'] : ''; ?>" type="text"/>
                <input placeholder="<?php echo __('Unit'); ?>" name="measurement_unit" value="<?php echo ($_SESSION['extrafield']['measurement_unit']) ? $_SESSION['extrafield']['measurement_unit'] : ''; ?>" type="text"/>
                <br/><span class="description"><?php echo __('Enter unit. Example: $, Kg, m2'); ?></span>
            </div>
            <div style="clear: both"></div>
        </div>

        <div class="control-group field-type field-text" style="display: none;">
            <div class="label"><?php echo __('Default value'); ?></div>
            <div class="control">
                <input placeholder="<?php echo __('Text value'); ?>" name="string_value"  value="<?php echo ($_SESSION['extrafield']['string_value']) ? $_SESSION['extrafield']['string_value'] : ''; ?>" type="text"/>
            </div>
            <div style="clear: both"></div>
        </div>

        <div class="control-group field-type field-dropdown_list" style="display: none;">
            <div class="label"><?php echo __('Default value'); ?></div>
            <div class="control">
                <textarea placeholder="<?php echo __('VALUE|TEXT|1'); ?>" cols="25" rows="4" name="drop_value"><?php echo ($_SESSION['extrafield']['drop_value']) ? $_SESSION['extrafield']['drop_value'] : ''; ?></textarea>
                <br/><span class="description"><?php echo __('Multiple options are separated by newline with syntax: Value|Text|Selected(1 or 0). Example:<br />VALUE_1|TEXT_1|1<br />VALUE_2|TEXT_2|0<br />VALUE_3|TEXT_3|1'); ?></span><br/>
                <br/><input type="checkbox" style="min-width: initial!important;" value="1" <?php echo ($_SESSION['extrafield']['drop_multiselect'] == 1) ? 'checked="checked"' : ""; ?> name="drop_multiselect"/> Multiple selected
            </div>
            <div style="clear: both"></div>
        </div>

        <div class="control-group field-type field-image" style="display: none;">
            <div class="label"><?php echo __('Default value'); ?></div>
            <div class="control">
                <script>
                    jQuery(function ($) {
                        var frame;

                        $('#field-image-button').on('click', function (e) {
                            e.preventDefault();

                            // Set options
                            var options = {
                                state: 'insert',
                                frame: 'post'
                            };

                            frame = wp.media(options).open();

                            // Tweak views
                            frame.menu.get('view').unset('gallery');
                            frame.menu.get('view').unset('featured-image');

                            frame.toolbar.get('view').set({
                                insert: {
                                    style: 'primary',
                                    text: '<?php _e('Insert', 'inwavethemes'); ?>',
                                    click: function () {
                                        var models = frame.state().get('selection'),
                                                url = models.first().attributes.url;

                                        $('#field-image-link').val(url);

                                        frame.close();
                                    }
                                } // end insert
                            });
                        });
                    });
                </script>
                <input placeholder="<?php echo __('Image URL'); ?>" id='field-image-link' name="image_text" value="<?php echo ($_SESSION['extrafield']['image_text']) ? htmlentities($_SESSION['extrafield']['image_text']) : ''; ?>" type="text"/>
                <input type='button' class='button' name='field-image-button' id='field-image-button' value='Browse' />
            </div>
            <div style="clear: both"></div>
        </div>

        <div class="control-group field-type field-date" style="display: none;">
            <div class="label"><?php echo __('Default value'); ?></div>
            <div class="control">
                <input name="date_value" value="<?php echo ($_SESSION['extrafield']['date_value']) ? htmlentities($_SESSION['extrafield']['date_value']) : ''; ?>" type="text"/>
            </div>
            <div style="clear: both"></div>
        </div>

        <div class="control-group">
            <div class="label"><?php echo __('Description'); ?></div>
            <div class="control">
                <textarea cols="25" rows="4" name="description"><?php echo ($_SESSION['extrafield']['description']) ? htmlentities($_SESSION['extrafield']['description']) : ''; ?></textarea>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label"><?php echo __('Status'); ?></div>
            <div class="control">
                <select name="status">
                    <option <?php echo ($_SESSION['extrafield']['status'] == '1') ? 'selected = "selected"' : ''; ?> value="1"><?php echo __('Published'); ?></option>
                    <option <?php echo ($_SESSION['extrafield']['status'] == '0') ? 'selected = "selected"' : ''; ?> value="0"><?php echo __('Unpublished'); ?></option>
                </select>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="control-group">
            <div class="label">&nbsp;</div>
            <div class="control">
                <?php if ($id): ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                <?php endif; ?>
                <input type="hidden" name="action" value="iw_courses_extrafield">
                <input type="submit" style="min-width: initial;" value="<?php echo __("Save"); ?>"/>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>
</form>

<script tpe="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#field_type').change(function () {
            var select = jQuery(this).val();
            jQuery('.field-type').hide();
            jQuery('.field-' + select).show();
        }).trigger('change');

        jQuery('input[name="date_value"]').datepicker({
            dateFormat: 'dd-mm-yy'
        });

    });
</script>