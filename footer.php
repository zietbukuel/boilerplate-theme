<?php
/**
 * Boilerplate Theme - Footer Template
 * 
 * The footer template closes the main content area, displays the site footer,
 * and closes the HTML document with wp_footer() hook.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

?>
    <!-- 
        Hook fired before the footer.
        Useful for injecting content between main content and footer.
    -->
    <?php do_action( 'boilerplate_before_footer' ); ?>

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="container">
            <div class="site-footer__inner">
                
                <!-- Footer Widget Areas -->
                <div class="footer-widgets grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 py-12">
                    <?php
                    /**
                     * Display footer widget areas if they have active widgets.
                     * We register 4 footer widget areas in functions.php.
                     */
                    for ( $i = 1; $i <= 4; $i++ ) :
                        if ( is_active_sidebar( 'footer-' . $i ) ) :
                    ?>
                            <div class="footer-widget-area footer-<?php echo esc_attr( $i ); ?>">
                                <?php dynamic_sidebar( 'footer-' . $i ); ?>
                            </div>
                    <?php
                        endif;
                    endfor;
                    ?>
                </div><!-- .footer-widgets -->

                <!-- Footer Bottom -->
                <div class="site-footer__bottom border-t border-gray-200 py-6">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        
                        <!-- Copyright -->
                        <div class="site-copyright text-sm text-gray-600 text-center md:text-left">
                            <?php
                            /**
                             * Filter the copyright text to allow child themes/plugins to modify it.
                             */
                            $copyright_text = sprintf(
                                /* translators: %s: Site title */
                                esc_html__( '&copy; %s All rights reserved.', 'boilerplate-theme' ),
                                '<a href="' . esc_url( home_url( '/' ) ) . '" class="hover:underline">' . get_bloginfo( 'name' ) . '</a>'
                            );
                            echo wp_kses_post( apply_filters( 'boilerplate_copyright_text', $copyright_text ) );
                            ?>
                        </div>

                        <!-- Footer Navigation -->
                        <nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'boilerplate-theme' ); ?>">
                            <?php
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'footer',
                                    'menu_class'     => 'footer-menu flex flex-wrap justify-center md:justify-end gap-4',
                                    'container'      => false,
                                    'fallback_cb'    => false,
                                    'depth'          => 1,
                                )
                            );
                            ?>
                        </nav>

                        <!-- Social Links / Credits -->
                        <div class="site-credits text-sm text-gray-500 text-center md:text-right">
                            <?php
                            /**
                             * Filter for developer credits.
                             * Allows child themes to add attribution.
                             */
                            $credits = sprintf(
                                /* translators: %s: Theme name */
                                esc_html__( 'Powered by %s', 'boilerplate-theme' ),
                                '<a href="https://wordpress.org/" target="_blank" rel="noopener noreferrer" class="hover:underline">WordPress</a> & ' .
                                '<a href="https://example.com/boilerplate-theme" target="_blank" rel="noopener noreferrer" class="hover:underline">Boilerplate Theme</a>'
                            );
                            echo wp_kses_post( apply_filters( 'boilerplate_footer_credits', $credits ) );
                            ?>
                        </div>

                    </div>
                </div><!-- .site-footer__bottom -->

            </div><!-- .site-footer__inner -->
        </div><!-- .container -->
    </footer><!-- #colophon -->

    <?php
    /**
     * Hook fired after the footer.
     * Useful for injecting scripts or content after footer but before body close.
     */
    do_action( 'boilerplate_after_footer' );
    
    /**
     * wp_footer() is a critical hook that must be included before the closing </body> tag.
     * It allows WordPress and plugins to inject JavaScript, admin bar, and other footer scripts.
     * Never remove this hook!
     */
    wp_footer(); 
    ?>
</body>
</html>