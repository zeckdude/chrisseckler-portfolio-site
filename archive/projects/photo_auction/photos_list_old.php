<?php 
session_start();



error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	include("includes/connection.php");
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('query');
	
	//1st Line - Selects all the table columns we are going to access
	//2nd Line - From the the photos table
	//3rd Line - This line connects the foreign key from the photos table with the primary key on the photographers table
	//4th Line - This line connects the foreign key from the photos table with the primary key on the styles table
	//5th Line - Orders the results by the Photographer name in ascending order
	
	if(!isset($_POST['sort']) && !isset($_POST['filter'])){
		$sql = "SELECT photos.photo_id, photos.photo_title, photos.photo_price, photos.photographer_id, photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, types.type_id, types.type_name, photos.image_id, images.image_id, images.image_filename
			FROM photos 
			LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
			LEFT JOIN styles ON photos.style_id = styles.style_id
			LEFT JOIN types ON photos.type_id = types.type_id
			LEFT JOIN images ON photos.image_id = images.image_id
			ORDER BY photos.photo_price DESC";
	} else if(isset($_POST['sort']) && !isset($_POST['filter'])) {
		$_SESSION['sortby'] = $_POST['sortby'];
		$_SESSION['direction'] = $_POST['direction'];
		$sql = "SELECT photos.photo_id, photos.photo_title, photos.photo_price, photos.photographer_id, photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, types.type_id, types.type_name, photos.image_id, images.image_id, images.image_filename
			FROM photos 
			LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
			LEFT JOIN styles ON photos.style_id = styles.style_id
			LEFT JOIN types ON photos.type_id = types.type_id
			LEFT JOIN images ON photos.image_id = images.image_id
			ORDER BY " .$_SESSION['sortby'] . ' ' . $_SESSION['direction'];

	} else if(!isset($_POST['sort']) or isset($_POST['filter'])) {
		$_SESSION['category'] = $_POST['category'];
		$_SESSION['filterby'] = $_POST['filterby'];
		$sql = "SELECT photos.photo_id, photos.photo_title, photos.photo_price, photos.photographer_id, photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, types.type_id, types.type_name, photos.image_id, images.image_id, images.image_filename
			FROM photos 
			LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
			LEFT JOIN styles ON photos.style_id = styles.style_id
			LEFT JOIN types ON photos.type_id = types.type_id
			LEFT JOIN images ON photos.image_id = images.image_id
			WHERE " . $_SESSION['category'] . " = '" . $_SESSION['filterby'] . "'
			ORDER BY " .$_SESSION['sortby'] . ' ' . $_SESSION['direction'];

	} else if(isset($_POST['sort']) && isset($_POST['filter'])) {
		$sql = "SELECT photos.photo_id, photos.photo_title, photos.photo_price, photos.photographer_id, photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, types.type_id, types.type_name, photos.image_id, images.image_id, images.image_filename
			FROM photos 
			LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
			LEFT JOIN styles ON photos.style_id = styles.style_id
			LEFT JOIN types ON photos.type_id = types.type_id
			LEFT JOIN images ON photos.image_id = images.image_id
			WHERE " . $_POST['category'] . " = '" . $_POST['filterby'] . "'
			ORDER BY " .$_POST['sortby'] . ' ' . $_POST['direction'];
	}
	
	//This is sending the request to the database and saving the results in $result
	$result = $conn->query($sql) or die(mysqli_error());
	
	
	
	
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_name; ?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />




<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $("#selectionresult").hide();

    $("#selection").change( function() {
        $("#selectionresult").hide();
        $("#result").html('Retrieving ...');
        $.ajax({
            type: "POST",
            data: "data=" + $(this).val(),
            url: "response.php",
            success: function(msg){
                if (msg != ''){
                    $("#selectionresult").html(msg).show();
                    $("#result").html('');
                }
                else{
                    $("#result").html('<em>No item result</em>');
                }
            }
        });
    });
});
</script>



</head>

<body>
<div id="container">
    <?php include("includes/header.php");
	echo 'The sortby session is: ' . $_SESSION['sortby'];
	echo '<br />';
	echo 'The direction session is: ' . $_SESSION['direction'];
	echo '<br />';
	echo 'The category session is: ' . $_SESSION['category'];
	echo '<br />';
	echo 'The filterby session is: ' . $_SESSION['filterby'];
	
	?>
    
    <div id="sort_filter_box">
        <div id="sort_options">
            <p>Sort by:</p>
            <form id="sort_form" name="sort_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <select name="sortby">
                    <option <?php if($_POST['sortby'] == 'photo_price') { echo 'selected';}?> value="photo_price">Current Price</option>
                    <option <?php if($_POST['sortby'] == 'photographer_lastname') { echo 'selected';}?> value="photographer_lastname">Photographer Last Name</option>
                    <option <?php if($_POST['sortby'] == 'photo_title') { echo 'selected';}?> value="photo_title">Photo Name</option>
                    <option <?php if($_POST['sortby'] == 'type_name') { echo 'selected';}?> value="type_name">Type of Photo</option>
                    <option <?php if($_POST['sortby'] == 'style_name') { echo 'selected';}?> value="style_name">Style of Photo</option>
                </select>
            
                <select name="direction">
                    <option <?php if($_POST['direction'] == 'ASC') { echo 'selected';}?> value="ASC">Ascending</option>
                    <option <?php if($_POST['direction'] == 'DESC') { echo 'selected';}?> value="DESC">Descending</option>
                </select>
                
                <input type="submit" name="sort" value="Sort" />
            </form>
        </div> <!--end sort options div-->
        
        <div id="filter_options">
        	<p>
                Only show 
            </p>
            <p>
            	<form id="sort_form" name="sort_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <select name="category" id="selection">
                    <option value="">
                        - Select Item Here -
                    </option>
                    <option value="photographers.photographer_name">
                        Photographer
                    </option>
                    <option value="style_name">
                        Photo Style
                    </option>
                    <option value="type_name">
                        Photo Type
                    </option>
                </select>
            </p>
            
            <p>
                <select id="selectionresult" name="filterby"></select>
                <input type="submit" name="filter" value="Filter" />
                </form>
            </p>
            <p id="result">&nbsp;</p>
        </div> <!--end filter options div-->
        
	</div> <!--end sort filter box div-->
    
    
    <div id="main_content">
        <div id="highest_items">
            <h2>Highest Auction Items</h2>
            <?php while($row = $result->fetch_assoc()) { ?>
                <div class="four_column_box">
                    <p><?php echo $row['photo_title']; ?></p>
                    <div id="box"><center><img src="images/thumbs/<?php echo $row['image_filename']; ?>" alt="<?php echo $row['photo_title']; ?>"/></center></div>
                    <p class="photographer_name"><?php echo $row['photographer_firstname']; ?> <?php echo $row['photographer_lastname']; ?></p>
                    <p><?php echo $row['style_name']; ?></p>
                    <p><?php echo $row['type_name']; ?></p>
                    <p>Current Price: $<?php echo $row['photo_price']; ?>.00</p>
                    <a href="photo_details.php?photo_id=<?php echo $row['photo_id']; ?>">Bid on this Photo</a>
                </div> <!--end four column div-->
            <?php } ?>
        </div> <!--end highest items div-->
    </div> <!--end main content div-->
</div> <!--end container div-->


<?php mysqli_close($conn); ?>
</body>
</html>