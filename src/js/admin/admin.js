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

	// For tab.
	$(document).on(
		'click',
		'.list-tab .tab',
		function ( e ) {
			e.preventDefault();
			var href = $( this ).attr( 'href' ),
				list = $( this ).parents( '.list-tab' ),
				tab = $( href );

				console.log( tab );

			list.find( '.active' ).removeClass( 'active' );
			$( this ).addClass( 'active' );
			tab.parent().find('.active').removeClass( 'active' );
			tab.addClass( 'active' );
		}
	);
} )( jQuery );
