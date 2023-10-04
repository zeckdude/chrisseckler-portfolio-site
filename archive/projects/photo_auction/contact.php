<?php 
session_start();



error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	include("includes/connection.php");
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('query');
	
	
	if(isset($_POST['submit_contact'])) {
		$name = $_POST['name'];
		$mailTo = 'zeckdude@gmail.com';
		$mailFrom = $_POST['email'];
		$subject = 'Contact Form Message on Tack Sharp contact form from ' . $_POST['name'];
		$mainmessage = $_POST['mainmessage'];
		
					
		mail($mailTo, $subject, $mainmessage, "From: ".$mailFrom, $name);
		
		$thankyou_message = '<div id="thankyou_message"><h3>Thank you! Your message has been sent!</h3></div>';
	}
	
	
	
	
	
	
	
	
	
	
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_name; ?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />




<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>




<link rel="shortcut icon" href="../images/favicon.ico" />
</head>

<body>
<div id="container">
    <?php include('includes/header.php'); ?>

    <div id="main_content">
        <div id="highest_items">
        <h2>How to Contact Tack Sharp!</h2>
				<span id="contact_instructions">If you want to contact the Administrator's for the Tack Sharp! Silent Photography Auction, please fill out the contact form below. If you would like to auction your photo on this site, please send the photo along with a description and photo style to admin@tacksharp.com. We will review the photo and respond if chosen.<br /> Thank you!</span>
            	<form name="contact_form" action="" method="post" id="sendEmail">               
                    <span class="contact_section">
                        <span id="nametitle" class="contact_title"><h3>Name:</h3></span>
                        <input style="margin-left: 31px;" class="input_align" name="name" id="name" type="text" value="">
                    </span>
                    
                    <span class="contact_section">
                        <span id="emailtitle" class="contact_title"><h3>Email:</h3></span>
                        <input style="margin-left: 31px;" class="input_align" name="email" id="email" type="text" value="">
                    </span>
                    
                    <span class="contact_section">
                        <span id="mainmessagetitle" class="contact_title"><h3>Message:</h3></span>
                        <textarea style="margin-left: 15px;" name="mainmessage" id="mainmessage"></textarea>									
                    </span>
                    
                    
                    <span class="contact_section">
                        <input id="send_message_btn" name="submit_contact" type="submit" value="Send Message"> </input>
                    </span>
            </form>
            
           <?php if(isset($_POST['submit_contact'])) {
            	echo $thankyou_message;
            } ?>
            
        </div> <!--end highest items div-->
    </div> <!--end main content div-->
</div> <!--end container div-->


<?php mysqli_close($conn); ?>
</body>
</html>