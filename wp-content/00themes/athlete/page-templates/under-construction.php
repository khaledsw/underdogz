<?php
/**
 * Template Name: Under Construction
 * This is the template that is used for the contact page, about page ...
 */
global $smof_data, $athlete_cfg;
include(get_template_directory() . '/inc/initvars.php');
?>
    <!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php esc_url(bloginfo('pingback_url')); ?>">
    <?php if ($smof_data['favicon']) { ?>
        <link rel="shortcut icon" href="<?php echo esc_url($smof_data['favicon']); ?>" type="image/x-icon"/>
    <?php } else { ?>
        <link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/favicon.ico"
              type="image/x-icon"/>
    <?php } ?>
    <style>
        .entry-footer {
            display: none;
        }
    </style>
	<?php  
	if($smof_data['gf_body'])
		$gfont[urlencode($smof_data['gf_body'])] = '' . urlencode($smof_data['gf_body']);
	if($smof_data['gf_nav'] && $smof_data['gf_nav'] != '' && $smof_data['gf_nav'] != $smof_data['gf_body'])
		$gfont[urlencode($smof_data['gf_nav'])] = '' . urlencode($smof_data['gf_nav']);
	if($smof_data['f_headings'] && $smof_data['f_headings'] != '' && $smof_data['f_headings'] != $smof_data['gf_body'] && $smof_data['f_headings'] != $smof_data['gf_nav'])
		$gfont[urlencode($smof_data['f_headings'])] = '' . urlencode($smof_data['f_headings']);
	if(isset( $gfont ) && $gfont){
		foreach( $gfont as $g_font ) {
			echo "<link href='http" . ((is_ssl()) ? 's' : '') . "://fonts.googleapis.com/css?family={$g_font}:" . $smof_data['gf_settings'] . "' rel='stylesheet' type='text/css' />";
		}
	}
	?>
    <?php wp_head(); ?>
</head>
<body id="page-top" class="page" data-offset="90" data-target=".navigation" data-spy="scroll">
<div class="wrapper coming-soon">
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('content', 'page'); ?>
    <?php endwhile; // end of the loop. ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
