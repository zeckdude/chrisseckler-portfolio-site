<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Foreign Character Test</title>
</head>                                                     
<body>                                                                                                                  
<?php
    error_reporting(E_ALL);
    $db = mysqli_connect('localhost', 'ideapale_fc', 'foreign', 'ideapale_fcharacters');
    
    $sql = 'SELECT * FROM text';
    $results = mysqli_query($db, $sql);
    print_r(mysqli_fetch_assoc($results));
    
	echo '<br/><br/>';
	
	
	
	
	
	
	
	
	$conn = new mysqli('localhost', 'ideapale_fc', 'foreign', 'ideapale_fcharacters') or die('Cannot open database');
	
    //mysqli_query($db, 'SET NAMES utf8');
    $conn->query('SET NAMES utf8');
    
    $sql = 'SELECT * FROM text';
	
	
    //$results = mysqli_query($db, $sql);
    //print_r(mysqli_fetch_assoc($results));
	
	$results = $conn->query($sql) or die(mysqli_error());
	//print_r($results->fetch_assoc());
	//$row = $results->fetch_assoc();
	
	echo '<br/><br/>';
	
	while($row = $results->fetch_assoc()) {
		echo 'The current name is ' . $row['names'] . '<br/>';
	}
	
	
	
	
	
    ?>

</body>
</html>