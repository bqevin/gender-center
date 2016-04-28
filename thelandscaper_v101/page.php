<?php
/**
 * The template for displaying all pages.
 *
 * @package The Landscaper
 */

get_header();

// Get the Main Title Template Part
get_template_part( 'parts/main-title' );

// Get Sidebar
$sidebar = get_field( 'display_sidebar' );

if ( ! $sidebar ) { $sidebar = 'Left'; }
?>
	
<div class="content">
	<div class="container">
		<div class="row">
			<main class="col-xs-12 <?php echo 'Left' === $sidebar ? 'col-md-9 col-md-push-3' : ''; echo 'Right' === $sidebar ? 'col-md-9' : ''; ?>">

				<?php 
				if ( have_posts() ) :
					while ( have_posts() ) : 
						the_post(); 
					?>

					<article <?php post_class(); ?>>
						<?php the_content(); ?>
					</article>
					
					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							comments_template( '', true );
						endif;
					
					endwhile;
				endif; 
				?>
					
			</main>

			<?php if ( 'Hide' !== $sidebar ) : ?>
				<div class="col-xs-12 col-md-3<?php echo 'Left' === $sidebar ? ' col-md-pull-9' : ''; ?>">
					<aside class="sidebar">
						<?php if ( is_active_sidebar( 'page-sidebar' ) ) : ?>
							<?php dynamic_sidebar( 'page-sidebar' ); ?>
						<?php endif; ?>
					</aside>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>

<?php get_footer(); ?>