<?php

session_start();

ob_start();



if($_SESSION['trans_proof_accepted'] != 'no') {

	header('Location: index.php');	

}



if(isset($_GET['instructions_sent'])) {

	session_destroy(); //destroys all the session variables now that we dont need them anymore	

}





date_default_timezone_set('America/Los_Angeles');



/* //These are the saved session variables

foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop

	//if($value != '') {

		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

	//}

}*/

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Order Form</title>

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

</head>











<body>





<div id="container">







<?php



include("includes/connection.php");

$conn = dbConnect('admin');





include("includes/header.php");







//echo 'SESSION ORDER ID: ' . $_SESSION['order_id'];



//echo '<br />SESSION EMPLOYEE ID: ' . $_SESSION['employee_id'];





$conn->query('SET NAMES utf8');



//Get address

$sql = "SELECT *

		FROM orders

		WHERE order_id = '" . $_SESSION['order_id'] . "' AND employee_id = '" . $_SESSION['employee_id'] . "'";



$result = $conn->query($sql) or die(mysqli_error());



$row = $result->fetch_assoc();



$_SESSION["order_id"] = $row['order_id'];

$_SESSION["order_num"] = $row['order_id'];

$_SESSION["full_name"] = $row['full_name'];

$_SESSION["first_name"] = $row['first_name'];

$_SESSION["last_name"] = $row['last_name'];

$_SESSION["title"] = $row['title'];

$_SESSION["title_2"] = $row['title_2'];

$_SESSION["dept_div"] = $row['dept_div'];

$_SESSION["approved_by"] = $row['approved_by'];

$_SESSION["employee_id"] = $row['employee_id'];

$_SESSION["email_language_proof"] = $row['email_language_proof'];

$_SESSION['employee_id'] = $row['employee_id'];





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











if($row['custom_address'] == 'yes') {

	$sql = "SELECT *

			FROM custom_addresses

			WHERE order_id = '" . $_GET['order_id'] . "'";

			

	$result = $conn->query($sql) or die(mysqli_error());

	$row = $result->fetch_assoc();

	

	$_SESSION['other_address'] = 'yes';

	$_SESSION["custom_address_1"] = $row['line_1'];

	$_SESSION["custom_address_2"] = $row['line_2'];

	$_SESSION["custom_city"] = $row['city'];

	$_SESSION["custom_state"] = $row['state'];

	$_SESSION["custom_zip"] = $row['zip_1'];

	$_SESSION["custom_zip_2"] = $row['zip_2'];

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

































if(isset($_POST['upload'])) {

	$sql = 'UPDATE orders SET

			upload_location = "'.$_SESSION["order_id"] . "_" . $_SESSION['last_name'].'"

			WHERE order_id = ' . $_SESSION["order_id"];

			

	$result = $conn->query($sql) or die(mysqli_error($conn));

	

	

	

	

	

	

	

	if(isset($_FILES['foreign_character_upload']) && $_FILES['foreign_character_upload']['name'] != '') {



		$error = 'no';

		

		$url = "upload/" . $_SESSION["order_id"] . '_' . $_SESSION['last_name'] . "/"; // The directory you want the uploads to go to

		

		$file_name = $_FILES['foreign_character_upload']['name']; // The file name that you uploaded.

		

		$file_name = str_replace(' ','_',$file_name);

		

		$file_type = $_FILES['foreign_character_upload']['type'];

		$file_temp = $_FILES['foreign_character_upload']['tmp_name']; // The temporary location

		$file_size = $_FILES['foreign_character_upload']['size'] / 1024; // The file size in kilobytes

		$size = number_format($file_size, 2); // The file size to 2 decimal places

		

		//Code to get file extension of file

		$file_extension = basename($file_name);

		$file_extension = explode('.', $file_extension);

		$file_extension = $file_extension[count($file_extension)-1];

		

		//This is our size condition

		if ($file_size > 5120) {

			$error_message =  "Your file is too large. Please choose another file.";

			$error = 'yes';

		}

		

		//This is our limit file type condition

		$allowed = array("image/jpg", "image/jpeg", "image/jpe", "application/pdf", "application/msword" );

		if (!in_array($file_type, $allowed)) {

			$error_message =  $file_extension . " files are not allowed. Only jpg, pdf, and word files are accepted. Please choose another file.";

			$error = 'yes';

		}

		

		

		if($error == 'no') { //If there's no validation error, then upload the file

		

			if (!file_exists("upload/" . $_SESSION["order_id"] . '_' . $_SESSION['last_name'])) { //Checks if the directory already exists

				mkdir("upload/" . $_SESSION["order_id"] . '_' . $_SESSION['last_name'], 0755); //Creates a new directory with the order_id and Customer last name

			}

			

			

			if(move_uploaded_file($file_temp, $url.$file_name)) { //This uploads the file into the newly created directory

					/*move_uploaded_file:

					   First parameter is the temporary location,

					   second is the new location (plus name),*/

				

			

				$upload_message = "<p>You just uploaded the file <strong>".$file_name."</strong> with a size of <strong>".$size." KB.</strong></p><p>Upload another file or enter instructions for the corrections needed.</p>";

				

				$_SESSION['uploaded'] = 'yes';

				

				

			} else {

				$upload_message = "<p>There's been a problem uploading your file. Please try again</p>";

			//echo 'Error Code: ' . $_FILES["file"]["error"];

			}

		}



	}	

}







if(isset($_POST['submit'])) {



	if($_POST['instruction_message'] != '') {

		

		

		

		foreach($_SESSION as $key => $value) {

			if(is_array($value)) continue; //This skips the current session variable if it is an array

			if($key == 'ordering_step') continue; //This skips the current session variable if it is named 'ordering_step'

			$_SESSION[$key] = sanitize($conn, $value); //This sanitizes the current session variable and then saves it back as the same session variable name

		}

		

		foreach($_POST as $key => $value) {

			$_POST[$key] = sanitize($conn, $value); //This sanitizes the current session variable and then saves it back as the same session variable name

		}

		

		

		$date_not_approved = date('Y-m-d H:i:s',time()); //Current Date/time in Unix format

		$not_approved = 'waiting_translator';

		

		$sql = 'UPDATE orders

				SET status = ?

				WHERE order_id = ? 

				AND employee_id = ?';

		

		

				

		

			$stmt = $conn->stmt_init(); 

			if ($stmt->prepare($sql)) { 

				$stmt->bind_param('sii', $not_approved, $_SESSION['order_id'], $_SESSION['employee_id']); 

				$done_not_approved = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $done

			}

		

		$date_added = date('Y-m-d H:i:s',time());

		

		//This adds the note marking a change in status		

		$notes_sql = 'INSERT into notes SET

				order_id = "'.$_SESSION['order_id'].'",

				date_added = "'.$date_added.'",

				note_message = "Translation instructions given:<br />'.$_POST['instruction_message'].'"';

		

		$notes_result = $conn->query($notes_sql) or die(mysqli_error($conn));

		

		//This adds the note marking a change in status	

		$notes_sql = 'INSERT into notes SET

				order_id = "'.$_SESSION['order_id'].'",

				date_added = "'.$date_added.'",

				note_message = "'.$note_message['sent_translator'].'"';

				

		$conn->query($notes_sql);

		

		//This adds the note marking a change in status		

		$instruction_sql = 'INSERT into trans_instructions SET

				order_id = "'.$_SESSION['order_id'].'",

				instruction_message = "'.$_POST['instruction_message'].'"';			

		$conn->query($instruction_sql);

		

		

		$instr_sql = "SELECT *

					FROM trans_instructions

					WHERE order_id = '" . $_SESSION['order_id'] . "'";

		

		$instr_result = $conn->query($instr_sql) or die(mysqli_error());

		

		

		$date = date("m/j/y");

			$mailTo = $translator_email;

			$subject = 'Translation Corrections needed for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION['order_num'] . ')';

			$message = 

						'<html>

						<head>

						<title>Translation Corrections Needed</title>

						</head>

						<body style="font-size: 12px;">

							<table style="width: 400px; border: 1px solid #5C7F99; margin-left: auto; margin-right: auto; margin-top: 35px;">

								<thead>

									<tr style="background: #FFFFFF none repeat-x scroll left center; border-bottom: 1px solid #C2C9CF;"><th colspan="2" style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px;"><span style="font-weight: normal;">Translation corrections needed for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION['order_num'] . ')</span></th></tr>   

								</thead>    

								<tbody>

									<tr>

										<td colspan="2" style="padding: 7px 15px; color: #183152; ">

											<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Order #:</span> ' . $_SESSION['order_num'] . '</p>

											<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Language:</span> ';

											

			if($_SESSION["language"] != '') {							

				$message .=	$_SESSION["language"];

			} else {

				$message .=	$_SESSION["other_language"];

			}

			

			$message .=

											'</p>

											<p style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px; margin-top: 22px;">Card Details</p>

											<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Name:</span> ' . $_SESSION["full_name"] . '</p>

											<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Title:</span> ' . $_SESSION["title"] . '</p>';

											

			if($_SESSION["title_2"] != '') {

				$message .=	'<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">2nd Title:</span> ' . $_SESSION["title_2"] . '</p>';

			}

			

			$message .=						

											'<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Dept/Div:</span> ' . $_SESSION["dept_div"] . '</p>';

											

			if($_SESSION["dept_div_2"] != '') {

				$message .= '<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">2nd Dept/Div:</span> ' . $_SESSION["dept_div_2"] . '</p>';

			}

			

			

			

			

			

	

			

			

			

			

			

			

			

			if($_SESSION['upload_location'] != '') {

				$message .=

										'<p style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px; margin-top: 42px;">Download User Provided Characters</p>

										<p>The user has provided artwork that shows their foreign characters.</p>';

										

										

				// directory path can be either absolute or relative

				//$dirPath = $site_basedir . 'upload/' . $_SESSION['upload_location'];

				

				//$message .= '<br /><br />' . $_SESSION['dirPath'];

				

				// open the specified directory and check if it's opened successfully

				if ($handle = opendir($_SESSION['dirPath'])) {

				

				   // keep reading the directory entries 'til the end

				   while (false !== ($file = readdir($handle))) {

				

					  // just skip the reference to current and parent directory

					  if ($file != "." && $file != "..") {

						 if (is_dir("$_SESSION[dirPath]/$file")) {

							// found a directory, do something with it?

							$message .= "[$file]<br>";

						 } else {

							// found an ordinary file

							$message .= "<a target='_blank' href='" . $site_basedir . "upload/" . $_SESSION['upload_location'] . "/$file'>$file</a><br>";

						 }

					  }

				   }

				

				   // ALWAYS remember to close what you opened

				   closedir($handle);

				}

				

				

				

					

				if($_SESSION['foreign_characters_name'] != '' || $_SESSION['foreign_characters_line2'] != '' || $_SESSION['foreign_characters_line3'] != '' || $_SESSION['foreign_characters_line4'] != '') {

					$message .= '<p>The user has provided their own foreign characters for use on their order.</p>';	

				}

					

					

				if($_SESSION['foreign_characters_name'] != '') {

					$message .= '<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Name:</span> ' . html_entity_decode($_SESSION["foreign_characters_name"]) . '</p>';

				}

				

				if($_SESSION['foreign_characters_line2'] != '') {

					$message .= '<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Line 2:</span> ' . $_SESSION["foreign_characters_line2"] . '</p>';

				}

				

				if($_SESSION['foreign_characters_line3'] != '') {

					$message .= '<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Line 3:</span> ' . $_SESSION["foreign_characters_line3"] . '</p>';

				}

				

				if($_SESSION['foreign_characters_line4'] != '') {

					$message .= '<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Line 4:</span> ' . $_SESSION["foreign_characters_line4"] . '</p>';

				}

			}

				

				

			$message .=

										'<p style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px; margin-top: 42px;">Instructions for Corrections</p>

										<p>The user has provided instructions for corrections on their translation.</p>

										<p>'; 

			$i = 1;							

			while ($instr_row = $instr_result->fetch_assoc()) {				

				$message .= '(' . $i . ') ' . $instr_row['instruction_message'] . '<br />';

				$i++;

			}

						

										

										

			$message .=					'</p>';

			

			

			

			$message .=

										'<p style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px; margin-top: 42px;">Upload Link</p>

										<p>Use this link to upload the corrected translations for this order once completed.</p>

										<p><a href="' . $site_basedir . 'admin/trans_char_upload.php?order_id=' . $_SESSION['order_num'] . '">Upload Corrected Translation PDF here</a></p>

										

										

										

										

										

										

										

										</td>

										

									</tr> 

								</tbody>     

							</table>

						</body>

						</html>';

						

			

			$headers  = 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			$headers .= 'From: Pro Print & Services <' . $pro_print_email . '>';

			

			mail($mailTo, $subject, $message, $headers);



		header('Location: ' . $site_basedir . 'trans_not_approved.php?instructions_sent=1');

	} else {

		$submit_error = '<p class="error_message">Please provide instructions for the translator as to how to make corrections to your translation proof. The order can not continue without this.</p>';	

	}





}











if(isset($_GET['instructions_sent'])) {

?>

	<div class="form_container" id="thank_you_box">  

        <div class="row">

            <div class="clientform_table_header">Your order has been sent back to the translator</div>   

        </div>

        

        <div class="row">

            <div class="content">

                <p>Your order has been sent back to the translator with the detailed instructions you provided. Please be aware that you will receive another translation proof soon. Make sure you review that proof as soon as possible.</p>

			</div>

          </div>       

    </div>





<?php } else { ?>





    

    <div class="form_container" id="thank_you_box">  

        <div class="row">

            <div class="clientform_table_header">Please provide instructions for needed translation corrections</div>   

        </div>

        

        

        

        <div class="row">

            <div class="content">

                <p>Would you like to upload any additional artwork or files describing the characters?<span class="warning">(pdf,jpg,word files only)</span></p>

                    

                <div id="upload_area">

                    <form id="clientForm" name="clientForm" method="post" action="" enctype="multipart/form-data">

                        <label for="foreign_character_upload">Upload Foreign Characters</label>

                        <div id="divinputfile">

                            <input name="foreign_character_upload" type="file" size="30" id="filepc" onchange="document.getElementById('fakefilepc').value = this.value;" />

                            <div id="fakeinputfile">

                                <input name="fakefilepc" type="text" id="fakefilepc" />

                            </div>

                        </div>

					<input class="button next submit" type="submit" name="upload" value="Upload" style="margin-right: 47px; margin-top: 14px;"/>

                    </form>

                    <div id="upload_message" style="width: 238px;"><?php

                            if($error == 'yes') { //if there's a validation error message show it

                                echo $error_message;	

                            } else if(isset($upload_message)) { //else if the file was uploaded, show the appropriate message

                                echo $upload_message; 

                            } else { //Else show the default message

                                echo '<p>Click Choose File, locate the file, and click on Upload.</p>';	

                            }

                        ?>

                    </div>

                </div>

                

			</div>

          </div>      

         

        <div class="row">

            <div class="content" id="thankyou_last_content_1">

                <p>Please provide detailed instructions as to how the translator can correct the translation.</p>

                

                <form id="clientForm" name="clientForm" method="post" action="">

                	<textarea name="instruction_message" style="width: 375px; margin-top: 10px;"></textarea>                

                <?php if(isset($submit_error)) {echo $submit_error;} ?>  <input class="button next submit" type="submit" name="submit" value="Submit for Corrections" style="margin-right: 22px; margin-top: 7px;"/></form> 

          </div>

        </div> 



    </div> 

     

<?php }   





	?>    

          

		 

</div>



</body>



</html>