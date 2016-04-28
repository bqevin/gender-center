<?php
/**
 * Main Title Template Part
 *
 * @package The Landscaper
 */

$header_attr = '';
$headtag 	 = is_single() ? 'h2' : 'h1';
$get_id 	 = get_the_ID();

if ( is_home() || is_singular( 'post' ) ) {
	$page_id = absint( get_option( 'page_for_posts' ) );
	$get_id  = $page_id;
}

if ( thelandscaper_woocommerce_active() && is_woocommerce() ) {
	$shop_id = absint( get_option( 'woocommerce_shop_page_id' ) );
	$get_id  = $shop_id;
}

// Page title settings
$title_style_array = array(
	'color'	=> get_field( 'page_title_color', $get_id ),
);
$title_attr = thelandscaper_header_array( $title_style_array );

// Page header settings
$header_attr = array();

if ( get_field( 'header_bgimage', $get_id ) ) {
	$header_attr = array(
		'background-image'      => get_field( 'header_bgimage', $get_id ),
		'background-position'   => get_field( 'header_bg_horizontal', $get_id ) . ' ' . get_field( 'header_bg_vertical', $get_id ),
		'background-size'       => get_field( 'header_bgsize', $get_id ),
		'background-attachment' => get_field( 'header_bgattachment', $get_id ),
	);
}

$header_attr['text-align'] = get_field( 'header_text_align', $get_id );
$header_attr['background-color'] = get_field( 'header_bgcolor', $get_id );

$style_attr = thelandscaper_header_array( $header_attr );

// If main title isset in page setting to large, or in theme customizer add 'header-large' class 

if ( 'large' !== get_theme_mod( 'qt_maintitle_layout', 'small' ) && 'header-large' !== get_field( 'page_title_area', $get_id ) ) {
	$title_layout = '';
} else {
	$title_layout = ' header-large';
}
?>

<div class="page-header<?php echo esc_attr( $title_layout ); ?>" <?php echo $style_attr;?>>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">

				<?php
					$subtitle = '';

					if ( is_home() || ( is_single() && 'post' === get_post_type() ) ) {
						
						$title = get_the_title( $page_id );
						$subtitle = get_field( 'subtitle', $page_id );

					} elseif ( is_category() ) {
						
						$title = esc_html__( 'Category', 'the-landscaper-wp') . ': ' . single_cat_title( '', false );

					} elseif ( is_tag() ) {
						
						$title = esc_html__( 'Tag', 'the-landscaper-wp') . ': ' . single_tag_title( '', false );

					} elseif ( is_search() ) {
						
						$title = esc_html__( 'Search Results For', 'the-landscaper-wp') . ' &quot;' . get_search_query() . '&quot;';

					} elseif ( is_404() ) {
						
						$title = esc_html__( 'Error 404', 'the-landscaper-wp');

					} elseif ( 'portfolio' == get_post_type() ) {
						
						if ( 'custom_title' === get_theme_mod( 'qt_gallery_title', 'custom_title' ) ) {
							$title = get_theme_mod( 'qt_gallery_maintitle', 'Gallery' );
						
						} else {
							$title = get_the_title();
						}

						if( is_tax() ) {
							$title = single_cat_title( "", false );
						}

						$subtitle = get_theme_mod( 'qt_gallery_subtitle', 'A selection of our best work' );

					} elseif ( thelandscaper_woocommerce_active() && is_woocommerce() && is_shop() ) {
						
						ob_start();
					 	$title = woocommerce_page_title();
					 	$title = ob_get_clean();
					 	$subtitle = get_field( 'subtitle', (int) get_option( 'woocommerce_shop_page_id' ) );

					} else {
						
						$title = get_the_title();
						$subtitle = get_field( 'subtitle' );

					}
				?>

				<<?php echo esc_html( $headtag ); ?> class="main-title"<?php echo $title_attr;?>><?php echo esc_attr( $title ); ?></<?php echo esc_html( $headtag ); ?>>

				<?php if ( $subtitle ): ?>
					<h3 class="sub-title"><?php echo esc_attr( $subtitle ); ?></h3>
				<?php endif; ?>

			</div>

		</div>
	</div>
</div>

<?php if ( 'hide' !== get_theme_mod( 'qt_breadcrumbs', 'show' ) ) : ?>
	<?php get_template_part( 'parts/breadcrumbs' ); ?>
<?php endif; ?>