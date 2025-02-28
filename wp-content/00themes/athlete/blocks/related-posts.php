<div class="related-post-title">
    <h5><?php echo __('Related Post', 'inwavethemes'); ?></h5>
</div>
<div class="related-post-content">
    <?php
    $orig_post = $post;
    global $post;
    $tags = wp_get_post_tags($post->ID);
    if ($tags) {
        $tag_ids = array();
        foreach ($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
        $args = array(
            'tag__in' => $tag_ids,
            'post__not_in' => array($post->ID),
            'posts_per_page' => 4, // Number of related posts to display.
            'ignore_sticky_posts' => 1
        );

        $my_query = new wp_query($args);

        while ($my_query->have_posts()) {
            $my_query->the_post();
            ?>
            <div class="related-post-list">
            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
            </div>
        <?php }
    }
    $post = $orig_post;
    wp_reset_query();
    ?>
</div>
