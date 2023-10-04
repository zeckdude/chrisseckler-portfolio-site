<?php
session_start();
ob_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Applied Materials Order Form</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>





<body>


<?php 

include("../includes/connection.php");
$conn = dbConnect("query"); 






$sql = "SELECT *
			FROM orders 
			WHERE order_id = 548";
	
	$result = $conn->query($sql) or die(mysqli_error());
	$row = $result->fetch_assoc();	

echo 'Upload Location is: ' . $row['upload_location'] . '<br />';

// directory path can be either absolute or relative
$dirPath = '../upload/' . $row['upload_location'];

// open the specified directory and check if it's opened successfully
if ($handle = opendir($dirPath)) {

   // keep reading the directory entries 'til the end
   while (false !== ($file = readdir($handle))) {

	  // just skip the reference to current and parent directory
	  if ($file != "." && $file != "..") {
		 if (is_dir("$dirPath/$file")) {
			// found a directory, do something with it?
			echo "[$file]<br>";
		 } else {
			// found an ordinary file
			echo "<a target='_blank' href='" . $site_basedir . "upload/" . $row['upload_location'] . "/$file'>$file</a><br>";
		 }
	  }
   }

   // ALWAYS remember to close what you opened
   closedir($handle);
}



?>

    

</body>

</html>