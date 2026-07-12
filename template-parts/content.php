<?php
/**
 * Default Post Content Template
 * 
 * Used to display post content when no post-type-specific template exists.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-content' ); ?>>
    
    <header class="entry-header mb-8">
        <?php
        if ( is_singular() ) {
            the_title( '<h1 class="entry-title text-4xl font-bold text-gray-900">', '</h1>' );
        } else {
            the_title( '<h2 class="entry-title text-2xl font-bold"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        }
        ?>
        
        <?php boilerplate_post_meta(); ?>
    </header><!-- .entry-header -->
    
    <div class="entry-content prose prose-lg max-w-none">
        <?php
        the_content(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'boilerplate-theme' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            )
        );
        
        wp_link_pages(
            array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'boilerplate-theme' ),
                'after'  => '</div>',
            )
        );
        ?>
    </div><!-- .entry-content -->
    
    <footer class="entry-footer mt-8 pt-8 border-t border-gray-200">
        <?php
        // Categories and tags
        $categories = get_the_category();
        $tags       = get_the_tags();
        
        if ( $categories ) {
            echo '<div class="entry-categories mb-3">';
            echo '<span class="font-medium text-gray-700">' . esc_html__( 'Categories:', 'boilerplate-theme' ) . '</span> ';
            $cat_links = array();
            foreach ( $categories as $category ) {
                $cat_links[] = '<a href="' . esc_url( get_category_link( $category ) ) . '" class="text-primary hover:underline">' . esc_html( $category->name ) . '</a>';
            }
            echo implode( ', ', $cat_links );
            echo '</div>';
        }
        
        if ( $tags ) {
            echo '<div class="entry-tags">';
            echo '<span class="font-medium text-gray-700">' . esc_html__( 'Tags:', 'boilerplate-theme' ) . '</span> ';
            $tag_links = array();
            foreach ( $tags as $tag ) {
                $tag_links[] = '<a href="' . esc_url( get_tag_link( $tag ) ) . '" class="text-primary hover:underline">' . esc_html( $tag->name ) . '</a>';
            }
            echo implode( ', ', $tag_links );
            echo '</div>';
        }
        ?>
    </footer><!-- .entry-footer -->
    
</article><!-- #post-<?php the_ID(); ?> -->