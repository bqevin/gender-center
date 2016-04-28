<?php
/*
Template Name: Front Page Fullwidth Slider
*/

get_header();

if ( have_rows( 'slide' ) ) {
	get_template_part( 'parts/jumbotron-fullwidth' ); // Get the slider part if the slider has images
}
?>

<div class="content">
	<div class="container">
		<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
			endif;
		?>
	</div>
</div>

<?php get_footer(); ?>