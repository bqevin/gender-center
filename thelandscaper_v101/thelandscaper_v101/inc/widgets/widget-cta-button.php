<?php
/**
 * Widget: Call To Action Button
 *
 * @package The Landscaper
 */

if ( ! class_exists( 'QT_CTA_Button' ) ) {
	class QT_CTA_Button extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				false,
				esc_html__( 'QT: Call To Action Button', 'the-landscaper-wp' ),
				array(
					'description' => esc_html__( 'CTA Button with a Icon', 'the-landscaper-wp' ),
					'classname'   => 'widget-cta-button',
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
			$instance['title']  = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'] );
			echo $args['before_widget'];

			if ( ! empty ( $instance['title'] ) ) : ?>
				<h4 class="widget-title"><?php echo wp_kses_post( $instance['title'] ); ?></h4>
			<?php endif;

			if ( ! empty ( $instance['link'] ) ) : ?>
				<a class="cta-button" href="<?php echo esc_url( $instance['link'] ); ?>"<?php echo empty ( $instance['new_tab'] ) ? '' : 'target="_blank"'; ?>>
			<?php else : ?>
				<div class="cta-button">
			<?php endif; ?>
					<i class="fa <?php echo esc_attr( $instance['icon'] ); ?>"></i>
					<?php echo esc_attr( $instance['btn_title'] ); ?>
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

			$instance['title']     = wp_kses_post( $new_instance['title'] );
			$instance['btn_title'] = wp_kses_post( $new_instance['btn_title'] );
			$instance['icon']	   = sanitize_html_class( $new_instance['icon'] );
			$instance['link']	   = esc_url_raw( $new_instance['link'] );
			$instance['new_tab']   = ! empty( $new_instance['new_tab'] ) ? sanitize_key( $new_instance['new_tab'] ) : '';

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
			$title      = empty( $instance['title'] ) ? '' : $instance['title'];
			$btn_title  = empty( $instance['btn_title'] ) ? '' : $instance['btn_title'];
			$icon       = empty( $instance['icon'] ) ? '' : $instance['icon'];
			$link       = empty( $instance['link'] ) ? '' : $instance['link'];
			$new_tab    = empty( $instance['new_tab'] ) ? '' : $instance['new_tab'];
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title', 'the-landscaper-wp' ); ?>:</label><br />
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php esc_html_e( 'Icon', 'the-landscaper-wp' ); ?>: <small><br><em><?php printf( esc_html__( 'See %s for all icon classes (example: fa-home)', 'the-landscaper-wp' ), '<a href="'. esc_url( 'http://fontawesome.io/icons/' ) .'" target="_blank">FontAwesome</a>' ); ?></em></small></label> <br />
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>" type="text" value="<?php echo esc_attr( $icon ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'btn_title' ) ); ?>"><?php esc_html_e( 'Text on Button', 'the-landscaper-wp' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'btn_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'btn_title' ) ); ?>" type="text" value="<?php echo esc_attr( $btn_title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_html_e( 'Link', 'the-landscaper-wp' ); ?>:</label> <br />
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_url( $link ); ?>" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $new_tab, 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'new_tab' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>"><?php esc_html_e( 'Open Links in New Browser Tab', 'the-landscaper-wp' ); ?></label>
			</p>
			<?php
		}
	}
	add_action( 'widgets_init', create_function( '', 'register_widget( "QT_CTA_Button" );' ) );
}