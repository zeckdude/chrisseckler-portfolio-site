<?php

session_start();

ob_start();



//These are the values for each of the tooltips

$foreign_cards = "<p class='tip_title'>Ordering Foreign Language Cards</p><p>Check this box if you want to order any foreign language cards</p><br /><p>All foreign language cards have English on one side and the foreign language that you select on the back.</p>";

$language_proof = "<p class='tip_title'>Language Proof Email</p><p>If you order foreign language cards, we need to know what email to send your language proof to.</p>";





/*//These are the saved session variables

foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop

	//if($value != '') {

		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

	//}

}*/ 



$_SESSION['ordering_mode'] = 'on';



//This code ensures that you have been to this page or page before it, so you can't manually type in the url without being redirected

if(!isset($_SESSION['ordering_step'])) {//if the ordering step has not been created, because someone manually typed it in without having been to the index page

	header('Location: index.php');

}





//echo 'ordering step: ' . $_SESSION['ordering_step'];

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Order Form - Language Options</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link href="css/style.css" rel="stylesheet" type="text/css" />

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

<script src="js/validation.js" type="text/javascript"></script>



<script type="text/javascript">

      $(document).ready(function(){

			

			

		//This brings back all elements for browsers with javaScript enabled

		$(".hidden-nojs").show();

		$("#js_warning").hide();	

		

		  

		  $('#english_only_area').hide();

          $('#english_w_foreign_area').hide();

		  $('#english_w_foreign_area_secondary').hide();

		  $('#foreign_email_row').hide();

		  

		  

		  if($('#english_only_checkbox').attr('checked')) { //This checks if the english_only_checkbox is checked, which it is if the session variable is set, and then will enable the fields

		  		$('#english_only_area').show();

          }

		  

		  if($('#foreign_checkbox').attr('checked')) { //This checks if the english_only_checkbox is checked, which it is if the session variable is set, and then will enable the fields

		  		$('#english_w_foreign_area').show();

				$('#english_w_foreign_area_secondary').show();

				$('#foreign_email_row').show();

          }

		  

		  $('#english_only_checkbox').click(function() { 

                //$('#english_only_area').toggle();

				if($('#english_only_checkbox').attr('checked')) {

					$('#english_only_area').slideDown();	

				} else {

					$('#english_only_area').slideUp();

				}

          });

		  

		  $('#foreign_checkbox').click(function() { 

                //$('#english_w_foreign_area').toggle();

				//$('#english_w_foreign_area_secondary').toggle();

				//$('#foreign_email_row').toggle();

				if($('#foreign_checkbox').attr('checked')) {

					$('#english_w_foreign_area').slideDown();

					$('#english_w_foreign_area_secondary').slideDown();

					$('#foreign_email_row').slideDown();

				} else {

					$('#english_w_foreign_area').slideUp();

					$('#english_w_foreign_area_secondary').slideUp();

					$('#foreign_email_row').slideUp();

				}

          });

		  

		  

		  

		  

		  

		  

		  

		  

		  

		  

		  

		  

		  

		  

		  

		  

		  /*//Default text colors to make it appear disabled for users with JS enabled

		  $('#english_only_area').addClass("disable_text");

		  $('#english_w_foreign_area').addClass("disable_text");

		  $('#english_w_foreign_area_secondary').addClass("disable_text");

		  $('#foreign_email_row div').addClass("disable_text");

				

		  if($('#english_only_checkbox').attr('checked')) { //This checks if the english_only_checkbox is checked, which it is if the session variable is set, and then will enable the fields

		  		$('#english_only_area').removeClass("disable_text");

				$('#english_only_area').addClass("normal_text");

          } else {					 

          		$('input[name="english_only"]').attr('disabled', true); //disable for radiobuttons in english only area

		  }

		  

		  if($('#foreign_checkbox').attr('checked')) { //This checks if the foreign_checkbox is checked, which it is if the session variable is set, and then will enable the fields

		  		$('#english_w_foreign_area').removeClass("disable_text");

		  		$('#english_w_foreign_area_secondary').removeClass("disable_text");

		  		$('#foreign_email_row div').removeClass("disable_text");

				$('#english_w_foreign_area').addClass("normal_text");

				$('#english_w_foreign_area_secondary').addClass("normal_text");

				$('#foreign_email_row div').addClass("normal_text");

				$('#additional_foreign_row').show();

				//alert('test');

          } else {					 

          		$('#english_w_foreign_area :input').attr('disabled', true); //disable for all inputs in foreign area

		  		$('#english_w_foreign_area_secondary :input').attr('disabled', true); //disable for all inputs in 2nd cell for foreign area

				$('#foreign_email_row :input').attr('disabled', true);

		  }

          

		  //Toggle to disable/enable radiobuttons on english only area and toggle for css for the text

          $('#english_only_checkbox').click(function() { 

                $('input[name="english_only"]').attr('disabled', !this.checked);

                $('#english_only_area').toggleClass("disable_text");

          });

		  

		  //Toggle to disable/enable inputs on foreign area and toggle for css for the text

		  $('#foreign_checkbox').click(function() {

                $('#english_w_foreign_area :input, #english_w_foreign_area_secondary :input, #foreign_email_row :input').attr('disabled', !this.checked);

                $('#english_w_foreign_area, #english_w_foreign_area_secondary, #foreign_email_row div').toggleClass("disable_text");

          });*/





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



$conn = dbConnect("admin"); 

$done = false;



if(isset($_POST['language_prev'])){ 

    

    //Language Details

    $_SESSION["english_only"] = $_POST['english_only'];

    $_SESSION["english_w_foreign"] = $_POST['english_w_foreign'];

	$_SESSION['foreign_characters'] = $_POST['foreign_characters'];

	$_SESSION['foreign_character_later'] = $_POST['foreign_character_later'];

    $_SESSION["language"] = $_POST['language'];

    $_SESSION["other_language"] = $_POST['other_language'];

    $_SESSION["email_language_proof"] = $_POST['email_language_proof'];

	$_SESSION["english_toggle"] = $_POST['english_toggle'];

	$_SESSION["foreign_toggle"] = $_POST['foreign_toggle'];

	

	if(isset($_POST['foreign_toggle'])) {

		$_SESSION["foreign_cards_ordered"] = "yes";

	} elseif(!isset($_POST['foreign_toggle'])) {

		$_SESSION["foreign_cards_ordered"] = "no";	

	}

	

	if(isset($_POST['english_toggle'])) {

		$_SESSION["english_cards_ordered"] = "yes";

	} elseif(!isset($_POST['english_toggle'])) {

		$_SESSION["english_cards_ordered"] = "no";	

	}

	

    

    header('Location: index.php');

    

        exit;

}



if(isset($_POST['language_next'])){

	

	

	$has_error = false;

	$error_array = array();

	$email_reg_expr = '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$';

	$latin_check = '/[\x{0030}-\x{007f}]/u';

	$character_array = array();

	

	//PHP Validation

	if(isset($_POST['english_toggle'])) {

		if($_POST['english_only'] == '') {

			$english_only_quantity_error = '<span id="english_only_quantity_error" class="error">Choose a quantity.</span>';

			$error_array['english_only_error'] = true;

		}

	}

	

	if(isset($_POST['foreign_toggle'])) {

		if($_POST['english_w_foreign'] == '') {

			$foreign_quantity_error = '<span id="foreign_quantity_error" class="error">Choose a quantity.</span>';

			$error_array['foreign_quantity_error'] = true;

		}

		

		if($_POST['email_language_proof'] == '') {

			$email_language_error = '<div id="email_language_error_1" class="error">You must provide an email to send the language proof to.</div>';

			$error_array['$email_language_error_1'] = true;

		} else if(!eregi($email_reg_expr, $_POST['email_language_proof'])) {

			$email_language_error = '<div id="email_language_error_2" class="error">Enter a valid Email.</div>';

			$error_array['$email_language_error_2'] = true;

		}

		

		if($_POST['language'] == '' && $_POST['other_language'] == '') {

			$language_error = '<div id="language_error" class="error">Select a language.</div>';

			$error_array['language_error'] = true;

		}

		

		if($_POST['language'] != '' && $_POST['other_language'] != '') {

			$language_both_error = '<div id="language_both_error" class="error">You may only choose one language.</div>';

			$error_array['language_both_error'] = true;

		}

		

		function check_characters($fieldname) {

			if(preg_match($latin_check, $fieldname)) {

				$foreign_character_error = '<div id="foreign_character_error" class="error">Only foreign characters and spaces are allowed.</div>';

				$error_array['foreign_character_error'] = true;		  

			}

		}	

		

		if($_POST['foreign_characters_name'] != '' || $_POST['foreign_characters_line2'] != '' || $_POST['foreign_characters_line3'] != '' || $_POST['foreign_characters_line4'] != '') {

			if(preg_match($latin_check, $_POST['foreign_characters_name'])) {

				$character_array['name'] = true;		  

			}

			

			if(preg_match($latin_check, $_POST['foreign_characters_line2'])) {

				$character_array['line2'] = true;		  

			}

			

			if(preg_match($latin_check, $_POST['foreign_characters_line3'])) {

				$character_array['line3'] = true;		  

			}

			

			if(preg_match($latin_check, $_POST['foreign_characters_line4'])) {

				$character_array['line4'] = true;		  

			}

			

			if(in_array(true, $character_array)) {

				$foreign_character_error = '<div id="foreign_character_error" class="error">Only foreign characters and spaces are allowed.</div>';

				$error_array['foreign_character_error'] = true;

			}

		}

	} //end if isset foreign toggle

	

	if(!isset($_POST['english_toggle']) && !isset($_POST['foreign_toggle'])) {

		$english_only_checkbox_error = '<span id="english_only_checkbox_error" class="error">You must choose at least one of these options.</span>';

		$foreign_checkbox_error = '<span id="foreign_checkbox_error" class="error">You must choose at least one of these options.</span>';

		$error_array['neither_checked'] = true;

	}

	

	

	if(in_array(true, $error_array)) {

		$has_error = true;

	}

	

	if($has_error != true) { //If there is no error, then save the values and go to the next page

    

		//Language Details

		$_SESSION["english_toggle"] = $_POST['english_toggle'];

		$_SESSION["english_only"] = $_POST['english_only'];

		$_SESSION["foreign_toggle"] = $_POST['foreign_toggle'];

		$_SESSION["english_w_foreign"] = $_POST['english_w_foreign'];

		$_SESSION['foreign_characters_name'] = $_POST['foreign_characters_name'];

		$_SESSION['foreign_characters_line2'] = $_POST['foreign_characters_line2'];

		$_SESSION['foreign_characters_line3'] = $_POST['foreign_characters_line3'];

		$_SESSION['foreign_characters_line4'] = $_POST['foreign_characters_line4'];

		$_SESSION["language"] = $_POST['language'];

		$_SESSION["other_language"] = $_POST['other_language'];

		$_SESSION["email_language_proof"] = $_POST['email_language_proof'];

		

		if(isset($_POST['foreign_toggle'])) {

			$_SESSION["foreign_cards_ordered"] = "yes";

		} elseif(!isset($_POST['foreign_toggle'])) {

			$_SESSION["foreign_cards_ordered"] = "no";	

		}

		

		if(isset($_POST['english_toggle'])) {

			$_SESSION["english_cards_ordered"] = "yes";

		} elseif(!isset($_POST['english_toggle'])) {

			$_SESSION["english_cards_ordered"] = "no";	

		}

	

		if($_SESSION['ordering_step'] == 1) {

			$_SESSION['ordering_step']++;	

		}

	

		header('Location: choose_location.php');

		

		exit;

	}

} //end if isset post language next

        

?>









<div id="container">





<?php 

	include("includes/header.php");

	include("includes/js_warning.php");

?>





    <form id="clientForm" name="clientForm" method="post" action="" enctype="multipart/form-data"><!-- Begin Form -->

          

          

        <div class="form_container" id="language_details">  

                <div class="row">

                	<div class="clientform_table_header" colspan="2">Language Options<br /> <span class="warning">Please choose your quantities and pick language details if applicable</span></div>

				</div>    

            

				<div class="row">

                    <div class="content"> 

                        <input id="english_only_checkbox" type="checkbox" name="english_toggle" <?php if(isset($_POST['english_toggle'])) {echo 'checked="checked"';} else if($_SESSION["english_toggle"] == 'on') { echo 'checked="checked"';} ?> />  <span id="english_only_checkbox_text"><label for="english_only_checkbox">Check here to order English Cards</label></span>

						<?php if(isset($english_only_checkbox_error)) { echo $english_only_checkbox_error; } ?>

                        <br /> 

                        <br />

                        <div id="english_only_area" class="normal_text">                  

                        	<label id="english_only_label" for="english_only">English ONLY Quantity</label>

                            <?php if(isset($english_only_quantity_error)) { echo $english_only_quantity_error; } ?> 

                        	<br />

                            <input id="english_only_250" type="radio" name="english_only" value="250" <?php if($_POST['english_only'] == '250') {echo 'checked="checked"';} else if($_SESSION["english_only"] == '250') { echo 'checked="checked"';} ?>><label for="english_only_250" style="font-weight: normal;">250</label>

                            <br />

                            <input id="english_only_500" type="radio" name="english_only" value="500" <?php if($_POST['english_only'] == '500') {echo 'checked="checked"';} else if($_SESSION["english_only"] == '500') { echo 'checked="checked"';} ?>><label for="english_only_500" style="font-weight: normal;">500</label>

                        </div>

                    </div>

				</div>

                

                <div class="row" id="foreign_tr">

                    <div class="content" id="foreign_cont_1">

                    	<input id="foreign_checkbox" type="checkbox" name="foreign_toggle" <?php if(isset($_POST['foreign_toggle'])) {echo 'checked="checked"';} else if($_SESSION["foreign_toggle"] == 'on') { echo 'checked="checked"';} ?> />  <span id="foreign_checkbox_text"><label for="foreign_checkbox">Check here to order Foreign language Cards</label></span> <span id="foreign_checkbox_tooltip" class="tooltip hidden-nojs" style="display:none;" tooltip="<?php echo $foreign_cards; ?>"> </span>

                        <?php if(isset($foreign_checkbox_error)) { echo $foreign_checkbox_error; } ?>

                        <br />

                        <br />

                        <div id="english_w_foreign_area" class="normal_text">

                        	<div class="foreign_language_quantity">

                                <label for="english_w_foreign">English on one side w/foreign language on the back Quantity</label>

                                <br />

                                <input id="foreign_250" type="radio" name="english_w_foreign" value="250" <?php if($_POST['english_w_foreign'] == '250') {echo 'checked="checked"';} else if($_SESSION["english_w_foreign"] == '250') { echo 'checked="checked"';} ?>><label for="foreign_250" style="font-weight: normal;">250</label>

                                <br />

                                <input id="foreign_500"  class="formfieldmargin" type="radio" name="english_w_foreign" value="500" <?php if($_POST['english_w_foreign'] == '500') {echo 'checked="checked"';} else if($_SESSION["english_w_foreign"] == '500') { echo 'checked="checked"';} ?>><label for="foreign_500" id="foreign_500_area" style="font-weight: normal;"><span id="foreign_number">500</span></label><?php if(isset($foreign_quantity_error)) { echo $foreign_quantity_error; } ?> 

                            </div>

                         </div> <!--end english_w_foreign_area div--> 

                    </div>

                

                    <div class="content language_choice">

                    	<div id="english_w_foreign_area_secondary" class="normal_text"> 

                            <div class="languages_pick"> 

                                <span id="language_text"><label for="language">Language</label></span>  

                                <select id="language" name="language" class="formfieldmargin">

                                  <option value=""></option>

                                  <option value="Japan" <?php if($_POST["language"] == 'Japan') { echo 'selected';} else if($_SESSION["language"] == 'Japan') { echo 'selected';} ?>>Japan</option>

                                  <option value="Korea" <?php if($_POST["language"] == 'Korea') { echo 'selected';} else if($_SESSION["language"] == 'Korea') { echo 'selected';} ?>>Korea</option>

                                  <option value="Taiwan" <?php if($_POST["language"] == 'Taiwan') { echo 'selected';} else if($_SESSION["language"] == 'Taiwan') { echo 'selected';} ?>>Taiwan</option>

                                  <option value="People's Republic of China" <?php if($_POST["language"] == "People's Republic of China") { echo 'selected';} else if($_SESSION["language"] == "People's Republic of China") { echo 'selected';} ?>>People's Republic of China</option>

                                </select>

                                <?php if(isset($language_error)) { echo $language_error; } ?>

                                

                                <br />

                                <label for="other_language">Other Language</label>  

                                <input class="formfieldmargin" id="other_language" name="other_language" class="text" type="text" value="<?php if(isset($_POST['other_language'])) {echo $_POST['other_language'];} else{echo $_SESSION["other_language"];} ?>" />

                                <?php if(isset($language_both_error)) { echo $language_both_error; } ?>

                            </div>

                    	</div> <!--end english_w_foreign_area_secondary div-->    

                    </div>

                </div>                     

                

                <div class="row" id="foreign_email_row">

                    <div class="content normal_text">  

                        <label for="email_language_proof">Please indicate which e-mail we should send your language proof to</label> <span class="tooltip hidden-nojs" style="display:none;" tooltip="<?php echo $language_proof; ?>"> </span> 

                        <br /> 

                        <input id="email_language_proof" name="email_language_proof" class="text" type="text" value="<?php if(isset($_POST['email_language_proof'])) {echo $_POST['email_language_proof'];} else{echo $_SESSION["email_language_proof"];} ?>"/> 

                        <?php if(isset($email_language_error)) { echo $email_language_error; } ?> 

                    </div>

                    



                </div>

                   

                <div class="row">

                    <div class="content"><input class="button prev submit" type="submit" name="language_prev" value="Previous Step" /></div> 

                    <div class="content" id="last_content"><input id="language_submit" class="button next submit" type="submit" name="language_next" value="Next Step" /></div>

                </div>

              

        </div> 

          

        

                 

                

        

    

    

    </form><!-- End Form --> 

</div>



</body>



</html>