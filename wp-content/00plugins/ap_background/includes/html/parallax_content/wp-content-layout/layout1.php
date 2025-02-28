
<?php
/**
 * Front end: layout display for type kieu wordpress post
 *
 * @author Inwavethemes
 * @package AP Background
 * @version 1.0.0
 */
?>

<?php while ($query->have_posts()) : $query->the_post(); ?>
    <?php if ($index % $contentSource->content_settings->rows == 0): ?>
        <div class="parallax-col">
        <?php endif; ?>
        <div class="parallax-row in-pos" style="<?php echo ($index % $contentSource->content_settings->rows == 0) ? '' : 'margin-top:' . $contentSource->content_settings->spacing . 'px;'; ?>">
            <?php $images = $bt_utility->getFirstImageFromContent(get_the_content()); ?>
            <?php if ($contentSource->content_settings->show_image && (has_post_thumbnail() || !empty($images))): ?>
                <div class="feature-image">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('featured_image'); ?>
                        <?php else: ?>
                            <?php echo $images; ?>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>
            <div class="post-content-info">
                <?php if ($contentSource->content_settings->show_title): ?>
                    <a href="<?php the_permalink(); ?>">
                        <h3 class="title"><?php the_title(); ?></h3>
                    </a>
                    <hr class="line"/>
                    <div style="clear: both;"></div>
                <?php endif; ?>
                <?php if ($contentSource->content_settings->show_info): ?>
                    <div class="post-info">
                        <?php
                        $post_categories = wp_get_post_categories(get_the_ID());
                        if (!empty($post_categories)) {
                            $cat = get_category($post_categories[0]);
                            echo __('Post in ') . '<span class="link"><a href="' . get_category_link($post_categories[0]) . '">' . $cat->name . '</a></span> ';
                        }
                        echo __('by') . ' <span class="link"><a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . get_the_author_meta('display_name') . '</a></span>';
                        echo ' / <span class="link"><a href="' . get_comments_link() . '">' . get_comments_number(get_the_id()) . ((get_comments_number(get_the_id()) < 2) ? __(' Comment') : __(' Comments')) . '</a></span>';
                        ?>
                    </div>
                <?php endif; ?>
                <?php if ($contentSource->content_settings->show_des): ?>
                    <div class="post-content">
                        <?php
                        echo $bt_utility->truncateString(strip_tags(get_the_excerpt()), $contentSource->content_settings->number_word);
                        ?>
                    </div>
                <?php endif; ?>
                <?php if ($contentSource->content_settings->show_readmore): ?>
                    <div class="link readmore">
                        <a href="<?php the_permalink(); ?>"><?php echo __('Read more'); ?> </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if (($index + 1) % $contentSource->content_settings->rows == 0 || $index == $query->post_count - 1): ?>
        </div>
    <?php endif; ?>
    <?php $index++; ?>
<?php endwhile; ?>
<div style="clear: both;"></div>
<?php
wp_reset_postdata();
