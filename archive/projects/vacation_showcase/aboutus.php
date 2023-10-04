<?php 
	include("includes/connection.php");
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('query');
	
	//This is telling the database what we want to grab from the database to potentially show on the page
	$sql = 'SELECT aboutus_desc
			FROM home_page
			ORDER BY id 
			LIMIT 1';
	
	//This is sending the request to the database and saving the results in $result
	$result = $conn->query($sql) or die(mysqli_error());
	$row = $result->fetch_assoc();
	
	
	
	//This is telling the database what we want to grab from the database to potentially show on the page
	$travelagentsql = 'SELECT *
			FROM travelagents
			ORDER BY travelagent_id 
			ASC';
	
	//This is sending the request to the database and saving the results in $result
	$travelagentresult = $conn->query($travelagentsql) or die(mysqli_error());
	 
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
        <div id="ptedescription">
        	<p>
        		<?php echo $row['aboutus_desc']; ?>
        	</p>
        </div>

        
        <div class="content_area">
            <p class="content_title">Contact Information</p>
            <div id="travelagents">
            
				<?php 
				$travelagentrow = 0; // set count of array to be 0 for first run
				for($i = 0; $i < count($travelagentrow); ) { 
					while($travelagentrow = $travelagentresult->fetch_assoc()) { 
						//divde the count by two and see if there is a remainder(odd number) and assign a color.
     					$class = ($i % 2) ? 'dark_background' : ''; 
					?>
						<span class="<?php echo $class; ?>">
							<p><?php echo $travelagentrow['name']; ?></p>
							<p id="company_name"><?php echo $travelagentrow['company_name']; ?></p>
							<p><?php echo $travelagentrow['phone']; ?></p>
							<p><?php echo $travelagentrow['email']; ?></p>
							<p>CST #<?php echo $travelagentrow['cst']; ?></p>
						</span>
					<?php
					 $i++; 
					} 
				}
				?>   
            </div>
        </div>
        <?php include('includes/companyline.php'); ?>
        
        
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
<?php mysqli_close($conn); ?>   
</body>
</html>
