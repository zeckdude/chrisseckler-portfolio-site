<?php 
session_start();



error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	include("../includes/connection.php");
	
	
	if(!isset($_SESSION['authenticated_pa_admin'])){
	header('Location: ' . $site_basedir . 'admin/admin_login.php');
}
	
	$inserted = false;
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('admin');
	
	
	
	$sql = 'SELECT photographers.photographer_id, photographers.photographer_name
			FROM photographers 
			ORDER BY photographer_name ASC';
	
	//submits the query
	$photographer_result = $conn->query($sql) or die(mysqli_error());
	
	//Get the number of records found 
	$photographer_numRows = $photographer_result->num_rows;
	
	
	$sql = 'SELECT styles.style_id, styles.style_name
			FROM styles 
			ORDER BY style_name ASC';
	
	$style_result = $conn->query($sql) or die(mysqli_error());
	$style_numRows = $style_result->num_rows;
	
	
	$sql = 'SELECT types.type_id, types.type_name
			FROM types 
			ORDER BY type_name ASC';
	
	$type_result = $conn->query($sql) or die(mysqli_error());
	$type_numRows = $type_result->num_rows;
	
	

	
	
	
	if (array_key_exists('insert', $_POST)) { 
		
		////////////UPLOAD SCRIPT FOR IMAGE
		$folder = '../images/';
		$orig_w = 400;
		
		$imageFile = $_FILES['image']['tmp_name'];
		$filename = basename( $_FILES['image']['name']);
		$filename = str_replace(' ', '_', $filename); //change all spaces to underscores within a file name and save the result in $file
		
		list($width, $height) = getimagesize($imageFile);
		
		$src = imagecreatefromjpeg($imageFile);
		$orig_h = ($height/$width)* $orig_w;
		
		$tmp = imagecreatetruecolor($orig_w, $orig_h);
		imagecopyresampled($tmp, $src, 0,0,0,0,$orig_w,$orig_h,$width,$height);
		imagejpeg($tmp, $folder.$filename,100);
		
		imagedestroy($tmp);
		imagedestroy($src);
		
		$filename = urlencode($filename);
		
		$sql = 'INSERT INTO images (images.image_filename)
				VALUES(?)';
				
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql)) { 
			$stmt->bind_param('s', $filename); 
			$image_inserted = $stmt->execute(); 
		}
		
		$new_photo_id = mysqli_insert_id($conn); //saves the id of the last insert into a variable
		
		
		
		
		//THIS FORMATS THE TIME FOR THE AUCTION END TIME	
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
		
		$endDateTime = $_POST['end_date'] . ' ' . $endTime; //Combining the Date and Time
		
		
		$initial_email_value = 'not sent';
		
		if($_POST['status'] == 'yes') {
			$status = 'active';	
		} else {
			$status = 'not active';	
		}
		
		
		
		//INSERTING INFORMATION ABOUT PHOTO
		$sql = 'INSERT INTO photos (photos.photo_title, photos.photographer_id, photos.style_id, photos.type_id, photos.image_id, photos.photo_price, photos.end_auction, photos.winner_email_sent, photos.status)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
		
		
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql)) { 
			$stmt->bind_param('siiiiisss', $_POST['photo_title'], $_POST['photographer_name'], $_POST['style_name'], $_POST['type_name'], $new_photo_id, $_POST['photo_price'], $endDateTime, $initial_email_value, $status); 
			$inserted = $stmt->execute(); 
			}
			
		
		//redirect if successful or display an error
		if ($inserted) { //if $OK is true(the prepared statement executed correctly)
			header("Location: " . $site_basedir . "admin/admin_crop.php?filename=$filename&height=$orig_h"); //redirect to jcrop page
			//header('Location: ' . $site_basedir . 'admin/admin_list.php'); //then redirect to this page
			exit; //and exit the script
			}
			
		else { //if it doesn't execute correctly
			echo $stmt->error; // then display an error message on the screen
			}
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
        <div class="admin_items">
            <h1>Insert new Photo entry </h1>
                <form id="newphotoform" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td><label for="photo_title">Photo Title:</label></td>
                        <td><input name="photo_title" type="text" class="widebox" id="photo_title_new" value=""/></input></td>
                    </tr>
                    
                    <tr>
                        <td><label for="photographer_name">Photographer's Name:</label></td>
                        <td><select name="photographer_name" id="photographer_name_new">
                            <?php while($row = $photographer_result->fetch_assoc()) { ?> <!--This runs a loop through all the results and puts them into an associative array named $row-->
                                <option value="<?php echo $row['photographer_id']; ?>"><?php echo $row['photographer_name']; ?></option>
                            <?php } ?> <!--closes the loop surrounding the options row-->
                        </select></td>
                    </tr>
                    
 
                    
                     <tr>
                       <td> <label for="style_name">Style:</label></td>
                        <td><select name="style_name" id="style_name_new">
                            <?php while($row = $style_result->fetch_assoc()) { ?> <!--This runs a loop through all the results and puts them into an associative array named $row-->
                                <option value="<?php echo $row['style_id']; ?>"><?php echo $row['style_name']; ?></option>
                            <?php } ?> <!--closes the loop surrounding the options row--> 
                        </select></td>
                    </tr>
                    
                     <tr>
                       <td> <label for="type_name">Type:</label></td>
                        <td><select name="type_name" id="type_name_new">
                            <?php while($row = $type_result->fetch_assoc()) { ?> <!--This runs a loop through all the results and puts them into an associative array named $row-->
                                <option value="<?php echo $row['type_id']; ?>"><?php echo $row['type_name']; ?></option>
                            <?php } ?> <!--closes the loop surrounding the options row--> 
                        </select></td>
                    </tr>
                    
                  
                        
                        
                             <tr>
                                <td><label for="image">Image of Photo:</label></td>
                                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" /></input> <!--This line somehow restricts the file size by having it above the input field-->
                                <td><input type="file" name="image" class="widebox" id="image_cat_new"></input></td>
                            </p>
                      
                    
                    <tr>
                       <td style="width: 140px;"> <label for="end_date">Auction End Date:</label></td>
                       <td> <input name="end_date" id="end_date"></input></td>
                    </tr>
                    
                    <tr>
                        <td><label for="end_hour">Auction End Time:</label></td>
                        <td><select name="end_hour" id="end_hour"> <!--FIRST STARTTIME SELECTBOX - to select the end hour-->
							<?php for($t=1; $t < 13; $t++){?>
                                <option value="<?php echo $t; ?>" ><?php echo $t; ?></option>
                            <?php } ?>
                        </select>
                        
                        :
                        
                        <select name="end_min" id="end_min"> <!--SECOND STARTTIME SELECTBOX  - to select the end minutes-->
                            <?php for($t=00; $t < 59; $t=$t+5){?>
                                <option value="<?php echo leadingZeros($t,2); ?>" ><?php echo leadingZeros($t,2); ?></option>
                            <?php } ?>
                        </select>
                        
                        <select name="end_am_pm" id="end_am_pm"> <!--THIRD STARTTIME SELECTBOX  - to select am or pm-->
                            <option value="am" >am</option>
                            <option value="pm" >pm</option>
                        </select></td>
                    </tr>
                    
                     <tr>
                        <td><label for="photo_price">Photo Price:</label></td>
                        <td><input type="text" name="photo_price" id="photo_price_new"></input></td>
                    </tr>
                    
                    <tr>
                        <td><label for="status">Activate Auction?</label></td>
                        <td><input type="checkbox" name="status" id="status" value="yes">Yes</input></td>
                    </tr>
                    
                    
                    
                    <tr>
                    	<td></td>
                       <td> <input class="add_photo_btn" type="submit" name="insert" value="Insert new Photo entry" /></td>
                    </tr>
                </table>
        		</form> 
        </div> <!--end highest items div-->
    </div> <!--end main content div-->
</div> <!--end container div-->


<?php mysqli_close($conn); ?>
</body>
</html>