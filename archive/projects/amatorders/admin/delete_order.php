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







if(!isset($_GET['order_id'])){



	header('Location: ' . $site_basedir . 'admin/tracker.php');



}







$sql = 'SELECT *
		FROM orders
		WHERE order_id = ' . $_GET['order_id'];

$result = $conn->query($sql) or die(mysqli_error());

$row = mysqli_fetch_assoc($result);















































if(isset($_POST['delete_accept'])) {


		/*$sql = 'DELETE FROM buildings



				WHERE building_id =' . $_GET['building_id'];*/
				
		
		$sql = 'UPDATE orders SET
				status = "deleted",
				deleted_datetime = "' . strtotime("now") . '"
				WHERE order_id = ' . $_GET['order_id'];

		$result = $conn->query($sql) or die(mysqli_error($conn));
		
		
		/*$del_sql = 'SELECT *
		FROM deleted_orders';

		$del_result = $conn->query($del_sql) or die(mysqli_error());
		$del_row = mysqli_fetch_assoc($del_result);
		
		
		
		$sql = 'UPDATE deleted_orders SET
				del_orders = "' . $del_row['del_orders'] . '<br />deleted"';

		$result = $conn->query($sql) or die(mysqli_error($conn));*/







		header('Location: ' . $site_basedir . 'admin/delete_order.php?order_id=' . $_GET['order_id'] . '&order_deleted=1');



		exit;



	



}







if(isset($_POST['delete_cancel'])) {



	header('Location: ' . $site_basedir . 'admin/tracker.php');



	exit;



}



















if(isset($_GET['order_deleted'])) {	



?>



	<div class="form_container" id="thank_you_box">  



        <div class="row">



            <div class="clientform_table_header">The order was deleted</div>   



        </div>



        



        <div class="row">



            <div class="content">



                <p>The order for <?php echo $_SESSION['full_name']; ?> was deleted. If for any reason you need access to the order again, please contact your handy dandy web support specialist, and he will work his magic ways to retrieve your order from the bowels of the database.
                
                <br /><br />
                
                You will be redirected in 6 seconds.</p>



                <?php



					header( 'refresh: 6; url=' . $site_basedir . '/admin/tracker.php' );



				?>



			</div>



          </div>       



    </div>











<?php } else { ?>







    <div class="form_container" id="address_box" style="width: 556px; margin: 0 auto;">  



        <div class="row">



            <div class="clientform_table_header">Are you sure you want to delete this order?</div>   



        </div>



        <div class="row">



            <div class="content">



				



                <table id="address_table" style="width: 524px;">



                	<tr>



                    	<th>Order ID</th>



                        <th>Employee ID</th>



                        <th>Name</th>



                        <th>Title</th>



                        <th>Manager Email</th>



                        <th>Ordered</th>



                	</tr>



                    



                    <tr>



                        <td><?php echo $row['order_id']; ?></td>



                        <td><?php echo $row['employee_id']; ?></td>



                        <td><?php echo $row['full_name']; ?></td>



                        <td><?php echo $row['title']; ?></td>



                        <td><?php echo $row['approved_by']; ?></td> 



                        <td><?php 
						
								if($row['english_quantity'] > 0) {

									echo 'English(' . $row['english_quantity'] . ')';

									echo '<br />';

								} 

						

								if($row['foreign_quantity'] > 0) {

									switch($row['language']) {

										case 'Japan':	

											$language = 'Japanese';

											break;

										case 'Korea':	

											$language = 'Korean';

											break;

										case 'Taiwan':	

											$language = 'Taiwanese';

											break;

										case 'People\'s Republic of China':	

											$language = 'Chinese';

											break;			

									}

									

									if($language == '') { $language = $row['other_language']; }

									

									echo  $language . '(' . $row['foreign_quantity'] . ')';

									echo '<br />';

								}

								

								

								

								

								

								if($row['notepad_size_425x55'] == 'yes') {

									echo 'Notepads(4.25x5.5)';

									echo '<br />';

								}

								

								if($row['notepad_size_55x85'] == 'yes') {

									echo 'Notepads(5.5x8.5)';	

								}
						
							?>
						</td> 
                    </tr>

                </table>



			</div>



		</div>



        



        <div class="row">



            <div class="content" style="width: 94%;"> 



            	<form id="clientForm" name="clientForm" method="post" action="">



                	<input class="button prev submit" type="submit" name="delete_cancel" value="Go back without deleting" />



                    <input class="button next submit" type="submit" name="delete_accept" value="Delete Order" />



                </form>



            </div>



		</div>



        



    </div> 



     



<?php }   











	?>    



          



		 



</div>







</body>







</html>