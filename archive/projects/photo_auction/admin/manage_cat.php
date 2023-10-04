<?php 
session_start();



error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	include("../includes/connection.php");
	
	if(!isset($_SESSION['authenticated_pa_admin'])){
	header('Location: ' . $site_basedir . 'admin_login.php');
}
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('query');
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
        	<h2 style="margin-left: 0px;">Manage Categories</h2>
            <div id="photographer_cat" class="category_panel">
				<?php
                $sql = "SELECT *
                        FROM photographers";
                
                $result = $conn->query($sql) or die(mysqli_error());
                ?>
                
                
                <table class="cat_table">
                <tr><td><a class="add_photographer_btn" href="admin_photographer_new.php">+ Add a New Photographer</a></td></tr>
                <tr>
                    <th id="photographer_column">Photographer Name</th>
                    <th id="sitelink_column">URL Link</th>
                    <th style="text-align: center;" class="extra_column">Delete</th>
                    <th style="text-align: center;" class="extra_column">Edit</th>
                </tr>
                <tr><td colspan="10"><hr /></td> </tr>
                <!--This while loop shows all the entries but not the finished ones -->
                <?php while($row = $result->fetch_assoc()) {  ?>
                    <tr>
                        <td><?php echo $row['photographer_name']; ?></td>
                        <td><a href="http://<?php echo $row['photographer_sitelink']; ?>"><?php echo $row['photographer_sitelink']; ?></a></td>
                        <td><center><a class="delete_btn" href="admin_cat_delete.php?photographer_id=<?php echo $row['photographer_id']; ?>">Delete</a></center></td>
                        <td><center><a class="edit_btn" href="admin_photographer_edit.php?photographer_id=<?php echo $row['photographer_id']; ?>">Edit</a></center></td>
                    </tr>
                    <tr><td colspan="10"><hr /></td> </tr>
                <?php } //end while ?>
                </table> 
            </div>
            
            <div id="style_cat" class="category_panel">
				<?php
                $sql = "SELECT *
                        FROM styles";
                
                $result = $conn->query($sql) or die(mysqli_error());
                ?>
                
                
                <table class="cat_table" style="float: left; margin-right: 20px;" >
                <tr><td><a class="add_style_btn" href="admin_style_new.php">+ Add a New Style</a></td></tr>
                <tr>
                    <th>Style Name</th>
                    <th style="text-align: center;" class="extra_column">Delete</th>
                    <th style="text-align: center;" class="extra_column">Edit</th>
                </tr>
                <tr><td colspan="10"><hr /></td> </tr>
                <!--This while loop shows all the entries but not the finished ones -->
                <?php while($row = $result->fetch_assoc()) {  ?>
                    <tr>
                        <td><?php echo $row['style_name']; ?></td>
                        <td><center><a class="delete_btn" href="admin_cat_delete.php?style_id=<?php echo $row['style_id']; ?>">Delete</a></center></td>
                        <td><center><a class="edit_btn" href="admin_style_edit.php?style_id=<?php echo $row['style_id']; ?>">Edit</a></center></td>
                    </tr>
                    <tr><td colspan="10"><hr /></td> </tr>
                <?php } //end while ?>
                </table> 
            </div>
            
            <div id="type_cat" class="category_panel">
				<?php
                $sql = "SELECT *
                        FROM types";
                
                $result = $conn->query($sql) or die(mysqli_error());
                ?>
                
                
                <table class="cat_table" style="float: left;">
                <tr><td><a class="add_type_btn" href="admin_type_new.php">+ Add a New Type</a></td></tr>
                <tr>
                    <th>Type Name</th>
                    <th style="text-align: center;" class="extra_column">Delete</th>
                    <th style="text-align: center;" class="extra_column">Edit</th>
                </tr>
                
                <!--This while loop shows all the entries but not the finished ones -->
                <?php while($row = $result->fetch_assoc()) {  ?>
                    <tr>
                        <td><?php echo $row['type_name']; ?></td>
                        <td><center><a class="delete_btn" href="admin_cat_delete.php?type_id=<?php echo $row['type_id']; ?>">Delete</a></center></td>
                        <td><center><a class="edit_btn" href="admin_type_edit.php?type_id=<?php echo $row['type_id']; ?>">Edit</a></center></td>
                    </tr>
                    <tr><td colspan="10"><hr /></td> </tr>
                <?php } //end while ?>
                </table> 
            </div>
            
            
            
        </div> <!--end highest items div-->
    </div> <!--end main content div-->
</div> <!--end container div-->


<?php mysqli_close($conn); ?>
</body>
</html>