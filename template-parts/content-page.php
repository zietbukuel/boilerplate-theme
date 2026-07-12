<?php
/**
 * Page Content Template
 * 
 * Used to display page content.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-content' ); ?>>
    
    <header class="entry-header mb-8">
        <?php
        the_title( '<h1 class="entry-title text-4xl font-bold text-gray-900">', '</h1>' );
        ?>
    </header><!-- .entry-header -->
    
    <div class="entry-content prose prose-lg max-w-none">
        <?php
        the_content();
        
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
        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Edit <span class="screen-reader-text">%s</span>', 'boilerplate-theme' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
        ?>
    </footer><!-- .entry-footer -->
    
</article><!-- #post-<?php the_ID(); ?> -->