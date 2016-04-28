<?php
/**
 * Widget: Testimonials
 *
 * @package The Landscaper
 */

if ( ! class_exists( 'QT_Testimonials' ) ) {
	class QT_Testimonials extends WP_Widget {

		/**
		* Register widget with WordPress.
		*/
		public function __construct() {
			parent::__construct(
			false,
				esc_html__( 'QT: Testimonials', 'the-landscaper-wp' ),
				array(
					'description' => esc_html__( 'Testomonial Widget', 'the-landscaper-wp' ),
					'classname'   => 'widget-testimonials',
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
			$header    = apply_filters( 'widget_title', empty( $instance['header'] ) ? '' : $instance['header'], $instance, $this->id_base );
			$autocycle = empty( $instance['autocycle'] ) ? false : 'yes' === $instance['autocycle'];
			$interval  = empty( $instance['interval'] ) ? 6000 : absint( $instance['interval'] );

			$columns   = round( 12 / $instance['columns'] ); // Calculate columns based on Bootstrap grid
			$amount    = empty( $instance['columns'] ) ? 2 : absint( $instance['columns'] );

			if ( isset( $instance['quote'] ) ) :
				$testimonials = array( 
					array(
						'quote'    => $instance['quote'],
						'author'   => $instance['author'],
						'location' => $instance['location'],
					)
				);
			else :
				$testimonials = array_values( $instance['testimonials'] );
			endif;

			echo $args['before_widget']; ?>

			<div class="testimonials">
				
				<?php if( $header ) : ?>
					<h3 class="widget-title">
				<?php endif; ?>
					
					<?php if ( count( $testimonials ) > $amount ) : ?>
						<a class="right testimonial-control" href="#testimonials-carousel-<?php echo esc_attr( $args['widget_id'] ); ?>" role="button" data-slide="next">
							<i class="fa fa-angle-right" aria-hidden="true"></i>
							<span class="sr-only">Next</span>
						</a>
						<a class="left testimonial-control" href="#testimonials-carousel-<?php echo esc_attr( $args['widget_id'] ); ?>" role="button" data-slide="prev">
							<i class="fa fa-angle-left" aria-hidden="true"></i>
							<span class="sr-only">Previous</span>
						</a>
					<?php endif; ?>
					
					<?php echo wp_kses_post( $header ); ?>

				<?php if( $header ) : ?>
					</h3>
				<?php endif; ?>
				
				<div id="testimonials-carousel-<?php echo esc_attr( $args['widget_id'] ); ?>" class="carousel slide" <?php echo esc_attr( $autocycle ) ? 'data-ride="carousel" data-interval="' . esc_attr( $interval ) . '"' : ''; ?>>
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<div class="row">
								
								<?php
								foreach ( $testimonials as $index => $testimonial ) : ?>
									<?php echo ( 0 !== $index && 0 === $index % $amount ) ? '</div></div><div class="item"><div class="row">' : ''; ?>
									<div class="col-xs-12 col-sm-6 col-md-<?php echo esc_attr( $columns ); ?>">
										<blockquote class="testimonial-quote">
											<?php echo esc_attr( $testimonial['quote'] ); ?>
										</blockquote>
										<div class="testimonial-person">
											<cite class="testimonial-author"><?php echo esc_attr( $testimonial['author'] ); ?></cite>
											<span class="testimonial-location"><?php echo esc_attr( $testimonial['location'] ); ?></span>
										</div>
									</div>
									<?php
								endforeach;
								?>

							</div>
						</div>
					</div>	
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

			$instance['header']    = wp_kses_post( $new_instance['header'] );
			$instance['columns']   = sanitize_key( $new_instance['columns'] );
			$instance['autocycle'] = sanitize_key( $new_instance['autocycle'] );
			$instance['interval']  = absint( $new_instance['interval'] );

			foreach ( $new_instance['testimonials'] as $key => $testimonial ) {
				$instance['testimonials'][$key]['id'] = sanitize_key( $testimonial['id'] );
				$instance['testimonials'][$key]['quote'] = sanitize_text_field( $testimonial['quote'] );
				$instance['testimonials'][$key]['author'] = sanitize_text_field( $testimonial['author'] );
				$instance['testimonials'][$key]['location'] = sanitize_text_field( $testimonial['location'] );
			}

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

			$header    = empty( $instance['header'] ) ? '' : $instance['header'];
			$columns   = empty( $instance['columns'] ) ? 2 : $instance['columns'];
			$autocycle = empty( $instance['autocycle'] ) ? 'no' : $instance['autocycle'];
			$interval  = empty( $instance['interval'] ) ? 6000 : $instance['interval'];

			if ( isset( $instance['quote'] ) ) {
				$testimonials = array( array(
					'id'       => 1,
					'quote'    => $instance['quote'],
					'author'   => $instance['author'],
					'location' => $instance['location'],
				) );
			}
			else {
				$testimonials = isset( $instance['testimonials'] ) ? array_values( $instance['testimonials'] ) : array(
					array(
						'id'       => 1,
						'quote'    => '',
						'author'   => '',
						'location' => '',
					)
				);
			}

			?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'header' ) ); ?>"><?php esc_html_e( 'Widget Title', 'the-landscaper-wp'  ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'header' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'header' ) ); ?>" type="text" value="<?php echo esc_attr( $header ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>"><?php esc_html_e( 'Show amount of testimonials in a row', 'the-landscaper-wp' ); ?>:</label>
				<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'columns' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>">
					<option value="1"<?php selected( $columns, '1' ) ?>><?php esc_html_e( '1', 'the-landscaper-wp'  ); ?></option>
					<option value="2"<?php selected( $columns, '2' ) ?>><?php esc_html_e( '2', 'the-landscaper-wp'  ); ?></option>
					<option value="3"<?php selected( $columns, '3' ) ?>><?php esc_html_e( '3', 'the-landscaper-wp'  ); ?></option>
					<option value="4"<?php selected( $columns, '4' ) ?>><?php esc_html_e( '4', 'the-landscaper-wp'  ); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'autocycle' ) ); ?>"><?php esc_html_e( 'Auto cycle carousel', 'the-landscaper-wp' ); ?>:</label>
				<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'autocycle' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'autocycle' ) ); ?>">
					<option value="yes"<?php selected( $autocycle, 'yes' ) ?>><?php esc_html_e( 'Yes', 'the-landscaper-wp'  ); ?></option>
					<option value="no"<?php selected( $autocycle, 'no' ) ?>><?php esc_html_e( 'No', 'the-landscaper-wp'  ); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'interval' ) ); ?>"><?php esc_html_e( 'Interval (in miliseconds)', 'the-landscaper-wp' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'interval' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'interval' ) ); ?>" type="number" min="0" step="500" value="<?php echo esc_attr( $interval ); ?>" />
			</p>

			<hr>

			<h3><?php esc_html_e( 'Testimonials', 'the-landscaper-wp'  ); ?>:</h3>

			<script type="text/template" id="js-testimonial-<?php echo esc_attr( $this->id ); ?>">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'testimonials' ) ); ?>-<%- id %>-quote"><?php esc_html_e( 'Quote', 'the-landscaper-wp' ); ?>:</label>
					<textarea rows="4" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'testimonials' ) ); ?>-<%- id %>-quote" name="<?php echo esc_attr( $this->get_field_name( 'testimonials' ) ); ?>[<%- id %>][quote]"><%- quote %></textarea>
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'testimonials' ) ); ?>-<%- id %>-author"><?php esc_html_e( 'Author', 'the-landscaper-wp' ); ?>:</label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'testimonials' ) ); ?>-<%- id %>-author" name="<?php echo esc_attr( $this->get_field_name( 'testimonials' ) ); ?>[<%- id %>][author]" type="text" value="<%- author %>" />
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'testimonials' ) ); ?>-<%- id %>-location"><?php esc_html_e( 'Author Location', 'the-landscaper-wp' ); ?>:</label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'testimonials' ) ); ?>-<%- id %>-location" name="<?php echo esc_attr( $this->get_field_name( 'testimonials' ) ); ?>[<%- id %>][location]" type="text" value="<%- location %>" />
				</p>
				<p>
					<input name="<?php echo esc_attr( $this->get_field_name( 'testimonials' ) ); ?>[<%- id %>][id]" type="hidden" value="<%- id %>" />
					<a href="#" class="js-remove-testimonial"><span class="dashicons dashicons-dismiss"></span><?php esc_html_e( 'Remove Testimonial', 'the-landscaper-wp' ); ?></a>
				</p>
			</script>
		 
			<div id="js-testimonials-<?php echo esc_attr( $this->id ); ?>">
				<div id="js-testimonials-list"></div>
				<p><a href="#" class="button" id="js-testimonials-add"><?php esc_html_e( 'Add New Testimonial', 'the-landscaper-wp' ); ?></a></p>
			</div>
		 
			<script type="text/javascript">
				var testimonialsJSON = <?php echo wp_json_encode( $testimonials ) ?>;
				QTTestimonials.repopulateTestimonials( '<?php echo esc_js( $this->id ); ?>', testimonialsJSON );
			</script>
	 
	    <?php
		}
	}
	add_action( 'widgets_init', create_function( '', 'register_widget( "QT_Testimonials" );' ) );
}