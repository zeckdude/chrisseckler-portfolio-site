<?php 

session_start();

ob_start();

date_default_timezone_set('America/Los_Angeles');















if(isset($_SESSION['ordering_mode'])) {

	session_destroy();	

}



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



<?php

include("includes/connection.php");

$conn = dbConnect("admin");



$done = false;



if(!isset($_GET['employee_id']) || !isset($_GET['order_id'])) {

	header('Location: index.php');											  

}





//Get address

$sql = "SELECT *, UNIX_TIMESTAMP('date_submitted')

		FROM orders

		WHERE order_id = '" . $_GET['order_id'] . "' AND employee_id = '" . $_GET['employee_id'] . "'";



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

$_SESSION["delivery_email"] = $row['delivery_email'];

$_SESSION["employee_id"] = $row['employee_id'];





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

$_SESSION['custom_address'] = $row['custom_address'];



$_SESSION['custom_proof_requested'] = $row['custom_proof_requested'];

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



$_SESSION['employee_id'] = $_GET['employee_id'];

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





/* //These are the saved session variables

foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop

	//if($value != '') {

		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

	//}

} */















if(isset($_POST['accept_proof'])){

	

	$_SESSION['manager_proof_accepted'] = 'yes';

	$date_approved = date('Y-m-d H:i:s',time()); //Current Date/time in Unix format

	$approved = 'approved';

	

	$sql = 'UPDATE orders

			SET status = ?,

			date_approved = ?

			WHERE order_id = ? 

			AND employee_id = ?';

	

	

			

	

		$stmt = $conn->stmt_init(); 

		if ($stmt->prepare($sql)) { 

			$stmt->bind_param('ssii', $approved, $date_approved, $_SESSION['order_id'], $_SESSION['employee_id']); 

			$done = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $done

		}

		

		//This adds the note marking a change in status	

		$notes_sql = 'INSERT into notes SET

				order_id = "'.$_SESSION['order_id'].'",

				date_added = "'.$date_approved.'",

				note_message = "'.$note_message['manager_approved'].'"';

				

		$conn->query($notes_sql);

	} //end if accept proof

	

	

	// redirect on success or if $_GET['article_id']) is not defined. This ensures that the page is redirected either if the update succeeds or if someone tries to access the page directly.

	if ($done) { //if $_GET['article_id'] is not defined

	

		$sql = "SELECT *

				FROM orders

				WHERE order_id = '" . $_SESSION['order_id'] . "' AND employee_id = '" . $_SESSION['employee_id'] . "'";



		$result = $conn->query($sql) or die(mysqli_error());

		$row = $result->fetch_assoc();

	

	

	

		/*echo 'Foreign Quantity: ' . $row['foreign_quantity'] . '<br />';

		echo 'Character Hold: ' . $row['character_hold'] . '<br />';*/

		

		//Checks if there was no foreign cards and sets the status to 'In Print'

		if($_SESSION['foreign_cards_ordered'] == 'no' && $row['custom_proof_requested'] != 'yes') {

		

			$status_sql = 'UPDATE orders

						SET status = "printing"

						WHERE order_id = ' . $_GET['order_id'];

						

			$conn->query($status_sql);

			

			$date_added = date('Y-m-d H:i:s',time()); //Current Date/time in Unix format

			

			//This adds the note marking a change in status		

			$notes_sql = 'INSERT into notes SET

					order_id = "'.$_SESSION['order_id'].'",

					date_added = "'.$date_added.'",

					note_message = "'.$note_message['ready_print'].'"';

					

			$conn->query($notes_sql);

			

		}

		

		//Checks if the order has already been approved and if so, it changes the status to waiting_translator

		if($_SESSION['foreign_cards_ordered'] == 'yes' && $row['character_hold'] != 'yes') {

			

			

			

			$status_sql = 'UPDATE orders

						SET status = "waiting_translator"

						WHERE order_id = ' . $_SESSION['order_id'];

						

			$conn->query($status_sql) or die(mysqli_error());	

			

		} elseif($_SESSION['foreign_cards_ordered'] == 'yes' && $row['character_hold'] == 'yes') {

			$status_sql = 'UPDATE orders

						SET status = "waiting_upload"

						WHERE order_id = ' . $_SESSION['order_id'];

						

			$conn->query($status_sql);

			

			$date_added = date('Y-m-d H:i:s',time()); //Current Date/time in Unix format

			

			//This adds the note marking a change in status		

			$notes_sql = 'INSERT into notes SET

					order_id = "'.$_SESSION['order_id'].'",

					date_added = "'.$date_added.'",

					note_message = "'.$note_message['waiting_upload'].'"';

					

			$conn->query($notes_sql);

		}

		

		

		//Checks if the order has is a custom proof order, it changes the status to waiting_custom_approval

		if($row['custom_proof_requested'] == 'yes') {

			

			$status_sql = 'UPDATE orders

						SET status = "waiting_custom_approval"

						WHERE order_id = ' . $_GET['order_id'];

						

			$conn->query($status_sql);

			

			//This adds the note marking a change in status		

			$notes_sql = 'INSERT into notes SET

						order_id = "'.$_SESSION['order_id'].'",

						date_added = "'.$date_added.'",

						note_message = "'.$note_message['waiting_custom_approval'].'"';

					

			$conn->query($notes_sql);

			

			include("includes/custom_approval_mail.php"); //Once approved, then send the user a notice to approve the custom proof PDF

		}



		header('Location: manager_thankyou.php');

		exit; //and exit the script	

	}

	

	//display error message if query fails

	if (isset($stmt) && !$done) { //if the prepared statement has been created, but both $OK and $done remain false 

		echo $stmt->error;	// then display an error message on the screen

	}







if(isset($_POST['dont_accept_proof'])){

	

	$_SESSION['manager_proof_accepted'] = 'no';

	

		

		

	

		header('Location: not_approved.php');

	

		exit;

	

}

?>









<div id="container">





<?php 



//echo 'the status is ' . $_SESSION['status'];



include("includes/header.php"); 



if($_SESSION['status'] == 'waiting_approval') {



?>



	

	<div class="form_container" id="pdf_container" <?php if($_SESSION['english_quantity'] == '' && $_SESSION['foreign_quantity'] == '') {echo 'style="width: 298px;"';} ?>>  

            <div class="row">

            	<div class="clientform_table_header">Do you want to accept this proof?<br /><span class="warning">Below is the business card proof for <?php echo $_SESSION["first_name"] . ' ' . $_SESSION["last_name"];?>. Please accept or deny the proof.</span>	

                </div>

			</div>   

        

            <div class="row">

            	<div class="content" style="overflow:hidden;">

                	<p>

                    	<?php 

						if($_SESSION['english_quantity'] == '' && $_SESSION['foreign_quantity'] == '') { //If no Business cards were picked meaning it must be only notepads

						

							if($_SESSION['notepad_size_425x55'] == 'yes') {

								echo 'Order Item: Notepads<br />';	

								echo 'Size: 4.25" x 5.5"<br />';

							}

							

							if($_SESSION['notepad_size_55x85'] == 'yes') {

								echo 'Order Item: Notepads<br />';	

								echo 'Size: 5.5" x 8.5"<br /><br />';

							}

						} else {

							

							if($row['custom_proof_requested'] == 'yes') { 

								 if($_SESSION[foreign_cards_ordered] != 'yes' && $_SESSION[english_cards_ordered] == 'yes') { //English Cards Only ?> 

                                        <iframe class="iframe" src="custom_upload/<?php echo $_SESSION["order_id"] . '_' . $_SESSION["last_name"]?>/english/english.pdf" width="700px" style="height:38em">

                                        [Your browser does <em>not</em> support <code>iframe</code>,

                                        or has been configured not to display inline frames.]</iframe>

								<?php } else if($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'yes') { //Foreign AND English Cards ?>                      

                                    <embed src="custom_upload/<?php echo $_SESSION["order_id"] . '_' . $_SESSION["last_name"]?>/english/english.pdf#toolbar=0&navpanes=0&scrollbar=0" width="700" height="375">

                                    <embed src="custom_upload/<?php echo $_SESSION["order_id"] . '_' . $_SESSION["last_name"]?>/foreign/foreign.pdf#toolbar=0&navpanes=0&scrollbar=0" width="700" height="375">

                               <?php } else if($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] != 'yes') { //Foreign Cards Only ?>

                                        <iframe class="iframe" src="custom_upload/<?php echo $_SESSION["order_id"] . '_' . $_SESSION["last_name"]?>/foreign/foreign.pdf" width="700px" style="height:38em">

                                        [Your browser does <em>not</em> support <code>iframe</code>,

                                        or has been configured not to display inline frames.]</iframe>

                               <?php }

							 } else {

						?>

                                <iframe class="iframe" src="pdf/pdf.php" width="700px" <?php if($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'yes') { echo 'style="height:55em"';} else if (($_SESSION[foreign_cards_ordered] == 'no' && $_SESSION[english_cards_ordered] == 'yes') || ($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'no')) {echo 'style="height:38em"';}?>>

                                [Your browser does <em>not</em> support <code>iframe</code>,

                                or has been configured not to display inline frames.]</iframe>

                        

                        <?php 

							}

						}

						?>

                        

                        

                    </p>







					





                    <p>

                        <form id="proof_form" name="proof_form" method="post" action=""><!-- Begin Form -->

                            <input class="submit prev button" type="submit" name="dont_accept_proof" value="Don't Accept Proof" />

                            <?php if($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'yes') { ?>

                                <p id="both_proof_desc">These are proofs for an English only and Foreign card(English side)</p>

                            <?php } else if($_SESSION[foreign_cards_ordered] == 'no' && $_SESSION[english_cards_ordered] == 'yes') { ?>

                                <p id="english_proof_desc">This is a proof for an English only card</p>

                            <?php } else if($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'no') {?>

                            	<p id="english_proof_desc">This is a proof for a Foreign card(English Side)</p>

                            <?php } ?>	

                            <input class="submit next button" type="submit" name="accept_proof" value="Accept Proof" />

                        </form><!-- End Form -->

                    </p>

            	</div>

            </div>

    </div> 

    

<?php } elseif($_SESSION['status'] == '') {  ?>



	<div class="form_container" id="thank_you_box">  

        <div class="row">

            <div class="clientform_table_header">There was an error retrieving the order</div>   

        </div>

        

        <div class="row">

            <div class="content">

                <p>There has been an error trying to retrieve your order. Please try again in a short while. If the problem persists, please contact Pro Print at <a href="mailto:support@amatorders.com?Subject=Cant%20See%20Manager%20Proof">support@amatorders.com</a></p>

			</div>

          </div>       

         

        <div class="row">

            <div class="content" id="thankyou_last_content_1"><a class="button prev" href="index.php">Back to the AMAT Order Form</a></div>

		</div>

    </div>



<?php } else { ?>



	<div class="form_container" id="thank_you_box">  

        <div class="row">

            <div class="clientform_table_header">This order has already been reviewed</div>   

        </div>

        

        <div class="row">

            <div class="content">

                <p>The order for <?php echo $_SESSION["first_name"] . ' ' . $_SESSION["last_name"]; ?> has already been reviewed and has been <?php if($_SESSION['status'] == 'not_approved') {echo 'rejected';} else if($_SESSION['status'] == 'waiting_corrections') {echo 'rejected pending changes';} else {echo 'approved';} ?>.</p>

			</div>

          </div>       

         

        <div class="row">

            <div class="content" id="thankyou_last_content_1"><a class="button prev" href="index.php">Back to the AMAT Order Form</a></div>

		</div>

    </div>









<?php } ?>    

    

    

	 

</div>



</body>



</html>