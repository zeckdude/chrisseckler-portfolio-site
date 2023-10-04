<?php 
session_start();
	include("../includes/connection.php");
	
	if(!isset($_SESSION['authenticated_vs'])){
	header('Location: ' . $site_basedir . 'login.php');
	}

	$conn = dbConnect('admin');

	
	//This is a variable that will be used later. For now, it must be false until something happens
	$inserted = false;

	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('admin');
	
	




	//This is what sends the form information to the database
	if (array_key_exists('insert', $_POST)) { //This checks to see that someone clicked on the button with the name 'insert'
		
		 
		
			//This tells the database which fields in the database are going to be inserted
			$sql = 'INSERT INTO participants (name, description, extra_line, link)
					VALUES(?, ?, ?, ?)'; //This is a secure way of transferring information and you must put the same amount of question marks here as you put number of fields on the last line
			
			//This starts the prepared statement which is a secure way of sending information
			$stmt = $conn->stmt_init();
			if ($stmt->prepare($sql)) {
				//This is where you specify what types of information and what fields you want to have inserted into the fields you mentioned on line 22. These must be in the same order so they are inserted into the correct database column
				$stmt->bind_param('ssss', $_POST['name'], $_POST['description'], $_POST['extra_line'], $_POST['link']); 
				$inserted = $stmt->execute(); //This runs the insertion and saves whether it worked or not in $inserted
			}

		//redirect if successful
		if ($inserted == true) { //This checks if $inserted is true, which it should be once you entered information into the database
			header('Location: ' . $site_basedir .'admin/participants_edit_list.php'); //If information was inserted into the database, then go to this page
			}
			
		else { //if it doesn't execute correctly
			echo $stmt->error; // then display an error message on the screen
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
        
        <div class="back"><a href="participants_edit_list.php">Back</a></div>
        <div class="logout"><a href="../includes/logout.php">Logout</a></div>
        <!--EDITABLE-->
        <div id="adminenter_box">
        	<p>
        		You are adding a new Vendor
        	</p>
        </div>

        
        <div class="content_area">
        	<form id="newphotoform" name="form1" method="post" action="">
            
            	
                    <table id="form_table">
                        <tr>
                            <th>Vendor:</th>
                            <td><input name="name" type="text" id="vendor_name" value=""/></td>
                        </tr>
                        
                        <tr>
                            <th>Description:</th>
                            <td><textarea rows=”12″ cols=”64″ wrap="hard" name="description" type="text" id="vendor_description"/></textarea></td>
                        </tr>
                        
                        <tr>
                            <th>Caption:</th>
                            <td><input name="extra_line" type="text" id="extra_line" value=""/></td>
                        </tr>
                        
                        <tr>
                            <th>Web Url Address:</th>
                            <td style="font-size:11px;">http:// <input name="link" type="text" id="link" style="width: 315px;" value=""/></td>
                        </tr>

                        <tr>
                            <th></th>
                            <td>
                                <input class="submit_button" type="submit" name="insert" id="submit" value="Add a new Vendor" />
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
