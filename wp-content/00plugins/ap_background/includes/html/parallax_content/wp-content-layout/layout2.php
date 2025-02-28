<?php
/**
 * Front end: layout display for type wordpress post
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
        <div class="parallax-row in-pos" <?php echo ($index % $contentSource->content_settings->rows == 0) ? '' : 'style="margin-top:' . $contentSource->content_settings->spacing . 'px;"'; ?>>
            <?php $images = $bt_utility->getFirstImageFromContent(get_the_content());?>
            <?php if ($contentSource->content_settings->show_image  && (has_post_thumbnail()||!empty($images))): ?>
                <div class="feature-image" style="width:<?php echo $contentSource->content_settings->item_height; ?>px; height:<?php echo $contentSource->content_settings->item_height; ?>px;">
                    <a href="<?php the_permalink(); ?>">
                        <?php if(has_post_thumbnail()):?>
                        <?php the_post_thumbnail('thumbnail'); ?>
                        <?php else:?>
                        <?php echo $images;?>
                        <?php endif;?>
                    </a>
                </div>
            <?php endif; ?>
            <div class="post-content-info" style="width:<?php echo $contentSource->content_settings->item_width - $contentSource->content_settings->item_height - 20; ?>px;">
                <?php if ($contentSource->content_settings->show_title): ?>
                    <a href="<?php the_permalink(); ?>">
                        <h3 class="title"><?php the_title(); ?></h3>
                    </a>
                    <div style="clear: both;"></div>
                <?php endif; ?>
                <?php if ($contentSource->content_settings->show_info): ?>
                    <div class="post-info">
                        <?php
                        echo '<span class="icon"><i class="fa fa-calendar"></i> ' . get_the_date('d, F') . '</span>';
                        echo '<span class="icon suffix"><i class="fa ' . ((get_comments_number(get_the_id()) < 2) ? 'fa-comment' : 'fa-comments') . '"></i> ' . get_comments_number(get_the_id()) . ((get_comments_number(get_the_id()) < 2) ? __(' comment') : __(' comments')) . '</span>';
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
                        <a href="<?php the_permalink(); ?>"><?php echo __('Read more '); ?><i class="fa fa-chevron-circle-right"></i> </a>
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
