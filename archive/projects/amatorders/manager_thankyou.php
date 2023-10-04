<?php

session_start();

ob_start();



date_default_timezone_set('America/Los_Angeles');

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





<div id="container">





<?php





/* //These are the saved session variables

foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop

	//if($value != '') {

		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

	//}

} */





if($_SESSION['manager_proof_accepted'] != 'yes') {

	header('Location: index.php');	

}



include("includes/connection.php");

$conn = dbConnect("admin");



include("includes/header.php");



//This sends the mail to the translator if there if not waiting for artwork from the user and it is a foreign language card order

if($_SESSION['foreign_quantity'] > 0 && $_SESSION['custom_proof_requested'] != 'yes') {

	if($_SESSION['character_hold'] == 'no') {	

		

		include("includes/translator_mail.php");

		

		$status_sql = 'UPDATE orders

					SET status = "waiting_translator"

					WHERE order_id = ' . $_SESSION["order_num"];

					

		$conn->query($status_sql);

			

			

		$date_added = date('Y-m-d H:i:s',time());	

			

		//This adds the note marking a change in status			

		$notes_sql = 'INSERT into notes SET

				order_id = "'.$_SESSION["order_num"].'",

				date_added = "'.$date_added.'",

				note_message = "'.$note_message['sent_translator'].'"';

				

		$conn->query($notes_sql);	

	}

}













?>



    <div class="form_container" id="thank_you_box">  

        <div class="row">

            <div class="clientform_table_header">Thank you for approving the order!</div>   

        </div>

        

        <div class="row">

            <div class="content">

                <p>The order for <?php echo $_SESSION["first_name"] . ' ' . $_SESSION["last_name"]; ?> has been sent to our <?php if($_SESSION['foreign_quantity'] > 0) { echo 'translation'; } else { echo 'printing'; } ?> department.</p>

			</div>

          </div>       

         

        <div class="row">

            <div class="content" id="thankyou_last_content_1"><a class="button prev" href="index.php">AMAT Order Form</a></div>	

		</div>

    </div> 

     

    <?php 	

	

	if(!isset($_SESSION['manager_thankyou_sent'])) {

		$date = date("m/j/y");

		$mailTo = $_SESSION["delivery_email"];

		$subject = 'Business Card order for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION["order_id"] . ') was approved';

		$message = 

					'<html>

					<head>

					<title>Manager Approval was provided</title>

					</head>

					<body>

						<table style="width: 400px; border: 1px solid #5C7F99; margin-left: auto; margin-right: auto; margin-top: 35px;">

							<thead>

								<tr style="background: #FFFFFF none repeat-x scroll left center; border-bottom: 1px solid #C2C9CF;"><th colspan="2" style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px;"><span style="font-weight: normal;">The order for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION["order_id"] . ') was approved</span></th></tr>   

							</thead>    

							<tbody>

								<tr>

									<td colspan="2" style="padding: 7px 15px; color: #183152; ">

										<p>You are receiving this email because ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . ' placed a business card order at Pro Print & Services on '.date("m/j/y",strtotime($_SESSION['date_submitted'])).'.</p>

										<p>The order has been approved by your manager. Thank you for your order.</p>';

		if($_SESSION['character_hold'] == 'yes') {

			$message .= 					'<p>Your order is currently on hold because you selected to supply foreign characters at a later time. Once you have the characters available, you may upload an image, or type them here: <b><a href="'.$site_basedir.'user_char_upload.php?order_id=' . $_SESSION["order_id"] . '">Supply Your Foreign Characters</a></b><br /><br />You will receive a proof with the foreign language character side of the card at the email you specified once you supply your characters. Please review that so the order can be processed.</p>';

		} else { 

			$message .=						'<p>The order has been sent to our ';

													if($_SESSION['foreign_quantity'] > 0) { $message .= 'translation'; } else { $message .= 'printing'; }

			$message .= 					' department.</p>';

		}

		

			$message .=						'</td>

								</tr> 

							</tbody>     

						</table>

					</body>

					</html>';

		

		$headers  = 'MIME-Version: 1.0' . "\r\n";

		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$headers .= 'From: Pro Print & Services <' . $pro_print_email . '>';

		

		mail($mailTo, $subject, $message, $headers);

		

		

		$_SESSION['manager_thankyou_sent'] = 'yes';

	}

	

	

	

	

	

	

	

	//session_destroy(); //destroys all the session variables now that we dont need them anymore 

	?>      

		 

</div>



</body>



</html>