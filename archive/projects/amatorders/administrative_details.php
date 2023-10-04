<?php  session_start();

ob_start();

//These are the values for each of the tooltips

$employee_id_tip = "<p class='tip_title'>Employee ID</p><p>This is where you enter the Employee ID number of the person who's card is being printed<p><br /><p>If you have ordered on this form before, the system will find and insert the card information based on the last order made with this Employee ID number</p>";

$approved_by_tip = "<p class='tip_title'>Approved By</p>This is where you enter the email address of the Manager who approves your order";

$delivery_bldg_tip = "<p class='tip_title'>Delivery Bldg.</p><p>This is where you enter the building number that the card should be delivered to.</p><br/><p>This only applies to deliveries made to Silicon Valley locations</p>";

$delivery_email_tip = "<p class='tip_title'>Delivery Contact Email</p><p>This is where you enter the email of the person to who the cards will be delivered to</p>";



$_SESSION['ordering_mode'] = 'on';

$_SESSION['custom_proof_requested'] = 'no'

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Order Form - Administrative Details</title>

<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />

<!--//////////  FOR USERS WITH INTERNET EXPLORER 6  //////////-->
<!--[if IE 6]>
        <link rel="stylesheet" type="text/css" href="css/ie6.css" />
<![endif]-->

<style type="text/css">
* { behavior: url(css/iepngfix.htc) }
</style> 
<!--//////////  FOR USERS WITH INTERNET EXPLORER 6  //////////-->


<link rel="shortcut icon" href="images/favicon.gif" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />







<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>

<script src="js/jquery.qtip.js" type="text/javascript"></script>

<script src="js/validation.js" type="text/javascript"></script>





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









<script type="text/javascript" src="js/ajax.js"></script>

<script type="text/javascript">

	function ajaxCallBack() {

											

		$(".error").hide(); //hide all errors

		

		

		

		

		

		var employeeId = $("#employee_id").val();

		if(employeeId == '') {

			$("#employee_id").after('<div id="employee_id_error" class="error">Your employee id number is required.</div>');

			

		}

		

		var costCenter = $("#cost_center").val();

		if(costCenter == '') {

			$("#cost_center").after('<div id="cost_center_error" class="error">Your cost center number is required.</div>');

			

		}

		

		var approvedBy = $("#approved_by").val();

		if(approvedBy == '') {

			$("#manager_warning").after('<div id="approved_by_error" class="error">The approving managers email is required.</div>');

			

		} /*
else if(!emailReg.test(approvedBy)) {

			$("#manager_warning").after('<div id="approved_by_error" class="error">Enter a valid Email.</div>');

		

		}
*/

		

		var deliveryEmail = $("#delivery_email").val();

		if(deliveryEmail == '') {

			$("#delivery_email").after('<div id="delivery_email_error" class="error">The delivery contact email is required.</div>');

		

		} /*
else if(!emailReg.test(deliveryEmail)) {

			$("#delivery_email").after('<div id="delivery_email_error" class="error">Enter a valid Email.</div>');

		

		}
*/

		

		var ext = $("#ext").val();

		if(ext == '') {

			$("#ext").after('<div id="ext_error" class="error">The delivery contact extension is required.</div>');

	

		}	

	}



/************************************************************************************************************

Ajax client lookup

Copyright (C) 2006  DTHMLGoodies.com, Alf Magne Kalleland



************************************************************************************************************/    

var ajax = new sack();

var currentClientID=false;

function getClientData()

{

    var clientId = document.getElementById('employee_id').value;

    if(clientId.length > 3 && clientId.length < 7){

        currentClientID = clientId;

        ajax.requestFile = 'getClient.php?getClientId='+clientId;    // Specifying which file to get

        ajax.onCompletion = showClientData;    // Specify function that will be executed after file has been found

        ajax.runAJAX();        // Execute AJAX function

		//ajaxCallBack();

		setTimeout(ajaxCallBack, 300);

    } 

}





function showClientData()

{

    var formObj = document.forms['clientForm'];    

    eval(ajax.response);







}





function initFormEvents()

{

    document.getElementById('employee_id').onblur = getClientData; // If you wish to have a lookup when you click or tab off the field

    //document.getElementById('employee_id').onkeyup = getClientData; // If you wish to have a lookup "as you type"
	
    document.getElementById('employee_id').focus();

}



window.onload = initFormEvents;









</script>











</head>











<body>







<?php include("includes/connection.php");



$conn = dbConnect("admin"); 

$done = false;





if(isset($_POST['index_next'])){ 



	$has_error = false;

	$error_array = array();

	$email_reg_expr = '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$';

	$num_reg_expr = '/^[0-9]*$/';

	//Function to check whether a string is an integer

	function isint( $mixed )

	{

		return ( preg_match( '/^\d*$/'  , $mixed) == 1 );

	}

	

	

	//PHP Validation

	if($_POST['employee_id'] == '') {

		$employee_id_error = '<div id="employee_id_error" class="error">Your employee id number is required.</div>';

		$error_array['employee_id_error'] = true;

	}

	

	if($_POST['cost_center'] == '') {

		$cost_center_error = '<div id="cost_center_error" class="error">Your cost center number is required.</div>';

		$error_array['cost_center_error'] = true;

	}

	

	if($_POST['approved_by'] == '') {

		$approved_by_error = '<div id="approved_by_error" class="error">The approving managers email is required.</div>';

		$error_array['approved_by_error'] = true;

	} /*
else if(!eregi($email_reg_expr, $_POST['approved_by'])) {

		$approved_by_error = '<div id="approved_by_error" class="error">Enter a valid Email.</div>';

		$error_array['approved_by_error'] = true;

	}
*/

	

	if($_POST['delivery_bldg'] != '') {

		if(!isint($_POST['delivery_bldg'])) {

			$delivery_bldg_error = '<div id="delivery_bldg_integer_error" class="error">Only numbers are allowed.</div>';

			$error_array['delivery_bldg_error'] = true;

		}

	}

	

	

	if($_POST['delivery_email'] == '') {

		$delivery_email_error = '<div id="delivery_email_error" class="error">The delivery contact email is required.</div>';

		$error_array['delivery_email_error'] = true;

	} /*
else if(!eregi($email_reg_expr, $_POST['delivery_email'])) {

		$delivery_email_error = '<div id="delivery_email_error" class="error">Enter a valid Email.</div>';

		$error_array['delivery_email_error'] = true;

	}
*/

	

	if($_POST['ext'] == '') {

		$ext_error = '<div id="ext_error" class="error">The delivery contact extension is required.</div>';

		$error_array['ext_error'] = true;

	} else if(!isint($_POST['ext'])) {

		$ext_error = '<div id="ext_integer_error" class="error">Only numbers are allowed.</div>';

		$error_array['ext_error'] = true;

	}



	if(in_array(true, $error_array)) {

		$has_error = true;

	}

	

	if($has_error != true) { //If there is no error, then save the values and go to the next page

		

		//Administrative Details

		$_SESSION["employee_id"] = $_POST['employee_id'];

		$_SESSION["cost_center"] = $_POST['cost_center'];

		$_SESSION["approved_by"] = $_POST['approved_by'];

		$_SESSION["delivery_bldg"] = $_POST['delivery_bldg'];

		$_SESSION["delivery_email"] = $_POST['delivery_email'];

		$_SESSION["ext"] = $_POST['ext'];

		

		$_SESSION['ordering_step'] = 1;

		

		header('Location: language_options.php');

		

		exit;

	}

		

} //end if isset post index next

        

?>









<div id="container">





<?php 

	include("includes/header.php");

	include("includes/js_warning.php");

?>



    <form id="clientForm" name="clientForm" method="post" action=""><!-- Begin Form -->

        <div class="form_container" id="admin_details">  

            <div class="row">

                <div class="clientform_table_header" style="width: 331px;">Administrative Details<br /><span class="warning">The following information must be provided in full or your order cannot be processed</span></div>   

            </div>

            

            

            <div class="row">

                <div class="content">  

                <label for="employee_id">Employee ID #</label> <span class="tooltip hidden-nojs" style="display:none;" tooltip="<?php echo $employee_id_tip; ?>"> </span>



                <br />

                <input id="employee_id" name="employee_id" class="validate['required']" type="text" value="<?php if(isset($_POST['employee_id'])) {echo $_POST['employee_id'];} else{echo $_SESSION["employee_id"];} ?>"/> 

                <?php if(isset($employee_id_error)) { echo $employee_id_error; } ?> 

                </div>

                

                <div class="content">  

                <label for="cost_center">Cost Center #</label>

                <br />

                <input id="cost_center" name="cost_center" class="text" type="text" value="<?php if(isset($_POST['cost_center'])) {echo $_POST['cost_center'];} else{echo $_SESSION["cost_center"];} ?>"/> 

                <?php if(isset($cost_center_error)) { echo $cost_center_error; } ?>  

                </div>

            </div>

            

            <div class="row">  

                <div class="content" id="approved_by_content">  

                <label for="approved_by">Approved by</label> <span class="tooltip hidden-nojs" style="display:none;" tooltip="<?php echo $approved_by_tip; ?>"> </span>

                <br />  

                <input id="approved_by" name="approved_by" class="text" type="text" value="<?php if(isset($_POST['approved_by'])) {echo $_POST['approved_by'];} else{echo $_SESSION["approved_by"];} ?>"/>

                <p id="manager_warning" class="warning">(Manager e-mail)</p>

                <?php if(isset($approved_by_error)) { echo $approved_by_error; } ?>   

                </div> 

                

                <div class="content">  

                <label for="delivery_bldg">Delivery Bldg. #</label> <span class="tooltip hidden-nojs" style="display:none;" tooltip="<?php echo $delivery_bldg_tip; ?>"> </span>

                <br />   

                <input id="delivery_bldg" name="delivery_bldg" class="text" type="text" value="<?php if(isset($_POST['delivery_bldg'])) {echo $_POST['delivery_bldg'];} else{echo $_SESSION["delivery_bldg"];} ?>"/> 

                <p id="bldg_warning" class="warning">(Silicon Valley locations only)</p>

                <?php if(isset($delivery_bldg_error)) { echo $delivery_bldg_error; } ?> 

                </div>

            </div>

            

            <div class="row">    

                <div class="content">  

                <label for="delivery_email">Delivery Contact Email</label> <span class="tooltip hidden-nojs" style="display:none;" tooltip="<?php echo $delivery_email_tip; ?>"> </span>

                <br />  

                <input id="delivery_email" name="delivery_email" class="text" type="text" value="<?php if(isset($_POST['delivery_email'])) {echo $_POST['delivery_email'];} else{echo $_SESSION["delivery_email"];} ?>"/>

                <?php if(isset($delivery_email_error)) { echo $delivery_email_error; } ?>  

                </div>

                

                <div class="content">  

                <label for="ext">Delivery Contact Ext. #</label>

                <br />  

                <input id="ext" name="ext" class="text" type="text" value="<?php if(isset($_POST['ext'])) {echo $_POST['ext'];} else{echo $_SESSION["ext"];} ?>"/> 

                <?php if(isset($ext_error)) { echo $ext_error; } ?>  

                </div>

            </div>

            

            <div class="row">

                <div class="content" id="last_content"><input class="button next submit" id="index_submit" type="submit" name="index_next" value="Next Step" /></div>

            </div>

            

            

            

        </div>  

          



        

    

    

    </form><!-- End Form --> 

</div>



</body>



</html>