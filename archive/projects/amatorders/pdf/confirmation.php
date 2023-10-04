<?php

session_start();

ob_start();



date_default_timezone_set('America/Los_Angeles');





//echo 'SQL Statement: ' . $_SESSION['sql'];

//unset($_SESSION['order_id']);

/*foreach($_SESSION['order_id'] as $orderid_key => $orderid_value) {

	echo 'Order Number: ' . $orderid_value . '<br />'; 	

}*/





//print_r($_SESSION['contact']);

//echo '<br /><br />';



if(count($_SESSION['contact']) > 0) {



	foreach ($_SESSION['contact'] as $counter => $contact_array) { //This specifies the $_SESSION['order'] array to loop through 
		if($contact_array != '') {
		

		//echo '<br />';

		//echo $counter . ' counter';

		//echo '<br />';

		

			foreach ($contact_array as $key => $value) { //This specifies the array within the $_SESSION['order'] array
	
				//echo $key . ': ' . $value;
	
				//echo '<br />';			
	
				$_SESSION['extra_number'][$counter][$key] = $value; 
	
			} //end foreach
	
			
	
			if(count($contact_array) == 0){
	
				if(is_array($_SESSION['extra_number'])) {
	
					foreach($_SESSION['extra_number'] as $session) {
	
						$_SESSION['extra_number'][$counter] = NULL;
	
					}				
	
				}
	
			}
		} //end if contact array != ''

		//echo '<br />';

	} //end of outer foreach loop

}



//print_r($_SESSION['extra_number']);







/*



echo '<br/>';



print_r ($_SESSION['shipping']);

echo '<br/><br/>';*/



/*//These are the saved session variables

foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop

	//if($value != '') {

		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

	//}

} */




unset($_SESSION['final_shipping']);



foreach($_SESSION['shipping'] as $mainkey => $mainvalue) {

		//echo '$_SESSION[shipping][' . $mainkey . '] = ' . $mainvalue . '<br />'; //Here the mainkey is the name of the array and the mainvalue is the contents of that array

		foreach ($mainvalue as $key => $value) {

			//echo '$_SESSION[shipping][' . $mainkey . '][' . $key . '] = ' . $value . '<br />';

			

			if($key == 'timespan') { $timespan = $value; }

			if($key == 'rush_date') { $rush_date = $value; }

		}

		

		if($timespan == '10 work days') {

			//echo $mainkey . ' is assigned to the 10 work days array<br/><br/>';	

			if(isset($_SESSION['final_shipping']['10_work_days'])) {

				$items_in_array = count($_SESSION['final_shipping']['10_work_days']);

				$_SESSION['final_shipping']['10_work_days'][$items_in_array+1][$mainkey]['timespan'] = $timespan;

				$_SESSION['final_shipping']['10_work_days'][$items_in_array+1][$mainkey]['rush_date'] = $rush_date;

			} else {

				$_SESSION['final_shipping']['10_work_days'][1][$mainkey]['timespan'] = $timespan;

				$_SESSION['final_shipping']['10_work_days'][1][$mainkey]['rush_date'] = $rush_date;

			}

		}

		

		if($timespan == '1-3 work days' || $timespan == '4-8 work days') {

			//echo $mainkey . ' is assigned to the 1-3 work days array<br/><br/>';	

			if(isset($_SESSION['final_shipping'][$rush_date])) {

				$items_in_array = count($_SESSION['final_shipping'][$rush_date]);

				$_SESSION['final_shipping'][$rush_date][$items_in_array+1][$mainkey]['timespan'] = $timespan;

				$_SESSION['final_shipping'][$rush_date][$items_in_array+1][$mainkey]['rush_date'] = $rush_date;

			} else {

				$_SESSION['final_shipping'][$rush_date][1][$mainkey]['timespan'] = $timespan;

				$_SESSION['final_shipping'][$rush_date][1][$mainkey]['rush_date'] = $rush_date;

			}

		}	

}



//echo '<br/>';

//print_r ($_SESSION['final_shipping']);

//echo '<br/><br/><br/>';



$items_in_array = count($_SESSION['final_shipping']);

//echo 'There are ' . $items_in_array . ' different shipping options.<br/><br/>';



/*$items_in_array = count($_SESSION['final_shipping']['10_work_days']);

echo 'There are ' . $items_in_array . ' items in the 10 work days array';*/





/*foreach($_SESSION['final_shipping'] as $workdays_key => $workdays_value) { //an example of $workdays_key is 10 work days or a date

	foreach ($workdays_value as $counter_key => $counter_value) { //an example of $counter_key is 1(the number of orders that exist for that shipping choice)

		//echo 'There are ' . count($workdays_value) . ' of the ' . $workdays_key . ' selection.<br/>';

		$items_for_workdays = count($workdays_value); //This is the number of items that need to be inserted into the DB

		

		foreach ($counter_value as $orderitem_key => $orderitem_value) { //an example of $orderitem_key is foreign(the item that is being ordered) 

			foreach ($orderitem_value as $key => $value) { //an example of $key is timespan and an example of value is 10 work days(the item that is being ordered) 

				if($key == 'timespan') { $timespan = $value; }

				if($key == 'rush_date') { $rush_date = $value; }

			}	

			

			echo 'Current Order Item: ' . $orderitem_key . '<br/>';

			echo 'Current Timespan: ' . $timespan . '<br/>';

			echo 'Current Rush Date: ' . $rush_date . '<br/>';

		}

		echo '<br/>';

	}

}

echo '<br/>';echo '<br/>';echo '<br/>';*/



unset($_SESSION['test_array']);

$test_inserted_array = array();



foreach($_SESSION['final_shipping'] as $workdays_key => $workdays_value) { 

	foreach ($workdays_value as $counter_key => $counter_value) { 

		

		$items_per_workdays = count($workdays_value); //This is the number of items that need to be inserted into the DB

		if(!in_array($workdays_key,$test_inserted_array)) {

			//echo 'There are ' . $items_per_workdays . ' of the ' . $workdays_key . ' selection.<br/>';	

			foreach ($counter_value as $orderitem_key => $orderitem_value) { //an example of $orderitem_key is foreign(the item that is being ordered) 

				//first create basic sql for all necessary information

				

				if($items_per_workdays > 1) {

					for($i = 1; $i <= $items_per_workdays; $i++) {

						//then create sql for each selection information, like all the english stuff, and then the notepads stuff

						foreach($_SESSION['final_shipping'][$workdays_key][$i] as $order_item_name => $order_item_value) {

							//echo 'Order Item: ' . $order_item_name . '<br/>';

							//echo 'Timespan: ' . $_SESSION['final_shipping'][$workdays_key][$i][$order_item_name]['timespan'] . '<br/>';

							//echo 'Rush Date: ' . $_SESSION['final_shipping'][$workdays_key][$i][$order_item_name]['rush_date'] . '<br/>';						

						} //end foreach

					} //end for

					

				} else { //end if

					foreach($_SESSION['final_shipping'][$workdays_key][1] as $order_item_name => $order_item_value) {

						//then create sql for selection information

						//echo 'Order Item: ' . $order_item_name . '<br/>';

						//echo 'Timespan: ' . $_SESSION['final_shipping'][$workdays_key][1][$order_item_name]['timespan'] . '<br/>';

						//echo 'Rush Date: ' . $_SESSION['final_shipping'][$workdays_key][1][$order_item_name]['rush_date'] . '<br/>';

					} //end foreach

				

				} //end else

			} //end foreach

		

			array_push($test_inserted_array,$workdays_key);

			

			//echo 'This is where the Insert query is run for each shipping time selection';

			//echo '<br/><br/>';

			

			$_SESSION['test_array'][] = $workdays_key;

		} //end if

	} //end foreach	

} //end foreach



//echo 'This is where any additional table inserts are run';

//echo '<br/>';



//print_r($_SESSION['test_array']);

/*foreach($_SESSION['test_array'] as $key => $value) {

	echo 'Order Number: ' . $value . '<br />';	

}*/



//echo '<br/>';



//print_r($test_inserted_array);





//echo '<br/>';echo '<br/>';echo '<br/>';







//This code ensures that you have been to this page or page before it, so you can't manually type in the url without being redirected

/*
if(!isset($_SESSION['ordering_step']) || $_SESSION['ordering_step'] < 7) {//if the ordering step has not been created or is less than the current page ordering step, because someone manually typed it in without having been to the index page

	header('Location: ../index.php');

}
*/





?>









<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Order Form</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="shortcut icon" href="../images/favicon.gif" />

<link href="../css/style.css" rel="stylesheet" type="text/css" />

<!--//////////  FOR USERS WITH INTERNET EXPLORER 6  //////////-->
<!--[if IE 6]>
        <link rel="stylesheet" type="text/css" href="../css/ie6.css" />
<![endif]-->

<style type="text/css">
* { behavior: url(../css/iepngfix.htc) }
</style> 
<!--//////////  FOR USERS WITH INTERNET EXPLORER 6  //////////-->



<script src="../js/jquery-1.3.2.min.js" type="text/javascript"></script>



<script>

      $(document).ready(function(){

    	//This brings back all elements for browsers with javaScript enabled

		$(".hidden-nojs").show();

		$("#js_warning").hide();
		
		/*$("#proof_form").submit(function() {
			$("#accept_proof").attr("disabled", "disabled");
			//alert('This Works!');
			//$('#accept_proof').after('<br /><p>Loading...</p>');
		});*/
		
		/*$('#proof_form').submit(function(){
			$('input[type=submit]', this).attr('disabled', 'disabled');
		});*/
		
		/*$('form#proof_form').submit(function(){
			$(this).children('input[type=submit]').attr('disabled', 'disabled');
			return false;
		});*/


    }); //end document ready

    

    

    function stopRKey(evt) { //disables enter key to submit form

      var evt = (evt) ? evt : ((event) ? event : null);

      var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);

      if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}

    }

    

    document.onkeypress = stopRKey; 

</script>

</head>











<body>







<?php 



//echo 'Done: ' . $done;



include("../includes/connection.php");



$conn = dbConnect("admin"); 







/*INSERT FOR DEV PURPOSES*/

/*$insert_sql = 'INSERT into orders SET

		employee_id = "1111",

		cost_center = "1111",

		approved_by = "zeckdude@gmail.com",

		delivery_bldg = "1111",

		delivery_email = "aaa@aaa.com",

		ext = "1111" ';

		

$conn->query($insert_sql);*/		





//This is needed to view the foreign characters in the DB

//$utf_sql = 'SET NAMES utf8';

//$conn->query($utf_sql); 



$done = false;







//echo '<B>SANITIZED NORMAL VARIABLES</B><br/>';



foreach($_SESSION as $key => $value) {

	if(is_array($value)) continue; //This skips the current session variable if it is an array

	if($key == 'ordering_step') continue; //This skips the current session variable if it is named 'ordering_step'

	//echo '$_SESSION[' .$key . '] = ' . $value . ' - Sanitized<br/>'; //This echoes it out to show it was sanitized

	$_SESSION[$key] = sanitize($conn, $value); //This sanitizes the current session variable and then saves it back as the same session variable name

	

	/*if($key == 'extranumber') { //This checks if the current session variable is named 'extranumber'

		foreach($value as $key2 => $value2) { //This loop runs through the 'extranumber' array

			$_SESSION['extranumber'][$key2] = sanitize($conn, $value2); //This sanitizes the current variable within session[extranumber]

			echo '$_SESSION[extranumber][' . $key2 . '] = ' . $value2 . ' - Sanitized<br/>'; //This echoes it out to show it was sanitized

		}

	}*/

}





	

	

	



if(isset($_POST['accept_proof'])){


	//echo 'The form was submitted!';
	

	nukeMagicQuotes();

	

	$_SESSION['custom_proof_requested'] = 'no';

	$_SESSION['ordering_mode'] = 'on';

	

	if($_SESSION['location'] == 'non_us_address') {

		$_SESSION['non_us_card'] = 'yes';	

	} else if($_SESSION['location'] == 'us_address') {

		$_SESSION['non_us_card'] = 'no';				

	}

	

	$_SESSION['proof_accepted'] = 'yes';



	$date_submitted = date('Y-m-d H:i:s',time()); //Current Date/time in Unix format

	

	$initial_status = 'waiting_approval';

	$initial_character_hold_status = 'no';

	

	if($_SESSION['mail_stop'] == 0) {

		$_SESSION['mail_stop'] = '';	

	}

	
		/**** CODE TO ESCAPE QUOTES ****/
		$strip_fields = array(
			'employee_id', 'approved_by', 'delivery_email', 'full_name', 
			'first_name', 'last_name', 'title', 'title_2', 'dept_div', 
			'dept_div_2', 'email', 'comments', 'special_instructions'
		);
		
		foreach($strip_fields as $key) {
			$_SESSION[$key] = $conn->real_escape_string($_SESSION[$key]);
		}
		/**** CODE TO ESCAPE QUOTES ****/
							

							/*$sql = 'INSERT INTO orders (employee_id, cost_center, approved_by, delivery_bldg, delivery_email, ext, english_quantity, foreign_quantity, language, other_language, foreign_characters_name, foreign_characters_line2, foreign_characters_line3, foreign_characters_line4, email_language_proof, non_us_card, full_name, first_name, last_name, title, title_2, dept_div, dept_div_2, phone_symbol, phone_int_prefix, phone_prefix, phone_first, phone_last, non_us_phone, fax_int_prefix, fax_prefix, fax_first, fax_last, non_us_fax, additional_contact_exists, email, mail_stop, building_id, custom_address, no_address, notepad_size_425x55, notepad_size_55x85, shipping_time_english, shipping_time_foreign, shipping_time_425x55, shipping_time_55x85, rush_needed_by_english, rush_needed_by_foreign, rush_needed_by_425x55, rush_needed_by_55x85, comments, custom_proof_requested, special_instructions, status, date_submitted) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

							

									$stmt = $conn->stmt_init();

							

									if($stmt->prepare($sql)){

							

										$stmt->bind_param('sisssiiissssssssssssssssiiiisiiiisssiisssssssssssssssss', $_SESSION['employee_id'], $_SESSION['cost_center'], $_SESSION['approved_by'], $_SESSION['delivery_bldg'], $_SESSION['delivery_email'], $_SESSION['ext'], $_SESSION['english_only'], $_SESSION['english_w_foreign'], $_SESSION['language'], $_SESSION['other_language'], $_SESSION['foreign_characters_name'], $_SESSION['foreign_characters_line2'], $_SESSION['foreign_characters_line3'], $_SESSION['foreign_characters_line4'], $_SESSION['email_language_proof'], $_SESSION['non_us_card'], $_SESSION['full_name'], $_SESSION['first_name'], $_SESSION['last_name'], $_SESSION['title'], $_SESSION['title_2'], $_SESSION['dept_div'], $_SESSION['dept_div_2'], $_SESSION['phone_symbol'], $_SESSION['phone_int_prefix'], $_SESSION['phone_prefix'], $_SESSION['phone_first'],$_SESSION['phone_last'], $_SESSION['non_us_phone'], $_SESSION['fax_int_prefix'], $_SESSION['fax_prefix'], $_SESSION['fax_first'], $_SESSION['fax_last'], $_SESSION['non_us_fax'], $_SESSION['additional_contact_exists'], $_SESSION['email'], $_SESSION['mail_stop'], $_SESSION['address'], $_SESSION['other_address'], $_SESSION['no_address'], $_SESSION['notepad_size_425x55'], $_SESSION['notepad_size_55x85'], $_SESSION['shipping']['english']['timespan'], $_SESSION['shipping']['foreign']['timespan'], $_SESSION['shipping']['425x55']['timespan'], $_SESSION['shipping']['55x85']['timespan'], $_SESSION['shipping']['english']['rush_date'], $_SESSION['shipping']['foreign']['rush_date'], $_SESSION['shipping']['425x55']['rush_date'], $_SESSION['shipping']['55x85']['rush_date'], $_SESSION['comments'], $_SESSION['custom_proof_requested'], $_SESSION['special_instructions'], $initial_status, $date_submitted);

										$done = $stmt->execute();

									}			

						}

						

						if ($done) {*/

		

		

	$inserted_array = array();

	$_SESSION['order_id'] = array();



	

	

	

	foreach($_SESSION['final_shipping'] as $workdays_key => $workdays_value) { 

		foreach ($workdays_value as $counter_key => $counter_value) { 

			

			$items_per_workdays = count($workdays_value); //This is the number of items that need to be inserted into the DB

			if(!in_array($workdays_key,$inserted_array)) {

				//echo 'There are ' . $items_per_workdays . ' of the ' . $workdays_key . ' selection.<br/>';	

				foreach ($counter_value as $orderitem_key => $orderitem_value) { //an example of $orderitem_key is foreign(the item that is being ordered) 

					//first create basic sql for all necessary information

					$sql = 'INSERT into orders SET

							employee_id = "'.$_SESSION['employee_id'].'",

							cost_center = "'.$_SESSION['cost_center'].'",

							approved_by = "'.$_SESSION['approved_by'].'",

							delivery_bldg = "'.$_SESSION['delivery_bldg'].'",

							delivery_email = "'.$_SESSION['delivery_email'].'",

							ext = "'.$_SESSION['ext'].'",

							non_us_card = "'.$_SESSION['non_us_card'].'",

							full_name = "'.$_SESSION['full_name'].'",

							first_name = "'.$_SESSION['first_name'].'",

							last_name = "'.$_SESSION['last_name'].'",

							title = "'.$_SESSION['title'].'",

							title_2 = "'.$_SESSION['title_2'].'",

							dept_div = "'.$_SESSION['dept_div'].'",

							dept_div_2 = "'.$_SESSION['dept_div_2'].'",

							phone_symbol = "'.$_SESSION['phone_symbol'].'",

							phone_int_prefix = "'.$_SESSION['phone_int_prefix'].'",

							phone_prefix = "'.$_SESSION['phone_prefix'].'",

							phone_first = "'.$_SESSION['phone_first'].'",

							phone_last = "'.$_SESSION['phone_last'].'",

							non_us_phone = "'.$_SESSION['non_us_phone'].'",

							fax_int_prefix = "'.$_SESSION['fax_int_prefix'].'",

							fax_prefix = "'.$_SESSION['fax_prefix'].'",

							fax_first = "'.$_SESSION['fax_first'].'",

							fax_last = "'.$_SESSION['fax_last'].'",

							non_us_fax = "'.$_SESSION['non_us_fax'].'",

							additional_contact_exists = "'.$_SESSION['additional_contact_exists'].'",

							email = "'.$_SESSION['email'].'",

							mail_stop = "'.$_SESSION['mail_stop'].'",

							building_id = "'.$_SESSION['address'].'",

							custom_address = "'.$_SESSION['other_address'].'",

							no_address = "'.$_SESSION['no_address'].'",

							comments = "'.$_SESSION['comments'].'",

							custom_proof_requested = "'.$_SESSION['custom_proof_requested'].'",

							special_instructions = "'.$_SESSION['special_instructions'].'",

							character_hold = "'.$initial_character_hold_status.'",

							status = "'.$initial_status.'",

							date_submitted = "'.$date_submitted.'", ';

							

					if($items_per_workdays > 1) {

						for($i = 1; $i <= $items_per_workdays; $i++) {

							foreach($_SESSION['final_shipping'][$workdays_key][$i] as $order_item_name => $order_item_value) {

								//then create sql for each selection information, like all the english cards, and the notepads

								echo "Order Item Name : " .$order_item_name . "<br/>";

								switch($order_item_name) {

									case "english":

										$sql .= 'english_quantity = "'.$_SESSION['english_only'].'", ';

										$testtype = 'english';

										break;

									

									case "foreign":

										if($_SESSION['language'] != '') { $language = $_SESSION['language']; } elseif($_SESSION['other_language'] != '') { $language = $_SESSION['other_language']; }

									

										$sql .= 'foreign_quantity = "'.$_SESSION['english_w_foreign'].'",												

												language = "'.$language.'",

												other_language = "'.$_SESSION['other_language'].'",

												foreign_characters_name = "'.$_SESSION['foreign_characters_name'].'",

												foreign_characters_line2 = "'.$_SESSION['foreign_characters_line2'].'",

												foreign_characters_line3 = "'.$_SESSION['foreign_characters_line3'].'",

												foreign_characters_line4 = "'.$_SESSION['foreign_characters_line4'].'",

												email_language_proof = "'.$_SESSION['email_language_proof'].'", ';

										$testtype='foreign';

										break;

										

									case "425x55":

										$sql .= 'notepad_size_425x55 = "'.$_SESSION['notepad_size_425x55'].'", ';

										$testtype='425x55';

										break;

										

									case "55x85":

										$sql .= 'notepad_size_55x85 = "'.$_SESSION['notepad_size_55x85'].'", ';

										$testtype = '55x85';

										break;	

								} //end switch

							} //end foreach							

						} //end for

						$sql .= 'shipping_time = "'.$_SESSION['shipping'][$testtype]['timespan'].'",

								rush_date = "'.$_SESSION['shipping'][$testtype]['rush_date'].'"';

						

						

						

						

						//echo 'THIS IS THE RUSH DATE VALUE: ' . $_SESSION['shipping']['foreign']['rush_date'];

						

					} else { //end if

						foreach($_SESSION['final_shipping'][$workdays_key][1] as $order_item_name => $order_item_value) {

							//then create sql for selection information

							$foreign_order = 'no';

							switch($order_item_name) {

								case "english":

									$sql .= 'english_quantity = "'.$_SESSION['english_only'].'",

											shipping_time = "'.$_SESSION['shipping']['english']['timespan'].'",

											rush_date = "'.$_SESSION['shipping']['english']['rush_date'].'" ';

									break;

								

								case "foreign":

								

									if($_SESSION['language'] != '') { $language = $_SESSION['language']; } elseif($_SESSION['other_language'] != '') { $language = $_SESSION['other_language']; }

									

									$sql .= 'foreign_quantity = "'.$_SESSION['english_w_foreign'].'",

											shipping_time = "'.$_SESSION['shipping']['foreign']['timespan'].'",

											rush_date = "'.$_SESSION['shipping']['foreign']['rush_date'].'",

											language = "'.$language.'",

											other_language = "'.$_SESSION['other_language'].'",

											foreign_characters_name = "'.$_SESSION['foreign_characters_name'].'",

											foreign_characters_line2 = "'.$_SESSION['foreign_characters_line2'].'",

											foreign_characters_line3 = "'.$_SESSION['foreign_characters_line3'].'",

											foreign_characters_line4 = "'.$_SESSION['foreign_characters_line4'].'",

											email_language_proof = "'.$_SESSION['email_language_proof'].'" ';

									$foreign_order = 'yes';

									break;

									

								case "425x55":

									$sql .= 'notepad_size_425x55 = "'.$_SESSION['notepad_size_425x55'].'",

											shipping_time = "'.$_SESSION['shipping']['425x55']['timespan'].'",

											rush_date = "'.$_SESSION['shipping']['425x55']['rush_date'].'" ';

									break;

									

								case "55x85":

									$sql .= 'notepad_size_55x85 = "'.$_SESSION['notepad_size_55x85'].'",

											shipping_time = "'.$_SESSION['shipping']['55x85']['timespan'].'",

											rush_date = "'.$_SESSION['shipping']['55x85']['rush_date'].'" ';

									break;	

							} //end switch

							

							

						} //end foreach

						

					} //end else

				} //end foreach

			

				array_push($inserted_array,$workdays_key);

				

				//Run insert query

				//mysqli_query($conn,$sql);

				$conn->query($sql) or die($conn->error);

				

				if($foreign_order == 'yes') {

					$_SESSION['foreign_order_id'] = mysqli_insert_id($conn);	

				}

				

				$_SESSION['rush_date_sql'] = $sql;

				//$link = mysqli_connect('localhost','ideapale_amadmin','amatorders','ideapale_offorders');

				//mysqli_query($link,$sql);

				

				//$_SESSION['order_id'][] = mysqli_insert_id($conn); //This adds the last inserted order id number to the SESSION[order_id] array 

				array_push($_SESSION['order_id'],mysqli_insert_id($conn));

				

				

				

			} //end if

			

			if($mail_sent_for_this_order != 'yes_' . mysqli_insert_id($conn)) { //If the mail has already been sent for the current order

				include("../includes/manager_mail.php"); //file that has the mail function for the mail to the manager

				$mail_sent_for_this_order = 'yes_' . mysqli_insert_id($conn);

			} 

		} //end foreach

	} //end foreach

	

	

	$_SESSION['sql'] = $sql;

	

	//Run any additional insert sql statements and queries for each different kind of shipping selection

	foreach($_SESSION['order_id'] as $orderid_key => $orderid_value) { //$orderid_value is the order id number for the current loop iteration					

		//This is adding any additional contact numbers to the contact_numbers table if the user added additional contact numbers

		

		

		if(isset($_SESSION['contact'])) {

			$stmt = $conn->stmt_init();

			foreach ($_SESSION['contact'] as $counter => $contact_array) { //This specifies the $_SESSION['contact'] array to loop through 

            //echo 'hey marc, look here.<br/>';

            //print_r($_SESSION['extra_number'][$counter]);

            //echo '<br/>';

            if($_SESSION['extra_number'][$counter] == NULL) { break; }

            

            

				foreach ($contact_array as $key => $value) { //This specifies the array within the $_SESSION['contact'] array

					

					//if($value != '') {

						$_SESSION['extra_number'][$counter][$key] = $value;

						

						//echo '<B>SANITIZED EXTRA CONTACT VARIABLES</B><br/>';

						

						//This sanitizes all the values that are about to be inserted(Security)

						foreach($_SESSION['extra_number'][$counter] as $contact_key => $contact_value) {

							if(is_array($contact_value)) continue; 

							$_SESSION['extranumber'][$contact_key] = sanitize($conn, $contact_value); //This sanitizes the current variable within session[extranumber]

							//echo '$_SESSION[extranumber][' . $contact_key . '] = ' . $contact_value . ' - Sanitized<br/>'; //This echoes it out to show it was sanitized	

						}

					

                        

						if(isset($_SESSION['extra_number']) && $_SESSION['extra_number'][$counter]['additional_contact'] != NULL) {

							$contact_sql = 'INSERT INTO contact_numbers (order_id, contact_type, int_prefix, prefix, first, last, non_us_number) VALUES (?, ?, ?, ?, ?, ?, ?)';		

							

							$type = $_SESSION['extra_number'][$counter]['additional_contact'];

							$int_prefix = $_SESSION['extra_number'][$counter]['additional_int_prefix'];

							$prefix = $_SESSION['extra_number'][$counter]['additional_prefix'];

							$first = $_SESSION['extra_number'][$counter]['additional_first'];

							$last = $_SESSION['extra_number'][$counter]['additional_last'];

							$non_us_number = $_SESSION['extra_number'][$counter]['additional_non_us_number'];

							

							

							

							if($stmt->prepare($contact_sql)){

								

								$stmt->bind_param('issssss', $orderid_value, $type, $int_prefix, $prefix, $first, $last, $non_us_number);

							//	$contact_done = $stmt->execute();

							}

						} //end if 

					//}

					

				} //end foreach

					

					$stmt->execute();

			} //end of outer foreach loop

		}//end if session[contact]	

		

		if($_SESSION['location'] == 'us_address') {

			if($_SESSION["other_address"] == 'yes') {

				$custom_address_sql = 'INSERT INTO custom_addresses (order_id, line_1, line_2, city, state, zip_1, zip_2) VALUES (?, ?, ?, ?, ?, ?, ?)';

				

				$line_1 = $_SESSION["custom_address_1"];

				$line_2 = $_SESSION["custom_address_2"];

				$city = $_SESSION["custom_city"];

				$state = $_SESSION["custom_state"];

				$zip_1 = $_SESSION["custom_zip"];

				$zip_2 = $_SESSION["custom_zip_2"];		

				

				$stmt = $conn->stmt_init();			

				if($stmt->prepare($custom_address_sql)){

					$stmt->bind_param('issssss', $orderid_value, $line_1, $line_2, $city, $state, $zip_1, $zip_2);

					$custom_done = $stmt->execute();

				}

			} //end if 

		} //end if location == us_address

		

		if($_SESSION['location'] == 'non_us_address') {

			if($_SESSION["no_address"] == 'no') {

				$custom_address_sql = 'INSERT INTO non_us_addresses (order_id, line_1, line_2, line_3, line_4) VALUES (?, ?, ?, ?, ?)';

				

				$line_1 = $_SESSION["non_us_address_1"];

				$line_2 = $_SESSION["non_us_address_2"];

				$line_3 = $_SESSION["non_us_address_3"];

				$line_4 = $_SESSION["non_us_address_4"];

				

				$stmt = $conn->stmt_init();			

				if($stmt->prepare($custom_address_sql)){

					$stmt->bind_param('issss', $orderid_value, $line_1, $line_2, $line_3, $line_4);

					$custom_done = $stmt->execute();

				}

			} //end if 

		} //end if location == non_us_address

	

	$date_added = date('Y-m-d H:i:s',time());

	

	//This adds the note marking a change in status

	$notes_sql = 'INSERT into notes SET

			order_id = "'.$orderid_value.'",

			date_added = "'.$date_added.'",

			note_message = "'.$note_message['order_started'].'"';

			

	$conn->query($notes_sql);

	

	} //end foreach

	



	

	

	

	

	

 



	if($_SESSION["foreign_cards_ordered"] == "yes") {	

		$date_added = date('Y-m-d H:i:s',time());

		//This adds the note marking a change in status

		$notes_sql = 'INSERT into notes SET

				order_id = "'.$orderid_value.'",

				date_added = "'.$date_added.'",

				note_message = "'.$note_message['waiting_approval'].'"';

				

		$conn->query($notes_sql);

		

		header('Location: upload_foreign.php');

	} else {

		$date_added = date('Y-m-d H:i:s',time());

		//This adds the note marking a change in status

		$notes_sql = 'INSERT into notes SET

				order_id = "'.$orderid_value.'",

				date_added = "'.$date_added.'",

				note_message = "'.$note_message['waiting_approval'].'"';

				

		$conn->query($notes_sql);

		

		header('Location: thankyou.php');

	}

	

						} //end isset accept_proof



	//exit;

	







if(isset($_POST['dont_accept_proof'])){

	header('Location: ../index.php');

	exit;

}



if(isset($_POST['custom_proof'])){

	

	$_SESSION['custom_proof_requested'] = 'yes';

	header('Location: custom_proof.php');	

	exit;

}







?>









<div id="container">





<?php



//echo 'RUSH DATE SQL STATEMENT: ' . $_SESSION['rush_date_sql'];

include("../includes/header.php"); 

include("../includes/js_warning.php");



?>



<div id="card_sample_area">

	<div id="english_card_container"  class="card_container">  

            <div class="row">

            	<div class="clientform_table_header">

                	English Standard Card Setup

                </div>

			</div>   

        

            <div class="row">

            	<div class="content" style="overflow:hidden; position: relative;">

                	<img class="example_card" src="../images/english_card.jpg" />

                    <a class="card_zoom_button" href="<?php echo $site_basedir . 'images/english_card.jpg'; ?>" TARGET="_blank"> +</a>

            	</div>

            </div>

    </div>

    

    <div id="foreign_card_container" class="card_container">  

            <div class="row">

            	<div class="clientform_table_header">

                	Foreign Standard Card Setup(English side)

                </div>

			</div>   

        

            <div class="row">

            	<div class="content" style="overflow:hidden; position: relative;">

                	<img class="example_card" src="../images/foreign_card.jpg" />

                    <a class="card_zoom_button" href="<?php echo $site_basedir . 'images/foreign_card.jpg'; ?>" TARGET="_blank"> +</a>

            	</div>

            </div>

    </div>

</div>







    <div class="form_container" id="pdf_container">  

            <div class="row">

            	<div class="clientform_table_header">

                <?php if($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'yes') { ?>

                	Do you accept these proofs?<br /> <span class="warning">These are previews of what your printed business cards will look like. Please accept or deny the proofs.</span>

                <?php } else if(($_SESSION[foreign_cards_ordered] == 'no' && $_SESSION[english_cards_ordered] == 'yes') || ($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'no')) { ?>

                	Do you accept this proof?<br /> <span class="warning">This is preview of what your printed business card will look like. Please accept or deny the proof.</span>

                <?php } ?>

                </div>

			</div>   

        

            <div class="row">

            	<div class="content" style="overflow:hidden;">

                	<p>

                        <iframe class="iframe" src="pdf.php" width="700px" <?php if($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'yes') { echo 'style="height:55em"';} else if (($_SESSION[foreign_cards_ordered] == 'no' && $_SESSION[english_cards_ordered] == 'yes') || ($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'no')) {echo 'style="height:38em"';}?>>

                        [Your browser does <em>not</em> support <code>iframe</code>,

                        or has been configured not to display inline frames.]</iframe>

                    </p>





                    <p>

                        <form id="proof_form" name="proof_form" method="post" action=""><!-- Begin Form -->

                            <input class="submit prev button" type="submit" name="dont_accept_proof" value="Back to make Changes" />

                            <?php if($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'yes') { ?>

                                <p id="both_proof_desc">These are proofs for your English only and foreign card (English side)</p>

                            <?php } else if($_SESSION[foreign_cards_ordered] == 'no' && $_SESSION[english_cards_ordered] == 'yes') { ?>

                                <p id="english_proof_desc">This is a proof for your English only card</p>

                            <?php } else if($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'no') {?>

                            	<p id="english_proof_desc">This is a proof for your foreign card (English side)</p>

                            <?php } ?>

                            	

                            <input id="accept_proof" class="submit next button" type="submit" name="accept_proof" value="Accept Proof" />

                            <p id="custom_proof_text">Does the proof not look correct?</p>

                            <input id="custom_proof_btn" class="submit button" type="submit" name="custom_proof" value="Request Custom Proof" />

                        </form><!-- End Form -->

                    </p>

            	</div>

            </div>

    </div>  

    

    

    

          

		 

</div>



</body>



</html>