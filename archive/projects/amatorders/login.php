<?php
session_start();
ob_start();

include("includes/connection.php");

$conn = dbConnect("query");

if(isset($_SESSION['authenticated_oc'])){
	header('Location: ' . $site_basedir . 'admin/tracker.php');
}

if(isset($_POST['submitBtn'])){
	$sql = "SELECT * 
			FROM admin 
			WHERE username = '" . $_POST['username'] . "' AND password = '" . sha1($_POST['username'].$_POST['password']) . "'";
	$result = $conn->query($sql) or die(mysqli_error());
	$row = $result->fetch_assoc();
	$confirm = count($row);
	if($confirm != 0){
		$_SESSION['authenticated_oc'] = $_POST['username'];
		header('Location: ' . $site_basedir .'admin/tracker.php');
	}else{
		header('Location: ' . $site_basedir .'login.php?error=1');
	}
}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Applied Materials Order Form</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" href="images/favicon.gif" />
</head>





<body>


<div id="container">


<?php include("includes/header.php");

/*echo 'Username: ' . $_POST['username'];
echo '<br />';
echo 'Password: ' . $_POST['password'];*/



?>

   
     
     
     <div class="form_container" id="admin_details">  
            <div class="row">
                <div class="clientform_table_header">Administrative Login<br /><span class="warning">Please login in the bottom two fields</span></div>   
            </div>
            
            
            <div class="row" style="overflow:hidden;">
                <div class="content"> 
                <form action="" id="fill_out_form" name="comment" method="post"> 
                    <label for="username">Username:</label>
                    <br />
                    <input type="text" name="username" id="username" value="<?php if(isset($_POST['username'])) {echo $_POST['username'];} ?>"/>
                </div>
                
                <div class="content">  
                	<label for="password">Password:</label>
                    <br />
                    <input type="password" name="password" id="password" value="<?php if(isset($_POST['password'])) {echo $_POST['password'];} ?>"/>  
                </div>
            </div>
            
            <div class="row">
            	<div class="content prev"><div id="error_box"><?php if(isset($_GET['error'])){ echo '<p>Incorrect Username and/or Password.  Please try again.</p>';} ?></div></div>
                <div class="content" id="last_content"> <input class="submit button next" type="submit" value="Login" id="login_btn" name="submitBtn"/></div>
            </div>  
        </div>
        
        </form>
     
     
          
		 
</div>

</body>

</html>