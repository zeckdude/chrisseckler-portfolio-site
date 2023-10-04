<?php

//Variables for testing
$two_part_name = 'Chris Seckler';
$three_part_name = 'Christopher Timothy Seckler';
$four_part_name = 'Christopher Tim Gerald Seckler';
$comma_name = 'Chris Seckler, Ph.D.';
$three_both_name = 'Chris Tim Seckler, Ph.D.';
$four_both_name = 'Chris Tim Gerald Seckler, Ph.D.';


//Testing different scenarios
$_POST['full_name'] = $two_part_name;
//$_POST['full_name'] = $three_part_name;
//$_POST['full_name'] = $four_part_name;
//$_POST['full_name'] = $comma_name;
//$_POST['full_name'] = $three_both_name;
//$_POST['full_name'] = $four_both_name;


$_POST['full_name'] = trim($_POST['full_name']); //trim the whitespace off the beginning and end
$comma_pos = strpos($_POST['full_name'], ','); //Finds the first occurrence of a comma within the full name


//Series of functions to separate the full name into separate first name, last name, and professional title
if($comma_pos) { //If there is a comma in the name then remove the contents after the comma and save the rest as the full name	
	$first_last_name = substr($_POST['full_name'], 0, $comma_pos); //This is the first and last name together
	$pro_title = substr($_POST['full_name'], $comma_pos+1); //This is the professional title
} else if(!$comma_pos) { //If there is no comma then just use the full name as the name
	$first_last_name = $_POST['full_name'];
}

$num_spaces = substr_count($first_last_name, ' '); //Number of Spaces in Name before a comma if applicable

$first_space_pos = strpos($first_last_name, ' '); //This is the first occurrence of a space within the full name

$last_space_pos = strrpos($first_last_name, ' '); //This is the last occurrence of a space within the full name

$first_name = substr($first_last_name, 0, $first_space_pos); //This is the first name

$middle_and_last_name = substr($first_last_name, $first_space_pos+1, strlen($first_last_name));

$middle_space_pos = strpos($middle_and_last_name, ' '); //Finds the next occurence of a space 

$middle_last_name_last_space_pos = strrpos($middle_and_last_name, ' '); //This is the last occurrence of a space within the Middle and Last Name

$middle_name = substr($middle_and_last_name, 0, $middle_last_name_last_space_pos);

$last_name = substr($first_last_name, $last_space_pos+1); //This is the last name
		
		
		

	
	
	
echo '<b style="width: 125px; display: inline-block;">Full Name:</b> ' . $_POST['full_name'];

echo '<br />';

echo '<b style="width: 125px; display: inline-block;">First Name:</b> ' . $first_name;

echo '<br />';

echo '<b style="width: 125px; display: inline-block;">Middle Name(s):</b> '; if($middle_name) { echo  $middle_name; } else { echo 'N/A'; }

echo '<br />';

echo '<b style="width: 125px; display: inline-block;">Last Name:</b> ' . $last_name;

echo '<br />';

echo '<b style="width: 125px; display: inline-block;">Professional Title:</b> '; if($pro_title) { echo  $pro_title; } else { echo 'N/A'; }

echo '<br />';

echo '<b style="width: 125px; display: inline-block;"># of Spaces:</b> '; if($num_spaces) { echo  $num_spaces; } else { echo 'No Spaces'; }
?>

























