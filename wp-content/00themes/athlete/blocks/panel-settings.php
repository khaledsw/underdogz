<?php
global $athlete_cfg;
$pnl = $athlete_cfg['panel-settings'];
?>
<div class="panel-tools">
	<div class="panel-content">
		<div class="row-setting layout-setting">
			<h3 class="title">LAYOUT</h3>
			<div class="setting">
				<button value="wide" class="wide <?php if($pnl->layout=='wide') echo 'active' ?>">WIDE</button>
				<button value="boxed" class="boxed <?php if($pnl->layout=='boxed') echo 'active' ?>">BOXED</button>
			</div>
		</div>
		<div class="row-setting color-setting sample-setting">
			<h3 class="title">SAMPLE COLOR</h3>
			<div class="setting">
				<button <?php if($pnl->mainColor=='#ec3642') echo 'class="active"' ?> value="#ec3642"></button>
				<button <?php if($pnl->mainColor=='#409915') echo 'class="active"' ?> value="#409915"></button>
				<button <?php if($pnl->mainColor=='#00c8d6') echo 'class="active"' ?> value="#00c8d6"></button>
				<button <?php if($pnl->mainColor=='#ef791f') echo 'class="active"' ?> value="#ef791f"></button>
				<button <?php if($pnl->mainColor=='#d31266') echo 'class="active"' ?> value="#d31266"></button>
				<button <?php if($pnl->mainColor=='#efc10a') echo 'class="active"' ?> value="#efc10a"></button>
			</div>
			<div class="description">
				Please read our documentation file to know how to change colors as you want
			</div>
		</div>
		<div class="overlay-setting <?php if($pnl->layout=='wide') echo 'disabled' ?>">
		<div class="row-setting color-setting background-setting">
			<h3 class="title">BACKGROUND COLOR</h3>
			<div class="setting">
				<button <?php if($pnl->bgColor=='#87a8a5') echo 'class="active"' ?> value="#87a8a5"></button>
				<button <?php if($pnl->bgColor=='#38424a') echo 'class="active"' ?> value="#38424a"></button>
				<button <?php if($pnl->bgColor=='#e3e6e8') echo 'class="active"' ?> value="#e3e6e8"></button>
				<button <?php if($pnl->bgColor=='#242d39') echo 'class="active"' ?> value="#242d39"></button>
				<button <?php if($pnl->bgColor=='#000000') echo 'class="active"' ?> value="#000000"></button>
				<button <?php if($pnl->bgColor=='#222222') echo 'class="active"' ?> value="#222222"></button>
			</div>
		</div>
		<div class="row-setting color-setting background-setting">
			<h3 class="title">BACKGROUND TEXTURE</h3>
			<div class="setting">
				<button <?php if($pnl->bgColor==get_template_directory_uri().'/images/texture/texture-1.png') echo 'class="active"' ?> value="<?php echo get_template_directory_uri()?>/images/texture/texture-1.png"></button>
				<button <?php if($pnl->bgColor==get_template_directory_uri().'/images/texture/texture-2.png') echo 'class="active"' ?> value="<?php echo get_template_directory_uri()?>/images/texture/texture-2.png"></button>
				<button <?php if($pnl->bgColor==get_template_directory_uri().'/images/texture/texture-3.png') echo 'class="active"' ?> value="<?php echo get_template_directory_uri()?>/images/texture/texture-3.png"></button>
				<button <?php if($pnl->bgColor==get_template_directory_uri().'/images/texture/texture-4.png') echo 'class="active"' ?> value="<?php echo get_template_directory_uri()?>/images/texture/texture-4.png"></button>
				<button <?php if($pnl->bgColor==get_template_directory_uri().'/images/texture/texture-5.png') echo 'class="active"' ?> value="<?php echo get_template_directory_uri()?>/images/texture/texture-5.png"></button>
				<button <?php if($pnl->bgColor==get_template_directory_uri().'/images/texture/texture-6.png') echo 'class="active"' ?> value="<?php echo get_template_directory_uri()?>/images/texture/texture-6.png"></button>
			</div>
		</div>
		</div>
        <?php if(class_exists('RTLTester')): ?>
            <h3>
            <?php if(is_rtl()): ?>
                <a class="switch-ltr" href="?d=ltr">Switch to Left-To-Right</a>
            <?php else:?>
                <a class="switch-ltr" href="?d=rtl">Switch to Right-To-Left</a>
            <?php endif;?>
            </h3>
        <?php endif;?>
		<div class="reset-button">
			<button>Reset</button>
		</div>
	</div>
	<button class="panel-button"><i class="fa fa-asterisk"></i></button>
</div>