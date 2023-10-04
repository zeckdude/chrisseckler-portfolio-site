<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>


<?php
/*// Loads the class
require 'Browscap.php';

// Creates a new Browscap object (loads or creates the cache)
$bc = new Browscap('cache');

// Gets information about the current browser's user agent
$current_browser = $bc->getBrowser();

// Output the result
echo '<pre>'; // some formatting issues ;)
print_r($current_browser);
echo '</pre>';*/


echo $_SERVER['HTTP_USER_AGENT'] . "<br /><br />";
$browser = get_browser(null,true);
print_r($browser);


?>









</body>
</html>