(function ($) {
	'use strict';

	/**
	 * @param $scope The widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetTOC = function ($scope, $) {
		var setting = $scope.data('settings'),
			body = $scope.find('.boostify-toc-body'),
			excludeTag = setting.exclude_headings_by_selector,
			includeTag = setting.headings_by_tags,
			container = setting.container ? setting.container : 'body',
			marker = setting.marker_view,
			icon = setting.icon,
			heading = $(container).find(includeTag.join(',')).not('.boostify-toc-header-title');

		var nav = [],
			depth = [],
			html = '<ol class="boostify-toc-list-wrapper">';

		for (var i = 0; i < includeTag.length; i++) {
			depth[includeTag[i]] = i;
		}

		console.log( setting );

		heading.each( function( index ) {
			$(this).before('<div id="boostify-toc-' + index +'"></div>');
			var item = $(this),
				text = item.text(),
				prev = item.prev(),
				iconHtml = '',
				depthItem = depth[item[0].localName];

				if ( index > 0 ) {
					prev = $(heading[index-1]);
					var prevLevel = depth[prev[0].localName];
					if ( prevLevel > depthItem ) {
						html += '</ol>'
					}
				}

				if ( icon ) {
					iconHtml = '<span class="' + icon.value + '"></span>';
				}

				html += '<li class="boostify-toc-list-item ' + marker + '">' +
					'<div class="boostify-toc-list-item-text">' +
						iconHtml +
						'<a href="#boostify-toc-' + index +'">' +
							text +
						'</a>' +
					'<div>';
				if ( index < heading.length - 1 ) {
					var next = $(heading[index+1]),
						nextLevel = depth[next[0].localName];

					if ( nextLevel > depthItem ) {
						html += '<ol class="boostify-toc-list-wrapper">';
					} else {
						html += '</li>';
					}
				}
		} );

		html += '</ol>';

		body.html(html);

		$('body').on( 'click', '.boostify-toc-list-item a', function (e) {
			e.preventDefault();
			var id = $(this).attr('href');
			console.log( id );
			var top = $(id).offset().top - 50;
			$( 'html, body' ).animate( { scrollTop: top }, 500);
		} );

		$scope.on( 'click', '.boostify-toc-toggle-button-expand', function(e) {
			body.slideDown(500);
			$(this).css('display', 'none');
			$(this).siblings( '.boostify-toc-toggle-button-collapse' ).css( 'display', 'block' );
		} );

		$scope.on( 'click', '.boostify-toc-toggle-button-collapse', function(e) {
			$(this).css('display', 'none');
			$(this).siblings( '.boostify-toc-toggle-button-expand' ).css( 'display', 'block' );
			body.slideUp(500);
		} );

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