<?php
/**
 * The default template for displaying content link
 * @package athlete
 */
global $authordata,$smof_data;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="blog-page">
        <div class="blog-listing">
            <div class="blog-item">
                <div class="img-blog">
                    <?php 
                    $contents = get_the_content();
                    $video = getElementByTags('embed', $contents);
                    if($video){
                        echo apply_filters('the_content', $video[0]);
                    }
                    ?>
                </div>
                <div class="blog-main">
                    <?php if($smof_data['author_info_listing']): ?>
                    <div class="img-blog">
                        <?php echo get_avatar(get_the_author_meta('email'), 90) ?>
                    </div>
                    <?php endif; ?>
                    <div class="blog-content">
                    <div class="blog-header">
                        <?php if($smof_data['blog_category_title_listing']): ?>
                        <div class="blog-title-top">
                            <?php the_category(', ') ?>
                        </div>
                        <?php endif; ?>
                        <div class="blog-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title('', ''); ?></a>
                        </div>
						<?php if($smof_data['blog_show_date']): ?>
							<div class="blog-date">
							<?php echo get_the_date(); ?>
							</div>
						<?php endif; ?>
                        </div>
                        <div class="blog-text">
                            <?php /* translators: %s: Name of current post */
                            if(!$video) {
                                the_content(sprintf(
                                    __('Continue reading %s <span class="meta-nav">&rarr;</span>', 'inwavethemes'),
                                    the_title('<span class="screen-reader-text">', '</span>', false)
                                ));
                            }else{
                                the_excerpt();
                            }

                            wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'inwavethemes' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                            ?>
                        </div>

                    </div>
                </div>
                <!--
                <footer class="entry-footer">
                    <?php athlete_entry_footer(); ?>
                </footer>
                 .entry-footer -->
            </div>
        </div>
    </div>
</article><!-- #post-## -->