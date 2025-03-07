<?php
/**
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
                    $post_format = get_post_format();
                    $contents = get_the_content();
                    $str_regux = '';
                    switch ($post_format) {
                        case 'video':
                            $video = getElementByTags('embed', $contents);
                            $str_regux = $video[0];
                            if ($video) {
                                echo apply_filters('the_content', $video[0]);
                            }
                            break;
                        case 'gallery':
                            $gallery = getElementByTags('gallery', $contents, 2);
                            $str_regux = $gallery[0];
                            if ($gallery) {
                                echo apply_filters('the_content', $gallery[0]);
                            }
                            break;
                        default:
                            if($smof_data['featured_images_single']) {
                                the_post_thumbnail();
                            }
                            break;
                    }
                    ?>
                </div>
                <div class="blog-main">
                    <?php if($smof_data['author_info']): ?>
                        <div class="img-blog">
                            <?php echo get_avatar(get_the_author_meta('email'), 90) ?>
                            <div class="icon-blog">
                            <span class="icon">
                                <a href="<?php echo esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename)); ?>"><i
                                        class="fa fa-user"></i></a>
                            </span>
                            <span class="icon">
                                <a href="#"><i class="fa fa-calendar"></i></a>
                            </span>
                            <span class="icon icon-reply">
                                <a href="<?php echo esc_url(get_the_author_meta('user_url')); ?>"><i
                                        class="fa fa-reply-all"></i></a>
                            </span>
                            <span class="icon">
                                <a href="#comments"><i class="fa fa-comment"></i></a>
                            </span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="blog-content" <?php if(!$smof_data['author_info']) echo 'style="margin-left:15px!important"'; ?>>
                        <?php if($smof_data['author_info']): ?>
                            <div class="blog-title-top">
                                <?php the_category(', ') ?>
                            </div>
                        <?php endif; ?>
                        <?php if($smof_data['blog_post_title']): ?>
                            <div class="blog-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title('<h3>', '</h3>'); ?></a>
                            </div>
                        <?php endif; ?>

                        <div class="entry-content">
                            <?php echo apply_filters('the_content', str_replace($str_regux, '', get_the_content())); ?>
                            <?php
                                wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'gmswebdesign') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>'));
                            ?>
                        </div>
                        <?php if($smof_data['post_tags']): ?>
                            <footer class="entry-footer">
                                <?php athlete_entry_footer(); ?>
                            </footer>
                        <?php endif ?>
                        <!-- .entry-footer -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</article><!-- #post-## -->