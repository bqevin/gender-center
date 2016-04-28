/* Maps */

define( ['jquery', 'underscore'], function ( $, _ ) {
	'use strict';
	
	$(document).ready(function () {
		$('.qt-map').each(function() {
			
			var data = $(this).data(), // Get the data from this element

			options = { // Create map options object
				center: new google.maps.LatLng(data.lat, data.lng), // Set center from the specified lat and lng
				scrollwheel: false, // Dont Zoom in/out when scrolling page
				zoom: data.zoom, // Set zoom level from 1 to maximum of 24
				mapTypeId: data.type, // Set map type ID: roadmap, satellit, hybrid or terrain
				styles: data.style, // Include the chosen custom map style from the data attr
			};

			// Create the map object
			var map = new google.maps.Map(this, options);

			// Check if title exist then create the infowindow
			if (data.title) {
				var InfoWindow = new google.maps.InfoWindow({
					content: data.title
				});
			}

			// Create the marker based on the lat & lng
			var marker = new google.maps.Marker({
				position: options['center'],
				map: map,
				icon: data.pin,
				title: data.title,
			});

			// Create the click event
			google.maps.event.addListener(marker, 'click', function() {
				InfoWindow.open(map,marker);
			});

			// Initialize the Map
			google.maps.event.addDomListener(window, 'load' );
			
		});
	});
});