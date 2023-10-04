<?php
session_start();
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Applied Materials Order Form - Character Test</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>





<body>



<?php 


include("includes/connection.php");

$conn = dbConnect("query"); 

//This is needed to view the foreign characters on the page
$utf_sql = 'SET NAMES utf8'; 
$conn->query($utf_sql); 


?>




<div id="container">


<?php

$sql = 'SELECT *
		FROM orders 
		WHERE order_id = 163';
	
	$result = $conn->query($sql) or die(mysqli_error());
	$row = $result->fetch_assoc();

echo '<p>Foreign Characters: ' . $row['characters_supplied'] . '</p>';
?>
          
		 
</div>

</body>

</html>