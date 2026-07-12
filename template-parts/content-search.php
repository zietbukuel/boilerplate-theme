<?php
/**
 * Search Result Content Template
 * 
 * Used to display post content in search results.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'search-result' ); ?>>
    
    <header class="entry-header mb-4">
        <?php
        the_title( 
            sprintf(
                '<h2 class="entry-title text-2xl font-bold"><a href="%s" rel="bookmark">',
                esc_url( get_permalink() )
            ),
            '</a></h2>'
        );
        ?>
        
        <div class="entry-meta text-sm text-gray-500 mt-2">
            <?php boilerplate_post_meta(); ?>
        </div>
    </header><!-- .entry-header -->
    
    <div class="entry-summary prose prose-sm max-w-none text-gray-600">
        <?php
        // Use excerpt for search results, with highlighted search terms
        the_excerpt();
        ?>
    </div><!-- .entry-summary -->
    
    <footer class="entry-footer mt-4">
        <a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more text-primary hover:underline font-medium">
            <?php esc_html_e( 'Read more', 'boilerplate-theme' ); ?>
            <span class="screen-reader-text"> <?php the_title(); ?></span>
        </a>
    </footer><!-- .entry-footer -->
    
</article><!-- #post-<?php the_ID(); ?> -->