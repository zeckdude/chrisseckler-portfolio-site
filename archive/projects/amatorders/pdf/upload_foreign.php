<?php

session_start();

ob_start();



date_default_timezone_set('America/Los_Angeles');

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<?php

//These are the values for each of the tooltips

$upload_later = "<p class='tip_title'>Uploading Foreign Characters later</p> <p>This will put your order on hold until you have uploaded the files. You will receive an email with directions as how to upload the files.</p>";





?>



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Order Form</title>

<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link href="../css/style.css" rel="stylesheet" type="text/css" />

<link rel="shortcut icon" href="../images/favicon.gif" />

<!--//////////  FOR USERS WITH INTERNET EXPLORER 6  //////////-->
<!--[if IE 6]>
        <link rel="stylesheet" type="text/css" href="../css/ie6.css" />
<![endif]-->

<style type="text/css">
* { behavior: url(../css/iepngfix.htc) }
</style> 
<!--//////////  FOR USERS WITH INTERNET EXPLORER 6  //////////-->

<script src="../js/jquery-1.3.2.min.js" type="text/javascript"></script>

<script src="../js/jquery.qtip.js" type="text/javascript"></script>





<script type="text/javascript">

      $(document).ready(function(){

			

			

		//This brings back all elements for browsers with javaScript enabled

		$(".hidden-nojs").show();

		$("#js_warning").hide();	

		

		  

		  $('#upload_row').hide();

	  

		  if($('#upload_now_checkbox').attr('checked')) { //This checks if the english_only_checkbox is checked, which it is if the session variable is set, and then will enable the fields

		  		$('#upload_row').show();

          }

		  

		  $('input[name=upload_decision]:radio').click(function() {

				$('#upload_decision_error').hide();												

				var value = $("input[@name=upload_decision]:checked").val();

				

				if(value == 'now') {

					$('#upload_row').slideDown();	

				} else {

					$('#upload_row').slideUp();

				}

          });



		//Tooltip Settings

		$.fn.qtip.styles.tooltipStyle = { // This is global style for all tooltips

			   width: 200,

                  padding: 10,

                  background: '#FFFFFF',

                  color: 'black',

                  textAlign: 'left',

                  border: {

                     width: 2,

                     radius: 0,

                     color: '#5C7F99'

                  },

			   name: 'dark' 

			}

			

			

			$('[tooltip]').each(function() // Select all elements with the "tooltip" attribute

			{

			   $(this).qtip({ 

					content: $(this).attr('tooltip'), 

					style: 'tooltipStyle',

					position: {

						corner: {

						   target: 'rightMiddle',

						   tooltip: 'leftMiddle'

						}

					 }, //end position

					 

					 show: { when: { event: 'click' } },

					 hide: { when: { event: 'mouseout' } }

				}); // Retrieve the tooltip attribute value from the current element

			});





		$('input[type="text"]').focus(function()

		 {

			$(this).select();	

		 });



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





<div id="container">





<?php 





//These are the saved session variables

/*foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop

	//if($value != '') {

		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

	//}

} */



//echo 'update_error: ' . $location_updated;



include("../includes/connection.php");

$conn = dbConnect("admin");



/*if($_SESSION['proof_accepted'] != 'yes') {

	header('Location: ../index.php');	

}*/





//DEBUGGING

/*if($_FILES['foreign_character_upload'] == '') {

	echo 'the files array is empty';

} else {

	print_r($_FILES['foreign_character_upload']);

}*/





//$order_id = end($_SESSION['order_id']);

	

	

	

	foreach($_SESSION['order_id'] as $key => $value) {

		//echo $value . '<br />';

		

		$sql = "SELECT *

				FROM orders 

				WHERE order_id = " . $value;

		

		$result = $conn->query($sql) or die(mysqli_error());

		$row = $result->fetch_assoc();

		

		if($row['foreign_quantity'] > 0) {

			$order_id = $value;	

		}

	}

	

	//echo 'The order ID it will be saved to: ' . $order_id;

	

	

	$sql = "SELECT *

			FROM orders 

			WHERE order_id = " . $order_id;

	

	$result = $conn->query($sql) or die(mysqli_error());

	$row = $result->fetch_assoc();	

	

	

	

	//echo 'Character Hold is set to: ' . $row['character_hold'];

	



	

if(isset($_POST['upload_foreign_next'])) {

	

	$has_error = false;

	$error_array = array();

	

	

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

	$_SESSION['dirPath'] = '../upload/' . $_SESSION['upload_location'];

	

	$_SESSION['hold_upload_address'] = 'Your order is currently on hold because you selected to supply foreign characters at a later time. Once you have the characters available, you may upload an image, or type them here: <b><a target="_blank" href="'.$site_basedir.'user_char_upload.php?order_id=' . $_SESSION['order_num'] . '">Supply Your Foreign Characters</a></b>';

	

	if($_POST['upload_decision'] == '') {

		$upload_decision_error = '<span id="upload_decision_error" class="error">You must make a selection.</span>';

		$error_array['upload_decision_error'] = true;

	}

	

	if(in_array(true, $error_array)) {

		$has_error = true;

	}

	



	

	if($has_error != true) { //If there is no error

	

		if($_SESSION['char_supplied'] == 'yes') {

			if($_SESSION['custom_proof_requested'] == 'yes') {

				header('Location: custom_thankyou.php');

				exit;

			} else if($_SESSION['custom_proof_requested'] == 'no') {

				header('Location: thankyou.php'); //redirect to the thankyou page if no files were chosen to be uploaded

				exit;

			}

		}

		

		

		if(isset($_POST['upload_decision']) && $_POST['upload_decision'] == 'now') {

			

			if($_FILES['foreign_character_upload']['name'] == '' && $_POST['foreign_characters_name'] == '') { //If a file isnt uploaded or characters are entered

				$upload_message = "<p class='error'>You have selected to supply characters. <br /><br />Please upload a file or enter your characters. </p>";

			}

			

		

			if(isset($_FILES['foreign_character_upload']) && $_FILES['foreign_character_upload']['name'] != '') {	

				

				$error = 'no';

				

				$url = "../upload/" . $order_id . '_' . $_SESSION['last_name'] . "/"; // The directory you want the uploads to go to

				

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

				$allowed = array("image/jpg", "image/jpeg", "image/jpe", "image/png", "application/pdf", "image/gif" );

				if (!in_array($file_type, $allowed)) {

					$error_message =  $file_extension . " files are not allowed. Only jpg, png, gif and pdf files are accepted. Please choose another file.";

					$error = 'yes';

				}

				

				

				if($error == 'no') { //If there's no validation error, then upload the file

				

					if (!file_exists("../upload/" . $order_id . '_' . $_SESSION['last_name'])) { //Checks if the directory already exists

						mkdir("../upload/" . $order_id . '_' . $_SESSION['last_name'], 0755); //Creates a new directory with the order_id and Customer last name

					}

					

					

					if(move_uploaded_file($file_temp, $url.$file_name)) { //This uploads the file into the newly created directory

							/*move_uploaded_file:

							   First parameter is the temporary location,

							   second is the new location (plus name),*/

						

					

						$upload_message = "<p class='error'>You just uploaded the file <strong>".$file_name."</strong> with a size of <strong>".$size." KB.</strong></p><p>Upload another file or click the Next Step button to continue.</p>";

						

						

						$upload_folder = $order_id . '_' . $_SESSION['last_name'];

						$sql = 'UPDATE orders

								SET upload_location = ?

								WHERE order_id = ' . $order_id;

								

						$stmt = $conn->stmt_init();

						if($stmt->prepare($sql)){

							$stmt->bind_param('s', $upload_folder);

							$location_updated = $stmt->execute();

						}

						

						$date_added = date('Y-m-d H:i:s',time());

						

						//This adds the note marking a change in status

						$notes_sql = 'INSERT into notes SET

								order_id = "'.$order_id.'",

								date_added = "'.$date_added.'",

								note_message = "'.$note_message['artwork_uploaded'].'"';

								

						$conn->query($notes_sql);

						

						/*//This adds the note marking a change in status

						$notes_sql = 'INSERT into notes SET

								order_id = "'.$order_id.'",

								date_added = "'.$date_added.'",

								note_message = "'.$note_message['waiting_approval'].'"';

								

						$conn->query($notes_sql);*/

						

						$_SESSION['char_supplied'] = 'yes';

						

					} else {

						$upload_message = "<p class='error'>There's been a problem uploading your file. Please try again</p>";

					//echo 'Error Code: ' . $_FILES["file"]["error"];

					}

				}

		

			} 

			

			if($_POST['foreign_characters_name'] != '') {

				//This adds the note marking a change in status		

				$sql = 'UPDATE orders SET

						foreign_characters_name = "'.$_POST['foreign_characters_name'].'",

						foreign_characters_line2 = "'.$_POST['foreign_characters_line2'].'",

						foreign_characters_line3 = "'.$_POST['foreign_characters_line3'].'",

						foreign_characters_line4 = "'.$_POST['foreign_characters_line4'].'"

						WHERE order_id = ' . $order_id;

				

				$result = $conn->query($sql) or die(mysqli_error($conn));

				

				$date_added = date('Y-m-d H:i:s',time());

							

				//This adds the note marking a change in status

				$notes_sql = 'INSERT into notes SET

						order_id = "'.$_SESSION['order_num'].'",

						date_added = "'.$date_added.'",

						note_message = "'.$note_message['characters_supplied'].'"';

						

				$conn->query($notes_sql);

				

				$char_upload_message = "<p class='error'>Your foreign characters have been saved.<br /><br />Click Next Step to continue</p>";

				

				$_SESSION['char_supplied'] = 'yes';

			}

			

			$_SESSION['upload_later'] = 'no';

		} else if(isset($_POST['upload_decision']) && $_POST['upload_decision'] == 'later') {

			$char_sql = 'UPDATE orders

					SET character_hold = "yes"

					WHERE order_id = ' . $order_id;

					

			$conn->query($char_sql);

			

			$date_added = date('Y-m-d H:i:s',time());

			

			//This adds the note marking a change in status

			$notes_sql = 'INSERT into notes SET

					order_id = "'.$order_id.'",

					date_added = "'.$date_added.'",

					note_message = "'.$note_message['hold_for_artwork'].'"';

					

			$conn->query($notes_sql);

		

			$_SESSION['upload_later'] = 'yes';

			

			

			if($_SESSION['custom_proof_requested'] == 'yes') {

				header('Location: custom_thankyou.php');

			} else if($_SESSION['custom_proof_requested'] == 'no') {

				header('Location: thankyou.php'); //redirect to the thankyou page if no files were chosen to be uploaded

			}

				

		} else {//end if isset foreign_character_upload

			if($_SESSION['custom_proof_requested'] == 'yes') {

				header('Location: custom_thankyou.php');

			} else if($_SESSION['custom_proof_requested'] == 'no') {

				header('Location: thankyou.php'); //redirect to the thankyou page if no files were chosen to be uploaded

			}

		}

	

	

	}

	

	

} //end if isset upload_foreign_next

























if($_SESSION["language"]) {

	$language_chosen = $_SESSION["language"];

} else if($_SESSION["other_language"]) {

	$language_chosen = $_SESSION["other_language"];

}





include("../includes/header.php"); ?>



    <div class="form_container" id="upload_foreign">  

        <div class="row">

            <div class="clientform_table_header">Upload Foreign Language Files</div>   

        </div>

        

        <div class="row">   	

            <div class="content">

            	<p>You have ordered a foreign language card for <?php echo $language_chosen; ?>.</p>

                <br /><p class="selection_header"><b>Make a selection below</b></p>

                <form id="clientForm" name="clientForm" method="post" action="" enctype="multipart/form-data">

                <div id="upload_decision_area">

                    <p><input id="upload_now_checkbox" type="radio" name="upload_decision" <?php if(isset($_POST['upload_decision']) && $_POST['upload_decision'] == 'now') {echo 'checked="yes"';} else if($_SESSION["upload_now_toggle"] == 'on') { echo 'checked="yes"';} ?> value="now"/> Supply the foreign language characters now</p>

                    

                    <p><input id="upload_later" type="radio" name="upload_decision" value="later" <?php if($_SESSION['char_supplied'] == 'yes') { echo 'disabled="disabled"';} ?>/> Supply the foreign characters at a later time <span id="upload_later_tooltip" class="tooltip hidden-nojs" style="display:none;" tooltip="<?php echo $upload_later;?>"> </span></p>

                    

                    <p><input id="upload_never" type="radio" name="upload_decision" value="never" <?php if($_SESSION['char_supplied'] == 'yes') { echo 'disabled="disabled"';} ?>/> I am not supplying any foreign characters</p>

                </div>    

                    <?php if(isset($upload_decision_error)) { echo $upload_decision_error; } ?> 

                

            </div>

        </div>

        

        

        <div class="row" id="upload_row">   	

                <div class="content">

                    <div id="upload_area">

                        

                            <label for="foreign_character_upload">Upload Foreign Characters <span class="warning">(pdf,jpg,word files only)</span></label>

                            <div id="divinputfile">

                                <input name="foreign_character_upload" type="file" size="30" id="filepc" onchange="document.getElementById('fakefilepc').value = this.value;" />

                                <div id="fakeinputfile">

                                    <input name="fakefilepc" type="text" id="fakefilepc" />

                                </div>

                            </div>

                            <p><span class="warning">If you want to upload a file, click the Choose File button.</span></p>



                        <div id="upload_message"><?php

                                if($error == 'yes') { //if there's a validation error message show it

                                    echo '<p class="error">' . $error_message . '</p>';	

                                } else if(isset($upload_message)) { //else if the file was uploaded, show the appropriate message

                                    echo $upload_message; 

                                } /*else { //Else show the default message

                                    echo '<p>Click browse, locate the file, and click on Next Step.</p><p>If you dont want to upload any files, just click Next Step.</p>';	

                                }*/

                            ?>

                        </div>

                    </div>

                    <br />

                    <p id="foreign_supply">Supply your own foreign characters (if available)</p>

                                <span id="foreign_supply_text">

                                    <label for="foreign_characters_name">Name </label>

                                    <input id="foreign_characters_name" name="foreign_characters_name" class="text" type="text" value="<?php if(isset($_POST['foreign_characters_name'])) {echo $_POST['foreign_characters_name'];} else{echo $_SESSION["foreign_characters_name"];} ?>"/><br />

                                    <label for="foreign_characters_line2">Line 2 </label>

                                    <input id="foreign_characters_line2" name="foreign_characters_line2" class="text" type="text" value="<?php if(isset($_POST['foreign_characters_line2'])) {echo $_POST['foreign_characters_line2'];} else{echo $_SESSION["foreign_characters_line2"];} ?>"/><br />

                                    <label for="foreign_characters_line3">Line 3 </label>

                                    <input id="foreign_characters_line3" name="foreign_characters_line3" class="text" type="text" value="<?php if(isset($_POST['foreign_characters_line3'])) {echo $_POST['foreign_characters_line3'];} else{echo $_SESSION["foreign_characters_line3"];} ?>"/><br />

                                    <label for="foreign_characters_line4">Line 4 </label>

                                    <input id="foreign_characters_line4" name="foreign_characters_line4" class="text" type="text" value="<?php if(isset($_POST['foreign_characters_line4'])) {echo $_POST['foreign_characters_line4'];} else{echo $_SESSION["foreign_characters_line4"];} ?>"/>

                                    <?php if(isset($char_upload_message)) { echo $char_upload_message; } ?>

                                </span>

				</div>

			</div>

            

        <div class="row">

            <div class="content" id="last_content">

            	<input class="button next submit" id="upload_foreign_submit" type="submit" name="upload_foreign_next" value="Next Step" />

                </form>

			</div>

        </div>	 

	</div>



</body>



</html>