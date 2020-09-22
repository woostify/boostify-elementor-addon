( function ($) {
	'use strict';

	/**
	 * @param $scope The widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetPostSlider = function ($scope, $) {

		var slider         = $scope.find( '.swiper-container' );
		var slide          = slider.find( '.swiper-wrapper' );
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
		var loop           = slide.attr( 'slider-loop' );
		var space          = slide.attr( 'column-space' );
		var btnNext = $scope.find( '.swiper-button-next' );
		var btnPrev = $scope.find( '.swiper-button-prev' );
		if ( space == 'undefined' || space == '' ) {
			space = 0;
		}
		space              = parseInt( space );
		var arrows         = false;
		var dots           = false;
		var data           = {};
		data               = {

			slidesPerView: column,
			slidesPerGroup: slidesPerGroup,
			spaceBetween: space,
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
		};
		if ( loop == 'yes' ) {
			data.loop                   = true;
			data.loopFillGroupWithBlank = true;
		}
		if ( arrow == 'yes' ) {
			data.navigation = {
				nextEl: btnNext,
				prevEl: btnPrev,
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
				delay: 3000
			}
			data.speed    = speed;
		}
		console.log( data );

		var swiper = new Swiper(
			slider,
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
