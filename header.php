<?php
/**
 * Boilerplate Theme - Header Template
 * 
 * The header template contains the opening HTML tags, the <head> section,
 * and the opening <body> tag with the site header navigation.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- 
        wp_head() is a critical hook that must be included in all themes.
        It allows WordPress and plugins to inject scripts, styles, meta tags,
        and other necessary code into the <head> section.
        Never remove this hook!
    -->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
    /**
     * wp_body_open() is a hook that fires immediately after the opening <body> tag.
     * It's used by plugins and themes to insert code right after the body tag opens.
     * This is where you'd typically add Google Tag Manager noscript, skip links, etc.
     */
    wp_body_open(); 
    ?>

    <!-- 
        Skip to main content link for accessibility.
        This allows keyboard users to bypass navigation and jump straight to content.
        It's hidden visually but becomes visible on focus.
    -->
    <a class="skip-link screen-reader-text" href="#primary">
        <?php esc_html_e( 'Skip to main content', 'boilerplate-theme' ); ?>
    </a>

    <header id="masthead" class="site-header" role="banner">
        <div class="container">
            <div class="site-header__inner flex items-center justify-between gap-4 py-4">
                
                <!-- Site Branding / Logo -->
                <div class="site-branding flex-shrink-0">
                    <?php
                    /**
                     * Display the custom logo if set in Customizer.
                     * the_custom_logo() outputs the logo markup automatically.
                     * Falls back to site title/description if no logo is set.
                     */
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                    } else {
                        // Fallback: Site Title & Description
                        ?>
                        <div class="site-title-wrapper">
                            <?php if ( is_front_page() && ! is_paged() ) : ?>
                                <h1 class="site-title">
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                        <?php bloginfo( 'name' ); ?>
                                    </a>
                                </h1>
                            <?php else : ?>
                                <p class="site-title">
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                        <?php bloginfo( 'name' ); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            
                            <?php
                            $description = get_bloginfo( 'description', 'display' );
                            if ( $description || is_customize_preview() ) :
                            ?>
                                <p class="site-description"><?php echo $description; ?></p>
                            <?php endif; ?>
                        </div>
                        <?php
                    }
                    ?>
                </div><!-- .site-branding -->

                <!-- Primary Navigation -->
                <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'boilerplate-theme' ); ?>">
                    <?php
                    /**
                     * Display the primary navigation menu.
                     * wp_nav_menu() generates the menu markup based on the menu assigned
                     * to the 'primary' theme location in Appearance > Menus.
                     * 
                     * The walker class allows for custom HTML structure (e.g., BEM classes,
                     * accessibility attributes, dropdown indicators).
                     */
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'primary',
                            'menu_id'         => 'primary-menu',
                            'menu_class'      => 'nav-menu flex items-center gap-1',
                            'container'       => false,
                            'fallback_cb'     => 'boilerplate_fallback_menu',
                            'walker'          => new Boilerplate_Nav_Walker(),
                        )
                    );
                    ?>
                </nav><!-- #site-navigation -->

                <!-- Mobile Menu Toggle Button -->
                <button 
                    class="mobile-menu-toggle lg:hidden flex items-center justify-center p-2 rounded-md bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-primary"
                    aria-expanded="false" 
                    aria-controls="site-navigation"
                    aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'boilerplate-theme' ); ?>"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

            </div><!-- .site-header__inner -->
        </div><!-- .container -->
    </header><!-- #masthead -->

    <?php
    /**
     * Hook fired after the header is rendered.
     * Useful for injecting content between header and main content,
     * such as hero sections, breadcrumbs, or page headers.
     */
    do_action( 'boilerplate_after_header' );
    ?>