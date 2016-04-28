<?php
/**
 * The Landscaper Blog Grid Loop
 */

// Get blog columns option
$grid_columns = get_field( 'blog_columns', (int) get_option( 'page_for_posts' ) );
?>

<div class="blog-grid" data-columns="<?php echo esc_attr( $grid_columns ); ?>">
	
	<?php $counter = 0; ?>
		<div class="row">
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php $counter++; ?>
	
				<article <?php post_class( 'post-inner' ); ?>>
					<div class="post-item news">
						<?php if( has_post_thumbnail() ) : ?>
							<a href="<?php esc_url( the_permalink() ); ?>" class="post-item-image">
								<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-responsive' ) ); ?>
								<div class="label-wrap">
									<span class="label date"><?php the_time( 'd M, Y' ); ?></span>
									<span class="label comments"><?php comments_number(); ?></span>
									<?php if( is_sticky() ) : ?>
										<span class="label sticky"><?php esc_html_e( 'Sticky', 'the-landscaper-wp' ); ?></span>
									<?php endif; ?>
								</div>
							</a>
						<?php endif; ?>
						<div class="post-meta-data">
							<span class="author"><?php the_author(); ?></span>
							<?php if( has_category() ) : ?>
								<span class="round-divider"></span>
								<span class="category"><?php the_category( ', ' ); ?></span>
							<?php endif; ?>
						</div>
						<div class="post-item-content">
							<h2 class="title">
								<a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a>
							</h2>
							<?php
								if( $post->post_excerpt ) :
									the_excerpt();
								else :
									the_content( sprintf(
									wp_kses( __( 'Read more %s', 'the-landscaper-wp' ), array( 'span' => array( 'class' => array( 'read more' ) ) ) ),
									the_title( '<span class="screen-reader-text">"', '"</span>', false )
									) );
								endif;
							?>
							<div class="clearfix"></div>
						</div>
					</div>
				</article>

				<?php if ( $counter % $grid_columns == 0 ) : ?>
					</div>
					<div class="row">
				<?php endif; ?>

			<?php endwhile; else : ?>

				<h3><?php esc_html_e( 'Sorry, no results found.', 'the-landscaper-wp' ); ?></h3>

		<?php endif; ?>

	</div>
</div>