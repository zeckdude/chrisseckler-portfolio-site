<?php 
session_start();
	include("../includes/connection.php");
	
	if(!isset($_SESSION['authenticated_vs'])){
	header('Location: ' . $site_basedir . 'login.php');
	}

	$conn = dbConnect('admin');

	
	$OK = false; 
	$updated = false; 

	if (isset($_GET['id']) && !$_POST) { 
  
	  $sql = 'SELECT *
			  FROM schedule
			  WHERE id = ?';
					
			$stmt = $conn->stmt_init(); 
			if ($stmt->prepare($sql)) { 
				$stmt->bind_param('i', $_GET['id']);
				$stmt->bind_result($id, $presenter, $startTime, $endTime); 
				$OK = $stmt->execute(); 
				$stmt->fetch();
				
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
	  
	
	//if form has been submitted, update record
	if (array_key_exists('update', $_POST)) { //checks that something with the 'update' name attribute is in the $_POST array, which it is once it is clicked. If the user does click on it, the execute the rest of the script
		
		//These next 40 lines convert the chosen time back from American time to Military time
		#### Condition for setting start time ####
		#### If hour is 12 am, sets hour to 0 ####
			if($_POST['start_hour'] == 12 && $_POST['start_am_pm'] == 'am'){
				$starthour = 0;
		#### If hour is 12 pm, leaves hour at 12 ####
			}elseif($_POST['start_hour'] == 12 && $_POST['start_am_pm'] == 'pm'){
				$starthour = 12;
		#### If hour is not 12, and is pm, then add 12 to hour, example, 2 pm would be hour 14 [2 + 12] ####
			}elseif($_POST['start_hour'] != 12 && $_POST['start_am_pm'] == 'pm'){
				$starthour = $_POST['start_hour'] + 12;
		#### Any thing else [with am], leave hour as is.  2 am is hour 2 ####
			}else{
				$starthour = $_POST['start_hour'];
			}
			
		#### Condition for setting end time ####
		#### If hour is 12 am, sets hour to 0 ####
			if($_POST['end_hour'] == 12 && $_POST['end_am_pm'] == 'am'){
				$endhour = 0;
		#### If hour is 12 pm, leaves hour at 12 ####
			}elseif($_POST['end_hour'] == 12 && $_POST['end_am_pm'] == 'pm'){
				$endhour = 12;
		#### If hour is not 12, and is pm, then add 12 to hour, example, 2 pm would be hour 14 [2 + 12] ####
			}elseif($_POST['end_hour'] != 12 && $_POST['end_am_pm'] == 'pm'){
				$endhour = $_POST['end_hour'] + 12;
		#### Any thing else [with am], leave hour as is.  2 am is hour 2 ####
			}else{
				$endhour = $_POST['end_hour'];
			}
		$startTime = $starthour.':'.$_POST["start_min"].':00';
		$endTime = $endhour.':'.$_POST["end_min"].':00';
		
		
		//prepare update query
		$sql = 'UPDATE schedule
				SET presenter = ?, startTime = ?, endTime = ?
				WHERE id = ?';
				
		//initialize prepared statement which will guarantee the code against SQL injection(MySQLI specific way of security)
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql)) { 
		
			//bind parameters and execute statement
			$stmt->bind_param('sssi', $_POST['presenter'], $startTime, $endTime, $_POST['id']);
			$updated = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $done
		}
	}
	
	
	// redirect on success or if $_GET['article_id']) is not defined. This ensures that the page is redirected either if the update succeeds or if someone tries to access the page directly.
	if ($updated == true || !isset($_GET['id'])) { //if $_GET['article_id'] is not defined
		header('Location: ' . $site_basedir .'admin/schedule_edit_list.php'); //then redirect to this page
		exit; //and exit the script	
	}
	
	//display error message if query fails
	if (isset($stmt) && !$OK && !$updated) { //if the prepared statement has been created, but both $OK and $done remain false 
		echo $stmt->error;	// then display an error message on the screen
	}
	
function leadingZeros($num,$numDigits) {
   return sprintf("%0".$numDigits."d",$num);
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
        <!--EDITABLE-->
        <div id="adminenter_box">
        	<p>
        		You are editing the presentation information for <?php echo htmlentities($presenter); ?>
        	</p>
        </div>
        
        <div id="delete_agent_btn">
        	<a href="schedule_delete_entry.php?id=<?php echo $id; ?>">- Delete this Presentation</a>
		</div>
        
        <div class="content_area">
        	<form id="newphotoform" name="form1" method="post" action="">
            
            	
                    <table id="form_table">
                        <tr>
                                <th>Presenter:</th>
                                <td><input name="presenter" type="text" id="presenter" value="<?php echo htmlentities($presenter); ?>"/></td>
                        </tr>
                        
                        <tr>
                            <th>Start Time:</th>
                            <td>
                                <select name="start_hour" id="start_hour"> <!--FIRST STARTTIME SELECTBOX - to select the start hour-->
									<?php for($t=1; $t < 13; $t++){?>
                                        <option 
                                            <?php if($t == $extracted_starthour_converted) { echo 'selected'; } ?> value="<?php echo $t; ?>" ><?php echo $t; ?>
                                        </option>
                                	<?php } ?>
                                </select>
                                
                                :
                                
                                <select name="start_min" id="start_min"> <!--SECOND STARTTIME SELECTBOX  - to select the start minutes-->
									<?php for($t=00; $t < 59; $t=$t+5){?>
                                        <option 
                                        	<?php if($t == $extracted_startmin) { echo 'selected'; } ?> value="<?php echo leadingZeros($t,2); ?>" ><?php echo leadingZeros($t,2); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                
                                <select name="start_am_pm" id="start_am_pm"> <!--THIRD STARTTIME SELECTBOX  - to select am or pm-->
                                    <option 
                                        <?php if($extracted_starthour >= 12) { echo 'selected'; } ?> value="pm" >pm
                                    </option>
                                    <option 
                                    	<?php if($extracted_starthour < 12) { echo 'selected'; } ?> value="am" >am
                                    </option>
                                </select>                           
                            </td>
                        </tr>
                        
                        <tr>
                            <th>End Time:</th>
                            <td>
                                <select name="end_hour" id="end_hour"> <!--FIRST ENDTIME SELECTBOX - to select the end hour-->
									<?php for($t=1; $t < 13; $t++){?>
                                        <option 
                                            <?php if($t == $extracted_endhour_converted) { echo 'selected'; } ?> value="<?php echo $t; ?>" ><?php echo $t; ?>
                                        </option>
                                	<?php } ?>
                                </select>
                                
                                :
                                
                                <select name="end_min" id="end_min"> <!--SECOND ENDTIME SELECTBOX  - to select the end minutes-->
									<?php for($t=00; $t < 59; $t=$t+5){?>
                                        <option 
                                        	<?php if($t == $extracted_endmin) { echo 'selected'; } ?> value="<?php echo leadingZeros($t,2); ?>" ><?php echo leadingZeros($t,2); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                
                                <select name="end_am_pm" id="end_am_pm"> <!--THIRD ENDTIME SELECTBOX  - to select am or pm-->
                                    <option 
                                        <?php if($extracted_endhour >= 12) { echo 'selected'; } ?> value="pm" >pm
                                    </option>
                                    <option 
                                    	<?php if($extracted_endhour < 12) { echo 'selected'; } ?> value="am" >am
                                    </option>
                                </select>                            
                            </td>
                        </tr>

                        <tr>
                            <th></th>
                            <td>
                                <input class="submit_button" type="submit" name="update" value="Update the presentation information" />
                                <input name="id" type="hidden" value="<?php echo $id ?>"/>
                            </td>
                        </tr>
                    </table>
            	
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
