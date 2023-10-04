<?php

session_start();

ob_start();



date_default_timezone_set('America/Los_Angeles');





/*foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop

	//if($value != '') {

		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

	//}

} */

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Order Form</title>

<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />

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



</head>











<body>





<div id="container">





<?php 



if($_SESSION['custom_proof_requested'] != 'yes') {

	header('Location: ../index.php');	

}



include("../includes/connection.php");

$conn = dbConnect("admin");





//This is needed to view the foreign characters in the DB

$utf_sql = 'SET NAMES utf8';

$conn->query($utf_sql); 



$done = false;



/*if(count($_SESSION['contact']) > 0) {



	foreach ($_SESSION['contact'] as $counter => $contact_array) { //This specifies the $_SESSION['order'] array to loop through 

		

		//echo '<br />';

		//echo $counter . ' counter';

		//echo '<br />';

		

		foreach ($contact_array as $key => $value) { //This specifies the array within the $_SESSION['order'] array

			//echo $key . ': ' . $value;

			//echo '<br />';			

			$_SESSION['extra_number'][$counter][$key] = $value;

			//echo $_SESSION['extra_number'][$counter]['additional_contact']; 

		} //end foreach

		

		if(count($contact_array) == 0){

			if(is_array($_SESSION['extra_number'])) {

				foreach($_SESSION['extra_number'] as $session) {

					$_SESSION['extra_number'][$counter] = NULL;

				}				

			}

		}

		//echo '<br />';

	} //end of outer foreach loop

}*/







foreach($_SESSION as $key => $value) {

	if(is_array($value)) continue; //This skips the current session variable if it is an array

	if($key == 'ordering_step') continue; //This skips the current session variable if it is named 'ordering_step'

	//echo '$_SESSION[' .$key . '] = ' . $value . ' - Sanitized<br/>'; //This echoes it out to show it was sanitized

	$_SESSION[$key] = sanitize($conn, $value); //This sanitizes the current session variable and then saves it back as the same session variable name

}













if(isset($_POST['custom_submit'])){ 

	

	if($_POST['special_instructions'] == '') {

		$submit_error = '<p class="error_message" style="margin-top: 10px; font-weight: bold;">Please provide a reason why the proof is not correct and list what needs to be corrected. The order can not continue without this.</p>';

	} else {

	

		$_SESSION['special_instructions'] = $_POST['special_instructions'];

		$_SESSION['custom_proof_requested'] = 'yes';

		

		nukeMagicQuotes();

		

		$_SESSION['ordering_mode'] = 'on';

		

		if($_SESSION['location'] == 'non_us_address') {

			$_SESSION['non_us_card'] = 'yes';	

		} else if($_SESSION['location'] == 'us_address') {

			$_SESSION['non_us_card'] = 'no';				

		}

		

		$_SESSION['proof_accepted'] = 'yes';

	

		$date_submitted = date('Y-m-d H:i:s',time()); //Current Date/time in Unix format

		

		$initial_status = 'custom_proof';

		$initial_character_hold_status = 'no';

	

		$inserted_array = array();

		$_SESSION['order_id'] = array();


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

		foreach($_SESSION['final_shipping'] as $workdays_key => $workdays_value) { 

			foreach ($workdays_value as $counter_key => $counter_value) { 

				

				$items_per_workdays = count($workdays_value); //This is the number of items that need to be inserted into the DB

				if(!in_array($workdays_key,$inserted_array)) {

					//echo 'There are ' . $items_per_workdays . ' of the ' . $workdays_key . ' selection.<br/>';	

					foreach ($counter_value as $orderitem_key => $orderitem_value) { //an example of $orderitem_key is foreign(the item that is being ordered) 

						//first create basic sql for all necessary information
						
						
						
						echo 'This is the Comment: ' . $_SESSION['comments'] . '<br /><br />';
						
						//$_SESSION['special_instructions'] = addslashes($_SESSION['special_instructions']);

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

											$sql .= 'foreign_quantity = "'.$_SESSION['english_w_foreign'].'",												

													language = "'.$_SESSION['language'].'",

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

	

								switch($order_item_name) {

									case "english":

										$sql .= 'english_quantity = "'.$_SESSION['english_only'].'",

												shipping_time = "'.$_SESSION['shipping']['english']['timespan'].'",

												rush_date = "'.$_SESSION['shipping']['english']['rush_date'].'" ';

										break;

									

									case "foreign":

										$sql .= 'foreign_quantity = "'.$_SESSION['english_w_foreign'].'",

												shipping_time = "'.$_SESSION['shipping']['foreign']['timespan'].'",

												rush_date = "'.$_SESSION['shipping']['foreign']['rush_date'].'",

												language = "'.$_SESSION['language'].'",

												other_language = "'.$_SESSION['other_language'].'",

												foreign_characters_name = "'.$_SESSION['foreign_characters_name'].'",

												foreign_characters_line2 = "'.$_SESSION['foreign_characters_line2'].'",

												foreign_characters_line3 = "'.$_SESSION['foreign_characters_line3'].'",

												foreign_characters_line4 = "'.$_SESSION['foreign_characters_line4'].'",

												email_language_proof = "'.$_SESSION['email_language_proof'].'" ';

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

					$conn->query($sql) or die(mysqli_error($conn));

					

					

					//$link = mysqli_connect('localhost','ideapale_amadmin','amatorders','ideapale_offorders');

					//mysqli_query($link,$sql);

					

					//$_SESSION['order_id'][] = mysqli_insert_id($conn); //This adds the last inserted order id number to the SESSION[order_id] array 

					array_push($_SESSION['order_id'],mysqli_insert_id($conn));

					

				} //end if

				

				

				if($mail_sent_for_this_order != 'yes_' . mysqli_insert_id($conn)) { //If the mail has already been sent for the current order

					include("../includes/customproof_notification.php"); //file that has the mail function for the mail to Pro Print to notify them that a custom proof order was made

					//include("../includes/manager_mail.php");

					

					

					$date_added = date('Y-m-d H:i:s',time());

					//This adds the note marking a change in status

					$notes_sql = 'INSERT into notes SET

							order_id = "'.mysqli_insert_id($conn).'",

							date_added = "'.$date_added.'",

							note_message = "'.$note_message['waiting_approval'].'"';

							

					//$conn->query($notes_sql);

		

		

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

		

		

		

		//This adds the note marking a change in status

		$notes_sql = 'INSERT into notes SET

				order_id = "'.$orderid_value.'",

				date_added = "'.$date_added.'",

				note_message = "'.$note_message['custom_proof'].'"';

				

		$conn->query($notes_sql);

		

			

		} //end foreach

		

		

		

		

		

		

		

		

	

		//include("../includes/customproof_notification.php"); //file that has the mail function for the mail to Pro Print to notify them that a custom proof order was made

	 

	

		if($_SESSION["foreign_cards_ordered"] == "yes") {

			header('Location: upload_foreign.php');

		} else {

			header('Location: custom_thankyou.php');

		}

	}

}













include("../includes/header.php"); ?>



    <p class="instructions">This is the Custom Proof Page. Please review all the information for your order. If you want to go back and correct any information, click on 'Back to make changes'. 

    <br /><br />If the information is accurate, but the PDF proof is not appearing as you would like, then please add any specific instructions you have for your order in the box below. 

    <br /><br />Please be aware that custom proofs may take a few days and will therefore affect the shipping date of your order. You will receive your proof at the <b>Delivery Contact Email</b> address you entered.

    </p>

	



    <div class="form_container" id="custom_proof_box">  

        <div class="row">

            <div class="clientform_table_header">Please review the Order<br /><span class="warning">Make sure all information is correct and add any specific directions you have for your card in the comments box below</span></div>   

        </div>

        

        

        <div class="row">

            <div class="content">

                <p><span class="custom_proof_column_1">Employee ID#: </span><?php echo $_SESSION["employee_id"]; ?> </p>

                <p><span class="custom_proof_column_1">Cost Center#: </span><?php echo $_SESSION["cost_center"]; ?> </p>

                <p><span class="custom_proof_column_1">Approving Managers Email: </span><?php echo $_SESSION["approved_by"]; ?> </p>

                <p><span class="custom_proof_column_1">Delivery Building: </span><?php if($_SESSION["delivery_bldg"] != '') {echo $_SESSION["delivery_bldg"];} else {echo 'None Chosen';} ?> </p>

                <p><span class="custom_proof_column_1">Delivery Contact Email: </span><?php echo $_SESSION["delivery_email"]; ?> </p>

                <p><span class="custom_proof_column_1">Delivery Contact Ext.#: </span><?php echo $_SESSION["ext"]; ?> </p>

            </div>

        </div>

        

        <div class="row clearBoth">

            <div class="clientform_table_header">Language Options</span></div>

        </div>

        <div class="row">

            <div class="content">

                <p><span class="custom_proof_column_1">English Only Cards: </span><?php if($_SESSION["english_cards_ordered"] == "yes") {echo $_SESSION["english_only"];} else {echo 'None Chosen';}  ?> </p>

                <p><span class="custom_proof_column_1">Foreign Language Cards: </span><?php if($_SESSION["foreign_cards_ordered"] == "yes") {echo $_SESSION["english_w_foreign"];} else {echo 'None Chosen';}  ?> </p>

                <?php if($_SESSION["foreign_cards_ordered"] == "yes") { ?>

                	<p><span class="custom_proof_column_1">Language: </span><?php if($_SESSION["language"] != '') {echo stripslashes($_SESSION["language"]);} else {echo $_SESSION["other_language"];} ?> </p>

                    <p><span class="custom_proof_column_1">Email to send language proof: </span><?php echo $_SESSION["email_language_proof"]; ?> </p>

                    <?php 

						if($_SESSION["foreign_characters_name"] != '') {echo '<p><span class="custom_proof_column_1">Name(Foreign Characters): </span>' . $_SESSION["foreign_characters_name"] . '</p>';}

						if($_SESSION["foreign_characters_line2"] != '') {echo '<p><span class="custom_proof_column_1">Line 2(Foreign Characters): </span>' . $_SESSION["foreign_characters_line2"] . '</p>';}

						if($_SESSION["foreign_characters_line3"] != '') {echo '<p><span class="custom_proof_column_1">Line 3(Foreign Characters): </span>' . $_SESSION["foreign_characters_line3"] . '</p>';}

						if($_SESSION["foreign_characters_line4"] != '') {echo '<p><span class="custom_proof_column_1">Line 4(Foreign Characters): </span>' . $_SESSION["foreign_characters_line4"] . '</p>';}		

                } ?>    

            </div>

        </div>       

         

        <div class="row clearBoth">

            <div class="clientform_table_header">Card Details</span></div>

        </div>

         <div class="row">

            <div class="content">

                <p><span class="custom_proof_column_1">Full Name: </span><?php echo $_SESSION["full_name"]; ?> </p>

                <p><span class="custom_proof_column_1">Title: </span><?php echo $_SESSION["title"]; ?> </p>

                <?php 

					if($_SESSION["title_2"] != '') { echo '<p><span class="custom_proof_column_1">Secondary Title: </span>' . $_SESSION["title_2"] . '</p>';}

					if($_SESSION["dept_div"] != '') { echo '<p><span class="custom_proof_column_1">Dept. and/or Div: </span>' . $_SESSION["dept_div"] . '</p>';}

					if($_SESSION["dept_div_2"] != '') { echo '<p><span class="custom_proof_column_1">Secondary Dept. and/or Div: </span>' . $_SESSION["dept_div_2"] . '</p>';}

					

					if($_SESSION["location"] == 'us_address') {

						echo '<p><span class="custom_proof_column_1">Phone('.$_SESSION["phone_symbol"].'): </span>'; 

						if($_SESSION["phone_int_prefix"] != '' && $_SESSION["phone_int_prefix"] > 0) { echo $_SESSION["phone_int_prefix"] . '.';} 

						echo $_SESSION["phone_prefix"] . '.' . $_SESSION["phone_first"] . '.' . $_SESSION["phone_last"] . '</p>';

						

						if($_SESSION["fax_prefix"] != '') {

							echo '<p><span class="custom_proof_column_1">Fax: </span>'; 

							if($_SESSION["fax_int_prefix"] != '' && $_SESSION["fax_int_prefix"] > 0) { echo $_SESSION["fax_int_prefix"] . '.';} 

							echo $_SESSION["fax_prefix"] . '.' . $_SESSION["fax_first"] . '.' . $_SESSION["fax_last"] . '</p>';

						}

						

						$counter = 1;

						for($counter = 1; $counter <= 2; $counter++) {

							if($_SESSION['contact'][$counter]['additional_contact'] != '') {

								echo '<p><span class="custom_proof_column_1">Additional Contact Type ' .$counter. ': </span>' . $_SESSION['contact'][$counter]['additional_contact'] . '</p>';

								

								

								echo '<p><span class="custom_proof_column_1">Additional Contact Number ' .$counter. ': </span>';

								if($_SESSION['contact'][$counter]['additional_int_prefix'] != '' && $_SESSION['contact'][$counter]['additional_int_prefix'] > 0) { echo $_SESSION['contact'][$counter]['additional_int_prefix'] . '.';} 

								echo $_SESSION['contact'][$counter]['additional_prefix'] . '.' . $_SESSION['contact'][$counter]['additional_first'] . '.' . $_SESSION['contact'][$counter]['additional_last'] . '</p>';

							}

						}

					} else if($_SESSION["location"] == 'non_us_address') { //end if location == us_address

						echo '<p><span class="custom_proof_column_1">Phone('.$_SESSION["phone_symbol"].'): </span>' . $_SESSION["non_us_phone"] . '</p>';  

						

						if($_SESSION["non_us_fax"] != '') {

							echo '<p><span class="custom_proof_column_1">Fax: </span>' . $_SESSION["non_us_fax"] . '</p>'; 

						}

						

						$counter = 1;

						for($counter = 1; $counter <= 2; $counter++) {

							if($_SESSION['contact'][$counter]['additional_contact'] != '') {

								echo '<p><span class="custom_proof_column_1">Additional Contact Type ' .$counter. ': </span>' . $_SESSION['contact'][$counter]['additional_contact'] . '</p>';

								echo '<p><span class="custom_proof_column_1">Additional Contact Number ' .$counter. ': </span>' . $_SESSION['contact'][$counter]['additional_non_us_number'] . '</p>';	 

							}

						}

					} //end if location == non_us_address

                ?>

                

                <p><span class="custom_proof_column_1">Email: </span><?php echo $_SESSION["email"]; ?> </p>

                <?php 

					if($_SESSION["mail_stop"] != '') { echo '<p><span class="custom_proof_column_1">Mail Stop#: </span>' . $_SESSION["mail_stop"] . '</p>';} 

				

					if($_SESSION["location"] == 'us_address') {

						if($_SESSION['address'] > 0) { //If the address option is chosen

							$sql = "SELECT *

									FROM buildings 

									WHERE building_id = '".$_SESSION['address']."'";

							

							$result = $conn->query($sql) or die(mysqli_error());

									

							while($row = $result->fetch_assoc()) {

								echo '<p><span class="custom_proof_column_1">Address: </span>' . $row['address'] . ', P.O. Box ' . $row['po_box'] . '</span><span class="custom_proof_column_2">' . $row['city'] . ', ' . $row['state']; if($_SESSION['foreign_cards_ordered'] == 'yes') { echo ' USA';} echo ' ' . $row['zip_code'] . '</p>';

							}	

						}

						

						if($_SESSION['no_address'] == 'yes') {

							echo '<p><span class="custom_proof_column_1">Address: </span>None Chosen</p>';

						}

						

						if($_SESSION['other_address'] == 'yes') {

							echo '<p><span class="custom_proof_column_1">Address Line 1: </span>'.$_SESSION["custom_address_1"].'</p>';

							echo '<p><span class="custom_proof_column_1">Address Line 2: </span>'.$_SESSION["custom_address_2"].'</p>';

							echo '<p><span class="custom_proof_column_1">City: </span>'.$_SESSION["custom_city"].'</p>';

							echo '<p><span class="custom_proof_column_1">State: </span>'.$_SESSION["custom_state"].'</p>';

							echo '<p><span class="custom_proof_column_1">Zip Code: </span>'.$_SESSION["custom_zip"]; if($_SESSION["custom_zip_2"] != '') {echo ' - ' . $_SESSION["custom_zip_2"];} echo '</p>';	

						}

					} else if($_SESSION["location"] == 'non_us_address') { //end if location == us_address

						if($_SESSION['no_address'] == 'yes') {

							echo '<p><span class="custom_proof_column_1">Address: </span>None Chosen</p>';

						} else {

							echo '<p><span class="custom_proof_column_1">Address Line 1: </span>'.$_SESSION["non_us_address_1"].'</p>';

							echo '<p><span class="custom_proof_column_1">Address Line 2: </span>'.$_SESSION["non_us_address_2"].'</p>';

							echo '<p><span class="custom_proof_column_1">Address Line 3: </span>'.$_SESSION["non_us_address_3"].'</p>';

							echo '<p><span class="custom_proof_column_1">Address Line 4: </span>'.$_SESSION["non_us_address_4"].'</p>';

						}

					}

				?>

            </div>

        </div>

       

       <?php if($_SESSION["notepad_size_425x55"] != '' || $_SESSION["notepad_size_55x85"] != '') { ?> 

       <div class="row">

            <div class="clientform_table_header">Notepads</span></div>

        </div>

            <div class="row">

                <div class="content">

                	<?php if($_SESSION["notepad_size_425x55"] != '') { ?>

                        <p><span class="custom_proof_column_1">Notepads(4.25 x 5.5): </span><?php echo 'Yes'; ?> </p>

                    <?php } 

						if($_SESSION["notepad_size_55x85"] != '') { ?>

                        	<p><span class="custom_proof_column_1">Notepads(5.5 x 8.5): </span><?php echo 'Yes'; ?> </p>

                    <?php } ?>

                </div>

            </div>

        <?php } ?>

        

        <div class="row clearBoth">

            <div class="clientform_table_header" id="shipping_options_bar">Shipping Options</span></div>

        </div>

        <div class="row">

            <div class="content">

            <?php 

				if($_SESSION["english_cards_ordered"] == "yes") { 

					echo '<div id="proof_shipping_english">';

						echo '<p><span class="custom_proof_column_1">Shipping(English Cards):</span>' . $_SESSION['shipping']['english']['timespan'] . '</p>';

						if($_SESSION['shipping']['english']['timespan'] == '1-3 work days' || $_SESSION['shipping']['english']['timespan'] == '4-8 work days') {

							echo '<p><span class="custom_proof_column_1">Rush Date(English Cards):</span>' . $_SESSION['shipping']['english']['rush_date'] . '</p>';

						}

					echo '</div>';

				}

				

				if($_SESSION["foreign_cards_ordered"] == "yes") { 

					echo '<div id="proof_shipping_foreign">';

						echo '<p><span class="custom_proof_column_1">Shipping(Foreign Cards):</span>' . $_SESSION['shipping']['foreign']['timespan'] . '</p>';

						if($_SESSION['shipping']['foreign']['timespan'] == '1-3 work days' || $_SESSION['shipping']['foreign']['timespan'] == '4-8 work days') {

							echo '<p><span class="custom_proof_column_1">Rush Date(Foreign Cards):</span>' . $_SESSION['shipping']['foreign']['rush_date'] . '</p>';

						}

					echo '</div>';

				}

				

				if($_SESSION["notepad_size_425x55"] == "yes") { 

					echo '<div id="proof_shipping_425x55">';

						echo '<p><span class="custom_proof_column_1">Shipping(4.25 x 5.5 Notepads):</span>' . $_SESSION['shipping']['425x55']['timespan'] . '</p>';

						if($_SESSION['shipping']['425x55']['timespan'] == '1-3 work days' || $_SESSION['shipping']['425x55']['timespan'] == '4-8 work days') {

							echo '<p><span class="custom_proof_column_1">Rush Date(4.25 x 5.5 Notepads):</span>' . $_SESSION['shipping']['425x55']['rush_date'] . '</p>';

						}

					echo '</div>';

				}

				

				if($_SESSION["notepad_size_55x85"] == "yes") { 

					echo '<div id="proof_shipping_55x85">';

						echo '<p><span class="custom_proof_column_1">Shipping(5.5 x 8.5 Notepads):</span>' . $_SESSION['shipping']['55x85']['timespan'] . '</p>';

						if($_SESSION['shipping']['55x85']['timespan'] == '1-3 work days' || $_SESSION['shipping']['55x85']['timespan'] == '4-8 work days') {

							echo '<p><span class="custom_proof_column_1">Rush Date(5.5 x 8.5 Notepads):</span>' . $_SESSION['shipping']['55x85']['rush_date'] . '</p>';

						}

					echo '</div>';

				}

			?>

            </div>

        </div>

        

        <?php if($_SESSION["comments"] != '') { ?>

        	<div class="row clearBoth">

                <div class="clientform_table_header">Comments</span></div>

            </div>

            <div class="row">

                <div class="content">

                    <p><span class="custom_proof_column_1">Comments: </span><span class="custom_proof_column_2"><?php echo stripslashes($_SESSION["comments"]); ?></span></p>

                </div>

            </div>

        <?php } ?>

        

        

        <form id="clientForm" name="clientForm" method="post" action=""><!-- Begin Form -->

        <div class="row clearBoth">

            <div class="clientform_table_header">Special Instructions</span></div>

        </div>

        <div class="row">

            <div class="content">

                <p><span class="custom_proof_column_1">Special Instructions: </span><textarea id="special_instructions" name="special_instructions"></textarea> </p>

                <?php if(isset($submit_error)) {echo $submit_error;} ?>

            </div>

        </div>

        

        <div class="row clearBoth">

            <div class="content" id="thankyou_last_content_1"><a class="button prev" href="../index.php">Back to make Changes</a></div>

          	<div class="content" id="thankyou_last_content_2"><input class="button next" id="custom_submit" type="submit" name="custom_submit" value="Submit Custom Proof Request" style="padding: 5px; height: 25px; margin-top: 0;"/></div>

		</div>

        </form>

    </div> 



</div>



</body>



</html>