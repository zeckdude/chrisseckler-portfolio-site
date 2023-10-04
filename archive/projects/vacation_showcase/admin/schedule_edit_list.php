<?php 
session_start();

	include("../includes/connection.php");
	
	if(!isset($_SESSION['authenticated_vs'])){
		header('Location: ' . $site_basedir . 'login.php');
	}	
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('query');
	
	//This is telling the database what we want to grab from the database to potentially show on the page
	$sql = 'SELECT *
			FROM schedule
			ORDER BY startTime 
			ASC';
	
	//This is sending the request to the database and saving the results in $result
	$result = $conn->query($sql) or die(mysqli_error());
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php include('../includes/titleline.php'); ?></title>
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
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
        <div id="title"> 
            <h2>Peninsula Travel Experts'</h2>
            <h1>VACATION SHOWCASE</h1>
        </div>
        
        <div class="back"><a href="admincontrols.php">Admin Controls</a></div>
        <div class="logout"><a href="../includes/logout.php">Logout</a></div>
        
        <div id="newagent_btn">
        	<a href="schedule_new_entry.php">+ Add a new Presentation</a>
		</div>
        
        
        <div id="adminenter_box">
            <p>
        		Click on an existing Presentation to edit or delete it
        	</p>
        </div>

        
        <div class="content_area">
            <p class="content_title">Schedule of Presentations</p>
            <table id="schedule_edit_table">
                <tr id="schedule_header" class="dark_background">
                    <th>Time</th>
                    <th>Presenter</th>
                </tr>
            	
                <?php while($row = $result->fetch_assoc()) { 
					$startTime = date('g:ia', strtotime(stripslashes($row['startTime'])));
					$endTime = date('g:ia', strtotime(stripslashes($row['endTime'])));
				?>
                    <tr onclick="window.location.href='schedule_edit_entry.php?id=<?php echo $row['id']; ?>'" OnMouseOver="this.className='cursor';">
                        <td class="time_column"><p><?php echo $startTime . ' - ' . $endTime; ?></p></td>
                        <td class="presenter_column"><p><?php echo $row['presenter']; ?></p></td>
                    </tr>
                <?php } ?> 

            </table>
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
