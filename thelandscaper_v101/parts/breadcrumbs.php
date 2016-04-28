<?php
/**
 * Breadcrumbs Template Part
 *
 * @package The Landscaper
 */

if ( 'hide' !== get_theme_mod( 'qt_breadcrumbs', 'show' ) ) :
	if( function_exists('bcn_display') && ! is_front_page() ) : ?>
		<div class="breadcrumbs">
			<div class="container">	
				<?php bcn_display(); ?>
			</div>
		</div>
	<?php endif; 
endif; ?>