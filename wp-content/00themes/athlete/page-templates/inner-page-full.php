<?php
/**
 * Template Name: Inner Page (Full width)
 * This is the template that is used for the contact page, about page ...
 */
get_header();
?>
<?php if ($athlete_cfg['slide-id']) { ?>
    <div class="container">
        <div class="slider-container">
            <?php masterslider($athlete_cfg['slide-id']); ?>
        </div>
    </div>
<?php } ?>
<section class="page-heading">
	<div class="title-slide">
		<div class="container">
				<div class="banner-content slide-container">									
					<div class="page-title">
                        <?php if($athlete_cfg['show-pageheading']){ ?>
                            <?php the_title('<h3>','</h3>') ?>
                        <?php } ?>
					</div>
				</div>
		</div>
	</div>
</section>
<div class="page-content inner-page-full">
    <?php include(get_template_directory().'/blocks/breadcrumb.php'); ?>

    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('content', 'page'); ?>
    <?php endwhile; // end of the loop. ?>
</div>
<?php get_footer(); ?>
