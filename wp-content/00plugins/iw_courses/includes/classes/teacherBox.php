<?php
/*
 * @package Courses Manager
 * @version 1.0.0
 * @created Mar 11, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of teacherBox
 *
 * @developer duongca
 */
class teacherBox {

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
        if ($post_type == 'iw_teacher') {
            add_meta_box(
                    'teacher_image_gallery', __('Image Gallery', 'inwavethemes'), array($this, 'render_meta_box_image_gallery'), $post_type, 'advanced', 'high'
            );
            add_meta_box(
                    'teacher_basic_information', __('Basic Information', 'inwavethemes'), array($this, 'render_meta_box_basic_information'), $post_type, 'advanced', 'high'
            );
            add_meta_box(
                    'teacher_info_training_skills', __('Training Skills', 'inwavethemes'), array($this, 'render_meta_box_training_skills'), $post_type, 'advanced', 'high'
            );
            add_meta_box(
                    'teacher_info_training_experience', __('Training Experience', 'inwavethemes'), array($this, 'render_meta_box_training_experience'), $post_type, 'advanced', 'high'
            );
            add_meta_box(
                    'teacher_social_link', __('Social Links', 'inwavethemes'), array($this, 'render_meta_box_social_link'), $post_type, 'advanced', 'high'
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
        if (!isset($_POST['iw_teacher_post_metabox_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST['iw_teacher_post_metabox_nonce'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'iw_teacher_post_metabox')) {
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

        $teacher_info = $_POST['iw_information'];
        $image_gallery = array();
        if ($teacher_info['image_gallery']) {
            foreach ($teacher_info['image_gallery'] as $value) {
                $image_gallery[] = str_replace(site_url(), '', $value);
            }
        }
        $basic_info = $this->margeArray($teacher_info['basic_information']);
		foreach($basic_info as &$bi){
			$bi = str_replace('\\"','&quot;',$bi);
		}
        $training_experience = $this->margeArray($teacher_info['training_experience']);
		foreach($training_experience as &$te){
			$te = str_replace('\\"','&quot;',$te);
		}
        $training_skills = $this->margeArray($teacher_info['training_skills']);
		foreach($training_skills as &$ts){
			$ts = str_replace('\\"','&quot;',$ts);
		}

        $social_links = $this->margeArray($teacher_info['social_link']);
        // Update the meta field.
        update_post_meta($post_id, 'iw_teacher_rate', $teacher_info['teacher_rate']);
        update_post_meta($post_id, 'iw_teacher_email', $teacher_info['teacher_email']);
        update_post_meta($post_id, 'iw_teacher_image_gallery', serialize($image_gallery));
        update_post_meta($post_id, 'iw_teacher_basic_info', serialize($basic_info));
        update_post_meta($post_id, 'iw_teacher_training_experience', serialize($training_experience));
        update_post_meta($post_id, 'iw_teacher_training_skills', serialize($training_skills));
        update_post_meta($post_id, 'iw_teacher_social_link', serialize($social_links));
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

    public function render_meta_box_image_gallery($post) {
        $value = get_post_meta($post->ID, 'iw_teacher_image_gallery', true);
        $image_gallery = unserialize($value);
        // Add an nonce field so we can check for it later.
        wp_nonce_field('iw_teacher_post_metabox', 'iw_teacher_post_metabox_nonce');
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
                <span class="button add-new-image"><?php echo __('Add new images', 'inwavethemes'); ?></span>
            </div>
        </div>
        <?php
    }

    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_basic_information($post) {

        // Use get_post_meta to retrieve an existing value from the database.
        $value = get_post_meta($post->ID, 'iw_teacher_basic_info', true);
        $basic_info = unserialize($value);
        $utility = new iwcUtility();
        ?>
        <div class="iwc-metabox-fields">
            <table class="list-table">
                <thead>
                    <tr>
                        <th class="left"><?php echo __('Text', 'inwavethemes'); ?></th>
                        <th><?php echo __('Value', 'inwavethemes'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="the-list">
                    <?php
                    $teacher_rate = get_post_meta($post->ID, 'iw_teacher_rate', true);
                    $data_rate = array(
                        array('value' => 5, 'text' => 5),
                        array('value' => 4, 'text' => 4),
                        array('value' => 3, 'text' => 3),
                        array('value' => 2, 'text' => 2),
                        array('value' => 1, 'text' => 1)
                    );
                    ?>
                    <tr class="alternate">
                        <td>
                            <label><?php echo __('Teacher Rate', 'inwavethemes'); ?></label>
                        </td>
                        <td colspan="2">
                            <?php
                            echo $utility->selectFieldRender('iw_information_teacher_rate', 'iw_information[teacher_rate]', $teacher_rate, $data_rate, 'Select Teacher Rate', '', false);
                            ?>
                        </td>
                    </tr>
                    <tr class="alternate">
                        <td>
                            <label><?php echo __('Teacher Email', 'inwavethemes'); ?></label>
                        </td>
                        <td colspan="2">
                            <input value="<?php echo get_post_meta($post->ID, 'iw_teacher_email', true) ? get_post_meta($post->ID, 'iw_teacher_email', true) : ''; ?>" placeholder="<?php echo __('Teacher Email', 'inwavethemes'); ?>" type="text" size="20" name="iw_information[teacher_email]"/>
                        </td>
                    </tr>
                    <?php if ($basic_info): ?>
                        <?php foreach ($basic_info as $info): ?>

                            <tr class="alternate">
                                <td>
                                    <input value="<?php echo $info['key_title'] ? htmlspecialchars($info['key_title']) : ''; ?>" placeholder="<?php echo __('Info Title', 'inwavethemes'); ?>" type="text" size="20" name="iw_information[basic_information][key_title][]"/>
                                </td>
                                <td>
                                    <input value="<?php echo $info['key_value'] ? htmlspecialchars($info['key_value']) : ''; ?>" placeholder="<?php echo __('Info Value', 'inwavethemes'); ?>" type="text" size="20" name="iw_information[basic_information][key_value][]"/>
                                </td>
                                <td>
                                    <span class="button remove-button"><?php echo __('Remove', 'inwavethemes'); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="alternate">
                            <td>
                                <input placeholder="<?php echo __('Info Title', 'inwavethemes'); ?>" type="text" size="20" name="iw_information[basic_information][key_title][]"/>
                            </td>
                            <td>
                                <input placeholder="<?php echo __('Info Value', 'inwavethemes'); ?>" type="text" size="20" name="iw_information[basic_information][key_value][]"/>
                            </td>
                            <td>
                                <span class="button remove-button"><?php echo __('Remove', 'inwavethemes'); ?></span>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan="3">
                            <div class="submit">
                                <span class="button add-row info"><?php echo __('Add Info', 'inwavethemes'); ?></span
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function render_meta_box_training_skills($post) {

        // Use get_post_meta to retrieve an existing value from the database.
        $value = get_post_meta($post->ID, 'iw_teacher_training_skills', true);
        $training_skills = unserialize($value);
        ?>
        <div class="iwc-metabox-fields">
            <table class="list-table">
                <thead>
                    <tr>
                        <th class="left"><?php echo __('Text', 'inwavethemes'); ?></th>
                        <th><?php echo __('Value', 'inwavethemes'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="the-list">
                    <?php if ($training_skills): ?>
                        <?php foreach ($training_skills as $skill): ?>

                            <tr class="alternate">
                                <td>
                                    <input value="<?php echo $skill['key_title']; ?>" placeholder="<?php echo __('Training Skills Title', 'inwavethemes'); ?>" type="text" size="20" name="iw_information[training_skills][key_title][]"/>
                                </td>
                                <td>
                                    <label class="field-value" style="font-weight: bold;"><?php echo $skill['key_value']; ?></label><br/>
                                    <input class="skill-field-value" value="<?php echo $skill['key_value']; ?>" placeholder="<?php echo __('Training Skills Value', 'inwavethemes'); ?>" type="range" min="0" max="100" step="1" size="20" name="iw_information[training_skills][key_value][]"/>
                                </td>
                                <td>
                                    <span class="button remove-button"><?php echo __('Remove', 'inwavethemes'); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="alternate">
                            <td>
                                <input placeholder="<?php echo __('Training Skills Title', 'inwavethemes'); ?>" type="text" size="20" name="iw_information[training_skills][key_title][]"/>
                            </td>
                            <td>
                                <label class="field-value" style="font-weight: bold;">50</label><br/>
                                <input class="skill-field-value" placeholder="<?php echo __('Training Skills Value', 'inwavethemes'); ?>" type="range" min="0" max="100" step="1" size="20" value="50" name="iw_information[training_skills][key_value][]"/>
                            </td>
                            <td>
                                <span class="button remove-button"><?php echo __('Remove', 'inwavethemes'); ?></span>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan="3">
                            <div class="submit">
                                <span class="button add-row skills"><?php echo __('Add Training Skills', 'inwavethemes'); ?></span
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function render_meta_box_training_experience($post) {

        // Use get_post_meta to retrieve an existing value from the database.
        $value = get_post_meta($post->ID, 'iw_teacher_training_experience', true);
        $training_experience = unserialize($value);
        ?>
        <div class="iwc-metabox-fields">
            <table class="list-table">
                <thead>
                    <tr>
                        <th class="left"><?php echo __('Text', 'inwavethemes'); ?></th>
                        <th><?php echo __('Value', 'inwavethemes'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="the-list">
                    <?php
                    if ($training_experience):
                        foreach ($training_experience as $exp):
                            ?>
                            <tr class="alternate">
                                <td>
                                    <input value="<?php echo $exp['key_title']; ?>" placeholder="<?php echo __('Training Experience Title', 'inwavethemes'); ?>" type="text" size="20" name="iw_information[training_experience][key_title][]"/>
                                </td>
                                <td>
                                    <textarea placeholder="<?php echo __('Training Experience Value', 'inwavethemes'); ?>" name="iw_information[training_experience][key_value][]"><?php echo $exp['key_value']; ?></textarea>
                                </td>
                                <td>
                                    <span class="button remove-button"><?php echo __('Remove', 'inwavethemes'); ?></span>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    else:
                        ?>
                        <tr class="alternate">
                            <td>
                                <input value="<?php echo $exp['key_title']; ?>" placeholder="<?php echo __('Training Experience Title', 'inwavethemes'); ?>" type="text" size="20" name="iw_information[training_experience][key_title][]"/>
                            </td>
                            <td>
                                <textarea placeholder="<?php echo __('Training Experience Value', 'inwavethemes'); ?>" name="iw_information[training_experience][key_value][]"><?php echo $exp['key_value']; ?></textarea>
                            </td>
                            <td>
                                <span class="button remove-button"><?php echo __('Remove', 'inwavethemes'); ?></span>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan="3">
                            <div class="submit">
                                <span class="button add-row experience"><?php echo __('Add Training Experience', 'inwavethemes'); ?></span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function render_meta_box_social_link($post) {
        // Use get_post_meta to retrieve an existing value from the database.
        $value = get_post_meta($post->ID, 'iw_teacher_social_link', true);
        $social_link = unserialize($value);
        $utility = new iwcUtility();
		$data = array(
			array('value' => 'facebook', 'text' => __('Facebook', 'inwavethemes')),
			array('value' => 'youtube', 'text' => __('Youtube', 'inwavethemes')),
			array('value' => 'vimeo', 'text' => __('Vimeo', 'inwavethemes')),
			array('value' => 'flickr', 'text' => __('Flickr', 'inwavethemes')),
			array('value' => 'google-plus', 'text' => __('Google+', 'inwavethemes')),
			array('value' => 'linkedin', 'text' => __('Linkedin', 'inwavethemes')),
			array('value' => 'tumblr', 'text' => __('Tumblr', 'inwavethemes')),
			array('value' => 'twitter', 'text' => __('Twitter', 'inwavethemes'))
		);
        ?>
        <div class="iwc-metabox-fields">
            <table class="list-table">
                <thead>
                    <tr>
                        <th class="left"><?php echo __('Social Type', 'inwavethemes'); ?></th>
                        <th><?php echo __('Link', 'inwavethemes'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="the-list">
                    <?php
                    if ($social_link):
                        foreach ($social_link as $exp):
                            ?>
                            <tr class="alternate social-link-types">
                                <td>
                                    <?php
                                    
                                    echo $utility->selectFieldRender('iw_information_social_link_key_title', 'iw_information[social_link][key_title][]', $exp['key_title'], $data, '', '', false);
                                    ?>
                                </td>
                                <td>
                                    <input type="url" placeholder="<?php echo __('Social Link Value', 'inwavethemes'); ?>" name="iw_information[social_link][key_value][]" value="<?php echo $exp['key_value']; ?>"/>
                                </td>
                                <td>
                                    <span class="button remove-button"><?php echo __('Remove', 'inwavethemes'); ?></span>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    else:
                        ?>
                        <tr class="alternate social-link-types">
                            <td>
                                <?php
                                echo $utility->selectFieldRender('iw_information_social_link_key_title', 'iw_information[social_link][key_title][]', NULL, $data, '', '', false);
                                ?>
                            </td>
                            <td>
                                <input type="url" placeholder="<?php echo __('Social Link Value', 'inwavethemes'); ?>" name="iw_information[social_link][key_value][]" value=""/>
                            </td>
                            <td>
                                <span class="button remove-button"><?php echo __('Remove', 'inwavethemes'); ?></span>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan="3">
                            <div class="submit">
                                <span class="button add-row social"><?php echo __('Add Social', 'inwavethemes'); ?></span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
    }

}
