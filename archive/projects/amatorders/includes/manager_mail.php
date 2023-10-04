<?php







if($_SESSION['custom_manager_approval'] == 'yes') {

	$order_num = $_SESSION['order_num'];

} else if(isset($_GET['order_id'])) { //If Pro Print wants to resend the Manager email manually

	$order_num = $_GET['order_id'];

} else {

	$order_num = mysqli_insert_id($conn);

}





if(!isset($conn)) {

	include("connection.php");

	$conn = dbConnect('admin');

}









$mail_sql = "SELECT *

			FROM orders 

			WHERE order_id = ".$order_num;



$mail_result = $conn->query($mail_sql) or die(mysqli_error());

$mail_row = $mail_result->fetch_assoc();



if($_SESSION['custom_manager_approval'] == 'yes' || isset($_GET['order_id'])) {

	$date = date('m/j/y',strtotime($mail_row['date_submitted']));

} else {

	$date = date("m/j/y");

}







$mailTo = $mail_row["approved_by"];

//$mailFrom = 'order@foreignpro.com';







if($mail_row['english_quantity'] != '' || $mail_row['foreign_quantity'] != '') {//If either of the business cards were ordered

	$subject = 'Manager approval needed for Business Card order for ' . $mail_row['first_name'] . ' ' . $mail_row['last_name'] . '(Order #' . $order_num . ')';

	$message = 

		'<html>

		<head>

		<title>Manager Approval needed</title>

		</head>

		<body>

			<table style="width: 400px; border: 1px solid #5C7F99; margin-left: auto; margin-right: auto; margin-top: 35px;">

				<thead>

					<tr style="background: #FFFFFF none repeat-x scroll left center; border-bottom: 1px solid #C2C9CF;"><th colspan="2" style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px;"><span style="font-weight: normal;">Please review this business card order</span></th></tr>   

				</thead>    

				<tbody>

					<tr>

						<td colspan="2" style="padding: 7px 15px; color: #183152; ">

							<p>You are receiving this email because ' . $mail_row['first_name'] . ' ' . $mail_row['last_name'] . ' placed a business card order at Pro Print & Services on '.$date.'.</p>

							<p>The order can only be processed once you have approved or disapproved. Thank you.</p>

							<p>Please click on the following link to view a PDF proof of the card that was ordered. Once you click "approve", the system will automatically send it to press(or to the translator if a foreign language card was ordered). Please do not send a separate "approval" email as it is not necessary.</p>

							<p><a href="' . $site_basedir . 'manager_approval.php?employee_id=' . $mail_row['employee_id'] . '&order_id=' . $order_num . '">Please click here to view the Business Card Proof</a></p>

						</td>

					</tr> 

				</tbody>     

			</table>

		</body>

		</html>';

	

} 





$headers  = 'MIME-Version: 1.0' . "\r\n";

$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$headers .= 'From: Pro Print & Services <' . $pro_print_email . '>';



mail($mailTo, $subject, $message, $headers);







if(isset($_GET['order_id'])) {

	

	if($mail_row['mng_mail_resent'] < 1) {

		$num_sent = 1;	

	} else {

		$num_sent = $mail_row['mng_mail_resent'] + 1;	

	}

	

	$resent_sql = 'UPDATE orders SET

			mng_mail_resent = "'.$num_sent.'"

			WHERE order_id = ' . $mail_row['order_id'];



	$resent_result = $conn->query($resent_sql) or die(mysqli_error($conn));

	

	

	header('Location: ' . $site_basedir . 'admin/tracker.php');

}







?>





























