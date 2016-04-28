/* Sticky Navigation */
define( ['jquery', 'underscore'], function ( $, _ ) {
	'use strict';

	var navigation = $('.navigation'),
		bodyClass = $('body'),
		stickyNavTop = navigation.offset().top,
		adminBar = $('body').hasClass('admin-bar') ? 32 : 0;
	
	$(window).on('scroll', function(){
		if($(window).scrollTop() > stickyNavTop - adminBar ) {
			if( bodyClass.hasClass('fixed-navigation') ) {
				bodyClass.addClass('is-sticky-nav');
				navigation.addClass('is-sticky');
			}
		} else {
			bodyClass.removeClass('is-sticky-nav');
			navigation.removeClass('is-sticky');
		}
	});
});