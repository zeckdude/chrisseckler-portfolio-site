<?php 
session_start();
	include("../includes/connection.php");
	
	if(!isset($_SESSION['authenticated_vs'])){
	header('Location: ' . $site_basedir . 'login.php');
	}

	$conn = dbConnect('admin');

	
	$OK = false; 
	$updated = false; 

	if (isset($_GET['id']) && !$_POST) { 
  
	  $sql = 'SELECT *
			  FROM participants
			  WHERE id = ?';
					
			$stmt = $conn->stmt_init(); 
			if ($stmt->prepare($sql)) { 
				$stmt->bind_param('i', $_GET['id']);
				$stmt->bind_result($id, $name, $description, $extra_line, $link); 
				$OK = $stmt->execute(); 
				$stmt->fetch();
			}
	  }
	  
	
	//if form has been submitted, update record
	if (array_key_exists('update', $_POST)) { //checks that something with the 'update' name attribute is in the $_POST array, which it is once it is clicked. If the user does click on it, the execute the rest of the script	
		
		//prepare update query
		$sql = 'UPDATE participants
				SET name = ?, description = ?, extra_line = ?, link = ?
				WHERE id = ?';
				
		//initialize prepared statement which will guarantee the code against SQL injection(MySQLI specific way of security)
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql)) { 
		
			//bind parameters and execute statement
			$stmt->bind_param('ssssi', $_POST['name'], $_POST['description'], $_POST['extra_line'], $_POST['link'], $_POST['id']);
			$updated = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $done
		}
	}
	
	
	// redirect on success or if $_GET['article_id']) is not defined. This ensures that the page is redirected either if the update succeeds or if someone tries to access the page directly.
	if ($updated == true || !isset($_GET['id'])) { //if $_GET['article_id'] is not defined
		header('Location: ' . $site_basedir .'admin/participants_edit_list.php'); //then redirect to this page
		exit; //and exit the script	
	}
	
	//display error message if query fails
	if (isset($stmt) && !$OK && !$updated) { //if the prepared statement has been created, but both $OK and $done remain false 
		echo $stmt->error;	// then display an error message on the screen
	}
	
function leadingZeros($num,$numDigits) {
   return sprintf("%0".$numDigits."d",$num);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php include('../includes/titleline.php'); ?></title>
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
<link rel="shortcut icon" href="../images/favicon.png" />

<!-- TinyMCE -->
<script type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "vendor_description, vendor_name, extra_line",
		theme : "advanced",
		plugins : "safari,pagebreak,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,charmap,|,undo,redo",
		theme_advanced_buttons2 : "",
		theme_advanced_toolbar_location : "bottom",
		theme_advanced_toolbar_align : "center",
		theme_advanced_resizing : false,

		// Example content CSS (should be your site CSS)
		content_css : "../css/tinymce.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->


<!--[if IE]>
<link href="css/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->



</head>

<body>      
    <!--PERMANENT FOR NOW UNTIL I CREATE DYNAMIC CSS-->
    <div id="header"></div>
    
     <div id="bottomleft_shadow">
     <div id="bottomright_shadow">
     <div id="left_shadow">
     <div id="right_shadow">
     <div id="bottom_shadow">
     <div id="container">
    
        <!--PERMANENT-->
        <div id="title"> 
            <h2>Peninsula Travel Experts'</h2>
            <h1>VACATION SHOWCASE</h1>
        </div>
        
        <div class="back"><a href="participants_edit_list.php">Back</a></div>
        <div class="logout"><a href="../includes/logout.php">Logout</a></div>
        <!--EDITABLE-->
        <div id="adminenter_box">
        	<p>
        		You are editing the vendor information for <?php echo strip_tags(stripslashes($name)); ?>
        	</p>
        </div>
        
        <div id="delete_agent_btn">
        	<a href="participants_delete_entry.php?id=<?php echo $id; ?>">- Delete this Vendor</a>
		</div>
        
        <div class="content_area">
        	<form id="newphotoform" name="form1" method="post" action="">
            
            	
                    <table id="form_table">
                        <tr>
                            <th>Vendor:</th>
                            <td><input name="name" type="text" id="vendor_name" value="<?php echo stripslashes(htmlentities($name)); ?>"/></td>
                        </tr>
                        
                        <tr>
                            <th>Description:</th>
                            <td><textarea rows=”12″ cols=”64″ wrap="hard" name="description" type="text" id="vendor_description"/><?php echo stripslashes(htmlentities($description)); ?></textarea></td>
                        </tr>
                        
                        <tr>
                            <th>Caption:</th>
                            <td><input name="extra_line" type="text" id="extra_line" value="<?php echo stripslashes(htmlentities($extra_line)); ?>"/></td>
                        </tr>
                        
                        <tr>
                            <th>Web Url Address:</th>
                            <td style="font-size:11px;">http:// <input name="link" type="text" id="link" style="width: 315px;" value="<?php echo htmlentities($link); ?>"/></td>
                        </tr>

                        <tr>
                            <th></th>
                            <td>
                                <input class="submit_button" type="submit" name="update" value="Update the vendor information" />
                                <input name="id" type="hidden" value="<?php echo $id ?>"/>
                            </td>
                        </tr>
                    </table>
            	
            </form>  
        </div>
        <?php include('../includes/companyline.php'); ?>
        
        
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
<?php mysqli_close($conn); ?>   
</body>
</html>
