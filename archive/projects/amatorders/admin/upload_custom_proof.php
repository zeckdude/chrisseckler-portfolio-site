<?php

session_start();

ob_start();



date_default_timezone_set('America/Los_Angeles');















/*foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop

	//if($value != '') {

		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

	//}

}*/ 







?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Custom Proof Upload Center</title>

<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" charset="utf-8" />

<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<link rel="shortcut icon" href="../images/favicon.gif" />

</head>



<script src="../js/jquery-1.4.2.min.js" type="text/javascript"></script>











<body>









<div id="container">





<?php 



include("../includes/connection.php");

$conn = dbConnect("admin");









if(!isset($_SESSION['authenticated_oc'])){

	header('Location: ' . $site_basedir . 'login.php');

}















$sql = "SELECT *

		FROM orders

		WHERE order_id = '" . $_GET['order_id'] . "'";



$result = $conn->query($sql) or die(mysqli_error());



$row = $result->fetch_assoc();





$custom_sql = "SELECT *

			FROM custom_instructions

			WHERE order_id = '" . $_GET['order_id'] . "'";



$custom_result = $conn->query($custom_sql) or die(mysqli_error());

$custom_row_cnt = $custom_result->num_rows;







if(!isset($_GET['order_id'])) {

	header('Location: ../index.php');											  

}



$_SESSION['custom_manager_approval'] = 'no';



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

	$_SESSION['delivery_email'] = $row['delivery_email'];

	$_SESSION["date_approved"] = $row['date_approved'];

	

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

?>





<script>

      $(document).ready(function(){

			/*Full Name value replace*/

			var fullName = '';

					

			$('input[name="full_name"]').focusin(function() {

				if($(this).val() == '<?php echo $_SESSION['full_name']; ?>') {							   

					$(this).val("");	

				} else if($(this).val() == fullName) {

					$(this).val("");

				}

				

				

		 	});

			

			$('input[name="full_name"]').focusout(function() {

				

				if($(this).val() !== '') {

					fullName = 	$(this).val();

				}

														   

				if($(this).val() == '') {

					if(fullName !== '') {

						$(this).val(fullName);	

					} else {

						$(this).val("<?php echo $_SESSION['full_name']; ?>");

					}

				}

		 	});

			

			

			/*Title value replace*/

			var title = '';

			

			$('input[name="title"]').focusin(function() {

				if($(this).val() == '<?php echo $_SESSION['title']; ?>') {							   

					$(this).val("");	

				} else if($(this).val() == title) {

					$(this).val("");

				}

				

				

		 	});

			

			$('input[name="title"]').focusout(function() {

				

				if($(this).val() !== '') {

					title = 	$(this).val();

				}

														   

				if($(this).val() == '') {

					if(title !== '') {

						$(this).val(title);	

					} else {

						$(this).val("<?php echo $_SESSION['title']; ?>");

					}

				}

		 	});

			

			

			/*Title 2 value replace*/

			var title_2 = '';

			

			$('input[name="title_2"]').focusin(function() {

				if($(this).val() == '<?php echo $_SESSION['title_2']; ?>') {							   

					$(this).val("");	

				} else if($(this).val() == title_2) {

					$(this).val("");

				}

				

				

		 	});

			

			$('input[name="title_2"]').focusout(function() {

				

				if($(this).val() !== '') {

					title_2 = 	$(this).val();

				}

														   

				if($(this).val() == '') {

					if(title_2 !== '') {

						$(this).val(title_2);	

					} else {

						$(this).val("<?php echo $_SESSION['title_2']; ?>");

					}

				}

		 	});

			

			

			/*Dept/Div value replace*/

			var dept_div = '';

			

			$('input[name="dept_div"]').focusin(function() {

				if($(this).val() == '<?php echo $_SESSION['dept_div']; ?>') {							   

					$(this).val("");	

				} else if($(this).val() == dept_div) {

					$(this).val("");

				}

				

				

		 	});

			

			$('input[name="dept_div"]').focusout(function() {

				

				if($(this).val() !== '') {

					dept_div = 	$(this).val();

				}

														   

				if($(this).val() == '') {

					if(dept_div !== '') {

						$(this).val(dept_div);	

					} else {

						$(this).val("<?php echo $_SESSION['dept_div']; ?>");

					}

				}

		 	});

			

			

			/*Dept/Div 2 value replace*/

			var dept_div_2 = '';

			

			$('input[name="dept_div_2"]').focusin(function() {

				if($(this).val() == '<?php echo $_SESSION['dept_div_2']; ?>') {							   

					$(this).val("");	

				} else if($(this).val() == dept_div_2) {

					$(this).val("");

				}

				

				

		 	});

			

			$('input[name="dept_div_2"]').focusout(function() {

				

				if($(this).val() !== '') {

					dept_div_2 = 	$(this).val();

				}

														   

				if($(this).val() == '') {

					if(dept_div_2 !== '') {

						$(this).val(dept_div_2);	

					} else {

						$(this).val("<?php echo $_SESSION['dept_div_2']; ?>");

					}

				}

		 	});

			

			

	  }); //end document ready

</script>











<?php



function rmdir_recursive($dir) {		

	$files = scandir($dir);		

	array_shift($files);    // remove '.' from array	

	array_shift($files);    // remove '..' from array

	

	foreach ($files as $file) {	

		$file = $dir . '/' . $file;	

		if (is_dir($file)) {	

			rmdir_recursive($file);	

			rmdir($file);	

		} else {

			unlink($file);		

		}

	}

	rmdir($dir);

}



	







if(isset($_POST['upload_next'])) {

	

	if(isset($_FILES['english_upload']) && $_FILES['english_upload']['name'] != '') {

		$english_error = 'no';	

		$url = "../custom_upload/" . $order_id . '_' . $row['last_name'] . "/english/"; // The directory you want the uploads to go to	

		$file_name = $_FILES['english_upload']['name']; // The file name that you uploaded.

		$file_name = str_replace(' ','_',$file_name);

		$orig_file_name = $file_name;

		$file_type = $_FILES['english_upload']['type'];

		$file_temp = $_FILES['english_upload']['tmp_name']; // The temporary location

		$file_size = $_FILES['english_upload']['size'] / 1024; // The file size in kilobytes

		$size = number_format($file_size, 2); // The file size to 2 decimal places

		

		//Code to get file extension of file

		$file_extension = basename($file_name);

		$file_extension = explode('.', $file_extension);

		$file_extension = $file_extension[count($file_extension)-1];

		

		

		//Defining the name of the file that is being uploaded so it can easily be referenced later

		$file_name = 'english.pdf';

		

		//This is our size condition

		if ($file_size > 5120) {

			$english_error_message =  "Your file is too large. Please choose another file.";

			$english_error = 'yes';

		}

		

		//This is our limit file type condition

		$allowed = array("application/pdf", "application/x-pdf", "application/acrobat", "applications/vnd.pdf", "text/pdf", "text/x-pdf");

		//if (!in_array($file_type, $allowed)) {

		if ($file_extension != 'pdf') {

			$english_error_message =  $file_extension . " files are not allowed. Only pdf files are accepted. Please choose another file.";

			$english_error = 'yes';

		}



		if($english_error == 'no') { //If there's no validation error, then upload the file



			//This erases the folder and its contents if the upload is for a correction

			if($custom_row_cnt > 0) {

				$dir = "../custom_upload/" . $order_id . '_' . $row['last_name'] . '/english/';		  

				 rmdir_recursive($dir); 

			}

			

			if (!file_exists("../custom_upload/" . $order_id . '_' . $row['last_name'])) { //Checks if the directory already exists

				mkdir("../custom_upload/" . $order_id . '_' . $row['last_name'], 0755); //Creates a new directory with the order_id and Customer last name

			}

			

			if (!file_exists("../custom_upload/" . $order_id . '_' . $row['last_name'] . '/english/')) { //Checks if the directory already exists

				mkdir("../custom_upload/" . $order_id . '_' . $row['last_name'] . '/english/', 0755); //Creates a new directory with the order_id and Customer last name

			}

			

			if(move_uploaded_file($file_temp, $url.$file_name)) { //This uploads the file into the newly created directory

				

				$english_upload_message = "<p>You just uploaded the file <strong>".$orig_file_name."</strong> with a size of <strong>".$size." KB.</strong></p>";

				

				$instruction_message = "<p class='instruction_message'>Click the Next Step button to continue when you are done uploading all proofs.</p>";

				

				$_SESSION['english_uploaded'] = 'yes';	

			} else {

				$english_upload_message = "<p>There's been a problem uploading your file. Please try again</p>";

			//echo 'Error Code: ' . $_FILES["file"]["error"];

			}

		}



	} //end if isset english_upload

	

	

	

	

	if(isset($_FILES['foreign_upload']) && $_FILES['foreign_upload']['name'] != '') {

		$foreign_error = 'no';	

		$url = "../custom_upload/" . $order_id . '_' . $row['last_name'] . "/foreign/"; // The directory you want the uploads to go to	

		$file_name = $_FILES['foreign_upload']['name']; // The file name that you uploaded.

		$file_name = str_replace(' ','_',$file_name);

		$orig_file_name = $file_name;

		$file_type = $_FILES['foreign_upload']['type'];

		$file_temp = $_FILES['foreign_upload']['tmp_name']; // The temporary location

		$file_size = $_FILES['foreign_upload']['size'] / 1024; // The file size in kilobytes

		$size = number_format($file_size, 2); // The file size to 2 decimal places

		

		//Code to get file extension of file

		$file_extension = basename($file_name);

		$file_extension = explode('.', $file_extension);

		$file_extension = $file_extension[count($file_extension)-1];

		

		//Defining the name of the file that is being uploaded so it can easily be referenced later

		$file_name = 'foreign.pdf';

		

		//This is our size condition

		if ($file_size > 5120) {

			$foreign_error_message =  "Your file is too large. Please choose another file.";

			$foreign_error = 'yes';

		}

		

		//This is our limit file type condition

		$allowed = array("application/pdf", "application/x-pdf", "application/acrobat", "applications/vnd.pdf", "text/pdf", "text/x-pdf");

		//if (!in_array($file_type, $allowed)) {

		if ($file_extension != 'pdf') {

			$foreign_error_message =  $file_extension . " files are not allowed. Only pdf files are accepted. Please choose another file.";

			$foreign_error = 'yes';

		}



		if($foreign_error == 'no') { //If there's no validation error, then upload the file



			//This erases the folder and its contents if the upload is for a correction

			if($custom_row_cnt > 0) {

				$dir = "../custom_upload/" . $order_id . '_' . $row['last_name'] . '/foreign/';		  

				 rmdir_recursive($dir); 

			}

			

			if (!file_exists("../custom_upload/" . $order_id . '_' . $row['last_name'])) { //Checks if the directory already exists

				mkdir("../custom_upload/" . $order_id . '_' . $row['last_name'], 0755); //Creates a new directory with the order_id and Customer last name

			}

			

			if (!file_exists("../custom_upload/" . $order_id . '_' . $row['last_name'] . '/foreign/')) { //Checks if the directory already exists

				mkdir("../custom_upload/" . $order_id . '_' . $row['last_name'] . '/foreign/', 0755); //Creates a new directory with the order_id and Customer last name

			}

			

			if(move_uploaded_file($file_temp, $url.$file_name)) { //This uploads the file into the newly created directory

				

				$foreign_upload_message = "<p>You just uploaded the file <strong>".$orig_file_name."</strong> with a size of <strong>".$size." KB.</strong></p>";

				

				$instruction_message = "<p class='instruction_message'>Click the Next Step button to continue when you are done uploading all proofs.</p>";

				

				$_SESSION['foreign_uploaded'] = 'yes';	

			} else {

				$foreign_upload_message = "<p>There's been a problem uploading your file. Please try again</p>";

			//echo 'Error Code: ' . $_FILES["file"]["error"];

			}

		}



	}

	

	else if($_FILES['english_upload']['name'] == '' && $_FILES['foreign_upload']['name'] == '') { //end if isset foreign_upload

		

		if($_SESSION['english_cards_ordered'] == 'yes') { //Checks to see if English cards were ordered and if so was an English Proof uploaded	

			if($_SESSION['english_uploaded'] != 'yes') {

				$english_error = 'yes';

				$english_error_message = '<p class="instruction_message">You must upload a file before you may continue.</p>';	

			}

		}

		

		if($_SESSION['foreign_cards_ordered'] == 'yes') { //Checks to see if Foreign cards were ordered and if so was a Foreign Proof uploaded	

			if($_SESSION['foreign_uploaded'] != 'yes') {

				$foreign_error = 'yes';

				$foreign_error_message = '<p class="instruction_message">You must upload a file before you may continue.</p>';	

			}

		}

		

		$date_custom_upload = date('Y-m-d H:i:s',time()); //Current Date/time in Unix format

		

		//Only english Cards

		if($_SESSION['english_cards_ordered'] == 'yes' && $_SESSION['foreign_cards_ordered'] == 'no') {

			if($_SESSION['english_uploaded'] == 'yes') {

				//It changes the status to waiting_custom_approval

				$status_sql = 'UPDATE orders

							SET status = "waiting_custom_approval",

							date_custom_upload = "' . $date_custom_upload . '"

							WHERE order_id = ' . $order_id;

							

				$conn->query($status_sql);

				

				$date_added = date('Y-m-d H:i:s',time());	

				

				//This adds the note marking a change in status	

				$notes_sql = 'INSERT into notes SET

						order_id = "'.$_SESSION['order_num'].'",

						date_added = "'.$date_added.'",

						note_message = "'.$note_message['custom_uploaded'].'"';

						

				$conn->query($notes_sql);

				

				if($_SESSION["date_approved"] == '0000-00-00 00:00:00' || $_SESSION["date_approved"] == '') { //If the order has not been approved by the Manager

					$_SESSION['custom_manager_approval'] = 'yes';

					include("../includes/manager_mail.php"); //Send the Manager a notice to approve

					

					$status_sql = 'UPDATE orders

								SET status = "waiting_approval",

								date_custom_upload = "' . $date_custom_upload . '"

								WHERE order_id = ' . $order_id;

								

					$conn->query($status_sql);

					

					//This adds the note marking a change in status	

					$notes_sql = 'INSERT into notes SET

							order_id = "'.$_SESSION['order_num'].'",

							date_added = "'.$date_added.'",

							note_message = "'.$note_message['waiting_approval'].'"';

							

					$conn->query($notes_sql);

					

				} else {

					include("../includes/custom_approval_mail.php"); //If it has been approved, then send the user a notice to approve the custom proof PDF

					

					//This adds the note marking a change in status	

					$notes_sql = 'INSERT into notes SET

							order_id = "'.$_SESSION['order_num'].'",

							date_added = "'.$date_added.'",

							note_message = "'.$note_message['waiting_custom_approval'].'"';

							

					$conn->query($notes_sql);

				}

				

				header('Location: customproofs.php');

			} 

		}

		

		//Only foreign Cards

		if($_SESSION['foreign_cards_ordered'] == 'yes' && $_SESSION['english_cards_ordered'] == 'no') {

			if($_SESSION['foreign_uploaded'] == 'yes') {

				//It changes the status to waiting_custom_approval

				$status_sql = 'UPDATE orders

							SET status = "waiting_custom_approval",

							date_custom_upload = "' . $date_custom_upload . '"

							WHERE order_id = ' . $order_id;

							

				$conn->query($status_sql);

				

				$date_added = date('Y-m-d H:i:s',time());	

				

				//This adds the note marking a change in status	

				$notes_sql = 'INSERT into notes SET

						order_id = "'.$_SESSION['order_num'].'",

						date_added = "'.$date_added.'",

						note_message = "'.$note_message['custom_uploaded'].'"';

						

				$conn->query($notes_sql);

				

				//This adds the note marking a change in status	

				$notes_sql = 'INSERT into notes SET

						order_id = "'.$_SESSION['order_num'].'",

						date_added = "'.$date_added.'",

						note_message = "'.$note_message['waiting_custom_approval'].'"';

						

				$conn->query($notes_sql);

				

				if($_SESSION["date_approved"] == '0000-00-00 00:00:00' || $_SESSION["date_approved"] == '') { //If the order has not been approved by the Manager

					$_SESSION['custom_manager_approval'] = 'yes';

					include("../includes/manager_mail.php"); //Send the Manager a notice to approve

					

					

					$status_sql = 'UPDATE orders

								SET status = "waiting_approval",

								date_custom_upload = "' . $date_custom_upload . '"

								WHERE order_id = ' . $order_id;

								

					$conn->query($status_sql);

					

					//This adds the note marking a change in status	

					$notes_sql = 'INSERT into notes SET

							order_id = "'.$_SESSION['order_num'].'",

							date_added = "'.$date_added.'",

							note_message = "'.$note_message['waiting_approval'].'"';

							

					$conn->query($notes_sql);

					

				} else {

					include("../includes/custom_approval_mail.php"); //If it has been approved, then send the user a notice to approve the custom proof PDF

					

					//This adds the note marking a change in status	

					$notes_sql = 'INSERT into notes SET

							order_id = "'.$_SESSION['order_num'].'",

							date_added = "'.$date_added.'",

							note_message = "'.$note_message['waiting_custom_approval'].'"';

							

					$conn->query($notes_sql);

				}

				

				header('Location: customproofs.php');

			} 

		}

		

		//Both english & foreign Cards

		if($_SESSION['english_cards_ordered'] == 'yes' && $_SESSION['foreign_cards_ordered'] == 'yes') {

			if($_SESSION['english_uploaded'] == 'yes') {

				if($_SESSION['foreign_uploaded'] == 'yes') {

					//It changes the status to waiting_custom_approval

					$status_sql = 'UPDATE orders

								SET status = "waiting_custom_approval",

								date_custom_upload = "' . $date_custom_upload . '"

								WHERE order_id = ' . $order_id;

								

					$conn->query($status_sql);

					

					$date_added = date('Y-m-d H:i:s',time());	

					

					//This adds the note marking a change in status	

					$notes_sql = 'INSERT into notes SET

							order_id = "'.$_SESSION['order_num'].'",

							date_added = "'.$date_added.'",

							note_message = "'.$note_message['custom_uploaded'].'"';

							

					$conn->query($notes_sql);

					

					//This adds the note marking a change in status	

					$notes_sql = 'INSERT into notes SET

							order_id = "'.$_SESSION['order_num'].'",

							date_added = "'.$date_added.'",

							note_message = "'.$note_message['waiting_custom_approval'].'"';

							

					$conn->query($notes_sql);

					

					if($_SESSION["date_approved"] == '0000-00-00 00:00:00' || $_SESSION["date_approved"] == '') { //If the order has not been approved by the Manager

						$_SESSION['custom_manager_approval'] = 'yes';

						include("../includes/manager_mail.php"); //Send the Manager a notice to approve

						

						

						

						$status_sql = 'UPDATE orders

									SET status = "waiting_approval",

									date_custom_upload = "' . $date_custom_upload . '"

									WHERE order_id = ' . $order_id;

									

						$conn->query($status_sql);

						

						//This adds the note marking a change in status	

						$notes_sql = 'INSERT into notes SET

								order_id = "'.$_SESSION['order_num'].'",

								date_added = "'.$date_added.'",

								note_message = "'.$note_message['waiting_approval'].'"';

								

						$conn->query($notes_sql);

						

					} else {

						include("../includes/custom_approval_mail.php"); //If it has been approved, then send the user a notice to approve the custom proof PDF

						

						//This adds the note marking a change in status	

						$notes_sql = 'INSERT into notes SET

								order_id = "'.$_SESSION['order_num'].'",

								date_added = "'.$date_added.'",

								note_message = "'.$note_message['waiting_custom_approval'].'"';

								

						$conn->query($notes_sql);

					}

					

					header('Location: customproofs.php');

				}

			}

		}

	

		

	}

	

	

	

} //end if isset upload_foreign_next

























if($row["language"]) {

	$language_chosen = $row["language"];

} else if($row["other_language"]) {

	$language_chosen = $row["other_language"];

}





include("../includes/admin_header.php");

 ?>

 

 	

    

    <?php if($row['status'] == 'custom_proof' || $row['status'] == 'waiting_corrections') { 

	

	

	/*echo 'Session Test: ' . $_SESSION['test'] . '<br /><br />';

	

	echo 'English Error Message: ' . $english_error_message . '<br /><br />';

	

	echo 'Foreign Error Message: ' . $foreign_error_message . '<br /><br />';*/

	

	

	?>



        <div class="form_container" id="upload_foreign">  

            <div class="row">

                <div class="clientform_table_header">Upload Custom Proof PDF for Order #<?php echo $_GET['order_id']; ?></div>   

            </div>

            

            <div class="row">   	

                <div class="content">

                    <p style="margin-bottom: 15px;">Please upload the custom proof PDF for <?php echo $row['first_name'] . ' ' . $row['last_name']; ?>.</p>

                    <p>The order is being held until the custom proof PDF has been uploaded.</p>

                    <p><span class="warning">If you want to upload a file, click the Choose File button.</span></p>

				</div>

			</div>

            

            

            <?php if($_SESSION['english_cards_ordered'] == 'yes') { ?>

                <div class="row">   	

                    <div class="content">        

                        <div id="upload_area" style="margin-top: 0px;">

                            <form id="clientForm" name="clientForm" method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">

                                <label for="english_upload">Upload English Custom Proof PDF</label>

                                <div id="divinputfile">

                                    <input name="english_upload" type="file" size="30" id="filepc" onchange="document.getElementById('fakefilepc').value = this.value;" />

                                    <div id="fakeinputfile">

                                        <input name="fakefilepc" type="text" id="fakefilepc" />

                                    </div>

                                </div>

            

                            <div id="upload_message"><?php

                                    if($english_error == 'yes') { //if there's a validation error message show it

                                        echo $english_error_message;	

                                    } else if(isset($english_upload_message)) { //else if the file was uploaded, show the appropriate message

                                        echo $english_upload_message; 

                                    } else { //Else show the default message

                                        echo '<p>Click browse, locate the file, and click on Next Step.</p>';	

                                    }

                                ?>

                            </div>

                        </div>

                    </div>

                </div>

			<?php } ?>

            

            

            <?php 
			if($_SESSION['foreign_cards_ordered'] == 'yes') { ?>

                <div class="row">   	

                    <div class="content">        

                        <div id="upload_area" style="margin-top: 0px;">

                            <form id="clientForm" name="clientForm" method="post" action="" enctype="multipart/form-data" accept-charset="utf-8">

                                <label for="foreign_upload">Upload Foreign Custom Proof PDF</label>

                                <div id="divinputfile">

                                    <input name="foreign_upload" type="file" size="30" id="filepc" onchange="document.getElementById('fakefilepc2').value = this.value;" />

                                    <div id="fakeinputfile">

                                        <input name="fakefilepc2" type="text" id="fakefilepc2" />

                                    </div>

                                </div>

            

                            <div id="upload_message"><?php

                                    if($foreign_error == 'yes') { //if there's a validation error message show it

                                        echo $foreign_error_message;	

                                    } else if(isset($foreign_upload_message)) { //else if the file was uploaded, show the appropriate message

                                        echo $foreign_upload_message; 

                                    } else { //Else show the default message

                                        echo '<p>Click browse, locate the file, and click on Next Step.</p>';	

                                    }

                                ?>

                            </div>

                        </div>

                    </div>

                </div>

			<?php } 

			

			

			if(isset($instruction_message)) {

			?>

            	<div class="row">

                    <div class="content">

                        <?php echo $instruction_message; ?>

                    </div>

                </div>

			<?php } ?>

            

             

                

                

            

            <div class="row">

                <div class="content" id="last_content">

                    <input class="button next submit" id="upload_foreign_submit" type="submit" name="upload_next" value="Next Step" />

                    </form>

                </div>

            </div>	 

        </div>

	<?php } else { ?>

    	<div class="form_container" id="upload_foreign">

        	<div class="row">

                <div class="clientform_table_header">Upload Custom Proof PDF for Order #<?php echo $_GET['order_id']; ?></div>   

            </div>



        	<div class="row">   	

                <div class="content">     

                    <p>You have already uploaded a custom proof PDF for this order. The order status of this order has already been changed.</p>

                </div>

            </div>

        </div>

    <?php } ?>



</body>



</html>