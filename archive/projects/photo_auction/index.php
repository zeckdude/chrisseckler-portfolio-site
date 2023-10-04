<?php 
session_start();



error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	include("includes/connection.php");
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('query');
	
	$sql = "SELECT photos.photo_id, photos.photo_title, photos.photo_price, photos.photographer_id, photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, types.type_id, types.type_name, photos.image_id, images.image_id, images.image_filename, photos.highest_bidder, users.user_id, photos.end_auction, photos.status, users.username, photographers.photographer_sitelink
			FROM photos 
			LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
			LEFT JOIN styles ON photos.style_id = styles.style_id
			LEFT JOIN types ON photos.type_id = types.type_id
			LEFT JOIN images ON photos.image_id = images.image_id
			LEFT JOIN users ON photos.highest_bidder = users.user_id
			WHERE photos.status = 'active'
			ORDER BY photos.end_auction DESC
			LIMIT 8";
			
	$result = $conn->query($sql) or die(mysqli_error());
	
	include("includes/find_loggedin_userid.php");
	
	function datediff( $date1, $date2 ) {
		$diff = abs( strtotime( $date1 ) - ( $date2 ) );
	
		return sprintf
		(
			"%dd, %dh, %dm, %ds",
			intval( $diff / 86400 ),
			intval( ( $diff % 86400 ) / 3600),
			intval( ( $diff / 60 ) % 60 ),
			intval( $diff % 60 )
		);
	}
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_name; ?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="../images/favicon.ico" />

</head>

<body>
<div id="container">
    <?php include('includes/header.php'); ?>
    

    <div id="main_content">
        <div id="highest_items">
            <h2>Auction items ending soonest</h2>
            
            
            
            
            <!--This while loop shows all the entries but not the finished ones -->
            <?php 
			while($row = $result->fetch_assoc()) {	
				if($row['status'] == 'active') { ?>
                	<span class="four_column_box">
                        <p id="photo_title"><?php echo $row['photo_title']; ?></p>
                        <div id="box"><a href="photo_details.php?photo_id=<?php echo $row['photo_id']; ?>"><img style="width: 90%;" src="images/thumbs/<?php echo $row['image_filename']; ?>" alt="<?php echo $row['photo_title']; ?>"/></a></div>
                        <p class="photographer_name">
                            <?php if(empty($row['photographer_sitelink'])) { 
                                echo $row['photographer_firstname'] . ' ' . $row['photographer_lastname']; 
                            } else { ?><a target="_blank" href="http://<?php echo $row['photographer_sitelink']; ?>"><?php echo $row['photographer_firstname'] . ' ' . $row['photographer_lastname'] ?></a>
                            <?php } ?>
                        </p>
                        
                        <p class="price">Current Price:<span> $<?php echo $row['photo_price']; ?>.00</span></p>
                        <p class="time_left">
							<?php
                                $now = time();
                                if($now <= strtotime($row['end_auction'])) { //if the current date is before the end date
                                    echo 'Time left: <span>';
                                    print datediff( $row['end_auction'], $now ) . "\n"; 
							?>
                         </span></p>
                         <p class="bid">               
									<?php if(isset($_SESSION['authenticated_pa'])){ 
                                            if($row['highest_bidder'] == $user_id) {
                                                echo 'You are the highest bidder for this photo';	
                                            } else { ?>
                                   
                                                <a class="bid_btn" style="display: block" href="photo_details.php?photo_id=<?php echo $row['photo_id']; ?>">Bid on this Photo</a>
                                      <?php } //end else
                                        } //end if session	
                                } else { //if the current date is after the end date
                                    echo 'This auction has ended.';
                                }
                            
                            ?>
                    	</p>
            		</span>
                <?php } //end if status is active ?>
            <?php } //end while ?>	
        </div> <!--end highest items div-->
    </div> <!--end main content div-->
</div> <!--end container div-->


<?php mysqli_close($conn); ?>
</body>
</html>