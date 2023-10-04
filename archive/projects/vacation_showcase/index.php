<?php  
	include("includes/connection.php");
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('query');
	
	//This is telling the database what we want to grab from the database to potentially show on the page
	$sql = 'SELECT *
			FROM home_page
			ORDER BY id 
			DESC
			LIMIT 1';
	
	//This is sending the request to the database and saving the results in $result
	$result = $conn->query($sql) or die(mysqli_error());
	$row = $result->fetch_assoc();
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
    
        <?php include('includes/title_nav.php'); ?>
        
        
            <!--EDITABLE-->
            <div id="datelocation">
                <h1><?php echo $row['date']; ?></h1>
                <h2><?php echo $row['location']; ?></h2>
                <h3><?php echo $row['location2']; ?></h3>
            </div>
            
            <!--EDITABLE-->
            <div id="description">
                <h3><?php echo $row['headline']; ?></h3>
                <span id="par1">
                    <?php echo stripslashes($row['par1']); ?>
                </span>
                <span id="par2">
                    <?php echo stripslashes($row['par2']); ?>
                </span>
            </div>
            
            <div id="info_banner">
                <h1>FREE ADMISSION!</h1>
            </div>
            
            
            <div id="footer">
                <div id="footertext"> 
                    <span><?php echo stripslashes($row['footer']); ?></span> 
                </div>
                <?php include('includes/companyline.php'); ?>
            </div>
		
        
            </div>
    </div>
    </div>
    </div>
    </div>
    </div>

<?php mysqli_close($conn); ?>    
</body>
</html>
