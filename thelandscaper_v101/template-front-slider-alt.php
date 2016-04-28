<?php
/*
Template Name: Front Page Alternative Slider
*/

get_header();

// Get the Revolution Slider & Layer Slider field
if( 'rev' === get_field( 'add_slider' ) && function_exists( 'putRevSlider' ) ) {
	putRevSlider( get_field( 'revolution_slider_id' ) );
} 
else if ( 'layer' === get_field( 'add_slider' ) && function_exists( 'layerslider' ) ) {
	layerslider( get_field( 'layer_slider_id' ) );
}
?>

<div class="content">
	<div class="container">
		<?php 
			if ( have_posts() ) : while ( have_posts() ) : the_post();
				the_content();
			endwhile; endif;
		?>
	</div>
</div>

<?php get_footer(); ?>