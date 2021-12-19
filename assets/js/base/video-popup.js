(function ($) {
	'use strict';

	/**
	 * @param $scope The widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetVideoPopup = function ($scope, $) {
		$scope.find(".html5lightbox").html5lightbox();
	};

	$( window ).on(
		'elementor/frontend/init',
		function () {
			elementorFrontend.hooks.addAction(
				'frontend/element_ready/boostify-video-popup.default',
				WidgetVideoPopup
			);
		}
	);
} )( jQuery );
