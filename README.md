# Boilerplate Theme

A battle-tested, high-performance WordPress custom theme starter framework developed to maximize development velocity on bespoke projects. Built around native WordPress standards, native custom Gutenberg block registrations, and automated namespacing to establish a clean, production-ready architecture from day one.

## Features

- **Modern WordPress Standards**: PHP 8.0+, WordPress 6.5+, HTML5 semantic markup
- **Native Custom Blocks**: Two React-based custom blocks (Hero Section, Feature Grid) registered natively in Gutenberg with dynamic PHP rendering
- **SCSS Compilation**: Integrated Webpack (`@wordpress/scripts`) compilation with native SASS/SCSS support, supporting nested elements, variables, and media query mixins out of the box
- **Modular Architecture**: Auto-loading `inc/` directory modules
- **Developer Experience**: Comprehensive inline documentation, BEM CSS methodology, utility classes
- **Performance Optimized**: Lazy loading, minimal dependencies, clean asset enqueueing
- **Accessibility Ready**: Proper ARIA attributes, skip links, semantic HTML
- **Translation Ready**: Complete text domain support with POT file generation
- **Block Editor Support**: Editor styles matching frontend, custom block category

## Requirements

- WordPress 6.5+
- PHP 8.0+

## Installation

1. Upload the theme to `/wp-content/themes/boilerplate-theme/`
2. Run `npm install` inside the theme folder to install build tools.
3. Run `npm run build` to compile asset bundles.
4. Run the rename script: `./rename-theme.sh`
5. Activate the theme in WordPress Admin > Appearance > Themes
6. Configure menus in Appearance > Menus (Primary, Footer, Social)

## Quick Start

### Renaming the Theme

```bash
cd wp-content/themes/boilerplate-theme
./rename-theme.sh
```

The script will prompt for:
- New Theme Name (e.g., "My Awesome Theme")
- New Theme Slug (e.g., "my_awesome_theme")
- New Text Domain (e.g., "my-awesome-theme")
- PHP Prefix (e.g., "my_awesome_theme")

### Adding Custom Blocks

Custom blocks are built natively as dynamic block types:
1. Register the block in JavaScript (e.g. `src/blocks/your-block-name/index.js`) using `registerBlockType()`.
2. Add your custom block-specific styling in `./style.css` in the same directory and import it in `index.js`.
3. Add the block entry point to the list in `webpack.config.js`.
4. Run `npm run build` (or `npm run start` for watch mode) to transpile code and build assets.
5. Register the block and render callback in PHP inside `inc/acf-blocks.php`.
6. Create the markup template in `template-parts/blocks/your-block-name.php`.

Example structure:
```
src/
  blocks/
    your-block-name/
      index.js            # React editor script (with ESNext imports)
      style.css           # Block-specific styles
template-parts/
  blocks/
    your-block-name.php   # PHP render template
```

### Adding Custom Post Types

Create `inc/custom-post-types.php` - it will be auto-loaded:

```php
<?php
function my_prefix_register_post_types() {
    register_post_type( 'my_prefix_project', array(
        'labels' => array(
            'name' => __( 'Projects', 'text-domain' ),
            'singular_name' => __( 'Project', 'text-domain' ),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'show_in_rest' => true,
    ) );
}
add_action( 'init', 'my_prefix_register_post_types' );
```

## Theme Structure

```
boilerplate-theme/
├── assets/
│   └── css/
│       └── editor-style.css      # Static block editor iframe styling
├── build/                        # Compiled production assets (Git-ignored)
│   ├── feature-grid.js
│   ├── style-feature-grid.css
│   ├── hero-section.js
│   ├── style-hero-section.css
│   ├── main.js
│   ├── editor.js
│   └── *.asset.php               # Dependency mapping files
├── src/                          # Asset source files
│   ├── blocks/                   # Custom Gutenberg blocks (React + SASS)
│   │   ├── hero-section/
│   │   │   ├── index.js
│   │   │   └── style.scss
│   │   └── feature-grid/
│   │       ├── index.js
│   │       └── style.scss
│   ├── js/                       # Core javascript source files
│   │   ├── main.js
│   │   └── editor.js
│   └── theme/                    # Modular theme SASS styles
│       ├── _variables.scss
│       ├── _reset.scss
│       ├── _typography.scss
│       ├── _layout.scss
│       ├── _buttons.scss
│       ├── _forms.scss
│       ├── _cards.scss
│       ├── _blocks.scss
│       ├── _utilities.scss
│       ├── header.txt            # WordPress theme info metadata header
│       └── style.scss            # Main stylesheet compiler entry
├── inc/                          # Auto-loaded PHP modules
│   ├── template-tags.php         # Template helper functions
│   └── acf-blocks.php            # Custom block PHP registration logic
├── template-parts/
│   ├── blocks/                   # Block dynamic PHP markup templates
│   │   ├── hero-section.php
│   │   └── feature-grid.php
│   ├── content.php               # Default post content
│   ├── content-page.php          # Page content
│   ├── content-search.php        # Search results
│   └── content-none.php          # No posts found
├── languages/                    # Translation files
├── 404.php                       # 404 template
├── archive.php                   # Archive template
├── footer.php                    # Footer template
├── functions.php                 # Main theme file
├── header.php                    # Header template
├── index.php                     # Main template
├── page.php                      # Page template
├── search.php                    # Search template
├── single.php                    # Single post template
├── sidebar.php                   # Sidebar template
├── style.css                     # Compiled main stylesheet (Git-ignored)
├── package.json                  # NPM packages & build commands
├── webpack.config.js             # Webpack build entry config
└── rename-theme.sh               # Theme renaming script
```

## Key Functions

### Template Tags (inc/template-tags.php)
- `boilerplate_the_posts_navigation()` - Pagination
- `boilerplate_post_meta()` - Post meta display
- `boilerplate_post_author_bio()` - Author bio box
- `boilerplate_post_thumbnail()` - Featured image
- `boilerplate_get_excerpt()` - Custom excerpt
- `boilerplate_get_reading_time()` - Reading time estimate
- `boilerplate_breadcrumbs()` - Schema.org breadcrumbs

### Theme Helpers & Utilities (functions.php)
- `boilerplate_get_acf_field()` - Safe field retrieval with escaping
- `boilerplate_get_acf_image()` - Formatted image output
- `boilerplate_sanitize_class()` - BEM class generation
- `boilerplate_block_wrapper_open/close()` - Block wrapper helpers

### Hooks for Extensibility
- `boilerplate_before_header` / `boilerplate_after_header`
- `boilerplate_before_footer` / `boilerplate_after_footer`
- `boilerplate_before_main_loop` / `boilerplate_after_main_loop`
- `boilerplate_copyright_text` / `boilerplate_footer_credits`

## CSS Architecture

- **SCSS Compiler**: Main theme stylesheet (`style.css`) and custom blocks compile dynamically using SASS/SCSS.
- **Modular Partial Structure**: Theme styles split into logical partials (`_variables.scss`, `_reset.scss`, `_layout.scss`, etc.) inside `src/theme/` for high maintainability.
- **Custom Properties**: Design tokens inside `:root` variables.
- **BEM Methodology**: Clean element/modifier naming convention (`.block--name__element--modifier`).
- **Utility Generation**: Loops (`@for` and `@each`) used to dynamically generate grid layout spans and spacing gaps.
- **Responsive**: Mobile-first media query mixins (`@include mobile`).
- **Dark Mode**: Built-in support using `prefers-color-scheme`.

## JavaScript

- **Vanilla ES6+**: No jQuery dependency
- **Modular**: IIFE pattern with utility functions
- **Features**: Mobile nav, smooth scroll, lazy load fallback, header scroll effects

## Translation

Generate POT file:
```bash
wp i18n make-pot . languages/boilerplate-theme.pot
```

Create PO file:
```bash
msginit -l en_US -i languages/boilerplate-theme.pot -o languages/en_US.po
```

Compile MO:
```bash
msgfmt -o languages/en_US.mo languages/en_US.po
```

## Coding Standards

- **PHP**: PSR-12 + WordPress Coding Standards
- **CSS**: BEM + CSS Custom Properties
- **JS**: ES6+, ESLint recommended config
- **Security**: All output escaped, nonces for forms, capability checks

## Security Features

- Direct file access prevention
- Output escaping (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`)
- Nonce verification for AJAX
- Capability checks for admin actions
- XML-RPC disabled
- Emoji scripts removed
- WordPress version hidden

## Performance

- Conditional asset loading
- Native lazy loading images
- Minimal HTTP requests
- Optimized image sizes
- No jQuery dependency
- Efficient database queries

## License

GNU General Public License v2 or later

## Credits

An internal development framework engineered for modularity, clean code compliance, and rapid project scaffolding.
Inspired by WordPress Core themes, modern React block editor engineering, and best-practice development conventions.