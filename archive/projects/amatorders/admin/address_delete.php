<?php
session_start();
ob_start();

date_default_timezone_set('America/Los_Angeles');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Applied Materials Order Center - Admin Options</title>
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" charset="utf-8" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../images/favicon.gif" />
</head>

<script src="../js/jquery-1.4.2.min.js" type="text/javascript"></script>





<body>


<div id="container">


<?php 





include("../includes/connection.php");
include("../includes/admin_header.php");
$conn = dbConnect('admin');


if(!isset($_SESSION['authenticated_oc'])){
	header('Location: ' . $site_basedir . 'login.php');
}

if(!isset($_GET['building_id'])){
	header('Location: ' . $site_basedir . 'admin/tracker.php');
}

$sql = 'SELECT *
		FROM buildings
		WHERE building_id = ' . $_GET['building_id'];

$result = $conn->query($sql) or die(mysqli_error());
$row = mysqli_fetch_assoc($result);











if(isset($_POST['delete_accept'])) {

	$_SESSION['address'] = $row['address'];

		
		$sql = 'DELETE FROM buildings
				WHERE building_id =' . $_GET['building_id'];
		
		$result = $conn->query($sql) or die(mysqli_error($conn));

		header('Location: ' . $site_basedir . 'admin/address_delete.php?building_id=' . $_GET['building_id'] . '&address_deleted=1');
		exit;
	
}

if(isset($_POST['delete_cancel'])) {
	header('Location: ' . $site_basedir . 'admin/options.php');
	exit;
}




if(isset($_GET['address_deleted'])) {	
?>
	<div class="form_container" id="thank_you_box">  
        <div class="row">
            <div class="clientform_table_header">The address was deleted</div>   
        </div>
        
        <div class="row">
            <div class="content">
                <p>The address for <?php echo $_SESSION['address']; ?> was deleted . You will be redirected in 3 seconds.</p>
                <?php
					header( 'refresh: 3; url=' . $site_basedir . '/admin/options.php' );
				?>
			</div>
          </div>       
    </div>


<?php } else { ?>

    <div class="form_container" id="address_box" style="width: 556px; margin: 0 auto;">  
        <div class="row">
            <div class="clientform_table_header">Are you sure you want to delete this address?</div>   
        </div>
        
        <?php
			if($row['zip_2'] != '') {
				$zip_code = $row['zip_1'] . ' - ' . $row['zip_2'];
			} else {
				$zip_code = $row['zip_1'];
			}
		?>
        
        <div class="row">
            <div class="content">
				
                <table id="address_table" style="width: 524px;">
                	<tr>
                    	<th>Bldg. #</th>
                        <th>Address</th>
                        <th>PO Box</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip Code</th>
                	</tr>
                    
                    <tr>
                        <td><?php echo $row['building_num']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['po_box']; ?></td>
                        <td><?php echo $row['city']; ?></td>
                        <td><?php echo $row['state']; ?></td> 
                        <td><?php echo $zip_code; ?></td> 
                    </tr>
                </table>
			</div>
		</div>
        
        <div class="row">
            <div class="content" style="width: 94%;"> 
            	<form id="clientForm" name="clientForm" method="post" action="">
                	<input class="button prev submit" type="submit" name="delete_cancel" value="Go back without deleting" />
                    <input class="button next submit" type="submit" name="delete_accept" value="Delete Address" />
                </form>
            </div>
		</div>
        
    </div> 
     
<?php }   


	?>    
          
		 
</div>

</body>

</html>