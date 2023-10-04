<?php

$name = $_POST['name'];
$mailTo = 'zeckdude@gmail.com';
$mailFrom = $_POST['email'];
$subject = 'Contact Form Message from ' . $_POST['name'];
$mainmessage = $_POST['mainmessage'];

			
mail($mailTo, $subject, $mainmessage, "From: ".$mailFrom, $name);
?>