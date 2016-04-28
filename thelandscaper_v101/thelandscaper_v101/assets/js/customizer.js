/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	"use strict";

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( 'a.logo h1' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.topbar .tagline' ).text( to );
		} );
	} );

	// Topbar Background Color
	wp.customize( 'qt_topbar_bg', function( value ) {
		value.bind( function( newval ) {
			$('.topbar').css('background-color', newval );
			$('.header').css('background-color', newval );
		} );
	} );

	// Topbar Text Color
	wp.customize( 'qt_topbar_textcolor', function( value ) {
		value.bind( function( newval ) {
			$( '.topbar a' ).css('color', newval );
			$( '.topbar .fa' ).css('color', newval );
			$( '.topbar .tagline' ).css('color', newval );
			$( '.topbar .widget-icon-box .title' ).css('color', newval );
			$( '.topbar .widget-icon-box .subtitle' ).css('color', newval );
			$( '.topbar .widget-icon-box .fa' ).css('color', newval );
			$( '.topbar .widget-social-icons a' ).css('color', newval );
		} );
	} );

	// Navigation Background Color
	wp.customize( 'qt_nav_bg', function( value ) {
		value.bind( function( newval ) {
			$('.main-navigation').css('background-color', newval );
		} );
	} );

	// Mobile Navigation Background Color
	wp.customize( 'qt_nav_mobile_bg', function( value ) {
		value.bind( function( newval ) {
			$('.main-navigation').css('background-color', newval );
		} );
	} );

	// Navigation Text Color
	wp.customize( 'qt_nav_textcolor', function( value ) {
		value.bind( function( newval ) {
			$( '.main-navigation>li>a' ).css('color', newval );
		} );
	} );

	// Mobile Navigation Text Color
	wp.customize( 'qt_nav_mobile_textcolor', function( value ) {
		value.bind( function( newval ) {
			$( '.main-navigation>li>a' ).css('color', newval );
		} );
	} );
	
	// Navigation Submenu Background Color
	wp.customize( 'qt_nav_submenu_bg', function( value ) {
		value.bind( function( newval ) {
			$( '.main-navigation>li>.sub-menu li a' ).css('background-color', newval );
		} );
	} );

	// Mobile Navigation Submenu Background Color
	wp.customize( 'qt_nav_mobile_submenu_bg', function( value ) {
		value.bind( function( newval ) {
			$( '.main-navigation>li>.sub-menu li a' ).css('background-color', newval );
		} );
	} );
	
	// Navigation Submenu Text Color
	wp.customize( 'qt_nav_submenu_textcolor', function( value ) {
		value.bind( function( newval ) {
			$( '.main-navigation>li>.sub-menu li a' ).css('color', newval );
		} );
	} );

	// Mobile Navigation Submenu Text Color
	wp.customize( 'qt_maintitle_bgcolor', function( value ) {
		value.bind( function( newval ) {
			$( '.page-header' ).css('background-color', newval );
		} );
	} );

	// Main Title Background Color
	wp.customize( 'qt_maintitle_color', function( value ) {
		value.bind( function( newval ) {
			$( '.page-header .main-title' ).css('color', newval );
		} );
	} );

	// Main Title Text Color
	wp.customize( 'qt_maintitle_color', function( value ) {
		value.bind( function( newval ) {
			$( '.page-header .main-title' ).css('color', newval );
		} );
	} );

	// Sub Main Title Text Color
	wp.customize( 'qt_subtitle_color', function( value ) {
		value.bind( function( newval ) {
			$( '.page-header .sub-title' ).css('color', newval );
		} );
	} );

	// Breadcrumbs Text Color
	wp.customize( 'qt_breadcrumbs_textcolor', function( value ) {
		value.bind( function( newval ) {
			$( '.breadcrumbs a' ).css('color', newval );
		} );
	} );

	// Breadcrumbs Active Color
	wp.customize( 'qt_breadcrumbs_activecolor', function( value ) {
		value.bind( function( newval ) {
			$( '.breadcrumbs span>span' ).css('color', newval );
		} );
	} );

	// Layout Text Color
	wp.customize( 'qt_theme_textcolor', function( value ) {
		value.bind( function( newval ) {
			$( 'body, .content a.icon-box .subtitle' ).css('color', newval );
		} );
	} );

	// Theme Colors -- Primary | Color
	wp.customize( 'qt_theme_primary_color', function( value ) {
		value.bind( function( newval ) {
			$( 'a.more' ).css('color', newval );
			$( '.dropcap' ).css('color', newval );
			$( '.content .icon-box.box-block .fa' ).css('color', newval );
			$( '.content .icon-box:hover .fa' ).css('color', newval );
			$( '.post .post-left-meta .day' ).css('color', newval );
			$( '.cta-button:hover .fa' ).css('color', newval );
			$( '.brochure-box:hover .fa' ).css('color', newval );
			$( '.opening-times ul li.today' ).css('color', newval );
			$( '.woocommerce-page div.product p.price' ).css('color', newval );
		} );
	} );
	// Theme Colors -- Primary | Background Color
	wp.customize( 'qt_theme_primary_color', function( value ) {
		value.bind( function( newval ) {
			$( '.count-box .count-icon .fa' ).css('background-color', newval );
			$( '.sidebar .widget_nav_menu .menu li a' ).css('background-color', newval );
			$( '.woocommerce .widget_product_categories .product-categories li a' ).css('background-color', newval );
			$( '.carousel-indicators li.active' ).css('background-color', newval );
			$( 'qt-table thead td' ).css('background-color', newval );
			$( '.opening-times ul span.right.label' ).css('background-color', newval );
		} );
	} );
	// Theme Colors -- Primary | Border Color
	wp.customize( 'qt_theme_primary_color', function( value ) {
		value.bind( function( newval ) {
			$( '.carousel-indicators li.active' ).css('border-color', newval );
			$( '.wpcf7-text:focus' ).css('border-color', newval );
			$( '.wpcf7-textarea:focus' ).css('border-color', newval );
			$( '.comment-form .comment-form-author input:focus' ).css('border-color', newval );
			$( '.comment-form .comment-form-email input:focus' ).css('border-color', newval );
			$( '.comment-form .comment-form-url input:focus' ).css('border-color', newval );
			$( '.comment-form .comment-form-comment textarea:focus' ).css('border-color', newval );
		} );
	} );


	// Theme Colors -- Button | Background Color
	wp.customize( 'qt_theme_primary_btncolor', function( value ) {
		value.bind( function( newval ) {
			$( '.btn-primary' ).css('background-color', newval );
			$( '.wpcf7-submit' ).css('background-color', newval );
			$( 'button' ).css('background-color', newval );
			$( 'input[type="button"]' ).css('background-color', newval );
			$( 'input[type="reset"]' ).css('background-color', newval );
			$( 'input[type="submit"]' ).css('background-color', newval );
			$( '.post-item .vertical-center span' ).css('background-color', newval );
			$( '.post-item .label' ).css('background-color', newval );
			$( '.testimonial-control' ).css('background-color', newval );
			$( '.testimonial-control:first-of-type::before' ).css('background-color', newval );
			$( '.testimonial-control:last-of-type::before' ).css('background-color', newval );
			$( '.project-navigation a' ).css('background-color', newval );
			$( '.pagination a.current' ).css('background-color', newval );
			$( '.pagination span.current' ).css('background-color', newval );
			$( '.woocommerce-page a.button' ).css('background-color', newval );
			$( '.woocommerce-page input.button' ).css('background-color', newval );
			$( '.woocommerce-page input.button.alt' ).css('background-color', newval );
			$( '.woocommerce-page button.button' ).css('background-color', newval );
			$( '.woocommerce span.onsale' ).css('background-color', newval );
			$( '.woocommerce ul.products li.product .onsale' ).css('background-color', newval );
			$( '.woocommerce nav.woocommerce-pagination ul li span.current' ).css('background-color', newval );
			$( '.woocommerce-page div.product form.cart .button.single_add_to_cart_button' ).css('background-color', newval );
			$( '.woocommerce div.product .woocommerce-tabs ul.tabs li.active' ).css('background-color', newval );
			$( '.woocommerce-cart .wc-proceed-to-checkout a.checkout-button' ).css('background-color', newval );			
		} );
	} );
	// Theme Colors -- Button | Text Color
	wp.customize( 'qt_theme_primary_btntext', function( value ) {
		value.bind( function( newval ) {
			$( '.btn-primary' ).css('color', newval );
			$( '.wpcf7-submit' ).css('color', newval );
			$( 'button' ).css('color', newval );
			$( 'input[type="button"]' ).css('color', newval );
			$( 'input[type="reset"]' ).css('color', newval );
			$( 'input[type="submit"]' ).css('color', newval );
			$( '.post-item .vertical-center span' ).css('color', newval );
			$( '.post-item .label' ).css('color', newval );
			$( '.testimonial-control' ).css('color', newval );
			$( '.testimonial-control:first-of-type::before' ).css('color', newval );
			$( '.testimonial-control:last-of-type::before' ).css('color', newval );
			$( '.project-navigation a' ).css('color', newval );
			$( '.pagination a.current' ).css('color', newval );
			$( '.pagination span.current' ).css('color', newval );
			$( '.woocommerce-page a.button' ).css('color', newval );
			$( '.woocommerce-page input.button' ).css('color', newval );
			$( '.woocommerce-page input.button.alt' ).css('color', newval );
			$( '.woocommerce-page button.button' ).css('color', newval );
			$( '.woocommerce span.onsale' ).css('color', newval );
			$( '.woocommerce ul.products li.product .onsale' ).css('color', newval );
			$( '.woocommerce nav.woocommerce-pagination ul li span.current' ).css('color', newval );
			$( '.woocommerce-page div.product form.cart .button.single_add_to_cart_button' ).css('color', newval );
			$( '.woocommerce div.product .woocommerce-tabs ul.tabs li.active' ).css('color', newval );
			$( '.woocommerce-cart .wc-proceed-to-checkout a.checkout-button' ).css('color', newval );	
		} );
	} );

	// Theme Colors -- Widget Title Color
	wp.customize( 'qt_theme_widgettitle', function( value ) {
		value.bind( function( newval ) {
			$( '.widget-title' ).css('color', newval );
		} );
	} );
	// Theme Colors -- First Span Widget Title Color
	wp.customize( 'qt_theme_widgettitle_span', function( value ) {
		value.bind( function( newval ) {
			$( '.content .widget-title span.light' ).css('color', newval );
		} );
	} );

	// Footer Text Color
	wp.customize( 'qt_footer_textcolor', function( value ) {
		value.bind( function( to ) {
			$( '.main-footer' ).css( 'color', to );
			$( '.main-footer p' ).css( 'color', to );
			$( '.main-footer .widget_nav_menu ul>li>a' ).css( 'color', to );
		});
	} );

	// Footer Widget Title Color
	wp.customize( 'qt_footer_widgettitle', function( value ) {
		value.bind( function( to ) {
			$( '.footer .widget-title ' ).css( 'color', to );
		});
	} );

	// Footer Background Color
	wp.customize( 'qt_footer_bgcolor', function( value ) {
		value.bind( function( newval ) {
			$( '.main-footer' ).css('background-color', newval );
		} );
	} );

	// Bottom Footer Background Color
	wp.customize( 'qt_footerbottom_bgcolor', function( value ) {
		value.bind( function( newval ) {
			$( '.bottom-footer' ).css('background-color', newval );
		} );
	} );
	
	// Bottom Footer Text Color
	wp.customize( 'qt_footerbottom_textcolor', function( value ) {
		value.bind( function( newval ) {
			$( '.bottom-footer p' ).css('color', newval );
		});
	} );

	// Bottom Footer Link Color
	wp.customize( 'qt_footerbottom_linkcolor', function( value ) {
		value.bind( function( to ) {
			$( '.bottom-footer a' ).css( 'color', to );
		});
	} );

} )( jQuery );