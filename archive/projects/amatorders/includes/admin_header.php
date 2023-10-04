



<?php



$conn = dbConnect('query');



//This counts the total number of ongoing orders

$approved_sql = "SELECT status 

				FROM orders 

				WHERE status = 'printing'";

					

$approved_result = $conn->query($approved_sql) or die(mysqli_error());



$approved_row = $approved_result->fetch_assoc();



$approved_numRows = $approved_result->num_rows;







//This counts the total number of ongoing orders

$billed_sql = "SELECT status 

				FROM orders 

				WHERE status = 'billed'";

					

$billed_result = $conn->query($billed_sql) or die(mysqli_error());

$billed_row = $billed_result->fetch_assoc();

$billed_numRows = $billed_result->num_rows;





//This counts the total number of ongoing orders

$custom_sql = "SELECT status 

				FROM orders 

				WHERE status = 'custom_proof'";

					

$custom_result = $conn->query($custom_sql) or die(mysqli_error());

$custom_cnt = $custom_result->num_rows;



?>

<div id="logout_box">

	<a id="logout_btn" class="button" href="../includes/logout.php">Logout</a>

</div>



<div id="admin_header">

    <a href="../index.php"><h1>Applied Materials Business Card Order Center</h1></a>

    <p>Order Tracking System</p>

        <div id="admin_nav">

        	<div style="margin-bottom: 55px;">
	            <a class="button" href="tracker.php">Order Tracker</a>
	
	            <a class="button" href="download.php">PDF's ready for Print (<?php echo $approved_numRows; ?>)</a>
	
	            <a class="button" href="customproofs.php">Custom Proof Orders (<?php echo $custom_cnt; ?>)</a>
	
	            <a class="button" href="archive.php">Archive (<?php echo $billed_numRows; ?>)</a>
        	</div>

            <a class="button" href="options.php">Options</a>
            
            <a class="button" href="deleted_orders.php" style="margin-left: 50px;">Deleted Orders</a>

        </div>

</div>