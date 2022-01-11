(function ($) {
	/**
	 * @param $scope The widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetLoginRegister = function ($scope, $) {
		var btnLogin          = $scope.find( '.wp-form-login' ),
			formRegister      = $scope.find( '.wp-form-register' ),
			settings          = $scope.data( 'settings' ),
			btnVisibility     = $scope.find( '.visibility-password' ),
			id                = $scope.data( 'id' ),
			loginRecaptcha    = $( '#g-recaptcha-'+ id ),
			registerRecaptcha = $( '#g-recaptcha-register-'+ id ),
			classError        = 'boostify-error',
			elementError      = 'div',
			childErrorClass   = 'error-text',
			// For Login.
			userField         = btnLogin.find( 'input[name=username]' ),
			passField         = btnLogin.find( 'input[name=password]' ),
			redirectLogined   = btnLogin.find( 'input[name=redirect_for_logined]' ).val(),
			redirectUrl       = btnLogin.find( 'input[name=redirect_url]' ).val(),
			// for register.
			userFieldR            = formRegister.find( 'input[name=username_register]' ),
			emailFieldR           = formRegister.find( 'input[name=email_register]' ),
			firstNameFieldR       = formRegister.find( 'input[name=first_name_register]' ),
			lastNameFieldR        = formRegister.find( 'input[name=last_name_register]' ),
			passFieldR            = formRegister.find( 'input[name=password_register]' ),
			passConfR             = formRegister.find( 'input[name=confirm_pass_register]' ),
			websiteFieldR         = formRegister.find( 'input[name=website_register]' ),
			redirectUrlR          = formRegister.find( 'input[name=register_redirect_url]' ),
			termsField            = formRegister.find( '.field-terms-conditions' ),
			sitekey               = $scope.find('input[name=g-recaptcha]').val(),
			actionRegisiter       = formRegister.find('input[name=register_action]').val(),
			adminEmailSubject     = formRegister.find('input[name=admin_email_subject]').val(),
			adminEmailMessage     = formRegister.find('input[name=admin_email_message]').val(),
			adminEmailContentType = formRegister.find('input[name=admin_email_content_type]').val(),
			emailSubject          = formRegister.find('input[name=email_subject]').val(),
			emailMessage          = formRegister.find('input[name=email_message]').val(),
			emailContentType      = formRegister.find('input[name=email_content_type]').val(),
			fieldLink             = $scope.find('.field-link a'),
			popupOverlay          = $scope.find('.popup-overlay');

		if ( redirectLogined ) {
			window.location.href = redirectLogined;
		}

		fieldLink.on( 'click', function(e) {
			if ( $(this).attr('href') == '#' ) {
				e.preventDefault();
				$(this).parents('form').siblings('.form-popup').addClass( 'show' );
			}
		} );

		popupOverlay.on( 'click', function (e) {
			$(this).parents('.form-popup').removeClass( 'show' );
		} )

		// for recaptcha login form
		if ( grecaptcha !== undefined && loginRecaptcha.length > 0 ) {
			grecaptcha.ready(function () {
				var loginRecaptchaNode = document.getElementById('g-recaptcha-'+ id);
				grecaptcha.render( loginRecaptchaNode, {
					'sitekey': sitekey,
					'theme': settings.login_rc_theme,
					'size': settings.login_rc_size
				});
			})
		}
		// For recaptcha register form
		if ( grecaptcha !== undefined && registerRecaptcha.length > 0 ) {
			grecaptcha.ready(function () {
				var resgisterRecaptchaNode = document.getElementById('g-recaptcha-register-'+ id);
				grecaptcha.render( resgisterRecaptchaNode, {
					'sitekey': sitekey,
					'theme': settings.register_rc_theme,
					'size': settings.register_rc_size
				});
			})
		}

		btnVisibility.on( 'click', function ( e ) {
			e.preventDefault();
			var input = $(this).siblings('input');
			if ( input.attr('type') == 'password' ) {
				$(this).find('span').addClass( 'dashicons-hidden' ).removeClass( 'dashicons-visibility' );
				input.attr('type', 'text');
			} else {
				$(this).find('span').addClass( 'dashicons-visibility' ).removeClass( 'dashicons-hidden' );
				input.attr('type', 'password');
			}
		} );

		// For Login
		btnLogin.on( 'submit', function( e ) {
			e.preventDefault();
			// For Login.
			var formLogin       = $(this),
				userField       = formLogin.find( 'input[name=username]' ),
				passField       = formLogin.find( 'input[name=password]' ),
				redirectLogined = formLogin.find( 'input[name=redirect_for_logined]' ).val(),
				redirectUrl     = formLogin.find( 'input[name=redirect_url]' ).val(),
				user            = userField.val(),
				pass            = passField.val(),
				remember        = $scope.find('input[name=rememberme]').is(":checked");

			if ( user == '' ) {
				userField.parents('.field-control').addClass( 'error' );
			}
			if ( pass == '' ) {
				passField.parents('.field-control').addClass( 'error' );
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
						formLogin.find('.btn-submit').prop('disabled', true);
						formLogin.parents( '.boostify-form' ).addClass( 'loading' );
					},
					success: function (response) {
						formLogin.find('.btn-submit').prop('disabled', false);
						formLogin.parents( '.boostify-form' ).removeClass( 'loading' );
						if ( response.success ) {
							if ( redirectUrl ) {
								window.location.href = redirectUrl;
							} else {
								location.reload();
							}
						} else {
							var data = response.data;

							if ( data.invalid_username ) {
								if ( settings.err_username == '' ) {
									settings.err_username = data.invalid_username;
								}
								errMessages( userField, settings.err_username, 'error-username' );
								userField.parents('.field-control').addClass( 'error' );
							} else if ( data.invalid_email ) {
								if ( settings.err_email == '' ) {
									settings.err_email = data.invalid_email;
								}
								errMessages( userField, settings.err_email, 'error-email' );
								userField.parents('.field-control').addClass( 'error' );
							} else if ( data.incorrect_password || data.empty_password ) {
								if ( settings.err_pass == '' ) {
									settings.err_pass = data.incorrect_password;
								}
								errMessages( userField, settings.err_pass, 'incorrect-password' );
								passField.parents('.field-control').addClass( 'error' );
							} else {
								var fieldError = formLogin.find( '.field-messages' );
								if ( settings.err_unknown = '' ) {
									settings.err_unknown = data.error;
								}
								fieldError.html('<'+ elementError +' class="' + classError + '"><span class="' + childErrorClass + '">' + settings.err_unknown + '</span></div>')
							}
						}
					},
				}
			);
		} );

		// For Register
		formRegister.on( 'submit', function( e ) {
			e.preventDefault();
			var form = $(this),
				userFieldR            = form.find( 'input[name=username_register]' ),
				emailFieldR           = form.find( 'input[name=email_register]' ),
				firstNameFieldR       = form.find( 'input[name=first_name_register]' ),
				lastNameFieldR        = form.find( 'input[name=last_name_register]' ),
				passFieldR            = form.find( 'input[name=password_register]' ),
				passConfR             = form.find( 'input[name=confirm_pass_register]' ),
				websiteFieldR         = form.find( 'input[name=website_register]' ),
				redirectUrlR          = form.find( 'input[name=register_redirect_url]' ),
				termsField            = form.find( '.field-terms-conditions' ),
				sitekey               = $scope.find('input[name=g-recaptcha]').val(),
				actionRegisiter       = form.find('input[name=register_action]').val(),
				adminEmailSubject     = form.find('input[name=admin_email_subject]').val(),
				adminEmailMessage     = form.find('input[name=admin_email_message]').val(),
				adminEmailContentType = form.find('input[name=admin_email_content_type]').val(),
				emailSubject          = form.find('input[name=email_subject]').val(),
				emailMessage          = form.find('input[name=email_message]').val(),
				emailContentType      = form.find('input[name=email_content_type]').val(),
				username              = userFieldR.val(),
				firstName             = firstNameFieldR.val(),
				lastName              = lastNameFieldR.val(),
				pass                  = passFieldR.val(),
				confirmPass           = passConfR.val(),
				email                 = emailFieldR.val(),
				website               = websiteFieldR.val(),
				redirect              = redirectUrlR.val(),
				termShow              = form.find('input[name=terms_conditions]')
				error                 = false;


			if ( username == '' ) {
				error = true;
				var userFieldControl = userFieldR.parent();
				errMessages( userFieldR, admin.validate.user, 'error-username' );
				userFieldR.parents('.field-control').addClass( 'error' );
			}
			if ( email == '' ) {
				error = true;
				emailFieldR.parents('.field-control').addClass( 'error' );
				errMessages( emailFieldR, admin.validate.email, 'error-email' );
			}

			if ( passFieldR.parent().hasClass('.field-required') && pass == '' ) {
				error = true;
				passFieldR.parents('.field-control').addClass( 'error' );
				errMessages( passFieldR, admin.validate.email, 'error-email' );
			}

			if ( passConfR.parent().hasClass('.field-required') && confirmPass == '' ) {
				error = true;
				passConfR.parents('.field-control').addClass( 'error' );
				errMessages( passConfR, admin.validate.email, 'error-email' );
			}

			if ( confirmPass && confirmPass != pass ) {
				error = true;
				passConfR.parents('.field-control').addClass( 'error' );
				errMessages( passConfR, settings.err_conf_pass, 'error-email' );
			}

			if ( termShow.length > 0 && ! termShow.is(':checked') ) {
				error = true;
				errMessages( termShow, settings.err_tc, 'error-terms' );
			}

			if ( grecaptcha !== undefined && registerRecaptcha.length > 0 ) {
				var response = grecaptcha.getResponse();

				if ( ! response ) {
					error = true;
					errMessages( registerRecaptcha, settings.err_recaptcha, 'error-recaptcha' );
				}
			}

			if ( error ) {
				return;
			}

			var data     = {
				action: 'boostify_wp_register',
				token: admin.nonce,
				email: email,
				username: username,
				role: settings.register_user_role,
				action_reg: actionRegisiter,
			};

			if ( pass ) {
				data.password = pass;
			}

			if ( confirmPass ) {
				data.confirm_password = confirmPass;
			}

			if ( firstName ) {
				data.first_name = firstName;
			}

			if ( lastName ) {
				data.last_name = lastName;
			}

			if ( website ) {
				data.website = website;
			}

			if ( redirectUrlR.length > 0 ) {
				data.redirect_url = redirectUrlR.val();
			}

			if ( adminEmailSubject ) {
				data.admin_email_subject = adminEmailSubject;
			}

			if ( adminEmailMessage ) {
				data.admin_email_message = adminEmailMessage;
			}

			if ( adminEmailContentType ) {
				data.admin_email_content_type = adminEmailContentType;
			}

			if ( emailSubject ) {
				data.email_subject = emailSubject;
			}

			if ( emailMessage ) {
				data.email_message = emailMessage;
			}

			if ( emailContentType ) {
				data.email_content_type = emailContentType;
			}

			$.ajax(
				{
					type: 'POST',
					url: admin.url,
					data: data,
					beforeSend: function (response) {
						form.find('.btn-submit').prop('disabled', true);
						form.parents( '.boostify-form' ).addClass( 'loading' );
					},
					success: function (response) {
						form.parents( '.boostify-form' ).removeClass( 'loading' );
						form.find('.btn-submit').prop('disabled', false);
						if ( response.success ) {
							if ( redirectUrlR.length > 0 ) {
								window.location.href = redirectUrlR.val();
							} else {
								location.reload();
							}
						} else {
							var data = response.data,
								fieldError = form.find( '.field-messages' );
							console.log( data );

							if ( data.username_required ) {
								errMessages( userFieldR, data.username_required, 'error-username' );
								userFieldR.parents('.field-control').addClass( 'error' );
							} else if ( data.username_registered ) {
								if ( settings.err_username_used == '' ) {
									settings.err_username_used = data.username_registered;
								}
								errMessages( userFieldR, settings.err_username_used, 'error-username' );
								userFieldR.parents('.field-control').addClass( 'error' );
							} else if ( data.username ) {
								if ( settings.err_username == '' ) {
									settings.err_username = data.username;
								}
								errMessages( userFieldR, settings.err_username, 'error-username' );
								passField.parents('.field-control').addClass( 'error' );
							} else if ( data.email_required ) {
								errMessages( emailFieldR, data.email_required, 'error-email' );
								emailFieldR.parents('.field-control').addClass( 'error' );
							} else if ( data.email_format ) {
								if ( settings.err_email == '' ) {
									settings.err_email = data.email_format;
								}
								errMessages( emailFieldR, settings.err_email, 'error-email' );
								emailFieldR.parents('.field-control').addClass( 'error' );
							} else if ( data.email ) {
								if ( settings.err_email_used == '' ) {
									settings.err_email_used = data.email;
								}
								errMessages( emailFieldR, settings.err_email_used, 'error-email' );
								emailFieldR.parents('.field-control').addClass( 'error' );
							} else if ( data.confirm_password ) {
								if ( settings.err_conf_pass == '' ) {
									settings.err_conf_pass = data.confirm_password;
								}
								errMessages( passConfR, settings.err_conf_pass, 'error-email' );
								passConfR.parents('.field-control').addClass( 'error' );
							} else if ( data.logged_in ) {
								if ( settings.logged_in == '' ) {
									settings.logged_in = data.logged_in;
								}
								fieldError.html('<'+ elementError +' class="' + classError + '"><span class="' + childErrorClass + '">' + settings.logged_in + '</span></div>');
							} else {
								if ( settings.err_unknown = '' ) {
									settings.err_unknown = data.user_create;
								}
								fieldError.html('<'+ elementError +' class="' + classError + '"><span class="' + childErrorClass + '">' + settings.err_unknown + '</span></div>');
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

			element.parent().addClass('error');
		}
	};

	// Make sure you run this code under Elementor.
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/boostify-wp-login-register.default', WidgetLoginRegister);
	});
})(jQuery);
