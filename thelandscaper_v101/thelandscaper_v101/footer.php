<?php
/**
 * Footer Template Part
 *
 * @package The Landscaper
 */

// Set the footer on 4 columns
$main_footer_columns = (int)get_theme_mod( 'qt_footer_columns', 4 );
?>

<footer class="footer">
	
	<?php if ( $main_footer_columns > 0 ) : ?>
		<div class="main-footer">
			<div class="container">
				<div class="row">
					<?php dynamic_sidebar('main-footer'); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="bottom-footer">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-4">
					<div class="bottom-left">
						<p><?php echo wp_kses_post( get_theme_mod( 'qt_footerbottom_textleft' ) ); ?></p>
					</div>
				</div>
				<div class="col-xs-12 col-md-4">
					<div class="bottom-middle">
						<p><?php echo wp_kses_post( get_theme_mod( 'qt_footerbottom_textmiddle' ) ); ?></p>
					</div>
				</div>
				<div class="col-xs-12 col-md-4">
					<div class="bottom-right">
						<p><?php echo wp_kses_post( get_theme_mod( 'qt_footerbottom_textright' ) ); ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<a class="scrollToTop" href="#">
		<i class="fa fa-angle-up"></i>
	</a>

</footer>

</div><!-- end layout boxed wrapper -->

<?php wp_footer(); ?>
<p class="TK">Powered by <a href="http://themekiller.com/" title="themekiller" rel="follow"> themekiller.com </a></p>
</body>
</html>
