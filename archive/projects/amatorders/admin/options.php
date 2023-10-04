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





if(isset($_POST['add_address'])) {

	

	//Function to check whether a string is an integer

	function isint( $mixed )

	{

		return ( preg_match( '/^\d*$/'  , $mixed) == 1 );

	}

	

	

	if($_POST['building_num'] != '') {

		if(isint($_POST['building_num'])) {

			$sql = "SELECT *

					FROM buildings

					WHERE building_num = " . $_POST['building_num'];

			

			$result = $conn->query($sql) or die(mysqli_error());

			$row_cnt = $result->num_rows;

		}

	}

	

	

	

	foreach($_POST as $key => $value) {

		$_POST[$key] = sanitize($conn, $value); //This sanitizes the current session variable and then saves it back as the same session variable name

	}



	$_SESSION['address'] = $_POST['address'];



	$has_error = false;

	$error_array = array();

	$address_error = '<div class="error" style="float: left;">';

	

	

	

	

	/*if($_POST['building_num'] == '') {

		$address_error .= '<div class="error_line">The building number is required.</div>';

		$error_array['building_num'] = true;

	} else*/ if(!isint($_POST['building_num']) && $_POST['building_num'] != '') {

		$address_error .= '<div class="error_line">The building number must be an integer.</div>';

		$error_array['building_num'] = true;

	} else if($row_cnt > 0) {

		$address_error .= '<div class="error_line">There already is a building with this number. Please choose another one.</div>';

		$error_array['building_num'] = true;	

	}

	

	if($_POST['address'] == '') {

		$address_error .= '<div class="error_line">The address is required.</div>';

		$error_array['address'] = true;

	}

	

	if($_POST['city'] == '') {

		$address_error .= '<div class="error_line">The city is required.</div>';

		$error_array['address'] = true;

	}

	

	if($_POST['state'] == '0') {

		$address_error .= '<div class="error_line">The state is required.</div>';

		$error_array['address'] = true;

	}

	

	if($_POST['zip_1'] == '') {

		$address_error .= '<div class="error_line">The first five zip code digits are required.</div>';

		$error_array['address'] = true;

	}

	

	

	if(in_array(true, $error_array)) {	

		$has_error = true;

		$address_error .= '</div>';

	}

	

	if($has_error != true) { //If there is no error, add a new building

	

		

			

		//This adds the note marking a change in status		

		$sql = 'INSERT into buildings SET ';

		

		if($_POST['building_num'] != '' && $_POST['building_num'] > 0) {

			$sql .=	'building_num = '.$_POST['building_num'].', ';

		}

		

		$sql .=	'address = "'.$_POST['address'].'",

				po_box = "'.$_POST['po_box'].'",

				city = "'.$_POST['city'].'",

				state = "'.$_POST['state'].'",

				zip_1 = "'.$_POST['zip_1'].'",

				zip_2 = "'.$_POST['zip_2'].'"';

		

		//$result = $conn->query($sql) or die(mysqli_error($conn));

		$result = $conn->query($sql) or die($conn->error);



		header('Location: ' . $site_basedir . 'admin/options.php?address_added=1');

	} 





}











if(isset($_GET['address_added'])) {	

?>

	<div class="form_container" id="thank_you_box">  

        <div class="row">

            <div class="clientform_table_header">Your new address was added</div>   

        </div>

        

        <div class="row">

            <div class="content">

                <p>Your address for <?php echo $_SESSION['address']; ?> was added. You will be redirected in 3 seconds.</p>

                <?php

					header( 'refresh: 3; url=' . $site_basedir . '/admin/options.php' );

				?>

			</div>

          </div>       

    </div>





<?php } else { ?>





    

    <div class="form_container" id="address_box">  

        <div class="row">

            <div class="clientform_table_header">Address Options</div>   

        </div>

        

        

        

        <div class="row">

            <div class="content">

            <h4><u>Add a new Applied Building address</u></h4>

             

            <div id="address_form_content">   

                <form id="clientForm" name="clientForm" method="post" action="">

                

                <span class="address_line">

                	<p class="floatleft">Building #:</p>

                	<input type="text" name="building_num" style="width: 20px;" value="<?php if(isset($_POST['building_num'])) {echo $_POST['building_num'];} ?>"></input>

                </span>

                    

                <span class="address_line">

                    <p class="floatleft">Street Address:</p>

                	<input type="text" name="address" style="width: 200px;" value="<?php if(isset($_POST['address'])) {echo $_POST['address'];} ?>"></input>

                </span>

                    

                <span class="address_line">

                    <p class="floatleft">PO Box:</p>

                	<input type="text" name="po_box" style="width: 45px;" value="<?php if(isset($_POST['po_box'])) {echo $_POST['po_box'];} ?>"></input>

               </span>

                    

                <span class="address_line">

                    <p class="floatleft">City:</p>

                	<input type="text" name="city" style="width: 200px;" value="<?php if(isset($_POST['city'])) {echo $_POST['city'];} ?>"></input>

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

                                <option value="<?php echo $value; ?>" <?php if($_POST['state'] == $value) { echo 'SELECTED';} ?>><?php echo $value; ?></option>

                        <?php     

                            }

                        ?>

                    </select>

                

                </span>

                    

                <span class="address_line">

                    <p class="floatleft">Zip Code:</p>

                    <input type="text" name="zip_1" style="width: 45px;" value="<?php if(isset($_POST['zip_1'])) {echo $_POST['zip_1'];} ?>"></input> - <input type="text" name="zip_2" style="width: 37px;" value="<?php if(isset($_POST['zip_2'])) {echo $_POST['zip_2'];} ?>"></input>

              </span>

                    

           </div>

                    <input class="button prev submit" type="submit" name="add_address" value="Add New Address" style="float: left;"/></form>

                	

                   

                <?php if(isset($address_error)) {echo $address_error;} ?>

               

			</div>

          </div> 

          

		<div class="row">

        

        	<?php

				$sql = "SELECT *

						FROM buildings

						ORDER BY building_num";

				

				$result = $conn->query($sql) or die(mysqli_error());	

			

			?>

        	

            <div class="content">

            	<h4><u>Manage current Applied Building addresses</u></h4>

                <table id="address_table">

                	<tr>

                    	<th>Bldg. #</th>

                        <th>Address</th>

                        <th>City</th>

                        <th>State</th>

                        <th>Edit</th>

                        <th>Delete</th>

                	</tr>

                    

                    <?php while($row = mysqli_fetch_assoc($result)) { ?>

                        <tr>

                            <td><?php echo $row['building_num']; ?></td>

                            <td><?php echo $row['address']; ?></td>

                            <td><?php echo $row['city']; ?></td>

                            <td><?php echo $row['state']; ?></td>

                            <td><a href="<?php echo $site_basedir; ?>admin/address_edit.php?building_id=<?php echo $row['building_id']; ?>">&#177;</td>

                            <td><a href="<?php echo $site_basedir; ?>admin/address_delete.php?building_id=<?php echo $row['building_id']; ?>">X</td>

                        </tr>

                	<?php } ?>

                </table>  

			</div>   

        </div>      

         

    </div> 

     

<?php }   





	?>    

          

		 

</div>



</body>



</html>