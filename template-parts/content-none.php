<?php
/**
 * No Posts Found Template
 * 
 * Displayed when no posts match the current query.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>

<section class="no-results not-found py-16 text-center">
    <div class="container">
        <header class="page-header mb-8">
            <h1 class="page-title text-3xl font-bold text-gray-900">
                <?php esc_html_e( 'Nothing Found', 'boilerplate-theme' ); ?>
            </h1>
        </header><!-- .page-header -->
        
        <div class="page-content">
            <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
                
                <p class="text-lg text-gray-600 mb-6">
                    <?php
                    printf(
                        wp_kses(
                            __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'boilerplate-theme' ),
                            array(
                                'a' => array(
                                    'href' => array(),
                                ),
                            )
                        ),
                        esc_url( admin_url( 'post-new.php' ) )
                    );
                    ?>
                </p>
                
            <?php elseif ( is_search() ) : ?>
                
                <p class="text-lg text-gray-600 mb-6">
                    <?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'boilerplate-theme' ); ?>
                </p>
                
                <?php get_search_form(); ?>
                
            <?php else : ?>
                
                <p class="text-lg text-gray-600 mb-6">
                    <?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'boilerplate-theme' ); ?>
                </p>
                
                <?php get_search_form(); ?>
                
            <?php endif; ?>
        </div><!-- .page-content -->
    </div>
</section><!-- .no-results -->