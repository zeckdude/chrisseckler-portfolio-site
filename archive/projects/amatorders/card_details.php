<?php

session_start();

ob_start();



/*

if($_SESSION['contact']) {

	for($counter = 1; $counter <= 2; $counter++) {

		foreach($_SESSION['contact'][$counter] as $key => $value) { 

				echo 'Group: ' . $counter;

				echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

		} 

		echo '<br/><br/><br/>';

	}

}



if($_SESSION['contact']) {

	foreach ($_SESSION['contact'] as $counter => $contact_array) { //This specifies the $_SESSION['order'] array to loop through 

		echo '<br />';

		echo $counter;

		echo '<br />';

		foreach ($contact_array as $key => $value) { //This specifies the array within the $_SESSION['order'] array

			echo $key . ': ' . $value;

			echo '<br />';

			$_SESSION['extra_number'][$counter][$key] = $value;

			//$extra_number[$counter][$key] = $value;

			//echo $_SESSION['extra_number'][$counter]['additional_contact']; 

		} //end foreach

		echo '<br />';

	} //end of outer foreach loop

}





foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop

	//if($value != '') {

		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

	//}

} */



$_SESSION['ordering_mode'] = 'on';



//This code ensures that you have been to this page or page before it, so you can't manually type in the url without being redirected

if(!isset($_SESSION['ordering_step']) || $_SESSION['ordering_step'] < 3) {//if the ordering step has not been created or is less than the current page ordering step, because someone manually typed it in without having been to the index page

	header('Location: index.php');

}





/*if (isset($_POST['jstest'])) {

  $_SESSION['js_enabled'] = 'yes';

  $nojs = FALSE;

  } else {

  // create a hidden form and submit it with javascript

  echo '<form name="jsform" id="jsform" method="post" style="display:none">';

  echo '<input name="jstest" type="text" value="true" />';

  echo '<script language="javascript">';

  echo 'document.jsform.submit();';

  echo '</script>';

  echo '</form>';

  // the variable below would be set only if the form wasn't submitted, hence JS is disabled

  $_SESSION['js_enabled'] = 'no';

  $nojs = TRUE;

}



if ($nojs){

  echo 'Javascript is enabled';

}*/









unset($_SESSION['contact'][1]['additional_non_us_number']);

unset($_SESSION['contact'][2]['additional_non_us_number']);



















?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Order Form - Card Details</title>

<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="shortcut icon" href="images/favicon.gif" />

<!--//////////  FOR USERS WITH INTERNET EXPLORER 6  //////////-->
<!--[if IE 6]>
        <link rel="stylesheet" type="text/css" href="css/ie6.css" />
<![endif]-->

<style type="text/css">
* { behavior: url(css/iepngfix.htc) }
</style> 
<!--//////////  FOR USERS WITH INTERNET EXPLORER 6  //////////-->



<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>

<script src="js/validation.js" type="text/javascript"></script>

<script src="js/jquery.autotab.js" type="text/javascript"></script> 



<script>

      $(document).ready(function(){

		

								 

		//This brings back all elements for browsers with javaScript enabled

		$(".hidden-nojs").show();

		$("#js_warning").hide();	

		

		//Code for additional contact fields

		$("#additional_content_1").hide();

		$("#additional_content_2").hide();

		$("#additional_title_row").hide();

		$("#additional_contact_row").hide();

		

		if($("#additional_prefix1").val() != '') {

			$("#additional_content_1").show();

			$("#additional_title_row").show();

			$("#additional_contact_row").show();

		}

		

		if($("#additional_prefix2").val() != '') {

			$("#additional_content_2").show();

			$("#additional_title_row").show();

			$("#additional_contact_row").show();

		}

		

		$('#additional_contact').click(function() {		

			if($("#additional_content_1").is(":hidden")) {

				$("#additional_content_1").show();

				$("#additional_title_row").show();

				$("#additional_contact_row").show();

			} else if($("#additional_content_2").is(":hidden")) {

				$("#additional_content_2").show();

			}

		}); //end click function

		

		$('.remove_number').click(function() { //Function when user clicks a remove button

			$(this).parent().hide(); //removes the area

			$(this).siblings().children().children().val('');

	

			$(this).siblings().find('div.error').remove();

			

			if($("#additional_content_1").is(":hidden")) {

				if($("#additional_content_2").is(":hidden")) {

					$("#additional_title_row").hide();

					$("#additional_contact_row").hide();

				}

			}

		});

		

		//This clears the value of the Additional Contact Fields if one of the fields doesn't contain a value

		if($("#additional_contact1").val() != '') {

			if($("#additional_prefix1").val() == '') {

				$("#additional_contact1").val('');

			}

		}

		

		if($("#additional_contact2").val() != '') {

			if($("#additional_prefix2").val() == '') {

				$("#additional_contact2").val('');

			}

		}

		

		

		

		

		

		//Code for Custom address Fields

		$("#custom_address_row").hide();

		$("#other_address").click(function(){

			$("#custom_address_row").toggle();
			//alert('Handler for .change() called.');
		});

		

		

		$('input[type="text"]').focus(function() //highlights all text inside of input fields when you click on them

		 {

			$(this).select();	

		 });

		

		//Automated tabbing in number fields

		function numberAutoTab(contactType, additionalNumber) {

			<?php if($_SESSION['foreign_cards_ordered'] == 'yes') { ?>

				//$('#' + contactType + '_int_prefix' + additionalNumber).autotab({ target: contactType + '_prefix' + additionalNumber, format: 'numeric' });

			<?php } ?>

			

			$('#' + contactType + '_prefix' + additionalNumber).autotab({ target: contactType + '_first' + additionalNumber, format: 'numeric' });

			$('#' + contactType + '_first' + additionalNumber).autotab({ target: contactType + '_last' + additionalNumber, format: 'numeric', previous: contactType + '_prefix' + additionalNumber });

			$('#' + contactType + '_last' + additionalNumber).autotab({ previous: contactType + '_first' + additionalNumber, format: 'numeric' });

		}

		

		numberAutoTab('phone','');

		numberAutoTab('fax','');

		numberAutoTab('additional','1');

		numberAutoTab('additional','2');

		numberAutoTab('additional','3');

		

		

		

    }); //end document ready

    

    //Code to make Enter Button Inactive

    function stopRKey(evt) { //disables enter key to submit form

      var evt = (evt) ? evt : ((event) ? event : null);

      var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);

      if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}

    }

    document.onkeypress = stopRKey; 

</script>





<?php

if($_SESSION['other_address'] == 'yes') {

?>

	<script>

        $(document).ready(function(){

            //Code for Custom address Fields

            $("#custom_address_row").show();

        }); //end document ready

    </script>

<?php

}

?>



</head>











<body>



<?php 



// echo 'Current Employee ID: ' . $_SESSION['employee_id'];



include("includes/connection.php");



$conn = dbConnect("query");





if(!$_SESSION['page_has_been_saved']) { //only grab these session variables if someone has not clicked the next step button on this page during this session

	$sql = "SELECT *

			FROM orders

			WHERE employee_id='".$_SESSION['employee_id']."'

			ORDER by order_id DESC";

				

		$result = $conn->query($sql) or die(mysqli_error());

	  

		if($row = $result->fetch_assoc()){			

			$_SESSION["last_order_id"] = $row["order_id"];

			$_SESSION["full_name"] = $row["full_name"];

			$_SESSION["title"] = $row["title"];

			$_SESSION["title_2"] = $row["title_2"];

			$_SESSION["dept_div"] = $row["dept_div"];

			$_SESSION["dept_div_2"] = $row["dept_div_2"];

			$_SESSION["phone_symbol"] = $row["phone_symbol"];

			$_SESSION["phone_int_prefix"] = $row["phone_int_prefix"];

			$_SESSION["phone_prefix"] = $row["phone_prefix"];

			$_SESSION["phone_first"] = $row["phone_first"];

			$_SESSION["phone_last"] = $row["phone_last"];

			$_SESSION["fax_int_prefix"] = $row["fax_int_prefix"];

			$_SESSION["fax_prefix"] = $row["fax_prefix"];

			$_SESSION["fax_first"] = $row["fax_first"];

			$_SESSION["fax_last"] = $row["fax_last"];

			$_SESSION["email"] = $row["email"];

			$_SESSION["mail_stop"] = $row["mail_stop"];

			$_SESSION["address"] = $row["building_id"];

			

			

			$_SESSION["no_address"] = $row["no_address"];

			$_SESSION["other_address"] = $row["other_address"];

			

		}

		

		$sql = "SELECT *

				FROM custom_addresses

				WHERE order_id='".$_SESSION['last_order_id']."'";

				

		$result = $conn->query($sql) or die(mysqli_error());

	  

		if($row = $result->fetch_assoc()){

			$_SESSION["custom_address_1"] = $row["line_1"];

			$_SESSION["custom_address_2"] = $row["line_2"];

			$_SESSION["custom_city"] = $row["city"];

			$_SESSION["custom_state"] = $row["state"];

			$_SESSION["custom_zip"] = $row["zip_1"];

			$_SESSION["custom_zip_2"] = $row["zip_2"];

		}

		

		

		$counter = 1;

		$sql = "SELECT *

				FROM contact_numbers

				WHERE order_id = '" . $_SESSION['last_order_id'] . "'";	

		

		$result = $conn->query($sql) or die(mysqli_error());

		while($row = $result->fetch_assoc()) {

				$_SESSION['contact'][$counter]['additional_contact'] = $row['contact_type'];

				$_SESSION['contact'][$counter]['additional_int_prefix'] = $row['int_prefix'];

				$_SESSION['contact'][$counter]['additional_prefix'] = $row['prefix'];

				$_SESSION['contact'][$counter]['additional_first'] = $row['first'];

				$_SESSION['contact'][$counter]['additional_last'] = $row['last'];

				$counter++;

		}	

}























$done = false;

//$_SESSION['js_enabled'] = 'yes';







if(isset($_POST['card_prev'])){ 

    

    //Card Details

	$_SESSION["full_name"] = $_POST['full_name'];



	/*//Series of functions to separate the full name into separate first name, last name, and professional title

	$comma_pos = strpos($_POST['full_name'], ','); //Finds the first occurrence of a comma within the full name

	

	if(!$comma_pos) { //If there is no comma then just separate the First and Last Name into variables

		$first_space_pos = strpos($_POST['full_name'], ' '); //This is the first occurrence of a space within the full name

		$last_space_pos = strrpos($_POST['full_name'], ' '); //This is the last occurrence of a space within the full name

		$first_name = substr($_POST['full_name'], 0, $first_space_pos); //This is the first name	

		$middle_space_pos = strlen($first_name); //This is the occurrence of the space between the first and last name	

		$last_name = substr($_POST['full_name'], $middle_space_pos+1); //This is the last name

		

	} else{ //If there is a comma then divide the First, Last, and Professional Title into separate variables

		$first_last_name = substr($_POST['full_name'], 0, $comma_pos); //This is the first and last name together

		$pro_title = substr($_POST['full_name'], $comma_pos+1); //This is the professional title

		$last_space_pos = strrpos($first_last_name, ' '); //This is the last occurrence of a space within the first and last name

		$first_name = substr($first_last_name, 0, $last_space_pos); //This is the first name

		$last_name = substr($first_last_name, $last_space_pos+1); //This is the last name
	}*/
	
	
	
	$_POST['full_name'] = trim($_POST['full_name']); //trim the whitespace off the beginning and end
	$comma_pos = strpos($_POST['full_name'], ','); //Finds the first occurrence of a comma within the full name

	//Series of functions to separate the full name into separate first name, last name, and professional title
	if($comma_pos) { //If there is a comma in the name then remove the contents after the comma and save the rest as the full name	
		$first_last_name = substr($_POST['full_name'], 0, $comma_pos); //This is the first and last name together
		$pro_title = substr($_POST['full_name'], $comma_pos+1); //This is the professional title
	} else if(!$comma_pos) { //If there is no comma then just use the full name as the name
		$first_last_name = $_POST['full_name'];
	}
	
	$num_spaces = substr_count($first_last_name, ' '); //Number of Spaces in Name before a comma if applicable
	
	$first_space_pos = strpos($first_last_name, ' '); //This is the first occurrence of a space within the full name
	
	$last_space_pos = strrpos($first_last_name, ' '); //This is the last occurrence of a space within the full name
	
	$first_name = substr($first_last_name, 0, $first_space_pos); //This is the first name
	
	$middle_and_last_name = substr($first_last_name, $first_space_pos+1, strlen($first_last_name));
	
	$middle_space_pos = strpos($middle_and_last_name, ' '); //Finds the next occurence of a space 
	
	$middle_last_name_last_space_pos = strrpos($middle_and_last_name, ' '); //This is the last occurrence of a space within the Middle and Last Name
	
	$middle_name = substr($middle_and_last_name, 0, $middle_last_name_last_space_pos);
	
	$last_name = substr($first_last_name, $last_space_pos+1); //This is the last name





    $_SESSION["first_name"] = $first_name . ' ' . $middle_name;

    $_SESSION["last_name"] = $last_name;
	
	



    $_SESSION["title"] = $_POST['title'];

    $_SESSION["title_2"] = $_POST['title_2'];

    $_SESSION["dept_div"] = $_POST['dept_div'];

    $_SESSION["dept_div_2"] = $_POST['dept_div_2'];

	$_SESSION["phone_symbol"] = $_POST['phone_symbol'];

	$_SESSION["phone_int_prefix"] = $_POST['phone_int_prefix'];

    $_SESSION["phone_prefix"] = $_POST['phone_prefix'];

    $_SESSION["phone_first"] = $_POST['phone_first'];

    $_SESSION["phone_last"] = $_POST['phone_last'];

	$_SESSION["fax_int_prefix"] = $_POST['fax_int_prefix'];

    $_SESSION["fax_prefix"] = $_POST['fax_prefix'];

    $_SESSION["fax_first"] = $_POST['fax_first'];

    $_SESSION["fax_last"] = $_POST['fax_last'];

    $_SESSION["other_number"] = $_POST['other_number'];

    $_SESSION["email"] = $_POST['email'];

    $_SESSION["address"] = $_POST['address'];

    $_SESSION["mail_stop"] = $_POST['mail_stop'];

	

	if($_POST['other_address']) {

		$_SESSION["other_address"] = 'yes';

	} else {

		$_SESSION["other_address"] = 'no';

	}

	

	if($_POST['no_address']) {

		$_SESSION["no_address"] = 'yes';

	} else {

		$_SESSION["no_address"] = 'no';

	}

	

	$_SESSION["page_has_been_saved"] = 'yes';

	

	if(isset($_POST['other_address'])) {

		$_SESSION["custom_address_1"] = $_POST['custom_address_1'];

		$_SESSION["custom_address_2"] = $_POST['custom_address_2'];

		$_SESSION["custom_city"] = $_POST['custom_city'];

		$_SESSION["custom_state"] = $_POST['custom_state'];

		$_SESSION["custom_zip"] = $_POST['custom_zip'];

		$_SESSION["custom_zip_2"] = $_POST['custom_zip_2'];

	}

	

	

	









	//Any extra contact numbers

	$counter = 1;

	$additional_contact_exists = array();

	

	for($counter = 1; $counter <= 2; $counter++) {

		if($_POST['additional_contact' . $counter] != '') {

			$_SESSION['contact'][$counter]['additional_contact'] = $_POST['additional_contact' . $counter];

			$_SESSION['contact'][$counter]['additional_int_prefix'] = $_POST['additional_int_prefix' . $counter]; //This saves the information for a new contact number into a multidimensional array

			$_SESSION['contact'][$counter]['additional_prefix'] = $_POST['additional_prefix' . $counter];

			$_SESSION['contact'][$counter]['additional_first'] = $_POST['additional_first' . $counter];

			$_SESSION['contact'][$counter]['additional_last'] = $_POST['additional_last' . $counter];

			$additional_contact_exists[$counter] = 'yes';

		} else {

			unset($_SESSION['contact'][$counter]['additional_contact']);

			unset($_SESSION['contact'][$counter]['additional_int_prefix']);

			unset($_SESSION['contact'][$counter]['additional_prefix']);

			unset($_SESSION['contact'][$counter]['additional_first']);

			unset($_SESSION['contact'][$counter]['additional_last']);

			$_SESSION['contact'][$counter] = NULL;



			$additional_contact_exists[$counter] = 'no';

		}

	}



	if(in_array('yes', $additional_contact_exists)) {

			$_SESSION['additional_contact_exists'] = 'yes';

		} else {

			$_SESSION['additional_contact_exists'] = 'no';

		}

    

    header('Location: choose_location.php');

    

        exit;

}









if(isset($_POST['card_next'])){ 





	$has_error = false;

	$error_array = array();

	$email_reg_expr = '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$';

	

	//Function to check whether a string is an integer

	function isint( $mixed )

	{

		return ( preg_match( '/^\d*$/'  , $mixed) == 1 );

	}





	//PHP Validation

	if($_POST['full_name'] == '') {

		$full_name_error = '<div id="full_name_error" class="error">Provide the full name as it should appear on the card.</div>';

		$error_array['full_name_error'] = true;

	}

	

	if($_POST['title'] == '') {

		$title_error = '<div id="title_error" class="error">Provide a job title.</div>';

		$error_array['title_error'] = true;

	}

	

	if($_POST['email'] == '') {

		$email_error = '<div id="email_error_1" class="error">The email is required.</div>';

		$error_array['$email_error_1'] = true;

	} /*
else if(!eregi($email_reg_expr, $_POST['email'])) {

		$email_error = '<div id="email_error_2" class="error">Enter a valid Email.</div>';

		$error_array['email_error_2'] = true;

	}
*/

	

	if($_POST['mail_stop'] != '') {

		 if (strlen($_POST['mail_stop']) < 4) {

			$mail_stop_error = '<div id="mail_stop_numbers_error" class="error">You need at least 4 characters in the Mail Stop.</div>';

			$error_array['mail_stop_error'] = true;	

		}

	}


	if($_POST['phone_prefix'] != '') {
		if($_POST['phone_symbol'] == '') {
	
			$phone_symbol_error = '<div id="phone_symbol_error" class="error">Select a phone symbol.</div>';
	
			$error_array['phone_symbol_error'] = true;
	
		}
	}
	

	/*
if(($_POST['phone_prefix'] == '') || ($_POST['phone_first'] == '') || ($_POST['phone_last'] == '')) {

		$phone_error = '<div id="phone_error" class="error">Provide a phone number.</div>';

		$error_array['phone_error'] = true;

	} else if (strlen($_POST['phone_prefix']) < 3 || (strlen($_POST['phone_first']) < 3) || (strlen($_POST['phone_last']) < 4)) {

		$phone_error = '<div id="phone_numbers_error" class="error">You are missing digits. Provide complete phone number.</div>';

		$error_array['phone_error'] = true;	

	} else if((!isint($_POST['phone_prefix'])) || (!isint($_POST['phone_first'])) || (!isint($_POST['phone_last']))) {

		$phone_error = '<div id="phone_integer_error" class="error">Only integers are allowed.</div>';

		$error_array['phone_error'] = true;

	}
*/

	

	if(($_POST['fax_prefix'] != '') || ($_POST['fax_first'] != '') || ($_POST['fax_last'] != '')) {

		if (strlen($_POST['fax_prefix']) < 3 || (strlen($_POST['fax_first']) < 3) || (strlen($_POST['fax_last']) < 4)) {

			$fax_error = '<div id="fax_numbers_error" class="error">You are missing digits. Provide complete fax number.</div>';

			$error_array['fax_error'] = true;	

		} else if((!isint($_POST['fax_prefix'])) || (!isint($_POST['fax_first'])) || (!isint($_POST['fax_last']))) {

			$fax_error = '<div id="fax_integer_error" class="error">Only integers are allowed.</div>';

			$error_array['fax_error'] = true;

		}

	}

	

	if($_POST['additional_contact1'] != '') {

		if(($_POST['additional_prefix1'] == '') || ($_POST['additional_first1'] == '') || ($_POST['additional_last1'] == '')) {

			$additional_error_1 = '<div id="additional_error1" class="error">Provide a contact number.</div>';

			$error_array['additional_error_1'] = true;	

		} else if (strlen($_POST['additional_prefix1']) < 3 || (strlen($_POST['additional_first1']) < 3) || (strlen($_POST['additional_last1']) < 4)) {

			$additional_error_1 = '<div id="additional_error1" class="error">Provide a contact number.</div>';

			$error_array['additional_error_1'] = true;	

		} else if((!isint($_POST['additional_prefix1'])) || (!isint($_POST['additional_first1'])) || (!isint($_POST['additional_last1']))) {

			$additional_error_1 = '<div id="additional_integer_error1" class="error">Only integers are allowed.</div>';

			$error_array['additional_error_1'] = true;

		}

	}

	

	if($_POST['additional_contact2'] != '') {

		if(($_POST['additional_prefix2'] == '') || ($_POST['additional_first2'] == '') || ($_POST['additional_last2'] == '')) {

			$additional_error_2 = '<div id="additional_error2" class="error">Provide a contact number.</div>';

			$error_array['additional_error_2'] = true;	

		} else if (strlen($_POST['additional_prefix2']) < 3 || (strlen($_POST['additional_first2']) < 3) || (strlen($_POST['additional_last2']) < 4)) {

			$additional_error_2 = '<div id="additional_error2" class="error">Provide a contact number.</div>';

			$error_array['additional_error_2'] = true;	

		} else if((!isint($_POST['additional_prefix2'])) || (!isint($_POST['additional_first2'])) || (!isint($_POST['additional_last2']))) {

			$additional_error_2 = '<div id="additional_integer_error2" class="error">Only integers are allowed.</div>';

			$error_array['additional_error_2'] = true;

		}

	}

	

	if(($_POST['additional_contact1'] != '') || ($_POST['additional_contact2'] != '')) {

		if($_POST['additional_contact1'] == $_POST['additional_contact2']) {

			$same_contact = '<div id="same_contact_error1" class="error">You can not pick two of the same contact type.</div>';

			$error_array['additional_type_same'] = true;

		}

		

		if(($_POST['additional_contact1'] == 'Mobile' && $_POST['additional_contact2'] == 'Cell') || ($_POST['additional_contact1'] == 'Cell' && $_POST['additional_contact2'] == 'Mobile')) {

			$both_contact = '<div id="both_contact_error1" class="error">You can not pick both Cell and Mobile.</div>';

			$error_array['additional_type_both'] = true;

		}

	}

	

	if(($_POST['address'] == 0) && ($_POST['no_address'] != 'on') && ($_POST['other_address'] != 'on')) { //if none of the address options are picked, then show an error

		$no_address_error = '<div id="no_address_error_1" class="error">You must choose one of these options.</div>';

		$error_array['no_address'] = true;	

	}

	

	if(($_POST['other_address'] == 'on' && $_POST['address'] != 0) || ($_POST['no_address'] == 'on' && $_POST['address'] != 0) || ($_POST['no_address'] == 'on' && $_POST['other_address'] == 'on') || ($_POST['other_address'] == 'on' && $_POST['address'] != 0) || ($_POST['other_address'] == 'on' && $_POST['no_address'] == 'on' && $_POST['address'] != 0)) {

		$both_address_error = '<div id="both_address_error_1" class="error">You can only choose one of these options.</div>';

		$error_array['both_address'] = true;		

	}

	

	if($_POST['other_address'] == 'on') {

		if($_POST['custom_address_1'] == '') {

			$custom_address_error = '<div id="custom_address_1_error" class="error">Provide the Address.</div>';

			$error_array['custom_address_error'] = true;

		}

		

		if($_POST['custom_city'] == '') {

			$custom_city_error = '<div id="custom_city_error" class="error">Provide the City.</div>';

			$error_array['custom_city_error'] = true;

		}

		

		if($_POST['custom_state'] == '0') {

			$custom_state_error = '<div id="custom_state_error" class="error">Provide the State.</div>';

			$error_array['custom_state_error'] = true;

		}

		

		if($_POST['custom_zip'] == '') {

			$custom_zip_error = '<div id="custom_zip_error" class="error">Provide the Zip Code.</div>';

			$error_array['custom_zip_error'] = true;

		} else if(!isint($_POST['custom_zip'])) {

			$custom_zip_error = '<div id="custom_zip_integer_error" class="error">Only numbers are allowed.</div>';

			$error_array['custom_zip_error'] = true;

		} else if (strlen($_POST['custom_zip']) < 4) {

			$custom_zip_error = '<div id="custom_zip_numbers_error" class="error">You need 5 digits in the Zip Code.</div>';

			$error_array['custom_zip_error'] = true;	

		}

	}

	



	if(in_array(true, $error_array)) {

		$has_error = true;

	}

	

	if($has_error != true) { //If there is no error, then save the values and go to the next page

    

		//Card Details

		$_POST['full_name'] = trim($_POST['full_name']);

		$_SESSION["full_name"] = $_POST['full_name'];

		

		/*//Series of functions to separate the full name into separate first name, last name, and professional title

		$comma_pos = strpos($_POST['full_name'], ','); //Finds the first occurrence of a comma within the full name

		

		if(!$comma_pos) { //If there is no comma then just separate the First and Last Name into variables

			$first_space_pos = strpos($_POST['full_name'], ' '); //This is the first occurrence of a space within the full name

			$last_space_pos = strrpos($_POST['full_name'], ' '); //This is the last occurrence of a space within the full name

			$first_name = substr($_POST['full_name'], 0, $first_space_pos); //This is the first name	

			$middle_space_pos = strlen($first_name); //This is the occurrence of the space between the first and last name

			$character_at_end = strlen($_POST['full_name']); //This is the occurrence of the first character after the full name

			$last_name = substr($_POST['full_name'], $middle_space_pos+1); //This is the last name

			

		} else{ //If there is a comma then divide the First, Last, and Professional Title into separate variables

			$first_last_name = substr($_POST['full_name'], 0, $comma_pos); //This is the first and last name together

			$pro_title = substr($_POST['full_name'], $comma_pos+1); //This is the professional title

			$last_space_pos = strrpos($first_last_name, ' '); //This is the last occurrence of a space within the first and last name

			$first_name = substr($first_last_name, 0, $last_space_pos); //This is the first name

			$last_name = substr($first_last_name, $last_space_pos+1); //This is the last name

		}
*/
	
		$_POST['full_name'] = trim($_POST['full_name']); //trim the whitespace off the beginning and end
	$comma_pos = strpos($_POST['full_name'], ','); //Finds the first occurrence of a comma within the full name

	//Series of functions to separate the full name into separate first name, last name, and professional title
	if($comma_pos) { //If there is a comma in the name then remove the contents after the comma and save the rest as the full name	
		$first_last_name = substr($_POST['full_name'], 0, $comma_pos); //This is the first and last name together
		$pro_title = substr($_POST['full_name'], $comma_pos+1); //This is the professional title
	} else if(!$comma_pos) { //If there is no comma then just use the full name as the name
		$first_last_name = $_POST['full_name'];
	}
	
	$num_spaces = substr_count($first_last_name, ' '); //Number of Spaces in Name before a comma if applicable
	
	$first_space_pos = strpos($first_last_name, ' '); //This is the first occurrence of a space within the full name
	
	$last_space_pos = strrpos($first_last_name, ' '); //This is the last occurrence of a space within the full name
	
	$first_name = substr($first_last_name, 0, $first_space_pos); //This is the first name
	
	$middle_and_last_name = substr($first_last_name, $first_space_pos+1, strlen($first_last_name));
	
	$middle_space_pos = strpos($middle_and_last_name, ' '); //Finds the next occurence of a space 
	
	$middle_last_name_last_space_pos = strrpos($middle_and_last_name, ' '); //This is the last occurrence of a space within the Middle and Last Name
	
	$middle_name = substr($middle_and_last_name, 0, $middle_last_name_last_space_pos);
	
	$last_name = substr($first_last_name, $last_space_pos+1); //This is the last name





    $_SESSION["first_name"] = $first_name . ' ' . $middle_name;

    $_SESSION["last_name"] = $last_name;

	

		$_SESSION["title"] = $_POST['title'];

		$_SESSION["title_2"] = $_POST['title_2'];

		$_SESSION["dept_div"] = $_POST['dept_div'];

		$_SESSION["dept_div_2"] = $_POST['dept_div_2'];

		$_SESSION["phone_symbol"] = $_POST['phone_symbol'];

		$_SESSION["phone_int_prefix"] = $_POST['phone_int_prefix'];

		$_SESSION["phone_prefix"] = $_POST['phone_prefix'];

		$_SESSION["phone_first"] = $_POST['phone_first'];

		$_SESSION["phone_last"] = $_POST['phone_last'];

		$_SESSION["fax_int_prefix"] = $_POST['fax_int_prefix'];

		$_SESSION["fax_prefix"] = $_POST['fax_prefix'];

		$_SESSION["fax_first"] = $_POST['fax_first'];

		$_SESSION["fax_last"] = $_POST['fax_last'];	

		$_SESSION["email"] = $_POST['email'];

		$_SESSION["address"] = $_POST['address'];

		$_SESSION["mail_stop"] = $_POST['mail_stop'];

		

		if($_POST['other_address']) {

			$_SESSION["other_address"] = 'yes';

		} else {

			$_SESSION["other_address"] = 'no';

		}

		

		if($_POST['no_address']) {

			$_SESSION["no_address"] = 'yes';

		} else {

			$_SESSION["no_address"] = 'no';

		}

		

		$_SESSION["page_has_been_saved"] = 'yes';

		

		if(isset($_POST['other_address'])) {

			$_SESSION["custom_address_1"] = $_POST['custom_address_1'];

			$_SESSION["custom_address_2"] = $_POST['custom_address_2'];

			$_SESSION["custom_city"] = $_POST['custom_city'];

			$_SESSION["custom_state"] = $_POST['custom_state'];

			$_SESSION["custom_zip"] = $_POST['custom_zip'];

			$_SESSION["custom_zip_2"] = $_POST['custom_zip_2'];

		}

		

		//Any extra contact numbers

		$counter = 1;

		$additional_contact_exists = array();

		

		for($counter = 1; $counter <= 2; $counter++) {

			if($_POST['additional_contact' . $counter] != '') {

				$_SESSION['contact'][$counter]['additional_contact'] = $_POST['additional_contact' . $counter];

				$_SESSION['contact'][$counter]['additional_int_prefix'] = $_POST['additional_int_prefix' . $counter];

				$_SESSION['contact'][$counter]['additional_prefix'] = $_POST['additional_prefix' . $counter];

				$_SESSION['contact'][$counter]['additional_first'] = $_POST['additional_first' . $counter];

				$_SESSION['contact'][$counter]['additional_last'] = $_POST['additional_last' . $counter];

				$additional_contact_exists[$counter] = 'yes';

			} else if(!isset($_POST['additional_contact' . $counter]) || $_POST['additional_contact' . $counter] == '') {

				unset($_SESSION['contact'][$counter]['additional_contact']);

				unset($_SESSION['contact'][$counter]['additional_int_prefix']);

				unset($_SESSION['contact'][$counter]['additional_prefix']);

				unset($_SESSION['contact'][$counter]['additional_first']);

				unset($_SESSION['contact'][$counter]['additional_last']);

				$additional_contact_exists[$counter] = 'no';

			}

		}

		 

		

		if(in_array('yes', $additional_contact_exists)) {

			$_SESSION['additional_contact_exists'] = 'yes';

		} else {

			$_SESSION['additional_contact_exists'] = 'no';

		}

		

		if($_SESSION['ordering_step'] == 3) { //if the ordering step is set to 3, then make it 4

			$_SESSION['ordering_step']++;	

		}

		

		header('Location: notepad_options.php');

		

			exit;

	}

} //end if isset card next

        

?>









<div id="container">





<?php 

	include("includes/header.php");

	include("includes/js_warning.php");

?>







    <form id="clientForm" name="clientForm" method="post" action=""><!-- Begin Form -->

          

          

        <div class="form_container" id="card_details">

                <div class="row">

                	<div class="clientform_table_header">Card/Notepad Details<br /> <span class="warning">I want my card/notepad to read:</span></div>

                </div>

                    

         

                <div class="row"> 

                    <div class="content">  

                        <label for="full_name">Full Name w/ professional title</label>

                        <br />  

                        <input id="full_name" name="full_name" class="text" type="text" value="<?php if(isset($_POST['full_name'])) {echo stripslashes($_POST['full_name']);} else {echo stripslashes($_SESSION["full_name"]);} ?>"/>  

                        <?php if(isset($full_name_error)) { echo $full_name_error; } ?>

                    </div>

                </div>

                <div class="row">

                    <div class="content floatleft" id="title_area">  

                        <label for="title">Title</label>

                        <br />    

                        <input id="title" name="title" class="text" type="text" value="<?php if(isset($_POST['title'])) {echo stripslashes($_POST['title']);} else {echo stripslashes($_SESSION["title"]);} ?>"/> 

                        <?php if(isset($title_error)) { echo $title_error; } ?> 

                    </div>  

                    <div class="content">  

                        <label for="title_2">Secondary Title</label>

                        <br />    

                        <input id="title_2" name="title_2" class="text" type="text" value="<?php if(isset($_POST['title_2'])) {echo stripslashes($_POST['title_2']);} else {echo stripslashes($_SESSION["title_2"]);} ?>"/>

                    <p class="warning">(If applicable)</p>   

                    </div>

                </div>

                <div class="row"> 

                    <div class="content floatleft">  

                        <label for="dept_div">Dept. and/or Div.</label>

                        <br />    

                        <input id="dept_div" name="dept_div" class="text" type="text" value="<?php if(isset($_POST['dept_div'])) {echo stripslashes($_POST['dept_div']);} else {echo stripslashes($_SESSION["dept_div"]);} ?>"/> 

                    </div>   

                    <div class="content">  

                        <label for="dept_div_2">Secondary Dept. and/or Div.</label>

                        <br />    

                        <input id="dept_div_2" name="dept_div_2" class="text" type="text" value="<?php if(isset($_POST['dept_div_2'])) {echo stripslashes($_POST['dept_div_2']);} else {echo stripslashes($_SESSION["dept_div_2"]);} ?>"/>

                        <p class="warning">(If applicable)</p>   

                    </div>

                </div>

                <div class="row">

                    <div class="content floatleft column_1">  

                        <label for="phone_prefix">Phone</label> 

                        <br />

                        <select id="phone_symbol" name="phone_symbol">
                        
                        	<option value=""></option>

                            <option value="T" <?php if($_POST["phone_symbol"] == 'T') { echo 'selected';} else if($_SESSION["phone_symbol"] == 'T') { echo 'selected';} ?>>T</option>

                            <option value="D" <?php if($_POST["phone_symbol"] == 'D') { echo 'selected';} else if($_SESSION["phone_symbol"] == 'D') { echo 'selected';} ?>>D</option>
                            
                            <option value="C" <?php if($_POST["phone_symbol"] == 'C') { echo 'selected';} else if($_SESSION["phone_symbol"] == 'C') { echo 'selected';} ?>>C</option>

							<option value="M" <?php if($_POST["phone_symbol"] == 'M') { echo 'selected';} else if($_SESSION["phone_symbol"] == 'M') { echo 'selected';} ?>>M</option>


                        </select>
                        
                        

                        <?php if($_SESSION['foreign_cards_ordered'] == 'yes') { ?> 

                        	<input id="phone_int_prefix" maxlength="2" size="2" name="phone_int_prefix" class="text" type="text" value="<?php if(isset($_POST['phone_int_prefix'])) {echo $_POST['phone_int_prefix'];} elseif($_SESSION["phone_int_prefix"] != '0') {echo $_SESSION["phone_int_prefix"];} ?>"/>

                        <?php } ?>

                        <input id="phone_prefix" maxlength="3" size="3" name="phone_prefix" class="text" type="text" value="<?php if(isset($_POST['phone_prefix'])) {echo $_POST['phone_prefix'];} else {echo $_SESSION["phone_prefix"];} ?>"/>

                        <input id="phone_first" maxlength="3" size="3" name="phone_first" class="text" type="text" value="<?php if(isset($_POST['phone_first'])) {echo $_POST['phone_first'];} else {echo $_SESSION["phone_first"];} ?>"/>

                        <input id="phone_last" maxlength="4" size="3" name="phone_last" class="text" type="text" value="<?php if(isset($_POST['phone_last'])) {echo $_POST['phone_last'];} else {echo $_SESSION["phone_last"];} ?>"/>

                        <?php if(isset($phone_error)) { echo $phone_error; } ?>
                        <?php if(isset($phone_symbol_error)) { echo $phone_symbol_error; } ?> 

                    </div>

                    <div class="content floatleft">  

                        <label for="fax_prefix">Fax</label> 

                        <br />

                        <?php if($_SESSION['foreign_cards_ordered'] == 'yes') { ?> 

                        	<input id="fax_int_prefix" maxlength="2" size="2" name="fax_int_prefix" class="text" type="text" value="<?php if(isset($_POST['fax_int_prefix'])) {echo $_POST['fax_int_prefix'];} elseif($_SESSION["fax_int_prefix"] != '0') {echo $_SESSION["fax_int_prefix"];} ?>"/>

                        <?php } ?>   

                        <input id="fax_prefix" maxlength="3" size="3" name="fax_prefix" class="text" type="text" value="<?php if(isset($_POST['fax_prefix'])) {echo $_POST['fax_prefix'];} else {echo $_SESSION["fax_prefix"];} ?>"/>

                        <input id="fax_first" maxlength="3" size="3" name="fax_first" class="text" type="text" value="<?php if(isset($_POST['fax_first'])) {echo $_POST['fax_first'];} else {echo $_SESSION["fax_first"];} ?>"/>

                        <input id="fax_last" maxlength="4" size="3" name="fax_last" class="text" type="text" value="<?php if(isset($_POST['fax_last'])) {echo $_POST['fax_last'];} else {echo $_SESSION["fax_last"];} ?>"/>

                        <?php if(isset($fax_error)) { echo $fax_error; } ?> 

                    </div>

                

                </div>

                

                <div class="row hidden-nojs" id="additional_contact_button" style="display:none;">

                    <div class="content">  

                        <span id="additional_contact" class="small_button">+ Add an additional Contact Number</span>

                    </div>      

                </div>

                

                

                    

                    <div class="row" id="additional_title_row">

                        <div class="clientform_table_header">Additional Contact Numbers <span class="warning">(If Applicable)</span></div>

                    </div>

                    

                    <div class="row" id="additional_contact_row" style="border-bottom: 1px solid #C2C9CF;" >

                        <div id="additional_content_1" class="content">  

                            <div id="additional_contact_area1" style="overflow:hidden;">

                                <div class="additional_group"><label for="additional_contact">Contact Number Type</label> <br />

                                	<select id="additional_contact1" name="additional_contact1">

                                	<option value=""></option>

                                    <option value="Cell" <?php if($_POST["additional_contact1"] == 'Cell') { echo 'selected';} else if($_SESSION['contact'][1]['additional_contact'] == 'Cell') { echo 'selected';} ?>>Cell</option>

                                    <option value="Mobile" <?php if($_POST["additional_contact1"] == 'Mobile') { echo 'selected';} else if($_SESSION['contact'][1]['additional_contact'] == 'Mobile') { echo 'selected';} ?>>Mobile</option>

                                    <option value="Pager" <?php if($_POST["additional_contact1"] == 'Pager') { echo 'selected';} else if($_SESSION['contact'][1]['additional_contact'] == 'Pager') { echo 'selected';} ?>>Pager</option>

                                    </select>

                                </div>

                                <br />

                                 <div class="additional_group"><label for="phone_prefix">Enter Number</label><br /><?php if($_SESSION['foreign_cards_ordered'] == 'yes') { ?><input id="additional_int_prefix1" maxlength="2" size="2" name="additional_int_prefix1" class="text" type="text" value="<?php if(isset($_POST['additional_int_prefix1'])) {echo $_POST['additional_int_prefix1'];} elseif($_SESSION['contact'][1]['additional_int_prefix'] != '0') {echo $_SESSION['contact'][1]['additional_int_prefix'];} ?>"/><?php } ?><input id="additional_prefix1" maxlength="3" size="3" name="additional_prefix1" class="text" type="text" value="<?php if(isset($_POST['additional_prefix1'])) {echo $_POST['additional_prefix1'];} else {echo $_SESSION['contact'][1]['additional_prefix'];} ?>"/><input id="additional_first1" maxlength="3" size="3" name="additional_first1" class="text" type="text" value="<?php if(isset($_POST['additional_first1'])) {echo $_POST['additional_first1'];} else {echo $_SESSION['contact'][1]['additional_first'];} ?>"/><input id="additional_last1" maxlength="4" size="3" name="additional_last1" class="text" type="text" value="<?php if(isset($_POST['additional_last1'])) {echo $_POST['additional_last1'];} else {echo $_SESSION['contact'][1]['additional_last'];} ?>"/><?php if(isset($additional_error_1)) { echo $additional_error_1; } else if(isset($same_contact)) { echo $same_contact; } else if(isset($both_contact)) { echo $both_contact; }?></div> 

                            </div>

                            

                            <span class="remove_number hidden-nojs" style="display:none;">X</span>

                        </div>

                        

                        <div id="additional_content_2" class="content">  

                            <div id="additional_contact_area2" style="overflow:hidden;">

                                <div class="additional_group"><label for="additional_contact">Contact Number Type</label> <br />

                                	<select id="additional_contact2" name="additional_contact2">

                                	<option value=""></option>

                                    <option value="Cell" <?php if($_POST["additional_contact2"] == 'Cell') { echo 'selected';} else if($_SESSION['contact'][2]['additional_contact'] == 'Cell') { echo 'selected';} ?>>Cell</option>

                                    <option value="Mobile" <?php if($_POST["additional_contact2"] == 'Mobile') { echo 'selected';} else if($_SESSION['contact'][2]['additional_contact'] == 'Mobile') { echo 'selected';} ?>>Mobile</option>

                                    <option value="Pager" <?php if($_POST["additional_contact2"] == 'Pager') { echo 'selected';} else if($_SESSION['contact'][2]['additional_contact'] == 'Pager') { echo 'selected';} ?>>Pager</option>

                                    </select>

                                </div>

                                <br />

                                 <div class="additional_group"><label for="phone_prefix">Enter Number</label><br /><?php if($_SESSION['foreign_cards_ordered'] == 'yes') { ?><input id="additional_int_prefix2" maxlength="2" size="2" name="additional_int_prefix2" class="text" type="text" value="<?php if(isset($_POST['additional_int_prefix2'])) {echo $_POST['additional_int_prefix2'];} elseif($_SESSION['contact'][2]['additional_int_prefix'] != '0') {echo $_SESSION['contact'][2]['additional_int_prefix'];} ?>"/><?php } ?><input id="additional_prefix2" maxlength="3" size="3" name="additional_prefix2" class="text" type="text" value="<?php if(isset($_POST['additional_prefix2'])) {echo $_POST['additional_prefix2'];} else {echo $_SESSION['contact'][2]['additional_prefix'];} ?>"/><input id="additional_first2" maxlength="3" size="3" name="additional_first2" class="text" type="text" value="<?php if(isset($_POST['additional_first2'])) {echo $_POST['additional_first2'];} else {echo $_SESSION['contact'][2]['additional_first'];} ?>"/><input id="additional_last2" maxlength="4" size="3" name="additional_last2" class="text" type="text" value="<?php if(isset($_POST['additional_last2'])) {echo $_POST['additional_last2'];} else {echo $_SESSION['contact'][2]['additional_last'];} ?>"/><?php if(isset($additional_error_2)) { echo $additional_error_2; } else if(isset($same_contact)) { echo $same_contact; } else if(isset($both_contact)) { echo $both_contact; } ?></div>   

                            </div>

                            

                        	<span class="remove_number hidden-nojs" style="display:none;">X</span>   

                        </div>        

                    </div>

                

                

                

                



                    

              

              

                

                

                

                

                

                

                <div style="overflow:hidden;" class="row clearBoth">

                    <div class="content">  

                        <label for="email">Email</label>

                        <br />    

                        <input id="email" name="email" class="text" type="text" value="<?php if(isset($_POST['email'])) {echo stripslashes($_POST['email']);} else {echo stripslashes($_SESSION["email"]);} ?>"/>

                        <?php if(isset($email_error)) { echo $email_error; } ?>   

                    </div>

                    <div class="content">  

                        <label for="mail_stop">Mail Stop #</label> <br /> 

                        <input id="mail_stop" name="mail_stop" class="text" type="text" value="<?php if(isset($_POST['mail_stop'])) {echo $_POST['mail_stop'];} else {if($_SESSION["mail_stop"] != 0) {echo $_SESSION["mail_stop"];}} ?>"/> 

                        <?php if(isset($mail_stop_error)) { echo $mail_stop_error; } ?>  

                    </div> 

                </div>

                

                <div class="row">

                    <div class="content">  

                        <label for="address">Address</label>

                        <br />    

                        <select id="address" name="address">

                        	<?php 

                            $sql = "SELECT *

                            FROM buildings";

                    

                            $result = $conn->query($sql) or die(mysqli_error());

                            

                            while($state_row = $result->fetch_assoc()) { 

							

							//echo $state_row['state'] . '<br />';

                            ?>

                        

                        		

                                <option value="0">Choose an Address</option>

                                <optgroup label="California" style="font-weight: bold; font-style: normal; border-bottom: 1px solid black; font-size: 12px;">    

								<?php 

                                    $sql = "SELECT *

                                    FROM buildings

                                    WHERE state = 'California'

                                    ORDER BY building_num ASC";

                            

                                    $result = $conn->query($sql) or die(mysqli_error());

                                    

                                    while($row = $result->fetch_assoc()) { 

									

									if($row['po_box'] != '' && $row['po_box'] > 0) {

										$po_box = ', P.O. Box ' . $row['po_box'];

									}

									

									

                                    ?>

                                         <option value="<?php echo $row['building_id']; ?>" <?php if($_POST["address"] == $row['building_id']) { echo 'selected';} else if($_SESSION["address"] == $row['building_id']) { echo 'selected';} ?>><?php echo 'Bldg. ' . $row['building_num'] . ' -  ' . $row['address'] . $po_box . ', ' . $row['city'] . ', ' . $row['state']; if($_SESSION['foreign_cards_ordered'] == 'yes') { echo ' USA';} echo ' ' . $row['zip_code'];  ?></option>

                                         

                                         

                                    <?php $po_box = '';

									} //end while?>

								</optgroup>

                                

                                

                                

                                

                                

                                

                                

                                <?php 

								



								

                                $sql = "SELECT *

                                FROM buildings

                                WHERE state != 'California'

                                ORDER BY state ASC";

                        

                                $result = $conn->query($sql) or die(mysqli_error());

                                

                                while($row = $result->fetch_assoc()) { 

								 

                                ?>

                                <optgroup label="<?php echo $row['state']; ?>" style="font-weight: bold; font-style: normal; border-bottom: 1px solid black; font-size: 12px;">

                                     <option value="<?php echo $row['building_id']; ?>" <?php if($_POST["address"] == $row['building_id']) { echo 'selected';} else if($_SESSION["address"] == $row['building_id']) { echo 'selected';} ?>><?php echo $row['address'] . ', P.O. Box ' . $row['po_box'] . ', ' . $row['city'] . ', ' . $row['state']; if($_SESSION['foreign_cards_ordered'] == 'yes') { echo ' USA';} echo ' ' . $row['zip_code'];  ?></option>

                                </optgroup>

                            <?php } //end while

							} //end while 

							?>

                            

                            

                            

                            

                            

                            

                            

                            

                        </select> 

                    <p class="warning" id="address_warning">(If you are part of the 'Applied Anywhere' program and need cards shipped to your residence, indicate specifics on the comments page)</p> 

                    <?php if(isset($no_address_error)) { echo $no_address_error; } else if(isset($both_address_error)) { echo $both_address_error; } ?> 

                    </div>

                </div>

                

                <div class="row clearBoth"> 

                    <div class="content">  

                        <label for="no_address">No Address on Card</label>

                        <input id="no_address" type="checkbox" name="no_address" <?php if(isset($_POST['no_address'])) {echo 'checked="checked"';} else if($_SESSION["no_address"] == 'yes') { echo 'checked="checked"';} ?> />  

                    	<p class="warning" id="no_address_warning">(Check here if you don't want any address on your card)</p>

                        <?php if(isset($no_address_error)) { echo $no_address_error; } else if(isset($both_address_error)) { echo $both_address_error; } ?>   

                    </div>

                </div> 

                

                <div class="row clearBoth"> 

                    <div class="content">  

                        <label for="other_address">Other Address</label>

                        <input id="other_address" type="checkbox" name="other_address" <?php if(isset($_POST['other_address'])) {echo 'checked="checked"';} else if($_SESSION["other_address"] == 'yes') { echo 'checked="checked"';} ?> />  

                    	<p class="warning" id="other_address_warning">(Check here if using a custom address)</p>

                        <?php if(isset($no_address_error)) { echo $no_address_error; } else if(isset($both_address_error)) { echo $both_address_error; } ?>   

                    </div>

                </div> 

                

                <div class="row clearBoth" id="custom_address_row"> 

                	<div class="clientform_table_header">Custom Address<br /> <span class="warning">Enter your customized address below:</span></div>

                    <div class="content column_1">  

                        <label for="custom_address_1">Address Line 1</label><br />  

                        <input id="custom_address_1" name="custom_address_1" type="text" value="<?php if(isset($_POST['custom_address_1'])) {echo $_POST['custom_address_1'];} else {echo $_SESSION["custom_address_1"];} ?>"/>

                        <?php if(isset($custom_address_error)) { echo $custom_address_error; } ?>    

                    </div> 

                    <div class="content">  

                        <label for="custom_address_2">Address Line 2</label><br />  

                        <input id="custom_address_2" name="custom_address_2" type="text" value="<?php if(isset($_POST['custom_address_2'])) {echo $_POST['custom_address_2'];} else {echo $_SESSION["custom_address_2"];} ?>"/> 

                        <p class="warning">(If applicable)</p>   

                    </div>

                    <div class="content column_1" style="clear:both">  

                        <label for="custom_city">City</label><br />  

                        <input id="custom_city" name="custom_city" type="text" value="<?php if(isset($_POST['custom_city'])) {echo $_POST['custom_city'];} else {echo $_SESSION["custom_city"];} ?>"/>

                        <?php if(isset($custom_city_error)) { echo $custom_city_error; } ?>    

                    </div>

                    <div class="content">  

                        <label for="custom_state">State / Province / Region</label><br /> 

                        <?php

						$states_array = array(

							'AL'=>"Alabama",  

							'AK'=>"Alaska",  

							'AZ'=>"Arizona",  

							'AR'=>"Arkansas",  

							'CA'=>"California",  

							'CO'=>"Colorado",  

							'CT'=>"Connecticut",  

							'DE'=>"Delaware",  

							'DC'=>"DC",  

							'FL'=>"Florida",  

							'GA'=>"Georgia",  

							'HI'=>"Hawaii",  

							'ID'=>"Idaho",  

							'IL'=>"Illinois",  

							'IN'=>"Indiana",  

							'IA'=>"Iowa",  

							'KS'=>"Kansas",  

							'KY'=>"Kentucky",  

							'LA'=>"Louisiana",  

							'ME'=>"Maine",  

							'MD'=>"Maryland",  

							'MA'=>"Massachusetts",  

							'MI'=>"Michigan",  

							'MN'=>"Minnesota",  

							'MS'=>"Mississippi",  

							'MO'=>"Missouri",  

							'MT'=>"Montana",

							'NE'=>"Nebraska",

							'NV'=>"Nevada",

							'NH'=>"New Hampshire",

							'NJ'=>"New Jersey",

							'NM'=>"New Mexico",

							'NY'=>"New York",

							'NC'=>"North Carolina",

							'ND'=>"North Dakota",

							'OH'=>"Ohio",  

							'OK'=>"Oklahoma",  

							'OR'=>"Oregon",  

							'PA'=>"Pennsylvania",  

							'RI'=>"Rhode Island",  

							'SC'=>"South Carolina",  

							'SD'=>"South Dakota",

							'TN'=>"Tennessee",  

							'TX'=>"Texas",  

							'UT'=>"Utah",  

							'VT'=>"Vermont",  

							'VA'=>"Virginia",  

							'WA'=>"Washington",  

							'WV'=>"West Virginia",  

							'WI'=>"Wisconsin",  

							'WY'=>"Wyoming");

						?>

                        

                        <select id="custom_state" name="custom_state">

                            <option value="0">Choose a state</option>

                            <?php 

								foreach($states_array as $key => $value){ 

							?>

									<option value="<?php echo $value; ?>" <?php if($_POST["custom_state"] == $value) { echo 'selected';} else if($_SESSION['custom_state'] == $value) { echo 'selected';} ?>><?php echo $value; ?></option>

                            <?php     

								}

							?>

                        </select> 

                        <?php if(isset($custom_state_error)) { echo $custom_state_error; } ?>   

                    </div>

                    <div class="content" style="clear:both; width: 150px;">  

                        <label for="custom_zip">ZIP / Postal Code</label><br /> 

                        <input id="custom_zip" name="custom_zip" type="text" maxlength="5" size="5" value="<?php if(isset($_POST['custom_zip'])) {echo $_POST['custom_zip'];} else {echo $_SESSION["custom_zip"];} ?>"/>

                        <span> - </span>

                        <input id="custom_zip_2" name="custom_zip_2" type="text" maxlength="4" size="4" value="<?php if(isset($_POST['custom_zip_2'])) {echo $_POST['custom_zip_2'];} else {echo $_SESSION["custom_zip_2"];} ?>"/>

                        <?php if(isset($custom_zip_error)) { echo $custom_zip_error; } ?>    

                    </div>

                </div>

                

                <div class="row clearBoth">

                    <div style="overflow:hidden;" class="content"><input class="button prev submit" type="submit" name="card_prev" value="Previous Step" /></div>     

                    <div class="content" id="last_content"><input class="button next submit" type="submit" id="card_submit" name="card_next" value="Next Step" /></div>

                </div>

                    

        </div> 

          

        

                 

                

        

    

    

    </form><!-- End Form --> 

</div>



</body>



</html>