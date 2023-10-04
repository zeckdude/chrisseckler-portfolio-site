<?php
$site_name = "Pro Print & Services";
$site_basedir = "http://www.dynamicpalette.com/projects/pro_print/";

function dbConnect($type) {
	  // Connection code goes here
	  if ($type  == 'query') { 
		$user = 'ppquery';
		$pwd = 'pppass';
		
		}
	  elseif ($type == 'admin') {
		$user = 'ppadmin';
		$pwd = 'pppass';
		}
	  else {
		exit('Unrecognized connection type');
		}
	  $conn = new mysqli('localhost', $user, $pwd, 'pro_print') or die ('Cannot open database');
	  
	  return $conn; 
	}


?>
