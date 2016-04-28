<?php
/**
 * Widget: Count Box
 *
 * @package The Landscaper
 */

if ( ! class_exists( 'QT_Count_Box' ) ) {
	class QT_Count_Box extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				false,
				esc_html__( 'QT: CountTo Box', 'the-landscaper-wp' ),
				array(
					'description' => esc_html__( 'Box with number counter', 'the-landscaper-wp' ),
					'classname'   => 'widget-count-box',
				)
			);
		}

		/**
		 * Enqueue the JS and CSS files for the widget
		 */
		public static function enqueue_js_css() {
			wp_enqueue_script( 'thelandscaper-waypoints', get_template_directory_uri(). '/assets/js/widgets/jquery.waypoints.min.js', array( 'jquery' ), '3.1.1', true );
			wp_enqueue_script( 'thelandscaper-countbox', get_template_directory_uri(). '/assets/js/widgets/countbox.js', array( 'jquery' ), '', true );
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
			echo $args['before_widget'];
			?>

			<div class="counter count-box">
				<?php if( esc_attr( $instance['count_icon'] ) ) : ?>
					<div class="count-icon">
						<i class="fa <?php echo esc_attr( $instance['count_icon'] ); ?>"></i>
					</div>
				<?php endif; ?>
				<div class="count-text">
					<?php if( $instance['count_before'] ) : ?>
						<span class="count-before"><?php echo esc_attr( $instance['count_before'] ); ?></span>
					<?php endif; ?>
					<span class="count-number" data-to="<?php echo esc_attr( $instance['count_to'] ); ?>" data-speed="2000"></span>
					<?php if( $instance['count_after'] ) : ?>
						<span class="count-after"><?php echo esc_attr( $instance['count_after'] ); ?></span>
					<?php endif; ?>
					<span class="count-title"><?php echo esc_attr( $instance['title'] ); ?></span>
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

			$instance['count_before'] = sanitize_text_field( $new_instance['count_before'] );
			$instance['count_to']     = absint( $new_instance['count_to'] );
			$instance['count_after']  = sanitize_text_field( $new_instance['count_after'] );
			$instance['count_icon']   = sanitize_html_class( $new_instance['count_icon'] );
			$instance['title']        = wp_kses_post( $new_instance['title'] );

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
			$count_before = empty( $instance['count_before'] ) ? '' : $instance['count_before'];
			$count_to     = empty( $instance['count_to'] ) ? '' : $instance['count_to'];
			$count_after  = empty( $instance['count_after'] ) ? '' : $instance['count_after'];
			$count_icon   = empty( $instance['count_icon'] ) ? '' : $instance['count_icon'];
			$title        = empty( $instance['title'] ) ? '' : $instance['title'];
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count_before' ) ); ?>"><?php esc_html_e( 'Count Unit Before (Optional)', 'the-landscaper-wp' ); ?>:</label> <br />
				<input id="<?php echo esc_attr( $this->get_field_id( 'count_before' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count_before' ) ); ?>" type="text" value="<?php echo esc_attr( $count_before ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count_to' ) ); ?>"><?php esc_html_e( 'Count To Number', 'the-landscaper-wp' ); ?>:</label> <br />
				<input id="<?php echo esc_attr( $this->get_field_id( 'count_to' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count_to' ) ); ?>" type="number" value="<?php echo esc_attr( $count_to ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count_after' ) ); ?>"><?php esc_html_e( 'Count Unit After (Optional)', 'the-landscaper-wp' ); ?>:</label> <br />
				<input id="<?php echo esc_attr( $this->get_field_id( 'count_after' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count_after' ) ); ?>" type="text" value="<?php echo esc_attr( $count_after ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count_icon' ) ); ?>"><?php esc_html_e( 'Icon', 'the-landscaper-wp' ); ?></label><br/><small><em><?php printf( esc_html__( 'See %s for all icon classes (example: fa-home)', 'the-landscaper-wp' ), '<a href="'. esc_url( 'http://fontawesome.io/icons/' ) . '" target="_blank">FontAwesome</a>' ); ?></em></small></label> <br />
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'count_icon' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'count_icon' ) ); ?>" value="<?php echo esc_attr( $count_icon ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'the-landscaper-wp' ); ?>:</label> <br />
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<?php
		}
	}
	add_action( 'wp_enqueue_scripts', array( 'QT_Count_Box', 'enqueue_js_css' ), 50 );
	add_action( 'widgets_init', create_function( '', 'register_widget( "QT_Count_Box" );' ) );
}