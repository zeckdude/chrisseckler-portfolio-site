<?php

include("includes/connection.php");
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('query');

$photographer_sql = "SELECT photographers.photographer_name
		FROM photographers
		ORDER BY photographer_name ASC";
		
$style_sql = "SELECT style_name
		FROM styles
		ORDER BY style_name ASC";
		
$type_sql = "SELECT type_name
		FROM types
		ORDER BY type_name ASC";
		
$photographer_result = $conn->query($photographer_sql) or die(mysqli_error());
$style_result = $conn->query($style_sql) or die(mysqli_error());
$type_result = $conn->query($type_sql) or die(mysqli_error());

$photographer_array = array();
$style_array = array();
$type_array = array();

while($photographer_row = $photographer_result->fetch_assoc()) {
$photographer_array[] = $photographer_row['photographer_name'];
}

while($style_row = $style_result->fetch_assoc()) {
$style_array[] = $style_row['style_name'];
}

while($type_row = $type_result->fetch_assoc()) {
$type_array[] = $type_row['type_name'];
}




		

$expectedValues = array("photographers.photographer_name", "style_name", "type_name");

//$selectionArr['photographer_name'] = array('Alberto Korda', 'Annie Leibowitz', 'Ansel Adams');
$selectionArr['photographers.photographer_name'] = $photographer_array;
$selectionArr['style_name'] = $style_array;
$selectionArr['type_name'] = $type_array;




//$selectionArr['style_name'] = array('Photo Journalism', 'Macro', 'B&W');
//$selectionArr['type_name'] = array('Metallic Print', 'Polaroid');

if (isset($_REQUEST['data']) and in_array($_REQUEST['data'], $expectedValues)){
    $selectedArr = $selectionArr[$_REQUEST['data']];

    foreach($selectedArr as $optionValue){ ?>
        <option <?php if($_POST['filterby'] == $optionValue) { echo 'selected';}?>><?php echo $optionValue; ?></option>;
  <?php }
}

?>