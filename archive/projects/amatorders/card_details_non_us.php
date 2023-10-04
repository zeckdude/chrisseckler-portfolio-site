<?php

session_start();

ob_start();



/*if($_SESSION['contact']) {

	for($counter = 1; $counter <= 2; $counter++) {

		foreach($_SESSION['contact'][$counter] as $key => $value) { 

				echo 'Group: ' . $counter;

				echo '$_SESSION[contact][' . $key . '] = ' . $value . '<br />';

		} 

		echo '<br/>';

	}

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







unset($_SESSION['contact'][1]['additional_int_prefix']);

unset($_SESSION['contact'][1]['additional_prefix']);

unset($_SESSION['contact'][1]['additional_first']);

unset($_SESSION['contact'][1]['additional_last']);





unset($_SESSION['contact'][2]['additional_int_prefix']);

unset($_SESSION['contact'][2]['additional_prefix']);

unset($_SESSION['contact'][2]['additional_first']);

unset($_SESSION['contact'][2]['additional_last']);















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

		

		if($("#additional_non_us1").val() != '') {

			$("#additional_content_1").show();

			$("#additional_title_row").show();

			$("#additional_contact_row").show();

		}

		

		if($("#additional_non_us2").val() != '') {

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

		

		

		/*$('#additional_non_us_contact2').change(function() {

			if(!$("#additional_non_us_contact_error2").is(":hidden")) {

				//alert('The error is shown');

				$('#additional_contact_area1').css("height","167px");

			}

			

			if(!$("#additional_non_us_error2").is(":hidden")) {

				//alert('The error is shown');

				$('#additional_contact_area1').css("height","167px");

			}

			

		});*/

		

		//This clears the value of the Additional Contact Fields if one of the fields doesn't contain a value

		if($("#additional_non_us_contact1").val() != '') {

			if($("#additional_non_us1").val() == '') {

				$("#additional_non_us_contact1").val('');

			}

		}

		

		if($("#additional_non_us_contact2").val() != '') {

			if($("#additional_non_us2").val() == '') {

				$("#additional_non_us_contact2").val('');

			}

		}



		

		

		$('input[type="text"]').focus(function() //highlights all text inside of input fields when you click on them

		 {

			$(this).select();	

		 });

		

		//Automated tabbing in number fields

		function numberAutoTab(contactType, additionalNumber) {

			<?php if($_SESSION['foreign_cards_ordered'] == 'yes') { ?>

				$('#' + contactType + '_int_prefix' + additionalNumber).autotab({ target: contactType + '_prefix' + additionalNumber, format: 'numeric' });

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



<?php include("includes/connection.php");



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

			$_SESSION["non_us_phone"] = $row["non_us_phone"];

			$_SESSION["non_us_fax"] = $row["non_us_fax"];

			$_SESSION["email"] = $row["email"];

			$_SESSION["phone_symbol"] = $row["phone_symbol"];

			$_SESSION["no_address"] = $row["no_address"];

		}

		

		$sql = "SELECT *

				FROM non_us_addresses

				WHERE order_id='".$_SESSION['last_order_id']."'";

				

		$result = $conn->query($sql) or die(mysqli_error());

	  

		if($row = $result->fetch_assoc()){

			$_SESSION["non_us_address_1"] = $row["line_1"];

			$_SESSION["non_us_address_2"] = $row["line_2"];

			$_SESSION["non_us_address_3"] = $row["line_3"];

			$_SESSION["non_us_address_4"] = $row["line_4"];

		}

		

		

		$counter = 1;

		$sql = "SELECT *

				FROM contact_numbers

				WHERE order_id = '" . $_SESSION['last_order_id'] . "'";	

		

		$result = $conn->query($sql) or die(mysqli_error());

		while($row = $result->fetch_assoc()) {

				$_SESSION['contact'][$counter]['additional_contact'] = $row['contact_type'];

				$_SESSION['contact'][$counter]['additional_non_us_number'] = $row['non_us_number'];

				$counter++;

		}	

}







$done = false;

//$_SESSION['js_enabled'] = 'yes';







if(isset($_POST['card_prev'])){ 

    

    //Card Details

	$_SESSION["full_name"] = $_POST['full_name'];



	//Series of functions to separate the full name into separate first name, last name, and professional title

	/*$comma_pos = strpos($_POST['full_name'], ','); //Finds the first occurrence of a comma within the full name

	

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

	$_SESSION["non_us_phone"] = $_POST['non_us_phone'];

	$_SESSION["non_us_fax"] = $_POST['non_us_fax'];

	$_SESSION["email"] = $_POST['email'];







	if($_POST['no_address']) {

		$_SESSION["no_address"] = 'yes';

	} else {

		$_SESSION["no_address"] = 'no';

	}

	

	$_SESSION["page_has_been_saved"] = 'yes';

	



	$_SESSION["non_us_address_1"] = $_POST['non_us_address_1'];

	$_SESSION["non_us_address_2"] = $_POST['non_us_address_2'];

	$_SESSION["non_us_address_3"] = $_POST['non_us_address_3'];

	$_SESSION["non_us_address_4"] = $_POST['non_us_address_4'];



	

	

	//Any extra contact numbers

	$counter = 1;

	$additional_contact_exists = array();



	for($counter = 1; $counter <= 2; $counter++) {

		if($_POST['additional_non_us_contact' . $counter] != '') {

			$_SESSION['contact'][$counter]['additional_contact'] = $_POST['additional_non_us_contact' . $counter];

			$_SESSION['contact'][$counter]['additional_non_us_number'] = $_POST['additional_non_us' . $counter];

			$_SESSION['additional_basic'] = 'no';

			$additional_contact_exists[$counter] = 'yes';

		} else if(!isset($_POST['additional_non_us_contact' . $counter]) || $_POST['additional_non_us_contact' . $counter] == '') {

			unset($_SESSION['contact'][$counter]['additional_contact']);

			unset($_SESSION['contact'][$counter]['additional_non_us_number']);			

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

	} else if(!eregi($email_reg_expr, $_POST['email'])) {

		$email_error = '<div id="email_error_2" class="error">Enter a valid Email.</div>';

		$error_array['email_error_2'] = true;

	}

	

	/*
if($_POST['non_us_phone'] == '') {

		$phone_error = '<div id="non_us_phone_error" class="error">Provide a phone number.</div>';

		$error_array['phone_error'] = true;

	}
*/



	if($_POST['additional_non_us_contact1'] != '') {

		if($_POST['additional_non_us1'] == '') {

			$additional_error_1 = '<div id="additional_non_us_contact_error1" class="error">Provide a contact number.</div>';

			$error_array['additional_error_1'] = true;	

		}

	}

	

	if($_POST['additional_non_us_contact2'] != '') {

		if($_POST['additional_non_us2'] == '') {

			$additional_error_2 = '<div id="additional_non_us_contact_error2" class="error">Provide a contact number.</div>';

			$error_array['additional_error_2'] = true;	

		}

	}

	

	if(($_POST['additional_non_us_contact1'] != '') || ($_POST['additional_non_us_contact2'] != '')) {

		if($_POST['additional_non_us_contact1'] == $_POST['additional_non_us_contact2']) {

			$same_contact = '<div id="same_contact_error1" class="error">You can not pick two of the same contact type.</div>';

			$error_array['additional_type_same'] = true;

		}

		

		if(($_POST['additional_non_us_contact1'] == 'Mobile' && $_POST['additional_non_us_contact2'] == 'Cell') || ($_POST['additional_non_us_contact1'] == 'Cell' && $_POST['additional_non_us_contact2'] == 'Mobile')) {

			$both_contact = '<div id="both_contact_error1" class="error">You can not pick both Cell and Mobile.</div>';

			$error_array['additional_type_both'] = true;

		}

	}

	

	if(($_POST['no_address'] != 'on') && ($_POST['non_us_address_1'] == '')) { //if none of the address options are picked, then show an error

		$no_address_error = '<div id="no_address_error_1" class="error">You must choose one of these options.</div>';

		$error_array['no_address'] = true;	

	}

	

	if($_POST['non_us_address_1'] != '' && $_POST['no_address'] == 'on') {

		$both_address_error = '<div id="both_address_error_1" class="error">You can only choose one of these options.</div>';

		$error_array['both_address'] = true;		

	}

	

	if($_POST['no_address'] != 'on') {

		if($_POST['non_us_address_1'] == '') {

			$non_us_address_error_1 = '<div id="non_us_address_error_1" class="error">Provide the Address.</div>';

			$error_array['non_us_address_error_1'] = true;

		}

		

		if($_POST['non_us_address_2'] == '') {

			$non_us_address_error_2 = '<div id="non_us_address_error_2" class="error">Provide the Address.</div>';

			$error_array['non_us_address_error_2'] = true;

		}

	}

	



	if(in_array(true, $error_array)) {

		$has_error = true;

	}

	

	if($has_error != true) { //If there is no error, then save the values and go to the next page

    

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

		$_SESSION["non_us_phone"] = $_POST['non_us_phone'];

		$_SESSION["non_us_fax"] = $_POST['non_us_fax'];

		$_SESSION["email"] = $_POST['email'];





	

		if($_POST['no_address']) {

			$_SESSION["no_address"] = 'yes';

		} else {

			$_SESSION["no_address"] = 'no';

		}

		

		$_SESSION["page_has_been_saved"] = 'yes';

		



		$_SESSION["non_us_address_1"] = $_POST['non_us_address_1'];

		$_SESSION["non_us_address_2"] = $_POST['non_us_address_2'];

		$_SESSION["non_us_address_3"] = $_POST['non_us_address_3'];

		$_SESSION["non_us_address_4"] = $_POST['non_us_address_4'];



		

		

		//Any extra contact numbers

		$counter = 1;

		$additional_contact_exists = array();



		for($counter = 1; $counter <= 2; $counter++) {

			if($_POST['additional_non_us_contact' . $counter] != '') {

				$_SESSION['contact'][$counter]['additional_contact'] = $_POST['additional_non_us_contact' . $counter];

				$_SESSION['contact'][$counter]['additional_non_us_number'] = $_POST['additional_non_us' . $counter];

				$_SESSION['additional_basic'] = 'no';

				$additional_contact_exists[$counter] = 'yes';

			} else if(!isset($_POST['additional_non_us_contact' . $counter]) || $_POST['additional_non_us_contact' . $counter] == '') {

				unset($_SESSION['contact'][$counter]['additional_contact']);

				unset($_SESSION['contact'][$counter]['additional_non_us_number']);			

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

          

          

        <div class="form_container non_us_card_details" id="card_details">

                <div class="row">

                	<div class="clientform_table_header">Card/Notepad Details<br /> <span class="warning">I want my card/notepad to read:</span></div>

                </div>

                    

         

                <div class="row"> 

                    <div class="content">  

                        <label for="full_name">Full Name w/ professional title</label>

                        <br />  

                        <input id="full_name" name="full_name" class="text" type="text" value="<?php if(isset($_POST['full_name'])) {echo $_POST['full_name'];} else {echo $_SESSION["full_name"];} ?>"/>  

                        <?php if(isset($full_name_error)) { echo $full_name_error; } ?>

                    </div>

                </div>

                <div class="row clearBoth">

                    <div class="content floatleft">  

                        <label for="title">Title</label>

                        <br />    

                        <input id="title" name="title" class="text" type="text" value="<?php if(isset($_POST['title'])) {echo $_POST['title'];} else {echo $_SESSION["title"];} ?>"/> 

                        <?php if(isset($title_error)) { echo $title_error; } ?> 

                    </div>  

                    <div class="content">  

                        <label for="title_2">Secondary Title</label>

                        <br />    

                        <input id="title_2" name="title_2" class="text" type="text" value="<?php if(isset($_POST['title_2'])) {echo $_POST['title_2'];} else {echo $_SESSION["title_2"];} ?>"/>

                    <p class="warning">(If applicable)</p>   

                    </div>

                </div>

                <div class="row"> 

                    <div class="content floatleft">  

                        <label for="dept_div">Dept. and/or Div.</label>

                        <br />    

                        <input id="dept_div" name="dept_div" class="text" type="text" value="<?php if(isset($_POST['dept_div'])) {echo $_POST['dept_div'];} else {echo $_SESSION["dept_div"];} ?>"/> 

                    </div>   

                    <div class="content">  

                        <label for="dept_div_2">Secondary Dept. and/or Div.</label>

                        <br />    

                        <input id="dept_div_2" name="dept_div_2" class="text" type="text" value="<?php if(isset($_POST['dept_div_2'])) {echo $_POST['dept_div_2'];} else {echo $_SESSION["dept_div_2"];} ?>"/>

                        <p class="warning">(If applicable)</p>   

                    </div>

                </div>

                <div class="row">

                    <div class="content floatleft column_1">  

                        <label for="non_us_phone">Phone</label> 

                        <br />

                        <select id="phone_symbol" name="phone_symbol">

                            <option value="T" <?php if($_POST["phone_symbol"] == 'T') { echo 'selected';} else if($_SESSION["phone_symbol"] == 'T') { echo 'selected';} ?>>T</option>

                            <option value="D" <?php if($_POST["phone_symbol"] == 'D') { echo 'selected';} else if($_SESSION["phone_symbol"] == 'D') { echo 'selected';} ?>>D</option>
                            
                            <option value="C" <?php if($_POST["phone_symbol"] == 'C') { echo 'selected';} else if($_SESSION["phone_symbol"] == 'C') { echo 'selected';} ?>>C</option>

							<option value="M" <?php if($_POST["phone_symbol"] == 'M') { echo 'selected';} else if($_SESSION["phone_symbol"] == 'M') { echo 'selected';} ?>>M</option>

                        </select>

                        <input id="non_us_phone" maxlength="20" size="20" name="non_us_phone" class="text" type="text" value="<?php if(isset($_POST['non_us_phone'])) {echo $_POST['non_us_phone'];} else {echo $_SESSION["non_us_phone"];} ?>"/>

                        <br /><span class="warning" id="nonus_phone_warning">Example: 123.123.1234</span>

                        <?php if(isset($phone_error)) { echo $phone_error; } ?> 

                    </div>

                    <div class="content floatleft">  

                        <label for="non_us_fax">Fax</label> 

                        <br />

                        <input id="non_us_fax" maxlength="20" size="20" name="non_us_fax" class="text" type="text" value="<?php if(isset($_POST['non_us_fax'])) {echo $_POST['non_us_fax'];} else {echo $_SESSION["non_us_fax"];} ?>"/>   

                        <br /><span class="warning" id="phone_warning">Example: 123.123.1234</span>

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

                                	<select id="additional_non_us_contact1" name="additional_non_us_contact1">

                                	<option value=""></option>

                                    <option value="Cell" <?php if($_POST["additional_non_us_contact1"] == 'Cell') { echo 'selected';} else if($_SESSION['contact'][1]['additional_contact'] == 'Cell') { echo 'selected';} ?>>Cell</option>

                                    <option value="Mobile" <?php if($_POST["additional_non_us_contact1"] == 'Mobile') { echo 'selected';} else if($_SESSION['contact'][1]['additional_contact'] == 'Mobile') { echo 'selected';} ?>>Mobile</option>

                                    <option value="Pager" <?php if($_POST["additional_non_us_contact1"] == 'Pager') { echo 'selected';} else if($_SESSION['contact'][1]['additional_contact'] == 'Pager') { echo 'selected';} ?>>Pager</option>

                                    </select>

                                </div>

                                <br />

                                 <div class="additional_group"><label for="phone_prefix">Enter Number</label><br /><input id="additional_non_us1" maxlength="20" size="20" name="additional_non_us1" class="text" type="text" value="<?php if(isset($_POST['additional_non_us1'])) {echo $_POST['additional_non_us1'];} else {echo $_SESSION['contact'][1]['additional_non_us_number'];} ?>"/><?php if(isset($additional_error_1)) { echo $additional_error_1; } else if(isset($same_contact)) { echo $same_contact; } else if(isset($both_contact)) { echo $both_contact; }?></div> 

                            </div>

                            

                            <span class="remove_number hidden-nojs" style="display:none;">X</span>

                        </div>

                        

                        <div id="additional_content_2" class="content">  

                            <div id="additional_contact_area2" style="overflow:hidden;">

                                <div class="additional_group"><label for="additional_contact">Contact Number Type</label> <br />

                                	<select id="additional_non_us_contact2" name="additional_non_us_contact2">

                                	<option value=""></option>

                                    <option value="Cell" <?php if($_POST["additional_non_us_contact2"] == 'Cell') { echo 'selected';} else if($_SESSION['contact'][2]['additional_contact'] == 'Cell') { echo 'selected';} ?>>Cell</option>

                                    <option value="Mobile" <?php if($_POST["additional_non_us_contact2"] == 'Mobile') { echo 'selected';} else if($_SESSION['contact'][2]['additional_contact'] == 'Mobile') { echo 'selected';} ?>>Mobile</option>

                                    <option value="Pager" <?php if($_POST["additional_non_us_contact2"] == 'Pager') { echo 'selected';} else if($_SESSION['contact'][2]['additional_contact'] == 'Pager') { echo 'selected';} ?>>Pager</option>

                                    </select>

                                </div>

                                <br />

                                 <div class="additional_group"><label for="phone_prefix">Enter Number</label><br /><input id="additional_non_us2" maxlength="20" size="20" name="additional_non_us2" class="text" type="text" value="<?php if(isset($_POST['additional_non_us2'])) {echo $_POST['additional_non_us2'];} else {echo $_SESSION['contact'][2]['additional_non_us_number'];} ?>"/><?php if(isset($additional_error_2)) { echo $additional_error_2; } else if(isset($same_contact)) { echo $same_contact; } else if(isset($both_contact)) { echo $both_contact; } ?></div>   

                            </div>

                        

                        <span class="remove_number hidden-nojs" style="display:none;">X</span>

                        </div>      

                    </div>

                

                

                

                

                

                

                

                

                

                

               

              

                

                

                

                

                

                

                <div style="overflow:hidden;" class="row">

                    <div class="content">  

                        <label for="email">Email</label>

                        <br />    

                        <input id="email" name="email" class="text" type="text" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];} else {echo $_SESSION["email"];} ?>"/>

                        <?php if(isset($email_error)) { echo $email_error; } ?>   

                    </div>

                </div>

                

                

                

                <div class="row"> 

                    <div class="content">  

                        <label for="non_us_no_address">No Address on Card</label>

                        <input id="non_us_no_address" type="checkbox" name="no_address" <?php if(isset($_POST['no_address'])) {echo 'checked="checked"';} else if($_SESSION["no_address"] == 'yes') { echo 'checked="checked"';} ?> />  

                    	<p class="warning" id="no_address_warning">(Check here if you don't want any address on your card)</p>

                        <?php if(isset($no_address_error)) { echo $no_address_error; } else if(isset($both_address_error)) { echo $both_address_error; } ?>   

                    </div>

                </div> 



                

                <div class="row" id="custom_address_row"> 

                	<div class="clientform_table_header" id="non_us_address_header">Address<br /> <span class="warning">Enter your customized address below:</span></div>

                    

                    

                    <div class="content">

						<?php if(isset($no_address_error)) { echo $no_address_error; } else if(isset($both_address_error)) { echo $both_address_error; } ?>  

                        <label for="non_us_address_1">Address Line 1</label><br />  

                        <input id="non_us_address_1" name="non_us_address_1" type="text" value="<?php if(isset($_POST['non_us_address_1'])) {echo $_POST['non_us_address_1'];} else {echo $_SESSION["non_us_address_1"];} ?>"/>

                        <?php if(isset($non_us_address_error_1)) { echo $non_us_address_error_1; } ?>    

                    </div> 

                    <div class="content" style="clear:both;">  

                        <label for="non_us_address_2">Address Line 2</label><br />  

                        <input id="non_us_address_2" name="non_us_address_2" type="text" value="<?php if(isset($_POST['non_us_address_2'])) {echo $_POST['non_us_address_2'];} else {echo $_SESSION["non_us_address_2"];} ?>"/>

                        <?php if(isset($non_us_address_error_2)) { echo $non_us_address_error_2; } ?>

                    </div>

                    

                    <div class="content" style="clear:both;">  

                        <label for="non_us_address_3">Address Line 3</label><br />  

                        <input id="non_us_address_3" name="non_us_address_3" type="text" value="<?php if(isset($_POST['non_us_address_3'])) {echo $_POST['non_us_address_3'];} else {echo $_SESSION["non_us_address_3"];} ?>"/>

                    </div>

                    

                    <div class="content" style="clear:both;">  

                        <label for="non_us_address_4">Address Line 4</label><br />  

                        <input id="non_us_address_4" name="non_us_address_4" type="text" value="<?php if(isset($_POST['non_us_address_4'])) {echo $_POST['non_us_address_4'];} else {echo $_SESSION["non_us_address_4"];} ?>"/>

                    </div>

                </div>

                

                <div class="row">

                    <div style="overflow:hidden;" class="content"><input class="button prev submit" type="submit" name="card_prev" value="Previous Step" /></div>     

                    <div class="content" id="last_content"><input class="button next submit" type="submit" id="non_us_card_submit" name="card_next" value="Next Step" /></div>

                </div>

                    

        </div> 

          

        

                 

                

        

    

    

    </form><!-- End Form --> 

</div>



</body>



</html>