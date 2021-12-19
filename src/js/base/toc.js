(function ($) {
	'use strict';

	/**
	 * @param $scope The widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetTOC = function ($scope, $) {
		console.log($scope.data('settings'));
		var setting = $scope.data('settings'),
			excludeTag = setting.exclude_headings_by_selector,
			includeTag = setting.headings_by_tags;

		console.log( includeTag.join(',') );

		console.log( $('body').find(includeTag.join(',')).not('.boostify-toc-header-title') );
		$('body').find(includeTag.join(',')).not('.boostify-toc-header-title');
	};

	$( window ).on(
		'elementor/frontend/init',
		function () {
			elementorFrontend.hooks.addAction(
				'frontend/element_ready/boostify-table-of-content.default',
				WidgetTOC
			);
		}
	);
} )( jQuery );
