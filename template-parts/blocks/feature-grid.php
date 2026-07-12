<?php
/**
 * Feature Grid Block Template
 * 
 * This template renders the Feature Grid block on the frontend.
 * It receives variables from the render callback function:
 * - $block: Array of block settings and attributes
 * - $id: String ID attribute for anchor linking
 * - $class_attr: String class attribute
 * - $section_title: String sanitized section title
 * - $section_description: String sanitized section description
 * - $features: Array of feature items (from repeater field)
 * - $columns: Integer number of columns (1-4)
 * - $icon_style: String icon style variant
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Extract variables
$section_title       = isset( $section_title ) ? $section_title : '';
$section_description = isset( $section_description ) ? $section_description : '';
$features            = isset( $features ) && is_array( $features ) ? $features : array();
$columns             = isset( $columns ) ? absint( $columns ) : 3;
$icon_style          = isset( $icon_style ) ? $icon_style : 'colored';
$block_id            = isset( $id ) ? $id : '';
$block_class_attr    = isset( $class_attr ) ? $class_attr : 'class="block block--feature-grid"';

// Sanitize columns
$columns = max( 1, min( 4, $columns ) );

// Build icon style modifier class
$icon_style_class = 'block-feature-grid--' . esc_attr( $icon_style );
?>

<div <?php echo $block_id . ' ' . $block_class_attr; ?>>
    
    <div class="block-feature-grid__container">
        
        <!-- Section Header -->
        <?php if ( $section_title || $section_description ) : ?>
            <header class="block-feature-grid__header">
                
                <?php if ( $section_title ) : ?>
                    <h2 class="block-feature-grid__title">
                        <?php echo esc_html( $section_title ); ?>
                    </h2>
                <?php endif; ?>
                
                <?php if ( $section_description ) : ?>
                    <p class="block-feature-grid__description">
                        <?php echo wp_kses_post( $section_description ); ?>
                    </p>
                <?php endif; ?>
                
            </header>
        <?php endif; ?>
        
        <!-- Feature Grid -->
        <?php if ( ! empty( $features ) ) : ?>
            <div class="block-feature-grid__grid <?php echo esc_attr( $icon_style_class ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
                
                <?php foreach ( $features as $index => $feature ) : ?>
                    
                    <?php
                    // Extract feature fields with safe defaults
                    $icon        = isset( $feature['icon'] ) ? $feature['icon'] : '';
                    $title       = isset( $feature['title'] ) ? $feature['title'] : '';
                    $description = isset( $feature['description'] ) ? $feature['description'] : '';
                    $link        = isset( $feature['link'] ) && isset( $feature['link']['url'] ) ? $feature['link'] : false;
                    
                    // Skip empty features
                    if ( ! $title && ! $description && ! $icon ) {
                        continue;
                    }
                    ?>
                    
                    <!-- Feature Item -->
                    <article class="block-feature-grid__item" itemprop="feature" itemscope itemtype="https://schema.org/FeatureList">
                        
                        <?php if ( $link ) : ?>
                            <!-- Linked Feature Card -->
                            <a href="<?php echo esc_url( $link['url'] ); ?>" 
                               class="block-feature-grid__link"
                               target="<?php echo esc_attr( $link['target'] ?? '_self' ); ?>"
                               rel="<?php echo esc_attr( $link['rel'] ?? 'noopener noreferrer' ); ?>"
                               itemprop="url">
                        <?php endif; ?>
                        
                            <!-- Icon -->
                            <?php if ( $icon ) : ?>
                                <div class="block-feature-grid__icon" aria-hidden="true">
                                    <?php
                                    // Handle different icon formats
                                    if ( is_array( $icon ) && isset( $icon['url'] ) ) {
                                        // ACF Image object
                                        echo wp_get_attachment_image( $icon['ID'], 'thumbnail', false, array(
                                            'class' => 'block-feature-grid__icon-img',
                                            'alt'   => '',
                                            'loading' => 'lazy',
                                        ) );
                                    } elseif ( is_numeric( $icon ) ) {
                                        // Attachment ID
                                        echo wp_get_attachment_image( $icon, 'thumbnail', false, array(
                                            'class' => 'block-feature-grid__icon-img',
                                            'alt'   => '',
                                            'loading' => 'lazy',
                                        ) );
                                    } elseif ( is_string( $icon ) && str_starts_with( $icon, 'http' ) ) {
                                        // URL
                                        echo '<img src="' . esc_url( $icon ) . '" alt="" class="block-feature-grid__icon-img" loading="lazy" />';
                                    } else {
                                        // Assume it's an icon class name or SVG
                                        // Check if it looks like an SVG
                                        if ( str_starts_with( trim( $icon ), '<svg' ) ) {
                                            echo wp_kses_post( $icon );
                                        } else {
                                            // Icon class (e.g., 'rocket', 'shield', 'users')
                                            $icon_class = 'icon-' . sanitize_html_class( $icon );
                                            echo '<svg class="block-feature-grid__icon-svg" aria-hidden="true"><use xlink:href="#' . esc_attr( $icon_class ) . '"></use></svg>';
                                        }
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Content -->
                            <div class="block-feature-grid__content">
                                
                                <?php if ( $title ) : ?>
                                    <h3 class="block-feature-grid__title" itemprop="name">
                                        <?php echo esc_html( $title ); ?>
                                    </h3>
                                <?php endif; ?>
                                
                                <?php if ( $description ) : ?>
                                    <p class="block-feature-grid__description" itemprop="description">
                                        <?php echo wp_kses_post( $description ); ?>
                                    </p>
                                <?php endif; ?>
                                
                            </div>
                        
                        <?php if ( $link ) : ?>
                            </a>
                        <?php endif; ?>
                        
                    </article><!-- .block-feature-grid__item -->
                    
                <?php endforeach; ?>
                
            </div><!-- .block-feature-grid__grid -->
            
        <?php else : ?>
            <!-- Empty State (only shown in editor preview) -->
            <?php if ( is_admin() && isset( $block['preview'] ) && $block['preview'] ) : ?>
                <div class="block-feature-grid__empty">
                    <p><?php esc_html_e( 'Add features in the block settings to see them here.', 'boilerplate-theme' ); ?></p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
    </div><!-- .block-feature-grid__container -->
    
</div><!-- .block--feature-grid -->