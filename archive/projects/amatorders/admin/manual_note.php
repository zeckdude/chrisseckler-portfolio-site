<?php
session_start();
ob_start();

date_default_timezone_set('America/Los_Angeles');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Applied Materials Note Adding Center</title>
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/favicon.gif" />
</head>

<script src="../js/jquery-1.4.2.min.js" type="text/javascript"></script>





<body>


<div id="container">


<?php 





include("../includes/connection.php");
include("../includes/admin_header.php");
$conn = dbConnect('admin');


if(!isset($_SESSION['authenticated_oc'])){
	header('Location: ' . $site_basedir . 'login.php');
}

if(!isset($_GET['order_id'])){
	header('Location: ' . $site_basedir . 'admin/tracker.php');
}


if(isset($_POST['submit'])) {
	

	if($_POST['note_message'] != '') {
		
		foreach($_POST as $key => $value) {
			$_POST[$key] = sanitize($conn, $value); //This sanitizes the current session variable and then saves it back as the same session variable name
		}
		
		
		$_SESSION['note_message'] = $_POST['note_message'];
		
		$date_added = date('Y-m-d H:i:s',time());
		
		//This adds the note marking a change in status		
		$notes_sql = 'INSERT into notes SET
				order_id = "'.$_GET['order_id'].'",
				date_added = "'.$date_added.'",
				note_message = "'.$_POST['note_message'].'"';
		
		$notes_result = $conn->query($notes_sql) or die(mysqli_error($conn));

		header('Location: ' . $site_basedir . 'admin/manual_note.php?note_sent=1');
	} else {
		$submit_error = '<p class="error_message">Please provide a note to be added.</p>';	
	}


}





if(isset($_GET['note_sent'])) {	
?>
	<div class="form_container" id="thank_you_box">  
        <div class="row">
            <div class="clientform_table_header">Your note was added</div>   
        </div>
        
        <div class="row">
            <div class="content">
                <p>Your note was added. You will be redirected in 3 seconds.</p>
                <?php
					header( 'refresh: 2; url=' . $site_basedir . '/admin/tracker.php' );
				?>
			</div>
          </div>       
    </div>


<?php } else { ?>


    
    <div class="form_container" id="thank_you_box">  
        <div class="row">
            <div class="clientform_table_header">Please provide note to be added</div>   
        </div>
        
        <div class="row">
            <div class="content">
                <p>Enter your note here:</p>
                
                <form id="clientForm" name="clientForm" method="post" action="">
                	<textarea name="note_message" style="width: 375px; margin-top: 10px;"></textarea>
                    
                <?php if(isset($submit_error)) {echo $submit_error;} ?>
                
			</div>
          </div>       
         
        <div class="row">
            <div class="content" id="thankyou_last_content_1"><input class="button next submit" type="submit" name="submit" value="Add Note" /></form></div>	
		</div>
    </div> 
     
<?php }   


	?>    
          
		 
</div>

</body>

</html>