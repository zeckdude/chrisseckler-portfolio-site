function showErrorDialogWithMessage(message)
{
	// For the tutorial, we'll just do an alert. You should customize this function to 
	// present "pretty" error messages on your page.
	alert(message);

	// Re-enable the submit button so the user can try again
	$('#buy-submit-button').removeAttr("disabled");
}


// Called when Stripe's server returns a token (or an error)
function stripeResponseHandler(status, response)
{
	if (response.error) 
	{
		// Stripe.js failed to generate a token. The error message will explain why.
		// Usually, it's because the customer mistyped their card info.
		// You should customize this to present the message in a pretty manner:
		alert(response.error.message);
	} 
	else 
	{	
		// Stripe.js generated a token successfully. We're ready to charge the card!
		var token = response.id;
		var firstName = $("#first-name").val();
		var lastName = $("#last-name").val();
		var email = $("#email").val();
		var price = $("#charge-amount").val();

		// We need to know what amount to charge. Assume $20.00 for the tutorial. 
		// You would obviously calculate this on your own:
		
 
		// Make the call to the server-script to process the order.
		// Pass the token and non-sensitive form information.
		var request = $.ajax ({
			type: "POST",
			url: "./pay.php",
			dataType: "json",
			data: {
				"stripeToken" : token,
				"firstName" : firstName,
				"lastName" : lastName,
				"email" : email,
				"price" : price
				}
		});

		request.done(function(msg)
		{
			if (msg.result === 0)
			{
				// Customize this section to present a success message and display whatever
				// should be displayed to the user.
				alert("The credit card was charged successfully!");
			}
			else
			{
				// The card was NOT charged successfully, but we interfaced with Stripe
				// just fine. There's likely an issue with the user's credit card.
				// Customize this section to present an error explanation
				alert("The user's credit card failed.");
			}
		});

		request.fail(function(jqXHR, textStatus)
		{
			// We failed to make the AJAX call to pay.php. Something's wrong on our end.
			// This should not normally happen, but we need to handle it if it does.
			alert("Error: failed to call pay.php to process the transaction.");
		});
	}
}



$(document).ready(function() 
{
	$('#buy-form').submit(function(event)
	{
		// immediately disable the submit button to prevent double submits
		$('#buy-submit-button').attr("disabled", "disabled");
		
		var fName = $('#first-name').val();
		var lName = $('#last-name').val();
		var email = $('#email').val();
		var cardNumber = $('#card-number').val();
		var cardCVC = $('#card-security-code').val();
		var chargeAmount = $('#charge-amount').val();
		
		// First and last name fields: make sure they're not blank
		if (fName === "") {
			showErrorDialogWithMessage("Please enter your first name.");
			return;
		}
		if (lName === "") {
			showErrorDialogWithMessage("Please enter your last name.");
			return;
		}
		
		// Validate the email address:
		var emailFilter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (email === "") {
			showErrorDialogWithMessage("Please enter your email address.");
			return;
		} else if (!emailFilter.test(email)) {
			showErrorDialogWithMessage("Your email address is not valid.");
			return;
		}
		 
		// Stripe will validate the card number and CVC for us, so just make sure they're not blank
		if (cardNumber === "") {
			showErrorDialogWithMessage("Please enter your card number.");
			return;
		}
		if (cardCVC === "") {
			showErrorDialogWithMessage("Please enter your card security code.");
			return;
		}
		
		if (chargeAmount === "") {
			showErrorDialogWithMessage("Please enter the amount to charge.");
			return;
		}
		
		// Boom! We passed the basic validation, so request a token from Stripe:
		Stripe.createToken({
			number: cardNumber,
			cvc: cardCVC,
			exp_month: $('#expiration-month').val(),
			exp_year: $('#expiration-year').val()
		}, stripeResponseHandler);

		// Prevent the default submit action on the form
		return false;
	});
});