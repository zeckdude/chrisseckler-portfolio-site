<?php 
session_start();



error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	include("includes/connection.php");
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('query');
	
	include("includes/sort_sql.php");
	
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




<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    //$("#selectionresult").hide();
	selector('#selection');
	
    $("#selection").change( function() {
        //$("#selectionresult").hide();
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

function selector(dropdown) {
	$("#result").html('Retrieving ...');
	$.ajax({
			type: "POST",
			data: "data=" + $(dropdown).val(),
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
}


</script>



<link rel="shortcut icon" href="../images/favicon.ico" />
</head>

<body>
<div id="container">
    <?php include('includes/header.php'); ?>
    
    <div id="sort_filter_box">
        <div id="sort_options">
            <p id="photo_title">Sort by:</p>
            <form id="sort_form" name="sort_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <select id="sortby" name="sortby">
                    <option <?php if($_POST['sortby'] == 'end_auction') { echo 'selected';}?> value="end_auction">Auction End Date/Time</option>
                    <option <?php if($_POST['sortby'] == 'photo_price') { echo 'selected';}?> value="photo_price">Current Price</option>
                    <option <?php if($_POST['sortby'] == 'photographer_lastname') { echo 'selected';}?> value="photographer_lastname">Photographer Last Name</option>
                    <option <?php if($_POST['sortby'] == 'photo_title') { echo 'selected';}?> value="photo_title">Photo Name</option>
                    <option <?php if($_POST['sortby'] == 'type_name') { echo 'selected';}?> value="type_name">Type of Photo</option>
                    <option <?php if($_POST['sortby'] == 'style_name') { echo 'selected';}?> value="style_name">Style of Photo</option>
                </select>
            	<br />
                <select id="direction" name="direction">
                	<option <?php if($_POST['direction'] == 'DESC') { echo 'selected';}?> value="DESC">Descending</option>
                    <option <?php if($_POST['direction'] == 'ASC') { echo 'selected';}?> value="ASC">Ascending</option>
                </select>
		</div> <!--end sort options div-->
        <div id="filter_options">      
                <p id="photo_title">Filter by:</p>
                <select name="category" id="selection">
                    <option value="">
                        - Select Item Here -
                    </option>
                    <option <?php if($_POST['category'] == 'photographers.photographer_name') { echo 'selected';}?> value="photographers.photographer_name">
                        Photographer
                    </option>
                    <option <?php if($_POST['category'] == 'style_name') { echo 'selected';}?> value="style_name">
                        Photo Style
                    </option>
                    <option <?php if($_POST['category'] == 'type_name') { echo 'selected';}?> value="type_name">
                        Photo Type
                    </option>
                </select>
                <br />
                <select id="selectionresult" name="filterby"></select>

                
            <!--<p id="result">&nbsp;</p>-->
        </div> <!--end filter options div-->
        <input id="sort" type="submit" name="sort" value="Sort / Filter results" />
        </form>
	</div> <!--end sort filter box div-->
    
    
    <div id="main_content">
        <div id="highest_items">

            <!--This while loop shows all the entries but not the finished ones -->
            <?php 
			while($row = $result->fetch_assoc()) {	
				if(($row['status'] == 'active') || ($row['status'] == 'finished')) { ?>
                	<span class="four_column_box" style="min-height: 350px;">
                        <p id="photo_title"><?php echo $row['photo_title']; ?></p>
                        <div id="box"><a href="photo_details.php?photo_id=<?php echo $row['photo_id']; ?>"><img style="width: 90%;" src="images/thumbs/<?php echo $row['image_filename']; ?>" alt="<?php echo $row['photo_title']; ?>"/></a></div>
                        <p class="photographer_name">
                            <?php if(empty($row['photographer_sitelink'])) { 
                                echo $row['photographer_firstname'] . ' ' . $row['photographer_lastname']; 
                            } else { ?><a target="_blank" href="http://<?php echo $row['photographer_sitelink']; ?>"><?php echo $row['photographer_firstname'] . ' ' . $row['photographer_lastname'] ?></a>
                            <?php } ?>
                        </p>
                        <p class="style">Style: <span><?php echo $row['style_name']; ?></span></p>
                        <p class="type">Type: <span><?php echo $row['type_name']; ?></span></p>
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
                <?php } //end if status is active or finished ?>
            <?php } //end while ?>
            
            
            <!--This while loop shows all the finished entries if the post sortby is end_auction-->
            <?php 
			if( ($_POST['sortby'] == 'end_auction') || (!isset($_POST['sort'])) ) {
				while($row = $finished_result->fetch_assoc()) {	
					if(($row['status'] == 'active') || ($row['status'] == 'finished')) { ?>
						<span class="four_column_box" style="min-height: 350px;">
                            <p id="photo_title"><?php echo $row['photo_title']; ?></p>
                            <div id="box"><a href="photo_details.php?photo_id=<?php echo $row['photo_id']; ?>"><img style="width: 90%;" src="images/thumbs/<?php echo $row['image_filename']; ?>" alt="<?php echo $row['photo_title']; ?>"/></a></div>
                            <p class="photographer_name">
                                <?php if(empty($row['photographer_sitelink'])) { 
                                    echo $row['photographer_firstname'] . ' ' . $row['photographer_lastname']; 
                                } else { ?><a target="_blank" href="http://<?php echo $row['photographer_sitelink']; ?>"><?php echo $row['photographer_firstname'] . ' ' . $row['photographer_lastname'] ?></a>
                                <?php } ?>
                            </p>
                            <p class="style">Style: <span><?php echo $row['style_name']; ?></span></p>
                        	<p class="type">Type: <span><?php echo $row['type_name']; ?></span></p>
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
                        
                        
                        
                        
                        
                        
                        
                        
					<?php } //end if status is active or finished ?>
				<?php } //end while ?>
            <?php } //end if sortby is end_auction ?>	
        </div> <!--end highest items div-->
    </div> <!--end main content div-->
</div> <!--end container div-->


<?php mysqli_close($conn); ?>
</body>
</html>