<?php 
session_start();
	include("../includes/connection.php");
	
	if(!isset($_SESSION['authenticated_vs'])){
	header('Location: ' . $site_basedir . 'login.php');
	}

	$conn = dbConnect('admin');

	
	$OK = false; 
	$updated = false; 

	if (isset($_GET['travelagent_id']) && !$_POST) { 
  
	  $sql = 'SELECT *
			  FROM travelagents
			  WHERE travelagent_id = ?';
					
			$stmt = $conn->stmt_init(); 
			if ($stmt->prepare($sql)) { 
				$stmt->bind_param('i', $_GET['travelagent_id']);
				$stmt->bind_result($id, $name, $company_name, $phone, $email, $cst); 
				$OK = $stmt->execute(); 
				$stmt->fetch(); 
			}
	  }
	  
	
	//if form has been submitted, update record
	if (array_key_exists('update', $_POST)) { //checks that something with the 'update' name attribute is in the $_POST array, which it is once it is clicked. If the user does click on it, the execute the rest of the script
	
	if(empty($_POST['name']) || empty($_POST['company_name'])) {
				$name_empty = htmlentities($_POST['name']);
				$company_name_empty = htmlentities($_POST['company_name']);
				$error = "Please fill out required fields";
				
		 } else {
	
	
	
		//prepare update query
		$sql = 'UPDATE travelagents
				SET name = ?, company_name = ?, phone = ?, email = ?, cst = ?
				WHERE travelagent_id = ?';
				
		//initialize prepared statement which will guarantee the code against SQL injection(MySQLI specific way of security)
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql)) { 
		
			//bind parameters and execute statement
			$stmt->bind_param('ssssii', $_POST['name'], $_POST['company_name'], $_POST['phone'], $_POST['email'], $_POST['cst'], $_POST['id']);
			$updated = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $done
		}
	}
	
	
	// redirect on success or if $_GET['article_id']) is not defined. This ensures that the page is redirected either if the update succeeds or if someone tries to access the page directly.
	if ($updated == true || !isset($_GET['travelagent_id'])) { //if $_GET['article_id'] is not defined
		header('Location: ' . $site_basedir .'admin/aboutus_edit_list.php'); //then redirect to this page
		exit; //and exit the script	
	}
	
	//display error message if query fails
	if (isset($stmt) && !$OK && !$updated) { //if the prepared statement has been created, but both $OK and $done remain false 
		echo $stmt->error;	// then display an error message on the screen
	}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php include('../includes/titleline.php'); ?></title>
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
<link rel="shortcut icon" href="../images/favicon.png" />

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
        
        <div class="back"><a href="aboutus_edit_list.php">Back</a></div>
        <div class="logout"><a href="../includes/logout.php">Logout</a></div>
        <!--EDITABLE-->
        <div id="adminenter_box">
        	<p>
        		You are editing the information for <?php echo htmlentities($name); ?>
        	</p>
        </div>
        
        <div id="delete_agent_btn">
        	<a href="aboutus_delete_entry.php?travelagent_id=<?php echo $id; ?>">- Delete this Travel Agent</a>
		</div>
        
        <div class="content_area">
        	<?php  if(isset($error)) { echo $error; } ?>
        	<form id="newphotoform" name="form1" method="post" action="">
            
            	
                    <table id="form_table">
                        <tr>
                                <th>Travel Agent Name:</th>
                                <td><input name="name" type="text" id="agent_name" value="<?php if(isset($error) && isset($name_empty)){ echo $name_empty;} elseif(!isset($error) && !isset($name_empty)) { echo htmlentities($name); }?>"/></td>
                        </tr>
                        
                        <tr>
                            <th>Company Name:</th>
                            <td><input name="company_name" type="text" id="company_name_field" value="<?php echo htmlentities($company_name); ?>"/></td>
                        </tr>
                        
                        <tr>
                            <th>Phone Number:</th>
                            <td><input name="phone" type="text" id="phone" value="<?php echo htmlentities($phone); ?>"/></td>
                        </tr>
                        
                        <tr>
                            <th>Email Address</th>
                            <td><input name="email" type="text" id="email" value="<?php echo htmlentities($email); ?>"/></td>
                        </tr>
                        
                         <tr>
                            <th>CST Number:</th>
                            <td><input name="cst" type="text" id="cst" value="<?php echo htmlentities($cst); ?>"/></td>
                        </tr>

                        <tr>
                            <th></th>
                            <td>
                                <input class="submit_button" type="submit" name="update" value="Update the Travel Agent information" />
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
