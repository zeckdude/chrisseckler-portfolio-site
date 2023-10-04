<?php 
session_start();
	include("../includes/connection.php");
	
	if(!isset($_SESSION['authenticated_vs'])){
	header('Location: ' . $site_basedir . 'login.php');
	}

	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('admin');

	//These are variables that will be used later. For now, they must be false until something happens
	$updated = false; //boolean variable to be used later which checks whether the update succeeds

	
  
	  //This is telling the database what we want to grab from the database to potentially show on the page
	$sql = 'SELECT *
			FROM home_page
			ORDER BY id 
			DESC';
	
	//This is sending the request to the database and saving the results in $result
	$result = $conn->query($sql) or die(mysqli_error());
	  
	  
	
	//if form has been submitted, update record
	if (array_key_exists('update', $_POST)) { //checks that something with the 'update' name attribute is in the $_POST array, which it is once it is clicked. If the user does click on it, the execute the rest of the script
		//prepare update query
		$sql = 'UPDATE home_page
				SET date = ?, location = ?, location2 = ?, headline = ?, par1 = ?, par2 = ?, footer = ?
				WHERE id = 1';
				
		//initialize prepared statement which will guarantee the code against SQL injection(MySQLI specific way of security)
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql)) { 
		
			//bind parameters and execute statement
			$stmt->bind_param('sssssss', $_POST['date'], $_POST['location'], $_POST['location2'], $_POST['headline'], $_POST['first_par'], $_POST['second_par'], $_POST['footer']);
			$updated = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $done
		}
	}
	
	
	// redirect on success or if $_GET['article_id']) is not defined. This ensures that the page is redirected either if the update succeeds or if someone tries to access the page directly.
	if ($updated == true) { //if $_GET['article_id'] is not defined
		header('Location: ' . $site_basedir .'admin/admincontrols.php'); //then redirect to this page
		exit; //and exit the script	
	}
	
	//display error message if query fails
	if (isset($stmt) && !$updated) { //if the prepared statement has been created, but both $OK and $done remain false 
		echo $stmt->error;	// then display an error message on the screen
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
		elements : "first_par, second_par, footer",
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
        
        <div class="back"><a href="admincontrols.php">Admin Controls</a></div>
        <div class="logout"><a href="<?php echo $site_basedir; ?>includes/logout.php">Logout</a></div>
        <!--EDITABLE-->
        <div id="adminenter_box">
        	<p>
        		You are editing the Home Page
        	</p>
        </div>

        
        <div class="content_area">
        	<form id="newphotoform" name="form1" method="post" action="">
            
            	<?php while($row = $result->fetch_assoc()) { ?>
                    <table id="form_table_index">
                        <tr>
                                <th>What is the Date of the Event?</th>
                                <td><input name="date" type="text" id="date" value="<?php echo htmlentities($row['date']); ?>"/></td>
                        </tr>
                        
                        <tr>
                            <th>What is the first Location line?</th>
                            <td><input name="location" type="text" id="location" value="<?php echo stripslashes(htmlentities($row['location'])); ?>"/></td>
                        </tr>
                        
                        <tr>
                            <th>What is the second Location line?</th>
                            <td><input name="location2" type="text" id="location2" value="<?php echo stripslashes(htmlentities($row['location2'])); ?>"/></td>
                        </tr>
                        
                        <tr>
                            <th>What is the headline in the content box?</th>
                            <td><input name="headline" type="text" id="headline" value="<?php echo stripslashes(htmlentities($row['headline'])); ?>"/></td>
                        </tr>
                        
                        <tr class="wysiwyg_box" style="height: 165px;">
                            <th>What should the first paragraph read?</th>
                            <td><textarea rows=”8″ cols=”58″ wrap="hard" name="first_par" type="text" id="first_par"/><?php echo stripslashes(htmlentities($row['par1'])); ?></textarea></td>
                        </tr>
                        
                        <tr class="wysiwyg_box" style="height: 165px;">
                            <th>What should the second paragraph read?</th>
                            <td><textarea rows=”8″ cols=”58″ wrap="hard" name="second_par" type="text" id="second_par"/><?php echo stripslashes(htmlentities($row['par2'])); ?></textarea></td>
                        </tr>
                        
                        <tr class="wysiwyg_box" style="height: 165px;">
                            <th>What should the footer section read?</th>
                            <td><textarea rows=”8″ cols=”58″ wrap="hard" name="footer" type="text" id="footer_edit"/><?php echo stripslashes(htmlentities($row['footer'])); ?></textarea></td>
                        </tr>
                        
                        <tr>
                            <th></th>
                            <td>
                                <input class="submit_button" type="submit" name="update" value="Update the Home Page" />
                            </td>
                        </tr>
                    </table>
            	<?php } ?>
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
