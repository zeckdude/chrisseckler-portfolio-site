<?php 
	include("includes/connection.php");
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('query');
	
	//This is telling the database what we want to grab from the database to potentially show on the page
	$sql = 'SELECT *
			FROM participants
			ORDER BY id 
			ASC';
	
	//This is sending the request to the database and saving the results in $result
	$result = $conn->query($sql) or die(mysqli_error());
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

        
        <div class="content_area">
            <p class="content_title">Participants</p>
            <div id="participants_table">
            
            
            <table>
            	<?php 
				
				$row = 0; // set count of array to be 0 for first run
				for($i = 0; $i < count($row); ) { ?>
                
				<?php	while($row = $result->fetch_assoc()) { 
						//divde the count by two and see if there is a remainder(odd number) and assign a color.
     					$class = ($i % 5) ? 'dark_background' : '';
					?>
                    <tr <?php echo $class; ?>>
						<td style="border: 1px solid #976B00; width: 280px; padding: 10px 20px">
							<?php if($row['link'] != '') {
								echo '<span class="vendor_name"><a href="http://' . $row['link'] . '" target="_blank">' . $row['name'] . '</a></span>';
							} else {
								echo '<span class="vendor_name">' . stripslashes($row['name']) . '</span>';
							}
							?>
							<span class="vendor_description"><?php echo stripslashes($row['description']); ?></span>
							
							<?php if($row['extra_line'] != '') {
								echo '<span class="extra_line">' . $row['extra_line'] . '</span>';
							}
							?>
						</td>
                     </tr>   
					<?php 
					$i++; ?>
					
				<?php	} ?> 
					
				<?php }
				?> 
    		</table>
                <span id="moretocome_box">
                    <p>...and more to come...</p>
                </span>
            </div>
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
