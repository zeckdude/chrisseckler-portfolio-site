<?php

session_start();

ob_start();



date_default_timezone_set('America/Los_Angeles');

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Order Center - Admin Options</title>

<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" charset="utf-8" />

<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<link rel="shortcut icon" href="../images/favicon.gif" />

</head>



<script src="../js/jquery-1.4.2.min.js" type="text/javascript"></script>











<body>





<div id="container">





<?php 











include("../includes/connection.php");

include("../includes/admin_header.php");

$conn = dbConnect('admin');





if(!isset($_SESSION['authenticated_oc'])){

	header('Location: ' . $site_basedir . 'login.php');

}



if(!isset($_GET['building_id'])){

	header('Location: ' . $site_basedir . 'admin/tracker.php');

}



$sql = 'SELECT *

		FROM buildings

		WHERE building_id = ' . $_GET['building_id'];



$result = $conn->query($sql) or die(mysqli_error());

$row = mysqli_fetch_assoc($result);























if(isset($_POST['edit_accept'])) {

	

	foreach($_POST as $key => $value) {

		$_POST[$key] = sanitize($conn, $value); //This sanitizes the current session variable and then saves it back as the same session variable name

	}



	$_SESSION['address'] = $_POST['address'];



	if($_POST['address'] != '') {				

		//This adds the note marking a change in status		

		$sql = 'UPDATE buildings SET

				building_num = '.$_POST['building_num'].',

				address = "'.$_POST['address'].'",

				po_box = "'.$_POST['po_box'].'",

				city = "'.$_POST['city'].'",

				state = "'.$_POST['state'].'",

				zip_1 = "'.$_POST['zip_1'].'",

				zip_2 = "'.$_POST['zip_2'].'"

				WHERE building_id =' . $_GET['building_id'];

		

		$result = $conn->query($sql) or die(mysqli_error($conn));



		header('Location: ' . $site_basedir . 'admin/address_edit.php?building_id=' . $_GET['building_id'] . '&address_edited=1');

		exit;

	} else {

		$address_error = '<p class="error_message">Please provide an address to be added.</p>';	

	}

}



if(isset($_POST['edit_cancel'])) {

	header('Location: ' . $site_basedir . 'admin/options.php');

	exit;

}









if(isset($_GET['address_edited'])) {	

?>

	<div class="form_container" id="thank_you_box">  

        <div class="row">

            <div class="clientform_table_header">The address was edited</div>   

        </div>

        

        <div class="row">

            <div class="content">

                <p>Your changes were saved. You will be redirected in 3 seconds.</p>

                <?php

					header( 'refresh: 2; url=' . $site_basedir . '/admin/options.php' );

				?>

			</div>

          </div>       

    </div>





<?php } else { ?>





    

    <div class="form_container" id="address_box">  

        <div class="row">

            <div class="clientform_table_header">Edit Address</div>   

        </div>

        

        

        

        <div class="row">

            <div class="content">

            <h4><u>Edit an Applied Building address</u></h4>

            

            <div id="address_form_content">    

                <form id="clientForm" name="clientForm" method="post" action="">

                

                <span class="address_line">

                	<p class="floatleft">Building #:</p>

                	<input type="text" name="building_num" style="width: 20px;" value="<?php echo $row['building_num']; ?>"></input>

                </span>

               

               <span class="address_line">     

                    <p class="floatleft">Street Address:</p>

                	<input type="text" name="address" style="width: 200px;" value="<?php echo $row['address']; ?>"></input>

                </span>

               

               <span class="address_line">     

                    <p class="floatleft">PO Box:</p>

                	<input type="text" name="po_box" style="width: 45px;" value="<?php echo $row['po_box']; ?>"></input>

                </span>

               

               <span class="address_line">     

                    <p class="floatleft">City:</p>

                	<input type="text" name="city" style="width: 200px;" value="<?php echo $row['city']; ?>"></input>

                </span>

               

               <span class="address_line">     

                    <p class="floatleft">State:</p>

                	<?php

						$states_array = array(

							'AL'=>"Alabama",  

							'AK'=>"Alaska",  

							'AZ'=>"Arizona",  

							'AR'=>"Arkansas",  

							'CA'=>"California",  

							'CO'=>"Colorado",  

							'CT'=>"Connecticut",  

							'DE'=>"Delaware",  

							'DC'=>"DC",  

							'FL'=>"Florida",  

							'GA'=>"Georgia",  

							'HI'=>"Hawaii",  

							'ID'=>"Idaho",  

							'IL'=>"Illinois",  

							'IN'=>"Indiana",  

							'IA'=>"Iowa",  

							'KS'=>"Kansas",  

							'KY'=>"Kentucky",  

							'LA'=>"Louisiana",  

							'ME'=>"Maine",  

							'MD'=>"Maryland",  

							'MA'=>"Massachusetts",  

							'MI'=>"Michigan",  

							'MN'=>"Minnesota",  

							'MS'=>"Mississippi",  

							'MO'=>"Missouri",  

							'MT'=>"Montana",

							'NE'=>"Nebraska",

							'NV'=>"Nevada",

							'NH'=>"New Hampshire",

							'NJ'=>"New Jersey",

							'NM'=>"New Mexico",

							'NY'=>"New York",

							'NC'=>"North Carolina",

							'ND'=>"North Dakota",

							'OH'=>"Ohio",  

							'OK'=>"Oklahoma",  

							'OR'=>"Oregon",  

							'PA'=>"Pennsylvania",  

							'RI'=>"Rhode Island",  

							'SC'=>"South Carolina",  

							'SD'=>"South Dakota",

							'TN'=>"Tennessee",  

							'TX'=>"Texas",  

							'UT'=>"Utah",  

							'VT'=>"Vermont",  

							'VA'=>"Virginia",  

							'WA'=>"Washington",  

							'WV'=>"West Virginia",  

							'WI'=>"Wisconsin",  

							'WY'=>"Wyoming");

						?>

    

                    <select id="state" name="state">

                        <option value="0">Choose a state</option>

                        <?php 

                            foreach($states_array as $key => $value){ 

                        ?>

                                <option value="<?php echo $value; ?>" <?php if($_POST["state"] == $value) { echo 'selected';} else if($row['state'] == $value) { echo 'selected';} ?>><?php echo $value; ?></option>

                        <?php     

                            }

                        ?>

                    </select>

            </span>

              

              <span class="address_line">  

                    <p class="floatleft">Zip Code:</p>

                    <input type="text" name="zip_1" style="width: 45px;" value="<?php echo $row['zip_1']; ?>" MAXLENGTH="5"></input> - <input type="text" name="zip_2" style="width: 37px;" value="<?php echo $row['zip_2']; ?>" MAXLENGTH="4"></input>

			</span>

              

            </div>  

                    <input class="button prev submit" type="submit" name="edit_cancel" value="Go back without saving" />

                    <input class="button next submit" type="submit" name="edit_accept" value="Save changes" /></form>

                    

                <?php if(isset($address_error)) {echo $address_error;} ?>

                

			</div>

          </div> 

          

		    

         

    </div> 

     

<?php }   





	?>    

          

		 

</div>



</body>



</html>