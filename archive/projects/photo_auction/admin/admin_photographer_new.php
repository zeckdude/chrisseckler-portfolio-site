<?php 
session_start();



error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	include("../includes/connection.php");
	
	
	if(!isset($_SESSION['authenticated_pa_admin'])){
	header('Location: ' . $site_basedir . 'admin/admin_login.php');
}
	
	$inserted = false;
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('admin');
	

	if (array_key_exists('insert', $_POST)) { 
		
		$photographer_name = $_POST['firstname'] . ' ' . $_POST['lastname'];
		
		//INSERTING INFORMATION ABOUT PHOTOGRAPHER
		$sql = 'INSERT INTO photographers (photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photographers.photographer_sitelink)
				VALUES(?, ?, ?, ?)';
		
		
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql)) { 
			$stmt->bind_param('ssss', $photographer_name, $_POST['firstname'], $_POST['lastname'], $_POST['sitelink']); 
			$inserted = $stmt->execute(); 
			}
			
		
		//redirect if successful or display an error
		if ($inserted) { //if $OK is true(the prepared statement executed correctly)
			header("Location: " . $site_basedir . "admin/manage_cat.php"); //redirect to jcrop page
			//header('Location: ' . $site_basedir . 'admin/admin_list.php'); //then redirect to this page
			exit; //and exit the script
			}
			
		else { //if it doesn't execute correctly
			echo $stmt->error; // then display an error message on the screen
			}
		}
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_name; ?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/jquery.datepick.css" type="text/css" media="screen" charset="utf-8" />
<link rel="shortcut icon" href="../../images/favicon.ico" />
</head>

<body>
<div id="container">
    <?php include('../includes/adminheader.php'); ?>
    
    <div id="main_content">
        <div id="highest_items">
            <h2 style="margin-left: 0px;">Enter new Photographer Information </h2>
                <form id="fill_out_form" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                    <p>
                        <label for="firstname">First Name:</label>
                        <input name="firstname" type="text" id="firstname" value=""/></input>
                    </p>
                    
                    <p>
                        <label for="lastname">Last Name:</label>
                        <input name="lastname" type="text" id="lastname" value=""/></input>
                    </p>

                     <p>
                        <label for="sitelink">Website URL:</label>
                        <input name="sitelink" type="text" id="lastname" value=""/></input>
                    </p>
                    
                    <p>
                        <input type="submit" name="insert" value="Insert new Photographer Information" />
                    </p>
        		</form> 
        </div> <!--end highest items div-->
    </div> <!--end main content div-->
</div> <!--end container div-->


<?php mysqli_close($conn); ?>
</body>
</html>