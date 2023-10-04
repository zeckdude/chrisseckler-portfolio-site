// Validation Script





$(document).ready(function(){

	

	//Regular Expressions to use in Validation

	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

	var numReg = /^[0-9]+$/;

	

	

//Validation for Index Page

	

	//Keyup functions

	$("#employee_id").keyup(function(){

		$("#employee_id_error").hide();

		var employeeId = $("#employee_id").val();

			if(employeeId == '') {

				$("#employee_id").after('<div id="employee_id_error" class="error">Your employee id number is required.</div>');

			} 

	});

	

	$("#cost_center").keyup(function(){

		$("#cost_center_error").hide();

		var costCenter = $("#cost_center").val();

		if(costCenter == '') {

			$("#cost_center").after('<div id="cost_center_error" class="error">Your cost center number is required.</div>');

		} 

	});

	

	$("#approved_by").keyup(function(){

		$("#approved_by_error").hide();

		var approvedBy = $("#approved_by").val();

		if(approvedBy == '') {

			$("#manager_warning").after('<div id="approved_by_error" class="error">The approving managers email is required.</div>');

		} 

		

		/*
if(!emailReg.test(approvedBy)) {

			$("#manager_warning").after('<div id="approved_by_error" class="error">Enter a valid Email.</div>');

		}
*/

	});

	

	$("#delivery_bldg").keyup(function(){

		$("#delivery_bldg_integer_error").hide();

		var deliveryBldg = $("#delivery_bldg").val();

		if(deliveryBldg != '') {

			if(!numReg.test(deliveryBldg)) {

				$("#bldg_warning").after('<div id="delivery_bldg_integer_error" class="error">Only whole numbers are allowed.</div>');

			}

		}

	});

	

	$("#delivery_email").keyup(function(){

		$("#delivery_email_error").hide();

		var deliveryEmail = $("#delivery_email").val();

		if(deliveryEmail == '') {

			$("#delivery_email").after('<div id="delivery_email_error" class="error">The delivery contact email is required.</div>');

		}

		

		/*
if(!emailReg.test(deliveryEmail)) {

			$("#delivery_email").after('<div id="delivery_email_error" class="error">Enter a valid Email.</div>');

		}
*/

	});

	

	$("#ext").keyup(function(){

		$("#ext_error").hide();

		var ext = $("#ext").val();

		if(ext == '') {

			$("#ext").after('<div id="ext_error" class="error">The delivery contact extension is required.</div>');

		} else if(!numReg.test(ext)) {

			$("#ext").after('<div id="ext_error" class="error">Only whole numbers are allowed.</div>');

		}

	});

	



	//Click function after user pushes the Submit button

	$("#index_submit").click(function() {

		

		var hasError = false;

											

		$(".error").hide(); //hide all errors

		

		

		var errorArray = new Array(); //array to hold any error values

		

		

		var employeeId = $("#employee_id").val();

		if(employeeId == '') {

			$("#employee_id").after('<div id="employee_id_error" class="error">Your employee id number is required.</div>');

			errorArray['employeeId'] = true;

		}

		

		var costCenter = $("#cost_center").val();

		if(costCenter == '') {

			$("#cost_center").after('<div id="cost_center_error" class="error">Your cost center number is required.</div>');

			errorArray['costCenter'] = true;

		}

		

		var approvedBy = $("#approved_by").val();

		if(approvedBy == '') {

			$("#manager_warning").after('<div id="approved_by_error" class="error">The approving managers email is required.</div>');

			errorArray['approvedBy'] = true;

		} /*
else if(!emailReg.test(approvedBy)) {

			$("#manager_warning").after('<div id="approved_by_error" class="error">Enter a valid Email.</div>');

			errorArray['approvedBy'] = true;

		}
*/

		

		var deliveryBldg = $("#delivery_bldg").val();

		if(deliveryBldg != '') {

			if(!numReg.test(deliveryBldg)) {

				$("#bldg_warning").after('<div id="delivery_bldg_integer_error" class="error">Only whole numbers are allowed.</div>');

				errorArray['deliveryBldg'] = true;

			}

		}

		

		/*if(!numReg.test(deliveryBldg)) {

			$("#bldg_warning").after('<div id="delivery_bldg_integer_error" class="error">Only numbers are allowed.</div>');

			errorArray['deliveryBldg'] = true;

		}*/

		

		var deliveryEmail = $("#delivery_email").val();

		if(deliveryEmail == '') {

			$("#delivery_email").after('<div id="delivery_email_error" class="error">The delivery contact email is required.</div>');

			errorArray['deliveryEmail'] = true;

		} /*
else if(!emailReg.test(deliveryEmail)) {

			$("#delivery_email").after('<div id="delivery_email_error" class="error">Enter a valid Email.</div>');

			errorArray['deliveryEmail'] = true;

		}
*/

		

		var ext = $("#ext").val();

		if(ext == '') {

			$("#ext").after('<div id="ext_error" class="error">The delivery contact extension is required.</div>');

			errorArray['ext'] = true;

		} else if(!numReg.test(ext)) {

			$("#ext").after('<div id="ext_error" class="error">Only whole numbers are allowed.</div>');

			errorArray['ext'] = true;

		}

		

		

		//This loops through the errorArray to check if any fields have errors

		for(value in errorArray) { 

			if(errorArray[value] == true) {

				hasError = true;	

			}

		}



		if(hasError == true) { //if there us an error, then don't let the submit button work

			return false; //this makes the submit button return false, meaning it won't do what it is supposed to do, making it disabled

		}

	}); //end click function for Index Form







	//AJAX Function Stuff





//Validation for Language Options Page





	//Live functions

	$("input[name='english_only']").mousedown(function(){	//hide the english quantity error if an english quantity is chosen									

			$("#english_only_quantity_error").hide();

	});



	$("input[name='english_w_foreign']").mousedown(function(){	//hide the foreign language quantity error if a language quantity is chosen									

			$("#foreign_quantity_error").hide();

	});

	

	

	

	$("#language").change(function(){	//hide the language error if a language is chosen

			var otherLanguage = $("#other_language").val();

			$("#language_error").hide();

			$("#language_both_error").hide();

			

			if(($("#language").attr("selectedIndex") == 0) && (otherLanguage == '')) { //show an error message if no foreign language is chosen

				$("#language").after('<div id="language_error" class="error">Select a language.</div>');

			}

			

			if(($("#language").attr("selectedIndex") != 0) && (otherLanguage != '')) { //show an error message if no foreign language is chosen

				$("#language").after('<div id="language_error" class="error">You may only select one language.</div>');

			}

	});





	$("#other_language").keyup(function(){ //hide the email language proof error if an email is entered

			var otherLanguage = $("#other_language").val();

			$("#language_error").hide();

			$("#language_both_error").hide();

			

			if(($("#language").attr("selectedIndex") == 0) && (otherLanguage == '')) { //show an error message if no foreign language is chosen

				$("#language").after('<div id="language_error" class="error">Select a language.</div>');

			}

			

			if(($("#language").attr("selectedIndex") != 0) && (otherLanguage != '')) { //show an error message if no foreign language is chosen

				$("#language").after('<div id="language_both_error" class="error">You may only select one language.</div>');

			}

	});





	$("#email_language_proof").keyup(function(){ //hide the email language proof error if an email is entered

		$("#email_language_error_1").hide();

		$("#email_language_error_2").hide();

		if($('#foreign_checkbox').is(':checked')) {

			var emailLanguageProof = $("#email_language_proof").val();

			if(emailLanguageProof == '') {

				$("#email_language_proof").after('<div id="email_language_error_1" class="error">You must provide an email to send the language proof to.</div>');

			} /*
else if(!emailReg.test(emailLanguageProof)) {

				$("#email_language_proof").after('<div id="email_language_error_2" class="error">Enter a valid Email.</div>');

			}
*/

		}

	});

	

	

	function checkCharacters() {

		$("#foreign_character_error").hide();

		var foreignCharactersName = $("#foreign_characters_name").val();

		var foreignCharactersLine2 = $("#foreign_characters_line2").val();

		var foreignCharactersLine3 = $("#foreign_characters_line3").val();

		var foreignCharactersLine4 = $("#foreign_characters_line4").val();

		var rlatins = /[\u0030-\u007f]/;

		if (rlatins.test(foreignCharactersName) || rlatins.test(foreignCharactersLine2) || rlatins.test(foreignCharactersLine3) || rlatins.test(foreignCharactersLine4)) {

		  $("#foreign_characters_line4").after('<div id="foreign_character_error" class="error">Only foreign characters and spaces are allowed.</div>');

		}

	}

	

	$("#foreign_characters_name").keyup(function(){

		checkCharacters()									  

	});

	

	$("#foreign_characters_line2").keyup(function(){

		checkCharacters()									  

	});

	

	$("#foreign_characters_line3").keyup(function(){

		checkCharacters()									  

	});

	

	$("#foreign_characters_line4").keyup(function(){

		checkCharacters()									  

	});

	

	$("#english_only_checkbox").change(function(){	//If the english only checkbox is chosen, show the quantity error if no quantity is chosen yet

		$("#english_only_quantity_error").hide();

		$("#english_only_checkbox_error").hide();

		$("#foreign_checkbox_error").hide();

		if($('#english_only_checkbox').is(':checked')) {

			var englishRadioButtons = $("input[name='english_only']");

			if(englishRadioButtons.filter(':checked').length == 0) { //show an error message if no english language quantity is chosen

				$("#english_only_label").after('<span id="english_only_quantity_error" class="error">Choose a quantity.</span>');

			}

		}

	});

	

	$("#foreign_checkbox").change(function(){	//If the foreign checkbox is chosen, show the quantity, language, and email language proof error

		$("#foreign_quantity_error").hide();

		$("#language_error").hide();

		$("#email_language_error_1").hide();

		$("#email_language_error_2").hide();

		$("#english_only_checkbox_error").hide();

		$("#foreign_checkbox_error").hide();

		$("#foreign_character_error").hide();

		

		if($('#foreign_checkbox').is(':checked')) {

			var emailLanguageProof = $("#email_language_proof").val();

			if(emailLanguageProof == '') {

				$("#email_language_proof").after('<div id="email_language_error_1" class="error">You must provide an email to send the language proof to.</div>');

			} /*
else if(!emailReg.test(emailLanguageProof)) {

				$("#email_language_proof").after('<div id="email_language_error_2" class="error">Enter a valid Email.</div>');

			}
*/

			

			var foreignRadioButtons = $("input[name='english_w_foreign']");

			if(foreignRadioButtons.filter(':checked').length == 0) { //show an error message if no foreign language quantity is chosen

				$("#foreign_number").after('<span id="foreign_quantity_error" class="error">Choose a quantity.</span>');

			}

			

			var otherLanguage = $("#other_language").val();

			if(($("#language").attr("selectedIndex") == 0)  && (otherLanguage == '')) { //show an error message if no foreign language is chosen

				$("#language").after('<div id="language_error" class="error">Select a language.</div>');

			}

			

			var foreignCharactersName = $("#foreign_characters_name").val();

			var foreignCharactersLine2 = $("#foreign_characters_line2").val();

			var foreignCharactersLine3 = $("#foreign_characters_line3").val();

			var foreignCharactersLine4 = $("#foreign_characters_line4").val();

			var rlatins = /[\u0030-\u007f]/;

			if (rlatins.test(foreignCharactersName) || rlatins.test(foreignCharactersLine2) || rlatins.test(foreignCharactersLine3) || rlatins.test(foreignCharactersLine4)) {

			  $("#foreign_characters_line4").after('<div id="foreign_character_error" class="error">Only foreign characters and spaces are allowed.</div>');

			}

		}

	});

	

	















	//Click function after user pushes the Submit button

	$("#language_submit").click(function() {

		var hasError = false;

		$(".error").hide(); //hide all errors

		var errorArray = new Array();

		

		if($('#foreign_checkbox').is(':checked')) { //if the foreign box is checked, then there must something in the email language proof box

			var emailLanguageProof = $("#email_language_proof").val();

			if(emailLanguageProof == '') {

				$("#email_language_proof").after('<div id="email_language_error_1" class="error">You must provide an email to send the language proof to.</div>');

				errorArray['emailLanguageProof'] = true;

			} /*
else if(!emailReg.test(emailLanguageProof)) {

				$("#email_language_proof").after('<div id="email_language_error_2" class="error">Enter a valid Email.</div>');

				errorArray['emailLanguageProof'] = true;

			}
*/

			

			var foreignRadioButtons = $("input[name='english_w_foreign']");

			if(foreignRadioButtons.filter(':checked').length == 0) { //show an error message if no foreign language quantity is chosen

				$("#foreign_number").after('<span id="foreign_quantity_error" class="error">Choose a quantity.</span>');

				errorArray['foreignRadioButtons'] = true;

			}

			

			//var otherLanguage = $("#other_language").val();

			if(($("#language").attr("selectedIndex") == 0) && (otherLanguage == '')) { //show an error message if no foreign language is chosen

				$("#language").after('<div id="language_error" class="error">Select a language.</div>');

				errorArray['language'] = true;

			}

			

			

			if((!$("#language").attr("selectedIndex") == 0) && (otherLanguage != '')) { //show an error message if both Language and other language is picked

				$("#other_language").after('<div id="language_both_error" class="error">You may only select one language.</div>');

				errorArray['both_languages'] = true;

			}

			

			var foreignCharactersName = $("#foreign_characters_name").val();

			var foreignCharactersLine2 = $("#foreign_characters_line2").val();

			var foreignCharactersLine3 = $("#foreign_characters_line3").val();

			var foreignCharactersLine4 = $("#foreign_characters_line4").val();

			var rlatins = /[\u0030-\u007f]/;

			if (rlatins.test(foreignCharactersName) || rlatins.test(foreignCharactersLine2) || rlatins.test(foreignCharactersLine3) || rlatins.test(foreignCharactersLine4)) {

			  $("#foreign_characters_line4").after('<div id="foreign_character_error" class="error">Only foreign characters and spaces are allowed.</div>');

			  errorArray['foreignCharacters'] = true;

			}



		} 

		

		

		if(!$('#foreign_checkbox').is(':checked') && !$('#english_only_checkbox').is(':checked')) { //if neither box is checked, then an error shows up

			$("#english_only_checkbox_text").after('<span id="english_only_checkbox_error" class="error">You must choose at least one of these options.</span>');

			$("#foreign_checkbox_tooltip").after('<span id="foreign_checkbox_error" class="error">You must choose at least one of these options.</span>');

			errorArray['neitherChecked'] = true;

		}

			

		if($('#english_only_checkbox').is(':checked')) {

			var englishRadioButtons = $("input[name='english_only']");

			if(englishRadioButtons.filter(':checked').length == 0) { //show an error message if no english language quantity is chosen

				$("#english_only_label").after('<span id="english_only_quantity_error" class="error">Choose a quantity.</span>');

				errorArray['englishRadioButtons'] = true;

			}

		}

		



		

		

			

		//This loops through the errorArray to check if any fields have errors

		for(value in errorArray) { 

			if(errorArray[value] == true) {

				hasError = true;	

			}

		}



		if(hasError == true) { //if there us an error, then don't let the submit button work

			return false; //this makes the submit button return false, meaning it won't do what it is supposed to do, making it disabled

		}

	}); //end click function for Language Options Form







//Validation for Card Details Page

	

	//Live functions

	$("#full_name").keyup(function(){

		$("#full_name_error").hide();

		var fullName = $("#full_name").val();

		if(fullName == '') {

			$("#full_name").after('<div id="full_name_error" class="error">Provide the full name as it should appear on the card.</div>');

		} 

	});

	

	$("#title").keyup(function(){

		$("#title_error").hide();

		var title = $("#title").val();

		if(title == '') {

			$("#title").after('<div id="title_error" class="error">Provide a job title.</div>');

		} 

	});

	

	/*$("#dept_div").keyup(function(){

		$("#dept_div_error").hide();

		var deptDiv = $("#dept_div").val();

		if(deptDiv == '') {

			$("#dept_div").after('<div id="dept_div_error" class="error">Provide a department and/or division.</div>');

		} 

	});*/

	

	$("#email").keyup(function(){ //hide the email language proof error if an email is entered

		$("#email_error_1").hide();

		$("#email_error_2").hide();

		var email = $("#email").val();

		if(email == '') {

			$("#email").after('<div id="email_error_1" class="error">The email is required.</div>');

		} /*
else if(!emailReg.test(email)) {

			$("#email").after('<div id="email_error_2" class="error">Enter a valid Email.</div>');

		}
*/

	});

	

	$("#mail_stop").keyup(function(){

		$("#mail_stop_integer_error").hide();

		$("#mail_stop_numbers_error").hide();

		var mailStop = $("#mail_stop").val();

		if(mailStop != '') {

			 if((mailStop.length < 4)) {

				$("#mail_stop").after('<div id="mail_stop_numbers_error" class="error">You need at least 4 characters in the Mail Stop.</div>');	

			}

		}

	});

	

	function phoneNumberCheck() {

		var phonePrefix = $("#phone_prefix").val();

		var phoneFirst = $("#phone_first").val();

		var phoneLast = $("#phone_last").val();

		if((phonePrefix == '') || (phoneFirst == '') || (phoneLast == '')) {

			$("#phone_last").after('<div id="phone_error" class="error">Provide a phone number.</div>');

		} else if((phonePrefix.length < 3) || (phoneFirst.length < 3) || (phoneLast.length < 4)) {

			$("#phone_last").after('<div id="phone_numbers_error" class="error">You are missing digits. Provide complete phone number.</div>');

		} else if((isNaN(phonePrefix) == true) || (isNaN(phoneFirst) == true) || (isNaN(phoneLast) == true)) { //if any of the digits are not integers, show an error

			$("#phone_last").after('<div id="phone_integer_error" class="error">Only integers are allowed.</div>');

		}

	}

	

	

	$("#phone_prefix").keyup(function(){

		$("#phone_error").hide();

		$("#phone_integer_error").hide();

		$("#phone_numbers_error").hide();

		phoneNumberCheck();

	});	

	

	$("#phone_first").keyup(function(){

		$("#phone_error").hide();

		$("#phone_integer_error").hide();

		$("#phone_numbers_error").hide();

		phoneNumberCheck();

	});	

	

	$("#phone_last").keyup(function(){

		$("#phone_error").hide();

		$("#phone_integer_error").hide();

		$("#phone_numbers_error").hide();

		phoneNumberCheck();

	});	

	

	

	

	function faxNumberCheck() {

		var faxPrefix = $("#fax_prefix").val();

		var faxFirst = $("#fax_first").val();

		var faxLast = $("#fax_last").val();

		

		function faxFunc() {

			if((faxPrefix.length > 0 && faxPrefix.length < 3) || (faxFirst.length > 0 && faxFirst.length < 3) || (faxLast.length > 0 && faxLast.length < 4)) {

				$("#fax_last").after('<div id="fax_numbers_error" class="error">You are missing digits. Provide complete fax number.</div>');

			}

		}

		

		faxFunc();

	}



	$("#fax_prefix").keyup(function(){

		$("#fax_integer_error").hide();

		$("#fax_numbers_error").hide();

		faxNumberCheck();

	});	

	

	$("#fax_first").keyup(function(){

		$("#fax_integer_error").hide();

		$("#fax_numbers_error").hide();

		faxNumberCheck();

	});	

	

	$("#fax_last").keyup(function(){

		$("#fax_integer_error").hide();

		$("#fax_numbers_error").hide();

		faxNumberCheck();

	});	

	

	

	//Validation for Additional Contacts

	function additionalTypeCheck(contactNumber) {

		$("#additional_contact_error" + contactNumber).hide();

		

		if($("#additional_contact" + contactNumber).is(":visible")) {

			if($("#additional_contact" + contactNumber).attr("selectedIndex") == 0) { //show an error message if no foreign language is chosen

				$("#additional_contact" + contactNumber).after('<div id="additional_contact_error' + contactNumber + '" class="error">Provide a contact type.</div>');

			}

		}

	} //end additionalTypeCheck function

	

	

	function additionalNumberCheck(contactNumber) {

		$("#additional_error" + contactNumber).hide();

		$("#additional_numbers_error" + contactNumber).hide();

		$("#additional_integer_error" + contactNumber).hide();

		

		if($("#additional_contact" + contactNumber).is(":visible")) {

			

			var additionalPrefix = $("#additional_prefix" + contactNumber).val();

			var additionalFirst = $("#additional_first" + contactNumber).val();

			var additionalLast = $("#additional_last" + contactNumber).val();



			if(additionalPrefix.length == 0 || additionalFirst.length == 0 || additionalLast.length == 0) {					

				$("#additional_last" + contactNumber).after('<div id="additional_error' + contactNumber + '" class="error">Provide a contact number.</div>');	

			} else if((additionalPrefix.length < 3) || (additionalFirst.length < 3) || (additionalLast.length < 4)) {

				$("#additional_last" + contactNumber).after('<div id="additional_numbers_error' + contactNumber + '" class="error">You are missing digits. Provide complete contact number.</div>');

			} else if((isNaN(additionalPrefix) == true) || (isNaN(additionalFirst) == true) || (isNaN(additionalLast) == true)) { //if any of the digits are not integers, show an error

				$("#additional_last" + contactNumber).after('<div id="additional_integer_error' + contactNumber + '" class="error">Only integers are allowed.</div>');

			}

		}

	}

	

	$("#additional_prefix1").keyup(function(){

		additionalNumberCheck('1');

	});	

	

	$("#additional_first1").keyup(function(){

		additionalNumberCheck('1');

	});	

	

	$("#additional_last1").keyup(function(){

		additionalNumberCheck('1');

	});	

	

	$("#additional_prefix2").keyup(function(){

		additionalNumberCheck('2');

	});	

	

	$("#additional_first2").keyup(function(){

		additionalNumberCheck('2');

	});	

	

	$("#additional_last2").keyup(function(){

		additionalNumberCheck('2');

	});



	

	//Checks if any of the contact types are the same

	function contactSameCheck() {

		var additionalContact1Value = $("#additional_contact1").val();

		var additionalContact2Value = $("#additional_contact2").val();

		

		$("#same_contact_error1").hide();

		$("#same_contact_error2").hide();	

		

		if(additionalContact1Value != '' && additionalContact2Value != '') { //If none of the fields being compared is empty, then

			if(additionalContact1Value == additionalContact2Value) { //Show error if two contact types are same

				$("#additional_contact1").after('<div id="same_contact_error1" class="error">You can not pick two of the same contact type.</div>');

				$("#additional_contact2").after('<div id="same_contact_error2" class="error">You can not pick two of the same contact type.</div>');	

			}

			

			if((additionalContact1Value == 'Mobile' && additionalContact2Value == 'Cell') || (additionalContact1Value == 'Cell' && additionalContact2Value == 'Mobile')) { //Show error if two contact types are same

				$("#additional_contact1").after('<div id="same_contact_error1" class="error">You can not pick both Cell and Mobile.</div>');

				$("#additional_contact2").after('<div id="same_contact_error2" class="error">You can not pick both Cell and Mobile.</div>');	

			}

		}

		

	} //end contactSameCheck function

	

	$("#additional_contact1").change(function(){

		contactSameCheck();

		additionalTypeCheck('1');

	});

	

	$("#additional_contact2").change(function(){

		contactSameCheck();

		additionalTypeCheck('2');

	});



	

    //Live Validation for Custom Address Fields

	$("#custom_address_1").keyup(function(){

		$("#custom_address_1_error").hide();

		var customAddress1 = $("#custom_address_1").val();

		if(customAddress1 == '') {

			$("#custom_address_1").after('<div id="custom_address_1_error" class="error">Provide the Address.</div>');

		}

	});

	

	$("#custom_city").keyup(function(){

		$("#custom_city_error").hide();

		var customCity = $("#custom_city").val();

		if(customCity == '') {

			$("#custom_city").after('<div id="custom_city_error" class="error">Provide the City.</div>');

		}

	});

	

	$("#custom_state").change(function(){

		$("#custom_state_error").hide();

		if($("#custom_state").attr("selectedIndex") == 0) { //show an error message if no foreign language is chosen

			$("#custom_state").after('<div id="custom_state_error" class="error">Provide the State.</div>');

		}

	});

	

	$("#custom_zip").keyup(function(){

		$("#custom_zip_error").hide();

		$("#custom_zip_integer_error").hide();

		$("#custom_zip_numbers_error").hide();

		var customZip = $("#custom_zip").val();

		if(customZip == '') {

			$("#custom_zip_2").after('<div id="custom_zip_error" class="error">Provide the Zip Code.</div>');

		} if(!numReg.test(customZip)) {

			$("#custom_zip_2").after('<div id="custom_zip_integer_error" class="error">Only whole numbers are allowed.</div>');

		} else if((customZip.length < 5)) {

			$("#custom_zip_2").after('<div id="custom_zip_numbers_error" class="error">You need 5 digits in the Zip Code.</div>');	

		}

	});

	

	$("#custom_zip_2").keyup(function(){

		$("#custom_zip_2_error").hide();

		var customZip2 = $("#custom_zip_2").val();

		if(customZip2 != '') {	

			if(!numReg.test(customZip2)) {

				$("#custom_zip_2").after('<div id="custom_zip_2_error" class="error">Only whole numbers are allowed.</div>');

			} else if((customZip2.length < 4)) {

				$("#custom_zip_2").after('<div id="custom_zip_2_error" class="error">You need 4 digits.</div>');	

			}

		}

	});

	

	function addressCheck(locator,errorName) {

		$("#no_address_error_1").hide();

		$("#no_address_error_2").hide();

		$("#no_address_error_3").hide();

		$("#both_address_error_1").hide();

		$("#both_address_error_2").hide();

		$("#both_address_error_3").hide();
		
		$("#address_warning").parent().css('background-color','transparent');  
		$("#address_warning").parent().parent().css('background-color','transparent');  
		
		$("#other_address_warning").parent().css('background-color','transparent');  
		$("#other_address_warning").parent().parent().css('background-color','transparent');  
		
		$("#no_address_warning").parent().css('background-color','transparent');  
		$("#no_address_warning").parent().parent().css('background-color','transparent');  
		

		if(($('#other_address').is(':checked') && $("#address").attr("selectedIndex") !== 0) || ($('#no_address').is(':checked') && $("#address").attr("selectedIndex") !== 0) || ($('#no_address').is(':checked') && $('#other_address').is(':checked'))  || ($('#other_address').is(':checked') && $("#address").attr("selectedIndex") !== 0) && $('#no_address').is(':checked')) { //if two address choices are picked, then show an error

			$(locator).after('<div id="' + errorName + '" class="error">You can only choose one of these options.</div>');
			
			$(locator).parent().css("background-color","#FFBCAF");
			$(locator).parent().parent().css("background-color","#FFBCAF");

			//$("#address_warning").after('<div id="both_address_error_1" class="error">You can only choose one of these options.</div>');

			//$("#other_address_warning").after('<div id="both_address_error_2" class="error">You can only choose one of these options.</div>');

			//$("#no_address_warning").after('<div id="both_address_error_3" class="error">You can only choose one of these options.</div>');

		}

	}

	

	$("#other_address").change(function(){

		addressCheck('#other_address_warning','both_address_error_1');

	});

	

	

	$("#no_address").change(function(){

		addressCheck('#no_address_warning','both_address_error_2');

	});

	

	

	$("#address").change(function(){

		addressCheck('#address_warning','both_address_error_3');
	});

	



	

	

	

	

	





	//Click function after user pushes the Submit button

	$("#card_submit").click(function() {

		

		var hasError = false;									

		$(".error").hide(); //hide all errors

		var errorArray = new Array(); //array to hold any error values

		

		var fullName = $("#full_name").val();

		if(fullName == '') {

			$("#full_name").after('<div id="full_name_error" class="error">Provide the full name as it should appear on the card.</div>');

			errorArray['fullName'] = true;

		} 

		

		var title = $("#title").val();

		if(title == '') {

			$("#title").after('<div id="title_error" class="error">Provide a job title.</div>');

			errorArray['title'] = true;

		} 

	

		/*var deptDiv = $("#dept_div").val();

		if(deptDiv == '') {

			$("#dept_div").after('<div id="dept_div_error" class="error">Provide a department and/or division.</div>');

			errorArray['deptDiv'] = true;

		} */	

		

		var email = $("#email").val();

		if(email == '') {

			$("#email").after('<div id="email_error_1" class="error">The email is required.</div>');

			errorArray['email'] = true;

		} /*
else if(!emailReg.test(email)) {

			$("#email").after('<div id="email_error_2" class="error">Enter a valid Email.</div>');

			errorArray['email'] = true;

		}
*/

		

		var mailStop = $("#mail_stop").val();

		if(mailStop != '') {

			 if((mailStop.length < 4)) {

				$("#mail_stop").after('<div id="mail_stop_numbers_error" class="error">You need at least 4 characters in the Mail Stop.</div>');

				errorArray['mailStop'] = true;

			}

		}

		



		function phoneNumberCheck() {

			var phonePrefix = $("#phone_prefix").val();

			var phoneFirst = $("#phone_first").val();

			var phoneLast = $("#phone_last").val();

			if((phonePrefix == '') || (phoneFirst == '') || (phoneLast == '')) {

				$("#phone_last").after('<div id="phone_error" class="error">Provide a phone number.</div>');

				errorArray['phoneError'] = true;

			} else if((phonePrefix.length < 3) || (phoneFirst.length < 3) || (phoneLast.length < 4)) {

				$("#phone_last").after('<div id="phone_numbers_error" class="error">You are missing digits. Provide complete phone number.</div>');

				errorArray['phoneError'] = true;

			} else if((isNaN(phonePrefix) == true) || (isNaN(phoneFirst) == true) || (isNaN(phoneLast) == true)) { //if any of the digits are not integers, show an error

				$("#phone_last").after('<div id="phone_integer_error" class="error">Only integers are allowed.</div>');

				errorArray['phoneError'] = true;

			}

		}

		

		function faxNumberCheck() {

			var faxPrefix = $("#fax_prefix").val();

			var faxFirst = $("#fax_first").val();

			var faxLast = $("#fax_last").val();

			

			if((faxPrefix.length > 0 && faxPrefix.length < 3) || (faxFirst.length > 0 && faxFirst.length < 3) || (faxLast.length > 0 && faxLast.length < 4)) {

				$("#fax_last").after('<div id="fax_numbers_error" class="error">You are missing digits. Provide complete fax number.</div>');

				errorArray['faxError'] = true;

			} else if((isNaN(faxPrefix) == true) || (isNaN(faxFirst) == true) || (isNaN(faxLast) == true)) { //if any of the digits are not integers, show an error

				$("#fax_last").after('<div id="fax_integer_error" class="error">Only integers are allowed.</div>');

				errorArray['faxError'] = true;

			}

		}

		

		phoneNumberCheck();

		faxNumberCheck();

		

		



		

		

		function additionalNumberCheck(contactNumber) {

			if($("#additional_contact" + contactNumber).is(":visible")) {

				if($("#additional_contact" + contactNumber).attr("selectedIndex") == 0) { //show an error message if no foreign language is chosen

					$("#additional_contact" + contactNumber).after('<div id="additional_contact_error' + contactNumber + '" class="error">Provide a contact type.</div>');

					errorArray['additionalContactType'] = true;

				}

				

	

				var additionalPrefix = $("#additional_prefix" + contactNumber).val();

				var additionalFirst = $("#additional_first" + contactNumber).val();

				var additionalLast = $("#additional_last" + contactNumber).val();

				//alert(additionalFirst.length + ' ' + additionalLast.length);

	

				if(additionalPrefix.length == 0 || additionalFirst.length == 0 || additionalLast.length == 0) {					

					$("#additional_last" + contactNumber).after('<div id="additional_error' + contactNumber + '" class="error">Provide a contact number.</div>');

					errorArray['additionalError'] = true;	

				} else if((additionalPrefix.length < 3) || (additionalFirst.length < 3) || (additionalLast.length < 4)) {

					$("#additional_last" + contactNumber).after('<div id="additional_numbers_error' + contactNumber + '" class="error">You are missing digits. Provide complete contact number.</div>');

					errorArray['additionalError'] = true;

				} else if((isNaN(additionalPrefix) == true) || (isNaN(additionalFirst) == true) || (isNaN(additionalLast) == true)) { //if any of the digits are not integers, show an error

					$("#additional_last" + contactNumber).after('<div id="additional_integer_error' + contactNumber + '" class="error">Only integers are allowed.</div>');

					errorArray['additionalError'] = true;

				}

			}

		}

		

		additionalNumberCheck('1');

		additionalNumberCheck('2');

		

		//This are checks if any of the contact types are the same

		var additionalContact1Value = $("#additional_contact1").val();

		var additionalContact2Value = $("#additional_contact2").val();

		

		if(additionalContact1Value != '' && additionalContact2Value != '') {

			if(additionalContact1Value == additionalContact2Value) { //Show error if two contact types are same

				$("#additional_contact1").after('<div id="same_contact_error1" class="error">You can not pick two of the same contact type.</div>');

				$("#additional_contact2").after('<div id="same_contact_error2" class="error">You can not pick two of the same contact type.</div>');

				errorArray['additionalTypeSame'] = true;	

			}

			

			if((additionalContact1Value == 'Mobile' && additionalContact2Value == 'Cell') || (additionalContact1Value == 'Cell' && additionalContact2Value == 'Mobile')) { //Show error if two contact types are same

				$("#additional_contact1").after('<div id="both_contact_error1" class="error">You can not pick both Cell and Mobile.</div>');

				$("#additional_contact2").after('<div id="both_contact_error2" class="error">You can not pick both Cell and Mobile.</div>');

				errorArray['additionalTypeMAndC'] = true;

			}

		}

		

		

		//validation for custom address area

		if($('#other_address').is(':checked')) {

			//Custom Address Area

			var customAddress1 = $("#custom_address_1").val();

			if(customAddress1 == '') {

				$("#custom_address_1").after('<div id="custom_address_1_error" class="error">Provide the Address.</div>');

				errorArray['customAddress1'] = true;

			}

			

			var customCity = $("#custom_city").val();

			if(customCity == '') {

				$("#custom_city").after('<div id="custom_city_error" class="error">Provide the City.</div>');

				errorArray['customCity'] = true;

			}

			

			if($("#custom_state").attr("selectedIndex") == 0) { //show an error message if no foreign language is chosen

				$("#custom_state").after('<div id="custom_state_error" class="error">Provide the State.</div>');

				errorArray['customState'] = true;

			}

			

			var customZip = $("#custom_zip").val();

			if(customZip == '') {

				$("#custom_zip_2").after('<div id="custom_zip_error" class="error">Provide the Zip Code.</div>');

				errorArray['customZip'] = true;

			} else if(!numReg.test(customZip)) {

				$("#custom_zip_2").after('<div id="custom_zip_integer_error" class="error">Only whole numbers are allowed.</div>');

				errorArray['customZip'] = true;

			} else if((customZip.length < 5)) {

				$("#custom_zip_2").after('<div id="custom_zip_numbers_error" class="error">You need 5 digits in the Zip Code.</div>');

				errorArray['customZip'] = true;

			}

			



			var customZip2 = $("#custom_zip_2").val();

			if(customZip2 != '') {	

				if(!numReg.test(customZip2)) {

					$("#custom_zip_2").after('<div id="custom_zip_2_error" class="error">Only whole numbers are allowed.</div>');

					errorArray['customZip2'] = true;

				} else if((customZip2.length < 4)) {

					$("#custom_zip_2").after('<div id="custom_zip_2_error" class="error">You need 4 digits.</div>');

					errorArray['customZip2'] = true;

				}

			}

			

		}		

		

		if(!$('#other_address').is(':checked') && $("#address").attr("selectedIndex") == 0 && !$('#no_address').is(':checked')) { //if neither an address or other address box is checked, then show an error

			$("#address_warning").after('<div id="no_address_error_1" class="error">You must choose one of these options.</div>');

			$("#other_address_warning").after('<div id="no_address_error_2" class="error">You must choose one of these options.</div>');

			$("#no_address_warning").after('<div id="no_address_error_3" class="error">You must choose one of these options.</div>');

			errorArray['noAddress'] = true;

		}

		

		if(($('#other_address').is(':checked') && $("#address").attr("selectedIndex") !== 0) || ($('#no_address').is(':checked') && $("#address").attr("selectedIndex") !== 0) || ($('#no_address').is(':checked') && $('#other_address').is(':checked')) || ($('#other_address').is(':checked') && $("#address").attr("selectedIndex") !== 0) && $('#no_address').is(':checked')) { //if both an address is picked or other address box is checked, then show an error

			$("#address_warning").after('<div id="both_address_error_1" class="error">You can only choose one of these options.</div>');

			$("#other_address_warning").after('<div id="both_address_error_2" class="error">You can only choose one of these options.</div>');

			$("#no_address_warning").after('<div id="both_address_error_3" class="error">You can only choose one of these options.</div>');

			errorArray['bothAddress'] = true;

		}

		

		

		

		

		



		//This loops through the errorArray to check if any fields have errors

		for(value in errorArray) { 

			//alert(value + ' : ' + errorArray[value]);

			if(errorArray[value] == true) {

				hasError = true;	



			}

		}



		if(hasError == true) { //if there us an error, then don't let the submit button work

			return false; //this makes the submit button return false, meaning it won't do what it is supposed to do, making it disabled

		}

	}); //end click function for Card Details Form

























//Validation for Non-US Card Details Page

	

	//Live functions

/*	$("#full_name").keyup(function(){

		$("#full_name_error").hide();

		var fullName = $("#full_name").val();

		if(fullName == '') {

			$("#full_name").after('<div id="full_name_error" class="error">Provide the full name as it should appear on the card.</div>');

		} 

	});

	

	$("#title").keyup(function(){

		$("#title_error").hide();

		var title = $("#title").val();

		if(title == '') {

			$("#title").after('<div id="title_error" class="error">Provide a job title.</div>');

		} 

	});

	

	$("#email").keyup(function(){ //hide the email error if an email is entered

		$("#email_error_1").hide();

		$("#email_error_2").hide();

		var email = $("#email").val();

		if(email == '') {

			$("#email").after('<div id="email_error_1" class="error">The email is required.</div>');

		} else if(!emailReg.test(email)) {

			$("#email").after('<div id="email_error_2" class="error">Enter a valid Email.</div>');

		}

	});*/

	

	function nonUsphoneNumberCheck() {

		var nonUsPhone = $("#non_us_phone").val();

		if(nonUsPhone == '') {

			$("#non_us_phone").after('<div id="non_us_phone_error" class="error">Provide a phone number.</div>');

		}

	}

	

	$("#non_us_phone").keyup(function(){

		$("#non_us_phone_error").hide();

		nonUsphoneNumberCheck();

	});	



	//Validation for Additional Contacts

	function nonUsadditionalTypeCheck(contactNumber) {

		$("#additional_non_us_contact_error" + contactNumber).hide();

		

		if($("#additional_non_us_contact" + contactNumber).is(":visible")) {

			if($("#additional_non_us_contact" + contactNumber).attr("selectedIndex") == 0) { //show an error message if no foreign language is chosen

				$("#additional_non_us_contact" + contactNumber).after('<div id="additional_non_us_contact_error' + contactNumber + '" class="error">Provide a contact type.</div>');

			}

		}

	} //end additionalTypeCheck function

	

	

	function nonUsadditionalNumberCheck(contactNumber) {

		$("#additional_non_us_error" + contactNumber).hide();

		

		if($("#additional_non_us_contact" + contactNumber).is(":visible")) {			

			var additionalnonUs = $("#additional_non_us" + contactNumber).val();

			if(additionalnonUs.length == 0) {					

				$("#additional_non_us" + contactNumber).after('<div id="additional_non_us_error' + contactNumber + '" class="error">Provide a contact number.</div>');	

			}

		}

	}

	

	$("#additional_non_us1").keyup(function(){

		nonUsadditionalNumberCheck('1');

	});	

	

	$("#additional_non_us2").keyup(function(){

		nonUsadditionalNumberCheck('2');

	});	

	





	

	//Checks if any of the contact types are the same

	function nonUscontactSameCheck() {

		var nonUsadditionalContact1Value = $("#additional_non_us_contact1").val();

		var nonUsadditionalContact2Value = $("#additional_non_us_contact2").val();

		

		$("#non_us_same_contact_error1").hide();

		$("#non_us_same_contact_error2").hide();	

		

		if(nonUsadditionalContact1Value != '' && nonUsadditionalContact2Value != '') { //If none of the fields being compared is empty, then

			if(nonUsadditionalContact1Value == nonUsadditionalContact2Value) { //Show error if two contact types are same

				$("#additional_non_us_contact1").after('<div id="non_us_same_contact_error1" class="error">You can not pick two of the same contact type.</div>');

				$("#additional_non_us_contact2").after('<div id="non_us_same_contact_error2" class="error">You can not pick two of the same contact type.</div>');	

			}

			

			if((nonUsadditionalContact1Value == 'Mobile' && nonUsadditionalContact2Value == 'Cell') || (nonUsadditionalContact1Value == 'Cell' && nonUsadditionalContact2Value == 'Mobile')) { //Show error if two contact types are same

				$("#additional_non_us_contact1").after('<div id="non_us_same_contact_error1" class="error">You can not pick both Cell and Mobile.</div>');

				$("#additional_non_us_contact2").after('<div id="non_us_same_contact_error2" class="error">You can not pick both Cell and Mobile.</div>');	

			}

		}

		

	} //end contactSameCheck function

	

	$("#additional_non_us_contact1").change(function(){

		nonUscontactSameCheck();

		nonUsadditionalTypeCheck('1');

	});

	

	$("#additional_non_us_contact2").change(function(){

		nonUscontactSameCheck();

		nonUsadditionalTypeCheck('2');

	});



	function nonUsaddressCheck() {

		$("#non_us_both_address_error_1").hide();

		$("#non_us_both_address_error_2").hide();

		

		var nonUsaddress1 = $("#non_us_address_1").val();

		

		if($('#non_us_no_address').is(':checked') && nonUsaddress1 != '') { //if two address choices are picked, then show an error

			$("#non_us_address_header").after('<div id="non_us_both_address_error_1" class="error">You can only choose one of these options.</div>');

			$("#no_address_warning").after('<div id="non_us_both_address_error_2" class="error">You can only choose one of these options.</div>');

		}

	}

	

	

    //Live Validation for Address Fields

	$("#non_us_address_1").keyup(function(){

		

		$("#non_us_address_error_1").hide();

		var nonUsaddress1 = $("#non_us_address_1").val();

		if(nonUsaddress1 == '' && !$('#non_us_no_address').is(':checked')) {

			$("#non_us_address_1").after('<div id="non_us_address_error_1" class="error">Provide the Address.</div>');

		}

		

		nonUsaddressCheck();

	});

	

	$("#non_us_address_2").keyup(function(){

		$("#non_us_address_error_2").hide();

		var nonUsaddress2 = $("#non_us_address_2").val();

		if(nonUsaddress2 == '' && !$('#non_us_no_address').is(':checked')) {

			$("#non_us_address_2").after('<div id="non_us_address_error_2" class="error">Provide the Address.</div>');

		}

		

		nonUsaddressCheck();

	});

	



	$("#non_us_no_address").change(function(){

		$("#non_us_address_error_1").hide();

		$("#non_us_address_error_2").hide();

											

		$("#non_us_no_address_error_1").hide();

		$("#non_us_no_address_error_2").hide();

		nonUsaddressCheck();

	});





	



	

	

	

	

	





	//Click function after user pushes the Submit button

	$("#non_us_card_submit").click(function() {

		

		var hasError = false;									

		$(".error").hide(); //hide all errors

		var errorArray = new Array(); //array to hold any error values

		

		var fullName = $("#full_name").val();

		if(fullName == '') {

			$("#full_name").after('<div id="full_name_error" class="error">Provide the full name as it should appear on the card.</div>');

			errorArray['fullName'] = true;

		} 

		

		var title = $("#title").val();

		if(title == '') {

			$("#title").after('<div id="title_error" class="error">Provide a job title.</div>');

			errorArray['title'] = true;

		} 	

		

		var email = $("#email").val();

		if(email == '') {

			$("#email").after('<div id="email_error_1" class="error">The email is required.</div>');

			errorArray['email'] = true;

		} /*
else if(!emailReg.test(email)) {

			$("#email").after('<div id="email_error_2" class="error">Enter a valid Email.</div>');

			errorArray['email'] = true;

		}
*/		



		var nonUsPhone = $("#non_us_phone").val();

		if(nonUsPhone == '') {

			$("#non_us_phone").after('<div id="non_us_phone_error" class="error">Provide a phone number.</div>');

			errorArray['phoneError'] = true;

		}





		function nonUsadditionalNumberCheck(contactNumber) {

			if($("#additional_non_us_contact" + contactNumber).is(":visible")) {

				if($("#additional_non_us_contact" + contactNumber).attr("selectedIndex") == 0) { //show an error message if no foreign language is chosen

					$("#additional_non_us_contact" + contactNumber).after('<div id="additional_non_us_contact_error' + contactNumber + '" class="error">Provide a contact type.</div>');

					errorArray['additionalError'] = true;

				}

			

				var additionalnonUs = $("#additional_non_us" + contactNumber).val();

				

				if(additionalnonUs.length == 0) {					

					$("#additional_non_us" + contactNumber).after('<div id="additional_non_us_error' + contactNumber + '" class="error">Provide a contact number.</div>');

					errorArray['additionalError'] = true;

				}

			}

		}

		

		nonUsadditionalNumberCheck('1');

		nonUsadditionalNumberCheck('2');

		



		

		//This are checks if any of the contact types are the same

		var nonUsadditionalContact1Value = $("#additional_non_us_contact1").val();

		var nonUsadditionalContact2Value = $("#additional_non_us_contact2").val();

		

		if(nonUsadditionalContact1Value != '' && nonUsadditionalContact2Value != '') {			

			if(nonUsadditionalContact1Value == nonUsadditionalContact2Value) { //Show error if two contact types are same

				$("#additional_non_us_contact1").after('<div id="non_us_same_contact_error1" class="error">You can not pick two of the same contact type.</div>');

				$("#additional_non_us_contact2").after('<div id="non_us_same_contact_error2" class="error">You can not pick two of the same contact type.</div>');

				errorArray['additionalTypeSame'] = true;

			}

			

			if((nonUsadditionalContact1Value == 'Mobile' && nonUsadditionalContact2Value == 'Cell') || (nonUsadditionalContact1Value == 'Cell' && nonUsadditionalContact2Value == 'Mobile')) { //Show error if two contact types are same

				$("#additional_non_us_contact1").after('<div id="non_us_same_contact_error1" class="error">You can not pick both Cell and Mobile.</div>');

				$("#additional_non_us_contact2").after('<div id="non_us_same_contact_error2" class="error">You can not pick both Cell and Mobile.</div>');

				errorArray['additionalTypeMAndC'] = true;

			}

		}

		

		//validation for custom address area

		if(!$('#non_us_no_address').is(':checked')) {

			//Non-USAddress Area

			var nonUsaddress1 = $("#non_us_address_1").val();

			if(nonUsaddress1 == '') {

				$("#non_us_address_1").after('<div id="non_us_address_error_1" class="error">Provide the Address.</div>');

				errorArray['nonUSAddress1'] = true;

			}

			

			var nonUsaddress2 = $("#non_us_address_2").val();

			if(nonUsaddress2 == '') {

				$("#non_us_address_2").after('<div id="non_us_address_error_2" class="error">Provide the Address.</div>');

				errorArray['nonUSAddress1'] = true;

			}	

		}	

		

		

		if(!$('#non_us_no_address').is(':checked') && nonUsaddress1 == '') { //if neither an address or other address box is checked, then show an error

			$("#non_us_address_header").after('<div id="non_us_no_address_error_1" class="error">You must choose one of these options.</div>');

			$("#no_address_warning").after('<div id="non_us_no_address_error_2" class="error">You must choose one of these options.</div>');

			errorArray['noAddress'] = true;

		}

		

		

		var nonUsaddress1 = $("#non_us_address_1").val();

		

		if($('#non_us_no_address').is(':checked') && nonUsaddress1 != '') { //if two address choices are picked, then show an error

			$("#non_us_address_header").after('<div id="non_us_both_address_error_1" class="error">You can only choose one of these options.</div>');

			$("#no_address_warning").after('<div id="non_us_both_address_error_2" class="error">You can only choose one of these options.</div>');

			errorArray['bothAddress'] = true;

		}

		





		//This loops through the errorArray to check if any fields have errors

		for(value in errorArray) { 

			//alert(value + ' : ' + errorArray[value]);

			if(errorArray[value] == true) {

				hasError = true;	



			}

		}



		if(hasError == true) { //if there us an error, then don't let the submit button work

			return false; //this makes the submit button return false, meaning it won't do what it is supposed to do, making it disabled

		}

	}); //end click function for non-US Card Details Form





























//Validation for Shipping Options Page





	//Live functions

	/*$("input[name='english_only']").mousedown(function(){	//hide the english quantity error if an english quantity is chosen									

			$("#english_only_quantity_error").hide();

	});



	



	$("#email_language_proof").keyup(function(){ //hide the email language proof error if an email is entered

		$("#email_language_error_1").hide();

		$("#email_language_error_2").hide();

		if($('#foreign_checkbox').is(':checked')) {

			var emailLanguageProof = $("#email_language_proof").val();

			if(emailLanguageProof == '') {

				$("#email_language_proof").after('<div id="email_language_error_1" class="error">You must provide an email to send the language proof to.</div>');

			} else if(!emailReg.test(emailLanguageProof)) {

				$("#email_language_proof").after('<div id="email_language_error_2" class="error">Enter a valid Email.</div>');

			}

		}

	});*/

	







	//Click function after user pushes the Submit button

	$("#shipping_submit").click(function() {

		var hasError = false;

		$(".error").hide(); //hide all errors

		var errorArray = new Array();

		

		var englishShippingvalue = $('input:radio[name=shipping_time_english]:checked').val();

		if((englishShippingvalue == '1-3 work days') || (englishShippingvalue == '4-8 work days')) { //if the shipping_time_english radiobuttons is checked, then there must something in the english rush needed by box

			var rushNeededByEnglish = $("#rush_needed_by_english").val();

			if(rushNeededByEnglish == '') {

				$("#english_rush_warning").after('<div id="english_rush_error" class="error">Specify a rush date.</div>');

				errorArray['rushNeededByEnglish'] = true;

			}

		}

		

		var foreignShippingvalue = $('input:radio[name=shipping_time_foreign]:checked').val();

		if((foreignShippingvalue == '1-3 work days') || (foreignShippingvalue == '4-8 work days')) { //if the shipping_time_foreign radiobuttons is checked, then there must something in the foreign rush needed by box

			var rushNeededByForeign = $("#rush_needed_by_foreign").val();

			if(rushNeededByForeign == '') {

				$("#foreign_rush_warning").after('<div id="foreign_rush_error" class="error">Specify a rush date.</div>');

				errorArray['rushNeededByForeign'] = true;

			}

		}

		

		var notepads425x55Shippingvalue = $('input:radio[name=shipping_time_425x55]:checked').val();

		if((notepads425x55Shippingvalue == '1-3 work days') || (notepads425x55Shippingvalue == '4-8 work days')) { //if the shipping_time_425x55 radiobuttons is checked, then there must something in the 425x55 rush needed by box

			var rushNeededBy425x55 = $("#rush_needed_by_425x55").val();

			if(rushNeededBy425x55 == '') {

				$("#425x55_rush_warning").after('<div id="rush_error_425x55" class="error">Specify a rush date.</div>');

				errorArray['rushNeededBy425x55'] = true;

			}

		}

		

		var notepads55x85Shippingvalue = $('input:radio[name=shipping_time_55x85]:checked').val();

		if((notepads55x85Shippingvalue == '1-3 work days') || (notepads55x85Shippingvalue == '4-8 work days')) { //if the shipping_time_55x85 radiobuttons is checked, then there must something in the 55x85 rush needed by box

			var rushNeededBy55x85 = $("#rush_needed_by_55x85").val();

			if(rushNeededBy55x85 == '') {

				$("#55x85_rush_warning").after('<div id="rush_error_55x85" class="error">Specify a rush date.</div>');

				errorArray['rushNeededBy55x85'] = true;

			}

		}

		

		

		/*if(!$('#foreign_checkbox').is(':checked') && !$('#english_only_checkbox').is(':checked')) { //if neither box is checked, then an error shows up

			$("#english_only_checkbox_text").after('<span id="english_only_checkbox_error" class="error">You must choose at least one of these options.</span>');

			$("#foreign_checkbox_tooltip").after('<span id="foreign_checkbox_error" class="error">You must choose at least one of these options.</span>');

			errorArray['neitherChecked'] = true;

		}

			

		if($('#english_only_checkbox').is(':checked')) {

			var englishRadioButtons = $("input[name='english_only']");

			if(englishRadioButtons.filter(':checked').length == 0) { //show an error message if no english language quantity is chosen

				$("#english_only_label").after('<span id="english_only_quantity_error" class="error">Choose a quantity.</span>');

				errorArray['englishRadioButtons'] = true;

			}

		}*/

		



		

		

			

		//This loops through the errorArray to check if any fields have errors

		for(value in errorArray) { 

			if(errorArray[value] == true) {

				hasError = true;	

			}

		}



		if(hasError == true) { //if there us an error, then don't let the submit button work

			return false; //this makes the submit button return false, meaning it won't do what it is supposed to do, making it disabled

		}

	}); //end click function for Shipping Options Form



}); //end document ready