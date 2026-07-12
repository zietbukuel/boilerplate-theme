<?php
/**
 * Boilerplate Theme - Native Gutenberg Block Registrations
 * 
 * Registers Gutenberg block categories, native block types, and their render callbacks.
 * This file replaces ACF Pro block registration entirely, making blocks native and self-contained.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register custom block category.
 */
function boilerplate_register_block_category( $categories ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'boilerplate-blocks',
                'title' => __( 'Boilerplate Blocks', 'boilerplate-theme' ),
                'icon'  => 'smiley',
            ),
        )
    );
}
add_filter( 'block_categories_all', 'boilerplate_register_block_category', 10, 1 );

/**
 * Register native block types.
 */
function boilerplate_register_native_blocks() {
    register_block_type( 'boilerplate/hero-section', array(
        'render_callback' => 'boilerplate_render_hero_section_block_native',
    ) );
    
    register_block_type( 'boilerplate/feature-grid', array(
        'render_callback' => 'boilerplate_render_feature_grid_block_native',
    ) );
}
add_action( 'init', 'boilerplate_register_native_blocks' );

/**
 * Render callback for Hero Section block.
 */
function boilerplate_render_hero_section_block_native( $attributes ) {
    $title           = $attributes['title'] ?? '';
    $subtitle        = $attributes['subtitle'] ?? '';
    $background      = $attributes['backgroundImage'] ?? false;
    $cta_primary     = $attributes['ctaPrimary'] ?? false;
    $cta_secondary   = $attributes['ctaSecondary'] ?? false;
    $content_align   = $attributes['contentAlignment'] ?? 'center';
    $overlay_opacity = $attributes['overlayOpacity'] ?? 0.6;
    
    // Set variables expected by the template parts file
    $id = '';
    $class_names = array( 'block', 'block--hero-section' );
    if ( ! empty( $attributes['align'] ) ) {
        $class_names[] = 'align' . $attributes['align'];
    }
    $class_attr = ' class="' . esc_attr( implode( ' ', $class_names ) ) . '"';
    
    ob_start();
    include get_template_directory() . '/template-parts/blocks/hero-section.php';
    return ob_get_clean();
}

/**
 * Render callback for Feature Grid block.
 */
function boilerplate_render_feature_grid_block_native( $attributes ) {
    $section_title       = $attributes['sectionTitle'] ?? '';
    $section_description = $attributes['sectionDescription'] ?? '';
    $features            = $attributes['features'] ?? array();
    $columns             = $attributes['columns'] ?? 3;
    $icon_style          = $attributes['iconStyle'] ?? 'colored';
    
    // Set variables expected by the template parts file
    $id = '';
    $class_names = array( 'block', 'block--feature-grid' );
    if ( ! empty( $attributes['align'] ) ) {
        $class_names[] = 'align' . $attributes['align'];
    }
    $class_attr = ' class="' . esc_attr( implode( ' ', $class_names ) ) . '"';
    
    ob_start();
    include get_template_directory() . '/template-parts/blocks/feature-grid.php';
    return ob_get_clean();
}