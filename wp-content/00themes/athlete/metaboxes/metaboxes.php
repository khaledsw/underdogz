<?php
class InwaveThemesFrameworkMetaboxes {
	
	public function __construct()
	{
		add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'save_meta_boxes'));
	}

	
	public function add_meta_boxes()
	{
		$this->add_meta_box('page_options', 'Page Options', 'page');
		$this->add_meta_box('post_options', 'Post Options', 'post');

	}
	
	public function add_meta_box($id, $label, $post_type)
	{
	    add_meta_box( 
	        'inwave_' . $id,
	        $label,
	        array($this, $id),
	        $post_type,
			'side'
	    );
	}
	
	public function save_meta_boxes($post_id)
	{
		if(defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		
		foreach($_POST as $key => $value) {
			if(strstr($key, 'inwave_')) {
				update_post_meta($post_id, $key, $value);
			}
		}
	}

	public function page_options()
	{
		include 'style.php';
		include 'page_options.php';
	}
	
	public function post_options()
	{	
		include 'style.php';
		include 'post_options.php';
	}
	public function post_options_portfolio()
	{	
		include 'style.php';
		include 'post_options_portfolio.php';
	}
	public function getMasterSlider(){
		global $wpdb;
		$masterslider = array();
		if(class_exists('Master_Slider_Admin')) {

            // safe query: no input data
			$rs = $wpdb->get_results( 
				"
				SELECT id, title
				FROM ".$wpdb->prefix."masterslider_sliders where status = 'published'
				ORDER BY title ASC LIMIT 100
				"
			);
			$masterslider = array(
				'' => 'No Slider'
			);
			if ($rs) {
				foreach ( $rs as $slider ) {
					$masterslider[$slider->id] = $slider->title;
				}
			}
		}
		return $masterslider;
	}
	public function getSideBars(){
		$sideBars = array();
		$sideBars[''] = 'Auto';
		foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
			$sideBars[str_replace('sidebar-','',$sidebar['id'])] = ucwords( $sidebar['name'] );
		}
		return $sideBars;
	}

	public function text($id, $label, $desc = '',$default='')
	{
		global $post;
		if (get_post_meta($post->ID, 'inwave_' . $id, true) == ""){
			$value = $default;
		}else{
			$value = get_post_meta($post->ID, 'inwave_' . $id, true);
		}
		$html = '';
		$html .= '<div class="inwave_metabox_field">';
			$html .= '<label for="inwave_' . $id . '">';
			$html .= $label;
			$html .= '</label>';
			$html .= '<div class="field">';
				$html .= '<input type="text" id="inwave_' . $id . '" name="inwave_' . $id . '" value="' . $value . '" />';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
		$html .= '</div>';
		
		echo $html;
	}
	
	public function select($id, $label, $options, $desc = '')
	{
		global $post;
		
		$html = '';
		$html .= '<div class="inwave_metabox_field">';
			$html .= '<label for="inwave_' . $id . '">';
			$html .= $label;
			$html .= '</label>';
			$html .= '<div class="field">';
				$html .= '<select id="inwave_' . $id . '" name="inwave_' . $id . '">';
				foreach($options as $key => $option) {
					if(get_post_meta($post->ID, 'inwave_' . $id, true) == $key) {
						$selected = 'selected="selected"';
					} else {
						$selected = '';
					}
					
					$html .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
				}
				$html .= '</select>';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
		$html .= '</div>';
		
		echo $html;
	}

	public function multiple($id, $label, $options, $desc = '')
	{
		global $post;
		
		$html = '';
		$html .= '<div class="inwave_metabox_field">';
			$html .= '<label for="inwave_' . $id . '">';
			$html .= $label;
			$html .= '</label>';
			$html .= '<div class="field">';
				$html .= '<select multiple="multiple" id="inwave_' . $id . '" name="inwave_' . $id . '[]">';
				foreach($options as $key => $option) {
					if(is_array(get_post_meta($post->ID, 'inwave_' . $id, true)) && in_array($key, get_post_meta($post->ID, 'inwave_' . $id, true))) {
						$selected = 'selected="selected"';
					} else {
						$selected = '';
					}
					
					$html .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
				}
				$html .= '</select>';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
		$html .= '</div>';
		
		echo $html;
	}

	public function textarea($id, $label, $desc = '')
	{
		global $post;

		$html = '';
		$html = '';
		$html .= '<div class="inwave_metabox_field">';
			$html .= '<label for="inwave_' . $id . '">';
			$html .= $label;
			$html .= '</label>';
			$html .= '<div class="field">';
				$html .= '<textarea cols="78" rows="5" id="inwave_' . $id . '" name="inwave_' . $id . '">' . get_post_meta($post->ID, 'inwave_' . $id, true) . '</textarea>';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
		$html .= '</div>';
		
		echo $html;
	}

	public function upload($id,$label,$desc = '',$default = ''){
		global $post;
		
		if (get_post_meta($post->ID, 'inwave_' . $id, true) == ""){
			$value = $default;
		}else{
			$value = get_post_meta($post->ID, 'inwave_' . $id, true);
		}
		$img_preview = '';
		if($value){
			$img_preview = wp_get_attachment_image_src($value);
			$img_preview = '<img src="' . $img_preview[0] . '" alt="Preview">';
		}
		$html = '';
		$html .= '<div class="inwave_metabox_field">';
			$html .= '<label for="inwave_' . $id . '">';
			$html .= $label;
			$html .= '</label>';
			$html .= '<div class="field">';
			$html .= '<div class="image-preview">'.$img_preview.'</div>';
			$html .= '<input class="inwave_' . $id . '" type="hidden" name="inwave_' . $id . '" size="12" value="' . $value . '" />';
			$html .= '<button id="inwave_' . $id . '" class="button">Insert</button> ';
			$html .= '<button class="clear-button button">Clear</button>';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
		$html .= '</div>';
		echo $html;
		?>
		<script>
		jQuery(document).ready(function(){
			jQuery('#inwave_<?php echo $id ?>').on('click', function (event) {
				var e_target = jQuery(this);

				event.preventDefault();

				// Create a new media frame
				frame = wp.media({
					state: 'insert',
					frame: 'post',
					library: {
						type: 'image'
					},
					multiple: false  // Set to true to allow multiple files to be selected
				}).open();

				frame.menu.get('view').unset('featured-image');

				frame.toolbar.get('view').set({
					insert: {
						style: 'primary',
						text: 'Insert',
						click: function () {
							// Get media attachment details from the frame state
							var attachment = frame.state().get('selection').first().toJSON();

							// Send the attachment URL to our custom image input field.
							e_target.parent().find('.image-preview').html('<img src="' + attachment.url + '" alt=""/>').removeClass('hidden');
							var imgElement = e_target.parent().find('div.image-preview img');
							if (imgElement.height() > imgElement.width()) {
								imgElement.css('width', '100%');
							} else {
								imgElement.css('height', '100%');
							}

							// Send the attachment id to our hidden input
							e_target.parent().find('input').val(attachment.id);
							frame.close();
						}
					} // end insert
				});
			});	
			jQuery('.inwave_metabox_field .clear-button').on('click', function (event) {
				var e_target = jQuery(this);
				event.preventDefault();
				// Clear out the preview image
				e_target.parents('.inwave_metabox_field').find('div.image-preview').addClass('hidden').html('');
				// Delete the image id from the hidden input
				e_target.parents('.inwave_metabox_field').find('input').val('');

			});		
		})
		</script>
		<?php
		
				
	}
	
}

$metaboxes = new InwaveThemesFrameworkMetaboxes;
