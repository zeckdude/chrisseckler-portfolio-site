<?php

session_start();

ob_start();



//These are the values for each of the tooltips

$employee_id = "<p class='tip_title'>Employee ID</p><p>This is where you enter your Employee ID number<p><br /><p>If you have ordered on this form before, the system will find and insert your information based on the last order you made</p>";

$approved_by = "<p class='tip_title'>Approved By</p>This is where you enter the email address of the Manager who approves your order";

$delivery_bldg = "<p class='tip_title'>Delivery Bldg.</p><p>This is where you enter the building number that the card should be delivered to.</p><br/><p>This only applies to deliveries made to Silicon Valley locations</p>";

$delivery_email = "<p class='tip_title'>Delivery Contact Email</p><p>This is where you enter the email of the person to who the cards will be delivered to</p>";



/*//These are the saved session variables

foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop

	//if($value != '') {

		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

	//}

} */



$_SESSION['ordering_mode'] = 'on';



//This code ensures that you have been to this page or page before it, so you can't manually type in the url without being redirected

if(!isset($_SESSION['ordering_step']) || $_SESSION['ordering_step'] < 2) {//if the ordering step has not been created or is less than the current page ordering step, because someone manually typed it in without having been to the index page

	header('Location: index.php');

}





//echo 'ordering step: ' . $_SESSION['ordering_step'];

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Order Form - Choose your Location</title>

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

<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>

<script src="js/jquery.qtip.js" type="text/javascript"></script>







<script>

      $(document).ready(function(){





		//This brings back all elements for browsers with javaScript enabled

		$(".hidden-nojs").show();

		$("#js_warning").hide();





		//TOOLTIPS					 

           // Match all link elements with href attributes within the content div

		   

		   //Tooltip Settings

		   $.fn.qtip.styles.tooltipStyle = { // This is global style for all tooltips

			   width: 200,

                  padding: 10,

                  background: '#FFFFFF',

                  color: 'black',

                  textAlign: 'left',

                  border: {

                     width: 2,

                     radius: 0,

                     color: '#5C7F99'

                  },

			   name: 'dark' 

			}

			

			

			$('[tooltip]').each(function() // Select all elements with the "tooltip" attribute

			{

			   $(this).qtip({ 

					content: $(this).attr('tooltip'), 

					style: 'tooltipStyle',

					position: {

						corner: {

						   target: 'rightMiddle',

						   tooltip: 'leftMiddle'

						}

					 }, //end position

					 

					 show: { when: { event: 'click' } },

					 hide: { when: { event: 'mouseout' } }

				}); // Retrieve the tooltip attribute value from the current element

			});

	  

	  

	  	 $('input[type="text"]').focus(function()

		 {

			$(this).select();	

		 });

	  

	  

	  

	  

    }); //end document ready

    

	

    

    function stopRKey(evt) { //disables enter key to submit form

      var evt = (evt) ? evt : ((event) ? event : null);

      var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);

      if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}

    }

    

    document.onkeypress = stopRKey; 

</script>





</head>











<body>







<?php include("includes/connection.php");



if(isset($_POST['us_address'])){ 



	$_SESSION['location'] = 'us_address';

	

	if($_SESSION['ordering_step'] == 2) { //if the ordering step is set to 2, then make it 3

		$_SESSION['ordering_step']++;	

	}

	

	header('Location: card_details.php');

	exit;		

} //end if isset post us_address



if(isset($_POST['non_us_address'])){

	

	$_SESSION['location'] = 'non_us_address';

	

	if($_SESSION['ordering_step'] == 2) { //if the ordering step is set to 2, then make it 3

		$_SESSION['ordering_step']++;	

	}

	

	header('Location: card_details_non_us.php');

	exit;		

} //end if isset post us_address



if(isset($_POST['location_prev'])){ 		

	header('Location: language_options.php');

	exit;		

} //end if isset post us_address

        

?>









<div id="container">





<?php 

	include("includes/header.php");

	include("includes/js_warning.php");

?>









    <form id="clientForm" name="clientForm" method="post" action=""><!-- Begin Form -->

        <div class="form_container" id="location_details">  

            <div class="row">

                <div class="clientform_table_header">Choose your Location</span></div>   

            </div>

            

            

            <div class="row" style="overflow:hidden;">

                <div class="content" id="location_text">  

                	<span>My business card is for</span>

                </div>

                

               <div class="content" id="location_buttons">  

                	<input class="button prev submit" id="us_address_submit" type="submit" name="us_address" value="A US Address" />

                	<input class="button submit" id="non_us_address_submit" type="submit" name="non_us_address" value="A non US address" />

                </div>

            </div>

            

            <div class="row">

                <div class="content"><input class="button prev submit" type="submit" name="location_prev" value="Previous Step" /></div>  

            </div>    

        </div>  

    

    </form><!-- End Form --> 

</div>



</body>



</html>