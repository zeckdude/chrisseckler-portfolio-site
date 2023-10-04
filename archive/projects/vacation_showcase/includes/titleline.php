<?php 
	
	$conn = dbConnect('query');
	
	$titlesql = 'SELECT *
			FROM home_page';
	
	//This is sending the request to the database and saving the results in $result
	$titleresult = $conn->query($titlesql) or die(mysqli_error());
	$titlerow = $titleresult->fetch_assoc();
	
	//$date = date("m/d/y", $titlerow['date']);
	$date = $titlerow['date'];
	$location = $titlerow['location'];
	
	echo 'Vacation Showcase - ' . $date . ' - ' . $location;
	
?>

