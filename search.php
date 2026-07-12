<?php
/**
 * Search Results Template
 * 
 * Template for displaying search results.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

get_header(); 
?>

<div class="container py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div id="primary" class="content-area <?php echo is_active_sidebar( 'sidebar-1' ) ? 'lg:col-span-8' : 'lg:col-span-12'; ?>">
            <header class="page-header mb-12">
                <h1 class="page-title text-4xl font-bold text-gray-900">
                    <?php
                    printf(
                        esc_html__( 'Search Results for: %s', 'boilerplate-theme' ),
                        '<span class="text-primary">' . get_search_query() . '</span>'
                    );
                    ?>
                </h1>
            </header><!-- .page-header -->

            <main id="main" class="site-main" role="main">
                <?php
                if ( have_posts() ) :
                    ?>
                    <div class="search-results space-y-8">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            get_template_part( 'template-parts/content', 'search' );
                        endwhile;
                        ?>
                    </div><!-- .search-results -->

                    <?php
                    boilerplate_the_posts_navigation();
                    
                else :
                    
                    get_template_part( 'template-parts/content', 'none' );
                    
                endif; 
                ?>
            </main><!-- #main -->
        </div><!-- #primary -->

        <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
            <div class="sidebar-area lg:col-span-4">
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>

    </div><!-- .grid -->
</div><!-- .container -->

<?php
get_footer();