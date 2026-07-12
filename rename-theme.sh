#!/usr/bin/env bash
# ============================================================================
# Boilerplate Theme - Rename Script
# ============================================================================
# This script renames the boilerplate theme to your custom theme.
# It searches and replaces all occurrences of the default theme identifiers
# with your custom values across the entire theme directory.
#
# Usage: ./rename-theme.sh
# ============================================================================

set -euo pipefail

# -----------------------------------------------------------------------------
# CONFIGURATION - Default values (boilerplate identifiers)
# -----------------------------------------------------------------------------
DEFAULT_THEME_NAME="Boilerplate Theme"
DEFAULT_THEME_SLUG="boilerplate_theme"
DEFAULT_THEME_TEXTDOMAIN="boilerplate-theme"
DEFAULT_THEME_PREFIX="boilerplate_theme"
DEFAULT_THEME_URI="https://example.com/boilerplate-theme"

# -----------------------------------------------------------------------------
# COLORS FOR OUTPUT
# -----------------------------------------------------------------------------
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# -----------------------------------------------------------------------------
# HELPER FUNCTIONS
# -----------------------------------------------------------------------------

print_header() {
    echo -e "${CYAN}==============================================================================${NC}"
    echo -e "${CYAN}$1${NC}"
    echo -e "${CYAN}==============================================================================${NC}"
}

print_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Validate input is not empty
validate_not_empty() {
    local value="$1"
    local name="$2"
    
    if [[ -z "$value" ]]; then
        print_error "$name cannot be empty."
        return 1
    fi
    return 0
}

# Validate slug format (lowercase, underscores only)
validate_slug() {
    local slug="$1"
    
    if [[ ! "$slug" =~ ^[a-z][a-z0-9_]*$ ]]; then
        print_error "Slug must start with a letter and contain only lowercase letters, numbers, and underscores."
        return 1
    fi
    
    if [[ ${#slug} -gt 50 ]]; then
        print_error "Slug must be 50 characters or less."
        return 1
    fi
    
    return 0
}

# Validate text domain format (lowercase, hyphens only)
validate_textdomain() {
    local domain="$1"
    
    if [[ ! "$domain" =~ ^[a-z][a-z0-9-]*$ ]]; then
        print_error "Text domain must start with a letter and contain only lowercase letters, numbers, and hyphens."
        return 1
    fi
    
    return 0
}

# Validate theme name
validate_theme_name() {
    local name="$1"
    
    if [[ ${#name} -gt 100 ]]; then
        print_error "Theme name must be 100 characters or less."
        return 1
    fi
    
    return 0
}

# Confirm action with user
confirm_action() {
    local prompt="$1"
    local response
    
    while true; do
        read -p "$(echo -e "${YELLOW}$prompt [y/N]:${NC} ")" response
        case "$response" in
            [Yy]|[Yy][Ee][Ss]) return 0 ;;
            [Nn]|[Nn][Oo]|"") return 1 ;;
            *) print_warning "Please answer yes or no." ;;
        esac
    done
}

# -----------------------------------------------------------------------------
# MAIN SCRIPT
# -----------------------------------------------------------------------------

print_header "Boilerplate Theme - Rename Script"
echo ""
print_info "This script will rename the boilerplate theme to your custom values."
print_info "It will search and replace across all theme files."
echo ""

# Check if we're in the right directory
THEME_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
THEME_NAME=$(basename "$THEME_DIR")

print_info "Theme directory: $THEME_DIR"
print_info "Current theme folder name: $THEME_NAME"
echo ""

# Verify this looks like a boilerplate theme
if [[ ! -f "$THEME_DIR/style.css" ]] || ! grep -q "Boilerplate Theme" "$THEME_DIR/style.css" 2>/dev/null; then
    print_error "This doesn't appear to be the Boilerplate Theme directory."
    print_error "Please run this script from the theme root directory."
    exit 1
fi

# -----------------------------------------------------------------------------
# GET USER INPUT
# -----------------------------------------------------------------------------
print_header "Configuration"

# Theme Name
while true; do
    read -p "$(echo -e "${BLUE}New Theme Name (e.g., My Awesome Theme):${NC} ")" NEW_THEME_NAME
    if validate_theme_name "$NEW_THEME_NAME"; then
        break
    fi
done

# Theme Slug (PHP prefix, folder name)
while true; do
    read -p "$(echo -e "${BLUE}New Theme Slug (lowercase, underscores only, e.g., my_awesome_theme):${NC} ")" NEW_THEME_SLUG
    if validate_slug "$NEW_THEME_SLUG"; then
        break
    fi
done

# Text Domain (for translations)
while true; do
    read -p "$(echo -e "${BLUE}New Text Domain (lowercase, hyphens only, e.g., my-awesome-theme):${NC} ")" NEW_TEXTDOMAIN
    if validate_textdomain "$NEW_TEXTDOMAIN"; then
        break
    fi
done

# Theme Prefix (for PHP functions/classes - usually same as slug)
while true; do
    read -p "$(echo -e "${BLUE}New PHP Prefix [${NEW_THEME_SLUG}]:${NC} ")" NEW_THEME_PREFIX
    NEW_THEME_PREFIX=${NEW_THEME_PREFIX:-$NEW_THEME_SLUG}
    if validate_slug "$NEW_THEME_PREFIX"; then
        break
    fi
done

# Theme URI (optional)
read -p "$(echo -e "${BLUE}Theme URI [https://example.com/$NEW_THEME_SLUG]:${NC} ")" NEW_THEME_URI
NEW_THEME_URI=${NEW_THEME_URI:-"https://example.com/$NEW_THEME_SLUG"}

# Author info (optional)
read -p "$(echo -e "${BLUE}Author Name [Your Name]:${NC} ")" NEW_AUTHOR
NEW_AUTHOR=${NEW_AUTHOR:-"Your Name"}

read -p "$(echo -e "${BLUE}Author URI [https://example.com]:${NC} ")" NEW_AUTHOR_URI
NEW_AUTHOR_URI=${NEW_AUTHOR_URI:-"https://example.com"}

# Description (optional)
read -p "$(echo -e "${BLUE}Theme Description [A custom WordPress theme built on Boilerplate Theme]:${NC} ")" NEW_DESCRIPTION
NEW_DESCRIPTION=${NEW_DESCRIPTION:-"A custom WordPress theme built on Boilerplate Theme"}

echo ""
print_header "Summary"
echo -e "  Theme Name:      ${GREEN}$NEW_THEME_NAME${NC}"
echo -e "  Theme Slug:      ${GREEN}$NEW_THEME_SLUG${NC}"
echo -e "  Text Domain:     ${GREEN}$NEW_TEXTDOMAIN${NC}"
echo -e "  PHP Prefix:      ${GREEN}$NEW_THEME_PREFIX${NC}"
echo -e "  Theme URI:       ${GREEN}$NEW_THEME_URI${NC}"
echo -e "  Author:          ${GREEN}$NEW_AUTHOR${NC}"
echo -e "  Author URI:      ${GREEN}$NEW_AUTHOR_URI${NC}"
echo -e "  Description:     ${GREEN}$NEW_DESCRIPTION${NC}"
echo ""

if ! confirm_action "Proceed with these values?"; then
    print_info "Aborted."
    exit 0
fi

# -----------------------------------------------------------------------------
# BACKUP & REPLACE
# -----------------------------------------------------------------------------
print_header "Processing Files"

# Create backup directory
BACKUP_DIR="$THEME_DIR/.rename-backup-$(date +%Y%m%d-%H%M%S)"
mkdir -p "$BACKUP_DIR"
print_info "Created backup directory: $BACKUP_DIR"

# Files to process (exclude binary files, node_modules, .git, backup dir)
FILES_TO_PROCESS=$(find "$THEME_DIR" -type f \
    ! -path "*/node_modules/*" \
    ! -path "*/build/*" \
    ! -path "*/.git/*" \
    ! -path "*/.rename-backup-*" \
    ! -name "*.png" \
    ! -name "*.jpg" \
    ! -name "*.jpeg" \
    ! -name "*.gif" \
    ! -name "*.ico" \
    ! -name "*.woff" \
    ! -name "*.woff2" \
    ! -name "*.ttf" \
    ! -name "*.eot" \
    ! -name "*.min.css" \
    ! -name "*.min.js" \
    ! -name "*.map" \
    ! -name "*.log" \
    -print)

print_info "Found $(echo "$FILES_TO_PROCESS" | wc -l) files to process."

# Counter for replacements
TOTAL_REPLACEMENTS=0
FILES_MODIFIED=0

# Function to replace in a single file
replace_in_file() {
    local file="$1"
    local backup="$BACKUP_DIR${file#$THEME_DIR}"
    local backup_dir=$(dirname "$backup")
    
    # Create backup directory structure
    mkdir -p "$backup_dir"
    
    # Copy original to backup
    cp "$file" "$backup"
    
    # Perform replacements
    local replacements=0
    
    # Use perl for in-place replacement (handles multiline better than sed)
    # Replace Theme Name
    replacements=$((replacements + $(perl -pi -e "s/\Q$DEFAULT_THEME_NAME\E/$NEW_THEME_NAME/g" "$file" && echo 1 || echo 0) ))
    
    # Replace Theme Slug (folder name, text domain in paths)
    replacements=$((replacements + $(perl -pi -e "s/\Q$DEFAULT_THEME_SLUG\E/$NEW_THEME_SLUG/g" "$file" && echo 1 || echo 0) ))
    
    # Replace Text Domain
    replacements=$((replacements + $(perl -pi -e "s/\Q$DEFAULT_THEME_TEXTDOMAIN\E/$NEW_TEXTDOMAIN/g" "$file" && echo 1 || echo 0) ))
    
    # Replace Theme Prefix (PHP functions, classes)
    replacements=$((replacements + $(perl -pi -e "s/\Q$DEFAULT_THEME_PREFIX\E/$NEW_THEME_PREFIX/g" "$file" && echo 1 || echo 0) ))
    
    # Replace Theme URI
    replacements=$((replacements + $(perl -pi -e "s|\Q$DEFAULT_THEME_URI\E|$NEW_THEME_URI|g" "$file" && echo 1 || echo 0) ))
    
    # Replace Author
    replacements=$((replacements + $(perl -pi -e "s/Author: Boilerplate Theme Author/Author: $NEW_AUTHOR/g" "$file" && echo 1 || echo 0) ))
    replacements=$((replacements + $(perl -pi -e "s/Author URI: https:\/\/example.com/Author URI: ${NEW_AUTHOR_URI//\//\\/}/g" "$file" && echo 1 || echo 0) ))
    
    # Replace Description in style.css header
    replacements=$((replacements + $(perl -pi -e "s/Description: A battle-tested, high-performance WordPress custom theme starter framework developed to maximize development velocity on bespoke projects. Built around native WordPress standards, native custom Gutenberg block registrations, and automated namespacing to establish a clean, production-ready architecture from day one./Description: $NEW_DESCRIPTION/g" "$file" && echo 1 || echo 0) ))
    
    if [[ $replacements -gt 0 ]]; then
        FILES_MODIFIED=$((FILES_MODIFIED + 1))
        TOTAL_REPLACEMENTS=$((TOTAL_REPLACEMENTS + replacements))
        print_info "Modified: ${file#$THEME_DIR/} ($replacements replacements)"
    fi
}

# Process all files
while IFS= read -r file; do
    replace_in_file "$file"
done <<< "$FILES_TO_PROCESS"

print_success "Processed $FILES_MODIFIED files with $TOTAL_REPLACEMENTS total replacements."

# -----------------------------------------------------------------------------
# RENAME THEME DIRECTORY
# -----------------------------------------------------------------------------
print_header "Renaming Theme Directory"

PARENT_DIR=$(dirname "$THEME_DIR")
NEW_THEME_DIR="$PARENT_DIR/$NEW_THEME_SLUG"

if [[ "$THEME_DIR" != "$NEW_THEME_DIR" ]]; then
    if [[ -e "$NEW_THEME_DIR" ]]; then
        print_error "Directory '$NEW_THEME_SLUG' already exists in $PARENT_DIR"
        print_error "Please remove or rename it first."
        exit 1
    fi
    
    print_info "Renaming directory: $THEME_NAME -> $NEW_THEME_SLUG"
    mv "$THEME_DIR" "$NEW_THEME_DIR"
    print_success "Theme directory renamed."
else
    print_info "Theme directory name already matches slug, skipping."
fi

# -----------------------------------------------------------------------------
# UPDATE STYLE.CSS HEADER
# -----------------------------------------------------------------------------
print_header "Updating style.css Header"

STYLE_CSS="$NEW_THEME_DIR/style.css"

if [[ -f "$STYLE_CSS" ]]; then
    # Create new header
    cat > "$STYLE_CSS.tmp" << EOF
/*
Theme Name: $NEW_THEME_NAME
Theme URI: $NEW_THEME_URI
Author: $NEW_AUTHOR
Author URI: $NEW_AUTHOR_URI
Description: $NEW_DESCRIPTION
Version: 1.0.0
Tested up to: 6.5
Requires PHP: 8.0
License: GNU General Public License v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: $NEW_TEXTDOMAIN
Tags: custom-theme, block-theme, block-patterns, full-site-editing, block-editor, custom-colors, custom-logo, custom-menu, editor-style, featured-images, full-width-template, rtl-language-support, sticky-post, threaded-comments, translation-ready, wide-blocks, block-patterns, block-styles, wide-blocks, block-styles, wide-blocks, block-patterns, wide-blocks, block-styles
*/

EOF
    # Append the rest of the file (skip the old header)
    awk '/^\*\// {found=1; next} found {print}' "$STYLE_CSS" >> "$STYLE_CSS.tmp"
    mv "$STYLE_CSS.tmp" "$STYLE_CSS"
    print_success "style.css header updated."
else
    print_warning "style.css not found in new directory."
fi

# -----------------------------------------------------------------------------
# CREATE README FOR DEVELOPER
# -----------------------------------------------------------------------------
print_header "Creating Developer README"

cat > "$NEW_THEME_DIR/DEVELOPER_README.md" << 'EOF'
# Theme Developer Guide

This theme was generated from the **Boilerplate Theme** using the rename script.

## Theme Information

- **Theme Name**: {{THEME_NAME}}
- **Theme Slug**: {{THEME_SLUG}}
- **Text Domain**: {{TEXT_DOMAIN}}
- **PHP Prefix**: {{PHP_PREFIX}}

## Quick Start

1. **Install dependencies** in the theme folder: `npm install`
2. **Build assets**: `npm run build` (or `npm run start` for watch mode)
3. **Activate the theme** in WordPress Admin > Appearance > Themes
4. **Configure menus** in Appearance > Menus (Primary, Footer, Social)
5. **Set up widgets** in Appearance > Widgets (Sidebar, Footer areas 1-4)
6. **Customize** in Appearance > Customize (Logo, Colors, Background)

## Adding New Blocks

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

## Adding Custom Post Types

Create `inc/custom-post-types.php` - it will be auto-loaded:

```php
<?php
function {{PHP_PREFIX}}_register_post_types() {
    register_post_type('{{PHP_PREFIX}}_project', array(
        'labels' => array(
            'name' => __('Projects', '{{TEXT_DOMAIN}}'),
            'singular_name' => __('Project', '{{TEXT_DOMAIN}}'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
    ));
}
add_action('init', '{{PHP_PREFIX}}_register_post_types');
```

## Adding Taxonomies

Create `inc/taxonomies.php`:

```php
<?php
function {{PHP_PREFIX}}_register_taxonomies() {
    register_taxonomy('{{PHP_PREFIX}}_category', '{{PHP_PREFIX}}_project', array(
        'label' => __('Categories', '{{TEXT_DOMAIN}}'),
        'hierarchical' => true,
        'show_in_rest' => true,
    ));
}
add_action('init', '{{PHP_PREFIX}}_register_taxonomies');
```

## Theme Structure

```
{{THEME_SLUG}}/
├── assets/
│   ├── css/
│   │   ├── editor-style.css      # Block editor styles
│   │   └── blocks/               # Block-specific styles
│   ├── js/
│   │   ├── main.js               # Frontend JS
│   │   ├── editor.js             # Editor JS
│   │   └── blocks/               # Block-specific JS
│   └── images/
├── inc/                          # Auto-loaded PHP modules
│   ├── template-tags.php         # Template helper functions
│   ├── acf-blocks.php            # Custom block registration
│   ├── custom-post-types.php     # (create this) Custom post types
│   ├── taxonomies.php            # (create this) Custom taxonomies
│   ├── shortcodes.php            # (create this) Shortcodes
│   ├── ajax.php                  # (create this) AJAX handlers
│   └── rest-api.php              # (create this) REST API endpoints
├── template-parts/
│   ├── blocks/                   # Block templates
│   │   ├── hero-section.php
│   │   └── feature-grid.php
│   ├── content.php               # Default post content
│   ├── content-none.php          # No posts found
│   └── content-{post-type}.php   # Post type specific
├── languages/                    # Translation files
├── header.php                    # Header template
├── footer.php                    # Footer template
├── index.php                     # Main template
├── functions.php                 # Main theme file
├── style.css                     # Main stylesheet
├── screenshot.png                # Theme screenshot (add this)
└── DEVELOPER_README.md           # This file
```

## Coding Standards

- **PHP**: PSR-12 + WordPress Coding Standards
- **CSS**: BEM methodology, CSS Custom Properties
- **JS**: ES6+, vanilla (no jQuery dependency)
- **Escaping**: Always escape output (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`)
- **Prefixing**: All functions/classes/hooks use `{{PHP_PREFIX}}_`

## Useful Hooks

```php
// Add custom image sizes
add_image_size('{{PHP_PREFIX}}_custom', 800, 600, true);

// Add editor styles
add_editor_style('assets/css/editor-style.css');

// Add block categories
add_filter('block_categories_all', function($categories) {
    return array_merge($categories, array(array(
        'slug' => '{{PHP_PREFIX}}-blocks',
        'title' => __('{{THEME_NAME}} Blocks', '{{TEXT_DOMAIN}}'),
    )));
});
```

## Translation

1. Generate POT file: `wp i18n make-pot . languages/{{TEXT_DOMAIN}}.pot`
2. Create PO file: `msginit -l en_US -i languages/{{TEXT_DOMAIN}}.pot -o languages/en_US.po`
3. Compile MO: `msgfmt -o languages/en_US.mo languages/en_US.po`

## Performance Tips

- Use `wp_enqueue_script/style` with proper dependencies
- Leverage `add_theme_support('lazy-loading-images')` (enabled by default)
- Use `loading="lazy"` on images (automatic in WP 5.5+)
- Minify CSS/JS for production (use build tools)
- Enable object caching (Redis/Memcached)

## Security

- All output is escaped
- Nonces used for forms/AJAX
- Capabilities checked for admin actions
- XML-RPC disabled by default
- REST API restricted to authenticated users (optional)

## Support

- WordPress Coding Standards: https://github.com/WordPress/WordPress-Coding-Standards
- Webpack Asset Compiling: https://developer.wordpress.org/block-editor/packages/packages-scripts/
- Block Editor Handbook: https://developer.wordpress.org/block-editor/
EOF

# Replace placeholders in README
sed -i "s/{{THEME_NAME}}/$NEW_THEME_NAME/g" "$NEW_THEME_DIR/DEVELOPER_README.md"
sed -i "s/{{THEME_SLUG}}/$NEW_THEME_SLUG/g" "$NEW_THEME_DIR/DEVELOPER_README.md"
sed -i "s/{{TEXT_DOMAIN}}/$NEW_TEXTDOMAIN/g" "$NEW_THEME_DIR/DEVELOPER_README.md"
sed -i "s/{{PHP_PREFIX}}/$NEW_THEME_PREFIX/g" "$NEW_THEME_DIR/DEVELOPER_README.md"

print_success "DEVELOPER_README.md created."

# -----------------------------------------------------------------------------
# FINAL SUMMARY
# -----------------------------------------------------------------------------
print_header "Rename Complete!"

echo -e "${GREEN}✓${NC} Theme renamed from '$DEFAULT_THEME_NAME' to '$NEW_THEME_NAME'"
echo -e "${GREEN}✓${NC} Theme slug: $NEW_THEME_SLUG"
echo -e "${GREEN}✓${NC} Text domain: $NEW_TEXTDOMAIN"
echo -e "${GREEN}✓${NC} PHP prefix: $NEW_THEME_PREFIX"
echo -e "${GREEN}✓${NC} $FILES_MODIFIED files modified with $TOTAL_REPLACEMENTS replacements"
echo -e "${GREEN}✓${NC} Theme directory renamed"
echo -e "${GREEN}✓${NC} style.css header updated"
echo -e "${GREEN}✓${NC} DEVELOPER_README.md created"
echo ""
print_info "Backup saved to: $BACKUP_DIR"
print_info "New theme location: $NEW_THEME_DIR"
echo ""
print_warning "Next steps:"
echo "  1. Run 'npm install' inside the new theme folder to install compiler tools"
echo "  2. Run 'npm run build' to compile block and stylesheet assets"
echo "  3. Activate the theme in WordPress Admin > Appearance > Themes"
echo "  4. Configure menus in Appearance > Menus"
echo "  5. Add a screenshot.png (1200x900) to the theme root"
echo "  6. Run 'composer install' if using Composer dependencies"
echo ""
print_success "Happy theming! 🎉"