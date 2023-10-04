
<?php
include("../includes/connection.php");
$conn = dbConnect("admin");


//Get address
/*$building_sql = "SELECT *
				FROM buildings
				WHERE building_id = '" . $row['building_id'] . "'";*/
				
$building_sql = "SELECT *
				FROM buildings
				WHERE building_id = 23";

$building_result = $conn->query($building_sql) or die(mysqli_error());

$building_row = $building_result->fetch_assoc();

if(isset($_SESSION['mail_stop']) && $_SESSION['mail_stop'] != '' && $_SESSION['mail_stop'] != 0) { 
	$mail_stop = ', M/S ' . $_SESSION['mail_stop'];
}

if($building_row['zip_2'] != '' && $building_row['zip_2'] != 0) {
	$zip_code = $building_row['zip_1'] . '-' . $building_row['zip_2'];	
} else {
	$zip_code = $building_row['zip_1'];	
}

$address_line_1 = $building_row['address'] . $mail_stop;
if($building_row['po_box'] != '' && $building_row['po_box'] != 0) {
	$address_line_2 = 'P.O. Box ' . $building_row['po_box'];
}
$address_line_3 = $building_row['city'] . ', ' . $building_row['state'] . ' ' . $zip_code;




echo 'This is the address: ' . $address_line_1;
?>