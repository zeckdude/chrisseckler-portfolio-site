<?php
session_start();
ob_start();

if($_SESSION['custom_proof_accepted'] != 'no') {
	header('Location: index.php');	
}

if(isset($_GET['instructions_sent'])) {
	session_destroy(); //destroys all the session variables now that we dont need them anymore	
}


date_default_timezone_set('America/Los_Angeles');

/* //These are the saved session variables
foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop
	//if($value != '') {
		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';
	//}
}*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Applied Materials Order Form</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" href="images/favicon.ico" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>





<body>


<div id="container">



<?php

include("includes/connection.php");
$conn = dbConnect('admin');


include("includes/header.php");






if(isset($_POST['submit'])) {

	if($_POST['instruction_message'] != '') {
		
		
		foreach($_SESSION as $key => $value) {
			if(is_array($value)) continue; //This skips the current session variable if it is an array
			if($key == 'ordering_step') continue; //This skips the current session variable if it is named 'ordering_step'
			$_SESSION[$key] = sanitize($conn, $value); //This sanitizes the current session variable and then saves it back as the same session variable name
		}
		
		foreach($_POST as $key => $value) {
			$_POST[$key] = sanitize($conn, $value); //This sanitizes the current session variable and then saves it back as the same session variable name
			//echo '$_POST[' .$key . '] = ' . $value . ' - Sanitized<br/>';
		}
		
		$date_added = date('Y-m-d H:i:s',time());
		
		//This adds the note marking a change in status		
		$notes_sql = 'INSERT into notes SET
				order_id = "'.$_SESSION['order_id'].'",
				date_added = "'.$date_added.'",
				note_message = "'.$note_message['sent_custom_corrections'].'"';
				
		$conn->query($notes_sql);
		
		//This adds the note marking a change in status		
		$instruction_sql = 'INSERT into custom_instructions SET
				order_id = "'.$_SESSION['order_id'].'",
				custom_instruction = "'.$_POST['instruction_message'].'"';			
		$conn->query($instruction_sql);
		
		
		$instr_sql = "SELECT *
					FROM custom_instructions
					WHERE order_id = '" . $_SESSION['order_id'] . "'";
		
		$instr_result = $conn->query($instr_sql) or die(mysqli_error());
		
		
		$date = date("m/j/y");
			$mailTo = $pro_print_email; //This needs to be changed to $pro_print_email after testing
			//$mailFrom = $pro_print_email;
			$subject = 'Custom Proof Corrections needed for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION['order_num'] . ')';
			$message = 
						'<html>
						<head>
						<title>Custom Proof Corrections Needed</title>
						</head>
						<body style="font-size: 12px;">
							<table style="width: 400px; border: 1px solid #5C7F99; margin-left: auto; margin-right: auto; margin-top: 35px;">
								<thead>
									<tr style="background: #FFFFFF none repeat-x scroll left center; border-bottom: 1px solid #C2C9CF;"><th colspan="2" style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px;"><span style="font-weight: normal;">Custom Proof corrections needed for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION['order_num'] . ')</span></th></tr>   
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
										<p>The user has provided instructions for corrections on their custom proof.</p>
										<p>';
										
			$message .=					'(1) ' . $_SESSION['special_instructions'] . '<br />';
			
			$i = 2;							
			while ($instr_row = $instr_result->fetch_assoc()) {				
				$message .= '(' . $i . ') ' . $instr_row['custom_instruction'] . '<br />';
				$i++;
			}
						
										
										
			$message .=					'</p>';
			
			
			
			$message .=
										'<p style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px; margin-top: 42px;">Upload Link</p>
										<p>Use this link to upload the corrected custom proof for this order once completed.</p>
										<p><a href="' . $site_basedir . 'admin/upload_custom_proof.php?order_id=' . $_SESSION['order_num'] . '">Upload Corrected Custom Proof PDF here</a></p>
										
										
										
										
										
										
										
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

		header('Location: ' . $site_basedir . 'custom_not_approved.php?instructions_sent=1');
	} else {
		$submit_error = '<p class="error_message">Please provide instructions for the graphic designer as to how to make corrections to the custom proof. The order can not continue without this.</p>';	
	}


}





if(isset($_GET['instructions_sent'])) {
?>
	<div class="form_container" id="thank_you_box">  
        <div class="row">
            <div class="clientform_table_header">Your order has been sent back for corrections</div>   
        </div>
        
        <div class="row">
            <div class="content">
                <p>Your order has been sent back with the detailed instructions you provided. Please be aware that you will receive the corrected custom proof soon. Make sure you review that proof as soon as possible.</p>
			</div>
          </div>       
    </div>


<?php } else { ?>


    
    <div class="form_container" id="thank_you_box">  
        <div class="row">
            <div class="clientform_table_header">Please provide instructions for needed custom proof corrections</div>   
        </div>
        
        <div class="row">
            <div class="content">
                <p>Please provide detailed instructions to correct the custom proof.</p>
                
                <form id="clientForm" name="clientForm" method="post" action="">
                	<textarea name="instruction_message" style="width: 375px; margin-top: 10px;"></textarea>
                    
                <?php if(isset($submit_error)) {echo $submit_error;} ?>
                
			</div>
          </div>       
         
        <div class="row">
            <div class="content" id="thankyou_last_content_1"><input class="button next submit" type="submit" name="submit" value="Submit for Corrections" /></form></div>	
		</div>
    </div> 
     
<?php }   


	?>    
          
		 
</div>

</body>

</html>