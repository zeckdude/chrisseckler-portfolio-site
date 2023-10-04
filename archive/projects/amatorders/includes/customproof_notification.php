<?php


	$sql = 'SELECT *
			FROM orders
			WHERE order_id = ' . mysqli_insert_id($conn);
			
	$result = $conn->query($sql) or die(mysqli_error());
	$row = $result->fetch_assoc();
	
	$ordered_items = '';
	if($row['english_quantity'] > 0) {
		$ordered_items .= 'English Language cards(' . $row['english_quantity'] . ')';	
	}
	
		if($row['language'] != '') {
			$language = $row['language'];	
		} else {
			$language = $row['other_language'];		
		}
	
	if($row['foreign_quantity'] > 0) {
		if($row['english_quantity'] > 0) {$ordered_items .= ', ';}
		$ordered_items .= 'Foreign Language cards(' . $row['foreign_quantity'] . ')(' . $language . ')';	
	}
	
	if($row['notepad_size_425x55'] == 'yes') {
		if($row['english_quantity'] > 0 || $row['foreign_quantity'] > 0) {$ordered_items .= ', ';}
		$ordered_items .= 'Notepads(4.25 x 5.5)';	
	}
	
	if($row['notepad_size_55x85'] == 'yes') {
		if($row['english_quantity'] > 0 || $row['foreign_quantity'] > 0 || $row['notepad_size_425x55'] == 'yes') {$ordered_items .= ', ';}
		$ordered_items .= 'Notepads(5.5 x 8.5)';	
	}
	
	if($row['shipping_time'] == '1-3 work days' || $row['shipping_time'] == '4-8 work days') {
		$rush = '(Rush Order)';	
		$rush_message = '<p><b>***THIS IS A RUSH ORDER***</b></p>';	
	} else if($row['shipping_time'] == '10 work days') {
		$rush = '';	
		$rush_message = '';
	}
	
	$date = date("m/j/y");
	
	if($row['shipping_time'] != '10 work days') {
		$delivery_date = $row['rush_date'];
	} else {
		$delivery_date = date("m/j/y",strtotime($date) + 10 * 24 * 60 * 60);
	}



	
	$mailTo = $pro_print_email;
	$subject = 'Custom Proof Requested(Order ' . $row['order_id'] . '): ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . ' ' . $rush;
	$message = 
				'<html>
				<head>
				<title>Custom proof requested</title>
				</head>
				<body>
					<table style="width: 400px; border: 1px solid #5C7F99; margin-left: auto; margin-right: auto; margin-top: 35px;">
						<thead>
							<tr style="background: #FFFFFF none repeat-x scroll left center; border-bottom: 1px solid #C2C9CF;"><th colspan="2" style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px;"><span style="font-weight: normal;">The following order requires a custom proof</span></th></tr>   
						</thead>    
						<tbody>
							<tr>
								<td colspan="2" style="padding: 7px 15px; color: #183152; ">
									' . $rush_message . '
									<p><b>Date Ordered:</b> ' . $date . '</p>
									<p><b>Order ID:</b> ' . $row['order_id'] . '</p>
									<p><b>Approx. Delivery Date:</b> ' . $delivery_date . '</p>
									<p><b>Ordered:</b> ' . $ordered_items . '</p>
									<p><b>First Name:</b> ' . $_SESSION['first_name'] . '</p>
									<p><b>Last Name:</b> ' . $_SESSION['last_name'] . '</p>
									
									<p><a href="' . $site_basedir . 'admin/customproofs.php">Click here to view all Custom Proof requested orders</a></p>
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



?>














