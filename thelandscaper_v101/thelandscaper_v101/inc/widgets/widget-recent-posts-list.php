<?php
/**
 * Widget: Recent Blog Posts List
 *
 * @package The Landscaper
 */

if ( ! class_exists( 'QT_Recent_Posts' ) ) {
	class QT_Recent_Posts extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
		 		false,
				esc_html__( 'QT: Latest Blog Posts List', 'the-landscaper-wp' ),
				array(
					'description' => esc_html__( 'Displays recent posts in a List', 'the-landscaper-wp' ),
					'classname' => 'widget_post_list',
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

			// Amount of posts to show
			$count = $instance['count'];
			
			// Ability to skip posts from newest
			$push = $instance['push'];

			// Get post by category
			$categories = esc_attr( $instance['categories'] );

			// Hide Sticky Posts
			$sticky_option = empty( $instance['sticky'] ) ? '' : get_option( 'sticky_posts' );

			// The Post Query
			$recent_posts_args = array(
				'posts_per_page'  => $count,
				'cat' 			  => $categories,
				'offset'		  => $push,
				'orderby' 	      => 'post_date',
				'order' 	      => 'DESC',
				'post__not_in'	  => $sticky_option
			);

			$recent_posts = new WP_Query( $recent_posts_args );
			
			echo $args['before_widget'];

			if ( ! empty( $title ) ) : ?>
				<h3 class="widget-title"><?php echo wp_kses_post( $title ); ?></h3>
			<?php endif; ?>

			<div class="widget_post_list">
				<?php if ( $recent_posts->have_posts() ) : while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>

					<a href="<?php the_permalink(); ?>">
						<h5 class="post-title"><?php the_title(); ?></h5>
						<span class="author"><?php esc_html_e( 'By','the-landscaper-wp'  ); ?> <?php echo esc_attr( get_the_author(), '&#44;' ); ?></span>
						<span class="date"><?php the_date( get_option( 'date_format' ) ); ?></span>
					</a>
						
				<?php endwhile;

					wp_reset_postdata();

					else : ?>

						<h3><?php esc_html_e( 'Sorry, no results found.', 'the-landscaper-wp' ); ?></h3>
					
				<?php endif; ?>

				<?php if ( $page_id ) : ?>
					<a href="<?php echo esc_url_raw( $page_data['url'] ); ?>" class="more-news">
						<?php esc_html_e( 'More news', 'the-landscaper-wp'  ); ?>
					</a>
				<?php endif; ?>

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

			$instance['title'] 		= wp_kses_post( $new_instance['title'] );
			$instance['categories'] = sanitize_key( $new_instance['categories'] );
			$instance['count'] 		= absint( $new_instance['count'] );
			$instance['push'] 		= absint( $new_instance['push'] );
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
			$title 		= empty( $instance['title'] ) ? '' : $instance['title'];
			$categories = empty( $instance['categories'] ) ? '' : $instance['categories'];
			$count 		= empty( $instance['count'] ) ? '3' : $instance['count'];
            $push 		= empty( $instance['push'] ) ? '' : $instance['push'];
            $sticky 	= empty( $instance['sticky'] ) ? '' : $instance['sticky'];
            $page_id 	= empty( $instance['page_id'] ) ? 0 : (int) $instance['page_id'];
			?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title:', 'the-landscaper-wp'  ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Display number of posts:', 'the-landscaper-wp'  ); ?></label><br>
				<input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $count ); ?>" />
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
				<label for="<?php echo esc_attr( $this->get_field_id( 'push' ) ); ?>"><?php esc_html_e( 'Skip amount of posts:', 'the-landscaper-wp'  ); ?></label><br>
				<input id="<?php echo esc_attr( $this->get_field_id( 'push' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'push' ) ); ?>" type="number" value="<?php echo esc_attr( $push ); ?>" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $sticky, 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'sticky' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sticky' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'sticky' ) ); ?>"><?php esc_html_e( 'Hide Sticky Posts?', 'the-landscaper-wp'  ); ?></label>
			</p>
		    <p>
		    	<label for="<?php echo esc_attr( $this->get_field_id( 'page' ) ); ?>"><?php esc_html_e( 'More News Links to:', 'the-landscaper-wp'  ); ?></label><br>
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
	add_action( 'widgets_init', create_function( '', 'register_widget( "QT_Recent_Posts" );' ) );
}