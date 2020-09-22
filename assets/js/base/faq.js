(function ($) {
	/**
	 * @param $scope The widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetFaqs = function ($scope, $) {

		var faqs = $( $scope ).find( '.boostify-faq' );

		$( faqs ).each( function(){
			var question = $( this ).find( '.boostify-question' );
			$( question ).on( 'click', function(){

				var parent = $( this ).parent();

				if ( $( parent ).hasClass('active') === true ) {
					$( parent ).removeClass( 'active' );
					$( this ).siblings(".boostify-answer").slideUp( 500 );
				}else{
					$( parent ).addClass( 'active' );
					$( parent ).find( '.boostify-answer' ).slideDown(500);

				}

			} );
		} );

	};

	// Make sure you run this code under Elementor.
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/boostify-faqs.default', WidgetFaqs);
	});
})(jQuery);
