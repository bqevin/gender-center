<?php
/**
 * Filters for the Theme
 *
 * @package The Landscaper
 */

/**
 * Add shortcodes in widgets
 */
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Custom tag font size
 */
if ( ! function_exists( 'thelandscaper_tag_cloud_sizes' ) ) {
    function thelandscaper_tag_cloud_sizes( $args ) {
    	$args['number'] = 12;
    	$args['largest'] = 11;
    	$args['smallest'] = 9;
    	return $args;
    }
    add_filter( 'widget_tag_cloud_args', 'thelandscaper_tag_cloud_sizes' );
}

/**
 * Wrap first word of widget title a <span>
 */
if ( ! function_exists( 'thelandscaper_widget_title' ) ) {
    function thelandscaper_widget_title( $title ) {

        // Cut the title to 2 parts
        $title_parts = explode(' ', $title, 2);

        // Throw first word inside a span
        $title = '<span class="light">' . $title_parts[0] . '</span>';
        
        // Add the the rest of the title if exist
        if( isset( $title_parts[1] ) ) {
            $title .= ' ' . $title_parts[1];
        }

        // Return title if isset
        if( $title_parts[0] ) {
            return $title;
        }
    }
    add_filter( 'widget_title', 'thelandscaper_widget_title' );
}

/**
 * The Content More Link
 */
if ( ! function_exists( 'thelandscaper_read_more_link' ) ) {
    function thelandscaper_read_more_link() {
        return '<a class="read more" href="' . get_permalink() . '">' . esc_html__( 'READ MORE', 'the-landscaper-wp' ) . '</a>';
    }
    add_filter( 'the_content_more_link', 'thelandscaper_read_more_link' );
}

/**
 * Add Custom styles to the Formats Dropdown in TinyMCE
 */
if ( ! function_exists( 'thelandscaper_tinymce_shortcodes' ) ) {
    function thelandscaper_tinymce_shortcodes( $settings ) {

        $headings = array(
            array(
                'title'   => esc_html__( 'Heading 1', 'the-landscaper-wp' ),
                'block'   => 'h1',
                'classes' => 'custom-title'
            ),
            array(
                'title'   => esc_html__( 'Heading 2', 'the-landscaper-wp' ),
                'block'   => 'h2',
                'classes' => 'custom-title'
            ),
            array(
                'title'   => esc_html__( 'Heading 3', 'the-landscaper-wp' ),
                'block'   => 'h3',
                'classes' => 'custom-title'
            ),
            array(
                'title'   => esc_html__( 'Heading 4', 'the-landscaper-wp' ),
                'block'   => 'h4',
                'classes' => 'custom-title'
            ),
            array(
                'title'   => esc_html__( 'Heading 5', 'the-landscaper-wp' ),
                'block'   => 'h5',
                'classes' => 'custom-title'
            ),
            array(
                'title'   => esc_html__( 'Heading 6', 'the-landscaper-wp' ),
                'block'   => 'h6',
                'classes' => 'custom-title'
            ),
        );

        $style_formats = array(
            array(
                'title'   => esc_html__( 'QT: Custom Headings', 'the-landscaper-wp' ),
                'items'   => $headings
            )
        );

    $settings['style_formats_merge'] = true;
    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

  }
  add_filter( 'tiny_mce_before_init', 'thelandscaper_tinymce_shortcodes' );
}

/**
 * Enable font size and custom heading buttons in the tiny mce editor
 */
if ( ! function_exists( 'thelandscaper_tinymce_more_buttons' ) ) {
    function thelandscaper_tinymce_more_buttons( $buttons ) {
        $buttons[3] = 'styleselect';
        $buttons[2] = 'fontsizeselect';
        
        return $buttons;
    }
    add_filter( 'mce_buttons_3', 'thelandscaper_tinymce_more_buttons');
}

/**
 * Creates the style from the array for the page headers
 */
if ( ! function_exists( 'thelandscaper_header_array' ) ) {
    function thelandscaper_header_array( $settings ) {

        // Begin of the style tag
        $array_style = 'style="';
        
        foreach ( $settings as $key => $value ) {

            if( $value ) {
            
                // If background isset add url()
                if( 'background-image' === $key ) {
                    $array_style .= $key . ': url(\'' . esc_url( $value ) . '\'); ';
                }
                else {
                    $array_style .= $key . ': ' . esc_attr( $value ) . '; ';
                }
            }
        }

        // End of the style tag
        $array_style .= '"';

        // Return the array
        return $array_style;
    }
}

/**
 * Define the custom options for the SiteOrigin Page Builder
 */
if ( ! function_exists( 'thelandscaper_define_custom_pagebuilder_options' ) ) {
    function thelandscaper_define_custom_pagebuilder_options( $fields ) {

        $fields['white_widget_title'] = array(
            'name'          => esc_html__( 'White Widget Title', 'the-landscaper-wp' ),
            'type'          => 'checkbox',
            'group'         => 'design',
            'label'         => esc_html__( 'Use white colored widget title', 'the-landscaper-wp' ),
            'priority'      => 16,
        );

        $fields['text_center'] = array(
            'name'          => esc_html__( 'Text Center', 'the-landscaper-wp' ),
            'type'          => 'checkbox',
            'group'         => 'design',
            'label'         => esc_html__( 'Center all text in widget', 'the-landscaper-wp' ),
            'priority'      => 17,
        );

        $fields['border_box'] = array(
            'name'          => esc_html__( 'Border Widget', 'the-landscaper-wp' ),
            'type'          => 'checkbox',
            'group'         => 'design',
            'label'         => esc_html__( 'Set a border around the widget', 'the-landscaper-wp' ),
            'priority'      => 18,
        );

        $fields['content_box'] = array(
            'name'          => esc_html__( 'Border Widget + Title', 'the-landscaper-wp' ),
            'type'          => 'checkbox',
            'group'         => 'design',
            'label'         => esc_html__( 'Set a border around the widget and use a slightly smaller title', 'the-landscaper-wp' ),
            'priority'      => 19,
        );

        return $fields;
    }

    add_filter( 'siteorigin_panels_widget_style_fields', 'thelandscaper_define_custom_pagebuilder_options' );
}

/**
 * Add some custom option to the SiteOrigin Page Builder widget styles panel
 */
if ( ! function_exists( 'thelandscaper_add_custom_options_to_pagebuilder' ) ) {
    function thelandscaper_add_custom_options_to_pagebuilder( $attributes, $args ) {

        if ( ! empty( $args['white_widget_title'] ) ) {
            array_push( $attributes['class'], 'white' );
        }

        if ( ! empty( $args['text_center'] ) ) {
            array_push( $attributes['class'], 'text-center' );
        }

        if ( ! empty( $args['border_box'] ) ) {
            array_push( $attributes['class'], 'border-box' );
        }

        if ( ! empty( $args['content_box'] ) ) {
            array_push( $attributes['class'], 'content-box' );
        }

        return $attributes;
    }
    add_filter( 'siteorigin_panels_widget_style_attributes', 'thelandscaper_add_custom_options_to_pagebuilder', 10, 2 );
}

/**
 * Change names & slug to gallery from portfolio CPT
 *
 */
if ( ! function_exists( 'thelandscaper_portfolio_cpt_change' ) ) {
    function thelandscaper_portfolio_cpt_change( array $args ) {
        $labels = array(
            'name'               => esc_html__( 'Galleries', 'the-landscaper-wp' ),
            'singular_name'      => esc_html__( 'Gallery', 'the-landscaper-wp' ),
            'add_new'            => esc_html__( 'Add New Gallery', 'the-landscaper-wp' ),
            'add_new_item'       => esc_html__( 'Add New Gallery', 'the-landscaper-wp' ),
            'edit_item'          => esc_html__( 'Edit Gallery', 'the-landscaper-wp' ),
            'new_item'           => esc_html__( 'Add New Gallery', 'the-landscaper-wp' ),
            'view_item'          => esc_html__( 'View Gallery', 'the-landscaper-wp' ),
            'search_items'       => esc_html__( 'Search Galleries', 'the-landscaper-wp' ),
            'not_found'          => esc_html__( 'No galleries found', 'the-landscaper-wp' ),
            'not_found_in_trash' => esc_html__( 'No galleries found in trash', 'the-landscaper-wp' ),
        );
        $args['labels'] = $labels;

        $args['rewrite'] = array( 'slug' => get_theme_mod( 'qt_gallery_slug', 'gallery' ) );
        $args['has_archive'] = true;

        return $args;
    }
    add_filter( 'portfolioposttype_args', 'thelandscaper_portfolio_cpt_change' );
}

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) {
    function thelandscaper_wp_title( $title, $sep ) {
       
       if ( is_feed() ) {
            return $title;
        }
        
        global $page, $paged;
        
        // Add the blog name
        $title .= get_bloginfo( 'name', 'display' );
        
        // Add the blog description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        
        if ( $site_description && ( is_home() || is_front_page() ) ) {
            $title .= " $sep $site_description";
        }
        
        // Add a page number if necessary:
        if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
            $title .= " $sep " . sprintf( esc_html__( 'Page %s', 'the-landscaper-wp' ), max( $paged, $page ) );
        }
        return $title;
    }
    add_filter( 'wp_title', 'thelandscaper_wp_title', 10, 2 );

    /**
    * Title shim for sites older than WordPress 4.1.
    *
    * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
    * @todo Remove this function when WordPress 4.3 is released.
    */
    function thelandscaper_render_title() { ?>
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <?php
    }
    add_action( 'wp_head', 'thelandscaper_render_title' );
}