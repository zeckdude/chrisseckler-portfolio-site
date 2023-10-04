<?php 
ob_start();
session_start();
include("includes/connection.php");

$conn = dbConnect("query");

if(isset($_SESSION['authenticated_pa'])){
	header('Location: ' . $site_basedir . 'index.php');
}

if(isset($_POST['submitBtn'])){
	$sql = "SELECT * 
			FROM users 
			WHERE username = '" . $_POST['username'] . "' AND password = '" . sha1($_POST['username'].$_POST['password']) . "'";
	$result = $conn->query($sql) or die(mysqli_error());
	$row = $result->fetch_assoc();
	$confirm = count($row);
	if($confirm != 0){
		$_SESSION['authenticated_pa'] = $_POST['username'];
		header('Location: ' . $site_basedir .'photos_list.php');
	}else{
		header('Location: ' . $site_basedir .'login.php?error=1');
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
        <h2 style="margin-left: 0px;">User Login</h2>
            
            <?php if(isset($_GET['error'])){
				echo '<p>Incorrect Username and/or Password.  Please try again.</p>';
			   } ?>
            <span id="login_area">
                <form action="" id="fill_out_form" name="comment" method="post">
                    <ul id="form">
                        <li class="field"><label for="username">Username:</label>
                            <span class="fieldbox"><input type="text" name="username" id="username"/></span></li>	
                        <li class="field"><label for="password">Password:</label>
                            <span class="fieldbox"><input type="password" name="password" id="password" style="margin-left: 6px;"/></span></li>
                    </ul>
                    <input class="submit_button" type="submit" value="Login" id="login_btn_small" name="submitBtn"/>
                </form><!-- End Form -->
            </span>
        </div>
    </div> <!--end main content div-->
</div> <!--end container div-->


<?php mysqli_close($conn); ?>
</body>
</html>