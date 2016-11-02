/**
 * Sends the clients credentials to be
 * validated and authenticated.
 */
$(document).ready(function() {
	$(document).on('submit', '#maintenance-login', function() {

        var btnSignIn = $('#btn-sign-in');

		var statusContainer = '#maintenance-login-status';

        var sArray = $(this).serialize();

        // Prepare and send the request
		$.ajax({
			type: "POST",
			url: $(this).attr('action'),
			data: sArray,
			dataType: "json",
			beforeSend: function() {
                /*
                 * Before we send the request, we'll display
                 * a nice message to let the user know the
                 * form has been sent
                 */
				showStatusMessage('Logging In...', 'info', statusContainer);

                // Disable the login button until a response is received
                btnDisable(btnSignIn);
			}
		}).done(function(result) {
            if(result.messageType === 'success'){
                /*
                 * Looks like the credentials are good,
                 * we'll redirect the user to the result URL
                 */
                window.setTimeout(function(){
                        window.location.href = result.redirect;
                }, 3000);

                showStatusMessage(result.message, result.messageType, statusContainer);
            } else if(typeof result.message !== 'undefined'){
                showStatusMessage(result.message, result.messageType, statusContainer);
            } else {
                showFormErrors(result.errors);
            }

            btnEnable(btnSignIn);
		});
		
		return false;
	});
});