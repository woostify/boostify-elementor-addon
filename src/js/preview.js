'use strict';

var onElementorLoaded = function onElementorLoaded( callback ) {
	if ( undefined === window.elementorFrontend || undefined === window.elementorFrontend.hooks ) {
		setTimeout( 
			function () {
				return onElementorLoaded( callback );
			}
		);

		return;
	}

	callback();
};

jQuery( document ).ready(
	function ( $ ) {

		function masonryBlog() {
			var layout = $( '.boostify-layout-masonry' );
			var $grid  = layout.masonry(
				{
					// options
					itemSelector: '.boostify-post-item',
					columnWidth: '.boostify-post-item'
				}
			);
		}

		function videoPopup() {
			var html5lightbox_options = {
				watermark: "http://html5box.com/images/html5boxlogo.png",
				watermarklink: "http://html5box.com"
			};
		}

		onElementorLoaded(
			function () {
				elementorFrontend.hooks.addAction(
					'frontend/element_ready/global',
					function () {
						masonryBlog();
						videoPopup();
					}
				);
			}
		);
	}
);
