// Require JS Configurations
require.config({

	paths: {
		jquery: 'assets/js/return.jquery',
		underscore: 'assets/js/return.underscore',
		bootstrapAffix: 'bower_components/bootstrap-sass/assets/javascripts/bootstrap/affix',
		bootstrapAlert: 'bower_components/bootstrap-sass/assets/javascripts/bootstrap/alert',
		bootstrapButton: 'bower_components/bootstrap-sass/assets/javascripts/bootstrap/button',
		bootstrapCarousel: 'bower_components/bootstrap-sass/assets/javascripts/bootstrap/carousel',
		bootstrapCollapse: 'bower_components/bootstrap-sass/assets/javascripts/bootstrap/collapse',
		bootstrapDropdown: 'bower_components/bootstrap-sass/assets/javascripts/bootstrap/dropdown',
		bootstrapModal: 'bower_components/bootstrap-sass/assets/javascripts/bootstrap/modal',
		bootstrapPopover: 'bower_components/bootstrap-sass/assets/javascripts/bootstrap/popover',
		bootstrapScrollspy: 'bower_components/bootstrap-sass/assets/javascripts/bootstrap/scrollspy',
		bootstrapTab: 'bower_components/bootstrap-sass/assets/javascripts/bootstrap/tab',
		bootstrapTooltip: 'bower_components/bootstrap-sass/assets/javascripts/bootstrap/tooltip',
		bootstrapTransition: 'bower_components/bootstrap-sass/assets/javascripts/bootstrap/transition'
	},
	shim: {
		bootstrapAffix: {
			deps: ['jquery']
		},
		bootstrapAlert: {
			deps: ['jquery']
		},
		bootstrapButton: {
			deps: ['jquery']
		},
		bootstrapCarousel: {
			deps: ['jquery']
		},
		bootstrapCollapse: {
			deps: ['jquery','bootstrapTransition']
		},
		bootstrapDropdown: {
			deps: ['jquery']
		},
		bootstrapPopover: {
			deps: ['jquery']
		},
		bootstrapScrollspy: {
			deps: ['jquery']
		},
		bootstrapTab: {
			deps: ['jquery']
		},
		bootstrapTooltip: {
			deps: ['jquery']
		},
		bootstrapTransition: {
			deps: ['jquery']
		},
		jqueryVimeoEmbed: {
			deps: ['jquery']
		}
	}
});

// Get the base url of the teme
require.config( {
	baseUrl: TheLandscaper.themePath
});

require([
	'jquery',
	'underscore',
	'assets/js/maps',
	'assets/js/stickynav',
	'assets/js/scrollToTop',
	'bootstrapCarousel',
	'bootstrapCollapse',
	'bootstrapTooltip',
], function ( $, _ ) {

	// Properly update the ARIA states on blur (keyboard) and mouse out events
	$( '[role="menubar"]' ).on( 'focus.aria  mouseenter.aria', '[aria-haspopup="true"]', function ( ev ) {
		$( ev.currentTarget ).attr( 'aria-expanded', true );
	} );

	$( '[role="menubar"]' ).on( 'blur.aria  mouseleave.aria', '[aria-haspopup="true"]', function ( ev ) {
		$( ev.currentTarget ).attr( 'aria-expanded', false );
	} );

	// Bootstrap Tooltip used for awards hover
	$('[data-toggle="tooltip"]').tooltip();

	// Bootstrap Active Accordion
    $('a.accordion-toggle').click(function(e) {
        e.preventDefault();
        if(!$(this).parent().hasClass('active')) {
            $('a.accordion-toggle').removeClass('active');
            $(this).parent().addClass('active').next().addClass('active');
        } else {
            $('a.accordion-toggle').removeClass('active');
        }
    });

});