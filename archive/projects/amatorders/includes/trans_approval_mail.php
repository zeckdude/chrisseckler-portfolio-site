<?php



//This is the code for the email to be sent for the translation approval



		

if(isset($_GET['order_id'])) { //If Pro Print wants to resend the Manager email manually

	$_SESSION['order_num'] = $_GET['order_id'];

}





if(!isset($conn)) {

	include("connection.php");

	$conn = dbConnect('admin');

}





if(isset($_GET['order_id'])) {



$mail_sql = "SELECT *

			FROM orders 

			WHERE order_id = ".$_SESSION['order_num'];



$mail_result = $conn->query($mail_sql) or die(mysqli_error());

$mail_row = $mail_result->fetch_assoc();



	$_SESSION['order_num'] = $mail_row['order_id'];

	$_SESSION['first_name'] = $mail_row['first_name'];

	$_SESSION['last_name'] = $mail_row['last_name'];

	$_SESSION['language'] = $mail_row['language'];

	$_SESSION['other_language'] = $mail_row['other_language'];

	$_SESSION['full_name'] = $mail_row['full_name'];

	$_SESSION['title'] = $mail_row['title'];

	$_SESSION['title_2'] = $mail_row['title_2'];

	$_SESSION['dept_div'] = $mail_row['dept_div'];

	$_SESSION['dept_div_2'] = $mail_row['dept_div_2'];

	$_SESSION['upload_location'] = $mail_row['upload_location'];

	$_SESSION['foreign_characters_name'] = $mail_row['foreign_characters_name'];

	$_SESSION['foreign_characters_line2'] = $mail_row['foreign_characters_line2'];

	$_SESSION['foreign_characters_line3'] = $mail_row['foreign_characters_line3'];

	$_SESSION['foreign_characters_line4'] = $mail_row['foreign_characters_line4'];

	$_SESSION['dirPath'] = 'upload/' . $mail_row['upload_location'];

	$_SESSION["email_language_proof"] = $mail_row['email_language_proof'];

	$_SESSION["employee_id"] = $mail_row['employee_id'];

	$_SESSION['date_submitted'] = $mail_row['date_submitted'];

}



			

			

			$_SESSION['date_submitted'] = strtotime($_SESSION['date_submitted']);

			$date = date("m/j/y", $_SESSION['date_submitted']);

			$mailTo = $_SESSION["email_language_proof"];

			$subject = 'Translation approval needed for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION['order_num'] . ')';

			$message = 

						'<html>

						<head>

						<title>Translation Approval Needed</title>

						</head>

						<body style="font-size: 12px;">

							<table style="width: 400px; border: 1px solid #5C7F99; margin-left: auto; margin-right: auto; margin-top: 35px;">

								<thead>

									<tr style="background: #FFFFFF none repeat-x scroll left center; border-bottom: 1px solid #C2C9CF;"><th colspan="2" style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px;"><span style="font-weight: normal;">Translation approval needed for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION['order_num'] . ')</span></th></tr>   

								</thead>    

								<tbody>

									<tr>

										<td colspan="2" style="padding: 7px 15px; color: #183152; ">
										
										

											<p>You are receiving this email because ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . ' made a foreign language business card order at Pro Print & Services on '.$date.'.</p>

											<p>The order can only be processed once you have approved or disapproved of the translation. Thank you.</p>

											<p>Please click on the following link to view a PDF proof of the card that was ordered.</p>

											<p><a href="' . $site_basedir . 'trans_approval.php?employee_id=' . $_SESSION["employee_id"] . '&order_id=' . $_SESSION['order_num'] . '">Please click here to view the Translation Proof</a></p>

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

		



if(isset($_GET['order_id'])) {

	

	if($mail_row['trans_mail_resent'] < 1) {

		$num_sent = 1;	

	} else {

		$num_sent = $mail_row['trans_mail_resent'] + 1;	

	}

	

	$resent_sql = 'UPDATE orders SET

			trans_mail_resent = "'.$num_sent.'"

			WHERE order_id = ' . $mail_row['order_id'];



	$resent_result = $conn->query($resent_sql) or die(mysqli_error($conn));

	

	

	header('Location: ' . $site_basedir . 'admin/tracker.php');

}

























?>