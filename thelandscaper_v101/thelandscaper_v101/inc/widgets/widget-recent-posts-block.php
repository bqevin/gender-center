<?php
/**
 * Widget: Recent Blog Posts Block
 *
 * @package The Landscaper
 */

if ( ! class_exists( 'QT_Recent_Posts_Block' ) ) {
	class QT_Recent_Posts_Block extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
		 		false,
				esc_html__( 'QT: Latest Blog Posts', 'the-landscaper-wp' ),
				array(
					'description' => esc_html__( 'Displays Recent Blog Posts', 'the-landscaper-wp' ),
					'classname' => 'widget_post_block',
				)
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			// Widget Title
			$title = apply_filters( 'widget_title', $instance['title'] );
			
			// Get posts id's for more news link
			$page_id = $instance['page_id'];

			if ( $page_id ) {
				$page_data = (array) get_post( $page_id );
			}

			$page_data['url'] = get_permalink( $page_id );

			// Get amount of posts
			$numberposts = absint( $instance['count'] );

			// Get post by category
			$categories = esc_attr( $instance['categories'] );

			// Calculate columns in a single row
			$columns = absint( $instance['columns'] );
			$calc_columns = round( 12 / $columns );

			// Hide Sticky Posts
			$sticky_option = empty( $instance['sticky'] ) ? '' : get_option( 'sticky_posts' );
			
			// The post query
			$recent_posts_args = array(
				'posts_per_page'	  => $numberposts,
				'cat' 				  => $categories,
				'orderby'			  => 'post_date',
				'order'				  => 'DESC',
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'post__not_in' 		  => $sticky_option
			);
			$recent_posts = new WP_Query( $recent_posts_args );

			echo $args['before_widget'];
			?>

			<div class="block-posts">

				<?php if ( ! empty( $title ) ) : ?>
					<h3 class="widget-title">
						<?php echo wp_kses_post( $title ); ?>
						<?php if ( $page_id ) : ?>
							<a href="<?php echo esc_url_raw( $page_data['url'] ); ?>"><?php esc_html_e( 'More news', 'the-landscaper-wp'  ); ?><i class="fa fa-angle-right"></i></a>
						<?php endif; ?>
					</h3>
				<?php endif; ?>

				<div class="row">
					<?php $counter = $columns; ?>
					<?php if ( $recent_posts->have_posts() ) : while ( $recent_posts->have_posts() ) : $recent_posts->the_post();

						// Prepare Featured Image srcset
						$post_image_id 		   = get_post_thumbnail_id();
						$post_image_data       = wp_get_attachment_image_src( $post_image_id, 'news-thumb-small' );
						$post['image_url']     = $post_image_data[0];
						$post['image_width']   = $post_image_data[1];
						$post['image_height']  = $post_image_data[2];
						$post['srcset']        = thelandscaper_srcset_sizes( $post_image_id, array( 'news-thumb-small', 'news-thumb-large' ) );

						// Begin Count Posts
						$counter++;
						?>

						<div class="col-xs-12 col-sm-4 col-md-<?php echo esc_attr( $calc_columns ); ?>">
							<article class="post-item news">
								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>" class="post-item-image">
										<img src="<?php echo esc_url( $post['image_url'] ); ?>" srcset="<?php echo esc_html( $post['srcset'] ); ?>" sizes="(min-width: 781px) 360px, calc(100vw - 30px)" alt="<?php echo esc_attr( the_title() ); ?>">
										<div class="label-wrap">
											<span class="label date"><?php the_time( get_option( 'date_format' ) ); ?></span>
											<?php if( is_sticky() ) : ?>
												<span class="label sticky">
													<?php esc_html_e( 'Sticky', 'the-landscaper-wp'  ); ?>
												</span>
											<?php endif; ?>
										</div>
									</a>
								<?php endif; ?>
								<div class="post-item-content">
									<h5 class="title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h5>
									<p>
				                        <?php
				                        	// Get the excerpt
				                            $excerpt = get_the_excerpt();

				                            // If content is longer than excerpt length trim the content
				                            if ( strlen( $excerpt ) > 115 ) :
				                                $excerpt = substr( $excerpt, 0, strpos( $excerpt , ' ', 115 ) ) . '...';
				                            endif;

				                            // Display the content
				                            echo esc_html( $excerpt );
				                        ?>
				                    </p>
				                    <a href="<?php the_permalink(); ?>" class="more"><?php esc_html_e( 'Read More', 'the-landscaper-wp' ) ?></a>
								</div>
							</article>
						</div>
						
						<?php if ( $counter % $columns == 0 ) : // Add a row when there are more posts to show then the columns amount isset ?>
							</div>
							<div class="row">
						<?php endif;

						endwhile; // have_posts

						wp_reset_postdata(); // reset postdata

					else : // If no posts are found display message below  ?>

						<h3><?php esc_html_e( 'No Posts Found', 'the-landscaper-wp'  ); ?></h3>

					<?php endif; // have_posts ?>
				</div>
			</div>

			<?php
			echo $args['after_widget'];
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			
			$instance['title']		= wp_kses_post( $new_instance['title'] );
			$instance['categories'] = sanitize_key( $new_instance['categories'] );
			$instance['count']		= absint( $new_instance['count'] );
			$instance['columns']	= absint( $new_instance['columns'] );
			$instance['sticky']		= sanitize_key( $new_instance['sticky'] );
			$instance['page_id']	= absint( $new_instance['page_id'] );
			
			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			$title 		  = empty( $instance['title'] ) ? '' : $instance['title'];
			$categories   = empty( $instance['categories'] ) ? '' : $instance['categories'];
			$count 		  = empty( $instance['count'] ) ? '' : $instance['count'];
			$columns 	  = empty( $instance['columns'] ) ? '3' : $instance['columns'];
			$sticky 	  = empty( $instance['sticky'] ) ? '' : $instance['sticky'];
			$page_id 	  = empty( $instance['page_id'] ) ? 0 : (int) $instance['page_id'];
			?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title:', 'the-landscaper-wp'  ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>"><?php esc_html_e( 'Filter by Category', 'the-landscaper-wp'  ); ?>:</label> 
				<?php
					wp_dropdown_categories( array(
						'orderby' => 'name',
						'name' => $this->get_field_name( 'categories' ),
						'selected' => $categories,
						'hierarchical' => true,
						'show_option_none' => esc_html__( 'All Categories', 'the-landscaper-wp'  ),
					) );
				?>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Display number of posts:', 'the-landscaper-wp'  ); ?></label><br>
				<input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $count ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>"><?php esc_html_e( 'Column in a row', 'the-landscaper-wp'  ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'columns' ) ); ?>">
				<?php for ( $i=1; $i < 5; $i++ ) : ?>
					<option value="<?php echo esc_attr( $i ); ?>" <?php selected( $columns, $i ); ?>><?php echo esc_attr( $i ); ?></option>
				<?php endfor; ?>
				</select>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $sticky, 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'sticky' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sticky' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'sticky' ) ); ?>"><?php esc_html_e( 'Hide Sticky Posts?', 'the-landscaper-wp'  ); ?></label>
			</p>
			<p>
		    	<label for="<?php echo esc_attr( $this->get_field_id( 'page_id' ) ); ?>"><?php esc_html_e( 'More News Links to:', 'the-landscaper-wp'  ); ?></label><br>
				<?php
					wp_dropdown_pages( array(
						'selected' => $page_id,
						'id'       => $this->get_field_id( 'page_id' ),
						'name'     => $this->get_field_name( 'page_id' ),
						'show_option_none' => esc_html__( 'Select a page', 'the-landscaper-wp'  ),
					) );
				?>
			</p>
			
			<?php
		}
	}
	add_action( 'widgets_init', create_function( '', 'register_widget( "QT_Recent_Posts_Block" );' ) );
}