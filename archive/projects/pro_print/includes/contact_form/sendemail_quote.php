<?php

$name = $_POST['quotes_name'];
$mailTo = 'zeckdude@gmail.com';
$mailFrom = $_POST['quotes_email'];
$subject = 'Quote Request from ' . $_POST['quotes_name'];
$message = 
			'<html>
			<head>
			<title>HTML email</title>
			</head>
			<body>
			<p><b>Name:</b> ' . $_POST['quotes_name'] . '</p>
			<p><b>Email:</b> ' . $_POST['quotes_email'] . '</p>
			<p><b>Job Type:</b> ' . $_POST['quotes_jobtype'] . '</p>
			<p><b>Turnaround:</b> ' . $_POST['quotes_turnaround'] . '</p>
			<p><b>Quantity:</b> ' . $_POST['quotes_quantity'] . '</p>
			<p><b>Message:</b> ' . $_POST['quotes_mainmessage'] . '</p>
			</body>
			</html>';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Pro Print Quote Request Form <some@body.com>';
			
mail($mailTo, $subject, $message, $headers);
?>