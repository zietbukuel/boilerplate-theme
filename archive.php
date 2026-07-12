<?php
/**
 * Archive Template
 * 
 * Template for displaying archive pages (category, tag, date, author, etc.).
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
                <?php
                the_archive_title( '<h1 class="page-title text-4xl font-bold text-gray-900">', '</h1>' );
                the_archive_description( '<div class="archive-description mt-4 text-lg text-gray-600">', '</div>' );
                ?>
            </header><!-- .page-header -->

            <main id="main" class="site-main" role="main">
                <?php
                if ( have_posts() ) :
                    ?>
                    <div class="posts-grid grid grid-cols-1 md:grid-cols-2 gap-8">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            get_template_part( 'template-parts/content', get_post_type() );
                        endwhile;
                        ?>
                    </div><!-- .posts-grid -->

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