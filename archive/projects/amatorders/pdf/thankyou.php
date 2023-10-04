<?php

session_start();

ob_start();

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Order Form</title>

<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link href="../css/style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="../css/print.css" type="text/css" media="print" />

<link rel="shortcut icon" href="../images/favicon.gif" />

<!--//////////  FOR USERS WITH INTERNET EXPLORER 6  //////////-->
<!--[if IE 6]>
        <link rel="stylesheet" type="text/css" href="../css/ie6.css" />
<![endif]-->

<style type="text/css">
* { behavior: url(../css/iepngfix.htc) }
</style> 
<!--//////////  FOR USERS WITH INTERNET EXPLORER 6  //////////-->

</head>











<body>





<div id="container">





<?php 



/*//These are the saved session variables

foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop

	//if($value != '') {

		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';

	//}

} 
*/


if($_SESSION['proof_accepted'] != 'yes') {

	header('Location: ../index.php');	

}



include("../includes/connection.php");

$conn = dbConnect("query"); 

include("../includes/header.php"); ?>



    <div class="form_container" id="thank_you_box">  

        <div class="row">

            <div class="clientform_table_header">Thank you for your order!</div>   

        </div>

        

        <div class="row">

            <div class="content">

            <div id="all_orders_area" class="print">

                <p>The order for <?php echo $_SESSION["first_name"] . ' ' . $_SESSION["last_name"]; ?> will be sent to our <?php if($_SESSION[foreign_cards_ordered] == 'yes') { echo 'translation'; } else { echo 'printing'; } ?> department pending manager approval. An order receipt has also been sent to  <?php echo $_SESSION["delivery_email"]; ?>. Please keep a record of it.</p>

                <br />



				<?php

                    if($_SESSION['foreign_cards_ordered'] == 'yes' && $_SESSION['upload_later'] == 'yes') {

                        echo '<p>' . $_SESSION['hold_upload_address'] . '</p>';

                    }

                ?>



                <?php

					$num_of_orders = count($_SESSION['order_id']);

						

					if($num_of_orders > 1) {

						echo '<br />';

						echo 'You have selected multiple order shipping dates. In order to more efficiently track your order, it has been split into separate orders by shipping dates.';

					}

				

				?>

                

                

			</div>

            </div>

            

            

            <div class="content">

            

            <div id="all_orders_area" class="print" style="border: 1px solid #5C7F99; width: 200px; ">

                <p>

               

				<?php 

				

						

						

						foreach($_SESSION['order_id'] as $order_key => $order_value) {

							$sql = "SELECT *

									FROM orders 

									WHERE order_id = ".$order_value;

							

							$result = $conn->query($sql) or die(mysqli_error());

							$order_row = $result->fetch_assoc();

							

							echo '<div class="main_item_area">';

							?>

                            

                            

                             <div class="row">

           						 <div class="clientform_table_header" style="padding-left: 8px;">

                            

                            <?php

							echo '<span>Order #:</span> ' . $order_value;

							?>

                            

                            	</div>   

        					</div>

                            

                            <div class="order_content">

                            <?php

							echo '<div class="due_date"><span class="thankyou_title">Approximate Delivery Date:</span> ';

							if($order_row['rush_date'] != '') { 

								echo $order_row['rush_date'];

							} else { 

								echo $order_row['shipping_time'];

							}

							

							echo '</div>';

							$order_row_txt = '<div class="due_date" style="margin-bottom: 20px;"><span class="thankyou_title" style="font-weight: bold;">Shipping Time:</span> ' . $order_row['shipping_time'] . '</div>';

							

							

							

							if($order_row['english_quantity'] > 0) {

								echo '<div class="item_area">';

								echo '<span class="thankyou_title">Order Item: </span>English language Business Cards';

								echo '<br />';

								echo '<span class="thankyou_title">Quantity: </span>' . $order_row['english_quantity'];

								echo '</div>';

								

								$order_row_txt .= '<div class="item_area" style="margin-bottom: 20px;"><span class="thankyou_title" style="font-weight: bold;">Order Item: </span>English language Business Cards<br /><span class="thankyou_title" style="font-weight: bold;">Quantity: </span>' . $order_row['english_quantity'] . '</div>';

							}

							

							if($order_row['foreign_quantity'] > 0) {

								echo '<div class="item_area">';

								echo '<span class="thankyou_title">Order Item: </span>Foreign language Business Cards';

								echo '<br />';

								echo '<span class="thankyou_title">Quantity: </span>' . $order_row['foreign_quantity'];

								echo '<br />';

								echo '<span class="thankyou_title">Foreign Language: </span>';

								

								if($order_row['language'] != '') {

									echo $order_row['language'];

									$order_row_language = $order_row['language'];

								} else {

									echo $order_row['other_language'];

									$order_row_language = $order_row['other_language'];

								}

								

								echo '</div>';

								

								$order_row_txt .= '<div class="item_area" style="margin-bottom: 20px;"><span class="thankyou_title" style="font-weight: bold;">Order Item: </span>Foreign language Business Cards<br /><span class="thankyou_title" style="font-weight: bold;">Quantity: </span>' . $order_row['foreign_quantity'] . '<br /><span class="thankyou_title" style="font-weight: bold;">Foreign Language: </span>' . $order_row_language . '</div>';

							}

							

							if($order_row['notepad_size_425x55'] == 'yes') {

								echo '<div class="item_area">';

								echo '<span class="thankyou_title">Order Item: </span>Notepad';

								echo '<br />';

								echo '<span class="thankyou_title">Size: </span>4.25" x 5.5"';

								echo '</div>';

								

								$order_row_txt .= '<div class="item_area" style="margin-bottom: 20px;"><span class="thankyou_title" style="font-weight: bold;">Order Item: </span>Notepad<br /><span class="thankyou_title" style="font-weight: bold;">Size: </span>4.25" x 5.5"</div>';

							}

							

							if($order_row['notepad_size_55x85'] == 'yes') {

								echo '<div class="item_area">';

								echo '<span class="thankyou_title">Order Item: </span>Notepad';

								echo '<br />';

								echo '<span class="thankyou_title">Size: </span>5.5" x 8.5"';

								echo '</div>';

								

								$order_row_txt .= '<div class="item_area" style="margin-bottom: 20px;"><span class="thankyou_title" style="font-weight: bold;">Order Item: </span>Notepad<br /><span class="thankyou_title" style="font-weight: bold;">Size: </span>5.5" x 8.5"</div>';

							}

							

							

							$date = date("m/j/y");

							$mailTo = $order_row["delivery_email"];

							//$mailFrom = 'order@foreignpro.com';

							$subject = 'Business Card order receipt for ' . $order_row['first_name'] . ' ' . $order_row['last_name'] . '(Order #' . $order_row["order_id"] . ')';

							$message = 

										'<html>

										<head>

										<title>Business Card Order Receipt</title>

										</head>

										<body>

											<table style="width: 400px; border: 1px solid #5C7F99; margin-left: auto; margin-right: auto; margin-top: 35px;">

												<thead>

													<tr style="background: #FFFFFF none repeat-x scroll left center; border-bottom: 1px solid #C2C9CF;"><th colspan="2" style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px;"><span style="font-weight: normal;">Business Card Order Receipt for ' . $order_row['first_name'] . ' ' . $order_row['last_name'] . '(Order #' . $order_row["order_id"] . ')</span></th></tr>   

												</thead>    

												<tbody>

													<tr>

														<td colspan="2" style="padding: 7px 15px; color: #183152; ">

															<p>You are receiving this email because ' . $order_row['first_name'] . ' ' . $order_row['last_name'] . ' placed a business card order at Pro Print & Services on '.date("m/j/y",strtotime($order_row['date_submitted'])).'.</p>

															<p>The order has been submitted and will be printed pending manager approval. This is a summary of your order. Keep this for your records.</p>

															 ' . $order_row_txt . '

														</td>

													</tr>'; 

							

							if($order_row['foreign_quantity'] > 0 && $_SESSION['upload_later'] == 'yes') {

								$message .=

													'<tr>

														<td colspan="2" style="padding: 7px 15px; color: #183152; ">

															You ordered a Foreign language Business Card. You have opted to supply foreign characters at a later time. The order will now be placed on hold. Once you have the characters available, you may upload an image, or type them here: <b><a href="'.$site_basedir.'user_char_upload.php?order_id=' . $order_row['order_id'] . '">Supply Your Foreign Characters</a></b><br /><br />You will receive a proof with the foreign language character side of the card at the email you specified once you supply your characters. Please review that so the order can be processed.

														</td>

													</tr>';

							} else if($order_row['foreign_quantity'] > 0) {

								$message .=

													'<tr>

														<td colspan="2" style="padding: 7px 15px; color: #183152; ">

															You ordered a Foreign language Business Card. You will receive a proof with the foreign language character side of the card at the email you specified. Please review that as soon as possible so the order can be processed.

														</td>

													</tr>';

							}

									

													

													

							$message .= 				

												'</tbody>     

											</table>

										</body>

										</html>';

							

							$headers  = 'MIME-Version: 1.0' . "\r\n";

							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

							$headers .= 'From: Pro Print & Services <' . $pro_print_email . '>';

							

							mail($mailTo, $subject, $message, $headers);
							
							
							
							
							
							//Email sent to Pro Print notifying them of the order
							$mailTo = $pro_print_email;

							//$mailFrom = 'order@foreignpro.com';

							$subject = 'Business Card order placed for ' . $order_row['first_name'] . ' ' . $order_row['last_name'] . '(Order #' . $order_row["order_id"] . ')';

							$message = 

										'<html>

										<head>

										<title>Business Card Order Placed</title>

										</head>

										<body>

											<table style="width: 400px; border: 1px solid #5C7F99; margin-left: auto; margin-right: auto; margin-top: 35px;">

												<thead>

													<tr style="background: #FFFFFF none repeat-x scroll left center; border-bottom: 1px solid #C2C9CF;"><th colspan="2" style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px;"><span style="font-weight: normal;">Business Card Order placed for ' . $order_row['first_name'] . ' ' . $order_row['last_name'] . '(Order #' . $order_row["order_id"] . ')</span></th></tr>   

												</thead>    

												<tbody>

													<tr>

														<td colspan="2" style="padding: 7px 15px; color: #183152; ">

															<p>You are receiving this email because ' . $order_row['first_name'] . ' ' . $order_row['last_name'] . ' placed a business card order on the AMAT Order Center website on '.date("m/j/y",strtotime($order_row['date_submitted'])).'.</p>

															<p>The order is pending manager approval. This is a summary of the order.</p>

															 ' . $order_row_txt . '

														</td>

													</tr>'; 

							

							

									

													

													

							$message .= 				

												'</tbody>     

											</table>

										</body>

										</html>';

							

							$headers  = 'MIME-Version: 1.0' . "\r\n";

							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

							$headers .= 'From: Pro Print & Services <' . $pro_print_email . '>';

							

							mail($mailTo, $subject, $message, $headers);


							

							

							

							



							echo '</div>';

						}

					?></p>

                    </div>

                 </div>   

                    <form><input class="button prev" style="padding: 5px; margin-top: 15px" type="button" value=" Print this page for your records "onclick="window.print();return false;" /></form> 

 

                    

                    

			</div>

            

          </div>       

         

        <div class="row">

            <div class="content" id="thankyou_last_content_1"><a class="button prev" href="../index.php">Back to the AMAT Order Form</a></div>

          	

		</div>

    </div> 

    

    

    

    <?php 

	

	

		

	

	

		session_destroy(); //destroys all the session variables now that we dont need them anymore 

	?> 

          

		 

</div>



</body>



</html>