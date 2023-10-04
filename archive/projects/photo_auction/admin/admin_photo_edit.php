<?php 
session_start();



error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	include("../includes/connection.php");
	
	if(!isset($_SESSION['authenticated_pa_admin'])){
	header('Location: ' . $site_basedir . 'admin/admin_login.php');
}
	
	$OK = false; //boolean variable to be used later which checks the success of retrieving the record
	$done = false; //boolean variable to be used later which checks whether the update succeeds
	
	
	//create a database connection which comes from 'conn.inc.php'
	$conn = dbConnect('admin');
		
	//get details of selected record
	 if (isset($_GET['photo_id']) && !$_POST) { 
		
		$sql = 'SELECT photos.photo_id, photos.photo_title, photos.photographer_id, photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, photos.type_id, types.type_id, types.type_name, photos.photo_price, photos.image_id, images.image_id, images.image_filename, photos.highest_bidder, users.user_id, photos.end_auction, photos.status, users.username
				FROM photos
				LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
				LEFT JOIN styles ON photos.style_id = styles.style_id
				LEFT JOIN types ON photos.type_id = types.type_id
				LEFT JOIN images ON photos.image_id = images.image_id
				LEFT JOIN users ON photos.highest_bidder = users.user_id
				WHERE photos.photo_id = ?';
				
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql)) { 
			$stmt->bind_param('i', $_GET['photo_id']); 
			$stmt->bind_result($photo_id, $photo_title, $current_photographer_id, $photographer_id2, $current_photographer_name, $photographer_firstname, $photographer_lastname, $current_style_id, $style_id2, $current_style_name, $current_type_id, $type_id2, $current_type_name, $photo_price, $image_id, $image_id2, $image_filename, $highest_bidder, $userid, $end_auction, $status, $username); 
			$OK = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $OK
			$row = $stmt->fetch(); //fetches the result
			
			//This splits the auction end datetime into separate date and time values
			$end_datetime = explode(" ", $end_auction);
			$end_date = $end_datetime[0];
			$endTime = $end_datetime[1];
			
			
			
			
			//These next lines convert the time in the database from Military time to American time
			$extracted_endhour = substr($endTime, 0, 2);
			$extracted_endmin = substr($endTime, 3, 2);
			
			if($extracted_endhour > 12) { //resets the hour to 1pm after 12 hours
				$extracted_endhour_converted = ($extracted_endhour -12);
			} elseif($extracted_endhour == '00') {
				$extracted_endhour_converted = '12';
			} else {
				$extracted_endhour_converted = $extracted_endhour;
			}
			
			
		}
	} //end if get photo id and !post
	
	//if form has been submitted, update record
	if (array_key_exists('update', $_POST)) { //checks that something with the 'update' name attribute is in the $_POST array, which it is once it is clicked. If the user does click on it, the execute the rest of the script
		
		//These next 40 lines convert the chosen time back from American time to Military time	
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
		$endTime = $endhour.':'.$_POST["end_min"].':00';
		
		$end_date_time = $_POST['end_date'] . ' ' . $endTime;
		
		//prepare update query
		$sql = 'UPDATE photos
				LEFT JOIN photographers 
				ON photos.photographer_id = photographers.photographer_id
				LEFT JOIN styles 
				ON photos.style_id = styles.style_id
				LEFT JOIN types 
				ON photos.type_id = types.type_id
				LEFT JOIN users 
				ON photos.highest_bidder = users.user_id
				SET photos.photo_title = ?, photos.photo_price = ?, photos.photographer_id = ?, photos.style_id = ?, photos.type_id = ?, photos.end_auction = ?, photos.status = ?
				WHERE photos.photo_id = ?';
				
				
		
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql)) { 
			$stmt->bind_param('siiiissi', $_POST['photo_title'], $_POST['photo_price'], $_POST['photographer_name'], $_POST['style_name'], $_POST['type_name'], $end_date_time, $_POST['status'], $_POST['photo_id']); 
			$done = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $done
		}
	}
	
	
	// redirect on success or if $_GET['article_id']) is not defined. This ensures that the page is redirected either if the update succeeds or if someone tries to access the page directly.
	if ($done || !isset($_GET['photo_id'])) { //if $_GET['article_id'] is not defined
		header('Location: ' . $site_basedir . 'admin/admin_list.php');
		exit; //and exit the script	
	}
	
	//display error message if query fails
	if (isset($stmt) && !$OK && !$done) { //if the prepared statement has been created, but both $OK and $done remain false 
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
<title><?php echo $site_name; ?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/jquery.datepick.css" type="text/css" media="screen" charset="utf-8" />

<script type="text/javascript" src="../js/jquery.pack.js"></script>
<script type="text/javascript" src="../js/jquery.datepick.pack.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		//configure the date format to match mysql date
		$('#end_date').datepick({dateFormat: 'yy-mm-dd'});
	});
</script>


<link rel="shortcut icon" href="../../images/favicon.ico" />
</head>

<body>
<div id="container">
    <?php include('../includes/adminheader.php'); ?>
    
    <div id="main_content">
        <div id="highest_items">
            <h2 style="margin-left: 0px;">Edit Photo entry </h2>
                <form id="edit_form" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                    <p>
                        <label for="photo_title">Photo Title:</label>
                        <input name="photo_title" type="text" class="widebox" id="photo_title_new" value="<?php echo htmlentities($photo_title); ?>"/></input>
                    </p>
                    
                    <p>
                        <label for="photographer_name">Photographer's Name:</label>
                        <select name="photographer_name" id="photographer_name_edit">
							<?php 
                                $conn = dbConnect('admin');
                        
                                $photographer_sql = 'SELECT photographers.photographer_id, photographers.photographer_name
                                                    FROM photographers';
    
                                if($result = $conn->query($photographer_sql) or die(mysqli_error())) :
                                    if($result->num_rows == 0):
                                        echo "There are no Photographers listed in the database!";
                                    else:
                                        while($row = $result->fetch_assoc()) :
                                            if($row['photographer_id'] == $current_photographer_id) { 
                                                echo "<option value=' " . $current_photographer_id . " ' SELECTED> " . $current_photographer_name . " </option>"; 
                                            } else { 
                                                echo "<option value=' " . $row['photographer_id'] . " ' > " . $row['photographer_name'] . " </option>"; 
                                            }
                                        endwhile;
                                    endif;
                                else:
                                    echo 'Bad Query';
                                endif;
                            ?>
                        </select>
                    </p>
                    
 
                    
                     <p>
                        <label for="style_name">Style:</label>
                        <select name="style_name" id="style_name_edit">
							<?php 
                                $conn = dbConnect('admin');
                        
                                $style_sql = 'SELECT styles.style_id, styles.style_name
                                                    FROM styles';
    
                                if($result = $conn->query($style_sql) or die(mysqli_error())) :
                                    if($result->num_rows == 0):
                                        echo "There are no Styles listed in the database!";
                                    else:
                                        while($row = $result->fetch_assoc()) :
                                            if($row['style_id'] == $current_style_id) { 
                                                echo "<option value=' " . $current_style_id . " ' SELECTED> " . $current_style_name . " </option>"; 
                                            } else { 
                                                echo "<option value=' " . $row['style_id'] . " ' > " . $row['style_name'] . " </option>"; 
                                            }
                                        endwhile;
                                    endif;
                                else:
                                    echo 'Bad Query';
                                endif;
                            ?>
                        </select>
                    </p>
                    
					<p>
                        <label for="type_name">Type:</label>
                        <select name="type_name" id="type_name_edit">
                            <?php 
                                $conn = dbConnect('admin');
                        
                                $type_sql = 'SELECT types.type_id, types.type_name
                                                    FROM types';
    
                                if($result = $conn->query($type_sql) or die(mysqli_error())) :
                                    if($result->num_rows == 0):
                                        echo "There are no types listed in the database!";
                                    else:
                                        while($row = $result->fetch_assoc()) :
                                            if($row['type_id'] == $current_type_id) { 
                                                echo "<option value=' " . $current_type_id . " ' SELECTED> " . $current_type_name . " </option>"; 
                                            } else { 
                                                echo "<option value=' " . $row['type_id'] . " ' > " . $row['type_name'] . " </option>"; 
                                            }
                                        endwhile;
                                    endif;
                                else:
                                    echo 'Bad Query';
                                endif;
                            ?>
                        </select>
                	</p>
                    
                    <p>
                        <label for="end_date">Auction End Date & Time:</label>
                        <input name="end_date" id="end_date" value="<?php echo htmlentities($end_date); ?>"></input>
                    </p>
                    
                    <p>
                        <label for="end_hour">Auction End Time:</label>
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
                    </p>
                    
                     <p>
                        <label for="photo_price">Photo Price:</label>
                        <input type="text" name="photo_price" id="photo_price_new" value="<?php echo htmlentities($photo_price); ?>"></input>
                    </p>
                    
                    <p>
                        <label for="status">Auction Status:</label>
                        <input type="radio" name="status" value="active" <?php if($status == 'active') { echo 'checked'; } ?>>Active
						<input type="radio" name="status" value="not active" <?php if($status == 'not active') { echo 'checked'; } ?>>Not Active
                    </p>
                    
                    
                    
                    <p>
                        <input type="submit" name="update" value="Update entry" />
                    	<input name="photo_id" type="hidden" value="<?php echo $photo_id ?>"/>
                    </p>
        		</form> 
        </div> <!--end highest items div-->
    </div> <!--end main content div-->
</div> <!--end container div-->


<?php mysqli_close($conn); ?>
</body>
</html>