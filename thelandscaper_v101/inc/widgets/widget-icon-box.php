<?php
/**
 * Widget: Icon Box
 *
 * @package The Landscaper
 */

if ( ! class_exists( 'QT_Icon_Box' ) ) {
	class QT_Icon_Box extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				false,
				esc_html__( 'QT: Icon Box', 'the-landscaper-wp' ),
				array(
					'description' => esc_html__( 'Custom text with a Icon', 'the-landscaper-wp' ),
					'classname'   => 'widget-icon-box',
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
			echo $args['before_widget'];

			if ( ! empty ( $instance['link'] ) ) :
			?>
				<a class="icon-box icon-<?php echo esc_attr( $instance['layout'] ); ?>" href="<?php echo esc_url_raw( $instance['link'] ); ?>">
			<?php else : ?>
				<div class="icon-box icon-<?php echo esc_attr( $instance['layout'] ); ?>">
			<?php endif; ?>
					<i class="fa <?php echo esc_attr( $instance['icon'] ); ?>"></i>
					<h6 class="title"><?php echo wp_kses_post( $instance['title'] ); ?></h6>
					<?php if ( $instance['text'] ) : ?>
						<span class="subtitle"><?php echo esc_attr( $instance['text'] ); ?></span>
					<?php endif; ?>
			</<?php echo empty ( $instance['link'] ) ? 'div' : 'a'; ?>>

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

			$instance['title']  = wp_kses_post( $new_instance['title'] );
			$instance['text']   = wp_kses_post( $new_instance['text'] );
			$instance['link']   = esc_url_raw( $new_instance['link'] );
			$instance['icon']   = sanitize_key( $new_instance['icon'] );
			$instance['layout'] = sanitize_key( $new_instance['layout'] );

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
			$title  = empty( $instance['title'] ) ? '' : $instance['title'];
			$text   = empty( $instance['text'] ) ? '' : $instance['text'];
			$link   = empty( $instance['link'] ) ? '' : $instance['link'];
			$icon   = empty( $instance['icon'] ) ? '' : $instance['icon'];
			$layout = empty( $instance['layout'] ) ? '' : $instance['layout'];
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php esc_html_e( 'Icon', 'the-landscaper-wp' ); ?>: <small><em><?php printf( esc_html__( 'See %s for all icon classes (example: fa-home)', 'the-landscaper-wp' ), '<a href="'. esc_url( 'http://fontawesome.io/icons/' ) .'" target="_blank">FontAwesome</a>' ); ?></em></small></label><br />
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>" type="text" value="<?php echo esc_attr( $icon ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'the-landscaper-wp' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text', 'the-landscaper-wp' ); ?>:</label> <br />
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_html_e( 'Link', 'the-landscaper-wp' ); ?>: <small><em><?php esc_html_e( 'Optional', 'the-landscaper-wp' ); ?></em></small></label> <br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_url( $link ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_html_e( 'Layout:', 'the-landscaper-wp' ); ?></label> <br>
				<select id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>">
					<option value="small" <?php selected( $layout, 'small' ); ?>><?php esc_html_e( 'Smaller Icon', 'the-landscaper-wp' ); ?></option>
					<option value="big" <?php selected( $layout, 'big' ); ?>><?php esc_html_e( 'Big Icon', 'the-landscaper-wp' ); ?></option>
				</select>
			</p>
			<?php
		}
	}
	add_action( 'widgets_init', create_function( '', 'register_widget( "QT_Icon_Box" );' ) );
}