<?php 
session_start();



error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	include("../includes/connection.php");
	
if(!isset($_SESSION['authenticated_pa_admin'])){
	header('Location: ' . $site_basedir . 'admin/admin_login.php');
}
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('query');
	
	include("../includes/sort_sql.php");
	
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




<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>

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
            url: "../response.php",
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



<link rel="shortcut icon" href="../../images/favicon.ico" />
</head>

<body>
<div id="container">
    <?php include('../includes/adminheader.php'); ?>
    
    <div style="position: relative; left: 25px;" id="sort_filter_box">
        <div id="sort_options">
            <p>Sort by:</p>
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
                    <option <?php if($_POST['direction'] == 'ASC') { echo 'selected';}?> value="ASC">Ascending</option>
                    <option <?php if($_POST['direction'] == 'DESC') { echo 'selected';}?> value="DESC">Descending</option>
                </select>
		</div> <!--end sort options div-->
        <div id="filter_options">      
                <p>Filter by:</p>
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
            <table class="center">
            <tr id="list_header">
                <th>Photographer</th>
                <th>Photo Name</th>
                <th>Type of Photo</th>
                <th>Style of Photo</th>
                <th>Current Price</th>
                <th>Highest Bidder</th>
                <th style="width: 120px;">Photo Thumbnail</th>
                <th>Time Left</th>
                <th>Delete</th>
            	<th>Edit</th>
            </tr>
			<tr><td colspan="10" style="padding-bottom: 20px;"><hr /></td> </tr>
			
			<!--This while loop shows all the entries but not the finished ones -->
			<?php while($row = $result->fetch_assoc()) {  ?>
                <tr class="list_body">
                    <td><?php echo $row['photographer_name']; ?></td>
                    <td><?php echo $row['photo_title']; ?></td>
                    <td><?php echo $row['type_name']; ?></td>
                    <td><?php echo $row['style_name']; ?></td>
                    <td>$<?php echo $row['photo_price']; ?>.00</td>
                    <td><?php echo $row['username']; ?></td>
                    <td>
                        <div id="list_image">
                            <p><a href="../photo_details.php?photo_id=<?php echo $row['photo_id']; ?>"><img src="../images/mini_thumbs/<?php echo $row['image_filename']; ?>" alt="<?php echo $row['photo_title'];  ?>"/></a></p>
                            <p><?php echo $row['photo_title']; ?></p>
                        </div>
                    </td>
                    <td><?php 
                            if($row['status'] == 'finished') { echo 'Finished'; }
                            else if($row['status'] == 'not active') { echo 'Not Active'; }
                            else { print datediff( $row['end_auction'], $now ) . "\n"; } ?></td>
                    <td><center><a class="delete_btn" href="admin_photo_delete.php?photo_id=<?php echo $row['photo_id']; ?>">Delete</a></center></td>
                    <td><center><a class="edit_btn" href="admin_photo_edit.php?photo_id=<?php echo $row['photo_id']; ?>">Edit</a></center></td>
                </tr>
                <tr><td colspan="10" style="padding: 10px 0px;"><hr /></td> </tr>
            <?php } //end while ?>
            
            <!--This while loop shows all the finished entries if the post sortby is end_auction-->
            <?php if( ($_POST['sortby'] == 'end_auction') || (!isset($_POST['sort'])) ) { ?>
				<?php while($row = $finished_result->fetch_assoc()) {  ?>
                    <tr class="finished list_body">
                        <td><?php echo $row['photographer_name']; ?></td>
                        <td><?php echo $row['photo_title']; ?></td>
                        <td><?php echo $row['type_name']; ?></td>
                        <td><?php echo $row['style_name']; ?></td>
                        <td>$<?php echo $row['photo_price']; ?>.00</td>
                        <td><?php echo $row['username']; ?></td>
                        <td>
                            <div id="list_image">
                                <p><center><a href="../photo_details.php?photo_id=<?php echo $row['photo_id']; ?>"><img src="../images/mini_thumbs/<?php echo $row['image_filename']; ?>" alt="<?php echo $row['photo_title'];  ?>"/></a></center></p>
                                <p><?php echo $row['photo_title']; ?></p>
                            </div>
                        </td>
                        <td>
							<?php 
                                if($row['status'] == 'finished') { echo 'Finished'; }
                                else if($row['status'] == 'not active') { echo 'Not Active'; }
                                else { print datediff( $row['end_auction'], $now ) . "\n"; } 
							?>
                        </td>
                        <td><center><a class="delete_btn" href="admin_photo_delete.php?photo_id=<?php echo $row['photo_id']; ?>">Delete</a></center></td>
                        <td><center><a class="edit_btn" href="admin_photo_edit.php?photo_id=<?php echo $row['photo_id']; ?>">Edit</a></center></td>
                    </tr>
                    <tr><td colspan="10"><hr/></td> </tr>
                <?php } //end while ?>
            <?php } //end if sortby is end_auction ?>
            </table> 
        </div> <!--end highest items div-->
    </div> <!--end main content div-->
</div> <!--end container div-->


<?php mysqli_close($conn); ?>
</body>
</html>