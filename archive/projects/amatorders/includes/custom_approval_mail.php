<?php

//This is the code for the email to be sent for the custom proof approval

if(isset($_GET['order_id'])) { //If Pro Print wants to resend the Custom Proof Approval email manually

	if(!isset($conn)) {
		include("connection.php");
		$conn = dbConnect('admin');
	}

	$mail_sql = "SELECT *
				FROM orders 
				WHERE order_id = ".$_GET['order_id'];
	
	$mail_result = $conn->query($mail_sql) or die(mysqli_error());
	$mail_row = $mail_result->fetch_assoc();
	
	
	$date = date('m/j/y',strtotime($mail_row['date_submitted']));
	$mailTo = $mail_row["delivery_email"]; 

	$mail_row['date_submitted'] = strtotime($mail_row['date_submitted']);
	$subject = 'Custom proof approval needed for ' . $mail_row['first_name'] . ' ' . $mail_row['last_name'] . '(Order #' . $mail_row['order_id'] . ')';
	$message = 
				'<html>
				<head>
				<title>Custom Proof Approval Needed</title>
				</head>
				<body style="font-size: 12px;">
					<table style="width: 403px; border: 1px solid #5C7F99; margin-left: auto; margin-right: auto; margin-top: 35px;">
						<thead>
							<tr style="background: #FFFFFF none repeat-x scroll left center; border-bottom: 1px solid #C2C9CF;"><th colspan="2" style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px;"><span style="font-weight: normal;">Custom proof approval needed for ' . $mail_row['first_name'] . ' ' . $mail_row['last_name'] . '(Order #' . $mail_row['order_id'] . ')</span></th></tr>   
						</thead>    
						<tbody>
							<tr>
								<td colspan="2" style="padding: 7px 15px; color: #183152; ">
									<p>You are receiving this email because ' . $mail_row['first_name'] . ' ' . $mail_row['last_name'] . ' placed a business card order at Pro Print & Services on '.$date.' and requested a custom proof be sent.</p>
									<p>The order can only be processed once you have approved or disapproved of the custom proof. Thank you.</p>
									<p>Please click on the following link to view a PDF proof of the card.</p>
									<p><a href="' . $site_basedir . 'custom_approval.php?employee_id=' . $mail_row["employee_id"] . '&order_id=' . $mail_row['order_id'] . '">Please click here to view the Custom Proof</a></p>
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
	
	
	header('Location: ' . $site_basedir . 'admin/tracker.php');


} else {

	$_SESSION['date_submitted'] = strtotime($_SESSION['date_submitted']);
	$date = date("m/j/y", $_SESSION['date_submitted']);
	$mailTo = $_SESSION["delivery_email"];
	$subject = 'Custom proof approval needed for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION['order_num'] . ')';
	$message = 
				'<html>
				<head>
				<title>Custom Proof Approval Needed</title>
				</head>
				<body style="font-size: 12px;">
					<table style="width: 403px; border: 1px solid #5C7F99; margin-left: auto; margin-right: auto; margin-top: 35px;">
						<thead>
							<tr style="background: #FFFFFF none repeat-x scroll left center; border-bottom: 1px solid #C2C9CF;"><th colspan="2" style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px;"><span style="font-weight: normal;">Custom proof approval needed for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION['order_num'] . ')</span></th></tr>   
						</thead>    
						<tbody>
							<tr>
								<td colspan="2" style="padding: 7px 15px; color: #183152; ">
									<p>You are receiving this email because ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . ' placed a business card order at Pro Print & Services on '.$date.' and requested a custom proof be sent.</p>
									<p>The order can only be processed once you have approved or disapproved of the custom proof. Thank you.</p>
									<p>Please click on the following link to view a PDF proof of the card.</p>
									<p><a href="' . $site_basedir . 'custom_approval.php?employee_id=' . $_SESSION["employee_id"] . '&order_id=' . $_SESSION['order_num'] . '">Please click here to view the Custom Proof</a></p>
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
	
	if($mail_row['custom_approval_mail_resent'] < 1) {
		$num_sent = 1;	
	} else {
		$num_sent = $mail_row['custom_approval_mail_resent'] + 1;	
	}
	
	$resent_sql = 'UPDATE orders SET
			custom_approval_mail_resent = "'.$num_sent.'"
			WHERE order_id = ' . $mail_row['order_id'];

	$resent_result = $conn->query($resent_sql) or die(mysqli_error($conn));
	
	
	header('Location: ' . $site_basedir . 'admin/tracker.php');
}


}
		














?>