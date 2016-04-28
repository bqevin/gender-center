<?php
/**
 * WooCommerce Integration
 *
 * @package The Landscaper
 */

if ( thelandscaper_woocommerce_active() ) {

	/**
	 * Remove the default WooCommerce wrappers
	 */
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

	/**
	 * Adding custom wrappers
	 */
	add_action('woocommerce_before_main_content', 'thelandscaper_wrapper_start', 10);
	add_action('woocommerce_after_main_content', 'thelandscaper_wrapper_end', 10);

	function thelandscaper_wrapper_start() {
		$sidebar = thelandscaper_single_product_sidebar();
		get_template_part( 'parts/main-title' );
		?>
		
		<div class="content">
			<div class="container">
				<div class="row">
					<main class="col-xs-12 <?php echo 'Left' === $sidebar ? 'col-md-9 col-md-push-3' : ''; echo 'Right' === $sidebar ? 'col-md-9' : '';?>">
		<?php
	}

	function thelandscaper_wrapper_end() {
		$sidebar = thelandscaper_single_product_sidebar(); 
		?>
					</main>
		
					<?php if ( 'Hide' !== $sidebar ) : ?>
						<div class="col-xs-12 col-md-3<?php echo 'Left' === $sidebar ? ' col-md-pull-9' : ''; ?>">
							<aside class="sidebar">
								<?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
									<?php dynamic_sidebar( 'shop-sidebar' ); ?>
								<?php endif; ?>
							</aside>
						</div>
					<?php endif ?>

				</div>
			</div>
		</div>
	<?php
	}

	/**
	 * Show the page title in the main title area
	 */
	add_filter( 'woocommerce_show_page_title', '__return_false' );

	/**
	 * Set our own sidebar option
	 */
	add_filter( 'woocommerce_get_sidebar', '__return_false' );

	/**
	 * Use own breadcrumbs
	 */
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

	/**
	 * Change number or products per row to 3
	 */
	if ( !function_exists( 'thelandscaper_loop_columns' ) ) {
		function thelandscaper_loop_columns() {
			// 4 products per row
			return 4;
		}
		add_filter( 'loop_shop_columns', 'thelandscaper_loop_columns' );
	}

	/**
	 * Display number of products per page from the theme customizer
	 */
	function thelandscaper_products_per_page() {
		return get_theme_mod( 'qt_shop_products_per_page', 8 );
	}
	add_filter( 'loop_shop_per_page', 'thelandscaper_products_per_page', 20 );

	/**
	 * The position of the sidebar for single product and shop base
	 */
	function thelandscaper_single_product_sidebar() {
		if ( is_product() ) {
			
			// Get the single product sidebar theme mod option
			return get_theme_mod( 'qt_single_product_sidebar', 'Right' );
		} else {
			
			// Get the sidebar option field for the WooCommerce page
			$shop_sidebar = get_field( 'display_sidebar', (int)get_option( 'woocommerce_shop_page_id' ) );
			
			// If Sidebar isn't set hide the sidebar
			if( ! $shop_sidebar ) { 
				$shop_sidebar = 'Hide';
			}
			
			// Return the sidebar
			return $shop_sidebar;
		}
	}

	/**
	 * Set the amount of related products shown at the bottom on product pages
	 */
	function thelandscaper_related_products( $args ) {
		// 4 related products
		$args['posts_per_page'] = 4;
		// arranged in columns
		$args['columns'] = 4;

		return $args;
	}
	add_filter( 'woocommerce_output_related_products_args', 'thelandscaper_related_products' );
}