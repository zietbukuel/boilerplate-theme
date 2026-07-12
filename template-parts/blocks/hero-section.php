<?php
/**
 * Hero Section Block Template
 * 
 * This template renders the Hero Section block on the frontend.
 * It receives variables from the render callback function:
 * - $block: Array of block settings and attributes
 * - $id: String ID attribute for anchor linking
 * - $class_attr: String class attribute
 * - $title: String sanitized title
 * - $subtitle: String sanitized subtitle
 * - $background: Array|false background image data
 * - $cta_primary: Array|false primary CTA link
 * - $cta_secondary: Array|false secondary CTA link
 * - $content_align: String content alignment (left, center, right)
 * - $overlay_opacity: Float overlay opacity (0-1)
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Extract variables for cleaner template code
$title              = isset( $title ) ? $title : '';
$subtitle           = isset( $subtitle ) ? $subtitle : '';
$background         = isset( $background ) ? $background : false;
$cta_primary        = isset( $cta_primary ) ? $cta_primary : false;
$cta_secondary      = isset( $cta_secondary ) ? $cta_secondary : false;
$content_align      = isset( $content_align ) ? $content_align : 'center';
$overlay_opacity    = isset( $overlay_opacity ) ? $overlay_opacity : 0.6;
$block_id           = isset( $id ) ? $id : '';
$block_class_attr   = isset( $class_attr ) ? $class_attr : 'class="block block--hero-section"';

// Build background image style
$background_style = '';
if ( $background && isset( $background['url'] ) ) {
    $background_style = 'style="background-image: url(' . esc_url( $background['url'] ) . ');"';
}

// Build overlay style
$overlay_style = 'style="--overlay-opacity: ' . esc_attr( $overlay_opacity ) . ';"';

// Build content alignment class
$align_class = 'block-hero__content--' . esc_attr( $content_align );
?>

<div <?php echo $block_id . ' ' . $block_class_attr; ?>>
    
    <!-- Background Image Layer -->
    <div class="block-hero__background" <?php echo $background_style; ?> <?php echo $overlay_style; ?> aria-hidden="true">
        <?php if ( $background && isset( $background['alt'] ) ) : ?>
            <!-- Accessible hidden image for screen readers -->
            <img src="<?php echo esc_url( $background['url'] ); ?>" 
                 alt="<?php echo esc_attr( $background['alt'] ); ?>" 
                 class="sr-only" 
                 aria-hidden="true" />
        <?php endif; ?>
    </div>
    
    <!-- Content Layer -->
    <div class="block-hero__content <?php echo esc_attr( $align_class ); ?>">
        
        <?php if ( $title ) : ?>
            <h1 class="block-hero__title">
                <?php echo esc_html( $title ); ?>
            </h1>
        <?php endif; ?>
        
        <?php if ( $subtitle ) : ?>
            <p class="block-hero__subtitle">
                <?php echo wp_kses_post( $subtitle ); ?>
            </p>
        <?php endif; ?>
        
        <?php if ( $cta_primary || $cta_secondary ) : ?>
            <div class="block-hero__cta">
                
                <?php if ( $cta_primary && isset( $cta_primary['url'], $cta_primary['title'] ) ) : ?>
                    <a href="<?php echo esc_url( $cta_primary['url'] ); ?>" 
                       class="btn btn-primary btn-lg"
                       target="<?php echo esc_attr( $cta_primary['target'] ?? '_self' ); ?>"
                       rel="<?php echo esc_attr( $cta_primary['rel'] ?? 'noopener noreferrer' ); ?>">
                        <?php echo esc_html( $cta_primary['title'] ); ?>
                    </a>
                <?php endif; ?>
                
                <?php if ( $cta_secondary && isset( $cta_secondary['url'], $cta_secondary['title'] ) ) : ?>
                    <a href="<?php echo esc_url( $cta_secondary['url'] ); ?>" 
                       class="btn btn-outline btn-lg"
                       target="<?php echo esc_attr( $cta_secondary['target'] ?? '_self' ); ?>"
                       rel="<?php echo esc_attr( $cta_secondary['rel'] ?? 'noopener noreferrer' ); ?>">
                        <?php echo esc_html( $cta_secondary['title'] ); ?>
                    </a>
                <?php endif; ?>
                
            </div>
        <?php endif; ?>
        
    </div><!-- .block-hero__content -->
    
</div><!-- .block--hero-section -->