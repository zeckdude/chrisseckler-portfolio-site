<?php

session_start();

ob_start();



date_default_timezone_set('America/Los_Angeles');

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Translator Upload Center</title>

<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" charset="utf-8" />

<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<link rel="shortcut icon" href="../images/favicon.gif" />

</head>



<script src="../js/jquery-1.4.2.min.js" type="text/javascript"></script>











<body>





<div id="container">





<?php 













//echo 'update_error: ' . $location_updated;



include("../includes/connection.php");

$conn = dbConnect("admin");









if(!isset($_SESSION['authenticated_translator'])){

	header('Location: ' . $site_basedir . 'admin/trans_login.php');

}







$sql = "SELECT *

		FROM orders

		WHERE order_id = '" . $_GET['order_id'] . "'";



$result = $conn->query($sql) or die(mysqli_error());



$row = $result->fetch_assoc();





$instr_sql = "SELECT *

			FROM trans_instructions

			WHERE order_id = '" . $_GET['order_id'] . "'";



$instr_result = $conn->query($instr_sql) or die(mysqli_error());

$instr_row_cnt = $instr_result->num_rows;







if(!isset($_GET['order_id'])) {

	header('Location: ../index.php');											  

}





$order_id = $row['order_id'];

	

	$_SESSION['order_num'] = $row['order_id'];

	$_SESSION['first_name'] = $row['first_name'];

	$_SESSION['last_name'] = $row['last_name'];

	$_SESSION['language'] = $row['language'];

	$_SESSION['other_language'] = $row['other_language'];

	$_SESSION['full_name'] = $row['full_name'];

	$_SESSION['title'] = $row['title'];

	$_SESSION['title_2'] = $row['title_2'];

	$_SESSION['dept_div'] = $row['dept_div'];

	$_SESSION['dept_div_2'] = $row['dept_div_2'];

	$_SESSION['upload_location'] = $row['upload_location'];

	$_SESSION['foreign_characters_name'] = $row['foreign_characters_name'];

	$_SESSION['foreign_characters_line2'] = $row['foreign_characters_line2'];

	$_SESSION['foreign_characters_line3'] = $row['foreign_characters_line3'];

	$_SESSION['foreign_characters_line4'] = $row['foreign_characters_line4'];

	$_SESSION['dirPath'] = 'upload/' . $_SESSION['upload_location'];

	$_SESSION["email_language_proof"] = $row['email_language_proof'];

	$_SESSION["employee_id"] = $row['employee_id'];

	$_SESSION['date_submitted'] = $row['date_submitted'];









if(isset($_POST['upload_foreign_next'])) {

	

	if(isset($_FILES['foreign_character_upload']) && $_FILES['foreign_character_upload']['name'] != '') {

		$error = 'no';

		

		//$last_name = 

		

		$url = "../trans_upload/" . $order_id . '_' . $row['last_name'] . "/"; // The directory you want the uploads to go to

		

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

		

		/*//Debugging

		echo 'URL: ' . $url . '<br/>';

		echo 'File Name: ' . $file_name . '<br/>';

		echo 'File extension: ' . $file_extension . '<br/>'; 

		echo 'File Type: ' . $file_type . '<br/>';

		echo 'Temporary Location: ' . $file_temp . '<br/>';

		echo 'File Size: ' . $size . '<br/>';*/

		

		

		//This is our size condition

		if ($file_size > 10120) {

			$error_message =  "Your file is too large. Please choose another file.";

			$error = 'yes';

		}

		

		//This is our limit file type condition

		$allowed = array("application/pdf", "application/x-pdf", "application/acrobat", "applications/vnd.pdf", "text/pdf", "text/x-pdf");

		//if (!in_array($file_type, $allowed)) {
			
		if($file_extension != 'pdf') {

			$error_message =  $file_extension . " files are not allowed. Only pdf files are accepted. Please choose another file.";

			$error = 'yes';

		}

		

		

		if($error == 'no') { //If there's no validation error, then upload the file

		

			if (!file_exists("../trans_upload/" . $order_id . '_' . $row['last_name'])) { //Checks if the directory already exists

				mkdir("../trans_upload/" . $order_id . '_' . $row['last_name'], 0755); //Creates a new directory with the order_id and Customer last name

			}

			

			$new_file_name = 'translation.pdf';

			

			if(move_uploaded_file($file_temp, $url.$new_file_name)) { //This uploads the file into the newly created directory

					/*move_uploaded_file:

					   First parameter is the temporary location,

					   second is the new location (plus name),*/

				

			

				$upload_message = "<p>You just uploaded the file <strong>".$file_name."</strong> with a size of <strong>".$size." KB.</strong></p><p>Click the Next Step button to continue.</p>";

				

				$_SESSION['uploaded'] = 'yes';

				

				

			} else {

				$upload_message = "<p>There's been a problem uploading your file. Please try again</p>";

			//echo 'Error Code: ' . $_FILES["file"]["error"];

			}

		}



	} else {//end if isset foreign_character_upload

	

		if($_SESSION['uploaded'] == 'yes') {

			

			/*These are things to do only after the user uploads ALL artwork*/

			

			$date_trans_upload = date('Y-m-d H:i:s',time()); //Current Date/time in Unix format

			

			//It changes the status to waiting_trans_approval

			$status_sql = 'UPDATE orders

						SET status = "waiting_trans_approval",

						date_trans_upload = "' . $date_trans_upload . '" 

						WHERE order_id = ' . $order_id;

						

			$conn->query($status_sql);

			

			$date_added = date('Y-m-d H:i:s',time());	

			

			//This adds the note marking a change in status	

			$notes_sql = 'INSERT into notes SET

					order_id = "'.$_SESSION['order_num'].'",

					date_added = "'.$date_added.'",

					note_message = "'.$note_message['trans_uploaded'].'"';

					

			$conn->query($notes_sql);

			

			//This adds the note marking a change in status	

			$notes_sql = 'INSERT into notes SET

					order_id = "'.$_SESSION['order_num'].'",

					date_added = "'.$date_added.'",

					note_message = "'.$note_message['waiting_trans_approval'].'"';

					

			$conn->query($notes_sql);

			

			include("../includes/trans_approval_mail.php");

			

			header('Location: trans_center.php');

			

		} else {

			$error = 'yes';

			$error_message = 'You must upload a file before you may continue.';	

		}

	}

	

} //end if isset upload_foreign_next

























if($row["language"]) {

	$language_chosen = $row["language"];

} else if($row["other_language"]) {

	$language_chosen = $row["other_language"];

}



 ?>

 

 	<div id="admin_header">

        <a href="../index.php"><h1>Applied Materials Business Card Order Center</h1></a>

        <p>Translator Upload Center</p>

            <div id="admin_nav">

                <a class="button" href="trans_center.php">List of Translations needed</a>

            </div>

    </div>

    

    <?php if($row['status'] == 'waiting_translator') { ?>



        <div class="form_container" id="upload_foreign">  

            <div class="row">

                <div class="clientform_table_header">Upload Translation PDF for Order #<?php echo $_GET['order_id']; ?></div>   

            </div>

             

             

             

            <div class="row">   	

                <div class="content">

                    <p style="margin-bottom: 15px;">Please upload the translation PDF for <?php echo $language_chosen . ' for ' . $row['first_name'] . ' ' . $row['last_name']; ?>.</p>

                    <p>The order is being held until foreign characters it has been uploaded.</p>

                    <p><span class="warning">If you want to upload files, click the Choose File button.</span></p>

                    

                    <div id="upload_area">

                        <form id="clientForm" name="clientForm" method="post" action="" enctype="multipart/form-data">

                            <label for="foreign_character_upload">Upload Foreign Characters PDF</label>

                            <div id="divinputfile">

                                <input name="foreign_character_upload" type="file" size="30" id="filepc" onchange="document.getElementById('fakefilepc').value = this.value;" />

                                <div id="fakeinputfile">

                                    <input name="fakefilepc" type="text" id="fakefilepc" />

                                </div>

                            </div>

        

                        <div id="upload_message"><?php

                                if($error == 'yes') { //if there's a validation error message show it

                                    echo $error_message;	

                                } else if(isset($upload_message)) { //else if the file was uploaded, show the appropriate message

                                    echo $upload_message; 

                                } else { //Else show the default message

                                    echo '<p>Click browse, locate the file, and click on Next Step.</p>';	

                                }

                            ?>

                        </div>

                    </div>

                </div>

            </div> 



            <div class="row">

                <div class="content" id="last_content">

                    <input class="button next submit" id="upload_foreign_submit" type="submit" name="upload_foreign_next" value="Next Step" />

                    </form>

                </div>

            </div>	 

        </div>

	<?php } else { ?>

    	<div class="form_container" id="upload_foreign">

        	<div class="row">

                <div class="clientform_table_header">Upload Translation Characters for Order #<?php echo $_GET['order_id']; ?></div>   

            </div>



        	<div class="row">   	

                <div class="content">     

                    <p>You have already uploaded characters for this order. The order status of this order has already been changed. If you have any additional characters that need to be uploaded for this order contact Pro Print & Services at (650)670-2405.</p>

                </div>

            </div>

        </div>

    <?php } ?>



</body>



</html>