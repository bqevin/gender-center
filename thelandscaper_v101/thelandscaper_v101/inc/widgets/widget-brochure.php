<?php
/**
 * Widget: Brochure
 *
 * @package The Landscaper 
 */

if ( ! class_exists( 'QT_Brochure' ) ) {
	class QT_Brochure extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
	    public function __construct() {
			parent::__construct(
				false,
				esc_html__( 'QT: Brochure', 'the-landscaper-wp' ),
				array(
					'description' => esc_html__( 'Upload a Brochure', 'the-landscaper-wp' ),
					'classname'   => 'widget-brochure',
				)
			);
		}

		/**
		 * Enqueue the JS and CSS files for the widget
		 */
		public static function enqueue_js_css() {
			wp_enqueue_media();
			wp_enqueue_script( 'thelandscaper-upload', get_template_directory_uri() . '/assets/js/widgets/brochure.js', array( 'jquery' ), '', true );
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
	    	$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'] );

	    	echo $args['before_widget'];

			if ( ! empty ( $instance['title'] ) ) : ?>
				<h6 class="widget-title"><?php echo wp_kses_post( $instance['title'] ); ?></h6>
			<?php endif; ?>

			<a href="<?php echo $instance['brochure_url']; ?>" class="brochure-box" <?php echo empty ( $instance['new_tab'] ) ? '' : 'target="_blank"'; ?>>
				<i class="fa <?php echo esc_attr( $instance['brochure_icon'] ); ?>"></i>
				<span><?php echo esc_attr( $instance['brochure_btn'] ); ?></span>
			</a>
				
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
			
			$instance['title']         = wp_kses_post( $new_instance['title'] );
			$instance['brochure_icon'] = sanitize_html_class( $new_instance['brochure_icon'] );
			$instance['brochure_url']  = esc_url_raw( $new_instance['brochure_url'] );
			$instance['brochure_btn']  = wp_kses_post( $new_instance['brochure_btn'] );
			$instance['new_tab']	   = ! empty( $new_instance['new_tab'] ) ? sanitize_key( $new_instance['new_tab'] ) : '';
			
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
			$title         = empty( $instance['title'] ) ? '' : $instance['title'];
			$brochure_icon = isset( $instance['brochure_icon'] ) ?  $instance['brochure_icon'] : 'fa-file-pdf-o';
			$brochure_url  = empty( $instance['brochure_url'] ) ? '' : $instance['brochure_url'];
			$brochure_btn  = isset( $instance['brochure_btn'] ) ? $instance['brochure_btn'] : 'Download Brochure';
			$new_tab	   = empty( $instance['new_tab'] ) ? '' : $instance['new_tab'];
			?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title', 'the-landscaper-wp' ); ?>:</label><br />
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'brochure_icon' ) ); ?>"><?php esc_html_e( 'Icon', 'the-landscaper-wp' ); ?>:</label><br/>
				<small><em><?php printf( esc_html__( 'See %s for all icon classes (example: fa-home)', 'the-landscaper-wp' ), '<a href="'. esc_url( 'http://fontawesome.io/icons/' ) .'" target="_blank">FontAwesome</a>' ); ?></em></small></label><br />
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'brochure_icon' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id('brochure_icon') ); ?>" value="<?php echo esc_attr( $brochure_icon ); ?>" class="widefat" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'brochure_url' ) ); ?>"><?php esc_html_e( 'File', 'the-landscaper-wp' ); ?>:</label><br />
				<input class="upload-file-url" id="<?php echo esc_attr( $this->get_field_id( 'brochure_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'brochure_url' ) ); ?>" type="text" value="<?php echo esc_attr( $brochure_url ); ?>" />
				<input type="button" class="upload-file-button button" value="Upload File" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'brochure_btn' ) ); ?>"><?php esc_html_e( 'Text on Button', 'the-landscaper-wp' ); ?>:</label><br />
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'brochure_btn' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'brochure_btn' ) ); ?>" value="<?php echo esc_attr( $brochure_btn ); ?>" class="widefat" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $new_tab, 'on'); ?> id="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'new_tab' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>"><?php esc_html_e('Open link in new browser tab', 'the-landscaper-wp' ); ?></label>
			</p>

			<?php
		}
	}
	add_action( 'widgets_init', create_function( '', 'return register_widget( "QT_Brochure" );' ) );
	add_action( 'admin_enqueue_scripts', array( 'QT_Brochure', 'enqueue_js_css' ) );
}