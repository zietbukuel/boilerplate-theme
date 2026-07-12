<?php
/**
 * Boilerplate Theme - Template Tags
 * 
 * Contains reusable template tags for displaying posts, navigation, meta, etc.
 * These functions are used throughout the theme templates.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * =============================================================================
 * POST NAVIGATION
 * =============================================================================
 */

/**
 * Display pagination for archive pages.
 * Uses WordPress core paginate_links() with custom styling.
 * 
 * @param array $args Optional. Arguments for pagination.
 * @return void
 */
function boilerplate_the_posts_navigation( $args = array() ) {
    // Don't show pagination if there's only one page
    if ( $GLOBALS['wp_query']->max_num_pages <= 1 ) {
        return;
    }
    
    $default_args = array(
        'mid_size'           => 2,
        'prev_text'          => __( '&larr; Previous', 'boilerplate-theme' ),
        'next_text'          => __( 'Next &rarr;', 'boilerplate-theme' ),
        'screen_reader_text' => __( 'Posts navigation', 'boilerplate-theme' ),
        'type'               => 'list',
    );
    
    $args = wp_parse_args( $args, $default_args );
    
    // Get pagination links
    $pagination = paginate_links( $args );
    
    if ( $pagination ) {
        echo '<nav class="pagination" role="navigation" aria-label="' . esc_attr( $args['screen_reader_text'] ) . '">';
        echo '<ul class="pagination__list flex items-center justify-center gap-2">';
        echo $pagination;
        echo '</ul>';
        echo '</nav>';
    }
}

/**
 * Display post navigation for single posts (previous/next post links).
 * 
 * @param array $args Optional. Arguments for post navigation.
 * @return void
 */
function boilerplate_the_post_navigation( $args = array() ) {
    $default_args = array(
        'prev_text' => '<span class="nav-subtitle">' . __( 'Previous:', 'boilerplate-theme' ) . '</span> <span class="nav-title">%title</span>',
        'next_text' => '<span class="nav-subtitle">' . __( 'Next:', 'boilerplate-theme' ) . '</span> <span class="nav-title">%title</span>',
        'screen_reader_text' => __( 'Post navigation', 'boilerplate-theme' ),
    );
    
    $args = wp_parse_args( $args, $default_args );
    
    the_post_navigation( $args );
}

/**
 * =============================================================================
 * POST META
 * =============================================================================
 */

/**
 * Display post meta (author, date, categories, tags).
 * 
 * @param int|WP_Post $post Optional. Post ID or object. Defaults to global $post.
 * @return void
 */
function boilerplate_post_meta( $post = null ) {
    $post = get_post( $post );
    
    if ( ! $post ) {
        return;
    }
    
    $meta_items = array();
    
    // Author
    $author = get_the_author_meta( 'display_name', $post->post_author );
    $author_link = get_author_posts_url( $post->post_author );
    $meta_items[] = sprintf(
        '<span class="post-meta__author">%s <a href="%s" class="post-meta__link">%s</a></span>',
        esc_html__( 'By', 'boilerplate-theme' ),
        esc_url( $author_link ),
        esc_html( $author )
    );
    
    // Date
    $date = get_the_date( '', $post );
    $date_link = get_permalink( $post );
    $meta_items[] = sprintf(
        '<span class="post-meta__date">%s <a href="%s" class="post-meta__link"><time datetime="%s">%s</time></a></span>',
        esc_html__( 'on', 'boilerplate-theme' ),
        esc_url( $date_link ),
        esc_attr( get_the_date( 'c', $post ) ),
        esc_html( $date )
    );
    
    // Categories
    $categories = get_the_category( $post->ID );
    if ( $categories ) {
        $cat_links = array();
        foreach ( $categories as $category ) {
            $cat_links[] = sprintf(
                '<a href="%s" class="post-meta__category">%s</a>',
                esc_url( get_category_link( $category ) ),
                esc_html( $category->name )
            );
        }
        $meta_items[] = sprintf(
            '<span class="post-meta__categories">%s %s</span>',
            esc_html__( 'in', 'boilerplate-theme' ),
            implode( ', ', $cat_links )
        );
    }
    
    // Tags (only for posts)
    if ( 'post' === $post->post_type ) {
        $tags = get_the_tags( $post->ID );
        if ( $tags ) {
            $tag_links = array();
            foreach ( $tags as $tag ) {
                $tag_links[] = sprintf(
                    '<a href="%s" class="post-meta__tag">%s</a>',
                    esc_url( get_tag_link( $tag ) ),
                    esc_html( $tag->name )
                );
            }
            $meta_items[] = sprintf(
                '<span class="post-meta__tags">%s %s</span>',
                esc_html__( 'tagged', 'boilerplate-theme' ),
                implode( ', ', $tag_links )
            );
        }
    }
    
    // Output meta
    echo '<div class="post-meta flex flex-wrap items-center gap-3 text-sm text-gray-600">';
    echo implode( ' <span class="post-meta__separator" aria-hidden="true">|</span> ', $meta_items );
    echo '</div>';
}

/**
 * Display post author bio box.
 * 
 * @param int|WP_Post $post Optional. Post ID or object.
 * @return void
 */
function boilerplate_post_author_bio( $post = null ) {
    $post = get_post( $post );
    
    if ( ! $post ) {
        return;
    }
    
    $author_id = $post->post_author;
    $author_name = get_the_author_meta( 'display_name', $author_id );
    $author_description = get_the_author_meta( 'description', $author_id );
    $author_avatar = get_avatar( $author_id, 80 );
    $author_url = get_author_posts_url( $author_id );
    
    // Only show if author has description or avatar
    if ( ! $author_description && ! $author_avatar ) {
        return;
    }
    
    echo '<div class="author-bio flex gap-6 p-6 bg-gray-50 rounded-xl">';
    echo '<div class="author-bio__avatar flex-shrink-0">' . $author_avatar . '</div>';
    echo '<div class="author-bio__content flex-1">';
    echo '<h3 class="author-bio__name text-lg font-semibold">';
    echo sprintf(
        '<a href="%s" class="hover:underline">%s</a>',
        esc_url( $author_url ),
        esc_html( $author_name )
    );
    echo '</h3>';
    
    if ( $author_description ) {
        echo '<div class="author-bio__description text-gray-700 mt-2">' . wp_kses_post( $author_description ) . '</div>';
    }
    
    echo '</div></div>';
}

/**
 * =============================================================================
 * POST THUMBNAIL / FEATURED IMAGE
 * =============================================================================
 */

/**
 * Display the post featured image with responsive sizes.
 * 
 * @param int|WP_Post $post Optional. Post ID or object.
 * @param string $size Image size. Default 'large'.
 * @param array $attr Additional attributes.
 * @return void
 */
function boilerplate_post_thumbnail( $post = null, $size = 'large', $attr = array() ) {
    $post = get_post( $post );
    
    if ( ! $post || ! has_post_thumbnail( $post ) ) {
        return;
    }
    
    $default_attr = array(
        'loading' => 'lazy',
        'decoding' => 'async',
        'class' => 'post-thumbnail w-full h-auto',
    );
    
    $attr = array_merge( $default_attr, $attr );
    
    echo get_the_post_thumbnail( $post, $size, $attr );
}

/**
 * =============================================================================
 * CONTENT HELPERS
 * =============================================================================
 */

/**
 * Get the post excerpt with custom length and more text.
 * 
 * @param int $length Excerpt length in words. Default 55.
 * @param string $more_text Text to append. Default '...'.
 * @param int|WP_Post $post Optional. Post ID or object.
 * @return string The excerpt.
 */
function boilerplate_get_excerpt( $length = 55, $more_text = '&hellip;', $post = null ) {
    $post = get_post( $post );
    
    if ( ! $post ) {
        return '';
    }
    
    if ( has_excerpt( $post ) ) {
        return get_the_excerpt( $post );
    }
    
    $content = get_the_content( '', false, $post );
    $content = strip_shortcodes( $content );
    $content = wp_trim_words( $content, $length, $more_text );
    
    return $content;
}

/**
 * Display the post excerpt.
 * 
 * @param int $length Excerpt length in words.
 * @param string $more_text Text to append.
 * @param int|WP_Post $post Optional. Post ID or object.
 * @return void
 */
function boilerplate_the_excerpt( $length = 55, $more_text = '&hellip;', $post = null ) {
    echo wp_kses_post( boilerplate_get_excerpt( $length, $more_text, $post ) );
}

/**
 * Get reading time estimate for post content.
 * 
 * @param int|WP_Post $post Optional. Post ID or object.
 * @param int $words_per_minute Reading speed. Default 200.
 * @return string Formatted reading time (e.g., "5 min read").
 */
function boilerplate_get_reading_time( $post = null, $words_per_minute = 200 ) {
    $post = get_post( $post );
    
    if ( ! $post ) {
        return '';
    }
    
    $content = get_the_content( '', false, $post );
    $word_count = str_word_count( strip_tags( $content ) );
    $minutes = ceil( $word_count / $words_per_minute );
    
    return sprintf(
        _n( '%d min read', '%d min read', $minutes, 'boilerplate-theme' ),
        $minutes
    );
}

/**
 * Display reading time.
 * 
 * @param int|WP_Post $post Optional. Post ID or object.
 * @return void
 */
function boilerplate_the_reading_time( $post = null ) {
    echo '<span class="reading-time text-sm text-gray-500">' . esc_html( boilerplate_get_reading_time( $post ) ) . '</span>';
}

/**
 * =============================================================================
 * BREADCRUMBS
 * =============================================================================
 */

/**
 * Display breadcrumb navigation using schema.org markup.
 * 
 * @param array $args Optional. Arguments for breadcrumbs.
 * @return void
 */
function boilerplate_breadcrumbs( $args = array() ) {
    $defaults = array(
        'home_text'       => __( 'Home', 'boilerplate-theme' ),
        'separator'       => '/',
        'show_on_front'   => true,
        'show_on_home'    => false,
        'show_current'    => true,
        'container_class' => 'breadcrumbs',
        'item_class'      => 'breadcrumb-item',
        'link_class'      => 'breadcrumb-link',
    );
    
    $args = wp_parse_args( $args, $defaults );
    
    // Don't show on front page unless explicitly enabled
    if ( is_front_page() && ! $args['show_on_front'] ) {
        return;
    }
    
    // Don't show on home page unless explicitly enabled
    if ( is_home() && ! is_front_page() && ! $args['show_on_home'] ) {
        return;
    }
    
    $breadcrumbs = array();
    
    // Home link
    $breadcrumbs[] = array(
        'url'   => home_url( '/' ),
        'label' => $args['home_text'],
    );
    
    // Handle different page types
    if ( is_category() || is_tag() || is_tax() ) {
        $term = get_queried_object();
        $ancestors = get_ancestors( $term->term_id, $term->taxonomy );
        
        // Add ancestors in reverse order
        $ancestors = array_reverse( $ancestors );
        foreach ( $ancestors as $ancestor_id ) {
            $ancestor = get_term( $ancestor_id, $term->taxonomy );
            $breadcrumbs[] = array(
                'url'   => get_term_link( $ancestor ),
                'label' => $ancestor->name,
            );
        }
        
        if ( $args['show_current'] ) {
            $breadcrumbs[] = array(
                'url'   => '',
                'label' => $term->name,
                'current' => true,
            );
        }
        
    } elseif ( is_single() ) {
        $post = get_queried_object();
        
        if ( 'post' === $post->post_type ) {
            $categories = get_the_category( $post->ID );
            if ( $categories ) {
                // Use first category
                $category = $categories[0];
                $ancestors = get_ancestors( $category->term_id, 'category' );
                $ancestors = array_reverse( $ancestors );
                
                foreach ( $ancestors as $ancestor_id ) {
                    $ancestor = get_term( $ancestor_id, 'category' );
                    $breadcrumbs[] = array(
                        'url'   => get_term_link( $ancestor ),
                        'label' => $ancestor->name,
                    );
                }
                
                $breadcrumbs[] = array(
                    'url'   => get_term_link( $category ),
                    'label' => $category->name,
                );
            }
        } elseif ( is_post_type_archive( $post->post_type ) ) {
            $post_type_obj = get_post_type_object( $post->post_type );
            $breadcrumbs[] = array(
                'url'   => get_post_type_archive_link( $post->post_type ),
                'label' => $post_type_obj->labels->name,
            );
        }
        
        if ( $args['show_current'] ) {
            $breadcrumbs[] = array(
                'url'   => '',
                'label' => $post->post_title,
                'current' => true,
            );
        }
        
    } elseif ( is_page() ) {
        $page = get_queried_object();
        $ancestors = get_post_ancestors( $page->ID );
        $ancestors = array_reverse( $ancestors );
        
        foreach ( $ancestors as $ancestor_id ) {
            $ancestor = get_post( $ancestor_id );
            $breadcrumbs[] = array(
                'url'   => get_permalink( $ancestor ),
                'label' => $ancestor->post_title,
            );
        }
        
        if ( $args['show_current'] ) {
            $breadcrumbs[] = array(
                'url'   => '',
                'label' => $page->post_title,
                'current' => true,
            );
        }
        
    } elseif ( is_post_type_archive() ) {
        $post_type = get_query_var( 'post_type' );
        $post_type_obj = get_post_type_object( $post_type );
        
        if ( $args['show_current'] ) {
            $breadcrumbs[] = array(
                'url'   => '',
                'label' => $post_type_obj->labels->name,
                'current' => true,
            );
        }
        
    } elseif ( is_author() ) {
        $author = get_queried_object();
        
        if ( $args['show_current'] ) {
            $breadcrumbs[] = array(
                'url'   => '',
                'label' => sprintf( __( 'Author: %s', 'boilerplate-theme' ), $author->display_name ),
                'current' => true,
            );
        }
        
    } elseif ( is_date() ) {
        if ( is_year() ) {
            $breadcrumbs[] = array(
                'url'   => '',
                'label' => get_the_date( 'Y' ),
                'current' => true,
            );
        } elseif ( is_month() ) {
            $breadcrumbs[] = array(
                'url'   => get_year_link( get_the_date( 'Y' ) ),
                'label' => get_the_date( 'Y' ),
            );
            $breadcrumbs[] = array(
                'url'   => '',
                'label' => get_the_date( 'F' ),
                'current' => true,
            );
        } elseif ( is_day() ) {
            $breadcrumbs[] = array(
                'url'   => get_year_link( get_the_date( 'Y' ) ),
                'label' => get_the_date( 'Y' ),
            );
            $breadcrumbs[] = array(
                'url'   => get_month_link( get_the_date( 'Y' ), get_the_date( 'm' ) ),
                'label' => get_the_date( 'F' ),
            );
            $breadcrumbs[] = array(
                'url'   => '',
                'label' => get_the_date( 'j' ),
                'current' => true,
            );
        }
        
    } elseif ( is_search() ) {
        $breadcrumbs[] = array(
            'url'   => '',
            'label' => sprintf( __( 'Search results for: %s', 'boilerplate-theme' ), get_search_query() ),
            'current' => true,
        );
        
    } elseif ( is_404() ) {
        $breadcrumbs[] = array(
            'url'   => '',
            'label' => __( '404 - Page Not Found', 'boilerplate-theme' ),
            'current' => true,
        );
    }
    
    // Output breadcrumbs
    if ( count( $breadcrumbs ) > 1 || ( count( $breadcrumbs ) === 1 && $args['show_on_home'] ) ) {
        echo '<nav class="' . esc_attr( $args['container_class'] ) . '" aria-label="' . esc_attr__( 'Breadcrumb', 'boilerplate-theme' ) . '">';
        echo '<ol class="flex items-center gap-2 text-sm text-gray-600" itemscope itemtype="https://schema.org/BreadcrumbList">';
        
        foreach ( $breadcrumbs as $index => $crumb ) {
            $position = $index + 1;
            $is_last = ( $position === count( $breadcrumbs ) );
            
            echo '<li class="' . esc_attr( $args['item_class'] ) . '" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            
            if ( ! empty( $crumb['url'] ) && ! $crumb['current'] ) {
                echo '<a href="' . esc_url( $crumb['url'] ) . '" class="' . esc_attr( $args['link_class'] ) . ' hover:underline" itemprop="item">';
                echo '<span itemprop="name">' . esc_html( $crumb['label'] ) . '</span>';
                echo '</a>';
            } else {
                echo '<span class="text-gray-900 font-medium" aria-current="page" itemprop="name">' . esc_html( $crumb['label'] ) . '</span>';
            }
            
            echo '<meta itemprop="position" content="' . esc_attr( $position ) . '" />';
            
            // Separator (except last item)
            if ( ! $is_last ) {
                echo '<span class="breadcrumb-separator" aria-hidden="true">' . esc_html( $args['separator'] ) . '</span>';
            }
            
            echo '</li>';
        }
        
        echo '</ol>';
        echo '</nav>';
    }
}

/**
 * =============================================================================
 * COMMENTS
 * =============================================================================
 */

/**
 * Custom comment callback for wp_list_comments().
 * 
 * @param WP_Comment $comment Comment object.
 * @param array $args Arguments.
 * @param int $depth Depth of comment.
 * @return void
 */
function boilerplate_comment_callback( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    
    $classes = array( 'comment' );
    
    if ( $comment->comment_author_email === get_the_author_meta( 'email' ) ) {
        $classes[] = 'comment--author';
    }
    
    if ( $comment->user_id ) {
        $classes[] = 'comment--by-user';
    }
    
    ?>
    <li id="comment-<?php comment_ID(); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
        <article class="comment__body">
            <header class="comment__header flex items-start gap-4">
                <div class="comment__avatar flex-shrink-0">
                    <?php echo get_avatar( $comment, 60 ); ?>
                </div>
                <div class="comment__meta flex-1">
                    <div class="comment__author-name font-medium">
                        <?php comment_author_link(); ?>
                    </div>
                    <div class="comment__meta-time text-sm text-gray-500">
                        <a href="<?php echo esc_url( get_comment_link( $comment ) ); ?>">
                            <time datetime="<?php comment_time( 'c' ); ?>">
                                <?php comment_date(); ?> <?php comment_time(); ?>
                            </time>
                        </a>
                    </div>
                </div>
            </header>
            
            <div class="comment__content mt-3">
                <?php comment_text(); ?>
            </div>
            
            <?php if ( '0' === $comment->comment_approved ) : ?>
                <p class="comment__awaiting-moderation text-sm text-yellow-600 mt-3">
                    <?php _e( 'Your comment is awaiting moderation.', 'boilerplate-theme' ); ?>
                </p>
            <?php endif; ?>
            
            <footer class="comment__footer mt-3">
                <?php
                comment_reply_link( array_merge( $args, array(
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'    => '<span class="comment-reply-link">',
                    'after'     => '</span>',
                ) ) );
                ?>
            </footer>
        </article>
    </li>
    <?php
}

/**
 * =============================================================================
 * FALLBACK MENU
 * =============================================================================
 */

/**
 * Fallback menu when no menu is assigned to the primary location.
 * Displays a link to the Menus admin page for admins, or pages list for visitors.
 * 
 * @param array $args Arguments from wp_nav_menu().
 * @return void
 */
function boilerplate_fallback_menu( $args ) {
    if ( current_user_can( 'edit_theme_options' ) ) {
        $link = admin_url( 'nav-menus.php' );
        $text = __( 'Add a menu', 'boilerplate-theme' );
    } else {
        $link = home_url( '/' );
        $text = __( 'Home', 'boilerplate-theme' );
    }
    
    echo '<ul class="' . esc_attr( $args['menu_class'] ) . '">';
    echo '<li class="menu-item"><a href="' . esc_url( $link ) . '" class="nav-link">' . esc_html( $text ) . '</a></li>';
    echo '</ul>';
}

/**
 * =============================================================================
 * CUSTOM NAV WALKER
 * =============================================================================
 */

/**
 * Custom Nav Walker for clean, accessible menu markup.
 * Outputs BEM-style classes and proper ARIA attributes.
 * 
 * @package Boilerplate_Theme
 * @since 1.0.0
 */
class Boilerplate_Nav_Walker extends Walker_Nav_Menu {
    
    /**
     * Start the element output.
     * 
     * @param string $output Output string (passed by reference).
     * @param WP_Post $item Menu item object.
     * @param int $depth Depth of menu item.
     * @param array $args Menu arguments.
     * @return void
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' );
        
        $classes = array( 'nav-item' );
        $classes[] = 'nav-item--level-' . $depth;
        
        if ( $args->walker->has_children ) {
            $classes[] = 'nav-item--has-children';
        }
        
        if ( in_array( 'current-menu-item', $item->classes, true ) ) {
            $classes[] = 'nav-item--current';
        }
        
        if ( in_array( 'current-menu-ancestor', $item->classes, true ) ) {
            $classes[] = 'nav-item--ancestor';
        }
        
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names . '>';
        
        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target ) ? $item->target : '';
        $atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
        $atts['href']   = ! empty( $item->url ) ? $item->url : '#';
        $atts['class']  = 'nav-link';
        
        if ( $args->walker->has_children ) {
            $atts['class'] .= ' nav-link--has-children';
            $atts['aria-haspopup'] = 'true';
            $atts['aria-expanded'] = 'false';
        }
        
        if ( in_array( 'current-menu-item', $item->classes, true ) ) {
            $atts['class'] .= ' nav-link--current';
            $atts['aria-current'] = 'page';
        }
        
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
        
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        
        // Add dropdown indicator for parent items
        if ( $args->walker->has_children ) {
            $item_output .= '<span class="nav-link__indicator" aria-hidden="true">';
            $item_output .= '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>';
            $item_output .= '</span>';
        }
        
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    
    /**
     * Start submenu level.
     * 
     * @param string $output Output string (passed by reference).
     * @param int $depth Depth of menu.
     * @param array $args Menu arguments.
     * @return void
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth + 1 );
        $output .= "\n$indent<ul class=\"nav-submenu nav-submenu--level-" . ( $depth + 1 ) . "\">\n";
    }
    
    /**
     * End submenu level.
     * 
     * @param string $output Output string (passed by reference).
     * @param int $depth Depth of menu.
     * @param array $args Menu arguments.
     * @return void
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth + 1 );
        $output .= "$indent</ul>\n";
    }
    
    /**
     * End element output.
     * 
     * @param string $output Output string (passed by reference).
     * @param WP_Post $item Menu item object.
     * @param int $depth Depth of menu item.
     * @param array $args Menu arguments.
     * @return void
     */
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }
}