<?php 

session_start();

ob_start();













error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);

	include("../includes/connection.php");

	

if(!isset($_SESSION['authenticated_oc'])){

	header('Location: ' . $site_basedir . 'login.php');

	exit;

}

	

	//This creates a database connection. The function that makes this happen is in the conn.inc.php file

	$conn = dbConnect('admin');

	

	$OK = false;

	

	

		//get details of selected record

	 if (isset($_GET['order_id'])) { 

		

		$sql = 'SELECT *

				FROM orders

				LEFT JOIN buildings ON orders.building_id = buildings.building_id

				WHERE order_id = ' . $_GET['order_id'];

				

		$result = $conn->query($sql) or die(mysqli_error());

		$row = $result->fetch_assoc();

		

		$_SESSION['building_id'] = $row['building_id'];

		

		$address_sql = 'SELECT *

						FROM custom_addresses

						WHERE order_id = ' . $_GET['order_id'];

				

		$address_result = $conn->query($address_sql) or die(mysqli_error());

		$address_row = $address_result->fetch_assoc();

		

		

		$nonus_address_sql = 'SELECT *

							  FROM non_us_addresses

							  WHERE order_id = ' . $_GET['order_id'];

				

		$nonus_address_result = $conn->query($nonus_address_sql) or die(mysqli_error());

		$nonus_address_row = $nonus_address_result->fetch_assoc();

		

		

		$contact_sql = 'SELECT *

						FROM contact_numbers 

						WHERE order_id = ' . $_GET['order_id'];

						

		$contact_result = $conn->query($contact_sql) or die(mysqli_error());

		

		

		

		$counter = 1;

										

			while($contact_row = $contact_result->fetch_assoc()) {		

				if($counter == 1) {

					$contact_type_1 = $contact_row['contact_type'];

					$contact_int_prefix_1 = $contact_row['int_prefix'];

					$contact_prefix_1 = $contact_row['prefix'];

					$contact_first_1 = $contact_row['first'];

					$contact_last_1 = $contact_row['last'];

					$contact_non_us_1 = $contact_row['non_us_number'];

				}

				

				if($counter == 2) {

					$contact_type_2 = $contact_row['contact_type'];

					$contact_int_prefix_2 = $contact_row['int_prefix'];

					$contact_prefix_2 = $contact_row['prefix'];

					$contact_first_2 = $contact_row['first'];

					$contact_last_2 = $contact_row['last'];

					$contact_non_us_2 = $contact_row['non_us_number'];

				}

				

				$counter++;

			}

		

		

		//DEBUGGING

		/*foreach($row as $key => $value) {

			echo '$row[' . $key . '] = ' . $value . '<br />';

		} */

	} //end if get order id and !post

	

	

	if(!isset($_GET['card_type'])) {

		if($row['non_us_card'] == 'yes') {

			header('Location: ' . $site_basedir . 'admin/edit_order.php?order_id=' . $_GET['order_id'] . '&card_type=non_us'); //then redirect to this page	

			exit;

		} else {

			header('Location: ' . $site_basedir . 'admin/edit_order.php?order_id=' . $_GET['order_id'] . '&card_type=us'); //then redirect to this page	

			exit;

		}

	}

	

	

	if(!isset($_GET['address_type'])) {

		if($row['no_address'] == 'yes') {

			header('Location: ' . $site_basedir . 'admin/edit_order.php?order_id=' . $_GET['order_id'] . '&card_type=' . $_GET['card_type'] . '&address_type=none'); //then redirect to this page	

			exit;

		} else if($row['custom_address'] == 'yes') {

			header('Location: ' . $site_basedir . 'admin/edit_order.php?order_id=' . $_GET['order_id'] . '&card_type=' . $_GET['card_type'] . '&address_type=custom'); //then redirect to this page

			exit;

		} else {

			header('Location: ' . $site_basedir . 'admin/edit_order.php?order_id=' . $_GET['order_id'] . '&card_type=' . $_GET['card_type'] . '&address_type=normal'); //then redirect to this page	

			exit;

		}

	}

	

	

	//This checks if the pdf was downloaded and if so, updates the status

	if(isset($_POST['edit_order'])) {

		

		foreach($_SESSION as $key => $value) {

			if(is_array($value)) continue; //This skips the current session variable if it is an array

			if($key == 'ordering_step') continue; //This skips the current session variable if it is named 'ordering_step'

			$_SESSION[$key] = sanitize($conn, $value); //This sanitizes the current session variable and then saves it back as the same session variable name

		}

		

		foreach($_POST as $key => $value) {

			$_POST[$key] = sanitize($conn, $value); //This sanitizes the current session variable and then saves it back as the same session variable name

		}

		

	//Series of functions to separate the full name into separate first name, last name, and professional title

	$comma_pos = strpos($_POST['full_name'], ','); //Finds the first occurrence of a comma within the full name

	

	if(!$comma_pos) { //If there is no comma then just separate the First and Last Name into variables

		$last_space_pos = strrpos($_POST['full_name'], ' ');

		$first_name = substr($_POST['full_name'], 0, $last_space_pos);

		$last_name = substr($_POST['full_name'], $last_space_pos+1);

		

	} else{ //If there is a comma then divide the First, Last, and Professional Title into separate variables

		$first_last_name = substr($_POST['full_name'], 0, $comma_pos); //This is the first and last name together

		$pro_title = substr($_POST['full_name'], $comma_pos+1); //This is the professional title

		$last_space_pos = strrpos($first_last_name, ' '); //This is the last occurrence of a space within the first and last name

		$first_name = substr($first_last_name, 0, $last_space_pos); //This is the first name

		$last_name = substr($first_last_name, $last_space_pos+1); //This is the last name

	}

	

	

		

		//prepare update query

		$sql = 'UPDATE orders SET

				status = "'.$_POST['status'].'",

				employee_id = "'.$_POST['employee_id'].'",

				cost_center = "'.$_POST['cost_center'].'",

				approved_by = "'.$_POST['approved_by'].'",

				delivery_bldg = "'.$_POST['delivery_bldg'].'",

				delivery_email = "'.$_POST['delivery_email'].'",

				ext = "'.$_POST['ext'].'",

				full_name = "'.$_POST['full_name'].'",

				first_name = "'.$first_name.'",

				last_name = "'.$last_name.'",

				title = "'.$_POST['title'].'",

				title_2 = "'.$_POST['title_2'].'",

				dept_div = "'.$_POST['dept_div'].'",

				dept_div_2 = "'.$_POST['dept_div_2'].'",

				phone_symbol = "'.$_POST['phone_symbol'].'",

				phone_int_prefix = "'.$_POST['phone_int_prefix'].'",

				phone_prefix = "'.$_POST['phone_prefix'].'",

				phone_first = "'.$_POST['phone_first'].'",

				phone_last = "'.$_POST['phone_last'].'",

				fax_int_prefix = "'.$_POST['fax_int_prefix'].'",

				fax_prefix = "'.$_POST['fax_prefix'].'",

				fax_first = "'.$_POST['fax_first'].'",

				fax_last = "'.$_POST['fax_last'].'",	

				email = "'.$_POST['email'].'",

				mail_stop = "'.$_POST['mail_stop'].'",

				building_id = "'.$_POST['address'].'",

				comments = "'.$_POST['comments'].'",

				shipping_time = "'.$_POST['shipping_time'].'",

				rush_date = "'.$_POST['rush_date'].'",

				english_quantity = "'.$_POST['english_quantity'].'",

				foreign_quantity = "'.$_POST['foreign_quantity'].'",

				language = "'.$_POST['language'].'",

				other_language = "'.$_POST['other_language'].'",

				email_language_proof = "'.$_POST['email_language_proof'].'"

				WHERE order_id = ' . $_GET['order_id'];

		

		$result = $conn->query($sql) or die(mysqli_error($conn));

		$edited = 'yes';

	} //end if get downloaded and get order id

	

	

	// redirect on success or if $_GET['order_id']) is not defined. This ensures that the page is redirected either if the update succeeds or if someone tries to access the page directly.

	if ($edited == 'yes') { //if $_GET['order_id'] is not defined

	

	

	

	

	

	

	

		if($_POST['notepad_size_425x55'] == 'yes') {

			$sql = 'UPDATE orders SET

					notepad_size_425x55 = "yes"

					WHERE order_id = ' . $_GET['order_id'];

		

			$result = $conn->query($sql) or die(mysqli_error());

		} else {

			$sql = 'UPDATE orders SET

					notepad_size_425x55 = "no"

					WHERE order_id = ' . $_GET['order_id'];

		

			$result = $conn->query($sql) or die(mysqli_error());	

		}

		

		if($_POST['notepad_size_55x85'] == 'yes') {

			$sql = 'UPDATE orders SET

					notepad_size_55x85 = "yes"

					WHERE order_id = ' . $_GET['order_id'];

		

			$result = $conn->query($sql) or die(mysqli_error());

		} else {

			$sql = 'UPDATE orders SET

					notepad_size_55x85 = "no"

					WHERE order_id = ' . $_GET['order_id'];

		

			$result = $conn->query($sql) or die(mysqli_error());	

		}

	

	

	

	

	

	

		if($_GET['card_type'] == 'us') {

			

			

			$contact_sql = 'SELECT *

							FROM contact_numbers 

							WHERE order_id = ' . $_GET['order_id'];

						

			$contact_result = $conn->query($contact_sql) or die(mysqli_error());

			

			$sql = 'UPDATE orders SET

					non_us_card = "no"

					WHERE order_id = ' . $_GET['order_id'];

			

			$result = $conn->query($sql) or die(mysqli_error());

			

			

			

			//If Additional Contact Numbers are chosen

			if($_POST['contact_prefix_1'] != '') {

				//Sets Additional Contact Exists to Yes if there are values in the Additional Contact Number Fields

				$sql = 'UPDATE orders SET

						additional_contact_exists = "yes"

						WHERE order_id = ' . $_GET['order_id'];

			

				$result = $conn->query($sql) or die(mysqli_error());

				

				//Deleting all the old contact numbers so we can replace them with the new ones

				$sql = 'DELETE FROM contact_numbers

						WHERE order_id = ' . $_GET['order_id'];

						

				$result = $conn->query($sql) or die(mysqli_error());

				

				//Adding the new Contact Numbers for this order

				$sql = 'INSERT INTO contact_numbers SET

						order_id = "'.$_GET['order_id'].'",

						contact_type = "'.$_POST['contact_type_1'].'",

						int_prefix = "'.$_POST['contact_int_prefix_1'].'",

						prefix = "'.$_POST['contact_prefix_1'].'",

						first = "'.$_POST['contact_first_1'].'",

						last = "'.$_POST['contact_last_1'].'"';

						

				$result = $conn->query($sql) or die(mysqli_error());

			} else {

				$sql = 'UPDATE orders SET

						additional_contact_exists = "no"

						WHERE order_id = ' . $_GET['order_id'];

			

				$result = $conn->query($sql) or die(mysqli_error());

				

				$i = 1;

				while($contact_row = $contact_result->fetch_assoc()) {

					if($i == 1) {

						

						//Deleting all the old contact numbers so we can replace them with the new ones

						$sql = 'DELETE FROM contact_numbers

								WHERE order_id = ' . $_GET['order_id'] . '

								 AND id = ' . $contact_row['id'];

								

						$result = $conn->query($sql) or die(mysqli_error());

					}

					$i++;

				}

			}

			

			

			if($_POST['contact_prefix_2'] != '') {

				

				

				$i = 1;

				while($contact_row = $contact_result->fetch_assoc()) {

					if($i == 2) {					

						//Deleting all the old contact numbers so we can replace them with the new ones

						$sql = 'DELETE FROM contact_numbers

								WHERE order_id = ' . $_GET['order_id'] . '

								 AND id = ' . $contact_row['id'];

								

						$result = $conn->query($sql) or die(mysqli_error());

					}

					$i++;

				}

				

				//Adding the new Contact Numbers for this order

				$sql = 'INSERT INTO contact_numbers SET

						order_id = "'.$_GET['order_id'].'",

						contact_type = "'.$_POST['contact_type_2'].'",

						int_prefix = "'.$_POST['contact_int_prefix_2'].'",

						prefix = "'.$_POST['contact_prefix_2'].'",

						first = "'.$_POST['contact_first_2'].'",

						last = "'.$_POST['contact_last_2'].'"';

						

				$result = $conn->query($sql) or die(mysqli_error());

			} else {

				$i = 1;

				while($contact_row = $contact_result->fetch_assoc()) {

					if($i == 2) {					

						//Deleting all the old contact numbers so we can replace them with the new ones

						$sql = 'DELETE FROM contact_numbers

								WHERE order_id = ' . $_GET['order_id'] . '

								 AND id = ' . $contact_row['id'];

								

						$result = $conn->query($sql) or die(mysqli_error());

					}

					$i++;

				}	

			}

			

			//If a custom address is chosen

			if($_GET['address_type'] == 'custom') {

				

				$sql = 'UPDATE orders SET

						custom_address = "yes",

						building_id = 0

						WHERE order_id = ' . $_GET['order_id'];

			

				$result = $conn->query($sql) or die(mysqli_error());

				

				//Deleting all the old custom address so we can replace it with the new one

				$sql = 'DELETE FROM custom_addresses

						WHERE order_id = ' . $_GET['order_id'];

						

				$result = $conn->query($sql) or die(mysqli_error());

				

				//Adding the new Custom Address for this order

				$sql = 'INSERT INTO custom_addresses SET

						order_id = "'.$_GET['order_id'].'",

						line_1 = "'.$_POST['custom_line_1'].'",

						line_2 = "'.$_POST['custom_line_2'].'",

						city = "'.$_POST['custom_city'].'",

						state = "'.$_POST['custom_state'].'",

						zip_1 = "'.$_POST['custom_zip_1'].'",

						zip_2 = "'.$_POST['custom_zip_2'].'"';

						

				$result = $conn->query($sql) or die(mysqli_error());

				

				

			} else {

				$sql = 'UPDATE orders SET

						custom_address = "no"

						WHERE order_id = ' . $_GET['order_id'];

			

				$result = $conn->query($sql) or die(mysqli_error());	

			}

			

			

			//If a no address is chosen

			if($_GET['address_type'] == 'none') {

				

				$sql = 'UPDATE orders SET

						no_address = "yes",

						building_id = 0

						WHERE order_id = ' . $_GET['order_id'];

			

				$result = $conn->query($sql) or die(mysqli_error());

			} else {

				$sql = 'UPDATE orders SET

						no_address = "no"

						WHERE order_id = ' . $_GET['order_id'];

			

				$result = $conn->query($sql) or die(mysqli_error());	

			}	

		}







		if($_GET['card_type'] == 'non_us') {

			

			$sql = 'UPDATE orders SET

					non_us_card = "yes",

					non_us_phone = "'.$_POST['non_us_phone'].'",

					custom_address = "no",

					building_id = 0,

					non_us_fax = "'.$_POST['non_us_fax'].'"

					WHERE order_id = ' . $_GET['order_id'];

		

			$result = $conn->query($sql) or die(mysqli_error());

			

			//If Additional Contact Numbers are chosen

			if($_POST['non_us_contact_1'] != '') {

				//Sets Additional Contact Exists to Yes if there are values in the Additional Contact Number Fields

				$sql = 'UPDATE orders SET

						additional_contact_exists = "yes"

						WHERE order_id = ' . $_GET['order_id'];

			

				$result = $conn->query($sql) or die(mysqli_error());

				

				//Deleting all the old contact numbers so we can replace them with the new ones

				$sql = 'DELETE FROM contact_numbers

						WHERE order_id = ' . $_GET['order_id'];

						

				$result = $conn->query($sql) or die(mysqli_error());

				

				//Adding the new Contact Numbers for this order

				$sql = 'INSERT INTO contact_numbers SET

						order_id = "'.$_GET['order_id'].'",

						contact_type = "'.$_POST['contact_type_1'].'",

						non_us_number = "'.$_POST['non_us_contact_1'].'"';

						

				$result = $conn->query($sql) or die(mysqli_error());

			} else {

				$sql = 'UPDATE orders SET

						additional_contact_exists = "no"

						WHERE order_id = ' . $_GET['order_id'];

			

				$result = $conn->query($sql) or die(mysqli_error());

			}

			

			

			if($_POST['non_us_contact_2'] != '') {

				//Adding the new Contact Numbers for this order

				$sql = 'INSERT INTO contact_numbers SET

						order_id = "'.$_GET['order_id'].'",

						contact_type = "'.$_POST['contact_type_2'].'",

						non_us_number = "'.$_POST['non_us_contact_2'].'"';

						

				$result = $conn->query($sql) or die(mysqli_error());

			}

			

			//If a no address is chosen

			if($_GET['address_type'] == 'normal' || $_GET['address_type'] == 'custom') {

				

				//Deleting all the old custom address so we can replace it with the new one

				$sql = 'DELETE FROM non_us_addresses

						WHERE order_id = ' . $_GET['order_id'];

						

				$result = $conn->query($sql) or die(mysqli_error());

				

				//Adding the new Custom Address for this order

				$sql = 'INSERT INTO non_us_addresses SET

						order_id = "'.$_GET['order_id'].'",

						line_1 = "'.$_POST['nonus_1'].'",

						line_2 = "'.$_POST['nonus_2'].'",

						line_3 = "'.$_POST['nonus_3'].'",

						line_4 = "'.$_POST['nonus_4'].'"';

						

				$_SESSION['non_us_sql'] = $sql;

				$result = $conn->query($sql) or die(mysqli_error());

			} 

			

			

			//If a no address is chosen

			if($_GET['address_type'] == 'none') {

				

				$sql = 'UPDATE orders SET

						no_address = "yes",

						building_id = 0

						WHERE order_id = ' . $_GET['order_id'];

			

				$result = $conn->query($sql) or die(mysqli_error());

			} else {

				$sql = 'UPDATE orders SET

						no_address = "no"

						WHERE order_id = ' . $_GET['order_id'];

			

				$result = $conn->query($sql) or die(mysqli_error());	

			}

		}




		//This adds the History
		//Note to be added that something was edited and what it was

		$note_message = '';

		$field_edited = array();

		

		function add_note_line($before_value, $after_value, $field_name) {

			if($after_value != $before_value) { //If the value has been changed

				global $field_edited;

				global $note_message;

				

				if($before_value == '') {

					$before_value = 'No Value';	

				}

				

				if($after_value == '') {

					$after_value = 'No Value';	

				}

				

				if($after_value != '0') {

					$note_message .= '<b>' . $field_name . ':</b> <i>' . $before_value . '</i> to <i>' . $after_value . '</i><br />';	//Then add a line to the note

					$field_edited['status'] = "yes";

				}

			}	

		}





		switch ($row['status']) {

			case "not_approved":

				$status_row = "Not Approved";

				break;

			case "waiting_approval":

				$status_row = "Waiting for manager approval";

				break;

			case "approved":

				$status_row = "Approved";

				break;

			case "printing":

				$status_row = "Ready for print";

				break;

			case "waiting_delivery":

				$status_row = "Waiting for delivery";

				break;

			case "delivered":

				$status_row = "Delivered";

				break;

			case "billed":

				$status_row = "Billed";

				break;

			case "waiting_translator":

				$status_row = "Waiting for translator";

				break;

			case "waiting_trans_approval":

				$status_row = "Waiting for translation approval";

				break;

			case "custom_proof":

				$status_row = "Custom proof requested";

				break;

			case "waiting_custom_approval":

				$status_row = "Waiting for custom proof approval";

				break;

			case "in_print":

				$status_row = "In Print";

				break;

			case "waiting_corrections":

				$status_row = "Waiting for Corrections";

				break;

			case "waiting_upload":

				$status_row = "Waiting for foreign characters";

				break;

		}

		

		switch ($_POST['status']) {

			case "not_approved":

				$status_post = "Not Approved";

				break;

			case "waiting_approval":

				$status_post = "Waiting for manager approval";

				break;

			case "approved":

				$status_post = "Approved";

				break;

			case "printing":

				$status_post = "Ready for print";

				break;

			case "waiting_delivery":

				$status_post = "Waiting for delivery";

				break;

			case "delivered":

				$status_post = "Delivered";

				break;

			case "billed":

				$status_post = "Billed";

				break;

			case "waiting_translator":

				$status_post = "Waiting for translator";

				break;

			case "waiting_trans_approval":

				$status_post = "Waiting for translation approval";

				break;

			case "custom_proof":

				$status_post = "Custom proof requested";

				break;

			case "waiting_custom_approval":

				$status_post = "Waiting for custom proof approval";

				break;

			case "in_print":

				$status_post = "In Print";

				break;

			case "waiting_corrections":

				$status_post = "Waiting for Corrections";

				break;

			case "waiting_upload":

				$status_post = "Waiting for foreign characters";

				break;

		}



		add_note_line($status_row, $status_post, 'Status');

		add_note_line($row['employee_id'], $_POST['employee_id'], 'Employee ID');

		add_note_line($row['cost_center'], $_POST['cost_center'], 'Cost Center');

		add_note_line($row['approved_by'], $_POST['approved_by'], 'Approved by');

		add_note_line($row['delivery_bldg'], $_POST['delivery_bldg'], 'Delivery Bldg');

		add_note_line($row['delivery_email'], $_POST['delivery_email'], 'Delivery Email');

		add_note_line($row['ext'], $_POST['ext'], 'Delivery Ext');

		

		add_note_line($row['shipping_time'], $_POST['shipping_time'], 'Shipping Time');

		add_note_line($row['rush_date'], $_POST['rush_date'], 'Rush Date');

		add_note_line($row['english_quantity'], $_POST['english_quantity'], 'English only Quantity');

		add_note_line($row['foreign_quantity'], $_POST['foreign_quantity'], 'Foreign Quantity');

		

		add_note_line($row['language'], $_POST['language'], 'Language');

		add_note_line($row['other_language'], $_POST['other_language'], 'Other Language');

		add_note_line($row['email_language_proof'], $_POST['email_language_proof'], 'Email Language Proof to');

		

		add_note_line($row['full_name'], $_POST['full_name'], 'Name');

		add_note_line($row['title'], $_POST['title'], 'Title');

		add_note_line($row['title_2'], $_POST['title_2'], 'Title 2');

		add_note_line($row['dept_div'], $_POST['dept_div'], 'Dept/Div');

		add_note_line($row['dept_div_2'], $_POST['dept_div_2'], 'Dept/Div 2');

		

		//US Card type

		//This checks if the card is a us address

		if($_GET['card_type'] == 'us') {

			

			//This adds a note if it is changed to non-US address from US address

			if($row['non_us_card'] == 'yes') {

				$note_message .= '<b>Card Type:</b> Changed to US<br />';

				$field_edited['status'] = "yes";

			}

		

			add_note_line($row['phone_symbol'], $_POST['phone_symbol'], 'Phone Symbol');

	

			//US Phone

			if($_POST['phone_int_prefix'] != $row['phone_int_prefix'] || $_POST['phone_prefix'] != $row['phone_prefix'] || $_POST['phone_first'] != $row['phone_first'] || $_POST['phone_last'] != $row['phone_last']) { //If the value has been changed

				if($row['phone_int_prefix'] > 0) {

					$row_prefix = $row['phone_int_prefix'] . '.';	

				}

				

				if($_POST['phone_int_prefix'] > 0) {

					$post_prefix = $_POST['phone_int_prefix'] . '.';	

				}

				

				$note_message .= '<b>US Phone:</b> ' . $row_prefix.$row['phone_prefix'].'.'.$row['phone_first'].'.'.$row['phone_last'] . ' to ' . $post_prefix.$_POST['phone_prefix'].'.'.$_POST['phone_first'].'.'.$_POST['phone_last'] . '<br />';	//Then add a line to the note

				$field_edited['status'] = "yes";

			}

			

			//US Fax

			if($_POST['fax_int_prefix'] != $row['fax_int_prefix'] || $_POST['fax_prefix'] != $row['fax_prefix'] || $_POST['fax_first'] != $row['fax_first'] || $_POST['fax_last'] != $row['fax_last']) { //If the value has been changed

				if($row['fax_int_prefix'] > 0) {

					$row_prefix = $row['fax_int_prefix'] . '.';	

				}

				

				if($_POST['fax_int_prefix'] > 0) {

					$post_prefix = $_POST['fax_int_prefix'] . '.';	

				}

				

				if($_row['fax_prefix'] == '' && $_POST['fax_prefix'] != '') {

					$note_message .= '<b>US Fax:</b> No Value to ' . $post_prefix.$_POST['fax_prefix'].'.'.$_POST['fax_first'].'.'.$_POST['fax_last'] . '<br />';

				} else if($_row['fax_prefix'] != '' && $_POST['fax_prefix'] == '') {

					$note_message .= '<b>US Fax:</b> ' . $row_prefix.$row['fax_prefix'].'.'.$row['fax_first'].'.'.$row['fax_last'] . ' to No Value<br />';

				} else {

					$note_message .= '<b>US Fax:</b> ' . $row_prefix.$row['fax_prefix'].'.'.$row['fax_first'].'.'.$row['fax_last'] . ' to ' . $post_prefix.$_POST['fax_prefix'].'.'.$_POST['fax_first'].'.'.$_POST['fax_last'] . '<br />';	//Then add a line to the note

				}

				$field_edited['status'] = "yes";

			}

			

			//Additional Contact 1

			if($_POST['contact_type_1'] != $contact_type_1) {

				if($contact_type_1 == '' && $_POST['contact_type_1'] != '') { //Going from Value to No Value

					$note_message .= '<b>Additional Contact 1 Type:</b> No Value to ' . $_POST['contact_type_1'] . '<br />';

				} else if($contact_type_1 != '' && $_POST['contact_type_1'] == '') { //Going from No Value to Value

					$note_message .= '<b>Additional Contact 1 Type:</b> '.$contact_type_1.' to No Value<br />';

				} else {

					$note_message .= '<b>Additional Contact 1 Type:</b> '.$contact_type_1.' to ' . $_POST['contact_type_1'] . '<br />';	

				}

				

				$field_edited['status'] = "yes";

			}

			

			if($_POST['contact_int_prefix_1'] != $contact_int_prefix_1 || $_POST['contact_prefix_1'] != $contact_prefix_1 || $_POST['contact_first_1'] != $contact_first_1 || $_POST['contact_last_1'] != $contact_last_1) { //If the value has been changed

				if($contact_int_prefix_1 != '') {

					$row_prefix = $contact_int_prefix_1 . '.';	

				}

				

				if($_POST['contact_int_prefix_1'] != '') {

					$post_prefix = $_POST['contact_int_prefix_1'] . '.';	

				}

				

				if($contact_prefix_1 == '' && $_POST['contact_prefix_1'] != '') { //Going from No Value to Value

					$note_message .= '<b>US Additional Contact 1:</b> No Value to ' . $post_prefix.$_POST['contact_prefix_1'].'.'.$_POST['contact_first_1'].'.'.$_POST['contact_last_1'] . '<br />';

				} else if($contact_prefix_1 != '' && $_POST['contact_prefix_1'] == '') { //Going from Value to No Value

					$note_message .= '<b>US Additional Contact 1:</b> ' . $row_prefix.$contact_prefix_1.'.'.$contact_first_1.'.'.$contact_last_1 . ' to No Value<br />';

				} else { //Going from Value to Value

					$note_message .= '<b>US Additional Contact 1:</b> ' . $row_prefix.$contact_prefix_1.'.'.$contact_first_1.'.'.$contact_last_1 . ' to ' . $post_prefix.$_POST['contact_prefix_1'].'.'.$_POST['contact_first_1'].'.'.$_POST['contact_last_1'] . '<br />';	//Then add a line to the note

				}

				$field_edited['status'] = "yes";

			}

			

			

			//Additional Contact 2

			if($_POST['contact_type_2'] != $contact_type_2) {

				if($contact_type_2 == '' && $_POST['contact_type_2'] != '') { //Going from Value to No Value

					$note_message .= '<b>Additional Contact 2 Type:</b> No Value to ' . $_POST['contact_type_2'] . '<br />';

				} else if($contact_type_2 != '' && $_POST['contact_type_2'] == '') { //Going from No Value to Value

					$note_message .= '<b>Additional Contact 2 Type:</b> '.$contact_type_2.' to No Value<br />';

				} else {

					$note_message .= '<b>Additional Contact 2 Type:</b> '.$contact_type_2.' to ' . $_POST['contact_type_2'] . '<br />';	

				}

				

				$field_edited['status'] = "yes";

			}

			

			if($_POST['contact_int_prefix_2'] != $contact_int_prefix_2 || $_POST['contact_prefix_2'] != $contact_prefix_2 || $_POST['contact_first_2'] != $contact_first_2 || $_POST['contact_last_2'] != $contact_last_2) { //If the value has been changed

				if($contact_int_prefix_2 > 0) {

					$row_prefix = $contact_int_prefix_2 . '.';	

				}

				

				if($_POST['contact_int_prefix_2'] > 0) {

					$post_prefix = $_POST['contact_int_prefix_2'] . '.';	

				}

				

				if($contact_prefix_2 == '' && $_POST['contact_prefix_2'] != '') { //Going from No Value to Value

					$note_message .= '<b>US Additional Contact 2:</b> No Value to ' . $post_prefix.$_POST['contact_prefix_2'].'.'.$_POST['contact_first_2'].'.'.$_POST['contact_last_2'] . '<br />';

				} else if($contact_prefix_2 != '' && $_POST['contact_prefix_2'] == '') { //Going from Value to No Value

					$note_message .= '<b>US Additional Contact 2:</b> ' . $row_prefix.$contact_prefix_2.'.'.$contact_first_2.'.'.$contact_last_2 . ' to No Value<br />';

				} else { //Going from Value to Value

					$note_message .= '<b>US Additional Contact 2:</b> ' . $row_prefix.$contact_prefix_2.'.'.$contact_first_2.'.'.$contact_last_2 . ' to ' . $post_prefix.$_POST['contact_prefix_2'].'.'.$_POST['contact_first_2'].'.'.$_POST['contact_last_2'] . '<br />';	//Then add a line to the note

				}

				$field_edited['status'] = "yes";

			}

		

		

		

		

			//This adds a note if the address is changed

			if($_GET['address_type'] == 'normal') {

			

				if($_SESSION['building_id'] == '' || $_SESSION['building_id'] < 1) {

					if($row['no_address'] == 'yes') {

						$before_address = 'No Address';

					} else if($row['no_address'] == 'no') {

						$before_address = 'Custom Address';	

					}

				} else {		

					$building_sql = "SELECT *

									FROM buildings 

									WHERE building_id = " . $_SESSION['building_id'];

				

					$building_result = $conn->query($building_sql) or die(mysqli_error($conn));

					$building_row = $building_result->fetch_assoc();

				

					$before_address = $building_row['address'];

				}

				

				$building_sql = "SELECT *

								FROM buildings 

								WHERE building_id = " . $_POST['address'];

						

				$building_result = $conn->query($building_sql) or die(mysqli_error());

				$building_row = $building_result->fetch_assoc();

				

				$after_address = $building_row['address'];

				

				add_note_line($before_address, $after_address, 'Address');

			}

		

		

			//This adds a note if it is changed to custom address

			if($row['custom_address'] != 'yes' && $_GET['address_type'] == 'custom') {

				$note_message .= '<b>Address Type:</b> Changed to Custom Address<br />';

				$field_edited['status'] = "yes";

			}

			

			if($_GET['address_type'] == 'custom') { 

				add_note_line($address_row['line_1'], $_POST['custom_line_1'], 'Custom Address Line 1');

				add_note_line($address_row['line_2'], $_POST['custom_line_2'], 'Custom Address Line 2');

				add_note_line($address_row['city'], $_POST['custom_city'], 'Custom Address City');

				add_note_line($address_row['state'], $_POST['custom_state'], 'Custom Address State');

				add_note_line($address_row['zip_1'], $_POST['custom_zip_1'], 'Custom Address Zip 1');

				add_note_line($address_row['zip_2'], $_POST['custom_zip_2'], 'Custom Address Zip 2');

			}

		}

		

		

		//This checks if the card is a non-us address

		if($_GET['card_type'] == 'non_us') {

			

			//This adds a note if it is changed to non-US address from US address

			if($row['non_us_card'] != 'yes') {

				$note_message .= '<b>Card Type:</b> Changed to Non-US<br />';

				$field_edited['status'] = "yes";

			}

			

			add_note_line($row['phone_symbol'], $_POST['phone_symbol'], 'Phone Symbol');

			add_note_line($row['non_us_phone'], $_POST['non_us_phone'], 'Non-US Phone');

			add_note_line($row['non_us_fax'], $_POST['non_us_fax'], 'Non-US Fax');

			

			//Additional Contact 1

			if($_POST['contact_type_1'] != $contact_type_1) {

				if($contact_type_1 == '' && $_POST['contact_type_1'] != '') { //Going from Value to No Value

					$note_message .= '<b>Additional Contact 1 Type:</b> No Value to ' . $_POST['contact_type_1'] . '<br />';

				} else if($contact_type_1 != '' && $_POST['contact_type_1'] == '') { //Going from No Value to Value

					$note_message .= '<b>Additional Contact 1 Type:</b> '.$contact_type_1.' to No Value<br />';

				} else {

					$note_message .= '<b>Additional Contact 1 Type:</b> '.$contact_type_1.' to ' . $_POST['contact_type_1'] . '<br />';	

				}

				

				$field_edited['status'] = "yes";

			}

			

			add_note_line($contact_non_us_1, $_POST['non_us_contact_1'], 'Non-US Addit. Contact 1');

			

			

			//Additional Contact 2

			if($_POST['contact_type_2'] != $contact_type_2) {

				if($contact_type_2 == '' && $_POST['contact_type_2'] != '') { //Going from Value to No Value

					$note_message .= '<b>Additional Contact 2 Type:</b> No Value to ' . $_POST['contact_type_2'] . '<br />';

				} else if($contact_type_2 != '' && $_POST['contact_type_2'] == '') { //Going from No Value to Value

					$note_message .= '<b>Additional Contact 2 Type:</b> '.$contact_type_2.' to No Value<br />';

				} else {

					$note_message .= '<b>Additional Contact 2 Type:</b> '.$contact_type_2.' to ' . $_POST['contact_type_2'] . '<br />';	

				}

				

				$field_edited['status'] = "yes";

			}

			

			add_note_line($contact_non_us_2, $_POST['non_us_contact_2'], 'Non-US Addit. Contact 2');

			

			

			if($_GET['address_type'] == 'custom' || $_GET['address_type'] == 'normal') {

				add_note_line($nonus_address_row['line_1'], $_POST['nonus_1'], 'Non-US Address Line 1');

				add_note_line($nonus_address_row['line_2'], $_POST['nonus_2'], 'Non-US Address Line 2');

				add_note_line($nonus_address_row['line_3'], $_POST['nonus_3'], 'Non-US Address Line 3');

				add_note_line($nonus_address_row['line_4'], $_POST['nonus_4'], 'Non-US Address Line 4');

			}

		}



		

		

		

		

		

		

		

		

		

		add_note_line($row['email'], $_POST['email'], 'Email');

		

		//This adds a note if it is changed to no address

		if($row['no_address'] != 'yes' && $_GET['address_type'] == 'none') {

			$note_message .= '<b>Address Type:</b> Changed to No Address<br />';

			$field_edited['status'] = "yes";

		}

		

		

		add_note_line($row['mail_stop'], $_POST['mail_stop'], 'Mail Stop');

		

		//This adds a note if the notepad(4.25x5.5) option is changed

		if($_POST['notepad_size_425x55'] != $row['notepad_size_425x55']) { //If the value has been changed



			if($_POST['notepad_size_425x55'] == 0 || $_POST['notepad_size_425x55'] == '') {

				if($row['notepad_size_425x55'] == 'yes') {

					$note_message .= '<b>Notepad(4.25x5.5):</b> Yes to No<br />';	//Then add a line to the note	

				} 

			}

			

			if($row['notepad_size_425x55'] == 0 || $row['notepad_size_425x55'] == '') {

				if($_POST['notepad_size_425x55'] == 'yes') {

					$note_message .= '<b>Notepad(4.25x5.5):</b> No to Yes<br />';	//Then add a line to the note	

				}

			}

			

			$field_edited['status'] = "yes";

		}	

		

		//This adds a note if the notepad(5.5x8.5) option is changed

		if($_POST['notepad_size_55x85'] != $row['notepad_size_55x85']) { //If the value has been changed



			if($_POST['notepad_size_55x85'] == 0 || $_POST['notepad_size_55x85'] == '') {

				if($row['notepad_size_55x85'] == 'yes') {

					$note_message .= '<b>Notepad(5.5x8.5):</b> Yes to No<br />';	//Then add a line to the note	

				} 

			}

			

			if($row['notepad_size_55x85'] == 0 || $row['notepad_size_55x85'] == '') {

				if($_POST['notepad_size_55x85'] == 'yes') {

					$note_message .= '<b>Notepad(5.5x8.5):</b> No to Yes<br />';	//Then add a line to the note	

				}

			}

			

			$field_edited['status'] = "yes";

		}

		

		

		//This adds a note if the notepad(5.5x8.5) option is changed

		if($_POST['comments'] != $row['comments']) { //If the value has been changed

			if($row['comments'] == '') {

				$row['comments'] = 'No Value';	

			}

			

			if($_POST['comments'] == '') {

				$_POST['comments'] = 'No Value';	

			}

			

			if($_POST['comments'] != '0') {

				$note_message .= '<b>Comments:</b> ' . $row['comments'] . ' to ' . $_POST['comments'] . '<br />';	//Then add a line to the note

				$field_edited['status'] = "yes";

			}

		}





	

		if(in_array("yes", $field_edited)) {

			$order_edited = 'yes';

		}



		//print_r($field_edited);

		

		if($order_edited == 'yes') { //If there is no error, then add the note

		

			//echo '<br /><br /><br /><br /><br /><br />It got to adding note area';

			$date_added = date('Y-m-d H:i:s',time());

			$note_message = addslashes($note_message);

			//This adds the note marking a change in status		

			$notes_sql = 'INSERT into notes SET

					order_id = "'.$_GET['order_id'].'",

					date_added = "'.$date_added.'",

					note_message = "The order was manually edited:<br />'.$note_message.'"';

			$_SESSION['sql'] = 'The Notes SQL Statement reads: ' . $notes_sql;

			$notes_result = $conn->query($notes_sql) or die(mysqli_error($conn));

		}









		//echo 'Notepad Post: ' . $_POST['notepad_size_425x55'];















		header('Location: ' . $site_basedir . 'admin/tracker.php'); //then redirect to this page

		exit; //and exit the script	

	}

	

	//display error message if query fails

	if (isset($stmt) && !$OK && !$done) { //if the prepared statement has been created, but both $OK and $done remain false 

		echo $stmt->error;	// then display an error message on the screen

	}

	

	$current_timestamp = time();

	

?> 





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $site_name; ?></title>

<link href="../css/style.css" rel="stylesheet" type="text/css" />

<link rel="shortcut icon" href="../images/favicon.gif" />

<link rel="stylesheet" href="../css/jquery.datepick.css" type="text/css" media="screen" charset="utf-8" />



<style type="text/css">

	#tracker_table { border-collapse:collapse; width: 1034px;}

	#tracker_table h4 { margin:0px; padding:0px; font-size: 14px; text-decoration: underline;}

	#tracker_table img { float:right;}

	#tracker_table ul { margin:10px 0 10px 40px; padding:0px;}

	#tracker_table th { background:#375D81 url(header_bkg.png) repeat-x scroll center left; color:#fff; padding:7px 15px; text-align:left;}

	#tracker_table td { background:#E0E9EF none repeat-x scroll center left; padding:7px 15px; width: 382px; }

	#tracker_table tr.odd td { background:#fff url(row_bkg.png) repeat-x scroll center left; vertical-align: top; }

	#tracker_table div.arrow { background:transparent url(../images/arrows.png) no-repeat scroll 0px -16px; width:16px; height:16px; display:block;}

	#tracker_table div.up { background-position:0px 0px;}

	

	.detail_text {

		width: 201px;	

	}

	

	.text #left_column {

		top: 0px;

		width: 300px;

	}

	

	

	img.datepick-trigger {

		margin: 0;

		left: -58px;

		top: 2px;

	}

	

	#contact_int_prefix {

		width: 15px;	

	}

	

	

	#tracker_table tr#master:hover {

		cursor: auto;	

	}

	

	#card_change_link {

		width: 179px;

		position: relative;

		left: 28px;

		margin-top: 10px;

	}

	

	#card_change_link a, #address_change_link a {

		color: #322328;

	}

	

	#card_change_link span, #address_change_link span {

		font-size: 11px;

		font-weight: normal;

	}

	

	#address_change_link {

		width: 179px;

		position: relative;

		left: 111px;

		margin-top: -1px;

	}

	

	#no_address_text {

		font-size: 12px;

		width: 235px;

	}

</style>



<script src="../js/jquery-1.3.2.min.js" type="text/javascript"></script>

<script src="../js/jquery.datepick.js" type="text/javascript"> //This is the datepicker</script> 





<script type="text/javascript">

	var newDateConverted = new Date(<?php echo $current_timestamp; ?> * 1000); //This is the date object in the datepick.js file. That is why it is placed above the file.

</script>



<script type="text/javascript">

	$(document).ready(function(){

		$("#rush_date").datepick({	//Default values for the datepicker

			showOn: 'both', //This is the trigger for when to show the datepicker. Both for both on focus and on button push

			buttonImageOnly: true, //This indicates whether or not the image should appear by itself(true) or on a button(false)

			buttonImage: '../images/calendar-blue.gif', //Location of the image for the Calendar Button

			beforeShowDay: $.datepick.noWeekends, //This controls what each day being displayed does, whether it is selectable or not. noWeeekends makes the weekends not selectable

			hideIfNoPrevNext: true // True to hide next/previous month links

		});					   						   

	}); //end document ready						





</script>









</head>



<body>





<div id="container">

			

           <?php include("../includes/admin_header.php"); ?> 



            <table id="tracker_table" class="clientform_table text">

            

            <tr>

            

               <th colspan="1" style="width: 340px;">Edit Order #<?php echo $row['order_id']; ?> - <?php echo $row['first_name'] . ' ' . $row['last_name']; ?></th>

               <th colspan="1"> </th>         

            </tr>

            

				<form id="editForm" name="editForm" method="post" action=""><!-- Begin Form -->

                    <tr id="master" class="odd">

                        <td colspan="1">

                        	<span id="left_column">

                            

                            <h4>Order Status</h4>

                            <ul>

                                <li><span class="detail_title">Status: </span>

                                	<span class="detail_text">

                                        <select id="status" name="status">

                                            <option value="not_approved" <?php if($row['status'] == 'not_approved') { echo 'selected';} ?>>Not approved</option>

                                            <option value="waiting_approval" <?php if($row['status'] == 'waiting_approval') { echo 'selected';} ?>>Waiting for approval</option>

                                            <option value="approved" <?php if($row['status'] == 'approved') { echo 'selected';} ?>>Approved</option>

                                            <option value="waiting_translator" <?php if($row['status'] == "waiting_translator") { echo 'selected';} ?>>Waiting for Translator</option>

                                            <option value="waiting_trans_approval" <?php if($row['status'] == "waiting_trans_approval") { echo 'selected';} ?>>Waiting for Translation Approval</option>

                                            <option value="custom_proof" <?php if($row['status'] == "custom_proof") { echo 'selected';} ?>>Waiting for Custom Proof Upload</option>

                                            <option value="waiting_custom_approval" <?php if($row['status'] == "waiting_custom_approval") { echo 'selected';} ?>>Waiting for Custom Proof Approval</option>   

                                            <option value="waiting_corrections" <?php if($row['status'] == "waiting_corrections") { echo 'selected';} ?>>Waiting for Pro Print Corrections</option>   

                                            <option value="printing" <?php if($row['status'] == 'printing') { echo 'selected';} ?>>In Print</option>

                                            <option value="waiting_delivery" <?php if($row['status'] == "waiting_delivery") { echo 'selected';} ?>>Waiting for Delivery</option>

                                            <option value="delivered" <?php if($row['status'] == "delivered") { echo 'selected';} ?>>Delivered</option>

                                            <option value="billed" <?php if($row['status'] == "billed") { echo 'selected';} ?>>Billed</option>

                                        </select>

                                	</span>

                                </li>

                            </ul>

                            

                            

                            

                            

                            

                            <h4>Administrative Details</h4>

                            <ul>

                                <li><span class="detail_title">Employee ID: </span><span class="detail_text"><input id="employee_id" name="employee_id" class="text" type="text" value="<?php echo $row['employee_id']; ?>"/></span></li>

                                <li><span class="detail_title">Cost Center: </span><span class="detail_text"><input id="cost_center" name="cost_center" class="text" type="text" value="<?php echo $row['cost_center']; ?>"/></span></li>

                                <li><span class="detail_title">Approved by: </span><span class="detail_text"><input id="approved_by" name="approved_by" class="text" type="text" value="<?php echo $row['approved_by']; ?>"/></span></li>

                                <li><span class="detail_title">Delivery Bldg: </span><span class="detail_text"><input id="delivery_bldg" name="delivery_bldg" class="text" type="text" value="<?php echo $row['delivery_bldg']; ?>"/></span></li>

                                <li><span class="detail_title">Delivery Email: </span><span class="detail_text"><input id="delivery_email" name="delivery_email" class="text" type="text" value="<?php echo $row['delivery_email']; ?>"/></span></li>

                                <li><span class="detail_title">Delivery Ext: </span><span class="detail_text"><input id="ext" name="ext" class="text" type="text" value="<?php echo $row['ext']; ?>"/></span></li>

                            </ul> 

                            

                            

                            <span class="detail_section">

                            <h4>Shipping Options</h4>

                            <ul>

                                <li><span class="detail_title">Shipping Time: </span><span class="detail_text">

                                        <input type="radio" name="shipping_time" value="10 work days" <?php if($row['shipping_time'] == '10 work days') { echo 'checked="checked"';} ?>> 10 Work days (Standard)

                                        <br />

                                        <input type="radio" name="shipping_time" value="4-8 work days" <?php if($row['shipping_time'] == '4-8 work days') { echo 'checked="checked"';} ?>> 4-8 Work days (50% RUSH)

                                        <br />

                                        <input type="radio" name="shipping_time" value="1-3 work days" <?php if($row['shipping_time'] == '1-3 work days') { echo 'checked="checked"';} ?>> 1-3 Work days (100% RUSH)

                                	</span>

                                </li>

                                <li><span class="detail_title">Rush needed by: </span><span class="detail_text"><input id="rush_date" name="rush_date" class="text" type="text" value="<?php echo $row['rush_date']; ?>" /></span></li>

                                <li><span class="detail_title">English only Quantity: </span><span class="detail_text">

                                		<input type="radio" name="english_quantity" value="0" <?php if($row['english_quantity'] == '' || $row['english_quantity'] == '0') { echo 'checked="checked"';} ?>>None

                                        <br />

                                		<input type="radio" name="english_quantity" value="250" <?php if($row['english_quantity'] == '250') { echo 'checked="checked"';} ?>>250

                        				<br />

                        				<input type="radio" name="english_quantity" value="500" <?php if($row['english_quantity'] == '500') { echo 'checked="checked"';} ?>>500

                                    </span>

                                </li>

                                <li><span class="detail_title">Foreign Quantity: </span><span class="detail_text">

                                 		<input type="radio" name="foreign_quantity" value="0" <?php if($row['foreign_quantity'] == '' || $row['foreign_quantity'] == '0') { echo 'checked="checked"';} ?>>None

                                        <br />

                                		<input type="radio" name="foreign_quantity" value="250" <?php if($row['foreign_quantity'] == '250') { echo 'checked="checked"';} ?>>250

                        				<br />

                        				<input type="radio" name="foreign_quantity" value="500" <?php if($row['foreign_quantity'] == '500') { echo 'checked="checked"';} ?>>500

									</span>

                            	</li>

                            </ul>

                            </span>

                             

                            <span class="detail_section">

                            <h4>Language Options</h4>

                            <ul>

                                <li><span class="detail_title">Language: </span>

                                	<span class="detail_text">

                                        <select id="language" name="language">

                                            <option value=""></option>

                                            <option value="Japan" <?php if($row['language'] == 'Japan') { echo 'selected';} ?>>Japan</option>

                                            <option value="Korea" <?php if($row['language'] == 'Korea') { echo 'selected';} ?>>Korea</option>

                                            <option value="Taiwan" <?php if($row['language'] == 'Taiwan') { echo 'selected';} ?>>Taiwan</option>

                                            <option value="People's Republic of China" <?php if($row['language'] == "People's Republic of China") { echo 'selected';} ?>>People's Republic of China</option>

                                        </select>

                                	</span>

                                </li>

                                <li><span class="detail_title">Other Language: </span><span class="detail_text"><input id="other_language" name="other_language" class="text" type="text" value="<?php echo $row['other_language']; ?>" /></span></li>

                                <li><span class="detail_title">Email Language Proof to: </span><span class="detail_text"><input name="email_language_proof" class="text" type="text" value="<?php echo $row['email_language_proof']; ?>"/></span></li>

                             </ul>

                             </span>

                             </span> <!--end left column-->

                        </td>

                        <td colspan="6">

                            

                            <span id="right_column"> 

                            <span class="detail_section">

                            <h4>Card/Notepad Details</h4>

                            <ul>

                                <li><span class="detail_title">Name: </span><span class="detail_text"><input id="full_name" name="full_name" class="text" type="text" value="<?php echo $row['full_name']; ?>"/></span></li>

                                <li><span class="detail_title">Title: </span><span class="detail_text"><input id="title" name="title" class="text" type="text" value="<?php echo $row['title']; ?>"/></span></li>

                                <li><span class="detail_title">Title 2: </span><span class="detail_text"><input id="title_2" name="title_2" class="text" type="text" value="<?php echo $row['title_2']; ?>"/></span></li>

                                <li><span class="detail_title">Dept/Div: </span><span class="detail_text"><input id="dept_div" name="dept_div" class="text" type="text" value="<?php echo $row['dept_div']; ?>"/></span></li>

                                <li><span class="detail_title">Dept/Div 2: </span><span class="detail_text"><input id="dept_div_2" name="dept_div_2" class="text" type="text" value="<?php echo $row['dept_div_2']; ?>"/></span></li>

                                

                                <li><span class="detail_title" id="card_change_link">

                                	<?php if($_GET['card_type'] == 'us') { echo 'US';}else{echo 'Non US';}?> card type<a href="<?php echo $site_basedir; ?>admin/edit_order.php?order_id=<?php echo $_GET['order_id']; ?>&card_type=<?php if($_GET['card_type'] == 'us') { echo 'non_us';}else{echo 'us';}?>"><span> - Change</span></a>

                                </span></li>

                                

                                

                                

                                

                                

                                <li><span class="detail_title">Phone: </span><span class="detail_text">

                                

                                <?php if($_GET['card_type'] == 'non_us') { ?>

                                

                                	<select id="phone_symbol" name="phone_symbol">

                                        <option value=""></option>

                                        <option value="T" <?php if($row['phone_symbol'] == 'T') { echo 'selected';} ?>>T</option>

                                        <option value="D" <?php if($row['phone_symbol'] == 'D') { echo 'selected';} ?>>D</option>

                                        <option value="C" <?php if($row['phone_symbol'] == 'C') { echo 'selected';} ?>>C</option>
                                        
                                        <option value="M" <?php if($row['phone_symbol'] == 'M') { echo 'selected';} ?>>M</option>
                                    </select>

                                

									<input id="non_us_phone" maxlength="20" size="20" name="non_us_phone" class="text" type="text" value="<?php echo $row['non_us_phone']; ?>"/>

								<?php } else if($_GET['card_type'] == 'us') { ?>

                                

                                    <select id="phone_symbol" name="phone_symbol">

                                        <option value=""></option>

                                        <option value="T" <?php if($row['phone_symbol'] == 'T') { echo 'selected';} ?>>T</option>

                                        <option value="D" <?php if($row['phone_symbol'] == 'D') { echo 'selected';} ?>>D</option>

                                        <option value="C" <?php if($row['phone_symbol'] == 'C') { echo 'selected';} ?>>C</option>
                                        
                                        <option value="M" <?php if($row['phone_symbol'] == 'M') { echo 'selected';} ?>>M</option>

                                    </select>



                                    <input id="phone_int_prefix" maxlength="2" size="2" name="phone_int_prefix" class="text" type="text" value="<?php echo $row['phone_int_prefix']; ?>"/>

                                	<input id="phone_prefix" maxlength="3" size="3" name="phone_prefix" class="text" type="text" value="<?php echo $row['phone_prefix']; ?>"/>

                                	<input id="phone_first" maxlength="3" size="3" name="phone_first" class="text" type="text" value="<?php echo $row['phone_first']; ?>"/>

                                    <input id="phone_last" maxlength="4" size="3" name="phone_last" class="text" type="text" value="<?php echo $row['phone_last']; ?>"/>

                                <?php } ?>

                                    </span>

                                </li>

                                

                                

                                

                                

                                

                                

                                

                                

                                <li><span class="detail_title">Fax: </span><span class="detail_text">

                                

                                <?php if($_GET['card_type'] == 'non_us') { ?>

									<input id="non_us_fax" maxlength="20" size="20" name="non_us_fax" class="text" type="text" value="<?php echo $row['non_us_fax']; ?>"/>

								<?php } else { ?>

										

                                    	<input id="fax_int_prefix" maxlength="2" size="2" name="fax_int_prefix" class="text" type="text" value="<?php echo $row['fax_int_prefix']; ?>"/>

                                		<input id="fax_prefix" maxlength="3" size="3" name="fax_prefix" class="text" type="text" value="<?php echo $row['fax_prefix']; ?>"/>

                                        <input id="fax_first" maxlength="3" size="3" name="fax_first" class="text" type="text" value="<?php echo $row['fax_first']; ?>"/>

                                        <input id="fax_last" maxlength="4" size="3" name="fax_last" class="text" type="text" value="<?php echo $row['fax_last']; ?>"/>

                                <?php } ?>

                                	</span>

                                </li>

                                

                                

                                

                                

                                

                                <li><span class="detail_title">Other Number: </span><span class="detail_text" style="width:230px;">

								

									<?php 

                                    

                                    

                                    

                                    

                                    $counter = 1;

										

										while($contact_row = $contact_result->fetch_assoc()) {

											

											if($counter == 1) {

												$contact_type_1 = $contact_row['contact_type'];

												$contact_int_prefix_1 = $contact_row['int_prefix'];

												$contact_prefix_1 = $contact_row['prefix'];

												$contact_first_1 = $contact_row['first'];

												$contact_last_1 = $contact_row['last'];

												$contact_non_us_1 = $contact_row['non_us_number'];

											}

											

											if($counter == 2) {

												$contact_type_2 = $contact_row['contact_type'];

												$contact_int_prefix_2 = $contact_row['int_prefix'];

												$contact_prefix_2 = $contact_row['prefix'];

												$contact_first_2 = $contact_row['first'];

												$contact_last_2 = $contact_row['last'];

												$contact_non_us_2 = $contact_row['non_us_number'];

											}

											

											$counter++;

										}

                                    

                                    if($_GET['card_type'] == 'non_us') { 

                                       

										?>

                                        	<select id="contact_type" name="contact_type_1">

												<option value=""></option>

												<option value="Cell" <?php if($contact_type_1 == 'Cell') { echo 'selected';} ?>>Cell</option>

												<option value="Mobile" <?php if($contact_type_1 == 'Mobile') { echo 'selected';} ?>>Mobile</option>

												<option value="Pager" <?php if($contact_type_1 == "Pager") { echo 'selected';} ?>>Pager</option>

											</select>

                                        	<input id="non_us_contact" maxlength="20" size="20" name="non_us_contact_1" class="text" type="text" value="<?php echo $contact_non_us_1; ?>"/>

                                            

                                            <br /><br />

                                        

                                        	<select id="contact_type" name="contact_type_2">

												<option value=""></option>

												<option value="Cell" <?php if($contact_type_2 == 'Cell') { echo 'selected';} ?>>Cell</option>

												<option value="Mobile" <?php if($contact_type_2 == 'Mobile') { echo 'selected';} ?>>Mobile</option>

												<option value="Pager" <?php if($contact_type_2 == "Pager") { echo 'selected';} ?>>Pager</option>

											</select>

                                        	<input id="non_us_contact" maxlength="20" size="20" name="non_us_contact_2" class="text" type="text" value="<?php echo $contact_non_us_2; ?>"/>

                                    	<?php 

											

                                    } else { 

                                    

                                    

										

											?>

											

											<select id="contact_type" name="contact_type_1">

												<option value=""></option>

												<option value="Cell" <?php if($contact_type_1 == 'Cell') { echo 'selected';} ?>>Cell</option>

												<option value="Mobile" <?php if($contact_type_1 == 'Mobile') { echo 'selected';} ?>>Mobile</option>

												<option value="Pager" <?php if($contact_type_1 == "Pager") { echo 'selected';} ?>>Pager</option>

											</select>

											

                                            <input id="contact_int_prefix" maxlength="2" size="2" name="contact_int_prefix_1" class="text" type="text" value="<?php echo $contact_int_prefix_1; ?>"/>

											<input id="contact_prefix" maxlength="3" size="3" name="contact_prefix_1" class="text" type="text" value="<?php echo $contact_prefix_1; ?>"/>

											<input id="contact_first" maxlength="3" size="3" name="contact_first_1" class="text" type="text" value="<?php echo $contact_first_1; ?>"/>

											<input id="contact_last" maxlength="4" size="4" name="contact_last_1" class="text" type="text" value="<?php echo $contact_last_1; ?>"/>

											

                                            <br /><br />

                                            

                                            <select id="contact_type" name="contact_type_2">

												<option value=""></option>

												<option value="Cell" <?php if($contact_type_2 == 'Cell') { echo 'selected';} ?>>Cell</option>

												<option value="Mobile" <?php if($contact_type_2 == 'Mobile') { echo 'selected';} ?>>Mobile</option>

												<option value="Pager" <?php if($contact_type_2 == "Pager") { echo 'selected';} ?>>Pager</option>

											</select>

											

                                            <input id="contact_int_prefix" maxlength="2" size="2" name="contact_int_prefix_2" class="text" type="text" value="<?php echo $contact_int_prefix_2; ?>"/>

											<input id="contact_prefix" maxlength="3" size="3" name="contact_prefix_2" class="text" type="text" value="<?php echo $contact_prefix_2; ?>"/>

											<input id="contact_first" maxlength="3" size="3" name="contact_first_2" class="text" type="text" value="<?php echo $contact_first_2; ?>"/>

											<input id="contact_last" maxlength="4" size="4" name="contact_last_2" class="text" type="text" value="<?php echo $contact_last_2; ?>"/>

                                            

											<?php	

									}

								?></span></li>

                                

                                

                                

                                

                                

                                

                                <li><span class="detail_title">Email: </span><span class="detail_text"><input id="email" name="email" class="text" type="text" value="<?php echo $row['email']; ?>"/></span></li>

                                <li><span class="detail_title">Address: </span>

                                

                                

                                

                                <?php if($_GET['address_type'] == 'normal') { 

										if($_GET['card_type'] == 'non_us') {	

								?>

                                			<span class="detail_text">

                                                <label for="nonus_1">Address Line 1</label>

                                                <br />    

                                                <input id="nonus_1" name="nonus_1" class="text" type="text" value="<?php echo $nonus_address_row['line_1']; ?>"/>

                                                

                                                <br /><br />

                                                

                                                <label for="nonus_2">Address Line 2</label>

                                                <br />    

                                                <input id="nonus_2" name="nonus_2" class="text" type="text" value="<?php echo $nonus_address_row['line_2']; ?>"/>

                                                

                                                <br /><br />

                                                

                                                <label for="nonus_3">Address Line 3</label>

                                                <br />    

                                                <input id="nonus_3" name="nonus_3" class="text" type="text" value="<?php echo $nonus_address_row['line_3']; ?>"/>

                                                

                                                <br /><br />

                                                

                                                <label for="nonus_4">Address Line 4</label>

                                                <br />    

                                                <input id="nonus_4" name="nonus_4" class="text" type="text" value="<?php echo $nonus_address_row['line_4']; ?>"/>

                                            </span>

                                <?php } if($_GET['card_type'] == 'us') { ?>

                                	<span class="detail_text">

                                		<select id="address" name="address">

											<?php 

                                            $building_sql = "SELECT *

                                            FROM buildings 

                                            ORDER BY city ASC";

                                    

                                            $building_result = $conn->query($building_sql) or die(mysqli_error());

                                            

                                            while($building_row = $building_result->fetch_assoc()) { 

                                            ?>

                                                 <option value="<?php echo $building_row['building_id']; ?>" <?php if($row['building_id'] == $building_row['building_id']) { echo 'selected';} ?>><?php echo $building_row['address'] . ', P.O. Box ' . $building_row['po_box'] . ', ' . $building_row['city'] . ', ' . $building_row['state'] . ' ' . $building_row['zip_code'];  ?></option>

                                            <?php } //end while?>

                                        </select>

                                    </span>

                                <?php 	}

									} else if($_GET['address_type'] == 'none') {?>

                                		<span class="detail_text"><p id="no_address_text">You have chosen to show no address</p></span>

                                <?php } else if($_GET['address_type'] == 'custom') {

											if($_GET['card_type'] == 'us') {

									?>

                                        <span class="detail_text">

                                            <label for="custom_line_1">Address Line 1</label>

                                            <br />    

                                            <input id="custom_line_1" name="custom_line_1" class="text" type="text" value="<?php echo $address_row['line_1']; ?>"/>

                                            

                                            <br /><br />   

                                            

                                            <label for="custom_line_2">Address Line 2</label>

                                            <br />    

                                            <input id="custom_line_2" name="custom_line_2" class="text" type="text" value="<?php echo $address_row['line_2']; ?>"/>

                                            

                                            <br /><br />   

                                            

                                            <label for="custom_city">City</label>

                                            <br />    

                                            <input id="custom_city" name="custom_city" class="text" type="text" value="<?php echo $address_row['city']; ?>"/>

                                            

                                            <br /><br />   

                                            

                                            <label for="custom_state">State</label>

                                            <br />    

                                            <input id="custom_state" name="custom_state" class="text" type="text" value="<?php echo $address_row['state']; ?>"/>

                                            

                                            <br /><br />   

                                            

                                            <label for="custom_zip_1">Zip-Code</label>

                                            <br />    

                                            <input id="custom_zip_1" name="custom_zip_1" class="text" type="text" value="<?php echo $address_row['zip_1']; ?>"/>

                                            -

                                            <input id="custom_zip_2" name="custom_zip_2" class="text" type="text" value="<?php echo $address_row['zip_2']; ?>"/>

                                        </span>

                                <?php

											} 

											

											if($_GET['card_type'] == 'non_us') { ?>

                                            	<span class="detail_text">

                                                    <label for="nonus_1">Address Line 1</label>

                                                    <br />    

                                                    <input id="nonus_1" name="nonus_1" class="text" type="text" value="<?php echo $nonus_address_row['line_1']; ?>"/>

                                                    

                                                    <br /><br />

                                                    

                                                    <label for="nonus_2">Address Line 2</label>

                                                    <br />    

                                                    <input id="nonus_2" name="nonus_2" class="text" type="text" value="<?php echo $nonus_address_row['line_2']; ?>"/>

                                                    

                                                    <br /><br />

                                                    

                                                    <label for="nonus_3">Address Line 3</label>

                                                    <br />    

                                                    <input id="nonus_3" name="nonus_3" class="text" type="text" value="<?php echo $nonus_address_row['line_3']; ?>"/>

                                                    

                                                    <br /><br />

                                                    

                                                    <label for="nonus_4">Address Line 4</label>

                                                    <br />    

                                                    <input id="nonus_4" name="nonus_4" class="text" type="text" value="<?php echo $nonus_address_row['line_4']; ?>"/>

                                                </span>

								<?php		}

                                } ?>

                                </li>

                                

                                <?php if($_GET['address_type'] != 'normal') { ?>

                                    <li><span class="detail_text" id="address_change_link">

                                        <a href="<?php echo $site_basedir; ?>admin/edit_order.php?order_id=<?php echo $_GET['order_id']; ?>&card_type=<?php echo $_GET['card_type']; ?>&address_type=normal"><span><?php if($_GET['card_type'] == 'us') { echo ' - Applied Building Address';} else { echo ' - Enter Manual Address';} ?></span></a>

                                    </span></li>

                                <?php } ?>

                                

                                <?php if($_GET['address_type'] != 'none') { ?>

                                    <li><span class="detail_text" id="address_change_link">

                                        <a href="<?php echo $site_basedir; ?>admin/edit_order.php?order_id=<?php echo $_GET['order_id']; ?>&card_type=<?php echo $_GET['card_type']; ?>&address_type=none"><span> - No Address</span></a>

                                    </span></li>

                                <?php } ?>

                               

                               

                                <?php if($_GET['card_type'] == 'us') {

										if($_GET['address_type'] != 'custom') { ?>

                                    	<li><span class="detail_text" id="address_change_link">

                                        	<a href="<?php echo $site_basedir; ?>admin/edit_order.php?order_id=<?php echo $_GET['order_id']; ?>&card_type=<?php echo $_GET['card_type']; ?>&address_type=custom"><span> - Custom Address</span></a>

                                    </span></li>

                                <?php 	}

									} ?>

                                

                                <li><span class="detail_title">Mail Stop: </span><span class="detail_text"><input id="mail_stop" name="mail_stop" class="text" type="text" value="<?php echo $row['mail_stop']; ?>"/></span></li>

                             </ul>

                             </span>

                             

                            <span class="detail_section">

                            <h4>Notepad Options</h4>

                            <ul>

                                <li><span class="detail_title">&nbsp; </span><span class="detail_text" style="font-weight: bold; font-size: 12px;"><input type="checkbox" name="notepad_size_425x55" value="yes" <?php if($row['notepad_size_425x55'] == 'yes') { echo 'checked="checked"';} ?>> 4.25 X 5.5</span></li>

                                <li><span class="detail_title">&nbsp; </span><span class="detail_text" style="font-weight: bold; font-size: 12px;"><input type="checkbox" name="notepad_size_55x85" value="yes" <?php if($row['notepad_size_55x85'] == 'yes') { echo 'checked="checked"';} ?>> 5.5 X 8.5</span></li>

                             </ul>

                             </span> 

                             

                            <span class="detail_section">

                            <h4>Comments</h4>

                            <ul>

                                <li><span class="detail_title">Message: </span><span class="detail_text"><textarea name="comments"><?php echo $row['comments']; ?></textarea></span></li>

                             </ul>

                             </span>

                             </span> <!--end right column -->

                        </td>

                    </tr>

                    

            		<tr class="odd">

                    	<td colspan="11" id="tracker_table_footer" style="border-bottom: 1px solid #5C7F99; height: 0px;">

                        	<input class="button next submit" type="submit" name="edit_order" value="Edit Order" />

                        </td>

                    </tr>	

                    </form>

        </table>

        

</div> <!--end container div-->





<?php mysqli_close($conn); ?>

</body>

</html>