<?php

session_start();

ob_start();

/*foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop
		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';
}

echo '<br/>Contact Numbers<br/>';



if($_SESSION['contact']) {

	foreach ($_SESSION['contact'] as $counter => $contact_array) { //This specifies the $_SESSION['order'] array to loop through 
		if($contact_array != '') {
			echo '<br />';
	
			echo $counter;
	
			echo '<br />';
	
			echo 'The contact_array value is: ' . $contact_array;
			foreach ($contact_array as $key => $value) { //This specifies the array within the $_SESSION['order'] array
	
				echo $key . ': ' . $value;
	
				echo '<br />';
	
				//$_SESSION['extra_number'][$counter][$key] = $value;
	
				//$extra_number[$counter][$key] = $value;
	
	
	
			} //end foreach
	
			echo '<br />';
		} //end if contact array != ''

	} //end of outer foreach loop

}*/



//echo $_SESSION['extra_number'][1]['additional_contact'];

echo $extra_number[1]['additional_contact'];

//These are the values for each of the tooltips

$notepad_options = "<p class='tip_title'>Notepad Options</p><p>If you want to order a set of notepads with the name of the person you ordered cards for, please check the appropriate size.</p>";



$_SESSION['ordering_mode'] = 'on';



//This code ensures that you have been to this page or page before it, so you can't manually type in the url without being redirected

if(!isset($_SESSION['ordering_step']) || $_SESSION['ordering_step'] < 4) {//if the ordering step has not been created or is less than the current page ordering step, because someone manually typed it in without having been to the index page

	header('Location: index.php');

}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Order Form - Notepad Options</title>

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



$conn = dbConnect("admin"); 

$done = false;



if(isset($_POST['notepad_prev'])){ 

    

    //Notepad Options

    $_SESSION["notepad_size_425x55"] = $_POST['notepad_size_425x55'];

    $_SESSION["notepad_size_55x85"] = $_POST['notepad_size_55x85'];

    

	if($_SESSION['location'] == 'us_address') {

    	header('Location: card_details.php');

	} else if($_SESSION['location'] == 'non_us_address') {

    	header('Location: card_details_non_us.php');

	} else {

		header('Location: card_details.php');

	}

    

	exit;

}



if(isset($_POST['notepad_next'])){ 

    

    //Notepad Options

    $_SESSION["notepad_size_425x55"] = $_POST['notepad_size_425x55'];

    $_SESSION["notepad_size_55x85"] = $_POST['notepad_size_55x85'];

    

	if($_SESSION['ordering_step'] == 4) { //if the ordering step is set to 4, then make it 5

		$_SESSION['ordering_step']++;	

	}

	

    header('Location: shipping_options.php');

    

        exit;

}

        

?>









<div id="container">





<?php 

	include("includes/header.php");

	include("includes/js_warning.php");

?>





    <form id="clientForm" name="clientForm" method="post" action=""><!-- Begin Form -->

          

        <div class="form_container" id="notepad_options">

                <div class="row">

                	<div class="clientform_table_header">Notepad Options <span class="tooltip hidden-no-js" style="display:none;" tooltip="<?php echo $notepad_options; ?>"> </span><br /> <span class="warning">(If applicable)</span></div>

				</div>     

                <div class="row">  

                    <div class="content"> 

                        <input id="notepad_size_425x55" type="checkbox" name="notepad_size_425x55" value="yes" <?php if(isset($_POST['notepad_size_425x55'])) {echo 'checked="checked"';} else if($_SESSION["notepad_size_425x55"] == 'yes') { echo 'checked="checked"';} ?>> <label for="notepad_size_425x55" style="font-weight: normal">4.25 X 5.5</label>

                        <br />

                        <input id="notepad_size_55x85" type="checkbox" name="notepad_size_55x85" value="yes" <?php if(isset($_POST['notepad_size_55x85'])) {echo 'checked="checked"';} else if($_SESSION["notepad_size_55x85"] == 'yes') { echo 'checked="checked"';} ?>> <label for="notepad_size_55x85" style="font-weight: normal">5.5 X 8.5</label>

                    </div>

                </div>

                <div class="row clearBoth">

                    <div class="content" style="overflow:hidden;"><input class="button prev submit" type="submit" name="notepad_prev" value="Previous Step" /></div> 

                    <div class="content" id="last_content"><input class="button next submit" type="submit" name="notepad_next" value="Next Step" /></div>

                </div>

        </div> 

          

    </form><!-- End Form --> 

</div>



</body>



</html>