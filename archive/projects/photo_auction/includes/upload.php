<?php

define('MAX_FILE_SIZE', 307200); //define name and value of constant for maximum file size



	define('UPLOAD_DIR', '../images/'); //define name and value of constant for upload folder's location
	define('THUMB_DIR', '../images/thumbs/'); //define name and value of constant for upload folder's location
	$file = str_replace(' ', '_', $_FILES['image_cat_add']['name']); //change all spaces to underscores within a file name and save the result in $file
	
	//converts the maximum size to kilobytes and saves the new value in $max
	$kilobytes = MAX_FILE_SIZE/1024; //converts to kilobytes
	$formatted = number_format($kilobytes, 1); //adds one comma for the thousands spot and saves it in $formatted
	$max = $formatted.'KB';
	
	//create an array of permitted MIME types
	$permitted = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');
	
	$typeOK = false; //sets a boolean flag for the file type
	$sizeOK = false; //sets a boolean flag for the file size
	
	//check that file is within the permitted size
	if ($_FILES['image_cat_add']['size'] > 0 && $_FILES['image_cat_add']['size'] <= MAX_FILE_SIZE) { //If the file is greater than 0 but less than or equal to the maximum file size
		$sizeOK = true;	//then set the flag to true which indicates the file is small enough to be uploaded
	}
	
	//check that the file is a permitted MIME type
	foreach ($permitted as $type) { //loops through the FILES array 
		if($type == $_FILES['image_cat_add']['type']) { //checks to see if the uploaded file matches any of the permitted MIME types
			$typeOK = true; //If it does, then set this to true
			break; //breaks out of the loop
		}
	}
	
	
	
	
	
	if ($sizeOK && $typeOK) {
		switch($_FILES['image_cat_add']['error']) {
			case 0: //error level 0 indicates that the file was uploaded succesfully
				
				$conn = dbConnect('admin');
				 
						$sql = 'INSERT INTO images (images.image_filename)
								VALUES(?)';
				
						$stmt = $conn->stmt_init(); 
						if ($stmt->prepare($sql)) { 
							$stmt->bind_param('s', $file); 
							$image_inserted = $stmt->execute(); 
						}
					
				
				//makes sure file name doesn't already exist
				if (!file_exists(UPLOAD_DIR.$file)) { //if this file name doesn't already exist, then let it keep its name
					//move the file to the upload folder and rename it
					$success = move_uploaded_file($_FILES['image_cat_add']['tmp_name'], UPLOAD_DIR.$file);
					$source='../images/' . $file ;
					$destination='../images/thumbs/' . $file ;
					
					copy($source, $destination);//move the file to the upload folder and rename it. The first argument is where the file is currently located. The second argument is where to move it to and what to rename it. The outcome of the operation is saved in $success as a boolean. This also adds a unix timestamp at te beginning of the file name.
					
				} else { //if this file does already exist then attach the unix timestamp to the front of it
					//get the date and time
					ini_set('date.timezone', 'Europe/London');
					$now = date('Y-m-d-His');
					$success = move_uploaded_file($_FILES['image_cat_add']['tmp_name'], UPLOAD_DIR.$now.$file);	
					
					$source='../images/' . $file ;
					$destination='../images/thumbs/' . $file ;
					
					copy($source, $destination);
				}
				
				
				
				if ($success) { //if $success returns as true
					$result = "$file uploaded successfully";	//then show this message
				} else {
					$result = "Error uploading $file. Please try again.";	//otherwise if the file did not upload successfully, show this message
				}
				break;
			case 3: //error level 3 indicates that the upload was incomplete
				$result = "Error uploading $file. Please try again.";
			default:
				$result = "System Error uploading $file, Contact Webmaster.";
		}
	} elseif ($_FILES['image_cat_add']['error'] == 4) { //this is for error message 4
			$result = 'No file selected';
	} else {
		$result = "$file cannot be uploaded. Maximum size: $max. Acceptable file types: gif, jpg, png.";	//this is if the file is too big
	}
	
	
	$new_photo_id = mysqli_insert_id($conn);
	






?>