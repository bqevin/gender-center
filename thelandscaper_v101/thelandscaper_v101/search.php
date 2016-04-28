<?php
/**
 * The template for displaying search results pages.
 *
 * @package The Landscaper
 */

get_header();

// Get the Main Title Template Part
get_template_part( 'parts/main-title' );
?>

<section class="content">
	<main class="container">
		<div class="row">
			<div class="col-xs-12 col-md-9">
				
				<ul class="search-list-results">
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<li>
							<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						</li>
					<?php endwhile; else : ?>
						<h2><?php esc_html_e( 'Sorry, no results found.', 'the-landscaper-wp'); ?></h2>
					<?php endif; ?>
				</ul>
				
			</div>

			<div class="col-xs-12 col-md-3">
				<aside class="sidebar">
					<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
						<?php dynamic_sidebar( 'sidebar' ); ?>
					<?php endif; ?>
				</aside>
			</div>

		</div>
	</main>
</section>

<?php get_footer(); ?>