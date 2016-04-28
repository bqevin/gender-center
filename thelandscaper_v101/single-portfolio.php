<?php
/**
 * Single Post Template for the gallery/portfolio post type
 *
 * @package The Landscaper
 */

get_header();

// Get the Main Title Template Part
get_template_part( 'parts/main-title' );

// Get the gallery field images
$images = get_field( 'gallery_field' );

// Get the amount of columns
$columns = get_field( 'gallery_columns' );

// Calculate for Bootstrap columns
if( $columns ) :
	$count = round( 12 / $columns );
endif;
?>

<div class="content">
	<div class="container">
		<div class="row">
			<main class="col-xs-12">
				
				<article <?php post_class( 'post-inner' ); ?>>

					<?php if ( 'custom_title' === get_theme_mod( 'qt_gallery_title', 'custom_title' ) ) : ?>
						<h1 class="widget-title"><?php the_title(); ?></h1>
					<?php endif; ?>

					<div class="row">

						<?php if( get_field( 'gallery_layout' ) === 'split' ) : ?>

							<?php if( $images ) : ?>

								<div class="col-xs-12 col-md-7 col-md-push-5">

									<div class="gallery-field split">

										<?php $counter = 0; ?>
										<div class="row">
									
											<?php foreach ( $images as $image ) :
												$counter++; ?>

												<div class="col-xs-12 col-md-<?php echo esc_attr( $count ); ?>">
													<a href="<?php echo esc_url( $image['url'] ); ?>" class="image">
														<img src="<?php echo esc_url( $image['sizes']['thelandscaper-project-images'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
														<div class="overlay"></div>
													</a>
												</div>

												<?php if ( $counter % $columns == 0 ) : ?>
													</div>
													<div class="row">
												<?php endif; ?>
											
											<?php endforeach; ?>

										</div>
									</div>

									<?php if( get_field( 'add_textarea' ) === true ) : ?>
										<div class="gallery-extra">
											<?php echo wp_kses_post( the_field( 'extra_textarea' ) ); ?>
										</div>
										<div class="clearfix"></div>
									<?php endif; ?>

								</div>
							<?php endif; // $images ?>
							
							<div class="col-xs-12 <?php echo empty ( $images ) ? '' : 'col-md-5 col-md-pull-7'; ?>">
								<?php while ( have_posts() ) : the_post();

									the_content(); ?>

									<div class="clearfix"></div>

								<?php endwhile; ?>
							</div>

						<?php 
							else : // if layout isn't set to split 
							?>

							<div class="col-xs-12">
								<?php if( $images ) : ?>

									<div class="gallery-field">

										<?php $counter = 0; ?>
										<div class="row">

											<?php foreach ( $images as $image ) :
												$counter++;

												$slide_image_srcset = thelandscaper_srcset_sizes( $image['ID'], array( 'thelandscaper-project-images-s', 'thelandscaper-project-images-m', 'thelandscaper-project-images-l' ) ); ?>

												<div class="col-xs-12 col-md-<?php echo esc_attr( $count ); ?>">
													<a href="<?php echo esc_url( $image['url'] ); ?>" class="image">
														<?php if( $columns === '1' ) : ?> 
															<img src="<?php echo esc_url( $image['sizes']['thelandscaper-project-images'] ); ?>" srcset="<?php echo esc_html( $slide_image_srcset ); ?>" sizes="100vw" alt="<?php echo esc_attr( get_sub_field( 'slide_heading' ) ); ?>">
														<?php else : ?>
															<img src="<?php echo esc_url( $image['sizes']['thelandscaper-project-images'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
														<?php endif; ?>
														<div class="overlay"></div>
													</a>
												</div>

												<?php if ( $counter % $columns == 0 ) : ?>
												</div>
												<div class="row">
												<?php endif;
											
											endforeach; ?>

										</div>
									</div>

								<?php endif; ?>
							</div>

							<?php while ( have_posts() ) : the_post(); ?>

								<div class="col-xs-12">

									<?php if( get_field( 'add_textarea' ) === true ) : ?>
										<div class="gallery-extra fullwidth">
											<?php echo wp_kses_post( the_field( 'extra_textarea' ) ); ?>
										</div>
										<div class="clearfix"></div>
									<?php endif; ?>

									<?php the_content(); ?>

									<div class="clearfix"></div>

								</div>

							<?php endwhile; ?>

						<?php endif; ?>

					</div>

				</article>

			</main>
		</div>
	</div>

	<?php if ( 'hide' !== get_theme_mod( 'qt_gallery_nav', 'show' ) ) : ?>
		<nav class="project-navigation">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<?php
							// The Previous Gallery Item Button 
							previous_post_link( '%link', '<i class="fa fa-caret-left"></i> ' . get_theme_mod( 'qt_gallery_prevtext', 'Previous' ) );
						?>

						<?php if( get_theme_mod( 'qt_gallery_summarytext' ) ) : ?>
							<a href="<?php echo esc_url( get_theme_mod( 'qt_gallery_summarylink' ) ); ?>" class="summary"><?php echo wp_kses_post( get_theme_mod( 'qt_gallery_summarytext' ) ); ?></a>
						<?php endif; ?>
						
						<?php
							// The Next Gallery Item Button 
							next_post_link( '%link', get_theme_mod( 'qt_gallery_nexttext', 'Next' ) . ' <i class="fa fa-caret-right"></i>' );
						?>
					</div>
				</div>
			</div>
		</nav>
	<?php endif; ?>

</div>

<?php get_footer(); ?>