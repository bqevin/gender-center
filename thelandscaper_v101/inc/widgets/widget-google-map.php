<?php
/**
 * Widget: Google Maps
 *
 * @package The Landscaper
 */

if ( ! class_exists( 'QT_Google_Map' ) ) {
	class QT_Google_Map extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
		 		false,
				esc_html__( 'QT: Google Map', 'the-landscaper-wp' ),
				array( 
					'description' => esc_html__( 'Display a Google Map', 'the-landscaper-wp' ),
					'classname'   => 'widget-google-map',
				)
			);
		}

		/**
		 * Custom Map Styles
		 * @see snazzymaps.com
		 */
		private $map_styles = array(
			'Default'          => '[]',
        	'Paper'            => '[{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"visibility":"simplified"},{"hue":"#0066ff"},{"saturation":74},{"lightness":100}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"off"},{"weight":0.6},{"saturation":-85},{"lightness":61}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"simplified"},{"color":"#5f94ff"},{"lightness":26},{"gamma":5.86}]}]',
        	'Canary'           => '[{"featureType":"all","elementType":"all","stylers":[{"hue":"#ffbb00"}]},{"featureType":"all","elementType":"geometry.fill","stylers":[{"hue":"#ffbb00"}]},{"featureType":"all","elementType":"labels.text.fill","stylers":[{"hue":"#ffbb00"}]}]',
        	'Blue Water'       => '[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]',
        	'Red Hat Antwerp'  => '[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"geometry.fill","stylers":[{"visibility":"on"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#b4d4e1"},{"visibility":"on"}]}]',
        	'Subtle Grayscale' => '[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]'
		);

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			extract( $args );
			extract( $instance );
			echo $before_widget;
			?>

			<div 
				class="qt-map"
				data-lat="<?php echo esc_attr( $lat ); ?>"
				data-lng="<?php echo esc_attr( $lng ); ?>"
				<?php
					if( $instance['title'] ) : ?>
						data-title="<?php echo esc_attr( $title ); ?>"
					<?php endif;
				?>
				data-zoom="<?php echo absint( $zoom ); ?>"
				data-type="<?php echo esc_attr( $type ); ?>"
				data-style="<?php echo esc_attr( $this->map_styles[$style] ); ?>"
				<?php
					if( $instance['pin'] ) : ?>
						data-pin="<?php echo esc_url( $pin ); ?>"
					<?php endif;
				?>
				style="height: <?php echo absint( $height ); ?>px;"
			></div>

			<?php
			echo $after_widget;
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

			$instance['lat']    = sanitize_text_field( $new_instance['lat'] );
			$instance['lng']    = sanitize_text_field( $new_instance['lng'] );
			$instance['title']  = wp_kses_post( $new_instance['title'] );
			$instance['zoom']   = absint( $new_instance['zoom'] );
			$instance['type']   = sanitize_key( $new_instance['type'] );
			$instance['style']  = sanitize_text_field( $new_instance['style'] );
			$instance['pin']    = esc_url( $new_instance['pin'] );
			$instance['height'] = absint( $new_instance['height'] );

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
			$lat    = isset( $instance['lat'] ) ? $instance['lat'] : '40.724545';
			$lng    = isset( $instance['lng'] ) ? $instance['lng'] : '-73.941860';
			$title  = isset( $instance['title'] ) ? $instance['title'] : '';
			$zoom   = isset( $instance['zoom'] ) ? $instance['zoom'] : 12;
			$type   = isset( $instance['type'] ) ? $instance['type'] : 'roadmap';
			$style  = isset( $instance['style'] ) ? $instance['style'] : 'Subtle Grayscale';
			$pin    = isset( $instance['pin'] ) ? $instance['pin'] : '';
			$height = isset( $instance['height'] ) ? $instance['height'] : 400;
			?>

			<p>
				<?php printf( esc_html__( "You can find the latitude and longitude from %s ", 'the-landscaper-wp'  ), '<a href="'. esc_url( 'http://www.latlong.net/' ) .'" target="_blank">this website</a>' ); ?>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'lat' ) ); ?>"><?php esc_html_e( 'Latitude of the location:', 'the-landscaper-wp' ); ?></label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'lat' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'lat' ) ); ?>" value="<?php echo esc_attr( $lat ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'lng' ) ); ?>"><?php esc_html_e( 'Longitude of the location:', 'the-landscaper-wp' ); ?></label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'lng' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'lng' ) ); ?>" value="<?php echo esc_attr( $lng ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title on Infobox: (Optional)', 'the-landscaper-wp' ); ?></label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'zoom' ) ); ?>"><?php esc_html_e( 'Map Zoom:', 'the-landscaper-wp' ); ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'zoom' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'zoom' ) ); ?>">
				<?php for ( $i=1; $i < 25; $i++ ) : ?>
					<option value="<?php echo esc_attr( $i ); ?>" <?php selected( $zoom, $i ); ?>><?php echo esc_html( $i ); ?></option>
				<?php endfor; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_html_e( 'Map Type:', 'the-landscaper-wp' ); ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
					<option value="roadmap" <?php selected( $type, 'roadmap' ); ?>>Roadmap</option>
					<option value="satellite" <?php selected( $type, 'satellite' ); ?>>Satellite</option>
					<option value="hybrid" <?php selected( $type, 'hybrid' ); ?>>Hybrid</option>
					<option value="terrain" <?php selected( $type, 'terrain' ); ?>>Terrain</option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php esc_html_e( 'Map Style:', 'the-landscaper-wp'  ); ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>">
				<?php foreach ( $this->map_styles as $style_name => $map_style ) : ?>
					<option value="<?php echo esc_attr( $style_name ); ?>" <?php selected( $style, $style_name ); ?>><?php echo esc_html( $style_name ); ?></option>
				<?php endforeach; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"><?php esc_html_e( 'Height of map (in px):', 'the-landscaper-wp'  ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" type="number" value="<?php echo esc_attr( $height ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'pin' ) ); ?>"><?php esc_html_e( 'Custom Marker URL (Empty is default marker)', 'the-landscaper-wp'  ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pin' ) ); ?>" value="<?php echo esc_url( $pin ); ?>" />
			</p>

			<?php
		}
	}
	add_action( 'widgets_init', create_function( '', 'register_widget( "QT_Google_Map" );' ) );
}