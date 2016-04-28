<?php
/**
 * The template for displaying 404 pages (not found).
 */

get_header();

// Get the Main Title Template Part
get_template_part( 'parts/main-title' );
?>

<div class="content">
	<main class="container">
		<div class="row">
			<div class="col-xs-12">
				
				<div class="text-404">
					<div class="404-image">
						<img src="<?php echo esc_html( get_template_directory_uri().'/assets/images/404_image.png' ); ?>" alt="404 Image">
					</div>
					<h1><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'the-landscaper-wp' ); ?></h1>
					<p><?php esc_html_e( 'Nothing was found here, try a search below', 'the-landscaper-wp' ); ?></p>
					<?php get_search_form(); ?>
				</div>

			</div>
		</div>
	</main>
</div>

<?php get_footer(); ?>