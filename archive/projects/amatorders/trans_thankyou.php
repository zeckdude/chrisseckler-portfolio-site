<?php

session_start();

ob_start();





date_default_timezone_set('America/Los_Angeles');



/*DEBUGGING*/

/*foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop

	//if($value != '') {

		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

	//}

} */

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Order Form</title>

<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="shortcut icon" href="images/favicon.gif" />

<!--//////////  FOR USERS WITH INTERNET EXPLORER 6  //////////-->
<!--[if IE 6]>
        <link rel="stylesheet" type="text/css" href="css/ie6.css" />
<![endif]-->

<style type="text/css">
* { behavior: url(css/iepngfix.htc) }
</style> 
<!--//////////  FOR USERS WITH INTERNET EXPLORER 6  //////////-->

</head>











<body>





<div id="container">





<?php



if($_SESSION['trans_proof_accepted'] != 'yes') {

		header('Location: index.php');

}



include("includes/connection.php");

include("includes/header.php");

$conn = dbConnect("admin");







?>



    <div class="form_container" id="thank_you_box">  

        <div class="row">

            <div class="clientform_table_header">Thank you for approving the Translation Proof</div>   

        </div>

        

        <div class="row">

            <div class="content">

                <p>The order for <?php echo $_SESSION["first_name"] . ' ' . $_SESSION["last_name"]; ?> has been sent to our printing department.</p>

			</div>

          </div>       

         

        <div class="row">

            <div class="content" id="thankyou_last_content_1"><a class="button prev" href="index.php">AMAT Order Form</a></div>	

		</div>

    </div> 

     

    <?php 



		$date_added = date('Y-m-d H:i:s',time());

		

		//This adds the note marking a change in status	

		$notes_sql = 'INSERT into notes SET

				order_id = "'.$_SESSION['order_id'].'",

				date_added = "'.$date_added.'",

				note_message = "'.$note_message['ready_print'].'"';

				

		$conn->query($notes_sql);

	

	

	

	session_destroy(); //destroys all the session variables now that we dont need them anymore 

	?>      

		 

</div>



</body>



</html>