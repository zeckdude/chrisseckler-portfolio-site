<?php
ob_start();
session_start();

 

	include("includes/connection.php"); 

	//initialize flag
	$selected = false; //boolean variable to be used later which checks the success of retrieving the record
	$done = false; //boolean variable to be used later which checks whether the update succeeds
	
	
	//create a database connection which comes from 'conn.inc.php'
	$conn = dbConnect('admin');
		
	//get details of selected record
	  
		
		//The code inside the braces is executed only when the query string is set, but the form hasn’t been submitted.
		//prepare SQL Query
		$sql = 'SELECT photos.photo_id, photos.photo_title, photos.photographer_id, photographers.photographer_id, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, photos.type_id, types.type_id, types.type_name, photos.photo_price, photos.image_id, images.image_id, images.image_filename, photos.highest_bidder, users.user_id, photos.end_auction, photographers.photographer_sitelink
				FROM photos
				LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
				LEFT JOIN styles ON photos.style_id = styles.style_id
				LEFT JOIN types ON photos.type_id = types.type_id
				LEFT JOIN images ON photos.image_id = images.image_id
				LEFT JOIN users ON photos.highest_bidder = users.user_id
				WHERE photos.photo_id = ?';
				
		//initialize prepared statement which will guarantee the code against SQL injection(MySQLI specific way of security)
		$stmt = $conn->stmt_init(); // 1. initialize the prepared statement, apply the stmt_init() method to the database connection ($conn), and store it in a variable $stmt
		if ($stmt->prepare($sql)) { // 2. pass the SQL query to $stmt->prepare(). This checks that you haven’t used question mark placeholders in the wrong place, and that when everything is put together, the query is valid SQL.
			//bind the query parameters
			$stmt->bind_param('i', $_GET['photo_id']); // 3. replaces the question mark in the query with the actual value held in the variable. You pass the variable to $stmt->bind_param(), together with a first argument specifying the data type of the variable (i for one integer).
			
			//bind the results to the variables
			$stmt->bind_result($photo_id, $photo_title, $photographer_id, $photographer_id2, $photographer_firstname, $photographer_lastname, $style_id, $style_id2, $style_name, $type_id, $type_id2, $type_name, $photo_price, $image_id, $image_id2, $image_filename, $highest_bidder, $userid, $end_auction, $sitelink); //binds the result to variables in the same order as the columns specified in the SELECT query
			
			//execute the query, and fetch the result
			$selected = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $OK
			$stmt->fetch(); //fetches the result
		}
		
		include("includes/find_loggedin_userid.php");
		
		function datediff( $date1, $date2 ) {
			$diff = abs( strtotime( $date1 ) - ( $date2 ) );
		
			return sprintf
			(
				"%d Days, %d Hours, %d Mins, %d Seconds",
				intval( $diff / 86400 ),
				intval( ( $diff % 86400 ) / 3600),
				intval( ( $diff / 60 ) % 60 ),
				intval( $diff % 60 )
			);
		}
		
		
		//if form has been submitted, update record
		if (array_key_exists('bidonthis', $_POST)) { //checks that something with the 'update' name attribute is in the $_POST array, which it is once it is clicked. If the user does click on it, the execute the rest of the script
		
			if($photo_price >= $_POST['bid']) { //If the current photo price is greater than or equal to the post bid amount, then echo a message 
				$error =  '<p>You must bid a higher amount than the current price</p>';	
			} else if(($_POST['bid'] - $photo_price) < 50) {
				$error =  '<p>You must bid at least $50.00 more than the current price</p>';
			} else if($_POST['bid'] > 100000) {
				$error =  '<p>You may not bid higher than $100,000. Relax Moneybags! Let the other children play also!</p>';
			}else { //otherwise update the database
				
				
				//prepare update query
				$sql = 'UPDATE photos SET photo_price = ?, highest_bidder = ?
						WHERE photo_id = ?';
						
				//initialize prepared statement which will guarantee the code against SQL injection(MySQLI specific way of security)
				$stmt = $conn->stmt_init(); // 1. initialize the prepared statement, apply the stmt_init() method to the database connection ($conn), and store it in a variable $stmt
				if ($stmt->prepare($sql)) { // 2. pass the SQL query to $stmt->prepare(). This checks that you haven’t used question mark placeholders in the wrong place, and that when everything is put together, the query is valid SQL.
					//bind parameters and execute statement
					$stmt->bind_param('sii', $_POST['bid'], $user_id, $_POST['photo_id'] ); // 3. replaces the question marks with the actual values held in the variables. You pass the variables to $stmt->bind_param() in the same order as you want them inserted into the SQL query, together with a first argument specifying the data type of each variable (ssi for two strings and an integer), again in the same order as the variables.
					$updated = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $done
				}
			}
		}
		
		
		// redirect on success or if $_GET['article_id']) is not defined. This ensures that the page is redirected either if the update succeeds or if someone tries to access the page directly.
		if ($updated || !isset($_GET['photo_id'])) { //if $_GET['article_id'] is not defined
			header('Location: ' . $site_basedir .'photos_list.php'); //then redirect to this page
			exit; //and exit the script	
		}
		
		//display error message if query fails
		if (isset($stmt) && !$selected && !$updated) { //if the prepared statement has been created, but both $OK and $done remain false 
			echo $stmt->error;	// then display an error message on the screen
		}
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_name; ?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

<script type="text/javascript">
/*$(document).ready(function(){
	$('form').submit(function () { // optional: replace "form" with whatever CSS selector you want (ex: ID or class)
		$('input:submit',this).attr('disabled','disabled');
 // optional: change "Sending..." to something else
	});					   
});*/
</script>


</head>

<body>
<div id="container">
    <?php include("includes/header.php"); ?>
    
    <div id="main_content">
        <div id="photo_pic_box">
            <img style="border: 1px solid #696868;" src="images/<?php echo $image_filename; ?>" alt="<?php echo $photo_title; ?>"/>
        </div> <!--end photo pic box div-->
        
        <div id="photo_details_box">
            	<p id="photo_details_title"><?php echo $photo_title ?></p>
            	<p id="photographer_details_name">
					<?php if(empty($sitelink)) { 
						echo $photographer_firstname . ' ' . $photographer_lastname; 
					} else { ?><a target="_blank" href="http://<?php echo $sitelink; ?>"><?php echo $photographer_firstname . ' ' . $photographer_lastname ?></a><?php } ?>
                </p>
                <p class="details_info">Style: <span><?php echo $style_name; ?></span></p>
                <p class="details_info">Type: <span><?php echo $type_name; ?></span></p>
                
                
                <p class="details_info" id="details_price">Current Price: <span>$<?php echo $photo_price ?>.00</span></p>
            <span> 
                <p id="time_left_details" class="details_bottom_info">	
                    <?php 
                    
                        $now = time(); 
                        $date = date('Y-m-d H:i:s');
                        
                        //echo 'date: ' . $date;
                        
                        if($now <= strtotime($end_auction)) { //if the current date is before the end date and the auction is still going
                            echo 'Time left in auction: ';
							echo '<span>';
                            print datediff( $end_auction, $now ) . "\n";
							echo '</span>';
                        } else { //if the current date is after the end date and the auction is over
							echo '<span>';
                            echo 'This item auction has been finished.';
							echo '</span>';
                        }
					?>
				</p>
                <p id="bid_area">
                   <?php if(isset($_SESSION['authenticated_pa'])){ //checks if someone is logged in
                            if($highest_bidder == $user_id) { //checks to see if the current user is the highest bidder for this item
                                echo 'You are currently the highest bidder for this photo and can not bid on it again until you are outbid.';
                            } else { //else if the current user is not the highest bidder 
                        
                                if($now <= strtotime($end_auction)) { //if the auction is still going
                    ?>				<p id="bid_instructions">Bidding Instructions:
                    				<span>You must bid at least $50 more than the current photo price.</span></p>
                                    <form id="bid_form" name="form1" method="post" action=""> 
                                        <input name="bid" type="text" id="bid" value=""/>
                                        <input class="bid_btn" type="submit" name="bidonthis" value="Bid on this Photo" />
                                        <input name="photo_id" type="hidden" value="<?php echo $photo_id ?>"/>
                                    </form>
                    <?php 		} //end if the current date is before the end date
                            } //end else
                        } else { //end if authenticated
                            echo '<br />Please Login to bid on this photo.';
                        }
                    ?>
            	</p> 
            </span>
            
            <?php if(isset($error)) { 
            	echo '<p id="error_message">' . $error . '</p>';
			}?>
        </div> <!--end photo details box div-->
        
    </div> <!--end main content div-->
</div> <!--end container div-->


<?php mysqli_close($conn); ?>
</body>
</html>