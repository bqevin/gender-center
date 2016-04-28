<?php
/**
 * Widget: Facebook
 *
 * @package The Landscaper
 */

if ( ! class_exists( 'QT_Facebook' ) ) {
	class QT_Facebook extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
		 		false,
				esc_html__( 'QT: Facebook', 'the-landscaper-wp' ),
				array( 
					'description' => esc_html__( 'Facebook Page Widget', 'the-landscaper-wp' ),
					'classname'   => 'widget-facebook',
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

			$instance['title']  = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'] );
			$instance['height'] = absint( $instance['height'] );
			$instance['width']  = absint( $instance['width'] );

			$fb_settings = array(
				'title'         => $instance['title'],
				'href'          => $instance['fb_url'],
				'height'        => $instance['height'],
				'width'         => $instance['width'],
				'hide_cover'    => ! empty( $instance['hide_cover'] ) ? 1 : 0,
				'show_facepile' => ! empty( $instance['show_facepile'] ) ? 1 : 0,
				'show_posts'    => ! empty( $instance['show_posts'] ) ? 1 : 0,
				'small_header'  => ! empty( $instance['small_header'] ) ? 1 : 0
			);

			// Build the URL from the settings above
			$build_fb_settings = http_build_query( $fb_settings );

			echo $args['before_widget'];

			if ( ! empty ( $instance['title'] ) ) : ?>
				<h6 class="widget-title"><?php echo wp_kses_post( $instance['title'] ); ?></h6>
			<?php endif; ?>

			<div class="fb-iframe">
				<iframe src="//www.facebook.com/plugins/likebox.php?<?php echo esc_attr( $build_fb_settings ); ?>" frameborder="0"></iframe>
				<style type="text/css">
					.fb-iframe iframe { min-height: <?php echo $fb_settings['height']; ?>px; min-width: <?php echo $fb_settings['height']; ?>px; max-width: 100%; }
				</style>
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

			$instance['title']		   = wp_kses_post( $new_instance['title'] );
			$instance['fb_url'] 	   = esc_url_raw( $new_instance['fb_url'] );
			$instance['height']		   = absint( $new_instance['height'] );
			$instance['width']		   = absint( $new_instance['width'] );
			$instance['hide_cover']    = sanitize_key( $new_instance['hide_cover'] );
			$instance['show_facepile'] = sanitize_key( $new_instance['show_facepile'] );
			$instance['show_posts']    = sanitize_key( $new_instance['show_posts'] );
			$instance['small_header']  = sanitize_key( $new_instance['small_header'] );
			
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
			$title  	   = isset( $instance['title'] ) ? $instance['title'] : '';
			$fb_url		   = isset( $instance['fb_url'] ) ? $instance[ 'fb_url' ] : 'https://www.facebook.com/QreativeThemes';
			$height 	   = isset( $instance['height'] ) ? $instance['height'] : 156;
			$width 		   = isset( $instance['width'] ) ?  $instance['width'] : 263;
			$hide_cover    = isset( $instance['hide_cover'] ) ? $instance['hide_cover'] : '';
			$show_facepile = isset( $instance['show_facepile'] ) ? $instance['show_facepile'] : '';
			$show_posts    = isset( $instance['show_posts'] ) ? $instance['show_posts'] : '';
			$small_header  = isset( $instance['small_header'] ) ? $instance['small_header'] : '';
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title', 'the-landscaper-wp' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'fb_url' ) ); ?>"><?php esc_html_e( 'Facebook Page URL', 'the-landscaper-wp' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'fb_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'fb_url' ) ); ?>" type="text" value="<?php echo esc_url( $fb_url ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"><?php esc_html_e( 'Height (in pixels)', 'the-landscaper-wp'  ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" type="number" value="<?php echo esc_attr( $height ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php esc_html_e( 'Width (in pixels)', 'the-landscaper-wp'  ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" type="number" value="<?php echo esc_attr( $width ); ?>" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $hide_cover, 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_cover' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>"><?php esc_html_e( 'Hide cover photo in the header', 'the-landscaper-wp'  ); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $show_facepile, 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_facepile' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_facepile' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_facepile' ) ); ?>"><?php esc_html_e( 'Show profile photos when friends like this', 'the-landscaper-wp'  ); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $show_posts, 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_posts' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_posts' ) ); ?>"><?php esc_html_e( 'Show posts from the Page\'s timeline', 'the-landscaper-wp'  ); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $small_header, 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'small_header' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'small_header' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'small_header' ) ); ?>"><?php esc_html_e( 'Use the small header instead', 'the-landscaper-wp'  ); ?></label>
			</p>

			<?php
		}
	}
	add_action( 'widgets_init', create_function( '', 'register_widget( "QT_Facebook" );' ) );
}