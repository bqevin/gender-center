<?php 
/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 * @package The Landscaper
 */

function thelandscaper_sidebars() {
	// Blog Page Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'the-landscaper-wp' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Sidebar on the blog page.', 'the-landscaper-wp' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' 	=> '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );

	// Header 'Sidebar'
	register_sidebar( array(
		'name' 			=> esc_html__( 'Header', 'the-landscaper-wp' ),
		'id' 			=> 'topbar-widgets',
		'description' 	=>  esc_html__( 'Widget area in the Topbar for Contact Info', 'the-landscaper-wp'),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' 	=> '</div>',
	) );

	// Default Sidebar
	register_sidebar( array(
		'name' 			=> esc_html__( 'Page Sidebar', 'the-landscaper-wp' ),
		'id' 			=> 'page-sidebar',
		'description' 	=> esc_html__( 'Sidebar on regular pages', 'the-landscaper-wp'),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' 	=> '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );

	// WooCommerce Sidebar
	if ( thelandscaper_woocommerce_active() ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Shop Sidebar', 'the-landscaper-wp'),
			'id'            => 'shop-sidebar',
			'description'   => esc_html__( 'Sidebar for the shop page', 'the-landscaper-wp'),
			'class'         => 'sidebar',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>'
		) );
	}

	// Footer Sidebar
	$main_footer_columns = (int)get_theme_mod( 'qt_footer_columns', 4 );

	if ( $main_footer_columns > 0 ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer', 'the-landscaper-wp' ),
				'id'            => 'main-footer',
				'description'   => esc_html__( 'Change column amount at: Appearance &gt; Customize &gt; QT: Theme Options &gt; Footer.', 'the-landscaper-wp' ),
				'before_widget' => sprintf( '<div class="col-xs-12 col-md-%d"><div class="widget w-footer %%2$s">', round( 12 / $main_footer_columns ) ),
				'after_widget'  => '</div></div>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>'
			)
		);
	}
}
add_action( 'widgets_init', 'thelandscaper_sidebars' );