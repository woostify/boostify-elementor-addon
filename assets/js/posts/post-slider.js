( function ($) {
	'use strict';

	/**
	 * @param $scope The widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetPostSlider = function ($scope, $) {

		var slider         = $scope.find( '.boostify-post-slider-widget' );
		var slide          = slider.find( '.boostify-widget-post-slider-wrapper' );
		var column         = slider.attr( 'columns' );
		column             = parseInt( column );
		var columnsTablet  = slider.attr( 'columns-tablet' );
		columnsTablet      = parseInt( columnsTablet );
		var columnsMobile  = slider.attr( 'columns-mobile' );
		columnsMobile      = parseInt( columnsMobile );
		var arrow          = slider.attr( 'arrow' );
		var dot            = slider.attr( 'dots' );
		var autoplay       = slider.attr( 'slider-autoplay' );
		var speed          = slide.attr( 'slide-speed' );
		var slidesPerGroup = slide.attr( 'slide-scroll' );
		slidesPerGroup     = parseInt( slidesPerGroup );
		speed              = parseInt( speed );
		var loop           = slide.attr( 'loop' );
		var arrows         = false;
		var dots           = false;
		var data           = {};
		data               = {
			speed: speed,
			slidesPerView: column,
			slidesPerGroup: slidesPerGroup,
			breakpoints: {
				640: {
					slidesPerView: columnsMobile,
				},
				768: {
					slidesPerView: columnsTablet,
				},
				1024: {
					slidesPerView: column,
				},
			}
		}
		if ( loop == 'yes' ) {
			data.loop = true;
		}
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

		if ( autoplay == 'yes' ) {
			data.autoplay = {
				delay: 2500,
				disableOnInteraction: false,
			}
		}

		var swiper = new Swiper(
			'.swiper-container',
			data
		);
	};

	$( window ).on(
		'elementor/frontend/init',
		function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/boostify-post-slider.default', WidgetPostSlider );
		}
	);

} )( jQuery );
