/**
 * Feature Grid Block - Editor Script (Webpack/ESNext)
 * 
 * Provides editor-specific functionality for the Feature Grid block.
 * This runs in the block editor context.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { createElement as el, useState, useEffect } from '@wordpress/element';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, Button, TextControl, TextareaControl } from '@wordpress/components';

import './style.scss';

/**
 * Feature Grid Block Edit Component
 */
const FeatureGridEdit = ( props ) => {
    const { attributes, setAttributes, isSelected } = props;
    
    const blockProps = useBlockProps( {
        className: 'block--feature-grid'
    } );
    
    // Hooks must run unconditionally at the top level
    const [ features, setFeatures ] = useState( attributes.features || [] );
    
    useEffect( () => {
        setFeatures( attributes.features || [] );
    }, [ attributes.features ] );
    
    const updateFeature = ( index, field, value ) => {
        const newFeatures = [ ...features ];
        newFeatures[ index ] = { ...newFeatures[ index ], [ field ]: value };
        setFeatures( newFeatures );
        setAttributes( { features: newFeatures } );
    };
    
    const addFeature = () => {
        const newFeatures = [ ...features, {
            icon: 'star',
            title: '',
            description: '',
            link: { url: '', title: '', target: '_self' }
        } ];
        setFeatures( newFeatures );
        setAttributes( { features: newFeatures } );
    };
    
    const removeFeature = ( index ) => {
        const newFeatures = features.filter( ( _, i ) => i !== index );
        setFeatures( newFeatures );
        setAttributes( { features: newFeatures } );
    };
    
    const moveFeature = ( index, direction ) => {
        const newIndex = index + direction;
        if ( newIndex < 0 || newIndex >= features.length ) return;
        
        const newFeatures = [ ...features ];
        const temp = newFeatures[ index ];
        newFeatures[ index ] = newFeatures[ newIndex ];
        newFeatures[ newIndex ] = temp;
        
        setFeatures( newFeatures );
        setAttributes( { features: newFeatures } );
    };
    
    // Preview mode - show rendered output
    if ( ! isSelected ) {
        return el( 'div', blockProps,
            el( 'div', { className: 'block-feature-grid__container' },
                ( attributes.sectionTitle || attributes.sectionDescription ) && el( 'header', { className: 'block-feature-grid__header' },
                    attributes.sectionTitle && el( 'h2', { className: 'block-feature-grid__title' }, attributes.sectionTitle ),
                    attributes.sectionDescription && el( 'p', { className: 'block-feature-grid__description' }, attributes.sectionDescription )
                ),
                el( 'div', { 
                    className: 'block-feature-grid__grid', 
                    'data-columns': attributes.columns || 3 
                },
                    ( attributes.features || [] ).map( ( feature, index ) => {
                        return el( 'article', { 
                            key: index, 
                            className: 'block-feature-grid__item' 
                        },
                            feature.icon && el( 'div', { className: 'block-feature-grid__icon' },
                                feature.icon.startsWith('<svg') ? 
                                    el( 'div', { dangerouslySetInnerHTML: { __html: feature.icon } } ) :
                                    el( 'i', { className: 'icon-' + feature.icon } )
                            ),
                            feature.title && el( 'h3', { className: 'block-feature-grid__title' }, feature.title ),
                            feature.description && el( 'p', { className: 'block-feature-grid__description' }, feature.description )
                        );
                    } )
                )
            )
        );
    }
    
    // Edit mode
    return el( 'div', blockProps,
        el( InspectorControls, null,
            el( PanelBody, { title: __( 'Section Settings', 'boilerplate-theme' ), initialOpen: true },
                el( TextControl, {
                    label: __( 'Section Title', 'boilerplate-theme' ),
                    value: attributes.sectionTitle,
                    onChange: ( value ) => { setAttributes( { sectionTitle: value } ); },
                    placeholder: __( 'Enter section title...', 'boilerplate-theme' ),
                } ),
                el( TextareaControl, {
                    label: __( 'Section Description', 'boilerplate-theme' ),
                    value: attributes.sectionDescription,
                    onChange: ( value ) => { setAttributes( { sectionDescription: value } ); },
                    placeholder: __( 'Enter section description...', 'boilerplate-theme' ),
                    rows: 3,
                } ),
                el( SelectControl, {
                    label: __( 'Columns', 'boilerplate-theme' ),
                    value: attributes.columns || 3,
                    options: [
                        { label: __( '1 Column', 'boilerplate-theme' ), value: 1 },
                        { label: __( '2 Columns', 'boilerplate-theme' ), value: 2 },
                        { label: __( '3 Columns', 'boilerplate-theme' ), value: 3 },
                        { label: __( '4 Columns', 'boilerplate-theme' ), value: 4 },
                    ],
                    onChange: ( value ) => { setAttributes( { columns: parseInt( value, 10 ) } ); },
                } ),
                el( SelectControl, {
                    label: __( 'Icon Style', 'boilerplate-theme' ),
                    value: attributes.iconStyle || 'colored',
                    options: [
                        { label: __( 'Colored Background', 'boilerplate-theme' ), value: 'colored' },
                        { label: __( 'Outline', 'boilerplate-theme' ), value: 'outline' },
                        { label: __( 'Minimal', 'boilerplate-theme' ), value: 'minimal' },
                    ],
                    onChange: ( value ) => { setAttributes( { iconStyle: value } ); },
                } ),
                el( SelectControl, {
                    label: __( 'Layout', 'boilerplate-theme' ),
                    value: attributes.layout || 'default',
                    options: [
                        { label: __( 'Default (Icon + Text)', 'boilerplate-theme' ), value: 'default' },
                        { label: __( 'Cards', 'boilerplate-theme' ), value: 'cards' },
                        { label: __( 'Minimal (Icon Left)', 'boilerplate-theme' ), value: 'minimal' },
                    ],
                    onChange: ( value ) => { setAttributes( { layout: value } ); },
                } )
            ),
            el( PanelBody, { title: __( 'Features', 'boilerplate-theme' ), initialOpen: true },
                features.map( ( feature, index ) => {
                    return el( 'div', { 
                        key: index, 
                        className: 'feature-item-editor',
                        style: { border: '1px solid #e2e8f0', borderRadius: '8px', padding: '16px', marginBottom: '16px', background: '#f8fafc' }
                    },
                        el( 'div', { style: { display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '12px' } },
                            el( 'strong', null, __( 'Feature', 'boilerplate-theme' ) + ' ' + ( index + 1 ) ),
                            el( 'div', null,
                                index > 0 && el( Button, { 
                                    variant: 'secondary', 
                                    size: 'small',
                                    onClick: () => moveFeature( index, -1 ),
                                    icon: 'arrow-up',
                                    'aria-label': __( 'Move up', 'boilerplate-theme' )
                                } ),
                                index < features.length - 1 && el( Button, { 
                                    variant: 'secondary', 
                                    size: 'small',
                                    onClick: () => moveFeature( index, 1 ),
                                    icon: 'arrow-down',
                                    'aria-label': __( 'Move down', 'boilerplate-theme' )
                                } ),
                                el( Button, { 
                                    variant: 'secondary', 
                                    size: 'small',
                                    onClick: () => removeFeature( index ),
                                    icon: 'trash',
                                    'aria-label': __( 'Remove feature', 'boilerplate-theme' )
                                } )
                            )
                        ),
                        el( TextControl, {
                            label: __( 'Icon', 'boilerplate-theme' ),
                            value: feature.icon || '',
                            onChange: ( value ) => updateFeature( index, 'icon', value ),
                            placeholder: __( 'e.g., rocket, shield, users', 'boilerplate-theme' ),
                            help: __( 'Enter icon class name or SVG code', 'boilerplate-theme' ),
                        } ),
                        el( TextControl, {
                            label: __( 'Title', 'boilerplate-theme' ),
                            value: feature.title || '',
                            onChange: ( value ) => updateFeature( index, 'title', value ),
                            placeholder: __( 'Feature title', 'boilerplate-theme' ),
                        } ),
                        el( TextareaControl, {
                            label: __( 'Description', 'boilerplate-theme' ),
                            value: feature.description || '',
                            onChange: ( value ) => updateFeature( index, 'description', value ),
                            placeholder: __( 'Feature description', 'boilerplate-theme' ),
                            rows: 2,
                        } ),
                        feature.link && feature.link.url && el( 'p', { style: { fontSize: '12px', color: '#64748b', marginTop: '8px' } },
                            '🔗 ', feature.link.title || feature.link.url
                        )
                    );
                } ),
                features.length === 0 && el( 'p', { className: 'editor-placeholder' }, __( 'No features added yet. Click "Add Feature" to get started.', 'boilerplate-theme' ) ),
                el( Button, {
                    variant: 'primary',
                    onClick: addFeature,
                    icon: 'plus',
                }, __( 'Add Feature', 'boilerplate-theme' ) )
            )
        ),
        // Preview in editor
        el( 'div', { className: 'block-feature-grid__container' },
            ( attributes.sectionTitle || attributes.sectionDescription ) && el( 'header', { className: 'block-feature-grid__header' },
                attributes.sectionTitle && el( 'h2', { className: 'block-feature-grid__title' }, attributes.sectionTitle ),
                attributes.sectionDescription && el( 'p', { className: 'block-feature-grid__description' }, attributes.sectionDescription )
            ),
            el( 'div', { 
                className: 'block-feature-grid__grid block-feature-grid--' + ( attributes.iconStyle || 'colored' ), 
                'data-columns': attributes.columns || 3 
            },
                features.map( ( feature, index ) => {
                    return el( 'article', { 
                        key: index, 
                        className: 'block-feature-grid__item' 
                    },
                        feature.icon && el( 'div', { className: 'block-feature-grid__icon' },
                            feature.icon.startsWith('<svg') ? 
                                el( 'div', { dangerouslySetInnerHTML: { __html: feature.icon } } ) :
                                el( 'i', { className: 'icon-' + feature.icon } )
                        ),
                        feature.title && el( 'h3', { className: 'block-feature-grid__title' }, feature.title ),
                        feature.description && el( 'p', { className: 'block-feature-grid__description' }, feature.description )
                    );
                } ),
                features.length === 0 && el( 'div', { className: 'block-feature-grid__empty' },
                    __( 'Add features in the block settings panel.', 'boilerplate-theme' )
                )
            )
        )
    );
};

// Register block natively in Gutenberg
registerBlockType( 'boilerplate/feature-grid', {
    apiVersion: 3,
    title: __( 'Feature Grid', 'boilerplate-theme' ),
    description: __( 'A responsive grid of feature cards with icons, titles, and descriptions.', 'boilerplate-theme' ),
    category: 'boilerplate-blocks',
    icon: 'grid-view',
    keywords: [ 'features', 'grid', 'cards', 'services', 'benefits' ],
    attributes: {
        sectionTitle: { type: 'string', default: '' },
        sectionDescription: { type: 'string', default: '' },
        features: { type: 'array', default: [] },
        columns: { type: 'number', default: 3 },
        iconStyle: { type: 'string', default: 'colored' },
        layout: { type: 'string', default: 'default' },
        align: { type: 'string', default: 'wide' },
    },
    supports: {
        align: [ 'wide', 'full' ],
        anchor: true,
        customClassName: true,
    },
    edit: FeatureGridEdit,
    save: () => null, // Render dynamically in PHP
} );
