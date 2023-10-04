<?php





date_default_timezone_set('America/Los_Angeles');



//ini_set('session.bug_compat_warn', 0);

//ini_set('session.bug_compat_42', 0);



function dbConnect($type){



	if($type == 'query'){



		$user = 'ideapale_amquery';



		$pwd = 'amatorders';



	}else if($type == 'admin'){



		$user = 'ideapale_amadmin';



		$pwd = 'amatorders';



	}else if($type == 'backup'){



		$user = 'ideapale_ambckup';



		$pwd = 'amatorders';



	}else if($type =='superuser') {

        $user = 'ideapale';



        $pwd = '7393WESTman!!';

        

    }

    else{



		exit('Unrecognized connection type');	



	}



	$conn = new mysqli('localhost', $user, $pwd, 'ideapale_finorders') or die('Cannot open database');



	return $conn;

    

}







function dbClose($conn){



	mysqli_close($conn);	



}







function nukeMagicQuotes() {



  if (get_magic_quotes_gpc()) {



    function stripslashes_deep($value) {



      $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);



      return $value;



      }



    $_POST = array_map('stripslashes_deep', $_POST);



    $_GET = array_map('stripslashes_deep', $_GET);



    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);

	

	$_SESSION = array_map('stripslashes_deep', $_SESSION);



    }



}





function sanitize($conn, $term) {

	trim($term);

	mysqli_real_escape_string($conn, $term);

	return $term;

}







/*Common URLS to use that may change in the future*/

$site_name = 'AMAT Order Tracker';

$site_basedir = "http://www.dynamicpalette.com/projects/amatorders/";

$pro_print_url = "http://www.foreignpro.com";



$currentPage = basename($_SERVER['SCRIPT_NAME']);



$db_name = 'ideapale_finorders';





/*Common Emails to use that may change in the future*/
$pro_print_email = 'customersupportamat@sprynet.com'; //Official Pro Print Email
$translator_email = 'kloh318@aol.com'; //Official Translator Email

//$pro_print_email = 'chrisseckler@gmail.com'; //Test Pro Print Email
//$translator_email = 'zeckdude@gmail.com'; //Test Translator Email

//$translator_email = 'klohtrans@gmail.com';
//$translator_email = 'chrisseckler@gmail.com';




/*Text to use in the section for various steps in ordering process*/

$note_message = array();

$note_message['order_started'] = 'Order initiated by Customer';

$note_message['custom_proof'] = 'Custom proof requested';

$note_message['waiting_approval'] = 'Order sent to Manager for approval';

$note_message['manager_approved'] = 'Order approved by Manager';

$note_message['manager_rejected'] = 'Order rejected by Manager - Not Authorized';

$note_message['manager_changes'] = 'Order rejected by Manager - Changes Needed';

$note_message['artwork_uploaded'] = 'User supplied own foreign character artwork';

$note_message['characters_supplied'] = 'User typed in own foreign characters';

$note_message['hold_for_artwork'] = 'Order put on hold. Waiting for foreign character upload';

$note_message['sent_translator'] = 'Order sent to Translator';

$note_message['no_artwork_upload'] = 'User decided not to supply any foreign characters';

$note_message['trans_uploaded'] = 'Translator uploaded artwork';

$note_message['waiting_trans_approval'] = 'Order sent to user for translation approval';

$note_message['trans_approved'] = 'Translation proof approved';

$note_message['trans_rejected'] = 'Translation proof rejected. Correction instructions provided by the user';

$note_message['ready_print'] = 'Order ready for Print';

$note_message['sent_trans_corrections'] = 'Order sent to Translator for additional corrections';

$note_message['custom_uploaded'] = 'Pro Print uploaded the custom proof';

$note_message['waiting_custom_approval'] = 'Order sent to user for custom proof approval';

$note_message['custom_approved'] = 'Custom proof approved';

$note_message['custom_rejected'] = 'Custom proof rejected. Correction instructions provided by the user';

$note_message['sent_custom_corrections'] = 'Order sent to Pro Print for additional corrections';

$note_message['sent_manager_corrections'] = 'Order sent to Pro Print for additional corrections';

$note_message['corrections_complete'] = 'Pro Print made the necessary corrections';

$note_message['waiting_upload'] = 'Waiting for foreign characters from admin. Order on hold.';

















































?>