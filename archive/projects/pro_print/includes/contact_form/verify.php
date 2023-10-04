<?php
if(isset($_POST['submitted'])) { //if the form was submitted, which is marked by the hidden field on the form, then run the validation
	
	if($_POST['name'] == '') {
		$nameError = 'You forgot to enter your name.';
	}
	
	if($_POST['email'] == '') {
		$emailError = 'You forgot to enter the email address to send from.';
	} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", $_POST['email'])) {
		$emailError = 'Enter a valid email address to send from.';
	}
	
	if($_POST['subject'] == '') {
		$subjectError = 'You forgot to enter the subject.';
	}
	
	if($_POST['mainmessage'] == '') {
		$mainmessageError = 'You forgot to enter the message.';
	}

	if(!isset($emailError) && !isset($subjectError) && !isset($mainmessageError)) {
		include('sendemail.php');
		include('thanks.php');
	}
}

?>