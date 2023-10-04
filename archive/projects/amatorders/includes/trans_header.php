

<?php

$conn = dbConnect('query');

//This counts the total number of ongoing orders
$approved_sql = "SELECT status 
				FROM orders 
				WHERE status = 'approved'";
					
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

?>
<div id="logout_box">
	<a id="logout_btn" class="button" href="../includes/trans_logout.php">Logout</a>
</div>

<div id="admin_header">
    <a href="../index.php"><h1>Applied Materials Business Card Order Center</h1></a>
    <p>Translator Upload Center</p>
        <div id="admin_nav">
            <a class="button" href="trans_center.php">List of Translations needed</a>
        </div>
</div>