<?php 
session_start();
	include("../includes/connection.php");
	
	if(!isset($_SESSION['authenticated_vs'])){
	header('Location: ' . $site_basedir . 'login.php');
	}
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('admin');

	//These are variables that will be used later. For now, they must be false until something happens
	$OK = false;
	$deleted = false;

	if (isset($_GET['id']) && !$_POST) { //This is checking that the GET variable 'id' exists in the url and that somebody pushed a form button to get here
  
	  //This is telling the database what we want to grab from the database to potentially show on the page
	  $sql = 'SELECT *
			  FROM schedule
			  WHERE id = ?';
					
			//This starts the prepared statement which is a secure way of sending and receiving information
			$stmt = $conn->stmt_init(); 
			if ($stmt->prepare($sql)) { 

				$stmt->bind_param('i', $_GET['id']); //This is where you specify what GET variable you are using
				
				$stmt->bind_result($id, $presenter, $startTime, $endTime); //This saves the row's data into variables so you can use them later. They must be in the same order as the SQL query on line 15
				
				$OK = $stmt->execute(); //This saves whether it worked or not in $OK(True/False)
				$stmt->fetch(); //This fetches the result(No idea what that means, not too important)
				
				//These next 20 lines converts the time in the database from Military time to American time
				$extracted_starthour = substr($startTime, 0, 2);
				$extracted_endhour = substr($endTime, 0, 2);
				$extracted_endmin = substr($endTime, 3, 2);
				$extracted_startmin = substr($startTime, 3, 2);
				
				if($extracted_starthour > 12) { //resets the hour to 1pm after 12 hours
					$extracted_starthour_converted = ($extracted_starthour -12);
				} elseif($extracted_starthour == '00') {
					$extracted_starthour_converted = '12';
				} else {
					$extracted_starthour_converted = $extracted_starthour;
				}
				
				if($extracted_endhour > 12) { //resets the hour to 1pm after 12 hours
					$extracted_endhour_converted = ($extracted_endhour -12);
				} elseif($extracted_endhour == '00') {
					$extracted_endhour_converted = '12';
				} else {
					$extracted_endhour_converted = $extracted_endhour;
				}
			
			}
	  }
	  
	
	if (array_key_exists('delete', $_POST)) { //If the 'delete' button is clicked, then run this bit of code
	  $sql = 'DELETE FROM schedule WHERE id = ?'; //This tells the database to delete the entry with the id # that is currently being sent from the form
	  $stmt = $conn->stmt_init();
	  if ($stmt->prepare($sql)) {
		$stmt->bind_param('i', $_POST['id']); //This is where you specify what POST variable you are using
		$deleted = $stmt->execute(); //This saves whether it worked or not in $deleted(True/False)
		}
	  }
	  
	// redirect the page if deletion is successful, cancel button is clicked, or $_GET['id'] is not defined
	if ($deleted == true || array_key_exists('cancel_delete', $_POST) || !isset($_GET['id']))  {
	  header('Location: ' . $site_basedir .'admin/schedule_edit_list.php'); //If any of the top 3 conditions are met, then go to this page
	  exit;
	  }
	  
	// if any SQL query fails or if , display error message
	if (isset($stmt) && !$OK && !$deleted) {
	  echo $stmt->error;
	  }
	  
	if($extracted_starthour >= 12) {
		$start_time_identifier = 'pm';	
	} else if ($extracted_starthour < 12)  {
		$start_time_identifier = 'am';
	}
	
	if($extracted_endhour >= 12) {
		$end_time_identifier = 'pm';	
	} else if ($extracted_endhour < 12)  {
		$end_time_identifier = 'am';
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php include('../includes/titleline.php'); ?></title>
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
<link rel="shortcut icon" href="../images/favicon.png" />

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
        <div id="title"> 
            <h2>Peninsula Travel Experts'</h2>
            <h1>VACATION SHOWCASE</h1>
        </div>
        
        <div class="back"><a href="schedule_edit_list.php">Back</a></div>
        <div class="logout"><a href="../includes/logout.php">Logout</a></div>
        
        <div id="adminenter_box">
            <p>
        		Are you sure you want to delete this Presentation?
        	</p>
        </div>

        
        <div class="content_area">
            <table id="aboutusdelete_table">
                <tr id="aboutusedit_header">
                        <th>Presenter</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                </tr>
                    <tr>
                        <td><?php echo $presenter; ?></td>
                        <td><?php echo $extracted_starthour_converted . ':' . $extracted_startmin . ' ' . $start_time_identifier; ?></td>
                        <td><?php echo $extracted_endhour_converted . ':' . $extracted_endmin . ' ' . $end_time_identifier; ?></td>
                    </tr>                        
            </table>
            
            <form id="form1" name="form1" method="post" action="">
                <span id="delete_area">
                    <span class="delete_btn"><input class="submit_button" name="cancel_delete" type="submit" id="cancel_delete" value="Cancel" /></span>
                    <span class="delete_btn"><input class="submit_button" name="delete" type="submit" value="Confirm deletion" /></span>
                </span>
                    <input name="id" type="hidden" value="<?php echo $id; ?>" />
            </form>
        </div>
        <?php include('../includes/companyline.php'); ?>
        
        
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
<?php mysqli_close($conn); ?>   
</body>
</html>
