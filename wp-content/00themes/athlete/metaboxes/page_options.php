<div class="inwave_metabox">
    <?php
    $this->select('masterslider',
        'Show Master Slider',
        $this->getMasterSlider()
    );
    ?>
   <?php
    $this->select('show_pageheading',
        'Show page heading',
        array(''=>'Default', 'yes' => 'Yes', 'no' => 'No'),
        ''
    );
    ?>
	<?php
    $this->upload('pageheading_bg','Page heading background');
    ?>
    <?php
    $this->select('sidebar_position',
        'Sidebar Position',
        array('none' => 'Without Sidebar', 'right' => 'Right', 'left' => 'Left', 'bottom' => 'Bottom'),
        ''
    );
    ?>
    <?php
    $this->select('sidebar_name',
        'Sidebar Name',
		$this->getSideBars(),
        ''
    );
    ?>
    <?php
    $this->text('page_class', 'Extra class', $desc = 'Add extra class for page content', $default = '');
    ?>
    <?php
    $this->select('header_option',
        'Header style',
        array('' => 'Default','onepage'=>'One Page', 'v1' => 'Header Style 1', 'v2' => 'Header Style 2', 'v3' => 'Header Style 3','v4' => 'Header Style 4 - Store Page'),
        ''
    );
    ?>
    <?php
    $this->select('footer_option',
        'Footer style',
        array('' => 'Default', 'footer-2' => 'Footer Store'),
        ''
    );
    ?>
    <?php
    $this->select('theme_style',
        'Theme Style',
        array('' => 'Default', 'dark' => 'Dark', 'light' => 'Light'),
        ''
    );
    ?>
</div>