<?php 
ob_start();
session_start();

include("includes/connection.php");

$conn = dbConnect("admin");


//This is a variable that will be used later. For now, it must be false until something happens
	$inserted = false;

//This creates a database connection. The function that makes this happen is in the conn.inc.php file
$conn = dbConnect('admin');






//This is what sends the form information to the database
if (array_key_exists('insert', $_POST)) { //This checks to see that someone clicked on the button with the name 'insert'
	
	 if(empty($_POST['username']) || empty($_POST['password'])) {
			$error = "Please fill out required fields";
			
	 } else {
			
		$username = $_POST['username'];
		$pwd = $_POST['password'];
		$encrypted_pass = sha1($username.$pwd);
		//echo "$encrypted_pass";

	
		//This tells the database which fields in the database are going to be inserted
		$sql = 'INSERT INTO users (username, password, user_firstname, user_lastname, user_email)
				VALUES(?, ?, ?, ?, ?)'; //This is a secure way of transferring information and you must put the same amount of question marks here as you put number of fields on the last line
		
		//This starts the prepared statement which is a secure way of sending information
		$stmt = $conn->stmt_init();
		if ($stmt->prepare($sql)) {
			//This is where you specify what types of information and what fields you want to have inserted into the fields you mentioned on line 22. These must be in the same order so they are inserted into the correct database column
			$stmt->bind_param('sssss', $_POST['username'], $encrypted_pass, $_POST['user_firstname'], $_POST['user_lastname'], $_POST['user_email']); 
			$inserted = $stmt->execute(); //This runs the insertion and saves whether it worked or not in $inserted
		}

	//redirect if successful
	if ($inserted == true) { //This checks if $inserted is true, which it should be once you entered information into the database
		header('Location: ' . $site_basedir .'index.php'); //If information was inserted into the database, then go to this page
		} else { //if it doesn't execute correctly
		echo $stmt->error; // then display an error message on the screen
		}
}
}
	
	
	
	
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_name; ?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />




<link rel="shortcut icon" href="../images/favicon.ico" />
</head>

<body>
<div id="container">
    <?php include('includes/header.php'); ?>
    
    <div id="main_content">
    	<div id="highest_items">
        <h2>User Registration</h2>
        <?php  if(isset($error)) { echo $error; } ?>
        	<form id="fill_out_form" name="form1" method="post" action="">
            
            	
                    <table id="form_table">
                        <tr>
                                <th>Username:</th>
                                <td><input name="username" type="text" id="username" value=""/></td>
                        </tr>
                        
                        <tr>
                            <th>Password:</th>
                            <td><input name="password" type="password" id="password" value=""/></td>
                        </tr>
                        
                        <tr>
                            <th>First Name:</th>
                            <td><input name="user_firstname" type="text" id="user_firstname" value=""/></td>
                        </tr>
                        
                       <tr>
                            <th>Last Name:</th>
                            <td><input name="user_lastname" type="text" id="user_lastname" value=""/></td>
                        </tr>
                        
                        <tr>
                            <th>Email:</th>
                            <td><input name="user_email" type="text" id="user_email" value=""/></td>
                        </tr>

                        <tr>
                            <th></th>
                            <td>
                                <input class="submit_button" type="submit" name="insert" id="submit" value="Register" />
                            </td>
                        </tr>
                    </table>
            </form> 
       </div> 
    </div> <!--end main content div-->
</div> <!--end container div-->


<?php mysqli_close($conn); ?>
</body>
</html>