<?php
//ob_start();
session_start();
	include("../includes/connection.php");
	
	if(!isset($_SESSION['authenticated_vs'])){
	header('Location: ' . $site_basedir .'login.php');
	}
	
	$conn = dbConnect('query');
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
        <a href="../index.php"><div id="title"> 
            <h2>Peninsula Travel Experts'</h2>
            <h1>VACATION SHOWCASE</h1>
        </div></a>
        
        <div class="logout"><a href="<?php echo $site_basedir; ?>includes/logout.php">Logout</a></div>
        <!--EDITABLE-->
        <div id="adminenter_box">
        	<p>
        		What page would you like to edit?
        	</p>
        </div>

        
        <div class="content_area">
        	<div id="adminlinks">
                <a href="index_edit_entry.php">Home Page</a>
                <a href="aboutus_edit_list.php">About Us Page</a>
                <a href="schedule_edit_list.php">Schedule Page</a>
                <a href="participants_edit_list.php">Participants Page</a> 
            </div>  
        </div>
        
        <div id="adminenter_box">
        	<p>
        		What page would you like to view?
        	</p>
        </div>

        
        <div class="content_area">
        	<div id="adminlinks">
                <a href="../index.php" target="_blank">Home Page</a>
                <a href="../aboutus.php" target="_blank">About Us Page</a>
                <a href="../schedule.php" target="_blank">Schedule Page</a>
                <a href="../participants.php" target="_blank">Participants Page</a> 
            </div>  
        </div>
        
        <div id="adminenter_box">
        	<p>
        		Mailing List Manager
        	</p>
        </div>

        
        <div class="content_area" style="width: 520px;">
        	<div id="adminlinks">
                <a href="mailinglist/index.php?action=manage-subscribers">Manage Subscribers</a>
                <a href="mailinglist/index.php?action=manage-lists">Manage Lists</a>
                <a href="mailinglist/index.php?action=manage-mail">Manage Mail</a> 
            </div>  
        </div>
        <?php include('../includes/companyline.php'); ?>
        
        
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    
</body>
</html>
