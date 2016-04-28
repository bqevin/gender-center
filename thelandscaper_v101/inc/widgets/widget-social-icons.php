<?php
/**
 * Widget: Social Icons
 *
 * @package The Landscaper
 */

if ( ! class_exists( 'QT_Social_Icons' ) ) {
	class QT_Social_Icons extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				false,
				esc_html__( 'QT: Social Icons', 'the-landscaper-wp' ),
				array(
					'description' => esc_html__( 'Social Media Icons', 'the-landscaper-wp' ),
					'classname'   => 'widget-social-icons',
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
		 	?>

		 	<div class="social-icons">
				<?php if( $instance['fb_profile'] ) : ?>
					<a href="<?php echo esc_url_raw( $instance['fb_profile'] ); ?>" <?php echo empty ( $instance['new_tab'] ) ? '' : 'target="_blank"'; ?>>
						<i class="fa fa-facebook"></i>
					</a>
				<?php endif; ?>

				<?php if( $instance['twttr_profile'] ) : ?>
					<a href="<?php echo esc_url_raw( $instance['twttr_profile'] ); ?>" <?php echo empty ( $instance['new_tab'] ) ? '' : 'target="_blank"'; ?>>
						<i class="fa fa-twitter"></i>
					</a>
				<?php endif; ?>

				<?php if( $instance['google_profile'] ) : ?>
					<a href="<?php echo esc_url_raw( $instance['google_profile'] ); ?>" <?php echo empty ( $instance['new_tab'] ) ? '' : 'target="_blank"'; ?>>
						<i class="fa fa-google-plus"></i>
					</a>
				<?php endif; ?>

				<?php if( $instance['lnkin_profile'] ) : ?>
					<a href="<?php echo esc_url_raw( $instance['lnkin_profile'] ); ?>" <?php echo empty ( $instance['new_tab'] ) ? '' : 'target="_blank"'; ?>>
						<i class="fa fa-linkedin"></i>
					</a>
				<?php endif; ?>
				
				<?php if( $instance['youtube_profile'] ) : ?>
					<a href="<?php echo esc_url_raw( $instance['youtube_profile'] ); ?>" <?php echo empty ( $instance['new_tab'] ) ? '' : 'target="_blank"'; ?>>
						<i class="fa fa-youtube-play"></i>
					</a>
				<?php endif; ?>
				
				<?php if( $instance['insta_profile'] ) : ?>
					<a href="<?php echo esc_url_raw( $instance['insta_profile'] ); ?>" <?php echo empty ( $instance['new_tab'] ) ? '' : 'target="_blank"'; ?>>
						<i class="fa fa-instagram"></i>
					</a>
				<?php endif; ?>
				
				<?php if( $instance['tumblr_profile'] ) : ?>
					<a href="<?php echo esc_url_raw( $instance['tumblr_profile'] ); ?>" <?php echo empty ( $instance['new_tab'] ) ? '' : 'target="_blank"'; ?>>
						<i class="fa fa-tumblr"></i>
					</a>
				<?php endif; ?>

				<?php if( $instance['pintrst_profile'] ) : ?>
					<a href="<?php echo esc_url_raw( $instance['pintrst_profile'] ); ?>" <?php echo empty ( $instance['new_tab'] ) ? '' : 'target="_blank"'; ?>>
						<i class="fa fa-pinterest"></i>
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

			$instance['fb_profile']		 = sanitize_text_field( $new_instance['fb_profile'] );
			$instance['twttr_profile']	 = sanitize_text_field( $new_instance['twttr_profile'] );
			$instance['google_profile']	 = sanitize_text_field( $new_instance['google_profile'] );
			$instance['lnkin_profile']	 = sanitize_text_field( $new_instance['lnkin_profile'] );
			$instance['youtube_profile'] = sanitize_text_field( $new_instance['youtube_profile'] );
			$instance['insta_profile']	 = sanitize_text_field( $new_instance['insta_profile'] );
			$instance['tumblr_profile']  = sanitize_text_field( $new_instance['tumblr_profile'] );
			$instance['pintrst_profile'] = sanitize_text_field( $new_instance['pintrst_profile'] );
			$instance['new_tab'] 		 = ! empty( $new_instance['new_tab'] ) ? sanitize_key( $new_instance['new_tab'] ) : '';
			
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
			$new_tab         = empty( $instance['new_tab'] ) ? '' : $instance['new_tab'];
			$fb_profile      = empty( $instance['fb_profile'] ) ? '' : $instance['fb_profile'];
			$twttr_profile   = empty( $instance['twttr_profile'] ) ? '' : $instance['twttr_profile'];
			$google_profile  = empty( $instance['google_profile'] ) ? '' : $instance['google_profile'];
			$lnkin_profile   = empty( $instance['lnkin_profile'] ) ? '' : $instance['lnkin_profile'];
			$insta_profile   = empty( $instance['insta_profile'] ) ? '' : $instance['insta_profile'];
			$tumblr_profile  = empty( $instance['tumblr_profile'] ) ? '' : $instance['tumblr_profile'];
			$pintrst_profile = empty( $instance['pintrst_profile'] ) ? '' : $instance['pintrst_profile'];
			$youtube_profile = empty( $instance['youtube_profile'] ) ? '' : $instance['youtube_profile'];
			?>

			<p>
				<input class="checkbox" type="checkbox" <?php checked( $new_tab, 'on'); ?> id="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'new_tab' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>"><?php esc_html_e('Open link in new browser tab?', 'the-landscaper-wp'   ); ?></label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('fb_profile' ) ); ?>">Facebook <?php esc_html_e( 'Link', 'the-landscaper-wp'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'fb_profile' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'fb_profile' ) ); ?>" type="text" value="<?php echo esc_attr( $fb_profile ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('twttr_profile' ) ); ?>">Twitter <?php esc_html_e( 'Link', 'the-landscaper-wp'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twttr_profile' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twttr_profile' ) ); ?>" type="text" value="<?php echo esc_attr( $twttr_profile ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('google_profile' ) ); ?>">Google+ <?php esc_html_e( 'Link', 'the-landscaper-wp'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'google_profile' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'google_profile' ) ); ?>" type="text" value="<?php echo esc_attr( $google_profile ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('lnkin_profile' ) ); ?>">LinkedIn <?php esc_html_e( 'Link', 'the-landscaper-wp'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'lnkin_profile' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'lnkin_profile' ) ); ?>" type="text" value="<?php echo esc_attr( $lnkin_profile ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('youtube_profile' ) ); ?>">Youtube <?php esc_html_e( 'Link', 'the-landscaper-wp'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube_profile ' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube_profile' ) ); ?>" type="text" value="<?php echo esc_attr( $youtube_profile ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('insta_profile' ) ); ?>">Instagram <?php esc_html_e( 'Link', 'the-landscaper-wp'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'insta_profile' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'insta_profile' ) ); ?>" type="text" value="<?php echo esc_attr( $insta_profile ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('tumblr_profile' ) ); ?>">Tumblr <?php esc_html_e( 'Link', 'the-landscaper-wp'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tumblr_profile') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tumblr_profile' ) ); ?>" type="text" value="<?php echo esc_attr( $tumblr_profile ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('pintrst_profile' ) ); ?>">Pinterest <?php esc_html_e( 'Link', 'the-landscaper-wp'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pintrst_profile' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pintrst_profile' ) ); ?>" type="text" value="<?php echo esc_attr( $pintrst_profile ); ?>" />
			</p>
			
			<?php 
		}
	}
	add_action( 'widgets_init', create_function( '', 'register_widget( "QT_Social_Icons" );' ) );
}