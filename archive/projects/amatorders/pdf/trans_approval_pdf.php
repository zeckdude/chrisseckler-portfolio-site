<?php

session_start();

// Get required files.

//require 'fpdf/fpdf.php';





header('Content-type: text/html; charset=utf-8');









require 'fpdf_eps.php';



include("../includes/connection.php");

$conn = dbConnect("admin");





$pdf = new PDF_EPS('L', 'mm', array(50.8,88.9));











// Set some document variables

$name = $_SESSION["full_name"];

$title = $_SESSION["title"];

$title_2 = $_SESSION["title_2"];

$dept_div = $_SESSION["dept_div"];

$dept_div_2 = $_SESSION["dept_div_2"];

$_SESSION["full_name"] = trim($_SESSION["full_name"]); //trim the whitespace off the beginning and end
$comma_pos = strpos($_SESSION["full_name"], ','); //Finds the first occurrence of a comma within the full name

//Series of functions to separate the full name into separate first name, last name, and professional title
	if($comma_pos) { //If there is a comma in the name then remove the contents after the comma and save the rest as the full name	
		$first_last_name = substr($_SESSION["full_name"], 0, $comma_pos); //This is the first and last name together
		$pro_title = substr($_SESSION["full_name"], $comma_pos+1); //This is the professional title
	} else if(!$comma_pos) { //If there is no comma then just use the full name as the name
		$first_last_name = $_SESSION["full_name"];
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





    $_SESSION["first_name"] = $first_name;

    $_SESSION["last_name"] = $last_name;


//$pdf_name = 'AMAT_' . $_SESSION['first_name'] . '_' . $_SESSION['last_name'] . '.pdf';
$pdf_name = 'AMAT_' . $first_name . '_' . $last_name . '.pdf';



if($_SESSION['phone_int_prefix']) {

	$phone_int_prefix = $_SESSION['phone_int_prefix'] . '.';	

}



$phone = $phone_int_prefix . $_SESSION["phone_prefix"] . '.' . $_SESSION["phone_first"] . '.' . $_SESSION["phone_last"];



if($_SESSION['fax_int_prefix']) {

	$fax_int_prefix = $_SESSION['fax_int_prefix'] . '.';	

}



if($_SESSION["fax_prefix"]) {

	$fax = $fax_int_prefix . $_SESSION["fax_prefix"] . '.' . $_SESSION["fax_first"] . '.' . $_SESSION["fax_last"];

}



$email = $_SESSION["email"];



//Take any values out of the extra contact numbers array and save them as variables

if($_SESSION['contact']) {

	foreach ($_SESSION['contact'] as $counter => $contact_array) { //This specifies the $_SESSION['order'] array to loop through 

		foreach ($contact_array as $key => $value) { //This specifies the array within the $_SESSION['order'] array

			$_SESSION['extra_number'][$counter][$key] = $value;

		} //end foreach

	} //end of outer foreach loop

}



//Get address

$sql = "SELECT *

FROM buildings

WHERE building_id = '" . $_SESSION['address'] . "'";



$result = $conn->query($sql) or die(mysqli_error());



$row = $result->fetch_assoc();



if(isset($_SESSION['mail_stop']) && $_SESSION['mail_stop'] != '' && $_SESSION['mail_stop'] != 0) { 

	$mail_stop = ', M/S ' . $_SESSION['mail_stop'];

}



if($row['zip_2'] != '' && $row['zip_2'] != 0) {

	$zip_code = $row['zip_1'] . '-' . $row['zip_2'];	

} else {

	$zip_code = $row['zip_1'];	

}



$address_line_1 = $row['address'] . $mail_stop;

if($row['po_box'] != '' && $row['po_box'] != 0) {

	$address_line_2 = 'P.O. Box ' . $row['po_box'];

}

$address_line_3 = $row['city'] . ', ' . $row['state'] . ' ' . $zip_code;



$custom_address_line_1 = $_SESSION[custom_address_1];

if($_SESSION[custom_address_2]) {

	$custom_address_line_2 = $_SESSION[custom_address_2];

}

if($_SESSION[custom_zip_2]) {

	$custom_zip_2 = '-' . $_SESSION[custom_zip_2];	

}

$custom_address_line_3 = $_SESSION[custom_city] . ', ' . $_SESSION[custom_state] . ' ' . $_SESSION[custom_zip] . $custom_zip_2;















//This is the code for outputting the PDF's



//This adds the fonts needed for the PDF's

$pdf->AddFont('Whitney-Book','','Whitney-Book.php');

$pdf->AddFont('Whitney-BookItalic','','Whitney-BookItalic.php');

$pdf->AddFont('Whitney-Semibold','','Whitney-Semibold.php');

$pdf->AddFont('Whitney-SemiboldItalic','','Whitney-SemiboldItalic.php');

$pdf->AddFont('Whitney-SemiboldSC','','Whitney-SemiboldSC.php');





	// English side of Foreign Card

	$pdf->addPage();

	

	$pdf->SetDisplayMode(125,'continuous'); //makes it show up at 160%

	

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

		while($_SESSION['extra_number'][$counter]['additional_contact'] && $_SESSION['extra_number'][$counter]['additional_prefix']) {

			

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

			$pdf->Cell(0,2.5, "$address_line_1", '0', 2, 'L', false); //Address Line 1

			if(isset($address_line_2)) {

				$pdf->Cell(0,2.5, "$address_line_2", '0', 2, 'L', false); //Address Line 2

			}

			$pdf->Cell(0,2.5, $address_line_3 . ' USA', '0', 2, 'L', false); //Address Line 3

		} else if($_SESSION['other_address'] == 'yes') {

			$pdf->Cell(0,2.5, "$custom_address_line_1", '0', 2, 'L', false); //Address Line 1

			if(isset($custom_address_line_2)) {

				$pdf->Cell(0,2.5, "$custom_address_line_2", '0', 2, 'L', false); //Address Line 2

			}

			$pdf->Cell(0,2.5, "$custom_address_line_3", '0', 2, 'L', false); //Address Line 3

		}

		

		$pdf->Cell(0,1, "", '0', 2, 'L', false);//Spacer block

		$pdf->Cell(0,2.5, "www.appliedmaterials.com", '0', 2, 'L', false); //Address Line 1

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

		

		$pdf->Cell(0,1, "", '0', 2, 'L', false);//Spacer block

		$pdf->Cell(0,2.5, "www.appliedmaterials.com", '0', 2, 'L', false); //Address Line 1

	} //end if location == non_us_address

	

	



	

	

	

	

	

	

	

	

// Close the document and save to the filesystem with the name simple.pdf

$pdf->Output($first_last_name.'.pdf','I');

?>