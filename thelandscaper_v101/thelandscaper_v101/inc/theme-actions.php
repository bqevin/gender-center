<?php
/**
 * Functions for the Theme
 *
 * @package The Landscaper
 */

/**
 * Check if WooCommerce is active
 */
if ( ! function_exists( 'thelandscaper_woocommerce_active' ) ) {
	function thelandscaper_woocommerce_active() {
		return class_exists( 'Woocommerce' );
	}
}

/**
 * Return the Google Font URL
 */
if ( ! function_exists( 'thelandscaper_fonts_slug' ) ) {
	function thelandscaper_fonts_slug() {
	    $font_url = '';

		/*
		Translators: If there are characters in your language that are not supported
		by chosen font(s), translate this to 'off'. Do not translate into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Google font: on or off', 'the-landscaper-wp' ) ) {
			$font_url = add_query_arg( 'family', urlencode( 'Roboto Slab:400,700|Roboto:400,700&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
		}

		return $font_url;
	}
}


/*
 * For Boxed Layout or Sticky Nav add class to the body
 */
if ( ! function_exists( 'thelandscaper_body_class' ) ) {
	function thelandscaper_body_class() {
		
		$class = array();

		// If theme mod isset to boxed add body.boxed
		if ( 'boxed' === get_theme_mod( 'qt_theme_layout', 'wide' ) ) {
			$class[] = 'boxed';
		}

		// If theme mod isset to sticky navigation add body.sticky
		if ( 'sticky' === get_theme_mod( 'qt_nav_position', 'static' ) ) {
			$class[] = 'fixed-navigation';
		}

		// If theme mod and ACF page option isset to hide topbar add body.no-topbar
		if ( 'hide' === get_theme_mod( 'qt_topbar', 'show' ) || 'hide' === get_field( 'topbar' ) ) {
			$class[] = 'no-topbar';
		}

		// If theme mod isset to wide header add body.header-wide
		if ( 'wide' === get_theme_mod( 'qt_nav_layout', 'default' ) ) {
			$class[] = 'header-wide';
		}

		if ( is_multi_author() ) {
			$class[] = 'group-blog';
		}

		return implode( ' ', $class );
	}
}

/*
 * Return the header layout
 */
if ( ! function_exists( 'thelandscaper_header_layout' ) ) {
	function thelandscaper_header_layout() {

		if( 'wide' === get_theme_mod( 'qt_nav_layout', 'default' ) ) {
			$header = 'wide';
		} else {
			$header = 'default';
		}

		return $header;
	}
}

/**
 * Slider Image Sizes for Fullwidth Slider Page Template
 */
if ( ! function_exists( 'thelandscaper_srcset_sizes' ) ) {
	function thelandscaper_srcset_sizes( $img_id, $sizes ) {
	    $srcset = array();

	    foreach ( $sizes as $size ) {
	        $img = wp_get_attachment_image_src( $img_id, $size );
	        $srcset[] = sprintf( '%s %sw', $img[0], $img[1] );
	    }

	    return implode( ', ' , $srcset );
	}
}

/**
 * Generare a ligter/darker color based on a #hex color input
 * 
 */
if ( ! function_exists( 'thelandscaper_adjust_color' ) ) {
	function thelandscaper_adjust_color( $hex, $steps ) {
	    // Steps should be between -255 and 255. Negative = darker, positive = lighter
	    $steps = max(-255, min(255, $steps));

	    // Normalize into a six character long hex string
	    $hex = str_replace('#', '', $hex);
	    if (strlen($hex) == 3) {
	        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
	    }

	    // Split into three parts: R, G and B
	    $color_parts = str_split($hex, 2);
	    $return = '#';

	    foreach ($color_parts as $color) {
	        $color   = hexdec($color); // Convert to decimal
	        $color   = max(0,min(255,$color + $steps)); // Adjust color
	        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
	    }

	    return $return;
	}
}

/**
 * Essential Grid - hide purchase notice
 * No custom prefix because it is a Essential Grid function
 */
if ( function_exists( 'set_ess_grid_as_theme' ) ) {
	define( 'ESS_GRID_AS_THEME', true );
	set_ess_grid_as_theme();
}