<div class="wrap" id="of_container">

	<div id="of-popup-save" class="of-save-popup">
		<div class="of-save-save">Options Updated</div>
	</div>
	
	<div id="of-popup-reset" class="of-save-popup">
		<div class="of-save-reset">Options Reset</div>
	</div>
	
	<div id="of-popup-fail" class="of-save-popup">
		<div class="of-save-fail">Error!</div>
	</div>
	
	<span style="display: none;" id="hooks"><?php echo json_encode(of_get_header_classes_array()); ?></span>
	<input type="hidden" id="reset" value="<?php if(isset($_REQUEST['reset'])) echo $_REQUEST['reset']; ?>" />
	<input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce('of_ajax_nonce'); ?>" />

	<form id="of_form" method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" enctype="multipart/form-data" >
	
		<div id="header">
		
			<div class="logo">
				<h2>underdogz front end</h2>
				<span><?php echo ('v'. THEMEVERSION); ?></span>
			</div>
		
			<div id="js-warning">Warning- This options panel will not work properly without javascript!</div>

		<div id="info_bar">

						
			<img style="display:none" src="<?php echo esc_url(ADMIN_DIR); ?>assets/images/loading.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />

			<button id="of_save" type="button" class="button-primary">
				<?php _e('Save Change','gmswebdesign');?>
			</button>
			
		</div><!--.info_bar--> 	
    	</div>
		<div class="clear"></div>
		
		<div id="main">
		
			<div id="of-nav">
				<ul>
				  <?php echo $options_machine->Menu ?>
				</ul>
			</div>

			<div id="content">

		  		<?php echo $options_machine->Inputs /* Settings */ ?>
                <?php if(isset($_REQUEST['imported'])){
                    echo '<h2 id="import-notice">Imported successfully!</h2>';
                    echo '<p style="font-size:12px;">Option: You can also download original images <a href="http://gmswebdesign.com/demo-images/athlete/original-images.zip">here</a> to replace grey demo images. Just unzip to the wordpress upload folder: wp-content/uploads</p>';
                }?>
		  	</div>
		  	
			<div class="clear"></div>
			
		</div>

	</form>
	
	<div style="clear:both;"></div>

</div><!--wrap-->