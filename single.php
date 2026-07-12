<?php
/**
 * Single Post Template
 * 
 * Template for displaying single posts.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

get_header(); 
?>

<div class="container py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div id="primary" class="content-area <?php echo is_active_sidebar( 'sidebar-1' ) ? 'lg:col-span-8' : 'lg:col-span-12'; ?>">
            <main id="main" class="site-main" role="main">

                <?php
                while ( have_posts() ) :
                    the_post();

                    get_template_part( 'template-parts/content', get_post_type() );

                    /**
                     * Post navigation for single posts.
                     */
                    boilerplate_the_post_navigation();

                    /**
                     * Display author bio if enabled.
                     */
                    boilerplate_post_author_bio();

                    /**
                     * Comments template.
                     * Only loads on single posts with comments open or existing comments.
                     */
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }

                endwhile; 
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