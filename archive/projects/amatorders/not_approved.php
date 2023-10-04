<?php

session_start();

ob_start();





/* //These are the saved session variables

foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop

	//if($value != '') {

		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

	//}

} 

*/



if($_SESSION['manager_proof_accepted'] != 'no') {

	//header('Location: index.php');	

}



include("includes/connection.php");

$conn = dbConnect('admin');





if(isset($_POST['submit'])) {

	

	if($_POST['rejection_reason'] == '') {

		$submit_error = '<p class="error_message error" style="width:92%">Please provide a reason why the card is being rejected. The order can not continue without this.</p>';

	} else {

		if($_POST['rejection_reason'] == 'changes_needed') {

			if($_POST['instruction_message'] != '') {

				foreach($_SESSION as $key => $value) {

				if(is_array($value)) continue; //This skips the current session variable if it is an array

				if($key == 'ordering_step') continue; //This skips the current session variable if it is named 'ordering_step'

				if($key == 'manager_proof_accepted') continue; //This skips the current session variable if it is named 'manager_proof_accepted'

				$_SESSION[$key] = sanitize($conn, $value); //This sanitizes the current session variable and then saves it back as the same session variable name

			}

			

			foreach($_POST as $key => $value) {

				$_POST[$key] = sanitize($conn, $value); //This sanitizes the current session variable and then saves it back as the same session variable name

			}

			

			

			$sql = 'UPDATE orders SET

					status = "waiting_corrections"

					WHERE order_id = "' . $_SESSION['order_id'] . '"

					AND employee_id = "' . $_SESSION['employee_id'] . '"';

		

			$result = $conn->query($sql) or die(mysqli_error());

			

			$date_added = date('Y-m-d H:i:s',time());

			

			//This adds the note marking a change in status	

			$notes_sql = 'INSERT into notes SET

					order_id = "'.$_SESSION['order_id'].'",

					date_added = "'.$date_added.'",

					note_message = "'.$note_message['manager_changes'].'"';

					

			$conn->query($notes_sql);

			

			

			

			//This adds the note marking a change in status		

			$notes_sql = 'INSERT into notes SET

					order_id = "'.$_SESSION['order_id'].'",

					date_added = "'.$date_added.'",

					note_message = "Correction instructions given:<br />'.$_POST['instruction_message'].'"';

			

			$notes_result = $conn->query($notes_sql) or die(mysqli_error($conn));

			

			

			

			//This adds the note marking a change in status	

			$notes_sql = 'INSERT into notes SET

					order_id = "'.$_SESSION['order_id'].'",

					date_added = "'.$date_added.'",

					note_message = "'.$note_message['sent_manager_corrections'].'"';

					

			$conn->query($notes_sql);

			

			//This adds the note marking a change in status		

			$instruction_sql = 'INSERT into manager_instructions SET

					order_id = "'.$_SESSION['order_id'].'",

					instruction_message = "'.$_POST['instruction_message'].'"';			

			$conn->query($instruction_sql);

			

			

			$instr_sql = "SELECT *

						FROM manager_instructions

						WHERE order_id = '" . $_SESSION['order_id'] . "'";

			

			$instr_result = $conn->query($instr_sql) or die(mysqli_error());

			

			

			$date = date("m/j/y");

				$mailTo = $pro_print_email; //This needs to be changed to $pro_print_email after testing

				$subject = 'Manager rejected order: Corrections needed for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION['order_num'] . ')';

				$message = 

							'<html>

							<head>

							<title>Corrections Needed</title>

							</head>

							<body style="font-size: 12px;">

								<table style="width: 400px; border: 1px solid #5C7F99; margin-left: auto; margin-right: auto; margin-top: 35px;">

									<thead>

										<tr style="background: #FFFFFF none repeat-x scroll left center; border-bottom: 1px solid #C2C9CF;"><th colspan="2" style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px;"><span style="font-weight: normal;">Corrections needed for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION['order_num'] . ')</span></th></tr>   

									</thead>    

									<tbody>

										<tr>

											<td colspan="2" style="padding: 7px 15px; color: #183152; ">

												<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Order #:</span> ' . $_SESSION['order_num'] . '</p>

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

					

					

				$message .=

											'<p style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px; margin-top: 42px;">Instructions for Corrections</p>

											<p>The manager has provided instructions for corrections on the order.</p>

											<p>';

				

				$i = 1;							

				while ($instr_row = $instr_result->fetch_assoc()) {				

					$message .= '(' . $i . ') ' . $instr_row['instruction_message'] . '<br />';

					$i++;

				}

							

											

											

				$message .=					'</p>';

				

				

				

				$message .=

											'<p style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px; margin-top: 42px;">Once Corrections are complete</p>

											<p>Once the corrections for the order are complete, go to the details section of that order on the tracker.</p>

											<p><a href="' . $site_basedir . 'admin/tracker.php">Click here to go to the Tracker</a></p>

											

											

											

											

											

											

											

											</td>

											

										</tr> 

									</tbody>     

								</table>

							</body>

							</html>';

							

				

				$headers  = 'MIME-Version: 1.0' . "\r\n";

				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				$headers .= 'From: Pro Print & Services <proprint@sprynet.com>';

				

				mail($mailTo, $subject, $message, $headers);

	

			header('Location: ' . $site_basedir . 'not_approved.php?instructions_sent=yes');

			} else {

				$submit_error = '<p class="error_message error" style="width: 92%;">Please provide instructions for Pro Print as to how to make corrections to your proof. The order can not continue without this.</p>';	

			}

		}

	

	

		if($_POST['rejection_reason'] == 'not_authorized') {

			

			$sql = 'UPDATE orders SET

					status = "not_approved"

					WHERE order_id = "' . $_SESSION['order_id'] . '"

					AND employee_id = "' . $_SESSION['employee_id'] . '"';

		

			$result = $conn->query($sql) or die(mysqli_error());

			

			$date_added = date('Y-m-d H:i:s',time());

			

			//This adds the note marking a change in status		

			$notes_sql = 'INSERT into notes SET

					order_id = "'.$_SESSION['order_id'].'",

					date_added = "'.$date_added.'",

					note_message = "'.$note_message['manager_rejected'].'"';

					

			$conn->query($notes_sql);

			

			

			if(!isset($_SESSION['not_approved_sent'])) {

				$date = date("m/j/y");

				$mailTo = $_SESSION["delivery_email"];

				$mailFrom = $pro_print_email;

				$subject = 'Business Card order for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION["order_id"] . ') was rejected';

				$message = 

							'<html>

							<head>

							<title>Manager Approval was provided</title>

							</head>

							<body>

								<table style="width: 400px; border: 1px solid #5C7F99; margin-left: auto; margin-right: auto; margin-top: 35px;">

									<thead>

										<tr style="background: #FFFFFF none repeat-x scroll left center; border-bottom: 1px solid #C2C9CF;"><th colspan="2" style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px;"><span style="font-weight: normal;">The order for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION["order_id"] . ') was rejected</span></th></tr>   

									</thead>    

									<tbody>

										<tr>

											<td colspan="2" style="padding: 7px 15px; color: #183152; ">

												<p>You are receiving this email because ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . ' placed a business card order at Pro Print & Services on '.date("m/j/y",strtotime($_SESSION['date_submitted'])).'.</p>

												<p>The order has been rejected by your Manager. Thank you for your order.</p>

											</td>

										</tr> 

									</tbody>     

								</table>

							</body>

							</html>';

				

				$headers  = 'MIME-Version: 1.0' . "\r\n";

				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				$headers .= 'From: Pro Print & Services <proprint@sprynet.com>';

				

				mail($mailTo, $subject, $message, $headers);

				

				$_SESSION['not_approved_sent'] = 'yes';

			}

			

			header('Location: ' . $site_basedir . 'not_approved.php?not_authorized=yes');

		}	

	}



}









?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Order Form</title>

<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link href="css/style.css" rel="stylesheet" type="text/css" />

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





include("includes/header.php");





    

    if(isset($_GET['instructions_sent'])) {

?>

	<div class="form_container" id="thank_you_box">  

        <div class="row">

            <div class="clientform_table_header">Your order has been sent back to Pro Print</div>   

        </div>

        

        <div class="row">

            <div class="content">

                <p>Your order has been sent back to Pro Print with the detailed instructions you provided. Please be aware that you will receive another proof soon. Make sure you review that proof as soon as possible.</p>

			</div>

          </div>       

    </div>





<?php 



session_destroy();



} else if(isset($_GET['not_authorized'])) { ?>

	<div class="form_container" id="thank_you_box">  

        <div class="row">

            <div class="clientform_table_header">Thank you for your time</div>   

        </div>

        

        <div class="row">

            <div class="content">

                <p>Thank you for taking the time to review the order. A notice will be sent to <?php echo $_SESSION["first_name"] . ' ' . $_SESSION["last_name"]; ?> to notify them that their order has not been approved.</p>

			</div>

          </div>       

    </div>



<?php 



session_destroy();



} else { ?>





    

    <div class="form_container" id="thank_you_box">  

        <div class="row">

            <div class="clientform_table_header">Please provide reason for rejection</div>   

        </div>      

         

        <div class="row">

            <div class="content" id="thankyou_last_content_1">

                <p style="margin-bottom: 5px;">Please provide reason for rejection:</p>

                

                <form id="clientForm" name="clientForm" method="post" action="">

                	<label><input type="radio" name="rejection_reason" value="not_authorized" <?php if($_POST['rejection_reason'] == 'not_authorized') {echo 'checked';}?> /> Order not authorized</label><br />

					<label><input type="radio" name="rejection_reason" value="changes_needed" <?php if($_POST['rejection_reason'] == 'changes_needed') {echo 'checked';}?> /> Changes needed</label><br />

                    <p style="margin-top: 20px; margin-bottom: -5px;">Please list changes needed<span class="warning">(if applicable)</span>:</p>

                	<textarea name="instruction_message" style="width: 375px; margin-top: 10px;"></textarea>                

                <?php if(isset($submit_error)) {echo $submit_error;} ?>  <input class="button next submit" type="submit" name="submit" value="Submit" style="margin-right: 22px; margin-top: 7px;"/></form> 

          </div>

        </div> 



    </div> 

     

<?php 

}   

	

?>    

          

		 

</div>



</body>



</html>