<?php

session_start();

ob_start();

// Get required files.

//require 'fpdf/fpdf.php';

require 'fpdf_eps.php';



include("../includes/connection.php");

$conn = dbConnect("admin");


unset($_SESSION['extra_number']); //This unsets any additional numbers that might have been saved from viewing a previous card

//Get address

$sql = "SELECT *

FROM orders

WHERE order_id = '" . $_GET['order_id'] . "'";



$result = $conn->query($sql) or die(mysqli_error());



$row = $result->fetch_assoc();





//Get address

$sql = "SELECT *, UNIX_TIMESTAMP('date_submitted')

		FROM orders

		WHERE order_id = '" . $_GET['order_id'] . "'";



$result = $conn->query($sql) or die(mysqli_error());



$row = $result->fetch_assoc();



$date_added = date('Y-m-d H:i:s',time());

$_SESSION["order_id"] = $row['order_id'];

$_SESSION["order_num"] = $row['order_id'];

$_SESSION["full_name"] = $row['full_name'];

$_SESSION["first_name"] = $row['first_name'];

$_SESSION["last_name"] = $row['last_name'];

$_SESSION["title"] = $row['title'];

$_SESSION["title_2"] = $row['title_2'];

$_SESSION["dept_div"] = $row['dept_div'];

$_SESSION["dept_div_2"] = $row['dept_div_2'];

$_SESSION["approved_by"] = $row['approved_by'];



$_SESSION["phone_symbol"] = $row['phone_symbol'];

$_SESSION["phone_int_prefix"] = $row['phone_int_prefix'];

$_SESSION["phone_prefix"] = $row['phone_prefix'];

$_SESSION["phone_first"] = $row['phone_first'];

$_SESSION["phone_last"] = $row['phone_last'];

$_SESSION["fax_int_prefix"] = $row['fax_int_prefix'];

$_SESSION["fax_prefix"] = $row['fax_prefix'];

$_SESSION["fax_first"] = $row['fax_first'];

$_SESSION["fax_last"] = $row['fax_last'];



$_SESSION["email"] = $row['email'];

$_SESSION["mail_stop"] = $row['mail_stop'];

$_SESSION["address"] = $row['building_id'];

$_SESSION['non_us_phone'] = $row['non_us_phone'];

$_SESSION['non_us_fax'] = $row['non_us_fax'];

$_SESSION['no_address'] = $row['no_address'];



$_SESSION['status'] = $row['status'];

$_SESSION['date_submitted'] = $row['date_submitted'];

$_SESSION['custom_address'] = $row['custom_address'];



$_SESSION['english_quantity'] = $row['english_quantity'];

$_SESSION['foreign_quantity'] = $row['foreign_quantity'];

$_SESSION['notepad_size_425x55'] = $row['notepad_size_425x55'];

$_SESSION['notepad_size_55x85'] = $row['notepad_size_55x85'];



$_SESSION['character_hold'] = $row['character_hold'];

$_SESSION["language"] = $row["language"];

$_SESSION["other_language"] = $row["other_language"];

$_SESSION['upload_location'] = $row["upload_location"];

$_SESSION['dirPath'] = 'upload/' . $_SESSION['upload_location'];

$_SESSION['foreign_characters_name'] = $row['foreign_characters_name'];

$_SESSION['foreign_characters_line2'] = $row['foreign_characters_line2'];

$_SESSION['foreign_characters_line3'] = $row['foreign_characters_line3'];

$_SESSION['foreign_characters_line4'] = $row['foreign_characters_line4'];


if(isset($_SESSION['mail_stop']) && $_SESSION['mail_stop'] != '' && $_SESSION['mail_stop'] != 0) { 

	$mail_stop = ', M/S ' . $_SESSION['mail_stop'];

}


if($row['non_us_card'] == 'yes') { //if its a non US card

	$_SESSION["location"] = 'non_us_address';

	$_SESSION["non_us_card"] = 'yes';

} else { //if its a US card

	$_SESSION["location"] = 'us_address';

	$_SESSION["non_us_card"] = 'no';

}







if($row['english_quantity'] != '' && $row['english_quantity'] > 0) {

	$_SESSION['english_cards_ordered'] = 'yes';

} else {

	$_SESSION['english_cards_ordered'] = 'no';

}



if($row['foreign_quantity'] != '' && $row['foreign_quantity'] > 0) {

	$_SESSION['foreign_cards_ordered'] = 'yes';

} else {

	$_SESSION['foreign_cards_ordered'] = 'no';

}





$_SESSION['order_id'] = $_GET['order_id'];



if($row['additional_contact_exists'] == 'yes') {	

	$counter = 1;

	$sql = "SELECT *

			FROM contact_numbers

			WHERE order_id = '" . $_GET['order_id'] . "'";	

	

	$result = $conn->query($sql) or die(mysqli_error());

	while($row = $result->fetch_assoc()) {

			$_SESSION['extra_number'][$counter]['additional_contact'] = $row['contact_type'];

			$_SESSION['extra_number'][$counter]['additional_int_prefix'] = $row['int_prefix'];		

			$_SESSION['extra_number'][$counter]['additional_prefix'] = $row['prefix'];

			$_SESSION['extra_number'][$counter]['additional_first'] = $row['first'];

			$_SESSION['extra_number'][$counter]['additional_last'] = $row['last'];

			$_SESSION['extra_number'][$counter]['additional_non_us_number'] = $row['non_us_number'];

			$counter++;

	}

}











if($_SESSION['custom_address'] == 'yes') {

	$sql = "SELECT *

			FROM custom_addresses

			WHERE order_id = '" . $_GET['order_id'] . "'";

			

	$result = $conn->query($sql) or die(mysqli_error());

	$row = $result->fetch_assoc();

	

	$_SESSION['other_address'] = 'yes';

	$_SESSION["custom_address_1"] = $row['line_1'] . $mail_stop;

	$_SESSION["custom_address_2"] = $row['line_2'];

	$_SESSION["custom_city"] = $row['city'];

	$_SESSION["custom_state"] = $row['state'];

	$_SESSION["custom_zip"] = $row['zip_1'];

	$_SESSION["custom_zip_2"] = $row['zip_2'];

} else {

	$_SESSION['other_address'] = 'no';	

}









if($_SESSION["non_us_card"] == 'yes') { //if this is a non us card

	$sql = "SELECT *

			FROM non_us_addresses

			WHERE order_id = '" . $_GET['order_id'] . "'";

			

	$result = $conn->query($sql) or die(mysqli_error());

	$row = $result->fetch_assoc();

	

	$_SESSION["non_us_address_1"] = $row['line_1'];

	$_SESSION["non_us_address_2"] = $row['line_2'];

	$_SESSION["non_us_address_3"] = $row['line_3'];

	$_SESSION["non_us_address_4"] = $row['line_4'];



}



$_SESSION['employee_id'] = $row['employee_id'];





if($_SESSION['phone_int_prefix'] > 0) {

	$phone_int_prefix = $_SESSION['phone_int_prefix'] . '.';	

}



$phone = $phone_int_prefix . $_SESSION["phone_prefix"] . '.' . $_SESSION["phone_first"] . '.' . $_SESSION["phone_last"];



if($_SESSION['fax_int_prefix'] > 0) {

	$fax_int_prefix = $_SESSION['fax_int_prefix'] . '.';	

}



if($_SESSION["fax_prefix"] > 0) {

	$fax = $fax_int_prefix . $_SESSION["fax_prefix"] . '.' . $_SESSION["fax_first"] . '.' . $_SESSION["fax_last"];

}



$email = $_SESSION["email"];











$pdf_name = 'AMAT_' . $_SESSION['first_name'] . '_' . $_SESSION['last_name'] . '_' . $_GET['order_id'] . '.pdf';













$pdf = new PDF_EPS('L', 'mm', array(50.8,88.9));





// Set some document variables

$name = $_SESSION["full_name"];

$title = $_SESSION["title"];

$title_2 = $_SESSION["title_2"];

$dept_div = $_SESSION["dept_div"];

$dept_div_2 = $_SESSION["dept_div_2"];



//Get address

$building_sql = 'SELECT *

				FROM buildings

				WHERE building_id = ' . $_SESSION["address"];



$building_result = $conn->query($building_sql) or die(mysqli_error());



$building_row = $building_result->fetch_assoc();



if(isset($_SESSION['mail_stop']) && $_SESSION['mail_stop'] != '' && $_SESSION['mail_stop'] != 0) { 

	$mail_stop = ', M/S ' . $_SESSION['mail_stop'];

}



if($building_row['zip_2'] != '' && $building_row['zip_2'] != 0) {

	$zip_code = $building_row['zip_1'] . '-' . $building_row['zip_2'];	

} else {

	$zip_code = $building_row['zip_1'];	

}



$address_line_1 = $building_row['address'] . $mail_stop;

if($building_row['po_box'] != '' && $building_row['po_box'] != 0) {

	$address_line_2 = 'P.O. Box ' . $building_row['po_box'];

}

$address_line_3 = $building_row['city'] . ', ' . $building_row['state'] . ' ' . $zip_code;





$custom_address_line_1 = $_SESSION['custom_address_1'];

if($_SESSION['custom_address_2'] != '') {

	$custom_address_line_2 = $_SESSION['custom_address_2'];

}

if($_SESSION['custom_zip_2'] != '') {

	$custom_zip_2 = '-' . $_SESSION['custom_zip_2'];	

}

$custom_address_line_3 = $_SESSION['custom_city'] . ', ' . $_SESSION['custom_state'] . ' ' . $_SESSION['custom_zip'] . $custom_zip_2;





//This is the code for outputting the PDF's



//This adds the fonts needed for the PDF's

$pdf->AddFont('Whitney-Book','','Whitney-Book.php');

$pdf->AddFont('Whitney-BookItalic','','Whitney-BookItalic.php');

$pdf->AddFont('Whitney-Semibold','','Whitney-Semibold.php');

$pdf->AddFont('Whitney-SemiboldItalic','','Whitney-SemiboldItalic.php');

$pdf->AddFont('Whitney-SemiboldSC','','Whitney-SemiboldSC.php');









	// Add a new page to the document

	$pdf->addPage('L', array(50.8,88.9));

	

	$pdf->SetDisplayMode(160,'default'); //makes it show up at 160%

	

	// Set the font color

	$pdf->SetTextColor(0,0,0); //sets text color for author by rgb values

	$pdf->SetXY(43.5, 0); //sets the position for the author

																																																															

	$pdf->SetMargins(0,0,0);	

	$pdf->SetAutoPageBreak(0);

	

	$pdf->ImageEps('ai/amatlogo.ai', 13, 6); // Place an image on the pdf document

	

	$pdf->Cell(0,13, "", '0', 2, 'L', false);//Spacer block

	

	$pdf->SetFont('Whitney-Semibold','',10);

	$pdf->SetX(43.5);

	$pdf->Cell(0,4, "$name", '0', 2, 'L', false); //Full Name

	

	$pdf->SetFont('Whitney-BookItalic','',7.25);

	$pdf->Cell(0,2.5, "$title", '0', 2, 'L', false); //Title

	

	if($title_2) {

		$pdf->Cell(0,2.5, "$title_2", '0', 2, 'L', false); //Title 2

	}

	

	if($dept_div) {

		$pdf->Cell(0,2.5, "$dept_div", '0', 2, 'L', false); //Department

	}

	

	if($dept_div_2) {

		$pdf->Cell(0,2.5, "$dept_div_2", '0', 2, 'L', false); //Department 2

	}

	

	$pdf->Cell(0,1, "", '0', 2, 'L', false);//Spacer block

	

	$pdf->SetFont('Whitney-Semibold','',5.5);

	if($_SESSION[phone_symbol] == 'T') {

		$pdf->Cell(3,2.5, "T  ", '0', 0, 'L', false); //Phone Signifier

	} else if($_SESSION[phone_symbol] == 'D') {

		$pdf->Cell(3,2.5, "D  ", '0', 0, 'L', false); //Phone Signifier

	}

	

	if($_SESSION['location'] == 'us_address') {

		$pdf->SetFont('Whitney-Book','',7.25);

		$pdf->Cell(0,2.5, "$phone", '0', 1, 'L', false); //Phone Number

		

		$counter = 1;

		while($_SESSION['extra_number'][$counter]['additional_contact'] != '' && $_SESSION['extra_number'][$counter]['additional_prefix'] != '') {

			

			switch($_SESSION['extra_number'][$counter]['additional_contact']) {

				case "Cell":

					$type = "C ";

					break;

				case "Mobile":

					$type = "M ";

					break;

				case "Pager":

					$type = "P ";

					break;

			}

			

			

			$pdf->SetX(43.5);

			$pdf->SetFont('Whitney-Semibold','',5.5);

			$pdf->Cell(3,2.5, $type, '0', 0, 'L', false); //Additional Contact Signifier

			

			

			if($_SESSION['extra_number'][$counter]['additional_int_prefix']) {

				$additional_int_prefix = $_SESSION['extra_number'][$counter]['additional_int_prefix'] . '.';	

			}

			$additional_contact_number = $additional_int_prefix . $_SESSION['extra_number'][$counter]['additional_prefix'] . '.' . $_SESSION['extra_number'][$counter]['additional_first'] . '.' . $_SESSION['extra_number'][$counter]['additional_last'];

			

			

			$pdf->SetFont('Whitney-Book','',7.25);

			$pdf->Cell(0,2.5, $additional_contact_number, '0', 1, 'L', false); //Additional Contact Number

			

			$counter++;

		}

		

		if($fax) {

			$pdf->SetX(43.5); //sets the position for the fax

			$pdf->SetFont('Whitney-Semibold','',5.5);

			$pdf->Cell(3,2.5, "F  ", '0', 0, 'L', false); //Fax Signifier

			

			$pdf->SetFont('Whitney-Book','',7.25);

			$pdf->Cell(0,2.5, "$fax", '0', 1, 'L', false); //Fax Number

		}

	} else if($_SESSION['location'] == 'non_us_address') {

		$pdf->SetFont('Whitney-Book','',7.25);

		$pdf->Cell(0,2.5, $_SESSION['non_us_phone'], '0', 1, 'L', false); //Phone Number

		

		$counter = 1;

		while($_SESSION['extra_number'][$counter]['additional_contact'] != '' && $_SESSION['extra_number'][$counter]['additional_non_us_number'] != '') {

			

			switch($_SESSION['extra_number'][$counter]['additional_contact']) {

				case "Cell":

					$type = "C ";

					break;

				case "Mobile":

					$type = "M ";

					break;

				case "Pager":

					$type = "P ";

					break;

			}

		

			$pdf->SetX(43.5);

			$pdf->SetFont('Whitney-Semibold','',5.5);

			$pdf->Cell(3,2.5, $type, '0', 0, 'L', false); //Additional Contact Signifier

			

			$additional_contact_number = $_SESSION['extra_number'][$counter]['additional_non_us_number'];

			

			$pdf->SetFont('Whitney-Book','',7.25);

			$pdf->Cell(0,2.5, $additional_contact_number, '0', 1, 'L', false); //Additional Contact Number

			

			$counter++;

		}

		

		if($_SESSION['non_us_fax']) {

			$pdf->SetX(43.5); //sets the position for the fax

			$pdf->SetFont('Whitney-Semibold','',5.5);

			$pdf->Cell(3,2.5, "F  ", '0', 0, 'L', false); //Fax Signifier

			

			$pdf->SetFont('Whitney-Book','',7.25);

			$pdf->Cell(0,2.5, $_SESSION['non_us_fax'], '0', 1, 'L', false); //Fax Number

		}

	} //end if location == non_us_address

	

	$pdf->SetX(43.5); //sets the position for the spacer

	$pdf->Cell(0,.5, "", '0', 2, 'L', false);//Spacer block

	

	$pdf->SetX(43.5); //sets the position for the email and address

	$pdf->SetFont('Whitney-SemiboldItalic','',7.25);

	$pdf->Cell(0,3, "$email", '0', 2, 'L', false); //Email

	

	$pdf->Cell(0,1.25, "", '0', 2, 'L', false);//Spacer block

	

	if($_SESSION['location'] == 'us_address') {

		$pdf->SetFont('Whitney-Book','',7.25);

		if($_SESSION['address'] != 0) {

			$pdf->Cell(0,2.5, $address_line_1, '0', 2, 'L', false); //Address Line 1

			if(isset($address_line_2)) {

				$pdf->Cell(0,2.5, $address_line_2, '0', 2, 'L', false); //Address Line 2

			}

			if($_SESSION['foreign_cards_ordered'] == 'yes') {
				$pdf->Cell(0,2.5, $address_line_3 . ' USA', '0', 2, 'L', false); //Address Line 3 with USA
			} else {
				$pdf->Cell(0,2.5, $address_line_3, '0', 2, 'L', false); //Address Line 3 without USA
			}
		} else if($_SESSION['other_address'] == 'yes') {

			$pdf->Cell(0,2.5, "$custom_address_line_1", '0', 2, 'L', false); //Address Line 1

			if(isset($custom_address_line_2)) {

				$pdf->Cell(0,2.5, "$custom_address_line_2", '0', 2, 'L', false); //Address Line 2

			}

			$pdf->Cell(0,2.5, "$custom_address_line_3", '0', 2, 'L', false); //Address Line 3

		}
		if($_SESSION['foreign_cards_ordered'] == 'yes') {
			$pdf->Cell(0,1, "", '0', 2, 'L', false);//Spacer block
			$pdf->Cell(0,2.5, "www.appliedmaterials.com", '0', 2, 'L', false); //Address Line 1
		}

	} else if($_SESSION['location'] == 'non_us_address') {

		$pdf->SetFont('Whitney-Book','',7.25);

		if($_SESSION['no_address'] == 'no') {

			$pdf->Cell(0,2.5, $_SESSION['non_us_address_1'], '0', 2, 'L', false); //Address Line 1

			if(isset($_SESSION['non_us_address_2'])) {

				$pdf->Cell(0,2.5, $_SESSION['non_us_address_2'], '0', 2, 'L', false); //Address Line 2

			}

			if(isset($_SESSION['non_us_address_3'])) {

				$pdf->Cell(0,2.5, $_SESSION['non_us_address_3'], '0', 2, 'L', false); //Address Line 2

			}

			if(isset($_SESSION['non_us_address_4'])) {

				$pdf->Cell(0,2.5, $_SESSION['non_us_address_4'], '0', 2, 'L', false); //Address Line 2

			}

		}

	} //end if location == non_us_address





foreach($_SESSION as $key => $value){

	if($key == 'authenticated_oc') continue; //This skips the current session variable if it is named 'authenticated_oc', which is what holds the login information.

	$_SESSION[$key] = NULL; 

	unset($_SESSION[$key]);

}



// Close the document and save to the filesystem with the name

$pdf->Output($pdf_name,'D');







?>