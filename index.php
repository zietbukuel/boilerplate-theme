<?php
/**
 * Boilerplate Theme - Main Index Template
 * 
 * The main template file. It is used to display a page when nothing more specific
 * matches a query. For example, it puts together the home page when no home.php
 * file exists. It is also used as a fallback for archive, search, and other pages.
 * 
 * Template Hierarchy:
 * https://developer.wordpress.org/themes/basics/template-hierarchy/
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
                /**
                 * Hook fired before the main loop.
                 * Useful for injecting content before the post loop.
                 */
                do_action( 'boilerplate_before_main_loop' );
                ?>

                <?php if ( have_posts() ) : ?>

                    <?php
                    /**
                     * Hook fired before the loop starts.
                     * Useful for injecting markup before the first post.
                     */
                    do_action( 'boilerplate_loop_start' );
                    ?>

                    <?php
                    /* Start the Loop */
                    while ( have_posts() ) :
                        the_post();

                        /*
                         * Include the Post Type specific template for the content.
                         * If you want to override this in a child theme, include a file
                         * called content-___.php (where ___ is the Post Type name) and 
                         * that will be used instead.
                         */
                        get_template_part( 'template-parts/content', get_post_type() );

                    endwhile;
                    ?>

                    <?php
                    /**
                     * Hook fired after the loop ends.
                     * Useful for injecting markup after the last post.
                     */
                    do_action( 'boilerplate_loop_end' );
                    ?>

                    <?php
                    /**
                     * Display pagination for archive pages.
                     * boilerplate_the_posts_navigation() is defined in inc/template-tags.php
                     */
                    boilerplate_the_posts_navigation();
                    ?>

                <?php else : ?>

                    <?php
                    /**
                     * Hook fired when no posts are found.
                     * Useful for customizing the "no results" message.
                     */
                    do_action( 'boilerplate_no_posts_found' );
                    ?>

                    <?php
                    /*
                     * If no content, include the "No posts found" template.
                     * This template is located in template-parts/content-none.php
                     */
                    get_template_part( 'template-parts/content', 'none' );
                    ?>

                <?php endif; ?>

                <?php
                /**
                 * Hook fired after the main loop.
                 * Useful for injecting content after the post loop.
                 */
                do_action( 'boilerplate_after_main_loop' );
                ?>

            </main><!-- #main -->
        </div><!-- #primary -->

        <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
            <div class="sidebar-area lg:col-span-4">
                <?php
                /**
                 * Hook fired after main content but before sidebar.
                 * Useful for sidebars or additional content areas.
                 */
                do_action( 'boilerplate_before_sidebar' );
                ?>
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>

    </div><!-- .grid -->
</div><!-- .container -->

<?php
get_footer();