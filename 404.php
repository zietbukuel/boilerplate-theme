<?php
/**
 * 404 Template
 * 
 * Template for displaying 404 pages (page not found).
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

get_header(); 
?>

<main id="primary" class="site-main" role="main">
    <div class="container">
        <section class="error-404 not-found py-20 text-center">
            <header class="page-header mb-8">
                <h1 class="page-title text-6xl font-bold text-gray-900">404</h1>
                <h2 class="screen-reader-text"><?php esc_html_e( 'Page Not Found', 'boilerplate-theme' ); ?></h2>
            </header><!-- .page-header -->

            <div class="page-content max-w-md mx-auto">
                <p class="text-xl text-gray-600 mb-8">
                    <?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'boilerplate-theme' ); ?>
                </p>

                <p class="text-gray-500 mb-8">
                    <?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'boilerplate-theme' ); ?>
                </p>

                <?php get_search_form(); ?>

                <div class="mt-12 pt-8 border-t border-gray-200">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                        <?php esc_html_e( 'Go Home', 'boilerplate-theme' ); ?>
                    </a>
                </div>
            </div><!-- .page-content -->
        </section><!-- .error-404 -->
    </div>
</main><!-- #main -->

<?php
get_footer();