( function ($) {
	'use strict';
	$(document).on(
		'click',
		'.btn-enable-widget',
		function ( e ) {
			e.preventDefault();
			$('input:checkbox').prop('checked', 'checked');
		}
	);

	$(document).on(
		'click',
		'.btn-disable-widget',
		function ( e ) {
			e.preventDefault();
			$('input:checkbox').prop('checked', false);
		}
	);
} )( jQuery );
