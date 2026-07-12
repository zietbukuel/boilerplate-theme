<?php
/**
 * Boilerplate Theme - Gutenberg Block Patterns
 * 
 * Registers Gutenberg block patterns as fallbacks/alternatives for users 
 * without ACF Pro or who prefer native core block patterns.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register custom block patterns.
 */
function boilerplate_register_block_patterns() {
    // Register custom pattern category
    register_block_pattern_category(
        'boilerplate-patterns',
        array( 'label' => __( 'Boilerplate Patterns', 'boilerplate-theme' ) )
    );

    // 1. Hero Section (Core Gutenberg Fallback)
    register_block_pattern(
        'boilerplate/core-hero-section',
        array(
            'title'       => __( 'Core Hero Section (No ACF Pro)', 'boilerplate-theme' ),
            'description' => __( 'A full-width hero section built with core Gutenberg blocks, styled by the theme.', 'boilerplate-theme' ),
            'categories'  => array( 'boilerplate-patterns' ),
            'content'     => '<!-- wp:group {"align":"full","className":"block block--hero-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull block block--hero-section">
    <!-- wp:group {"className":"block-hero__background","layout":{"type":"constrained"}} -->
    <div class="wp-block-group block-hero__background"></div>
    <!-- /wp:group -->
    <!-- wp:group {"className":"block-hero__content block-hero__content--center","layout":{"type":"constrained"}} -->
    <div class="wp-block-group block-hero__content block-hero__content--center">
        <!-- wp:heading {"level":1,"className":"block-hero__title","fontSize":"xx-large"} -->
        <h1 class="wp-block-heading block-hero__title has-xx-large-font-size">' . esc_html__( 'Welcome to Our Platform', 'boilerplate-theme' ) . '</h1>
        <!-- /wp:heading -->
        <!-- wp:paragraph {"className":"block-hero__subtitle"} -->
        <p class="block-hero__subtitle">' . esc_html__( 'Build faster with our intuitive tools and powerful features.', 'boilerplate-theme' ) . '</p>
        <!-- /wp:paragraph -->
        <!-- wp:buttons {"className":"block-hero__cta","layout":{"type":"flex","justifyContent":"center"}} -->
        <div class="wp-block-buttons block-hero__cta">
            <!-- wp:button {"className":"btn btn-primary btn-lg"} -->
            <div class="wp-block-button btn btn-primary btn-lg"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Get Started', 'boilerplate-theme' ) . '</a></div>
            <!-- /wp:button -->
            <!-- wp:button {"className":"btn btn-outline btn-lg"} -->
            <div class="wp-block-button btn btn-outline btn-lg"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Learn More', 'boilerplate-theme' ) . '</a></div>
            <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->',
        )
    );

    // 2. Feature Grid Section (Core Gutenberg Fallback)
    register_block_pattern(
        'boilerplate/core-feature-grid',
        array(
            'title'       => __( 'Core Feature Grid (No ACF Pro)', 'boilerplate-theme' ),
            'description' => __( 'A grid of features built with core Gutenberg blocks, styled by the theme.', 'boilerplate-theme' ),
            'categories'  => array( 'boilerplate-patterns' ),
            'content'     => '<!-- wp:group {"align":"wide","className":"block block--feature-grid","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide block block--feature-grid">
    <!-- wp:heading {"textAlign":"center","className":"block-feature-grid__title","fontSize":"x-large"} -->
    <h2 class="wp-block-heading text-center block-feature-grid__title has-x-large-font-size">' . esc_html__( 'Our Key Features', 'boilerplate-theme' ) . '</h2>
    <!-- /wp:heading -->
    <!-- wp:paragraph {"align":"center","className":"block-feature-grid__description"} -->
    <p class="has-text-align-center block-feature-grid__description">' . esc_html__( 'Everything you need to scale your project and succeed.', 'boilerplate-theme' ) . '</p>
    <!-- /wp:paragraph -->
    <!-- wp:columns {"className":"block-feature-grid__list"} -->
    <div class="wp-block-columns block-feature-grid__list">
        <!-- wp:column {"className":"block-feature-grid__item"} -->
        <div class="wp-block-column block-feature-grid__item">
            <!-- wp:paragraph {"className":"block-feature-grid__item-icon"} -->
            <p class="block-feature-grid__item-icon">🚀</p>
            <!-- /wp:paragraph -->
            <!-- wp:heading {"level":3,"className":"block-feature-grid__item-title","fontSize":"medium"} -->
            <h3 class="wp-block-heading block-feature-grid__item-title has-medium-font-size">' . esc_html__( 'Lightning Fast', 'boilerplate-theme' ) . '</h3>
            <!-- /wp:heading -->
            <!-- wp:paragraph {"className":"block-feature-grid__item-description"} -->
            <p class="block-feature-grid__item-description">' . esc_html__( 'Optimized for speed and page performance out of the box.', 'boilerplate-theme' ) . '</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->
        <!-- wp:column {"className":"block-feature-grid__item"} -->
        <div class="wp-block-column block-feature-grid__item">
            <!-- wp:paragraph {"className":"block-feature-grid__item-icon"} -->
            <p class="block-feature-grid__item-icon">🛡️</p>
            <!-- /wp:paragraph -->
            <!-- wp:heading {"level":3,"className":"block-feature-grid__item-title","fontSize":"medium"} -->
            <h3 class="wp-block-heading block-feature-grid__item-title has-medium-font-size">' . esc_html__( 'Secure & Private', 'boilerplate-theme' ) . '</h3>
            <!-- /wp:heading -->
            <!-- wp:paragraph {"className":"block-feature-grid__item-description"} -->
            <p class="block-feature-grid__item-description">' . esc_html__( 'Security practices built directly into every theme layer.', 'boilerplate-theme' ) . '</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->
        <!-- wp:column {"className":"block-feature-grid__item"} -->
        <div class="wp-block-column block-feature-grid__item">
            <!-- wp:paragraph {"className":"block-feature-grid__item-icon"} -->
            <p class="block-feature-grid__item-icon">👥</p>
            <!-- /wp:paragraph -->
            <!-- wp:heading {"level":3,"className":"block-feature-grid__item-title","fontSize":"medium"} -->
            <h3 class="wp-block-heading block-feature-grid__item-title has-medium-font-size">' . esc_html__( 'Team Collaboration', 'boilerplate-theme' ) . '</h3>
            <!-- /wp:heading -->
            <!-- wp:paragraph {"className":"block-feature-grid__item-description"} -->
            <p class="block-feature-grid__item-description">' . esc_html__( 'Easily customisable layout that works for multi-author blogs.', 'boilerplate-theme' ) . '</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->',
        )
    );

    // 3. Register ACF-based patterns if ACF Pro is active
    if ( function_exists( 'acf_register_block_type' ) ) {
        // Pattern: Hero with Feature Grid
        register_block_pattern(
            'boilerplate/hero-with-features',
            array(
                'title'       => __( 'Hero with Features (ACF)', 'boilerplate-theme' ),
                'description' => __( 'A hero section followed by a feature grid (requires ACF Pro).', 'boilerplate-theme' ),
                'categories'  => array( 'boilerplate-patterns' ),
                'content'     => '<!-- wp:boilerplate/hero-section {"align":"full","title":"Welcome to Our Platform","subtitle":"Build faster with our powerful tools"} /-->
<!-- wp:boilerplate/feature-grid {"align":"wide","sectionTitle":"Key Features","sectionDescription":"Everything you need to succeed","columns":3} /-->',
            )
        );

        // Pattern: Feature Grid Only
        register_block_pattern(
            'boilerplate/feature-grid-section',
            array(
                'title'       => __( 'Feature Grid Section (ACF)', 'boilerplate-theme' ),
                'description' => __( 'A standalone feature grid section (requires ACF Pro).', 'boilerplate-theme' ),
                'categories'  => array( 'boilerplate-patterns' ),
                'content'     => '<!-- wp:boilerplate/feature-grid {"align":"wide","sectionTitle":"Our Features","sectionDescription":"Powerful features for modern teams","columns":3} /-->',
            )
        );

        // Pattern: Centered Hero
        register_block_pattern(
            'boilerplate/centered-hero',
            array(
                'title'       => __( 'Centered Hero (ACF)', 'boilerplate-theme' ),
                'description' => __( 'A centered hero section with CTA buttons (requires ACF Pro).', 'boilerplate-theme' ),
                'categories'  => array( 'boilerplate-patterns' ),
                'content'     => '<!-- wp:boilerplate/hero-section {"align":"full","title":"Launch Your Project Today","subtitle":"Join thousands of developers building with our platform","contentAlignment":"center"} /-->',
            )
        );
    }
}
add_action( 'init', 'boilerplate_register_block_patterns' );
