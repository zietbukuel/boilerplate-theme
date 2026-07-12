/**
 * Hero Section Block - Editor Script (Webpack/ESNext)
 * 
 * Provides editor-specific functionality for the Hero Section block.
 * This runs in the block editor context.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { createElement as el, useState, useEffect } from '@wordpress/element';
import { useBlockProps, InspectorControls, MediaUpload, __experimentalLinkControl as LinkControl } from '@wordpress/block-editor';
import { PanelBody, SelectControl, RangeControl, Button, TextControl, TextareaControl } from '@wordpress/components';

import './style.scss';

/**
 * Hero Section Block Edit Component
 */
const HeroSectionEdit = ( props ) => {
    const { attributes, setAttributes, isSelected } = props;
    
    const blockProps = useBlockProps( {
        className: 'block--hero-section'
    } );
    
    // Preview mode shows the rendered output
    if ( ! isSelected ) {
        return el( 'div', blockProps,
            el( 'div', { className: 'block-hero__background' } ),
            el( 'div', { className: 'block-hero__content block-hero__content--center' },
                attributes.title && el( 'h1', { className: 'block-hero__title' }, attributes.title ),
                attributes.subtitle && el( 'p', { className: 'block-hero__subtitle' }, attributes.subtitle ),
                ( attributes.ctaPrimary || attributes.ctaSecondary ) && el( 'div', { className: 'block-hero__cta' },
                    attributes.ctaPrimary && el( 'a', { 
                        className: 'btn btn-primary btn-lg',
                        href: attributes.ctaPrimary.url 
                    }, attributes.ctaPrimary.title ),
                    attributes.ctaSecondary && el( 'a', { 
                        className: 'btn btn-outline btn-lg',
                        href: attributes.ctaSecondary.url 
                    }, attributes.ctaSecondary.title )
                )
            )
        );
    }
    
    // Edit mode - show controls
    return el( 'div', blockProps,
        el( InspectorControls, null,
            el( PanelBody, { title: __( 'Content', 'boilerplate-theme' ), initialOpen: true },
                el( TextControl, {
                    label: __( 'Title', 'boilerplate-theme' ),
                    value: attributes.title,
                    onChange: ( value ) => { setAttributes( { title: value } ); },
                    placeholder: __( 'Enter hero title...', 'boilerplate-theme' ),
                } ),
                el( TextareaControl, {
                    label: __( 'Subtitle', 'boilerplate-theme' ),
                    value: attributes.subtitle,
                    onChange: ( value ) => { setAttributes( { subtitle: value } ); },
                    placeholder: __( 'Enter hero subtitle...', 'boilerplate-theme' ),
                    rows: 3,
                } ),
                el( SelectControl, {
                    label: __( 'Content Alignment', 'boilerplate-theme' ),
                    value: attributes.contentAlignment || 'center',
                    options: [
                        { label: __( 'Left', 'boilerplate-theme' ), value: 'left' },
                        { label: __( 'Center', 'boilerplate-theme' ), value: 'center' },
                        { label: __( 'Right', 'boilerplate-theme' ), value: 'right' },
                    ],
                    onChange: ( value ) => { setAttributes( { contentAlignment: value } ); },
                } ),
                el( RangeControl, {
                    label: __( 'Overlay Opacity', 'boilerplate-theme' ),
                    value: attributes.overlayOpacity || 0.6,
                    min: 0,
                    max: 1,
                    step: 0.1,
                    onChange: ( value ) => { setAttributes( { overlayOpacity: value } ); },
                } )
            ),
            el( PanelBody, { title: __( 'Background Image', 'boilerplate-theme' ), initialOpen: true },
                el( MediaUpload, {
                    onSelect: ( media ) => {
                        setAttributes( {
                            backgroundImage: {
                                id: media.id,
                                url: media.url,
                                alt: media.alt,
                                title: media.title,
                            }
                        } );
                    },
                    allowedTypes: 'image',
                    value: attributes.backgroundImage?.id,
                    render: ( obj ) => {
                        return el( Button, {
                            className: attributes.backgroundImage ? 'button' : 'button button-large',
                            onClick: obj.open,
                        }, attributes.backgroundImage ? __( 'Replace Image', 'boilerplate-theme' ) : __( 'Select Image', 'boilerplate-theme' ) );
                    },
                } ),
                attributes.backgroundImage && el( 'p', { style: { marginTop: '8px' } },
                    el( 'img', { 
                        src: attributes.backgroundImage.url, 
                        alt: '', 
                        style: { maxWidth: '200px', height: 'auto', borderRadius: '4px' }
                    } )
                )
            ),
            el( PanelBody, { title: __( 'Call to Action', 'boilerplate-theme' ), initialOpen: false },
                el( LinkControl, {
                    label: __( 'Primary CTA', 'boilerplate-theme' ),
                    value: attributes.ctaPrimary,
                    onChange: ( value ) => { setAttributes( { ctaPrimary: value } ); },
                } ),
                el( LinkControl, {
                    label: __( 'Secondary CTA', 'boilerplate-theme' ),
                    value: attributes.ctaSecondary,
                    onChange: ( value ) => { setAttributes( { ctaSecondary: value } ); },
                } )
            )
        ),
        // Preview in editor
        el( 'div', { className: 'block-hero__background', style: attributes.backgroundImage ? { backgroundImage: 'url(' + attributes.backgroundImage.url + ')' } : {} } ),
        el( 'div', { className: 'block-hero__content block-hero__content--' + ( attributes.contentAlignment || 'center' ) },
            attributes.title && el( 'h1', { className: 'block-hero__title' }, attributes.title ),
            attributes.subtitle && el( 'p', { className: 'block-hero__subtitle' }, attributes.subtitle ),
            ( attributes.ctaPrimary || attributes.ctaSecondary ) && el( 'div', { className: 'block-hero__cta' },
                attributes.ctaPrimary && el( 'a', { 
                    className: 'btn btn-primary btn-lg',
                    href: attributes.ctaPrimary.url 
                }, attributes.ctaPrimary.title ),
                attributes.ctaSecondary && el( 'a', { 
                    className: 'btn btn-outline btn-lg',
                    href: attributes.ctaSecondary.url 
                }, attributes.ctaSecondary.title )
            ),
            !attributes.title && !attributes.subtitle && el( 'p', { className: 'editor-placeholder' }, __( 'Add content in the block settings panel.', 'boilerplate-theme' ) )
        )
    );
};

// Register block natively in Gutenberg
registerBlockType( 'boilerplate/hero-section', {
    apiVersion: 3,
    title: __( 'Hero Section', 'boilerplate-theme' ),
    description: __( 'A full-width hero section with title, subtitle, background image, and CTA buttons.', 'boilerplate-theme' ),
    category: 'boilerplate-blocks',
    icon: 'cover-image',
    keywords: [ 'hero', 'banner', 'header', 'landing', 'cta' ],
    attributes: {
        title: { type: 'string', default: '' },
        subtitle: { type: 'string', default: '' },
        backgroundImage: { type: 'object', default: null },
        ctaPrimary: { type: 'object', default: null },
        ctaSecondary: { type: 'object', default: null },
        contentAlignment: { type: 'string', default: 'center' },
        overlayOpacity: { type: 'number', default: 0.6 },
        align: { type: 'string', default: 'full' },
    },
    supports: {
        align: [ 'wide', 'full' ],
        anchor: true,
        customClassName: true,
    },
    edit: HeroSectionEdit,
    save: () => null, // Render dynamically in PHP
} );
