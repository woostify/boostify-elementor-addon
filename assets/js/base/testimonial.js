(function ($) {
	'use strict';

	/**
	 * @param $scope The widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetTestimonial = function ($scope, $) {
		var test   = $scope.find( '.swiper-container' );
		var col = test.attr( 'data-col' );
		var arrow = test.attr( 'data-arrow' );
		var dot = test.attr('data-dot');
		var data = {
			slidesPerView: col,
			spaceBetween: 30,
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			// autoplay: {
			// 	delay: 5000,
			// 	disableOnInteraction: false,
			// },
			loop: false,
			// loopFillGroupWithBlank: true,
			speed: 1000
		};

		if ( arrow == 'yes' ) {
			data.navigation = {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			}
		}

		if ( dot == 'yes' ) {
			data.pagination = {
				el: '.swiper-pagination',
				clickable: true,
			}
		}
		var swiper = new Swiper(
			test,data
		);

	};

	$( window ).on(
		'elementor/frontend/init',
		function () {
			elementorFrontend.hooks.addAction(
				'frontend/element_ready/boostify-testimonial.default',
				WidgetTestimonial
			);
		}
	);
} )( jQuery );
