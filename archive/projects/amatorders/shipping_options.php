<?php

session_start();

ob_start();

date_default_timezone_set('America/Los_Angeles');





$_SESSION['ordering_mode'] = 'on';



//This code ensures that you have been to this page or page before it, so you can't manually type in the url without being redirected

if(!isset($_SESSION['ordering_step']) || $_SESSION['ordering_step'] < 5) {//if the ordering step has not been created or is less than the current page ordering step, because someone manually typed it in without having been to the index page

	header('Location: index.php');

}



//Code for checking if the current time is between 3pm and 11:59pm

$current_timestamp = time();

$current_time = date('m/d/y H:i:s', $current_timestamp);



$three_pm_timestamp = mktime(15,0,0,date("m"),date("d"),date("Y"));

$three_pm_time = date('m/d/y H:i:s', $three_pm_timestamp); 



$eleven_59pm_timestamp = mktime(23,59,0,date("m"),date("d"),date("Y"));

$eleven_59pm_time = date('m/d/y H:i:s', $eleven_59pm_timestamp);



$current_day_of_week = date("N");





//This adds another day to day of week, because any orders after 3pm are considered ordered on the next day

if($current_timestamp > $three_pm_timestamp && $current_timestamp < $eleven_59pm_timestamp) { //If the current time is between 3pm and 11:59pm, then add another day to the current day of the week

	$past_3pm = 'yes';

} else {

	$past_3pm = 'no';

}





//Variables to use in function that adds days to use for minDate and maxDate setting in datepicker

$current_date = date('m/d/Y', $current_timestamp);

$current_month = date('m', $current_timestamp);

$current_day = date('d', $current_timestamp);

$current_year = date('Y', $current_timestamp);





?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Order Form - Shipping Options</title>

<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />

<link rel="stylesheet" href="css/jquery.datepick.css" type="text/css" media="screen" charset="utf-8" />

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

<script src="js/validation.js" type="text/javascript"></script>



<script type="text/javascript">

	var newDateConverted = new Date(<?php echo $current_timestamp; ?> * 1000); //This is the date object in the datepick.js file. That is why it is placed above the file.

</script>



<script src="js/jquery.datepick.js" type="text/javascript"> //This is the datepicker</script> 

<script src="js/date.js" type="text/javascript"> //This includes the functions that add together the days and formats the date for minDate and maxDate</script>



<script type="text/javascript">



//Variables that are being used in the datepicker function

var dayOfTheWeek = <?php echo $current_day_of_week;  ?>;

var past3Pm = '<?php echo $past_3pm;  ?>';



var currentDate = '<?php echo $current_date; ?>';

var currentMonth = <?php echo $current_month; ?>;

var currentDay = <?php echo $current_day; ?>;

var currentYear = <?php echo $current_year; ?>;



//This function adds a certain number of days to the current date. This is used for the minDate and maxDate for the datepicker

function addtoDate(year,monthMinusOne,day,daysToAdd) {

	var daysAdded = new Date(year,monthMinusOne,day).add('d',daysToAdd).format('MM/dd/yyyy');

	return daysAdded;

}



	$(document).ready(function(){

							   

		//This brings back all elements for browsers with javaScript enabled

		$(".hidden-nojs").show();

		$("#js_warning").hide();



		var lastDay;

		var firstDay;

		var shippingTimeEnglish = 'shipping_time_english'; //Variable to be used as a parameter for datepicker function

		var shippingTimeForeign = 'shipping_time_foreign'; //Variable to be used as a parameter for datepicker function

		

		



		

		

		

		function datepicker(radioButtonsName,inputFieldName) { //This is the function that is run every time the radiobuttons are changed

			

			//$("#rush_needed_by_english").datepick('hide');

			if ($("input[name='"+radioButtonsName+"']:checked").val() == '1-3 work days') { //This is run when the user picks the 1-3 work days radiobutton

				

				$("#"+inputFieldName).attr('disabled', false); //enables the input field

				

				$('#'+inputFieldName).keydown(function() { //this disables the use of keyboard entry on the input field so the user is forced to use the datepicker

					return false;

				});

				

				

				$("#"+inputFieldName).datepick({	//Default values for the datepicker

					showOn: 'both', //This is the trigger for when to show the datepicker. Both for both on focus and on button push

					buttonImageOnly: true, //This indicates whether or not the image should appear by itself(true) or on a button(false)

					buttonImage: 'images/calendar-blue.gif', //Location of the image for the Calendar Button

					beforeShowDay: $.datepick.noWeekends, //This controls what each day being displayed does, whether it is selectable or not. noWeeekends makes the weekends not selectable

					hideIfNoPrevNext: true // True to hide next/previous month links

				});



				//Checks what number day of the week it is and based on that, it will determine how many days should be selectable in datepicker. The values change if it is after 3pm, rolls over to next day in that case	

				switch(dayOfTheWeek) {

					case 1: //Monday

					  if(past3Pm == 'yes') {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,4); //This for example, adds 4 days to the current date

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,2);

					  } else {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,3); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,1);

					  }

					  break;

					case 2: //Tuesday

					  if(past3Pm == 'yes') {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,6); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,2);

					  } else {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,3); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,1);

					  }

					  break;

					case 3: //Wednesday

					  if(past3Pm == 'yes') {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,6); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,2);

					  } else {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,5); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,1);

					  }

					  break;

					case 4: //Thursday

					  if(past3Pm == 'yes') {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,6); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,3);

					  } else {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,5); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,1);

					  }

					  break;

					case 5: //Friday

					  if(past3Pm == 'yes') {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,6); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,4);

					  } else {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,5); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,1);

					  }

					  break;

					case 6: //Saturday

					  if(past3Pm == 'yes') {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,5); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,3);

					  } else {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,5); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,3);

					  }

					  break;

					case 7: //Sunday

					  if(past3Pm == 'yes') {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,4); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,2);

					  } else {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,4); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,2);

					  }

					  break;

				}

				

				

				

				$("#"+inputFieldName).datepick('option', { 

					minDate: firstDay, //This is the earliest day to be able to get picked  

					maxDate: lastDay //This is the latest day to be able to get picked

				});

				

				

			} else if ($("input[name='"+radioButtonsName+"']:checked").val() == '4-8 work days') {

				

				$("#"+inputFieldName).attr('disabled', false);

				

				$('#'+inputFieldName).keydown(function() {

					return false;

				});

				

				$("#"+inputFieldName).datepick({	

					showOn: 'both', //This is the trigger for when to show the datepicker. Both for both on focus and on button push

					buttonImageOnly: true, //This indicates whether or not the image should appear by itself(true) or on a button(false)

					buttonImage: 'images/calendar-blue.gif', //Location of the image for the Calendar Button

					beforeShowDay: $.datepick.noWeekends, //This controls what each day being displayed does, whether it is selectable or not. noWeeekends makes the weekends not selectable

					hideIfNoPrevNext: true // True to hide next/previous month links

				});

				

				//Code for 4-8 days datepicker	

				switch(dayOfTheWeek) {

					case 1: //Monday

					  if(past3Pm == 'yes') {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,11); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,5);

					  } else {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,10); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,4);

					  }

					  break;

					case 2: //Tuesday

					  if(past3Pm == 'yes') {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,13); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,7);

					  } else {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,10); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,4);

					  }

					  break;

					case 3: //Wednesday

					  if(past3Pm == 'yes') {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,13); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,7);

					  } else {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,12); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,6);

					  }

					  break;

					case 4: //Thursday

					  if(past3Pm == 'yes') {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,12); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,6);

					  } else {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,13); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,4);

					  }

					  break;

					case 5: //Friday

					  if(past3Pm == 'yes') {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,13); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,7);

					  } else {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,12); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,4);

					  }

					  break;

					case 6: //Saturday

					  if(past3Pm == 'yes') {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,12); 



						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,6);

					  } else {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,12); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,6);

					  }

					  break;

					case 7: //Sunday

					  if(past3Pm == 'yes') {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,11); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,5);

					  } else {

						  lastDay = addtoDate(currentYear,currentMonth-1,currentDay,11); 

						  firstDay = addtoDate(currentYear,currentMonth-1,currentDay,5);

					  }

					  break;

				}

						

				$("#"+inputFieldName).datepick('option', {

					minDate: firstDay, //This is the earliest day to be able to get picked  

					maxDate: lastDay //This is the latest day to be able to get picked

				});

				

			} else if ($("input[name='"+radioButtonsName+"']:checked").val() == '10 work days') {



				$("#"+inputFieldName).datepick('destroy');

				$("#"+inputFieldName).val("");

				$("#"+inputFieldName).attr('disabled', true);

			}//end else if

		} //end datepicker function	

		

		

		

		$('input[type="text"]').focus(function()

		 {

			$(this).select();	

		 });

	

	

		$("input[name='shipping_time_english']").click(function(){	//When the radiobuttons change, run this function											 

			datepicker('shipping_time_english','rush_needed_by_english');													 

		});

		

		$("input[name='shipping_time_foreign']").click(function(){	//When the radiobuttons change, run this function											 

			datepicker('shipping_time_foreign','rush_needed_by_foreign');													 

		});

		

		$("input[name='shipping_time_425x55']").click(function(){	//When the radiobuttons change, run this function											 

			datepicker('shipping_time_425x55','rush_needed_by_425x55');													 

		});

		

		$("input[name='shipping_time_55x85']").click(function(){	//When the radiobuttons change, run this function											 

			datepicker('shipping_time_55x85','rush_needed_by_55x85');													 

		});

		

		

		

		//This disables the input fields on page load, since the default value is 10 work days.

		if($("#rush_needed_by_english").val() == '') {

			$("#rush_needed_by_english").attr('disabled', true); 

		} else {

			datepicker('shipping_time_english','rush_needed_by_english');

		}

		

		if($("#rush_needed_by_foreign").val() == '') {

			$("#rush_needed_by_foreign").attr('disabled', true);

		} else {

			datepicker('shipping_time_foreign','rush_needed_by_foreign');

		}

		

		if($("#rush_needed_by_425x55").val() == '') {

			$("#rush_needed_by_425x55").attr('disabled', true);

		} else {

			datepicker('shipping_time_425x55','rush_needed_by_425x55');	

		}

		

		if($("#rush_needed_by_55x85").val() == '') {

			$("#rush_needed_by_55x85").attr('disabled', true);

		} else {

			datepicker('shipping_time_55x85','rush_needed_by_55x85');

		}	 

	

	}); //end document ready

</script>

    

<script type="text/javascript">   

    function stopRKey(evt) { //disables enter key to submit form

      var evt = (evt) ? evt : ((event) ? event : null);

      var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);

      if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}

    }

    

    document.onkeypress = stopRKey; 

</script>



</head>











<body id="shipping_options_page">



<?php include("includes/connection.php");



if($_SESSION['notepad_size_425x55'] && $_SESSION['notepad_size_55x85']) {

	$_SESSION['both_notepads_selected']	= 'yes';

}





$conn = dbConnect("admin"); 

$done = false;



if(isset($_POST['shipping_prev'])){ 

    

    //Shipping Options

	//English Shipping 

    $_SESSION['shipping']['english']['timespan'] = $_POST['shipping_time_english'];

	$_SESSION['shipping']['english']['rush_date'] = $_POST['rush_needed_by_english'];

	

	//Foreign Shipping

	$_SESSION['shipping']['foreign']['timespan'] = $_POST['shipping_time_foreign']; //This saves the foreign language shipping info into a multidimensional array

	$_SESSION['shipping']['foreign']['rush_date'] = $_POST['rush_needed_by_foreign'];

		

	//4.25 x 5.5 Notepads Shipping

	$_SESSION['shipping']['notepads']['425x55']['timespan'] = $_POST['shipping_time_425x55'];

	$_SESSION['shipping']['notepads']['425x55']['rush_date'] = $_POST['rush_needed_by_425x55'];



	//5.5 x 8.5 Notepads Shipping

	$_SESSION['shipping']['notepads']['55x85']['timespan'] = $_POST['shipping_time_55x85'];

	$_SESSION['shipping']['notepads']['55x85']['rush_date'] = $_POST['rush_needed_by_55x85'];

    

    header('Location: notepad_options.php');

    

        exit;

}







if(isset($_POST['shipping_next'])){

	

	$has_error = false;

	$error_array = array();

	$date_regex = '/(0[1-9]|1[012])[\/](0[1-9]|[12][0-9]|3[01])[\/]((?:19|20)\d\d)/';

	

	$entered_date_timestamp = 0;

	$allowable_start_date = 0;

	$allowable_end_date = 0;

	$allowed_start_converted = 0;

	$allowed_end_converted = 0;

	$is_weekend_day = 0;

	

		//Validation to check if date entered is within a certain range

	function date_check($shipping_field_name,$rush_field_name) {

		//echo '<br/>Date entered: ' . $_POST['rush_needed_by_english'] . '<br/>';

		

		//Declaring Global Variables

		global $entered_date_timestamp;

		global $allowable_start_date;

		global $allowable_end_date;

		global $allowed_start_converted;

		global $allowed_end_converted;

		global $is_weekend_day;

		global $current_day_of_week;

		

		$entered_date_timestamp = strtotime($rush_field_name); //Timestamp for date entered in field

		$current_timestamp = time(); //The timestamp for right now
		//$current_timestamp = '1300420800';

		//echo 'The current timestamp is ' . $current_timestamp;
		//echo '<br />';
		//echo 'The debug current timestamp from Friday is 1300420800';

		

		$day_of_week_entered = date("N",$entered_date_timestamp);

		

		if($day_of_week_entered == 6 || $day_of_week_entered == 7) { //This checks if the day that was chosen is a weekend day

			$is_weekend_day = 'yes';

		} else {

			$is_weekend_day = 'no';	

		}

		


		if($shipping_field_name == '1-3 work days') {

			//Settings for 1-3 Days option

			switch($current_day_of_week) {

				case 1: //Monday

					if($past_3pm == 'yes') {

						$allowable_end_date = strtotime('+4 day', $current_timestamp); 	

						$allowable_start_date = strtotime('+2 day', strtotime(date('Y-m-d'))); //Make the allowable start date 48 hours from now	

					} else {

						$allowable_end_date = strtotime('+3 day', $current_timestamp); 

						$allowable_start_date = strtotime('+1 day', strtotime(date('Y-m-d'))); //Make the allowable start date 24 hours from now

					}

					break;

				case 2: //Tuesday

					if($past_3pm == 'yes') {

						$allowable_end_date = strtotime('+6 day', $current_timestamp); 	

						$allowable_start_date = strtotime('+2 day', strtotime(date('Y-m-d'))); 	

					} else {

						$allowable_end_date = strtotime('+3 day', $current_timestamp); 

						$allowable_start_date = strtotime('+1 day', strtotime(date('Y-m-d'))); 

					}

					break;

				case 3: //Wednesday

					if($past_3pm == 'yes') {

						$allowable_end_date = strtotime('+6 day', $current_timestamp); 	

						$allowable_start_date = strtotime('+2 day', strtotime(date('Y-m-d'))); 	

					} else {

						$allowable_end_date = strtotime('+5 day', $current_timestamp); 

						$allowable_start_date = strtotime('+1 day', strtotime(date('Y-m-d'))); 

					}

					break;

				case 4: //Thursday

					if($past_3pm == 'yes') {

						$allowable_end_date = strtotime('+6 day', $current_timestamp); 	

						//$allowable_start_date = strtotime('+4 day', $current_timestamp);

						$allowable_start_date = strtotime('+4 day', strtotime(date('Y-m-d')));

					} else {

						$allowable_end_date = strtotime('+5 day', $current_timestamp); 

						$allowable_start_date = strtotime('+1 day', strtotime(date('Y-m-d'))); 

					}

					break;

				case 5: //Friday

					if($past_3pm == 'yes') {

						$allowable_end_date = strtotime('+7 day', $current_timestamp); 	

						$allowable_start_date = strtotime('+4 day', strtotime(date('Y-m-d'))); 	

					} else {

						$allowable_end_date = strtotime('+5 day', $current_timestamp); 

						$allowable_start_date = strtotime('+3 day', strtotime(date('Y-m-d'))); 

					}

					break;

				case 6: //Saturday

					if($past_3pm == 'yes') {

						$allowable_end_date = strtotime('+5 day', $current_timestamp); 	

						$allowable_start_date = strtotime('+3 day', strtotime(date('Y-m-d'))); 	

					} else {

						$allowable_end_date = strtotime('+5 day', $current_timestamp); 

						$allowable_start_date = strtotime('+3 day', strtotime(date('Y-m-d'))); 

					}

					break;

				case 7: //Sunday

					if($past_3pm == 'yes') {

						$allowable_end_date = strtotime('+4 day', $current_timestamp); 	

						$allowable_start_date = strtotime('+2 day', strtotime(date('Y-m-d'))); 

					} else {

						$allowable_end_date = strtotime('+4 day', $current_timestamp); 

						$allowable_start_date = strtotime('+2 day', strtotime(date('Y-m-d'))); 

					}

					break;

			} //end 1-3 days switch

		} //end if 1-3 days

		

		if($shipping_field_name == '4-8 work days') {

			//Settings for 4-8 Days option

			switch($current_day_of_week) {

				case 1: //Monday

					if($past_3pm == 'yes') {

						$allowable_end_date = strtotime('+11 day', $current_timestamp); 	

						$allowable_start_date = strtotime('+5 day', strtotime(date('Y-m-d'))); //Make the allowable start date 48 hours from now	

					} else {

						$allowable_end_date = strtotime('+10 day', $current_timestamp); 

						$allowable_start_date = strtotime('+4 day', strtotime(date('Y-m-d'))); //Make the allowable start date 24 hours from now

					}

					break;

				case 2: //Tuesday

					if($past_3pm == 'yes') {

						$allowable_end_date = strtotime('+13 day', $current_timestamp); 	

						$allowable_start_date = strtotime('+7 day', strtotime(date('Y-m-d'))); 	

					} else {

						$allowable_end_date = strtotime('+10 day', $current_timestamp); 

						$allowable_start_date = strtotime('+4 day', strtotime(date('Y-m-d'))); 

					}

					break;

				case 3: //Wednesday

					if($past_3pm == 'yes') {

						$allowable_end_date = strtotime('+13 day', $current_timestamp); 	

						$allowable_start_date = strtotime('+7 day', strtotime(date('Y-m-d'))); 	

					} else {

						$allowable_end_date = strtotime('+12 day', $current_timestamp); 

						$allowable_start_date = strtotime('+6 day', strtotime(date('Y-m-d'))); 

					}

					break;

				case 4: //Thursday

					if($past_3pm == 'yes') {

						$allowable_end_date = strtotime('+12 day', $current_timestamp); 	

						//$allowable_start_date = strtotime('+4 day', $current_timestamp);

						$allowable_start_date = strtotime('+6 day', strtotime(date('Y-m-d')));

					} else {

						$allowable_end_date = strtotime('+13 day', $current_timestamp); 

						$allowable_start_date = strtotime('+4 day', strtotime(date('Y-m-d'))); 

					}

					break;

				case 5: //Friday

					if($past_3pm == 'yes') {

						$allowable_end_date = strtotime('+13 day', $current_timestamp); 	

						$allowable_start_date = strtotime('+7 day', strtotime(date('Y-m-d'))); 	

					} else {

						$allowable_end_date = strtotime('+12 day', $current_timestamp); 

						$allowable_start_date = strtotime('+4 day', strtotime(date('Y-m-d'))); 

					}

					break;

				case 6: //Saturday

					if($past_3pm == 'yes') {

						$allowable_end_date = strtotime('+12 day', $current_timestamp); 	

						$allowable_start_date = strtotime('+6 day', strtotime(date('Y-m-d'))); 	

					} else {

						$allowable_end_date = strtotime('+12 day', $current_timestamp); 

						$allowable_start_date = strtotime('+6 day', strtotime(date('Y-m-d'))); 

					}

					break;

				case 7: //Sunday

					if($past_3pm == 'yes') {

						$allowable_end_date = strtotime('+11 day', $current_timestamp); 	

						$allowable_start_date = strtotime('+5 day', strtotime(date('Y-m-d'))); 

					} else {

						$allowable_end_date = strtotime('+11 day', $current_timestamp); 

						$allowable_start_date = strtotime('+5 day', strtotime(date('Y-m-d'))); 

					}

					break;

			} //end 4-8 days switch

		} //end if 4-8 days

		

		

		

		//Dates in string format

		$allowed_start_converted = date('m/d/Y',$allowable_start_date); 

		//$test = strtotime('+3 day', $allowable_end_date);
		//echo 'test is ' . $test;
		//$allowable_end_date_converted = date('m/d/Y',strtotime('+3 day', $allowable_end_date));
		$allowed_end_converted = date('m/d/Y',$allowable_end_date);
		
		//echo '<br />The PHP Allowed Start Date is ' . $allowed_start_converted . '<br />';
		//echo 'The PHP Allowed End Date is ' . $allowed_end_converted . '<br />';

		

		//echo 'allowed_start_converted is: ' . $allowed_start_converted . '<br/><br/>';

	} //end function date_check()

	





	

	//DEBUGGING

	//echo $past_3pm . '<br/>';

	//echo 'The allowed start date: ' . date('m/d/Y',$allowable_start_date) . '<br/>';

	//echo 'The allowed end date: ' . date('m/d/Y',$allowable_end_date) . '<br/>';

	/*echo 'allowed start date is: ' . $allowable_start_date . '<br/><br/>';

	

	echo 'allowed start converted date is: ' . $allowed_start_converted . '<br/><br/>';

	echo 'allowed end converted date is: ' . $allowed_end_converted . '<br/><br/>';





	

	echo '<br/><br/>' . $test . '<br/><br/>';*/

	/*$new_date_regex = '/(0[1-9]|1[012])[\/](0[1-9]|[12][0-9]|3[01])[\/](19|20\d\d)/';

	echo '<br/>PREG MATCH TEST<br/>';

	$test_date = '12/25/2010';

	if(preg_match($new_date_regex, $test_date)) {

	  echo 'this date is formatted correctly';  

	} else {

	  echo 'this date is not formatted correctly';  

	}*/



	

	

	

	

	

	

	

	

	

	

	

	

	

	//PHP Validation

	/*if(($_POST['shipping_time_english'] == '1-3 work days') || ($_POST['shipping_time_english'] == '4-8 work days')) {

		

		date_check($_POST['shipping_time_english'],$_POST['rush_needed_by_english']);

		

		if($_POST['rush_needed_by_english'] == '') {

			$rush_english_error = '<div id="english_rush_error" class="error">Specify a rush date.</div>';

			$error_array['rush_english_error'] = true;

		} else if(!preg_match($date_regex, $_POST['rush_needed_by_english'])) {

			$rush_english_error = '<div class="rush_date_error error">Enter a valid date format. Ex: 04/09/2010</div>';

			$error_array['rush_english_error'] = true;

		} else if($entered_date_timestamp < $allowable_start_date || $entered_date_timestamp > $allowable_end_date) { //If the date entered is before the allowed start date or after the allowed end date

			$date_english_format_error = '<div class="date_format_error error">The date must be a weekday between '.$allowed_start_converted.' and '.$allowed_end_converted.'</div>';

			$error_array['date_format_error'] = true;

		} else if($is_weekend_day == 'yes') { //If the date entered is before the allowed start date or after the allowed end date

			$date_english_format_error = '<div class="date_format_error error">The date must be a weekday.</div>';

			$error_array['date_format_error'] = true;

		}

	}

	

	if(($_POST['shipping_time_foreign'] == '1-3 work days') || ($_POST['shipping_time_foreign'] == '4-8 work days')) {

		

		date_check($_POST['shipping_time_foreign'],$_POST['rush_needed_by_foreign']);

		

		if($_POST['rush_needed_by_foreign'] == '') {

			$rush_foreign_error = '<div id="foreign_rush_error" class="error">Specify a rush date.</div>';

			$error_array['rush_foreign_error'] = true;

		} else if(!preg_match($date_regex, $_POST['rush_needed_by_foreign'])) {

			$rush_foreign_error = '<div class="rush_date_error error">Enter a valid date format.</div>';

			$error_array['rush_foreign_error'] = true;

		} else if($entered_date_timestamp < $allowable_start_date || $entered_date_timestamp > $allowable_end_date) { //If the date entered is before the allowed start date or after the allowed end date

			$date_foreign_format_error = '<div class="date_format_error error">The date must be a weekday between '.$allowed_start_converted.' and '.$allowed_end_converted.'</div>';

			$error_array['date_format_error'] = true;

		} else if($is_weekend_day == 'yes') { //If the date entered is before the allowed start date or after the allowed end date

			$date_foreign_format_error = '<div class="date_format_error error">The date must be a weekday.</div>';

			$error_array['date_format_error'] = true;

		}

	}

	

	if(($_POST['shipping_time_425x55'] == '1-3 work days') || ($_POST['shipping_time_425x55'] == '4-8 work days')) {

		

		date_check($_POST['shipping_time_425x55'],$_POST['rush_needed_by_425x55']);

		

		if($_POST['rush_needed_by_425x55'] == '') {

			$rush_425x55_error = '<div id="rush_error_425x55" class="error">Specify a rush date.</div>';

			$error_array['rush_425x55_error'] = true;

		} else if(!preg_match($date_regex, $_POST['rush_needed_by_425x55'])) {

			$rush_425x55_error = '<div class="rush_date_error error">Enter a valid date format.</div>';

			$error_array['rush_425x55_error'] = true;

		} else if($entered_date_timestamp < $allowable_start_date || $entered_date_timestamp > $allowable_end_date) { //If the date entered is before the allowed start date or after the allowed end date

			$date_425x55_format_error = '<div class="date_format_error error">The date must be a weekday between '.$allowed_start_converted.' and '.$allowed_end_converted.'</div>';

			$error_array['date_format_error'] = true;

		} else if($is_weekend_day == 'yes') { //If the date entered is before the allowed start date or after the allowed end date

			$date_425x55_format_error = '<div class="date_format_error error">The date must be a weekday.</div>';

			$error_array['date_format_error'] = true;

		}	

	}

	

	if(($_POST['shipping_time_55x85'] == '1-3 work days') || ($_POST['shipping_time_55x85'] == '4-8 work days')) {

		

		date_check($_POST['shipping_time_55x85'],$_POST['rush_needed_by_55x85']);

		

		if($_POST['rush_needed_by_55x85'] == '') {

			$rush_55x85_error = '<div id="rush_error_55x85" class="error">Specify a rush date.</div>';

			$error_array['rush_55x85_error'] = true;

		} else if(!preg_match($date_regex, $_POST['rush_needed_by_55x85'])) {

			$rush_55x85_error = '<div class="rush_date_error error">Enter a valid date format.</div>';

			$error_array['rush_55x85_error'] = true;

		} else if($entered_date_timestamp < $allowable_start_date || $entered_date_timestamp > $allowable_end_date) { //If the date entered is before the allowed start date or after the allowed end date

			$date_55x85_format_error = '<div class="date_format_error error">The date must be a weekday between '.$allowed_start_converted.' and '.$allowed_end_converted.'</div>';

			$error_array['date_format_error'] = true;

		} else if($is_weekend_day == 'yes') { //If the date entered is before the allowed start date or after the allowed end date

			$date_55x85_format_error = '<div class="date_format_error error">The date must be a weekday.</div>';

			$error_array['date_format_error'] = true;

		}	

	}*/

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	



	

    if(in_array(true, $error_array)) {

		$has_error = true;

	}

	

	if($has_error != true) { //If there is no error, then save the values and go to the next page

	

		//Shipping Options

		//English Shipping 

		$_SESSION['shipping']['english']['timespan'] = $_POST['shipping_time_english'];

		$_SESSION['shipping']['english']['rush_date'] = $_POST['rush_needed_by_english'];

		

		//Foreign Shipping

		$_SESSION['shipping']['foreign']['timespan'] = $_POST['shipping_time_foreign']; //This saves the foreign language shipping info into a multidimensional array

		$_SESSION['shipping']['foreign']['rush_date'] = $_POST['rush_needed_by_foreign'];

			

		//4.25 x 5.5 Notepads Shipping

		$_SESSION['shipping']['425x55']['timespan'] = $_POST['shipping_time_425x55'];

		$_SESSION['shipping']['425x55']['rush_date'] = $_POST['rush_needed_by_425x55'];

	

		//5.5 x 8.5 Notepads Shipping

		$_SESSION['shipping']['55x85']['timespan'] = $_POST['shipping_time_55x85'];

		$_SESSION['shipping']['55x85']['rush_date'] = $_POST['rush_needed_by_55x85'];

		

		if($_SESSION['ordering_step'] == 5) { //if the ordering step is set to 5, then make it 6

			$_SESSION['ordering_step']++;	

		}

		

		header('Location: comments.php');
		exit;

	}

} //end if isset shipping next

 

 

/*//These are the saved session variables

foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop

	//if($value != '') {

		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

	//}

} 



echo '<br/>Contact Numbers<br/>';



if($_SESSION['contact']) {

	foreach ($_SESSION['contact'] as $counter => $contact_array) { //This specifies the $_SESSION['order'] array to loop through 

		echo '<br />';

		echo $counter;

		echo '<br />';

		foreach ($contact_array as $key => $value) { //This specifies the array within the $_SESSION['order'] array

			echo $key . ': ' . $value;

			echo '<br />';

			//$_SESSION['extra_number'][$counter][$key] = $value;

			$extra_number[$counter][$key] = $value;



		} //end foreach

		echo '<br />';

	} //end of outer foreach loop

}



//echo $_SESSION['extra_number'][1]['additional_contact'];

echo $extra_number[1]['additional_contact']; */













































?>









<div id="container">





<?php include("includes/header.php"); ?>





    <form id="clientForm" name="clientForm" method="post" action=""><!-- Begin Form -->

          

        <div class="form_container" id="shipping_details"> 

                <div class="row">

                	<div class="clientform_table_header" colspan="2">Shipping Options<br /> <span class="warning">Turn around: from time purchasing / supplier receives the manager approval</span></div>

           		</div>       

                <div class="row clearBoth">   

                    <div class="content">

                        <?php

                        //ENGLISH ONLY CARDS

                        echo '<p class="shipping_title">English Only Cards</p>';

                        if($_SESSION['english_cards_ordered'] == 'yes') {

                            echo 'Quantity: ' . $_SESSION['english_only'] . '<br />'; 

                        ?>

                            <div class="shipping_content" style="float:left;"> 

                                <input id="shipping_time_english_10" type="radio" name="shipping_time_english" value="10 work days" <?php if($_POST['shipping_time_english'] == '10 work days') {echo 'checked="checked"';} else if($_SESSION['shipping']['english']['timespan'] == '10 work days' || !isset($_SESSION["shipping_time_english"])) { echo 'checked="checked"';} ?>> <label for="shipping_time_english_10" style="font-weight: normal;">10 Work days (Standard)</label>

                                <br />

                                <input id="shipping_time_english_48" type="radio" name="shipping_time_english" value="4-8 work days" <?php if($_POST['shipping_time_english'] == '4-8 work days') {echo 'checked="checked"';} else if($_SESSION['shipping']['english']['timespan'] == '4-8 work days') { echo 'checked="checked"';} ?>> <label for="shipping_time_english_48" style="font-weight: normal;">4-8 Work days (50% RUSH)</label>

                                <br />

                                <input id="shipping_time_english_13" type="radio" name="shipping_time_english" value="1-3 work days" <?php if($_POST['shipping_time_english'] == '1-3 work days') {echo 'checked="checked"';} else if($_SESSION['shipping']['english']['timespan'] == '1-3 work days') { echo 'checked="checked"';} ?>> <label for="shipping_time_english_13" style="font-weight: normal;">1-3 Work days (100% RUSH)</label>

                            </div>

                       </div> <!--end content-->

                       <div class="content" id="english_rush_area">

                           <div class="rush_needed_content">

                                <label for="rush_needed_by_english">RUSH NEEDED BY</label>

                                <br />  

                                <input id="rush_needed_by_english" name="rush_needed_by_english" class="text" type="text" value="<?php if(isset($_POST['rush_needed_by_english'])) {echo $_POST['rush_needed_by_english'];} else {echo $_SESSION['shipping']['english']['rush_date'];} ?>" />

                                <p id="english_rush_warning" class="warning">(Only if Rush is selected)</p>

                                <noscript><p id="english_rush_warning" class="warning">Use MM/DD/YYYY format</p></noscript>

                                <?php if(isset($rush_english_error)) { echo $rush_english_error; } else if(isset($date_english_format_error)) { echo $date_english_format_error; } ?>

                            </div> 

                         

                        <?php     	

                        } else {

                            echo 'No English Only cards were selected';	

                        }

                    ?>

                    </div> <!--end content-->

                </div> <!--end row-->

                

                

                

                

                

                

                <div class="row clearBoth">

                	<p id="foreign_shipping_title" class="shipping_title">English on the front w/ foreign language on back Cards</p>   

                    <div class="content">

						<?php

                            //FOREIGN CARDS

                            

							if($_SESSION['foreign_cards_ordered'] == 'yes') {

								

                            if($_SESSION["language"] != '') { $language = stripslashes($_SESSION["language"]);} else { $language = $_SESSION["other_language"];}

							

							

                            //This echos the main foreign language card information

                            if($_SESSION['foreign_toggle'] == 'on') {

								echo 'Language: ' . $language . '<br />';

                                echo 'Quantity: ' . $_SESSION['english_w_foreign'] . '<br />';

                            }

                            

                            ?>

                        

                        <!--This is the first shipping options area-->

                        <div class="shipping_content" style="float:left;"> 

                            <input id="shipping_time_foreign_10" type="radio" name="shipping_time_foreign" value="10 work days" <?php if($_POST['shipping_time_foreign'] == '10 work days') {echo 'checked="checked"';} else if($_SESSION['shipping']['foreign']['timespan'] == '10 work days' || !isset($_SESSION['shipping']['shipping_time_foreign'])) { echo 'checked="checked"';} ?>> <label for="shipping_time_foreign_10" style="font-weight: normal;">10 Work days (Standard)</label>

                            <br />

                            <input id="shipping_time_foreign_48" type="radio" name="shipping_time_foreign" value="4-8 work days" <?php if($_POST['shipping_time_foreign'] == '4-8 work days') {echo 'checked="checked"';} else if($_SESSION['shipping']['foreign']['timespan'] == '4-8 work days') { echo 'checked="checked"';} ?>> <label for="shipping_time_foreign_48" style="font-weight: normal;">4-8 Work days (50% RUSH)</label>

                            <br />

                            <input id="shipping_time_foreign_13" type="radio" name="shipping_time_foreign" value="1-3 work days" <?php if($_POST['shipping_time_foreign'] == '1-3 work days') {echo 'checked="checked"';} else if($_SESSION['shipping']['foreign']['timespan'] == '1-3 work days') { echo 'checked="checked"';} ?>> <label for="shipping_time_foreign_13" style="font-weight: normal;">1-3 Work days (100% RUSH)</label>

                        </div>

					</div> <!--end content-->

                    <div class="content" id="rush_needed_by_area">

                        <div class="rush_needed_content">

                            <label for="rush_needed_by_foreign">RUSH NEEDED BY</label>

                            <br />  

                            <input id="rush_needed_by_foreign" name="rush_needed_by_foreign" class="text" type="text" value="<?php if(isset($_POST['rush_needed_by_foreign'])) {echo $_POST['rush_needed_by_foreign'];} else {echo $_SESSION['shipping']['foreign']['rush_date'];} ?>" />

                            <p id="foreign_rush_warning" class="warning">(Only if Rush is selected)</p>

                            <noscript><p id="english_rush_warning" class="warning">Use MM/DD/YYYY format</p></noscript>

                            <?php if(isset($rush_foreign_error)) { echo $rush_foreign_error; } else if(isset($date_foreign_format_error)) { echo $date_foreign_format_error; }?>

                        </div>

                        

                        

                        <?php

					} else {

						echo 'No foreign language cards were selected';	

					}                        

                        

                        

                        ?>

                    

                	</div> <!--end content div-->

                </div> <!--End of row holding the foreign order information-->

                

                <div class="row">

                	

                    <p id="notepads_title" class="shipping_title">Notepads</p>

                    

                    <?php

                    //NOTEPADS   

                    if(isset($_SESSION['notepad_size_425x55'])) { 

                    ?>

                        <div id="notepads_425x55">

                            <div class="content">

                            <?php

                                echo '<div class="notepad_shipping_info">';		

                                    echo 'Size: 4.25 x 5.5 <br />';

                                echo '</div';

                            ?>

                                <div class="shipping_content" style="float:left;"> 

                                    <input type="radio" name="shipping_time_425x55" value="10 work days" <?php if($_POST['shipping_time_425x55'] == '10 work days') {echo 'checked="checked"';} else if($_SESSION['shipping']['notepads']['425x55']['timespan'] == '10 work days' || !isset($_SESSION["shipping_time_425x55"])) { echo 'checked="checked"';} ?>> 10 Work days (Standard)

                                </div> <!--end shipping content-->

                            </div> <!--end content-->

                        </div> <!--end notepads 425x55-->



                    <?php

                    } //end if notepad size 425x55

                    if(isset($_SESSION['notepad_size_55x85'])) {

                    ?>

                        <div id="notepads_55x85">

                            <div class="content">

                                <?php

                                echo '<div class="notepad_shipping_info">';

                                    echo 'Size: 5.5 x 8.5 <br />';

                                echo '</div';

                                ?>

                                <div class="shipping_content" style="float:left;"> 

                                    <input type="radio" name="shipping_time_55x85" value="10 work days" <?php if($_POST['shipping_time_55x85'] == '10 work days') {echo 'checked="checked"';} else if($_SESSION['shipping']['notepads']['55x85']['timespan'] == '10 work days' || !isset($_SESSION["shipping_time_55x85"])) { echo 'checked="checked"';} ?>> 10 Work days (Standard)

                                </div> <!--end shipping content-->

                            </div> <!--end content-->

                            

                        </div> <!--end notepads 55x85-->

                    

                    <?php

                    

                    } //end if notepad size 55x85



                    if(!isset($_SESSION['notepad_size_425x55']) && !isset($_SESSION['notepad_size_55x85'])) {

                    ?>

                        <div id="no_notepads_selected">

                            <div class="content">

                                <?php

                                echo 'No notepads were selected';



                                ?>

                            </div> <!--end content-->

                        </div> <!--end no notepads selected-->

                    <?php

                    } //end if no notepad_425x55 and notepad_55x85

                    ?> 

                </div> <!--end notepads row-->

                

                

                <div class="row">

                    <div class="content" style="overflow:hidden;"><input class="button prev submit" type="submit" name="shipping_prev" value="Previous Step" /></div> 

                    <div class="content" id="last_content"><input class="button next submit" id="shipping_submit" type="submit" name="shipping_next" value="Next Step" /></div>

                </div>          

         

          

    </form><!-- End Form --> 

</div>



</body>



</html>