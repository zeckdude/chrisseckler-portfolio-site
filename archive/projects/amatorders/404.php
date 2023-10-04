<?php
session_start();
ob_start();
date_default_timezone_set('America/Los_Angeles');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Applied Materials Order Form - The page can not be found </title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="images/favicon.gif" />
</head>





<body>


<div id="container">

<?php 

include("includes/connection.php");
include("includes/header.php"); 

?>

    <div class="form_container" id="thank_you_box">  
        <div class="row">
            <div class="clientform_table_header">Oops! The page can not be found</div>   
        </div>
        
        <div class="row">
            <div class="content">
                <p>The page you are looking for cannot be found. Click the back button on your browser to return to your last page.</p>
			</div>
          </div>       
         
        <div class="row">
            <div class="content" id="thankyou_last_content_1"><a class="button prev" href="index.php">AMAT Order Form</a></div>	
		</div>
    </div> 

</div>

</body>

</html>