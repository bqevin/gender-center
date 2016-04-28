<?php
/**
 * Widget: Featured Page
 *
 * @package The Landscaper
 */

if ( ! class_exists( 'QT_Feature_Page' ) ) {
	class QT_Feature_Page extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
		 		false,
				esc_html__( 'QT: Featured Page', 'the-landscaper-wp' ),
				array( 
					'description' => esc_html__( 'Feature a page', 'the-landscaper-wp' ),
					'classname'   => 'widget-featured-page',
				)
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {

			// Get post from page ID
			$page_id = $instance['page_id'];

			if ( $page_id ) :
				$page = (array) get_post( $page_id );
			endif;

			// If excerpt isset show, else show content
			$excerpt = ! empty( $page['post_excerpt'] ) ? strip_tags( $page['post_excerpt'] ) : strip_tags( $page['post_content'] );

			// If content is longer than excerpt length trim the content
			if ( strlen( $excerpt ) > 180 ) :
				$excerpt = substr( $excerpt, 0, strpos( $excerpt , ' ', 180) ) . '...';
			endif;

			// Get the treated content
			$page['post_excerpt']  = $excerpt;

			// Get permalink from page ID
			$page['url'] = get_permalink( $page_id );

			// Prepare Featured Image srcset
			$page_image_id         = get_post_thumbnail_id( $page_id );
			$page_image_data       = wp_get_attachment_image_src( $page_image_id, 'thelandscaper-featured-thumb' );
			$page['image_url']     = $page_image_data[0];
			$page['image_width']   = $page_image_data[1];
			$page['image_height']  = $page_image_data[2];
			$page['srcset']        = thelandscaper_srcset_sizes( $page_image_id, array( 'thelandscaper-featured-thumb', 'thelandscaper-featured-large' ) );

			echo $args['before_widget'];
			?>

			<div class="post-item page">
				<?php if ( $page_image_id ) : ?>
					<a href="<?php echo esc_url_raw( $page['url'] ); ?>" class="post-item-image">
						<img src="<?php echo esc_url( $page['image_url'] ); ?>" width="<?php echo esc_attr( $page['image_width'] ); ?>" height="<?php echo esc_attr( $page['image_height'] ); ?>" srcset="<?php echo esc_html( $page['srcset'] ); ?>" sizes="(min-width: 781px) 360px, calc(100vw - 30px)" alt="<?php echo esc_attr( $page['post_title'] ); ?>">
						<?php if( $instance['btn_text'] ) : ?>
							<div class="overlay">
								<div class="vertical-center">
									<span><?php echo esc_attr( $instance['btn_text'] ); ?></span>
								</div>
							</div>
						<?php endif; ?>
					</a>
				<?php endif; ?>
				<h5 class="title">
					<a href="<?php echo esc_url_raw( $page['url'] ); ?>"><?php echo esc_attr( $page['post_title'] ); ?></a>
				</h5>
				<?php if ( $page['post_excerpt'] ) : ?>
					<p><?php echo esc_html( $page['post_excerpt'] ); ?></p>
					<?php if( $instance['btn_text'] ) : ?>
						<a href="<?php echo esc_url_raw( $page['url'] ); ?>" class="more"><?php echo esc_attr( $instance['btn_text'] ); ?></a>
					<?php endif; ?>
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

			$instance['page_id']  = absint( $new_instance['page_id'] );
			$instance['btn_text'] = sanitize_text_field( $new_instance['btn_text'] );
			
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
			$page_id  = empty( $instance['page_id'] ) ? 0 : (int) $instance['page_id'];
			$btn_text = isset( $instance['btn_text'] ) ? $instance['btn_text'] : 'Read More';
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'page_id' ) ); ?>"><?php esc_html_e( 'Select a page', 'the-landscaper-wp' ); ?></label>
				<?php
					wp_dropdown_pages( array(
						'selected' => $page_id,
						'id'       => $this->get_field_id( 'page_id' ),
						'name'     => $this->get_field_name( 'page_id' ),
					));
				?>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'btn_text' ) ); ?>"><?php esc_html_e( 'Link Text', 'the-landscaper-wp' ); ?></label><br />
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'btn_text') ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'btn_text' ) ); ?>" value="<?php echo esc_attr( $btn_text ); ?>" />
			</p>
			<?php
		}
	}
	add_action( 'widgets_init', create_function( '', 'register_widget( "QT_Feature_Page" );' ) );
}