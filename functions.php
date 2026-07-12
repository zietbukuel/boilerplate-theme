<?php
/**
 * Boilerplate Theme - Functions.php
 * 
 * The main engine of the theme. This file sets up theme supports, enqueues scripts/styles,
 * registers menus, sidebars, image sizes, and includes modular files from the inc/ directory.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

// Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * =============================================================================
 * THEME CONSTANTS & SETUP
 * =============================================================================
 */

/** Define theme version for cache busting */
define( 'BOILERPLATE_THEME_VERSION', '1.0.0' );

/** Define theme text domain for translations */
define( 'BOILERPLATE_THEME_TEXTDOMAIN', 'boilerplate-theme' );

/** Define theme directory URI */
define( 'BOILERPLATE_THEME_URI', get_template_directory_uri() );

/** Define theme directory path */
define( 'BOILERPLATE_THEME_DIR', get_template_directory() );

/** Define theme includes directory */
define( 'BOILERPLATE_THEME_INC', BOILERPLATE_THEME_DIR . '/inc' );

/** Define theme blocks directory */
define( 'BOILERPLATE_THEME_BLOCKS', BOILERPLATE_THEME_DIR . '/blocks' );

/** Define theme template parts directory */
define( 'BOILERPLATE_THEME_TEMPLATE_PARTS', BOILERPLATE_THEME_DIR . '/template-parts' );

/**
 * =============================================================================
 * THEME SETUP - Runs after theme is loaded
 * =============================================================================
 */
function boilerplate_theme_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Boilerplate Theme, use a find and replace
     * to change 'boilerplate-theme' to the name of your theme in all the template files.
     */
    load_theme_textdomain( BOILERPLATE_THEME_TEXTDOMAIN, get_template_directory() . '/languages' );

    /*
     * Add default posts and comments RSS feed links to head.
     * This adds <link rel="alternate" type="application/rss+xml" ...> to <head>
     */
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     * This enables the Featured Image meta box in the editor.
     */
    add_theme_support( 'post-thumbnails' );

    /*
     * Enable support for HTML5 markup in search forms, comment forms,
     * comment lists, gallery, caption, and style/script elements.
     * This outputs modern HTML5 markup instead of XHTML.
     */
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    /*
     * Enable support for Post Formats.
     * Enables the Post Format meta box in the editor.
     */
    add_theme_support( 'post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio',
    ) );

    /*
     * Enable support for responsive embeds.
     * This adds wrapper divs around embeds for responsive sizing.
     */
    add_theme_support( 'responsive-embeds' );

    /*
     * Enable support for custom logo.
     * Allows users to upload a custom logo in Customizer > Site Identity.
     */
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'unlink-homepage-logo' => true,
    ) );

    /*
     * Enable support for custom background.
     * Allows users to set a custom background image/color in Customizer.
     */
    add_theme_support( 'custom-background', array(
        'default-color' => 'f8fafc',
        'default-image' => '',
    ) );

    /*
     * Enable support for selective refresh for widgets in Customizer.
     * Provides live preview when editing widgets.
     */
    add_theme_support( 'customize-selective-refresh-widgets' );

    /*
     * Enable support for wide and full-width alignment.
     * Allows blocks to have "wide" and "full-width" alignment options.
     */
    add_theme_support( 'align-wide' );

    /*
     * Enable support for editor styles.
     * Allows the theme to provide styles for the block editor.
     */
    add_theme_support( 'editor-styles' );
    
    /*
     * Add editor stylesheets for the block editor.
     * This styles both custom blocks and fallback patterns inside the editor iframe.
     */
    add_editor_style( array(
        'assets/css/editor-style.css',
        'build/style-hero-section.css',
        'build/style-feature-grid.css',
    ) );

    /*
     * Enable support for block styles.
     * Allows registering custom block styles.
     */
    add_theme_support( 'wp-block-styles' );

    /*
     * Enable support for custom line height.
     * Adds line-height controls to text blocks.
     */
    add_theme_support( 'custom-line-height' );

    /*
     * Enable support for custom spacing.
     * Adds padding/margin controls to blocks.
     */
    add_theme_support( 'custom-spacing' );

    /*
     * Enable support for custom units.
     * Allows using rem, em, px, %, vh, vw units.
     */
    add_theme_support( 'custom-units' );

    /*
     * Enable support for experimental link color.
     * Allows custom link colors in blocks.
     */
    add_theme_support( 'experimental-link-color' );

    /*
     * Register navigation menus.
     * These appear in Appearance > Menus for assignment.
     */
    register_nav_menus( array(
        'primary'  => esc_html__( 'Primary Menu', 'boilerplate-theme' ),
        'footer'   => esc_html__( 'Footer Menu', 'boilerplate-theme' ),
        'social'   => esc_html__( 'Social Links Menu', 'boilerplate-theme' ),
    ) );

    /*
     * Register image sizes.
     * These are generated when images are uploaded.
     * Use the_post_thumbnail( 'size-name' ) to output.
     * 
     * Note: Use add_image_size() sparingly as each size generates additional files.
     * Consider using CSS aspect-ratio and object-fit instead for flexible layouts.
     */
    add_image_size( 'boilerplate-hero', 1920, 1080, true );      // Hero banner - hard crop
    add_image_size( 'boilerplate-card', 600, 400, true );        // Card layout - hard crop
    add_image_size( 'boilerplate-feature', 800, 600, false );    // Feature grid - soft crop
    add_image_size( 'boilerplate-thumbnail-square', 300, 300, true ); // Square thumbnails
}

/**
 * Hook theme setup to after_setup_theme.
 * Priority 10 (default) ensures it runs after parent theme setup in child themes.
 */
add_action( 'after_setup_theme', 'boilerplate_theme_setup' );

/**
 * =============================================================================
 * CONTENT WIDTH
 * =============================================================================
 */
/**
 * Set the content width in pixels.
 * This limits the maximum width of embedded content (oEmbeds, images, etc.)
 * in the content area.
 */
$GLOBALS['content_width'] = apply_filters( 'boilerplate_content_width', 1200 );

/**
 * =============================================================================
 * SCRIPT & STYLE ENQUEUEING
 * =============================================================================
 */
function boilerplate_enqueue_assets() {
    /*
     * Enqueue the main stylesheet.
     * Using get_stylesheet_uri() gets the current theme's style.css
     * Version is set to theme version for cache busting.
     */
    wp_enqueue_style(
        'boilerplate-style',
        get_stylesheet_uri(),
        array(),
        BOILERPLATE_THEME_VERSION
    );

    /*
     * Enqueue the main JavaScript file.
     * - Dependencies: loaded from Webpack asset definition
     * - Version: versioned dynamically from Webpack asset definition for cache busting
     * - In footer: true (loads before </body>)
     */
    $main_asset = file_exists( BOILERPLATE_THEME_DIR . '/build/main.asset.php' )
        ? include BOILERPLATE_THEME_DIR . '/build/main.asset.php'
        : array( 'dependencies' => array(), 'version' => BOILERPLATE_THEME_VERSION );

    wp_enqueue_script(
        'boilerplate-main',
        BOILERPLATE_THEME_URI . '/build/main.js',
        $main_asset['dependencies'],
        $main_asset['version'],
        true
    );

    /*
     * Localize script for passing PHP data to JavaScript.
     * This makes the 'boilerplateData' object available in JS.
     */
    wp_localize_script( 'boilerplate-main', 'boilerplateData', array(
        'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
        'nonce'         => wp_create_nonce( 'boilerplate_nonce' ),
        'siteUrl'       => home_url( '/' ),
        'themeUri'      => BOILERPLATE_THEME_URI,
        'isRTL'         => is_rtl(),
        'breakpoints'   => array(
            'sm'  => 640,
            'md'  => 768,
            'lg'  => 1024,
            'xl'  => 1280,
            '2xl' => 1536,
        ),
    ) );

    /*
     * Conditionally enqueue comment-reply script for threaded comments.
     * Only loads on singular pages with comments open and threaded comments enabled.
     */
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    /*
     * Deregister jQuery if not needed (modern themes often don't need it).
     * Uncomment if you're not using jQuery:
     * wp_deregister_script( 'jquery' );
     */

    /*
     * Register block-specific stylesheets so they can be enqueued by handle.
     */
    $hero_asset = file_exists( BOILERPLATE_THEME_DIR . '/build/hero-section.asset.php' )
        ? include BOILERPLATE_THEME_DIR . '/build/hero-section.asset.php'
        : array( 'version' => BOILERPLATE_THEME_VERSION );

    wp_register_style(
        'boilerplate-block-hero-section',
        BOILERPLATE_THEME_URI . '/build/style-hero-section.css',
        array(),
        $hero_asset['version']
    );

    $feature_asset = file_exists( BOILERPLATE_THEME_DIR . '/build/feature-grid.asset.php' )
        ? include BOILERPLATE_THEME_DIR . '/build/feature-grid.asset.php'
        : array( 'version' => BOILERPLATE_THEME_VERSION );

    wp_register_style(
        'boilerplate-block-feature-grid',
        BOILERPLATE_THEME_URI . '/build/style-feature-grid.css',
        array(),
        $feature_asset['version']
    );

    /*
     * Enqueue block stylesheets globally on the frontend.
     */
    wp_enqueue_style( 'boilerplate-block-hero-section' );
    wp_enqueue_style( 'boilerplate-block-feature-grid' );
}

/**
 * Hook asset enqueueing to wp_enqueue_scripts.
 * This is the proper hook for frontend scripts and styles.
 */
add_action( 'wp_enqueue_scripts', 'boilerplate_enqueue_assets' );

/**
 * =============================================================================
 * BLOCK EDITOR SUPPORT
 * =============================================================================
 */
function boilerplate_block_editor_assets() {
    /*
     * Enqueue native block scripts.
     */
    $hero_asset = file_exists( BOILERPLATE_THEME_DIR . '/build/hero-section.asset.php' )
        ? include BOILERPLATE_THEME_DIR . '/build/hero-section.asset.php'
        : array( 'dependencies' => array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-block-editor', 'wp-i18n' ), 'version' => BOILERPLATE_THEME_VERSION );

    wp_enqueue_script(
        'boilerplate-block-hero-section',
        BOILERPLATE_THEME_URI . '/build/hero-section.js',
        $hero_asset['dependencies'],
        $hero_asset['version'],
        true
    );

    $feature_asset = file_exists( BOILERPLATE_THEME_DIR . '/build/feature-grid.asset.php' )
        ? include BOILERPLATE_THEME_DIR . '/build/feature-grid.asset.php'
        : array( 'dependencies' => array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-block-editor', 'wp-i18n' ), 'version' => BOILERPLATE_THEME_VERSION );

    wp_enqueue_script(
        'boilerplate-block-feature-grid',
        BOILERPLATE_THEME_URI . '/build/feature-grid.js',
        $feature_asset['dependencies'],
        $feature_asset['version'],
        true
    );

    /*
     * Enqueue editor scripts.
     * For editor enhancements or utility functions.
     */
    $editor_asset = file_exists( BOILERPLATE_THEME_DIR . '/build/editor.asset.php' )
        ? include BOILERPLATE_THEME_DIR . '/build/editor.asset.php'
        : array( 'dependencies' => array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-i18n' ), 'version' => BOILERPLATE_THEME_VERSION );

    wp_enqueue_script(
        'boilerplate-editor-script',
        BOILERPLATE_THEME_URI . '/build/editor.js',
        $editor_asset['dependencies'],
        $editor_asset['version'],
        true
    );
}

/**
 * Hook block editor assets to enqueue_block_editor_assets.
 */
add_action( 'enqueue_block_editor_assets', 'boilerplate_block_editor_assets' );

/**
 * =============================================================================
 * WIDGET AREAS / SIDEBARS
 * =============================================================================
 */
function boilerplate_widgets_init() {
    /*
     * Register the main sidebar widget area.
     * Appears in Appearance > Widgets and Customizer.
     */
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'boilerplate-theme' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'boilerplate-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    /*
     * Register footer widget areas.
     * Four columns in footer.
     */
    for ( $i = 1; $i <= 4; $i++ ) {
        register_sidebar( array(
            'name'          => sprintf( esc_html__( 'Footer Area %d', 'boilerplate-theme' ), $i ),
            'id'            => 'footer-' . $i,
            'description'   => sprintf( esc_html__( 'Widgets in this area will be shown in footer column %d.', 'boilerplate-theme' ), $i ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
    }
}

/**
 * Hook widget registration to widgets_init.
 */
add_action( 'widgets_init', 'boilerplate_widgets_init' );

/**
 * =============================================================================
 * CUSTOM LOGO CUSTOMIZER SETTINGS
 * =============================================================================
 */
function boilerplate_customize_register( $wp_customize ) {
    /*
     * Customize the custom logo control.
     * Move it to a more prominent location.
     */
    $wp_customize->get_control( 'custom_logo' )->section = 'title_tagline';
    $wp_customize->get_control( 'custom_logo' )->priority = 5;
}

/**
 * Hook customizer settings to customize_register.
 */
add_action( 'customize_register', 'boilerplate_customize_register' );

/**
 * =============================================================================
 * MODULAR FILE INCLUSION
 * =============================================================================
 */
/**
 * Include all PHP files from the inc/ directory.
 * This allows for modular, organized code where each feature has its own file.
 * Files are loaded in alphabetical order, so prefix with numbers for ordering.
 * 
 * To add a new feature:
 * 1. Create a new file in inc/ (e.g., inc/custom-post-types.php)
 * 2. It will be automatically included - no need to modify functions.php!
 */
$inc_files = glob( BOILERPLATE_THEME_INC . '/*.php' );
if ( $inc_files ) {
    foreach ( $inc_files as $file ) {
        require_once $file;
    }
}

/**
 * Include all block files from the blocks/ directory.
 * Each block should have its own directory with a register.php file.
 * This enables modular block development.
 */
$block_dirs = glob( BOILERPLATE_THEME_BLOCKS . '/*', GLOB_ONLYDIR );
if ( $block_dirs ) {
    foreach ( $block_dirs as $block_dir ) {
        $register_file = $block_dir . '/register.php';
        if ( file_exists( $register_file ) ) {
            require_once $register_file;
        }
    }
}

/**
 * =============================================================================
 * HELPER FUNCTIONS
 * =============================================================================
 */

/**
 * Get the theme prefix for function/class names.
 * 
 * @return string The theme prefix (boilerplate_theme).
 */
function boilerplate_get_prefix() {
    return 'boilerplate_theme';
}

/**
 * Safely get an ACF field value with escaping.
 * 
 * @param string $field_name The ACF field name.
 * @param int|bool $post_id The post ID (optional, defaults to current post).
 * @param string $escape The escaping function to use (esc_html, esc_attr, esc_url, wp_kses_post, or none).
 * @return string|array|false The field value, escaped, or false if not found.
 */
function boilerplate_get_acf_field( $field_name, $post_id = false, $escape = 'esc_html' ) {
    if ( ! function_exists( 'get_field' ) ) {
        return false;
    }
    
    $value = get_field( $field_name, $post_id );
    
    if ( $value === false || $value === null || $value === '' ) {
        return false;
    }
    
    if ( is_array( $value ) ) {
        return $value;
    }
    
    switch ( $escape ) {
        case 'esc_attr':
            return esc_attr( $value );
        case 'esc_url':
            return esc_url( $value );
        case 'wp_kses_post':
            return wp_kses_post( $value );
        case 'none':
            return $value;
        case 'esc_html':
        default:
            return esc_html( $value );
    }
}

/**
 * Safely get an ACF image field and return formatted HTML.
 * 
 * @param string $field_name The ACF field name.
 * @param int|bool $post_id The post ID.
 * @param string $size The image size (thumbnail, medium, large, full, or custom).
 * @param array $attr Additional attributes for the img tag.
 * @return string|false HTML img tag or false if no image.
 */
function boilerplate_get_acf_image( $field_name, $post_id = false, $size = 'large', $attr = array() ) {
    if ( ! function_exists( 'get_field' ) ) {
        return false;
    }
    
    $image = get_field( $field_name, $post_id );
    
    if ( ! $image ) {
        return false;
    }
    
    // Handle ACF image array format
    if ( is_array( $image ) && isset( $image['ID'] ) ) {
        $image_id = $image['ID'];
    } elseif ( is_numeric( $image ) ) {
        $image_id = $image;
    } else {
        return false;
    }
    
    // Default attributes
    $default_attr = array(
        'loading' => 'lazy',
        'decoding' => 'async',
    );
    
    $attr = array_merge( $default_attr, $attr );
    
    // Build attribute string
    $attr_str = '';
    foreach ( $attr as $key => $value ) {
        $attr_str .= ' ' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
    }
    
    // Get image HTML
    $image_html = wp_get_attachment_image( $image_id, $size, false, $attr );
    
    return $image_html;
}

/**
 * Get a sanitized class name from a string.
 * Useful for generating BEM-style class names from block names.
 * 
 * @param string $string The input string.
 * @param string $prefix Optional prefix.
 * @return string Sanitized class name.
 */
function boilerplate_sanitize_class( $string, $prefix = '' ) {
    $sanitized = strtolower( trim( $string ) );
    $sanitized = preg_replace( '/[^a-z0-9]+/', '-', $sanitized );
    $sanitized = trim( $sanitized, '-' );
    
    if ( $prefix ) {
        $sanitized = $prefix . '-' . $sanitized;
    }
    
    return $sanitized;
}

/**
 * Output a BEM-style block wrapper with attributes.
 * 
 * @param string $block_name The block name (e.g., 'hero-section').
 * @param array $attributes Block attributes from Gutenberg.
 * @param array $extra_classes Additional CSS classes.
 * @return void Echoes the opening wrapper div.
 */
function boilerplate_block_wrapper_open( $block_name, $attributes = array(), $extra_classes = array() ) {
    $classes = array( 'block', 'block--' . boilerplate_sanitize_class( $block_name ) );
    
    // Add align class if present
    if ( ! empty( $attributes['align'] ) ) {
        $classes[] = 'align' . $attributes['align'];
    }
    
    // Add custom className if present
    if ( ! empty( $attributes['className'] ) ) {
        $classes[] = $attributes['className'];
    }
    
    // Add extra classes
    $classes = array_merge( $classes, $extra_classes );
    
    // Filter classes
    $classes = array_map( 'sanitize_html_class', $classes );
    $classes = array_filter( $classes );
    
    // Build class attribute
    $class_attr = ' class="' . esc_attr( implode( ' ', $classes ) ) . '"';
    
    // Build ID attribute if anchor is set
    $id_attr = '';
    if ( ! empty( $attributes['anchor'] ) ) {
        $id_attr = ' id="' . esc_attr( $attributes['anchor'] ) . '"';
    }
    
    // Output wrapper
    echo '<div' . $id_attr . $class_attr . '>';
}

/**
 * Close the block wrapper.
 * 
 * @return void
 */
function boilerplate_block_wrapper_close() {
    echo '</div>';
}

/**
 * =============================================================================
 * TEMPLATE TAGS (included from inc/template-tags.php)
 * =============================================================================
 * These functions are defined in inc/template-tags.php and provide
 * reusable template tags for displaying posts, navigation, meta, etc.
 */

/**
 * =============================================================================
 * ACTION & FILTER HOOKS FOR EXTENSIBILITY
 * =============================================================================
 * These hooks allow child themes and plugins to modify theme behavior
 * without modifying core theme files.
 */

/**
 * Filter the theme prefix.
 * Allows child themes to change the function/class prefix.
 */
apply_filters( 'boilerplate_theme_prefix', 'boilerplate_theme' );

/**
 * Filter the content width.
 * Allows adjusting the max content width for embeds.
 */
apply_filters( 'boilerplate_content_width', 1200 );

/**
 * Filter copyright text in footer.
 */
apply_filters( 'boilerplate_copyright_text', '' );

/**
 * Filter footer credits.
 */
apply_filters( 'boilerplate_footer_credits', '' );

/**
 * Action before header.
 * @see header.php
 */
do_action( 'boilerplate_before_header' );

/**
 * Action after header.
 * @see header.php
 */
do_action( 'boilerplate_after_header' );

/**
 * Action before footer.
 * @see footer.php
 */
do_action( 'boilerplate_before_footer' );

/**
 * Action after footer.
 * @see footer.php
 */
do_action( 'boilerplate_after_footer' );

/**
 * Action before main loop.
 * @see index.php
 */
do_action( 'boilerplate_before_main_loop' );

/**
 * Action after main loop.
 * @see index.php
 */
do_action( 'boilerplate_after_main_loop' );

/**
 * Action when no posts found.
 * @see index.php
 */
do_action( 'boilerplate_no_posts_found' );

/**
 * =============================================================================
 * MAINTENANCE & CLEANUP
 * =============================================================================
 */

/**
 * Remove WordPress version from head for security.
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Remove emoji scripts and styles for performance.
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/**
 * Disable XML-RPC for security.
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Disable REST API for non-authenticated users (optional - uncomment if needed).
 */
// add_filter( 'rest_authentication_errors', function( $result ) {
//     if ( ! empty( $result ) ) {
//         return $result;
//     }
//     if ( ! is_user_logged_in() ) {
//         return new WP_Error( 'rest_not_logged_in', 'You are not logged in.', array( 'status' => 401 ) );
//     }
//     return $result;
// } );

/**
 * Remove unnecessary dashboard widgets for cleaner admin.
 */
function boilerplate_remove_dashboard_widgets() {
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
}
add_action( 'wp_dashboard_setup', 'boilerplate_remove_dashboard_widgets' );

/**
 * Add theme support for custom editor font sizes.
 * These appear in the block editor typography panel.
 */
function boilerplate_editor_font_sizes() {
    add_theme_support( 'editor-font-sizes', array(
        array(
            'name'      => esc_html__( 'Extra Small', 'boilerplate-theme' ),
            'shortName' => esc_html__( 'XS', 'boilerplate-theme' ),
            'size'      => 12,
            'slug'      => 'xs',
        ),
        array(
            'name'      => esc_html__( 'Small', 'boilerplate-theme' ),
            'shortName' => esc_html__( 'SM', 'boilerplate-theme' ),
            'size'      => 14,
            'slug'      => 'sm',
        ),
        array(
            'name'      => esc_html__( 'Normal', 'boilerplate-theme' ),
            'shortName' => esc_html__( 'M', 'boilerplate-theme' ),
            'size'      => 16,
            'slug'      => 'normal',
        ),
        array(
            'name'      => esc_html__( 'Large', 'boilerplate-theme' ),
            'shortName' => esc_html__( 'LG', 'boilerplate-theme' ),
            'size'      => 20,
            'slug'      => 'lg',
        ),
        array(
            'name'      => esc_html__( 'Extra Large', 'boilerplate-theme' ),
            'shortName' => esc_html__( 'XL', 'boilerplate-theme' ),
            'size'      => 30,
            'slug'      => 'xl',
        ),
        array(
            'name'      => esc_html__( 'Huge', 'boilerplate-theme' ),
            'shortName' => esc_html__( 'XXL', 'boilerplate-theme' ),
            'size'      => 48,
            'slug'      => 'xxl',
        ),
    ) );
}
add_action( 'after_setup_theme', 'boilerplate_editor_font_sizes' );

/**
 * Add theme support for custom editor color palette.
 * These colors appear in the block editor color pickers.
 */
function boilerplate_editor_color_palette() {
    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => esc_html__( 'Primary', 'boilerplate-theme' ),
            'slug'  => 'primary',
            'color' => '#2563eb',
        ),
        array(
            'name'  => esc_html__( 'Primary Light', 'boilerplate-theme' ),
            'slug'  => 'primary-light',
            'color' => '#dbeafe',
        ),
        array(
            'name'  => esc_html__( 'Secondary', 'boilerplate-theme' ),
            'slug'  => 'secondary',
            'color' => '#64748b',
        ),
        array(
            'name'  => esc_html__( 'Accent', 'boilerplate-theme' ),
            'slug'  => 'accent',
            'color' => '#f59e0b',
        ),
        array(
            'name'  => esc_html__( 'Success', 'boilerplate-theme' ),
            'slug'  => 'success',
            'color' => '#10b981',
        ),
        array(
            'name'  => esc_html__( 'Error', 'boilerplate-theme' ),
            'slug'  => 'error',
            'color' => '#ef4444',
        ),
        array(
            'name'  => esc_html__( 'White', 'boilerplate-theme' ),
            'slug'  => 'white',
            'color' => '#ffffff',
        ),
        array(
            'name'  => esc_html__( 'Gray 50', 'boilerplate-theme' ),
            'slug'  => 'gray-50',
            'color' => '#f8fafc',
        ),
        array(
            'name'  => esc_html__( 'Gray 900', 'boilerplate-theme' ),
            'slug'  => 'gray-900',
            'color' => '#0f172a',
        ),
        array(
            'name'  => esc_html__( 'Gray 950', 'boilerplate-theme' ),
            'slug'  => 'gray-950',
            'color' => '#020617',
        ),
    ) );
    
    // Disable custom colors to enforce design system
    add_theme_support( 'disable-custom-colors' );
    
    // Disable custom gradients
    add_theme_support( 'disable-custom-gradients' );
    
    // Disable custom font sizes
    add_theme_support( 'disable-custom-font-sizes' );
}
add_action( 'after_setup_theme', 'boilerplate_editor_color_palette' );

/**
 * =============================================================================
 * DEVELOPER DOCUMENTATION
 * =============================================================================
 * 
 * HOW TO ADD NEW FEATURES:
 * 
 * 1. CUSTOM POST TYPES / TAXONOMIES:
 *    Create: inc/custom-post-types.php
 *    It will be auto-loaded. No need to modify functions.php.
 * 
 * 2. CUSTOM BLOCKS (ACF):
 *    Create: blocks/your-block-name/register.php
 *    Create: blocks/your-block-name/render.php (or template-parts/blocks/your-block-name.php)
 *    The register.php will be auto-loaded.
 * 
 * 3. TEMPLATE TAGS:
 *    Add to: inc/template-tags.php
 * 
 * 4. CUSTOMIZER SETTINGS:
 *    Create: inc/customizer.php
 * 
 * 5. WIDGETS:
 *    Create: inc/widgets.php
 * 
 * 6. SHORTCODES:
 *    Create: inc/shortcodes.php
 * 
 * 7. AJAX HANDLERS:
 *    Create: inc/ajax.php
 * 
 * 8. REST API ENDPOINTS:
 *    Create: inc/rest-api.php
 * 
 * 9. ADMIN ENHANCEMENTS:
 *    Create: inc/admin.php
 * 
 * 10. THIRD-PARTY INTEGRATIONS:
 *     Create: inc/integrations/ (directory for each integration)
 * 
 * NAMING CONVENTIONS:
 * - Functions: boilerplate_theme_function_name()
 * - Classes: Boilerplate_Theme_Class_Name
 * - Hooks: boilerplate_hook_name
 * - Filters: boilerplate_filter_name
 * - Text Domain: boilerplate-theme
 * - CSS Classes: .block--block-name__element--modifier (BEM)
 * 
 * ESCAPING FUNCTIONS:
 * - esc_html() - for HTML output
 * - esc_attr() - for HTML attributes
 * - esc_url() - for URLs
 * - esc_js() - for JavaScript
 * - wp_kses_post() - for content with allowed HTML
 * - wp_kses() - for custom allowed HTML
 * 
 * SECURITY:
 * - Always escape output
 * - Use nonces for forms/AJAX
 * - Sanitize input with sanitize_text_field(), sanitize_email(), etc.
 * - Validate with is_email(), absint(), etc.
 * - Use $wpdb->prepare() for database queries
 * - Check capabilities with current_user_can()
 * - Verify nonces with wp_verify_nonce()
 */