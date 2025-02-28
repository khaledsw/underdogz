<?php
/*
 * @package Courses Manager
 * @version 1.0.0
 * @created Mar 13, 2015
 * @author gmswebdesign
 * @email gmswebdesign@gmail.com
 * @website http://gmswebdesign.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 gmswebdesign. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of coursesBox
 *
 * @developer duongca
 */
class coursesBox {

    /**
     * Hook into the appropriate actions when the class is constructed.
     */
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_box'));
        add_action('save_post', array($this, 'save'));
    }

    /**
     * Adds the meta box container.
     */
    public function add_meta_box($post_type) {
        //var_dump($post_type);die;
        if ($post_type == 'iw_courses') {
            add_meta_box(
                    'course_image_gallery', __('Image Gallery', 'gmswebdesign'), array($this, 'render_meta_box_image_gallery'), $post_type, 'advanced', 'high'
            );
            add_meta_box(
                    'course_advance_relative', __('Advanced', 'gmswebdesign'), array($this, 'render_meta_box_advanced'), $post_type, 'advanced', 'high'
            );
            add_meta_box(
                    'course_extra_fields', __('Extra Fields', 'gmswebdesign'), array($this, 'render_meta_box_extra_fields'), $post_type, 'advanced', 'high'
            );
        }
    }

    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save($post_id) {

        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        /* @var $_POST type */
        if (!isset($_POST['iw_courses_post_metabox_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST['iw_courses_post_metabox_nonce'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'iw_courses_post_metabox')) {
            return $post_id;
        }

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // Check the user's permissions.
        $post_type = $_POST['post_type'];
        if ('page' == $post_type) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
        }


        /* OK, its safe for us to save the data now. */

        $iw_information = $_POST['iw_information'];
        $image_gallery = array();
        if ($iw_information['image_gallery']) {
            foreach ($iw_information['image_gallery'] as $value) {
                $image_gallery[] = str_replace(site_url(), '', $value);
            }
        }
        if ($iw_information['related_couses']) {
            $related_couses = $this->margeArray($iw_information['related_couses']);
        }

        // Update the meta field.
        update_post_meta($post_id, 'iw_courses_image_gallery', serialize($image_gallery));
        update_post_meta($post_id, 'iw_courses_related_couses', serialize($related_couses));
        update_post_meta($post_id, 'iw_courses_teacher', $iw_information['teacher']);


        global $wpdb;

// Update meta data
        $wpdb->delete($wpdb->prefix . "iw_courses_extrafields_value", array('courses_id' => $post_id));

        foreach ($iw_information['extrafield'] as $key => $val) {
            if (is_array($val)) {
                $val = serialize($val);
            }
            update_post_meta($post_id, $key, stripslashes(htmlspecialchars($val)));
            $ext_id = intval(substr($key, strrpos($key, '_') + 1));
            if ($ext_id) {
                $wpdb->insert($wpdb->prefix . "iw_courses_extrafields_value", array('courses_id' => $post_id, 'extrafields_id' => $ext_id, 'value' => stripslashes(htmlspecialchars($val))));
            }
        }
    }

    public function margeArray($array) {
        if (!is_array($array)) {
            return;
        }
        $key_title = $array['key_title'];
        $key_value = $array['key_value'];
        $new_array = array();
        $i = 0;
        foreach ($key_title as $value) {
            $new_array[] = array('key_title' => $value, 'key_value' => $key_value[$i]);
            $i++;
        }
        return $new_array;
    }

    public function render_meta_box_advanced($post) {
        global $wpdb;
        $utinity = new iwcUtility();
        ?>
        <div class="iwc-metabox-fields">
            <h3><?php echo __('Teacher: ', 'gmswebdesign'); ?></h3>
            <label for='teacher_relative'><strong><?php echo __('Teacher', 'gmswebdesign'); ?></strong></label>
            <?php
            $teacher_value = get_post_meta($post->ID, 'iw_courses_teacher', true);
            $teachers = $wpdb->get_results('SELECT ID, post_title FROM ' . $wpdb->prefix . 'posts WHERE post_status="publish" AND post_type="iw_teacher"');
            $data = array();
            if ($teachers) {
                foreach ($teachers as $teacher) {
                    $data[] = array('value' => $teacher->ID, 'text' => $teacher->post_title);
                }
            }
            echo $utinity->selectFieldRender('teacher_relative', 'iw_information[teacher]', $teacher_value, $data, 'Select Teacher', '', FALSE);
            ?>
            <h3><?php echo __('Related Courses: ', 'gmswebdesign'); ?></h3>
            <?php
            $courses_value = get_post_meta($post->ID, 'iw_courses_related_couses', true);
            $courses = unserialize($courses_value);
            ?>
            <table class="list-table">
                <thead>
                    <tr>
                        <th class="left"><?php echo __('ID', 'gmswebdesign'); ?></th>
                        <th><?php echo __('Title', 'gmswebdesign'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="the-list">
                    <?php
                    if ($courses):
                        foreach ($courses as $v):
                            ?>
                            <tr class="alternate">
                                <td>
                                    <label class="related_couses_id"><?php echo $v['key_value']; ?></label>
                                    <input class="related_couses_id" type="hidden" value="<?php echo htmlspecialchars($v['key_value']); ?>" size="20" name="iw_information[related_couses][key_value][]"/>
                                </td>
                                <td>
                                    <label class="related_couses_title"><?php echo $v['key_title']; ?></label>
                                    <input type="hidden" value="<?php echo htmlspecialchars($v['key_title']); ?>" size="20" name="iw_information[related_couses][key_title][]"/>
                                </td>
                                <td>
                                    <span class="button remove-button"><?php echo __('Remove', 'gmswebdesign'); ?></span>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                    ?>
                    <tr>
                        <td colspan="2" style="position: relative;">
                            <input type="text" placeholder="<?php echo __('Search Courses'); ?>" class="auto-load-post"/>
                            <span class="iw-ajax-loading"></span>
                            <div class="iw-courses-list" style="display: none;"></div>
                        </td>
                        <td>
                            <span style="width: 100%;" class="button add-row courses-related"><?php echo __('Add Courses', 'gmswebdesign'); ?></span
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function render_meta_box_image_gallery($post) {
        $value = get_post_meta($post->ID, 'iw_courses_image_gallery', true);
        $image_gallery = unserialize($value);
        // Add an nonce field so we can check for it later.
        wp_nonce_field('iw_courses_post_metabox', 'iw_courses_post_metabox_nonce');
        ?>
        <div class="iwc-metabox-fields">
            <div class="list-image-gallery">
                <?php
                if ($image_gallery):
                    foreach ($image_gallery as $item) :
                        ?>
                        <div class="iw-image-item">
                            <div class="action-overlay">
                                <span class="remove-image">x</span>
                            </div>
                            <img width="150" src="<?php echo site_url() . $item; ?>"/>
                            <input type="hidden" name="iw_information[image_gallery][]" value="<?php echo htmlspecialchars($item); ?>"/>
                        </div>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
            <div style="clear: both;"></div>
            <div class="button-add-image">
                <span class="button add-new-image"><?php echo __('Add new images', 'gmswebdesign'); ?></span>
            </div>
        </div>
        <?php
    }

    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_extra_fields($post) {


        global $wpdb;
        /* Create a settings metabox ----------------------------------------------------- */
        $fields = array();
        $categories = array('0');
        $cats = $wpdb->get_results($wpdb->prepare('SELECT a.term_taxonomy_id as category_id FROM ' . $wpdb->prefix . 'term_relationships as a where a.object_id =%d', $post->ID));
        if (!empty($cats)) {
            foreach ($cats as $cat) {
                $categories[] = $cat->category_id;
            }
        }
        $extfields = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'iw_courses_extrafields as a inner join ' . $wpdb->prefix . 'iw_courses_extrafields_category as b on a.id = b.extrafields_id WHERE b.category_id IN(' . implode(',', wp_parse_id_list($categories)) . ') group by a.id');
        if (!empty($extfields)) {
            foreach ($extfields as $extrafield) {
                $data = array(
                    'name' => __(stripslashes($extrafield->name), 'gmswebdesign'),
                    'desc' => __(stripslashes($extrafield->description), 'gmswebdesign'),
                    'id' => '_iw_courses_' . $extrafield->id,
                    'type' => $extrafield->type,
                    'title' => __(htmlentities(stripslashes($extrafield->name)), 'gmswebdesign'),
                    'std' => $extrafield->default_value
                );
                array_push($fields, $data);
            }
        }
        $this->metaBoxHtmlRender($post, $fields);
    }

    /**
     * Print HTML content of a meta box.
     *
     * @since 1.0.0
     * @param object $post The post
     * @param array $meta_box Meta box data
     */
    function metaBoxHtmlRender($post, $fields) {
        if (!is_array($fields)) {
            return false;
        }
        $utility = new iwcUtility();
        if (!empty($fields)):
            ?>
            <div class="iwc-metabox-fields">
                <table class="list-table">
                    <thead>
                        <tr>
                            <th class="left"><?php echo __('Field Name', 'gmswebdesign'); ?></th>
                            <th><?php echo __('Value', 'gmswebdesign'); ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="the-list">
                        <?php
                        foreach ($fields as $field):
                            $meta = get_post_meta($post->ID, $field['id'], true);
                            ?>
                            <tr class="alternate">
                                <td>
                                    <label for='<?php echo $field['id']; ?>'><strong><?php echo $field['name']; ?></strong><span><?php echo $field['desc']; ?></span></label>
                                </td>
                                <td>
                                    <?php
                                    switch ($field['type']):
                                        case 'text':
                                            echo "<input title='{$field['title']}' type='text' name='iw_information[extrafield][{$field['id']}]' id='{$field['id']}' value='" . ($meta ? $meta : htmlentities(stripslashes($field['std']))) . "' />";
                                            break;
                                        case 'dropdown_list':
                                            $field_data = unserialize($field['std']);
                                            if ($field_data[1] == 1) {
                                                echo "<select name='iw_information[extrafield][{$field['id']}][]' id='{$field['id']}' multiple='multiple' >";
                                            } else {
                                                echo "<select name='iw_information[extrafield][{$field['id']}]' id='{$field['id']}' >";
                                            }
                                            $options = explode("\n", htmlentities(stripslashes($field_data[0])));
                                            foreach ($options as $option) {
                                                $option_data = explode("|", $option);
                                                if (count($option_data) == 3) {
                                                    echo "<option value='{$option_data[0]}'";
                                                    if ($meta) {
                                                        $values = unserialize(html_entity_decode($meta));
                                                        $val = $option_data[0];
                                                        if (in_array($val, $values)) {
                                                            echo ' selected="selected"';
                                                        }
                                                    } else {
                                                        if ($option_data[2] == 1) {
                                                            echo ' selected="selected"';
                                                        }
                                                    }
                                                    echo ">{$option_data[1]}</option>";
                                                }
                                            }
                                            echo '</select>';
                                            break;
                                        case 'textarea':
                                            echo "<textarea title='{$field['title']}' name='iw_information[extrafield][{$field['id']}]' id='{$field['id']}'>" . ($meta ? $meta : htmlentities(stripslashes($field['std']))) . "</textarea>";
                                            break;
                                        case 'date':
                                            echo "<input type='text' title='{$field['title']}' name='iw_information[extrafield][{$field['id']}]' id='{$field['id']}' value='" . ($meta ? $meta : $field['std']) . "'/>";
                                            echo '<script tpe="text/javascript">
                            jQuery(document).ready(function () {
                                jQuery("#' . $field['id'] . '").datepicker({
                                    dateFormat: "dd-mm-yy"
                                });
                            });
                        </script>';
                                            break;
                                        case 'measurement':
                                            $measurement_data = unserialize(html_entity_decode($meta));
                                            if (!$measurement_data) {
                                                $measurement_data = unserialize($field['std']);
                                            }
                                            $measurement_value = htmlentities(stripslashes($measurement_data['measurement_value']));
                                            $measurement_unit = $measurement_data['measurement_unit'];
                                            echo "<input type='text' title='{$field['title']}' name='iw_information[extrafield][{$field['id']}][measurement_value]' id='{$field['id']}' value='" . $measurement_value . "'/> {$measurement_unit}";
                                            echo "<input type='hidden' name='iw_information[extrafield][{$field['id']}][measurement_unit]' id='{$field['id']}' value='" . $measurement_unit . "'/>";
                                            break;
                                        case 'link':
                                            $link_data = unserialize(html_entity_decode($meta));
                                            if (!$link_data) {
                                                $link_data = unserialize($field['std']);
                                            }
                                            $link_url = htmlentities(stripslashes($link_data['link_value_link']));
                                            $link_text = htmlentities(stripslashes($link_data['link_value_text']));
                                            $link_target = $link_data['link_value_target'];
                                            echo '<input placeholder = "' . __('URL') . '" name = "iw_information[extrafield][' . $field['id'] . '][link_value_link]" value = "' . $link_url . '" type = "url"/>';
                                            echo '<input placeholder = "' . __('Text') . '" name = "iw_information[extrafield][' . $field['id'] . '][link_value_text]" value = "' . $link_text . '" type = "text"/>';
                                            $link_datas = array(
                                                array('value' => '_blank', 'text' => 'Blank'),
                                                array('value' => '_self', 'text' => 'Self')
                                            );
                                            echo $utility->selectFieldRender('iw_information_' . $field['id'], 'iw_information[extrafield][' . $field['id'] . '][link_value_target]', $link_target, $link_datas, 'Target', '', false);
                                            break;
                                        case 'image':
                                            ?>
                                            <script>
                                                jQuery(function ($) {
                                                    var frame;

                                                    $('#field-image-button-<?php echo $field['id']; ?>').on('click', function (e) {
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
                                                                text: '<?php _e('Insert', 'gmswebdesign'); ?>',
                                                                click: function () {
                                                                    var models = frame.state().get('selection'),
                                                                            url = models.first().attributes.url;

                                                                    $('#field-image-link-<?php echo $field['id']; ?>').val(url);

                                                                    frame.close();
                                                                }
                                                            } // end insert
                                                        });
                                                    });
                                                });
                                            </script>
                                            <input placeholder="<?php echo __('Image URL'); ?>" id='field-image-link-<?php echo $field['id']; ?>' name="iw_information[extrafield][<?php echo $field['id']; ?>]" value="<?php echo ($meta ? $meta : $field['std']); ?>" type="text"/>
                                            <input type='button' class='button' name='field-image-button-<?php echo $field['id']; ?>' id='field-image-button-<?php echo $field['id']; ?>' value='Browse' />
                                            <?php
                                            break;
                                        case 'images':
                                            ?>
                                            <script>
                                                jQuery(function ($) {
                                                    // Load images
                                                    function loadImages(images) {
                                                        if (images) {
                                                            var shortcode = new wp.shortcode({
                                                                tag: 'gallery',
                                                                attrs: {ids: images},
                                                                type: 'single'
                                                            });

                                                            var attachments = wp.media.gallery.attachments(shortcode);

                                                            var selection = new wp.media.model.Selection(attachments.models, {
                                                                props: attachments.props.toJSON(),
                                                                multiple: true
                                                            });

                                                            selection.gallery = attachments.gallery;

                                                            // Fetch the query's attachments, and then break ties from the
                                                            // query to allow for sorting.
                                                            selection.more().done(function () {
                                                                // Break ties with the query.
                                                                selection.props.set({query: false});
                                                                selection.unmirror();
                                                                selection.props.unset('orderby');
                                                            });

                                                            return selection;
                                                        }

                                                        return false;
                                                    }

                                                    var frame,
                                                            images = '<?php echo get_post_meta($post->ID, '_iw_courses_image_ids', true); ?>'
                                                    selection = loadImages(images);

                                                    $('#iw_courses_image_upload').on('click', function (e) {
                                                        e.preventDefault();

                                                        // Set options for 1st frame render
                                                        var options = {
                                                            title: '<?php _e('Create Gallery', 'gmswebdesign'); ?>',
                                                            state: 'gallery-edit',
                                                            frame: 'post',
                                                            selection: selection
                                                        }

                                                        // Check if frame or gallery already exist
                                                        if (frame || selection) {
                                                            options['title'] = '<?php _e('Edit Gallery', 'gmswebdesign'); ?>';
                                                        }

                                                        frame = wp.media(options).open();

                                                        // Tweak views
                                                        frame.menu.get('view').unset('cancel');
                                                        frame.menu.get('view').unset('separateCancel');
                                                        frame.menu.get('view').get('gallery-edit').el.innerHTML = '<?php _e('Edit Gallery', 'gmswebdesign'); ?>';
                                                        frame.content.get('view').sidebar.unset('gallery'); // Hide Gallery Settings in sidebar

                                                        // When we are editing a gallery
                                                        overrideGalleryInsert();
                                                        frame.on('toolbar:render:gallery-edit', function () {
                                                            overrideGalleryInsert();
                                                        });

                                                        frame.on('content:render:browse', function (browser) {
                                                            if (!browser)
                                                                return;
                                                            // Hide Gallery Settings in sidebar
                                                            browser.sidebar.on('ready', function () {
                                                                browser.sidebar.unset('gallery');
                                                            });
                                                            // Hide filter/search as they don't work
                                                            browser.toolbar.on('ready', function () {
                                                                if (browser.toolbar.controller._state == 'gallery-library') {
                                                                    browser.toolbar.$el.hide();
                                                                }
                                                            });
                                                        });

                                                        // All images removed
                                                        frame.state().get('library').on('remove', function () {
                                                            var models = frame.state().get('library');
                                                            if (models.length == 0) {
                                                                selection = false;
                                                                $.post(ajaxurl, {ids: '', action: 'iw_courses_save_images', post_id: iw_courses_ajax.post_id, nonce: iw_courses_ajax.nonce});
                                                            }
                                                        });

                                                        // Override insert button
                                                        function overrideGalleryInsert() {
                                                            frame.toolbar.get('view').set({
                                                                insert: {
                                                                    style: 'primary',
                                                                    text: '<?php echo _e('Save Gallery', 'gmswebdesign'); ?>',
                                                                    click: function () {
                                                                        var models = frame.state().get('library'),
                                                                                ids = '';

                                                                        models.each(function (attachment) {
                                                                            ids += attachment.id + ','
                                                                        });

                                                                        this.el.innerHTML = '<?php _e('Saving ...', 'gmswebdesign'); ?>';

                                                                        $.ajax({
                                                                            type: 'POST',
                                                                            url: ajaxurl,
                                                                            data: {
                                                                                ids: ids,
                                                                                action: 'iw_courses_save_images',
                                                                                post_id: iw_courses_ajax.post_id,
                                                                                nonce: iw_courses_ajax.nonce
                                                                            },
                                                                            success: function () {
                                                                                selection = loadImages(ids);
                                                                                $('#_iw_courses_image_ids').val(ids);
                                                                                frame.close();
                                                                            },
                                                                            dataType: 'html'
                                                                        }).done(function (data) {
                                                                            $('.iwc-gallery-thumbnail').html(data);
                                                                        });

                                                                    } // end click function
                                                                } // end insert
                                                            });
                                                        }
                                                    });
                                                });
                                            </script>
                                            <?php
// SPECIAL CASE:
                                            $meta = get_post_meta($post->ID, '_iw_courses_image_ids', true);
                                            $thumbs_output = '';
                                            $button_text = $meta ? __('Edit Gallery', 'gmswebdesign') : $field['std'];
                                            if ($meta) {
                                                $field['std'] = __('Edit Gallery', 'gmswebdesign');
                                                $thumbs = explode(',', $meta);
                                                foreach ($thumbs as $thumb) {
                                                    $thumbs_output .= '<li>' . wp_get_attachment_image($thumb, array(50, 50)) . '</li>';
                                                }
                                            }
                                            echo
                                            "
						<input type='button' class='button' name='{$field['id']}' id='iw_courses_image_upload' value='$button_text' />
						<input type='hidden' name='iw_information[extrafield][_iw_courses_image_ids]' id='_iw_courses_image_ids' value='" . ($meta ? $meta : 'false') . "' />
						<ul class='iwc-gallery-thumbnail'>{$thumbs_output}</ul>
					";
                                            break;
                                        case 'file':
                                            ?>
                                            <script>
                                                jQuery(function ($) {
                                                    var frame;

                                                    $('#<?php echo $field['id']; ?>_button').on('click', function (e) {
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
                                                                text: '<?php _e('Insert', 'gmswebdesign'); ?>',
                                                                click: function () {
                                                                    var models = frame.state().get('selection'),
                                                                            url = models.first().attributes.url;

                                                                    $('#<?php echo $field['id']; ?>').val(url);

                                                                    frame.close();
                                                                }
                                                            } // end insert
                                                        });
                                                    });
                                                });
                                            </script>
                                            <?php
                                            echo
                                            "
						<input type='text' title='{$field['title']}' name='iw_information[extrafield][{$field['id']}]' id='{$field['id']}' value='" . ($meta ? $meta : $field['std']) . "' class='file' />
						<input type='button' class='button' name='{$field['id']}_button' id='{$field['id']}_button' value='Browse' />
					";
                                            break;
                                        default:
                                            break;
                                    endswitch;
                                    ?>
                                </td>
                <!--                                <td>
                                    <span class="button remove-button"><?php echo __('Remove', 'gmswebdesign'); ?></span>
                                </td>-->
                            </tr>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }

}
