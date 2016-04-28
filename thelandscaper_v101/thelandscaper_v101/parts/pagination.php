<?php
/**
 * Pagination Template Part
 *
 * @package The Landscaper
 */

if ( paginate_links() ) : ?>
	<nav class="pagination">
		<?php	
			$big = 999999999;
			echo paginate_links( array(
				'base' 		=> str_replace( $big, '%#%', get_pagenum_link( $big ) ),
				'format' 	=> '?paged=%#%',
				'current' 	=> max( 1, get_query_var( 'paged' ) ),
				'total' 	=> $wp_query->max_num_pages,
				'type' 		=> '',
				'prev_text' => '<i class="fa fa-long-arrow-left"></i>',
				'next_text' => '<i class="fa fa-long-arrow-right"></i>'
			) );
		?>
	</nav>
<?php endif; ?>