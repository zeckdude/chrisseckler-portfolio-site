<?php
$host = "localhost";
$site_name = "Vacation Showcase";
$site_basedir = "http://www.dynamicpalette.com/projects/vacation_showcase/";

function dbConnect($type) {
	  // Connection code goes here
	  if ($type  == 'query') { 
		$user = 'ideapale_vsquery';
		$pwd = 'vspass';
		
		}
	  elseif ($type == 'admin') {
		$user = 'ideapale_vsadmin';
		$pwd = 'vspass';
		}
	  else {
		exit('Unrecognized connection type');
		}
	  $conn = new mysqli('localhost', $user, $pwd, 'ideapale_vacations') or die ('Cannot open database');
	  
	  return $conn; 
	}


?>
