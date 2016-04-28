/* Scroll To Top Button */

define( ['jquery'], function ( $ ) {
	'use strict';

	var isVisible = false;
		$(window).scroll(function(){
			var shouldBeVisible = $( window ).scrollTop() > 1000;
			if ( shouldBeVisible && !isVisible ) {
				isVisible = true;
				$('.scrollToTop').addClass('visible');
			} else if ( isVisible && !shouldBeVisible ) {
				isVisible = false;
				$('.scrollToTop').removeClass('visible');
			}
	});

	$('.scrollToTop').on('click', function(event){
		event.preventDefault();
		$('html, body').animate({
			scrollTop: 0,
		 	}, 700
		);
	});

} );