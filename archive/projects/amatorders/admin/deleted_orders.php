<?php



session_start();



ob_start();







date_default_timezone_set('America/Los_Angeles');



?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">







<html xmlns="http://www.w3.org/1999/xhtml">







<head>



<title>Applied Materials Order Center - List of deleted orders</title>



<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" charset="utf-8" />



<meta http-equiv="Content-type" content="text/html; charset=utf-8" />



<link rel="shortcut icon" href="../images/favicon.gif" />



</head>







<script src="../js/jquery-1.4.2.min.js" type="text/javascript"></script>























<body>











<div id="container" class="del_cont">

<?php 
include("../includes/connection.php");
include("../includes/admin_header.php");
$conn = dbConnect('admin');

if(!isset($_SESSION['authenticated_oc'])){
	header('Location: ' . $site_basedir . 'login.php');
}

$sql = 'SELECT *
		FROM orders
		WHERE status = "deleted"
		ORDER BY order_id ASC';

$result = $conn->query($sql) or die(mysqli_error());

$row = mysqli_fetch_assoc($result);

/*$del_sql = 'SELECT *
		FROM deleted_orders';

		$del_result = $conn->query($del_sql) or die(mysqli_error());
		$del_row = mysqli_fetch_assoc($del_result);*/
		
		
?>

    <div class="form_container" id="address_box">  
        <div class="row">
            <div class="clientform_table_header">List of deleted orders</div>   
        </div>

        <div class="row">
            <div class="content">



				



                <table id="address_table" style="width: 715px;">


				
                	<tr>



                    	<th>Order ID</th>



                        <th>Employee ID</th>



                        <th>Name</th>



                        <th>Title</th>



                        <th>Manager Email</th>



                        <th>Ordered</th>
                        
                        <th>Date/Time<br /> Deleted</th>



                	</tr>



                    


			<?php while($row = mysqli_fetch_assoc($result)) { ?>
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
                        
                        <td><?php if($row['deleted_datetime'] == '0000-00-00 00:00:00') {echo ' ';} else {echo date('n/j/y g:ia',strtotime($row['deleted_datetime'])); } ?></td>  
                    </tr>
			<?php } ?>
                </table>
			


			</div>
        </div> 
    </div> 
</div>







</body>







</html>