<?php
/**
 * The default template for displaying content link
 * @package athlete
 */
global $authordata;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="blog-page quote-article">
        <div class="blog-item">
            <div class="img-blog">
                <?php the_post_thumbnail(); ?>
            </div>
            <div class="parallax-background-overlay"></div>
            <div class="blog-main">
                <div class="quote-blog-content">
                    <div class="quote-char"><i class="fa fa-quote-left fa-2x"></i></div>
                    <div class="quote-text">
                        <?php
                        $quote = getElementByTags('blockquote', get_the_content(), 3);
                        $text = $quote[2];
                        $text = ltrim($text, '"');
                        $text = rtrim($text, '"');
                        echo '<a href="' . get_the_permalink() . '">' . $text . '</a>';
                        ?>
                    </div>
                    <div class="img-blog-author">
                        <?php echo get_avatar(get_the_author_meta('email'), 90) ?>
                    </div>
                    <div class="name-blog-author">
                        <?php the_author(); ?>
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
</article><!-- #post-## -->