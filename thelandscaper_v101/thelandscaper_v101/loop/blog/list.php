<?php
/**
 * The Landscaper Blog List Loop
 */
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
	<article <?php post_class( 'post-inner' ); ?>>
		<div class="post-left-meta">
			<?php if( is_sticky() ) : ?>
				<div class="box stickylabel">
					<span><i class="fa fa-bookmark"></i>Sticky</span>
				</div>
			<?php endif; ?>
			<div class="box date">
				<span class="day"><?php the_time( 'd' ); ?></span>
				<span class="month"><?php the_time( 'M' ); ?></span>
				<span class="year"><?php the_time( 'Y' ); ?></span>
			</div>
		</div>
		<div class="post-content">
			<?php if( has_post_thumbnail() ) : ?>
				<a href="<?php esc_url( the_permalink() ); ?>">
					<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-responsive' ) ); ?>	
				</a>
			<?php endif; ?>
			<div class="post-meta-data">
				<a href="<?php esc_url( comments_link() ); ?>"><?php echo esc_attr( get_comments_number() ); ?> <?php echo esc_html_e( 'Comments', 'the-landscaper-wp' ); ?></a>
				<span class="round-divider"></span>
				<span class="author"><?php esc_html_e( 'By', 'the-landscaper-wp'); ?> <?php the_author(); ?></span>
				<?php if( has_category() ) : ?>
					<span class="round-divider"></span>
					<span class="category"><?php the_category( ', ' ); ?></span>
				<?php endif; ?>
				<?php if( has_tag() ) : ?>
					<span class="round-divider"></span>
					<span class="tags"><?php the_tags( ' ' ); ?></span>
				<?php endif; ?>
			</div>
			
			<h2 class="post-title">
				<a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a>
			</h2>
			<?php
				the_content( sprintf(
				wp_kses( __( 'Read more %s', 'the-landscaper-wp' ), array( 'span' => array( 'class' => array( 'read more' ) ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
			?>
			<div class="clearfix"></div>
		</div>
	</article>
	
<?php endwhile; else : ?>

	<h3><?php esc_html_e( 'Sorry, no results found.', 'the-landscaper-wp' ); ?></h3>

<?php endif; ?>