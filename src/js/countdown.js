( function ($) {
	'use strict';

	/**
	 * @param $scope The widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetCountDown = function ($scope, $) {

        var counter_id = $scope.find( '.boostify-count-down' ).data('id'),
        date = $scope.find('#bcd-'+counter_id).data('date'),
        en_digit = ( 'yes' === $scope.find('#bcd-'+counter_id).data('digit') ) ? true : false; 
        const second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;
        let countDown = new Date(date).getTime(),
        x = setInterval(function() {    
            let now = new Date().getTime(),
            distance = countDown - now;
            let cr_days = Math.floor(distance / (day)),
            cr_hours = Math.floor((distance % (day)) / (hour)),
            cr_minutes = Math.floor((distance % (hour)) / (minute)),
            cr_seconds = Math.floor((distance % (minute)) / second);
 
            if (distance < 0) {
                clearInterval(x);
                cr_days = cr_hours = cr_minutes = cr_seconds = 0;
            } 
            $('#days-'+counter_id).text( counterDoubleDigit(cr_days , en_digit) ),
            $('#hours-'+counter_id).text( counterDoubleDigit(cr_hours , en_digit) ),
            $('#minutes-'+counter_id).text( counterDoubleDigit(cr_minutes , en_digit) ),
            $('#seconds-'+counter_id).text( counterDoubleDigit(cr_seconds , en_digit) );
        }, second);

        function counterDoubleDigit( arg , allow = true ){
            if( arg.toString().length <= 1 && true == allow ){
                arg = ('0' + arg).slice(-2);
            }
            return arg;
        }

	};

	$( window ).on(  
		'elementor/frontend/init',
		function () {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/boostify-count-down.default', WidgetCountDown );
		}
	);

} )( jQuery );
