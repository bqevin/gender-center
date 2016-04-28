<?php
/**
 * Single Post Template ( Blog Posts )
 *
 * @package The Landscaper
 */

get_header();

// Get the Main Title Template Part
get_template_part( 'parts/main-title' );

// Get the sidebar
$sidebar = get_field( 'display_sidebar' );
if ( ! $sidebar ) {
	$sidebar = 'Right';
}
?>

<div class="content">
	<div class="container">
		<div class="row">
			<main class="col-xs-12<?php echo 'Left' === $sidebar ? ' col-md-9 col-md-push-3' : ''; echo 'Right' === $sidebar ? ' col-md-9' : ''; ?>">

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

					<article <?php post_class( 'post-inner' ); ?>>
						
						<?php if( has_post_thumbnail() ) : ?>
							<a href="<?php esc_url( the_permalink() ); ?>">
								<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-responsive' ) ); ?>	
							</a>
						<?php endif; ?>
						
						<div class="post-meta-data">
							<time datetime="<?php esc_attr( the_time( 'c' ) ); ?>" class="date"><?php echo esc_attr( get_the_date( get_option( 'date_format' ) ) ); ?></time>
							<span class="round-divider"></span>
							<a href="<?php esc_url( comments_link() ); ?>"><?php comments_number(); ?></a>
							<span class="round-divider"></span>
							<span class="author"><?php esc_html_e( 'By', 'the-landscaper-wp'); ?> <?php the_author(); ?></span>
							<span class="round-divider"></span>
							<?php if( has_category() ) : ?>
								<span class="category"><?php the_category( ', ' ); ?></span>
							<?php endif; ?>
							<span class="round-divider"></span>
							<?php if( has_tag() ) : ?>
								<span class="tags"><?php the_tags( ' ' ); ?></span>
							<?php endif; ?>
						</div>

						<h1 class="post-title"><?php the_title(); ?></h1>
						
						<div class="post-content">
							<?php the_content(); ?>
						</div>

						<div class="clearfix"></div>
						
						<?php if ( 'hide' !== get_theme_mod( 'qt_blog_share', 'show' ) ) :
							$share_tooltip    = get_theme_mod( 'qt_blog_tooltip', 'Share' );
							$share_twitter    = get_theme_mod( 'qt_blog_twitter', 'Twitter' );
							$share_facebook   = get_theme_mod( 'qt_blog_facebook', 'Facebook' );
							$share_googleplus = get_theme_mod( 'qt_blog_googleplus', 'Google+' );
							$share_linkedin   = get_theme_mod( 'qt_blog_linkedin', 'LinkedIn' );
						?>

							<div class="social-sharing-buttons">
								<span data-toggle="tooltip" data-original-title="<?php echo esc_attr( $share_tooltip ); ?>"><i class="fa fa-share-alt"></i></span>
								<?php if ( $share_twitter ) : ?>
									<a class="twitter" href="http://twitter.com/intent/tweet/?text=<?php echo esc_html( get_the_title() ); ?>&url=<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_html( get_the_title() ); ?>" onclick="window.open(this.href, 'newwindow', 'width=700,height=450'); return false;"><?php echo wp_kses_post( $share_twitter ); ?></a>
								<?php endif; ?>
								<?php if ( $share_facebook ) : ?>
									<a class="facebook" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_html( get_the_title() ); ?>" onclick="window.open(this.href, 'newwindow', 'width=700,height=450'); return false;"><?php echo wp_kses_post( $share_facebook ); ?></a>
								<?php endif; ?>
								<?php if ( $share_googleplus ) : ?>
									<a class="gplus" href="http://plus.google.com/share?url=<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_html( get_the_title() ); ?>" onclick="window.open(this.href, 'newwindow', 'width=700,height=450'); return false;"><?php echo wp_kses_post( $share_googleplus ); ?></a>
								<?php endif; ?>
								<?php if ( $share_linkedin ) : ?>
									<a class="linkedin" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( get_the_permalink() ); ?>&title=<?php echo esc_html( get_the_title() ); ?>" title="<?php echo esc_html( get_the_title() ); ?>" onclick="window.open(this.href, 'newwindow', 'width=700,height=450'); return false;"><?php echo wp_kses_post( $share_linkedin ); ?></a>
								<?php endif; ?>
								<div class="clear"></div>
							</div>
						<?php endif; ?>

						<!-- Multi Page in One Post -->
						<?php
							$args = array(
								'before'      => '<div class="multi-page clearfix">' . /* translators: after that comes pagination like 1, 2, 3 ... 10 */ _x( 'Pages:' , 'frontend', 'the-landscaper-wp' ) . ' &nbsp; ',
								'after'       => '</div>',
								'link_before' => '<span class="btn btn-primary">',
								'link_after'  => '</span>',
								'echo'        => 1
							);
							wp_link_pages( $args );
						?>
						<?php comments_template(); ?>
					</article>

				<?php endwhile; else : ?>

					<h3><?php esc_html_e( 'Sorry, no results found.', 'the-landscaper-wp'); ?></h3>

				<?php endif; ?>
			</main>

			<?php if ( 'Hide' !== $sidebar ) : ?>
				<div class="col-xs-12 col-md-3 <?php echo 'Left' === $sidebar ? 'col-md-pull-9' : ''; ?>">
					<aside class="sidebar widget-area">
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