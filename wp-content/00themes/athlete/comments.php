<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package athlete
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments">

    <div class="comments-title">
        <h5><?php echo __('Comments', 'inwavethemes') ?></h5>
    </div>
    <div class="comments-content">

        <?php if (have_comments()) : ?>

            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
                <nav id="comment-nav-above" class="comment-navigation" role="navigation">
                    <div
                        class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'inwavethemes')); ?></div>
                    <div
                        class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'inwavethemes')); ?></div>
                </nav><!-- #comment-nav-above -->
            <?php endif; // check for comment navigation ?>
            <ul>
            <?php
            wp_list_comments(array(
                'callback' => 'athlete_comment',
                'short_ping' => true,
            ));
            ?>
            </ul>
            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
                <nav id="comment-nav-bellow" class="comment-navigation" role="navigation">
                <div
                    class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'inwavethemes')); ?></div>
                <div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'inwavethemes')); ?></div>
                </nav><!-- #comment-nav-below -->
            <?php endif; // check for comment navigation ?>

        <?php endif; // have_comments() ?>

        <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (!comments_open() && '0' != get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
            ?>
            <p class="no-comments"><?php _e('Comments are closed.', 'inwavethemes'); ?></p>
        <?php endif; ?>
        <div class="form-comment">
        <?php comment_form(array(
            $fields = array(
                'author' => '<input id="author" class="input-text" name="author" placeholder="' . __( 'Name' ,'inwavethemes') .'" type="text" value="" size="30" />' ,
                'email'  => '<input id="email" class="input-text" name="email" placeholder="' . __( 'Email' ,'inwavethemes') .'" type="email" value="" size="30" />',
                'url'    => '<input id="url" class="input-text" name="url" placeholder="' . __( 'Website' ,'inwavethemes') .'" type="url" value="" size="30" />',
            ),

        'fields'                => apply_filters( 'comment_form_default_fields', $fields ),
            'comment_field'        => '<div class="message"><textarea id="comment" class="control" placeholder="'._x( 'Comment', 'noun' ).'" name="comment" cols="45" rows="8" aria-describedby="form-allowed-tags" aria-required="true"></textarea></div>',
            'class_submit' => 'btn-submit'
    )); ?>
        </div>
    </div>
    <!-- #comments -->
</div><!-- #comments -->
