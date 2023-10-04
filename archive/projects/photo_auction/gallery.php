<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>My Simple Portfolio</title>
	<link rel="stylesheet" href="css/gallery.css" />
	<script type="text/javascript" src="js/jquery.pack.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
<link rel="shortcut icon" href="../images/favicon.ico" />
</head>
<body>

<div id="container">
	<h1>Some Portfolio</h1>
	<div id="featured">
	<?php
		$featured_dir = 'images/';
		$scan = scandir($featured_dir);
		echo '<img src="' . $featured_dir . $scan[2] . '" alt="image" />';
	?>
	</div><!--end featured-->
	
	<ul id="options">
	
	<?php
	
	$dir = 'images/mini_thumbs/';
	$scan = scandir($dir);	
	
	for ($i = 0; $i<count($scan); $i++) {
		
	if ($scan[$i] != '.' && $scan[$i] != '..') {
		if (strpos($scan[$i], '.jpg') !== false) {
			echo '
				<li>
				<a href="' . $featured_dir . $scan[$i] . '">
				<img src="' . $dir . $scan[$i] . '" alt="' . $scan[$i] . '" />
				</a>
				</li>';
		}
	}
	}; 
	?>
	</ul>
</div><!--end container-->
</body>
</html>
