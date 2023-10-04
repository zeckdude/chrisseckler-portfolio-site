<?php 

session_start();

ob_start();

date_default_timezone_set('America/Los_Angeles');



//header('Content-type: text/html; charset=utf-8');











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



//$sql = 'SET NAMES utf8';

//$conn->query($sql) or die(mysqli_error());









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

$_SESSION["employee_id"] = $row['employee_id'];

$_SESSION["email_language_proof"] = $row['email_language_proof'];



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



/*	DEBUGGING	*/

 //These are the saved session variables

/*foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop

	//if($value != '') {

		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

	//}

} */















if(isset($_POST['accept_proof'])){

	

	$_SESSION['trans_proof_accepted'] = 'yes';

	$date_approved = date('Y-m-d H:i:s',time()); //Current Date/time in Unix format

	$approved = 'printing';

	

	$sql = 'UPDATE orders

			SET status = ?

			WHERE order_id = ? 

			AND employee_id = ?';

	

	

			

	

		$stmt = $conn->stmt_init(); 

		if ($stmt->prepare($sql)) { 

			$stmt->bind_param('sii', $approved, $_SESSION['order_id'], $_SESSION['employee_id']); 

			$done = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $done

		}

		

		$date_added = date('Y-m-d H:i:s',time());

		

		//This adds the note marking a change in status	

		$notes_sql = 'INSERT into notes SET

				order_id = "'.$_SESSION['order_id'].'",

				date_added = "'.$date_added.'",

				note_message = "'.$note_message['trans_approved'].'"';

				

		$conn->query($notes_sql);

	} //end if accept proof

	

	

	// redirect on success or if $_GET['article_id']) is not defined. This ensures that the page is redirected either if the update succeeds or if someone tries to access the page directly.

	if ($done) { //if $_GET['article_id'] is not defined

		header('Location: trans_thankyou.php');

		exit; //and exit the script	

	}

	

	//display error message if query fails

	if (isset($stmt) && !$done) { //if the prepared statement has been created, but both $OK and $done remain false 

		echo $stmt->error;	// then display an error message on the screen

	}







if(isset($_POST['dont_accept_proof'])){

	

	$_SESSION['trans_proof_accepted'] = 'no';

		

		$date_added = date('Y-m-d H:i:s',time());

		

		//This adds the note marking a change in status		

		$notes_sql = 'INSERT into notes SET

				order_id = "'.$_SESSION['order_id'].'",

				date_added = "'.$date_added.'",

				note_message = "'.$note_message['trans_rejected'].'"';

				

		$conn->query($notes_sql);

		

		

	

		header('Location: trans_not_approved.php');

	

		exit;

	

}

?>









<div id="container">





<?php include("includes/header.php"); 





if($_SESSION['status'] == 'waiting_trans_approval') {

	

	if($_SESSION['foreign_characters_name'] != '' || $_SESSION['foreign_characters_line2'] != '' || $_SESSION['foreign_characters_line3'] != '' || $_SESSION['foreign_characters_line4'] != '') {

		echo 'Foreign Characters exist';	

	}

	

	

	$trans_sql = "SELECT *

				FROM translations

				WHERE order_id = '" . $_SESSION["order_id"] . "'";



	$trans_result = $conn->query($trans_sql) or die(mysqli_error());

	$trans_row = $trans_result->fetch_assoc();

	

	

	

	

	

	

	

?>





	<div class="form_container" id="pdf_container" <?php if($_SESSION['english_quantity'] == '' && $_SESSION['foreign_quantity'] == '') {echo 'style="width: 298px;"';} ?>>  

            <div class="row">

            	<div class="clientform_table_header">

                

                	 <?php 

						if($_SESSION['english_quantity'] != '' || $_SESSION['foreign_quantity'] != '') {//If either of the business cards were ordered 

							if($_SESSION['notepad_size_425x55'] == 'yes' || $_SESSION['notepad_size_55x85'] == 'yes') { //If either of the notepads were ordered

								echo 'Do you want to accept this business card and notepad order?<br /><span class="warning">Below is the details of the order for ' . $_SESSION["first_name"] . ' ' . $_SESSION["last_name"] . '. Please accept or deny the order.</span>';

							} else { //If no notepads were ordered

								echo 'Do you want to accept this proof?<br /><span class="warning">Below is the business card proof for ' . $_SESSION["first_name"] . ' ' . $_SESSION["last_name"] . '. Please accept or deny the proof.</span>';

							}

						} elseif($_SESSION['english_quantity'] == '' && $_SESSION['foreign_quantity'] == '') { //If no Business cards were picked meaning it must be only notepads

							echo 'Do you want to accept this notepad order?<br /><span class="warning">Below is the details of the order for ' . $_SESSION["first_name"] . ' ' . $_SESSION["last_name"] . '. Please accept or deny the order.</span>';

						}

					 ?>

                	

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

						?>

                            <iframe class="iframe" src="pdf/trans_approval_pdf.php#toolbar=0&navpanes=0&scrollbar=0" width="700px" style="height:25em; margin-bottom: 0px; border: none;">

                            [Your browser does <em>not</em> support <code>iframe</code>,

                            or has been configured not to display inline frames.]</iframe>

                            

                            <div style="width: 700px; height: 295px; background-color: #333333; margin-bottom: 91px;">

                            <embed src="trans_upload/<?php echo $_SESSION["order_num"] . '_' . $_SESSION["last_name"];?>/translation.pdf#toolbar=0&navpanes=0" width="700" height="370px" style="margin-top:0px; border: none; margin-bottom: 0px;">

                            </div>

                        

                        <?php 

						}

						?>

                        

                        

                    </p>







					<?php if($_SESSION['notepad_size_425x55'] == 'yes' || $_SESSION['notepad_size_55x85'] == 'yes') { 

								if($_SESSION['english_quantity'] != '' && $_SESSION['foreign_quantity'] != '') {

					

					

					

					?>

                        <p>                    

                            <div id="all_orders_area" class="print" style="border: 1px solid #5C7F99; width: 222px; margin: 16px auto 24px;">

                                <div class="row">

                                     <div class="clientform_table_header" style="padding-left: 8px;">Additional Items</div>   

                                </div>

                                

                                <div class="order_content">

                                

                                    <?php if($_SESSION['notepad_size_425x55'] == 'yes') { ?>

                                        <div class="item_area">

                                            <span class="thankyou_title">Order Item: </span>Notepads(4.25" x 5.5")<br />

                                        </div>

                                    <?php } ?>

                                    

                                    <?php if($_SESSION['notepad_size_55x85'] == 'yes') { ?>

                                        <div class="item_area">

                                            <span class="thankyou_title">Order Item: </span>Notepads(5.5" x 8.5")<br />

                                        </div>

                                    <?php } ?>

                                </div>  

                            </div>                          

                        </p>

					<?php 

						}

					} ?>





                    <p>

                        <form id="proof_form" name="proof_form" method="post" action=""><!-- Begin Form -->

                            <input class="submit prev button" type="submit" name="dont_accept_proof" value="Don't Accept Proof" />



                            	<p id="english_proof_desc">This is a proof for a translation for a Foreign card<br /><span class="warning">Note: This is the proof for ONLY the translated portion of the card, which will be merged at time of printing with contact information from the English side of the card</span></p>



                            <input class="submit next button" type="submit" name="accept_proof" value="Accept Proof" />

                        </form><!-- End Form -->

                    </p>

            	</div>

            </div>

    </div> 

    

<?php } else { ?>



	<div class="form_container" id="thank_you_box">  

        <div class="row">

            <div class="clientform_table_header">This order has already been reviewed</div>   

        </div>

        

        <div class="row">

            <div class="content">

                <p>The order for <?php echo $_SESSION["first_name"] . ' ' . $_SESSION["last_name"]; ?> has already been reviewed and has been <?php if($_SESSION['status'] == 'not_approved') {echo 'rejected';} else {echo 'approved';} ?>.</p>

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