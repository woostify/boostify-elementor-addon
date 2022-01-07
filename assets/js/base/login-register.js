(function ($) {
	/**
	 * @param $scope The widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetLoginRegister = function ($scope, $) {
		var btnLogin = $scope.find( '.wp-form-login' ),
			settings        = $scope.data('settings'),
			btnVisibility   = $scope.find('.visibility-password'),
			id              = $scope.data('id'),
			loginRecaptcha  = $('#g-recaptcha-'+ id),
			classError      = 'boostify-error',
			elementError    = 'div',
			childErrorClass = 'error-text',
			// For Login.
			userField       = $scope.find('input[name=username]'),
			passField       = $scope.find('input[name=password]'),
			redirectLogined = $scope.find('input[name=redirect_for_logined]').val(),
			redirectUrl     = $scope.find('input[name=redirect_url]').val();

		if ( redirectLogined ) {
			window.location.href = redirectLogined;
		}

		if ( grecaptcha !== undefined && loginRecaptcha.length > 0 ) {
			grecaptcha.ready(function () {
				var loginRecaptchaNode = document.getElementById('g-recaptcha-'+ id);
				grecaptcha.render( loginRecaptchaNode, {
					'sitekey' : admin.recaptcha_sitekey,
				});
			})
		}

		btnVisibility.on( 'click', function ( e ) {
			e.preventDefault();
			var input = $(this).siblings('input');
			if ( input.attr('type') == 'password' ) {
				$(this).addClass( 'dashicons-hidden' ).removeClass( 'dashicons-visibility' );
				input.attr('type', 'text');
			} else {
				$(this).addClass( 'dashicons-visibility' ).removeClass( 'dashicons-hidden' );
				input.attr('type', 'password');
			}
		} );

		btnLogin.on( 'submit', function( e ) {
			e.preventDefault();
			var user     = userField.val(),
				pass     = passField.val(),
				remember = $scope.find('input[name=rememberme]').is(":checked");

			if ( user == '' ) {
				userField.parent().addClass( 'error' );
			}
			if ( pass == '' ) {
				passField.parent().addClass( 'error' );
			}

			if ( grecaptcha !== undefined && loginRecaptcha.length > 0 ) {
				var response = grecaptcha.getResponse();

				if ( ! response ) {
					errMessages( loginRecaptcha, settings.err_recaptcha, 'error-recaptcha' );
					return;
				}
			}

			var data     = {
				action: 'boostify_wp_login',
				token: admin.nonce,
				user: user,
				pass: pass,
				remember: remember
			};

			$.ajax(
				{
					type: 'POST',
					url: admin.url,
					data: data,
					beforeSend: function (response) {
						$( '#ht_hf_setting' ).addClass( 'loading' );
					},
					success: function (response) {
						console.log( response );
						if ( response.success ) {
							if ( redirectUrl ) {
								window.location.href = redirectUrl;
							}
						} else {
							var data = response.data;

							if ( data.invalid_username ) {
								if ( settings.err_username == '' ) {
									settings.err_username = data.invalid_username;
								}
								errMessages( userField, settings.err_username, 'error-username' );
								userField.parent().addClass( 'error' );
							} else if ( data.invalid_email ) {
								if ( settings.err_email == '' ) {
									settings.err_email = data.invalid_email;
								}
								errMessages( userField, settings.err_email, 'error-email' );
								userField.parent().addClass( 'error' );
							} else if ( data.incorrect_password || data.empty_password ) {
								if ( settings.err_pass == '' ) {
									settings.err_pass = data.incorrect_password;
								}
								errMessages( userField, settings.err_pass, 'incorrect-password' );
								passField.parent().addClass( 'error' );
							}
						}
					},
				}
			);
		} );

		function errMessages( element, message,  $class = '' ) {
			var errElement = element.parent().find( '.' + classError );
			if ( errElement.length > 0 ) {
				errElement.html( '<span class="' + childErrorClass + '">' + message + '</span>' );
			} else {
				element.after(
						'<'+ elementError +' class="' + classError + ' ' + $class + '"><span class="' + childErrorClass + '">' + message + '</span></div>'
					)
			}
		}
	};

	// Make sure you run this code under Elementor.
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/boostify-wp-login-register.default', WidgetLoginRegister);
	});
})(jQuery);
