<?php 
session_start();



error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	include("../includes/connection.php");
	
	if(!isset($_SESSION['authenticated_pa_admin'])){
	header('Location: ' . $site_basedir . 'admin/admin_login.php');
}
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('admin');
	
	
	// initialize flags
	$OK = false;
	$deleted = false;
	
	// get details of selected record
	if (isset($_GET['photo_id']) && !$_POST) {
	  // prepare SQL query
	  $sql = 'SELECT photos.photo_id, photos.photo_title, photos.photographer_id, photographers.photographer_id, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, photos.type_id, types.type_id, types.type_name, photos.photo_price, photos.image_id, images.image_id, images.image_filename, photos.highest_bidder, users.user_id, photos.end_auction, photos.status, users.username
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
				$stmt->bind_result($photo_id, $photo_title, $photographer_id, $photographer_id2, $photographer_firstname, $photographer_lastname, $style_id, $style_id2, $style_name, $type_id, $type_id2, $type_name, $photo_price, $image_id, $image_id2, $image_filename, $highest_bidder, $userid, $end_auction, $status, $username); //binds the result to variables in the same order as the columns specified in the SELECT query
				
				//execute the query, and fetch the result
				$OK = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $OK
				$stmt->fetch(); //fetches the result
			}
	  } //end isset($_GET['photo_id']) && !$_POST
	  
	// if confirm deletion button has been clicked, delete record
	if (array_key_exists('delete', $_POST)) {
	  $sql = 'DELETE FROM photos WHERE photo_id = ?';
	  $stmt = $conn->stmt_init();
	  if ($stmt->prepare($sql)) {
		$stmt->bind_param('i', $_POST['photo_id']);
		$deleted = $stmt->execute();
		}
	  }
	  
	// redirect the page if deletion is successful, cancel button clicked, or $_GET['article_id'] not defined
	if ($deleted || array_key_exists('cancel_delete', $_POST) || !isset($_GET['photo_id']))  {
	  header('Location: ' . $site_basedir . 'admin/admin_list.php');
	  exit;
	  }
	// if any SQL query fails, display error message
	if (isset($stmt) && !$OK && !$deleted) {
	  echo $stmt->error;
	  }

$now = time();
	
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
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<link rel="shortcut icon" href="../../images/favicon.ico" />
</head>

<body>
<div id="container">
    <?php include('../includes/adminheader.php'); ?>

    <div id="main_content">
        <div id="highest_items">
            <h2 style="margin-left: 0px;">Delete Photo Entry?</h2>
			<?php if($photo_id == 0) { ?>
            <p class="warning">Invalid request: record does not exist.</p>
            <?php } else { ?>
            <p class="warning">Please confirm that you want to delete the following entry. This action cannot be undone.</p>

            <?php if($status == 'active') {
				echo '<p class="warning"><b>Caution:</b> this is an active auction item. Deleting this item will cancel that auction</p>';
			} ?>

            <table class="center">
                <tr>
                    <th>Photographer</th>
                    <th>Photo Name</th>
                    <th>Type of Photo</th>
                    <th>Style of Photo</th>
                    <th>Current Price</th>
                    <th>Highest Bidder</th>
                    <th>Photo Thumbnail</th>
                    <th>Time Left</th>
                </tr>
                <tr><td colspan="10" style="padding-bottom: 20px;"><hr /></td> </tr>
                <tr class="list_body">
                    <td><?php echo $photographer_firstname . ' ' . $photographer_lastname; ?></td>
                    <td><?php echo $photo_title; ?></td>
                    <td><?php echo $type_name; ?></td>
                    <td><?php echo $style_name; ?></td>
                    <td>$<?php echo $photo_price; ?>.00</td>
                    <td><?php echo $username; ?></td>
                    <td>
                        <div id="list_image">
                            <p><img src="../images/mini_thumbs/<?php echo $image_filename; ?>" alt="<?php echo $photo_title;  ?>"/></a></p>
                            <p><?php echo $photo_title; ?></p>
                        </div>
                    </td>
                    <td>
                        <?php 
                            if($status == 'finished') { echo 'Finished'; }
                            else if($status == 'not active') { echo 'Not Active'; }
                            else { print datediff( $end_auction, $now ) . "\n"; } 
                        ?>
                    </td>                    
                </tr>
            </table>

            <?php } ?>
            <form id="form1" name="form1" method="post" action="">
                <p>
                <?php if($photo_id > 0) { ?>
                    <input type="submit" name="delete" value="Confirm deletion" />
                <?php } ?>
                    <input name="cancel_delete" type="submit" id="cancel_delete" value="Cancel" />
                <?php if($photo_id > 0) { ?>
                    <input name="photo_id" type="hidden" value="<?php echo $photo_id; ?>" />
                <?php } ?>
                </p>
            </form> 
        </div> <!--end highest items div-->
    </div> <!--end main content div-->
</div> <!--end container div-->


<?php mysqli_close($conn); ?>
</body>
</html>