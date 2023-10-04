<?php

//This is the code for the email to be sent to the translator
if(!isset($_SESSION['translator_mail_sent'])) {
		
			//if($row['character_hold'] != 'yes') {
			
			$date = date("m/j/y");
			$mailTo = $translator_email;
			$subject = 'Translation needed for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION['order_num'] . ')';
			$message = 
						'<html>
						<head>
						<title>Translation Needed</title>
						</head>
						<body style="font-size: 12px;">
							<table style="width: 400px; border: 1px solid #5C7F99; margin-left: auto; margin-right: auto; margin-top: 35px;">
								<thead>
									<tr style="background: #FFFFFF none repeat-x scroll left center; border-bottom: 1px solid #C2C9CF;"><th colspan="2" style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px;"><span style="font-weight: normal;">Translation needed for ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '(Order #' . $_SESSION['order_num'] . ')</span></th></tr>   
								</thead>    
								<tbody>
									<tr>
										<td colspan="2" style="padding: 7px 15px; color: #183152; ">
											<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Order #:</span> ' . $_SESSION['order_num'] . '</p>
											<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Language:</span> ';
											
			if($_SESSION["language"] != '') {							
				$message .=	$_SESSION["language"];
			} else {
				$message .=	$_SESSION["other_language"];
			}
			
			$message .=
											'</p>
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
			
			
			
			
			
	
			
			
			
			
			
			if($_SESSION['foreign_characters_name'] != '' || $_SESSION['foreign_characters_line2'] != '' || $_SESSION['foreign_characters_line3'] != '' || $_SESSION['foreign_characters_line4'] != '' || $_SESSION['upload_location'] != '') {
					$message .= '<p style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px; margin-top: 42px;">Download User Provided Characters</p>';	
				}
			
			if($_SESSION['upload_location'] != '') {
				$message .=
							'<p>The user has provided artwork that shows their foreign characters.</p>';
										
										
				// directory path can be either absolute or relative
				//$dirPath = $site_basedir . 'upload/' . $_SESSION['upload_location'];
				
				//$message .= '<br /><br />' . $_SESSION['dirPath'];
				
				// open the specified directory and check if it's opened successfully
				if ($handle = opendir($_SESSION['dirPath'])) {
				
				   // keep reading the directory entries 'til the end
				   while (false !== ($file = readdir($handle))) {
				
					  // just skip the reference to current and parent directory
					  if ($file != "." && $file != "..") {
						 if (is_dir("$_SESSION[dirPath]/$file")) {
							// found a directory, do something with it?
							$message .= "[$file]<br>";
						 } else {
							// found an ordinary file
							$message .= "<a target='_blank' href='" . $site_basedir . "upload/" . $_SESSION['upload_location'] . "/$file'>$file</a><br>";
						 }
					  }
				   }
				
				   // ALWAYS remember to close what you opened
				   closedir($handle);
				}
			}	
				
				
					
				if($_SESSION['foreign_characters_name'] != '' || $_SESSION['foreign_characters_line2'] != '' || $_SESSION['foreign_characters_line3'] != '' || $_SESSION['foreign_characters_line4'] != '') {
					$message .= '<p>The user has provided their own foreign characters for use on their order.</p>';	
				}
					
					
				if($_SESSION['foreign_characters_name'] != '') {
					$message .= '<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Name:</span> ' . html_entity_decode($_SESSION["foreign_characters_name"]) . '</p>';
				}
				
				if($_SESSION['foreign_characters_line2'] != '') {
					$message .= '<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Line 2:</span> ' . $_SESSION["foreign_characters_line2"] . '</p>';
				}
				
				if($_SESSION['foreign_characters_line3'] != '') {
					$message .= '<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Line 3:</span> ' . $_SESSION["foreign_characters_line3"] . '</p>';
				}
				
				if($_SESSION['foreign_characters_line4'] != '') {
					$message .= '<p><span style="font-weight: bold; width: 100px; float: left; width: 82px;">Line 4:</span> ' . $_SESSION["foreign_characters_line4"] . '</p>';
				}
			
				
				
			
			
			
			
			$message .=
										'<p style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px; margin-top: 42px;">Upload Link</p>
										<p>Use this link to upload the translations for this order once completed.</p>
										<p><a href="' . $site_basedir . 'admin/trans_char_upload.php?order_id=' . $_SESSION['order_num'] . '">Upload Translation PDF here</a></p>
										
										
										
										
										
										
										
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
		
			
			$_SESSION['translator_mail_sent'] = 'yes';
		//}
	}














?>