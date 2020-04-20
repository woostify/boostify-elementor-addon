( function ($) {
	'use strict';

	/**
	 * @param $scope The widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetPostGrid = function ($scope, $) {

		var layout = $scope.find( '.boostify-layout-masonry' );
		if ( layout.length > 0 ) {
			var layout = $scope.find( '.boostify-layout-masonry' );
			layout.masonry(
				{
					// options
					itemSelector: '.boostify-post-item',
					columnWidth: '.boostify-post-item'
				}
			);
		}

	};

	$( window ).on(
		'elementor/frontend/init',
		function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/boostify-post-grid.default', WidgetPostGrid );
		}
	);

} )( jQuery );
