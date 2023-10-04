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
	
	
	
	if(isset($_GET['photographer_id'])) {
		  // prepare SQL query
		  if (isset($_GET['photographer_id']) && !$_POST) { 
			
			$sql = 'SELECT photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photographers.photographer_sitelink
					FROM photographers
					WHERE photographers.photographer_id = ?';
					
			$stmt = $conn->stmt_init(); 
			if ($stmt->prepare($sql)) { 
				$stmt->bind_param('i', $_GET['photographer_id']); 
				$stmt->bind_result($photographer_id, $photographer_name, $firstname, $lastname, $sitelink); 
				$OK = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $OK
				$row = $stmt->fetch(); //fetches the result
	
			}
		} //end if get photographer id and !post
		
		
		// if confirm deletion button has been clicked, delete record
		if (array_key_exists('delete', $_POST)) {
		  $sql = 'DELETE FROM photographers WHERE photographer_id = ?';
		  $stmt = $conn->stmt_init();
		  if ($stmt->prepare($sql)) {
			$stmt->bind_param('i', $_POST['photographer_id']);
			$deleted = $stmt->execute();
			}
		  }// end if delete
		  
	} //end if the get variable is photographer_id
	
	
	
	if(isset($_GET['style_id'])) {
		  // prepare SQL query
		  if (isset($_GET['style_id']) && !$_POST) { 
			
			$sql = 'SELECT styles.style_id, styles.style_name, styles.style_desc
					FROM styles
					WHERE styles.style_id = ?';
					
			$stmt = $conn->stmt_init(); 
			if ($stmt->prepare($sql)) { 
				$stmt->bind_param('i', $_GET['style_id']); 
				$stmt->bind_result($style_id, $style_name, $style_desc); 
				$OK = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $OK
				$row = $stmt->fetch(); //fetches the result
	
			}
		} //end if get style id and !post
		
		
		// if confirm deletion button has been clicked, delete record
		if (array_key_exists('delete', $_POST)) {
		  $sql = 'DELETE FROM styles WHERE style_id = ?';
		  $stmt = $conn->stmt_init();
		  if ($stmt->prepare($sql)) {
			$stmt->bind_param('i', $_POST['style_id']);
			$deleted = $stmt->execute();
			}
		  }// end if delete
		  
	} //end if the get variable is style_id
	
	
	
	
	if(isset($_GET['type_id'])) {
		  // prepare SQL query
		  if (isset($_GET['type_id']) && !$_POST) { 
			
			$sql = 'SELECT types.type_id, types.type_name, types.type_desc
					FROM types
					WHERE types.type_id = ?';
					
			$stmt = $conn->stmt_init(); 
			if ($stmt->prepare($sql)) { 
				$stmt->bind_param('i', $_GET['type_id']); 
				$stmt->bind_result($type_id, $type_name, $type_desc); 
				$OK = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $OK
				$row = $stmt->fetch(); //fetches the result
	
			}
		} //end if get type id and !post
		
		
		// if confirm deletion button has been clicked, delete record
		if (array_key_exists('delete', $_POST)) {
		  $sql = 'DELETE FROM types WHERE type_id = ?';
		  $stmt = $conn->stmt_init();
		  if ($stmt->prepare($sql)) {
			$stmt->bind_param('i', $_POST['type_id']);
			$deleted = $stmt->execute();
			}
		  }// end if delete
		  
	} //end if the get variable is type_id
	
	
	
	
	
	
	
	// redirect the page if deletion is successful, cancel button clicked, or $_GET['article_id'] not defined
	if ($deleted || array_key_exists('cancel_delete', $_POST))  {
	  header('Location: ' . $site_basedir . 'admin/manage_cat.php');
	  exit;
	}
	// if any SQL query fails, display error message
	if (isset($stmt) && !$OK && !$deleted) {
	  echo $stmt->error;
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
        
        <?php if(isset($_GET['photographer_id'])) { ?>
            <h1>Delete Photographer Entry?</h1>
			<?php if($photographer_id == 0) { ?>
            <p class="warning">Invalid request: record does not exist.</p>
            <?php } else { ?>
            <p class="warning">Please confirm that you want to delete the following photographer. This action cannot be undone.</p>

            <table class="center">
                <tr>
                    <th>Photographer</th>
                    <th>Website URL</th>
                </tr>
                
                <tr>
                    <td><?php echo $firstname . ' ' . $lastname; ?></td>
                    <td><?php echo $sitelink; ?></td>                    
                </tr>
            </table>

            <?php } ?>
            <form id="form1" name="form1" method="post" action="">
                <p>
                <?php if($photographer_id > 0) { ?>
                    <input type="submit" name="delete" value="Confirm deletion" />
                <?php } ?>
                    <input name="cancel_delete" type="submit" id="cancel_delete" value="Cancel" />
                <?php if($photographer_id > 0) { ?>
                    <input name="photographer_id" type="hidden" value="<?php echo $photographer_id; ?>" />
                <?php } ?>
                </p>
            </form>
        <?php } //end if get variable is photographer ?> 
        
        
        
        
        <?php if(isset($_GET['style_id'])) { ?>
            <h1>Delete Style Entry?</h1>
			<?php if($style_id == 0) { ?>
            <p class="warning">Invalid request: record does not exist.</p>
            <?php } else { ?>
            <p class="warning">Please confirm that you want to delete the following style. This action cannot be undone.</p>

            <table class="center">
                <tr>
                    <th>Style</th>
                    <th>Description</th>
                </tr>
                
                <tr>
                    <td><?php echo $style_name; ?></td>
                    <td><?php echo $style_desc; ?></td>                    
                </tr>
            </table>

            <?php } ?>
            <form id="form1" name="form1" method="post" action="">
                <p>
                <?php if($style_id > 0) { ?>
                    <input type="submit" name="delete" value="Confirm deletion" />
                <?php } ?>
                    <input name="cancel_delete" type="submit" id="cancel_delete" value="Cancel" />
                <?php if($style_id > 0) { ?>
                    <input name="style_id" type="hidden" value="<?php echo $style_id; ?>" />
                <?php } ?>
                </p>
            </form>
        <?php } //end if get variable is style ?>   
         
        
        
        <?php if(isset($_GET['type_id'])) { ?>
            <h1>Delete Type Entry?</h1>
			<?php if($type_id == 0) { ?>
            <p class="warning">Invalid request: record does not exist.</p>
            <?php } else { ?>
            <p class="warning">Please confirm that you want to delete the following type. This action cannot be undone.</p>

            <table class="center">
                <tr>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
                
                <tr>
                    <td><?php echo $type_name; ?></td>
                    <td><?php echo $type_desc; ?></td>                    
                </tr>
            </table>

            <?php } ?>
            <form id="form1" name="form1" method="post" action="">
                <p>
                <?php if($type_id > 0) { ?>
                    <input type="submit" name="delete" value="Confirm deletion" />
                <?php } ?>
                    <input name="cancel_delete" type="submit" id="cancel_delete" value="Cancel" />
                <?php if($type_id > 0) { ?>
                    <input name="type_id" type="hidden" value="<?php echo $type_id; ?>" />
                <?php } ?>
                </p>
            </form>
        <?php } //end if get variable is type ?>  
         
        </div> <!--end highest items div-->
    </div> <!--end main content div-->
</div> <!--end container div-->


<?php mysqli_close($conn); ?>
</body>
</html>