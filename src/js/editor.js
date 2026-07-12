/**
 * Boilerplate Theme - Block Editor JavaScript
 * 
 * Handles block editor specific functionality:
 * - Block registration
 * - Block editor enhancements
 * - Custom block previews
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

(function (wp) {
    'use strict';

    var registerBlockType = wp.blocks.registerBlockType;
    var __ = wp.i18n.__;
    var _x = wp.i18n._x;
    var el = wp.element.createElement;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody = wp.components.PanelBody;
    var SelectControl = wp.components.SelectControl;
    var RangeControl = wp.components.RangeControl;
    var ToggleControl = wp.components.ToggleControl;
    var TextControl = wp.components.TextControl;
    var MediaUpload = wp.blockEditor.MediaUpload;
    var Button = wp.components.Button;

    /**
     * ==========================================================================
     * BLOCK STYLES FOR EDITOR
     * ==========================================================================
     */

    // Add custom styles to the block editor
    wp.domReady(function () {
        // Add theme-specific block styles
        var style = document.createElement('style');
        style.textContent =
            '.block--hero-section { ' +
            'border: 2px dashed var(--color-border-medium); ' +
            '}' +
            '.block--hero-section.is-selected { ' +
            'border-color: var(--color-primary); ' +
            '}' +
            '.block--feature-grid { ' +
            'border: 2px dashed var(--color-border-medium); ' +
            '}' +
            '.block--feature-grid.is-selected { ' +
            'border-color: var(--color-primary); ' +
            '}' +
            '.block-feature-grid__empty { ' +
            'padding: 3rem; ' +
            'text-align: center; ' +
            'background: var(--color-bg-secondary); ' +
            'border-radius: var(--radius-lg); ' +
            'border: 2px dashed var(--color-border-medium); ' +
            '}' +
            '.editor-block-list__block[data-type="boilerplate/hero-section"] .block-editor-block-list__block-title::before, ' +
            '.editor-block-list__block[data-type="boilerplate/feature-grid"] .block-editor-block-list__block-title::before { ' +
            'content: ""; ' +
            'display: inline-block; ' +
            'width: 16px; ' +
            'height: 16px; ' +
            'margin-right: 8px; ' +
            'background: var(--color-primary); ' +
            'border-radius: var(--radius-sm); ' +
            'vertical-align: middle; ' +
            '}';
        document.head.appendChild(style);
    });

    /**
     * ==========================================================================
     * CUSTOM BLOCK CATEGORY
     * ==========================================================================
     */

    // Add custom category for our blocks
    wp.hooks.addFilter(
        'blocks.getBlockCategories',
        'boilerplate/add-block-category',
        function (categories) {
            return [
                ...categories,
                {
                    slug: 'boilerplate-blocks',
                    title: __('Boilerplate Blocks', 'boilerplate-theme'),
                    icon: 'smiley',
                },
            ];
        }
    );

    /**
     * ==========================================================================
     * EXPORT FOR OTHER SCRIPTS
     * ==========================================================================
     */

    window.BoilerplateEditor = {
        // Expose utilities if needed
    };

})(window.wp);