<?php

$four_part_name = 'Christopher Tim Gerald Seckler';
$three_part_name = 'Christopher Timothy Seckler';
$comma_name = 'Chris Seckler, Ph.D.';
$both_name = 'Chris Tim Seckler, Ph.D.';


//Series of functions to separate the full name into separate first name, last name, and professional title

	//Testing different scenarios
	$_POST['full_name'] = $four_part_name;
	//$_POST['full_name'] = $three_part_name;
	//$_POST['full_name'] = $comma_name;
	//$_POST['full_name'] = $both_name;
	
	
	$_POST['full_name'] = trim($_POST['full_name']); //trim the whitespace off the beginning and end

	$comma_pos = strpos($_POST['full_name'], ','); //Finds the first occurrence of a comma within the full name
	
	

	

	if(!$comma_pos) { //If there is no comma then just separate the First and Last Name into variables
	
		$num_spaces = substr_count($_POST['full_name'], ' '); //Number of Spaces in Name before a comma if applicable

		$first_space_pos = strpos($_POST['full_name'], ' '); //This is the first occurrence of a space within the full name

		$last_space_pos = strrpos($_POST['full_name'], ' '); //This is the last occurrence of a space within the full name

		$first_name = substr($_POST['full_name'], 0, $first_space_pos); //This is the first name
		
		$middle_and_last_name = substr($_POST['full_name'], $first_space_pos+1, strlen($_POST['full_name']));
		echo '<br />This is the String to Search for the next space(first space within that string): ' . $middle_and_last_name . '<br />'; 
		
		$middle_space_pos = strpos($middle_and_last_name, ' '); //Finds the next occurence of a space
		
		echo 'First Space Position: '.$first_space_pos . '<br />'; 
		echo '2nd Space Position: '.$middle_space_pos . '<br />'; 
		echo 'Last Space Position: '.$last_space_pos . '<br />'; 
		
		//Checks for the last space in the name
		if(substr_count($middle_and_last_name, ' ') > 1) { //Multiple word middle name
			$middle_last_name_last_space_pos = strrpos($middle_and_last_name, ' '); //This is the last occurrence of a space within the Middle and Last Name
			$middle_name = substr($middle_and_last_name, 0, $middle_last_name_last_space_pos);	
		} else { //One word middle name
			$middle_last_name_last_space_pos = strrpos($middle_and_last_name, ' '); //This is the last occurrence of a space within the Middle and Last Name
			$middle_name = substr($middle_and_last_name, 0, $middle_last_name_last_space_pos);
		}

		$last_name = substr($_POST['full_name'], $last_space_pos+1); //This is the last name
		
		$m = strlen($middle_name)+1;
		echo 'mmm' . $m;
		
		
		

	} else{ //If there is a comma then divide the First, Last, and Professional Title into separate variables

		$first_last_name = substr($_POST['full_name'], 0, $comma_pos); //This is the first and last name together

		$pro_title = substr($_POST['full_name'], $comma_pos+1); //This is the professional title

		$last_space_pos = strrpos($first_last_name, ' '); //This is the last occurrence of a space within the first and last name

		$first_name = substr($first_last_name, 0, $last_space_pos); //This is the first name

		$last_name = substr($first_last_name, $last_space_pos+1); //This is the last name
		
		$num_spaces = substr_count($first_last_name, ' '); //Number of Spaces in Name before a comma if applicable
	}
	
	
echo '<b style="width: 125px; display: inline-block;">Full Name:</b> ' . $_POST['full_name'];

echo '<br />';

echo '<b style="width: 125px; display: inline-block;">First Name:</b> ' . $first_name;

echo '<br />';

echo '<b style="width: 125px; display: inline-block;">Last Name:</b> ' . $last_name;

echo '<br />';

echo '<b style="width: 125px; display: inline-block;">Professional Title:</b> '; if($pro_title) { echo  $pro_title; } else { echo 'N/A'; }

echo '<br />';

echo '<b style="width: 125px; display: inline-block;">Middle Name:</b> '; if($middle_name) { echo  $middle_name; } else { echo 'N/A'; }

echo '<br />';

echo '<b style="width: 125px; display: inline-block;">2nd Middle Name:</b> '; if($middle_name2) { echo  $middle_name2; } else { echo 'N/A'; }

echo '<br />';

echo '<b style="width: 125px; display: inline-block;"># of Spaces:</b> '; if($num_spaces) { echo  $num_spaces; } else { echo 'No Spaces'; }
?>