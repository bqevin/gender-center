<?php
/**
 * The Landscaper Theme Main Template File.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header();

// Get the Main Title Template Part
get_template_part( 'parts/main-title' );

// Get Sidebar
$sidebar = get_field( 'display_sidebar', (int) get_option( 'page_for_posts' ) );
if ( ! $sidebar ) {
	$sidebar = 'Right';
}

// Get the Blog Layout
$blog_layout = get_field( 'blog_type', (int) get_option( 'page_for_posts' ) );
if( ! $blog_layout ) {
	$blog_layout = 'list';
}

// Get Blog layout on url parameter
$layout = (isset($_GET['layout']) ? htmlspecialchars($_GET['layout']) : $blog_layout );

// Get blog columns option
$grid_columns = get_field( 'blog_columns', (int) get_option( 'page_for_posts' ) );
?>

<div class="content">
	<div class="container">
		<div class="row">
			<main class="col-xs-12 <?php echo 'Left' === $sidebar ? 'col-md-9 col-md-push-3' : ''; echo 'Right' === $sidebar ? 'col-md-9' : '';?>">
				<?php
					get_template_part( 'loop/blog/' . $layout );
					get_template_part( 'parts/pagination' );
				?>
			</main>

			<?php if ( 'Hide' !== $sidebar ) : ?>
				<div class="col-xs-12 col-md-3<?php echo 'Left' === $sidebar ? ' col-md-pull-9' : ''; ?>">
					<aside class="sidebar">
						<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
							<?php dynamic_sidebar( 'sidebar' ); ?>
						<?php endif; ?>
					</aside>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>

<?php get_footer(); ?>