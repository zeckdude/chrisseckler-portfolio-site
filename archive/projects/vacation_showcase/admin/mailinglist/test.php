<?php
ob_start();
//session_start();
	include("../../includes/connection.php");
	
	/*if(!isset($_SESSION['authenticated_vs'])){
	header('Location: ' . $site_basedir . 'login.php');
	} */
  
  

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php include('../../includes/titleline.php'); ?></title>
<link rel="stylesheet" href="../../css/style.css" type="text/css" media="screen" />
<link rel="shortcut icon" href="../../images/favicon.png" />





<!--[if IE]>
<link href="css/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->



</head>

<body>      
    <!--PERMANENT FOR NOW UNTIL I CREATE DYNAMIC CSS-->
    <div id="header"></div>
    
     <div id="bottomleft_shadow">
     <div id="bottomright_shadow">
     <div id="left_shadow">
     <div id="right_shadow">
     <div id="bottom_shadow">
     <div id="container">
    
        <!--PERMANENT-->
        <a href="../../index.php"><div id="title"> 
            <h2>Peninsula Travel Experts'</h2>
            <h1>VACATION SHOWCASE</h1>
        </div></a>
        
        <div class="back"><a href="../admincontrols.php">Admin Controls</a></div>
        <div class="logout"><a href="<?php echo $site_basedir; ?>includes/logout.php">Logout</a></div>
        <!--EDITABLE-->
        <div id="adminenter_box">
        	<p>
        		Newsletter Distribution Application
        	</p>
        </div>

        
        <div class="content_area" style="width: 520px;">
        	<div id="adminlinks">
                <a href="index.php?action=manage-subscribers">Manage Subscribers</a>
                <a href="index.php?action=manage-lists">Manage Lists</a>
                <a href="index.php?action=manage-mail">Manage Mail</a> 
            </div>  
        </div>
        
        
        <?php

		  // this functionality is in a separate file to allow us to be
		  // more paranoid with it
		
		  // if anything goes wrong, we will exit
		
		  $max_size = 50000;
		  
		  $message = "";
		  $uploading_message = "";
		  $resubmit_alert = "<p id='resubmit_alert'>Please click on Manage Mail and resubmit your email</p>";
		  
		  include ('includes/include_fns.php');
		
		  
		  // iterate through the array of uploaded images
		  $i = 0;
		  print_r($_FILES['images']);
		  //echo $_FILES['images']['name'][0];
		  while (($_FILES['images']['name'][$i]) &&
				 ($_FILES['images']['name'][$i] !='none')) {
			$uploading_message .=  "<p>Uploading ".$_FILES['images']['name'][$i]." - ".
				  $_FILES['images']['size'][$i]." bytes.</p>";
				  
		
			if ($_FILES['images']['size'][$i]==0) {
			  $message .= "<p>Problem: ".$_FILES['images']['name'][$i].
				   " is zero length</p>";
			  $error = true;
			  $i++;
			  continue;
			}
			
		
			if ($_FILES['images']['size'][$i]>$max_size) {
			  $message .= "<p>Problem: ".$_FILES['images']['name'][$i]." is over "
					.$max_size." bytes</p>";
			  $error = true;
			  $i++;
			  continue;
			}
		
			// we would like to check that the uploaded image is an image
			// if getimagesize() can work out its size, it probably is.
			if(($i>1) && (!getimagesize($_FILES['images']['tmp_name'][$i]))) {
			  $message .= "<p>Problem: ".$_FILES['images']['name'][$i].
				   " is corrupt, or not a gif, jpeg or png.</p>";
			  $error = true;
			  $i++;
			  continue;
			}
		
			
			  $destination = "archive/".$list."/".$mailid."/"
							 .$_FILES['images']['name'][$i];
			  
			  $query = "insert into images values ('".$mailid."',
							   '".$_FILES['images']['name'][$i]."',
							   '".$_FILES['images']['type'][$i]."')";
		
			  $result = $conn->query($query);
			
		
			if (!is_uploaded_file($_FILES['images']['tmp_name'][$i])) {
			  // possible file upload attack detected
			  $message .= "<p>Something funny happening with "
				   .$_FILES['images']['name'].", not uploading.</p>";
			  $error = true;
			  exit;
			}
		
			move_uploaded_file($_FILES['images']['tmp_name'][$i],
							   $destination);
		
			$i++;
		  }
		  
		  /*echo $_FILES['images'];
		  
		  
		 $images = $_FILES['images']; 
		  
		 foreach ($images as $data)
			{
			print_r($data);
			}*/
		  
		  
		  



		if ($error == true) {
			echo '<div id="upload_message_area">' . $uploading_message . $message . $resubmit_alert .
				  '</div>';
		} else {
			echo '<div id="upload_message_area">';
				echo '<p style="font-size: 12px; text-align: center; margin-bottom: 30px;">All files uploaded successfully. Please choose one of the three below options</p>';
				echo "<a class='submit_button' style='padding: 10px; margin-left: 50px; margin-right: 10px;' target='new' href='archive/" . $list . "/" . $mailid . "/index.html'>Preview Html</a>";
				echo "<a class='submit_button' style='margin-right: 10px; margin-bottom: 20px;' target='new' href='archive/" . $list . "/" . $mailid . "/text.txt'>Preview Text</a>";
				echo "<a class='submit_button' href='index.php?action=send&id=" . $mailid . ">Send Mail</a>";
			echo '</div>';
		}
		
		
		
		
		?>
        
        
        
        <?php include('../../includes/companyline.php'); ?>
        
        
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    
</body>
</html>
