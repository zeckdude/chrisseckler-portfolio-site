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
		
		 
		 	#### Condition for setting start time ####
			#### If hour is 12 am, sets hour to 0 ####
				if($_POST['start_hour'] == 12 && $_POST['start_am_pm'] == 'am'){
					$starthour = 0;
			#### If hour is 12 pm, leaves hour at 12 ####
				}elseif($_POST['start_hour'] == 12 && $_POST['start_am_pm'] == 'pm'){
					$starthour = 12;
			#### If hour is not 12, and is pm, then add 12 to hour, example, 2 pm would be hour 14 [2 + 12] ####
				}elseif($_POST['start_hour'] != 12 && $_POST['start_am_pm'] == 'pm'){
					$starthour = $_POST['start_hour'] + 12;
			#### Any thing else [with am], leave hour as is.  2 am is hour 2 ####
				}else{
					$starthour = $_POST['start_hour'];
				}
			#### Condition for setting end time ####
			#### If hour is 12 am, sets hour to 0 ####
				if($_POST['end_hour'] == 12 && $_POST['end_am_pm'] == 'am'){
					$endhour = 0;
			#### If hour is 12 pm, leaves hour at 12 ####
				}elseif($_POST['end_hour'] == 12 && $_POST['end_am_pm'] == 'pm'){
					$endhour = 12;
			#### If hour is not 12, and is pm, then add 12 to hour, example, 2 pm would be hour 14 [2 + 12] ####
				}elseif($_POST['end_hour'] != 12 && $_POST['end_am_pm'] == 'pm'){
					$endhour = $_POST['end_hour'] + 12;
			#### Any thing else [with am], leave hour as is.  2 am is hour 2 ####
				}else{
					$endhour = $_POST['end_hour'];
				}
			$startTime = $starthour.':'.$_POST["start_min"].':00';
			$endTime = $endhour.':'.$_POST["end_min"].':00';
		 	
		
			//This tells the database which fields in the database are going to be inserted
			$sql = 'INSERT INTO schedule (presenter, startTime, endTime)
					VALUES(?, ?, ?)'; //This is a secure way of transferring information and you must put the same amount of question marks here as you put number of fields on the last line
			
			//This starts the prepared statement which is a secure way of sending information
			$stmt = $conn->stmt_init();
			if ($stmt->prepare($sql)) {
				//This is where you specify what types of information and what fields you want to have inserted into the fields you mentioned on line 22. These must be in the same order so they are inserted into the correct database column
				$stmt->bind_param('sss', $_POST['presenter'], $startTime, $endTime); 
				$inserted = $stmt->execute(); //This runs the insertion and saves whether it worked or not in $inserted
			}

		//redirect if successful
		if ($inserted == true) { //This checks if $inserted is true, which it should be once you entered information into the database
			header('Location: ' . $site_basedir .'admin/schedule_edit_list.php'); //If information was inserted into the database, then go to this page
			}
			
		else { //if it doesn't execute correctly
			echo $stmt->error; // then display an error message on the screen
			}
	}
function leadingZeros($num,$numDigits) {
   return sprintf("%0".$numDigits."d",$num);
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
        
        <div class="back"><a href="schedule_edit_list.php">Back</a></div>
        <div class="logout"><a href="../includes/logout.php">Logout</a></div>
        <!--EDITABLE-->
        <div id="adminenter_box">
        	<p>
        		You are adding a new Presentation
        	</p>
        </div>

        
        <div class="content_area">
        	<form id="newphotoform" name="form1" method="post" action="">
            
            	
                    <table id="form_table">
                        <tr>
                                <th>Presenter:</th>
                                <td><input name="presenter" type="text" id="presenter" value="<?php echo htmlentities($presenter); ?>"/></td>
                        </tr>
                        
                        <tr>
                            <th>Company Name:</th>
                            <td><input name="company_name" type="text" id="company_name_field" value="<?php echo htmlentities($company_name); ?>"/></td>
                        </tr>
                        
                        <tr>
                            <th>Start Time:</th>
                            <td>
                                <select name="start_hour" id="start_hour"> <!--FIRST STARTTIME SELECTBOX - to select the start hour-->
									<?php for($t=1; $t < 13; $t++){?>
                                        <option value="<?php echo $t; ?>" ><?php echo $t; ?></option>
                                	<?php } ?>
                                </select>
                                
                                :
                                
                                <select name="start_min" id="start_min"> <!--SECOND STARTTIME SELECTBOX  - to select the start minutes-->
									<?php for($t=00; $t < 59; $t=$t+5){?>
                                        <option value="<?php echo leadingZeros($t,2); ?>" ><?php echo leadingZeros($t,2); ?></option>
                                    <?php } ?>
                                </select>
                                
                                <select name="start_am_pm" id="start_am_pm"> <!--THIRD STARTTIME SELECTBOX  - to select am or pm-->
                                    <option value="pm" >pm</option>
                                    <option value="am" >am</option>
                                </select>                             
                            </td>
                        </tr>
                        
                        <tr>
                            <th>End Time:</th>
                            <td>
                                <select name="end_hour" id="end_hour"> <!--FIRST STARTTIME SELECTBOX - to select the end hour-->
									<?php for($t=1; $t < 13; $t++){?>
                                        <option value="<?php echo $t; ?>" ><?php echo $t; ?></option>
                                	<?php } ?>
                                </select>
                                
                                :
                                
                                <select name="end_min" id="end_min"> <!--SECOND STARTTIME SELECTBOX  - to select the end minutes-->
									<?php for($t=00; $t < 59; $t=$t+5){?>
                                        <option value="<?php echo leadingZeros($t,2); ?>" ><?php echo leadingZeros($t,2); ?></option>
                                    <?php } ?>
                                </select>
                                
                                <select name="end_am_pm" id="end_am_pm"> <!--THIRD STARTTIME SELECTBOX  - to select am or pm-->
                                    <option value="pm" >pm</option>
                                    <option value="am" >am</option>
                                </select>                            
                            </td>
                        </tr>

                        <tr>
                            <th></th>
                            <td>
                                <input class="submit_button" type="submit" name="insert" id="submit" value="Add a new Presentation" />
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
