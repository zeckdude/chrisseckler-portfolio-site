<?php 
session_start();
ob_start();
date_default_timezone_set('America/Los_Angeles');

header('Content-type: text/html; charset=utf-8');





if(isset($_SESSION['ordering_mode'])) {
	session_destroy();	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Applied Materials Order Form</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" href="images/favicon.ico" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>





<body>

<?php
include("includes/connection.php");
$conn = dbConnect("admin");

$done = false;

foreach($_SESSION as $key => $value) {
	if(is_array($value)) continue; //This skips the current session variable if it is an array
	if($key == 'ordering_step') continue; //This skips the current session variable if it is named 'ordering_step'
	$_SESSION[$key] = sanitize($conn, $value); //This sanitizes the current session variable and then saves it back as the same session variable name
}

if(!isset($_GET['employee_id']) || !isset($_GET['order_id'])) {
	header('Location: index.php');											  
}

$conn->query('SET NAMES utf8');

//Get address
$sql = "SELECT *, UNIX_TIMESTAMP('date_submitted')
		FROM orders
		WHERE order_id = '" . $_GET['order_id'] . "' AND employee_id = '" . $_GET['employee_id'] . "'";

$result = $conn->query($sql) or die(mysqli_error());

$row = $result->fetch_assoc();

$_SESSION["order_id"] = $row['order_id'];
$_SESSION["order_num"] = $row['order_id'];
$_SESSION["full_name"] = $row['full_name'];
$_SESSION["first_name"] = $row['first_name'];
$_SESSION["last_name"] = $row['last_name'];
$_SESSION["title"] = $row['title'];
$_SESSION["title_2"] = $row['title_2'];
$_SESSION["dept_div"] = $row['dept_div'];
$_SESSION["dept_div_2"] = $row['dept_div_2'];
$_SESSION["approved_by"] = $row['approved_by'];
$_SESSION["employee_id"] = $row['employee_id'];
$_SESSION["email_language_proof"] = $row['email_language_proof'];

$_SESSION["phone_symbol"] = $row['phone_symbol'];
$_SESSION["phone_int_prefix"] = $row['phone_int_prefix'];
$_SESSION["phone_prefix"] = $row['phone_prefix'];
$_SESSION["phone_first"] = $row['phone_first'];
$_SESSION["phone_last"] = $row['phone_last'];
$_SESSION["fax_int_prefix"] = $row['fax_int_prefix'];
$_SESSION["fax_prefix"] = $row['fax_prefix'];
$_SESSION["fax_first"] = $row['fax_first'];
$_SESSION["fax_last"] = $row['fax_last'];

$_SESSION["email"] = $row['email'];
$_SESSION["mail_stop"] = $row['mail_stop'];
$_SESSION["address"] = $row['building_id'];
$_SESSION['non_us_phone'] = $row['non_us_phone'];
$_SESSION['non_us_fax'] = $row['non_us_fax'];
$_SESSION['no_address'] = $row['no_address'];

$_SESSION['status'] = $row['status'];
$_SESSION['date_submitted'] = $row['date_submitted'];

$_SESSION['special_instructions'] = $row['special_instructions'];

$_SESSION['english_quantity'] = $row['english_quantity'];
$_SESSION['foreign_quantity'] = $row['foreign_quantity'];

if($row['english_quantity'] != '' && $row['english_quantity'] > 0) {
	$_SESSION['english_cards_ordered'] = 'yes';
} else {
	$_SESSION['english_cards_ordered'] = 'no';
}

if($row['foreign_quantity'] != '' && $row['foreign_quantity'] > 0) {
	$_SESSION['foreign_cards_ordered'] = 'yes';
} else {
	$_SESSION['foreign_cards_ordered'] = 'no';
}


$_SESSION['notepad_size_425x55'] = $row['notepad_size_425x55'];
$_SESSION['notepad_size_55x85'] = $row['notepad_size_55x85'];

$_SESSION['character_hold'] = $row['character_hold'];
$_SESSION["language"] = $row["language"];
$_SESSION["other_language"] = $row["other_language"];
$_SESSION['upload_location'] = $row["upload_location"];
$_SESSION['dirPath'] = 'upload/' . $_SESSION['upload_location'];
$_SESSION['foreign_characters_name'] = $row['foreign_characters_name'];
$_SESSION['foreign_characters_line2'] = $row['foreign_characters_line2'];
$_SESSION['foreign_characters_line3'] = $row['foreign_characters_line3'];
$_SESSION['foreign_characters_line4'] = $row['foreign_characters_line4'];


if($row['non_us_card'] == 'yes') { //if its a non US card
	$_SESSION["location"] = 'non_us_address';
	$_SESSION["non_us_card"] = 'yes';
} else { //if its a US card
	$_SESSION["location"] = 'us_address';
	$_SESSION["non_us_card"] = 'no';
}





$_SESSION['employee_id'] = $_GET['employee_id'];
$_SESSION['order_id'] = $_GET['order_id'];

if($row['additional_contact_exists'] == 'yes') {	
	$counter = 1;
	$sql = "SELECT *
			FROM contact_numbers
			WHERE order_id = '" . $_GET['order_id'] . "'";	
	
	$result = $conn->query($sql) or die(mysqli_error());
	while($row = $result->fetch_assoc()) {
			$_SESSION['extra_number'][$counter]['additional_contact'] = $row['contact_type'];
			$_SESSION['extra_number'][$counter]['additional_int_prefix'] = $row['int_prefix'];		
			$_SESSION['extra_number'][$counter]['additional_prefix'] = $row['prefix'];
			$_SESSION['extra_number'][$counter]['additional_first'] = $row['first'];
			$_SESSION['extra_number'][$counter]['additional_last'] = $row['last'];
			$_SESSION['extra_number'][$counter]['additional_non_us_number'] = $row['non_us_number'];
			$counter++;
	}
}





if($row['custom_address'] == 'yes') {
	$sql = "SELECT *
			FROM custom_addresses
			WHERE order_id = '" . $_GET['order_id'] . "'";
			
	$result = $conn->query($sql) or die(mysqli_error());
	$row = $result->fetch_assoc();
	
	$_SESSION['other_address'] = 'yes';
	$_SESSION["custom_address_1"] = $row['line_1'];
	$_SESSION["custom_address_2"] = $row['line_2'];
	$_SESSION["custom_city"] = $row['city'];
	$_SESSION["custom_state"] = $row['state'];
	$_SESSION["custom_zip"] = $row['zip_1'];
	$_SESSION["custom_zip_2"] = $row['zip_2'];
}




if($_SESSION["non_us_card"] == 'yes') { //if this is a non us card
	$sql = "SELECT *
			FROM non_us_addresses
			WHERE order_id = '" . $_GET['order_id'] . "'";
			
	$result = $conn->query($sql) or die(mysqli_error());
	$row = $result->fetch_assoc();
	
	$_SESSION["non_us_address_1"] = $row['line_1'];
	$_SESSION["non_us_address_2"] = $row['line_2'];
	$_SESSION["non_us_address_3"] = $row['line_3'];
	$_SESSION["non_us_address_4"] = $row['line_4'];

}


/* //These are the saved session variables
foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop
	//if($value != '') {
		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';
	//}
} */







if(isset($_POST['accept_proof'])){
	
	$_SESSION['custom_proof_accepted'] = 'yes';
	$date_approved = date('Y-m-d H:i:s',time()); //Current Date/time in Unix format
	$approved = 'printing';
	
	$sql = 'UPDATE orders
			SET status = ?
			WHERE order_id = ? 
			AND employee_id = ?';
	
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql)) { 
			$stmt->bind_param('sii', $approved, $_SESSION['order_id'], $_SESSION['employee_id']); 
			$done = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $done
		}
		
		$date_added = date('Y-m-d H:i:s',time());
		
		//This adds the note marking a change in status	
		$notes_sql = 'INSERT into notes SET
				order_id = "'.$_SESSION['order_id'].'",
				date_added = "'.$date_added.'",
				note_message = "'.$note_message['custom_approved'].'"';
				
		$conn->query($notes_sql);
	} //end if accept proof
	
	
	// redirect on success or if $_GET['article_id']) is not defined. This ensures that the page is redirected either if the update succeeds or if someone tries to access the page directly.
	if ($done) { //if $_GET['article_id'] is not defined
	
		//Checks if the order has already been approved and if so, it changes the status to waiting_translator
		if($_SESSION['foreign_cards_ordered'] == 'yes') {	
			$status_sql = 'UPDATE orders
						SET status = "waiting_translator"
						WHERE order_id = ' . $_SESSION['order_id'];
						
			$conn->query($status_sql);	
		}
	
	
		header('Location: custom_thankyou.php');
		exit; //and exit the script	
	}
	
	//display error message if query fails
	if (isset($stmt) && !$done) { //if the prepared statement has been created, but both $OK and $done remain false 
		echo $stmt->error;	// then display an error message on the screen
	}



if(isset($_POST['dont_accept_proof'])){
	
	$_SESSION['custom_proof_accepted'] = 'no';
	$date_not_approved = date('Y-m-d H:i:s',time()); //Current Date/time in Unix format
	$not_approved = 'custom_proof';
	
	$sql = 'UPDATE orders
			SET status = ?
			WHERE order_id = ? 
			AND employee_id = ?';
	
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql)) { 
			$stmt->bind_param('sii', $not_approved, $_SESSION['order_id'], $_SESSION['employee_id']); 
			$done_not_approved = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $done
		}
		
		$date_added = date('Y-m-d H:i:s',time());
		
		//This adds the note marking a change in status		
		$notes_sql = 'INSERT into notes SET
				order_id = "'.$_SESSION['order_id'].'",
				date_added = "'.$date_added.'",
				note_message = "'.$note_message['custom_rejected'].'"';
				
		$conn->query($notes_sql);
		
		
		
			
		header('Location: custom_not_approved.php');
	
		exit;
	
}
?>




<div id="container">


<?php include("includes/header.php"); 


if($_SESSION['status'] == 'waiting_custom_approval') {
?>


	<div class="form_container" id="pdf_container">  
            <div class="row">
            	<div class="clientform_table_header">
                <?php if($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'yes') { ?>
                	Do you accept these proofs?<br /> <span class="warning">These are previews of what your printed business cards will look like. Please accept or deny the proofs.</span>
                <?php } else if(($_SESSION[foreign_cards_ordered] == 'no' && $_SESSION[english_cards_ordered] == 'yes') || ($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'no')) { ?>
                	Do you accept this proof?<br /> <span class="warning">This is preview of what your printed business card will look like. Please accept or deny the proof.</span>
                <?php } ?>
                </div>
			</div>   
        
            <div class="row">
            	<div class="content" style="overflow:hidden;">
                
               
				 <?php if($_SESSION[foreign_cards_ordered] != 'yes' && $_SESSION[english_cards_ordered] == 'yes') { ?>
                
                	<p>
                        <iframe class="iframe" src="custom_upload/<?php echo $_SESSION["order_id"] . '_' . $_SESSION["last_name"]?>/english/english.pdf" width="700px" style="height:38em">
                        [Your browser does <em>not</em> support <code>iframe</code>,
                        or has been configured not to display inline frames.]</iframe>
                    </p>
               <?php } else if($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'yes') { ?>                      
                    <embed src="custom_upload/<?php echo $_SESSION["order_id"] . '_' . $_SESSION["last_name"]?>/english/english.pdf#toolbar=0&navpanes=0&scrollbar=0" width="700" height="375">
                    
                    <embed src="custom_upload/<?php echo $_SESSION["order_id"] . '_' . $_SESSION["last_name"]?>/foreign/foreign.pdf#toolbar=0&navpanes=0&scrollbar=0" width="700" height="375">
               <?php } else if($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] != 'yes') { ?>
               		<p>
                        <iframe class="iframe" src="custom_upload/<?php echo $_SESSION["order_id"] . '_' . $_SESSION["last_name"]?>/foreign/foreign.pdf" width="700px" style="height:38em">
                        [Your browser does <em>not</em> support <code>iframe</code>,
                        or has been configured not to display inline frames.]</iframe>
                    </p>
               <?php } ?>  
				   


                    <p>
                        <form id="proof_form" name="proof_form" method="post" action=""><!-- Begin Form -->
                            <input class="submit prev button" type="submit" name="dont_accept_proof" value="Don't Accept Proof" />	
                            <?php if($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'yes') { ?>
                                <p id="both_proof_desc">These are proofs for your English only and Foreign card(English side)</p>
                            <?php } else if($_SESSION[foreign_cards_ordered] == 'no' && $_SESSION[english_cards_ordered] == 'yes') { ?>
                                <p id="english_proof_desc">This is a proof for your English only card</p>
                            <?php } else if($_SESSION[foreign_cards_ordered] == 'yes' && $_SESSION[english_cards_ordered] == 'no') {?>
                            	<p id="english_proof_desc">This is a proof for your Foreign card(English Side)</p>
                            <?php } ?>
                             
                            <input class="submit next button" type="submit" name="accept_proof" value="Accept Proof" />
                        </form><!-- End Form -->
                    </p>
            	</div>
            </div>
    </div> 
    
<?php } else { ?>

	<div class="form_container" id="thank_you_box">  
        <div class="row">
            <div class="clientform_table_header">This order has already been reviewed</div>   
        </div>
        
        <div class="row">
            <div class="content">
                <p>The order for <?php echo $_SESSION["first_name"] . ' ' . $_SESSION["last_name"]; ?> has already been reviewed and has been <?php if($_SESSION['status'] == 'custom_proof') {echo 'rejected pending changes';} else {echo 'approved';} ?>.</p>
			</div>
          </div>       
         
        <div class="row">
            <div class="content" id="thankyou_last_content_1"><a class="button prev" href="index.php">Back to the AMAT Order Form</a></div>
		</div>
    </div>




<?php } ?>    
    
    
	 
</div>

</body>

</html>