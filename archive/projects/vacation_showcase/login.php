<?php
ob_start();
session_start();
include("includes/connection.php");

$conn = dbConnect("query");

if(isset($_SESSION['authenticated_vs'])){
	header('Location: ' . $site_basedir . 'admin/admincontrols.php');
}

if(isset($_POST['submitBtn'])){
	$sql = "SELECT * 
			FROM admin 
			WHERE username = '" . $_POST['username'] . "' AND password = '" . sha1($_POST['username'].$_POST['password']) . "'";
	$result = $conn->query($sql) or die(mysqli_error());
	$row = $result->fetch_assoc();
	$confirm = count($row);
	if($confirm != 0){
		$_SESSION['authenticated_vs'] = 'confirm';
		header('Location: ' . $site_basedir .'admin/admincontrols.php');
	}else{
		header('Location: ' . $site_basedir .'login.php?error=1');
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php include('includes/titleline.php'); ?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<link rel="shortcut icon" href="images/favicon.png" />

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
        <a href="index.php"><div id="title"> 
            <h2>Peninsula Travel Experts'</h2>
            <h1>VACATION SHOWCASE</h1>
        </div></a>
        
        <!--EDITABLE-->
        <div id="login">
        	<h2>Administrative Login</h2>
            
            <?php if(isset($_GET['error'])){
				echo '<p>Incorrect Username and/or Password.  Please try again.</p>';
			   } ?>
            <span id="login_area">
                <form action="" id="comment" name="comment" method="post">
                    <ul id="form">
                        <li class="field"><label for="username">Username:</label>
                            <span class="fieldbox"><input type="text" name="username" id="username"/></span></li>	
                        <li class="field"><label for="password" style="position:relative; top: 25px;">Password:</label>
                            <span class="fieldbox"><input type="password" name="password" id="password"/></span></li>
                    </ul>
                    <input class="submit_button" type="submit" value="Login" id="login_btn" name="submitBtn"/>
                </form><!-- End Form -->
            </span>
        </div>

        <?php include('includes/companyline.php'); ?>
        
        
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    
</body>
</html>
