jQuery(document).ready( function($) {
	'use strict';
	
	// Color picker for the CTA Banner Widget
	$('.qt-color-picker').wpColorPicker();
	
	// Color picker for if widget is saved
	$(document).ajaxComplete(function() {
		$('.qt-color-picker').wpColorPicker();
	});

});