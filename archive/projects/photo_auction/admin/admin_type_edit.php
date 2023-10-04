<?php 
session_start();



error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	include("../includes/connection.php");
	
	if(!isset($_SESSION['authenticated_pa_admin'])){
	header('Location: ' . $site_basedir . 'admin/admin_login.php');
}
	
	$OK = false; //boolean variable to be used later which checks the success of retrieving the record
	$done = false; //boolean variable to be used later which checks whether the update succeeds
	
	
	//create a database connection which comes from 'conn.inc.php'
	$conn = dbConnect('admin');
		
	//get details of selected record
	 if (isset($_GET['type_id']) && !$_POST) { 
		
		$sql = 'SELECT types.type_id, types.type_name, types.type_desc
				FROM types
				WHERE types.type_id = ?';
				
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql)) { 
			$stmt->bind_param('i', $_GET['type_id']); 
			$stmt->bind_result($type_id, $name, $desc); 
			$OK = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $OK
			$row = $stmt->fetch(); //fetches the result

		}
	} //end if get photo id and !post
	
	//if form has been submitted, update record
	if (array_key_exists('update', $_POST)) { //checks that something with the 'update' name attribute is in the $_POST array, which it is once it is clicked. If the user does click on it, the execute the rest of the script

		//prepare update query
		$sql = 'UPDATE types
				SET types.type_name = ?, types.type_desc = ?
				WHERE types.type_id = ?';
				
				
		
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql)) { 
			$stmt->bind_param('ssi', $_POST['name'], $_POST['desc'], $_POST['type_id']); 
			$done = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $done
		}
	}
	
	
	// redirect on success or if $_GET['article_id']) is not defined. This ensures that the page is redirected either if the update succeeds or if someone tries to access the page directly.
	if ($done || !isset($_GET['type_id'])) { //if $_GET['article_id'] is not defined
		header('Location: ' . $site_basedir . 'admin/manage_cat.php');
		exit; //and exit the script	
	}
	
	//display error message if query fails
	if (isset($stmt) && !$OK && !$done) { //if the prepared statement has been created, but both $OK and $done remain false 
		echo $stmt->error;	// then display an error message on the screen
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
            <h1>Edit Type entry </h1>
                
                <form id="newphotoform" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                    <p>
                        <label for="name">Type Name:</label>
                        <input name="name" type="text" id="type_name" value="<?php echo htmlentities($name); ?>"/></input>
                    </p>
                    
                    <p>
                        <label for="desc">Type Description:</label>
                        <textarea name="desc" id="type_desc"/><?php echo htmlentities($desc); ?></textarea>
                    </p>
                    
                    <p>
                        <input type="submit" name="update" value="Update Type Information" />
                        <input name="type_id" type="hidden" value="<?php echo $type_id ?>"/>
                    </p>
                </form> 
               
        </div> <!--end highest items div-->
    </div> <!--end main content div-->
</div> <!--end container div-->



<?php mysqli_close($conn); ?>
</body>
</html>