<?php
$site_name = "Photography Auction";
$site_basedir = "http://www.dynamicpalette.com/projects/photo_auction/";

function dbConnect($type) {
	  // Connection code goes here
	  if ($type  == 'query') { 
		$user = 'ideapale_paquery';
		$pwd = 'papass';
		
		}
	  elseif ($type == 'admin') {
		$user = 'ideapale_paadmin';
		$pwd = 'papass';
		}
	  else {
		exit('Unrecognized connection type');
		}
	  $conn = new mysqli('localhost', $user, $pwd, 'ideapale_auction') or die ('Cannot open database');
	  
	  return $conn; 
	}


?>