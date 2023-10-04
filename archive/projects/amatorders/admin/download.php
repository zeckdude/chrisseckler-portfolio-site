<?php 
session_start();




error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	include("../includes/connection.php");
	
if(!isset($_SESSION['authenticated_oc'])){
	header('Location: ' . $site_basedir . 'login.php');
}
	
	//This creates a database connection. The function that makes this happen is in the conn.inc.php file
	$conn = dbConnect('admin');
	
	$sql = 'SELECT * 
			FROM orders 
			LEFT JOIN buildings ON orders.building_id = buildings.building_id
			WHERE status = "printing" AND character_hold != "yes"
			ORDER BY order_id DESC';
			
	$result = $conn->query($sql) or die(mysqli_error());
	
	###################################
	# Get the number of records found #
	###################################
	$numRows = $result->num_rows;

	
	//This checks if the pdf was downloaded and if so, updates the status
	if(isset($_GET['downloaded']) && isset($_GET['order_id'])) {
		/*$printing = 'printing';
		
		//prepare update query
		$sql = 'UPDATE orders
				SET status = ?
				WHERE order_id = ?';
		
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql)) { 
			$stmt->bind_param('si', $printing, $_GET['order_id']); 
			$done = $stmt->execute(); //executes the statement and saves the return value (True/False) in the variable $done
		}*/
		
		$sql = 'UPDATE orders SET
				status = "in_print"
				WHERE order_id = ' . $_GET['order_id'];
	
		$result = $conn->query($sql) or die(mysqli_error());
		
		header('Location: ' . $site_basedir . 'admin/download.php');
	} //end if get downloaded and get order id
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_name; ?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="../images/favicon.gif" />

<style type="text/css">
	#download_table { border-collapse:collapse; width: 750px; margin: 0 auto; position: relative; top: 17px; border: 1px solid #5C7F99;}
	#download_table h4 { margin:0px; padding:0px; font-size: 14px; text-decoration: underline;}
	#download_table img { float:right;}
	#download_table ul { margin:10px 0 10px 40px; padding:0px;}
	#download_table th { background:#375D81 url(header_bkg.png) repeat-x scroll center left; color:#fff; padding:7px 15px; text-align:left;}
	#download_table td { background:#C7DDEE none repeat-x scroll center left; color:#000; padding:7px 15px; }
	#download_table tr td { background:#fff url(row_bkg.png) repeat-x scroll center left; border-bottom: 1px solid #C2C9CF; padding: 15px 15px;}
	
	#download_table tr.rush_order { background: rgba(219, 20, 20, .5); }
	#download_table tr.rush_order td { background-color: transparent; }
	
	
</style>








</head>

<body>


<div id="container">
    
        	<?php include("../includes/admin_header.php"); 
			
			
			if($numRows > 0) {?>
                <div style="width: 320px; margin: 0 auto;">
                    <form id="search" name="search" method="get" action="">
                        <select id="searchby" name="searchby">
                            <option value="order_id">Order ID</option>
                            <option value="employee_id">Employee ID</option>
                            <option value="last_name">Last Name</option>
                        </select>
                        <input type="text" id="search_input" name="search_input" />
                        <input class="button" type="submit" id="search_submit" name="search_submit" value="Search" />
                    </form>
                </div>    
            <?php } ?>
            
            <table id="download_table">
            
            	
            	
            	<tr>
            		<th>Order ID</th>
                    <th>Date Approved</th>
                    <th>Name</th>
                    <th>Shipping Time</th>
                    <th>Download</th>
                    <th>Click here after saving PDF</th>
                </tr>
                
                <?php
					#######################################
					# Display message if no records found #
					#######################################
					if ($numRows == 0) {
					
					 echo '<tr><td colspan="6" style="border-bottom: 1px solid #5C7F99;">There are no orders ready for print at this time</td></tr>';
					
					  }
					##################################
					# Otherwise, display the results #
					##################################
					else {
				?>
                
                <?php while($row = $result->fetch_assoc()) { ?>
                
                    <tr <?php if($row['shipping_time'] == '1-3 work days' || $row['shipping_time'] == '4-8 work days') { echo 'class="rush_order"';}?>>
                        <td style=" <?php if($row['shipping_time'] == '1-3 work days' || $row['shipping_time'] == '4-8 work days') { echo 'border-left: 3px solid #375D81';} else { echo 'border-left: 1px solid #5C7F99';} ?>"><?php echo $row['order_id'] ?></td>
                        <td><?php if($row['date_approved'] == '0000-00-00 00:00:00') {echo ' ';} else {echo date('n/j/y g:ia',strtotime($row['date_approved'])); } ?></td>
                        <td><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></td>
                        <td><?php echo $row['shipping_time'] ?></td>
                        <td>
                        	<?php 
                        		//If foreign cards are ordered, but English cards are not
                        		if($row['foreign_quantity'] > 0 && $row['english_quantity'] < 1 && $row['custom_proof_requested'] != 'yes') { ?>
                                	<a href="../pdf/foreign_pdf.php?order_id=<?php echo $row['order_id'] ?>">Download</a><span class="warning">(Foreign)</span>
                            <?php } 
                            	//If foreign and english cards are ordered
                            	else if($row['foreign_quantity'] > 0 && $row['english_quantity'] > 0 && $row['custom_proof_requested'] != 'yes') { ?>
									<a href="../pdf/download_pdf.php?order_id=<?php echo $row['order_id'] ?>">Download</a><span  class="warning">(English)</span>
									<a href="../pdf/foreign_pdf.php?order_id=<?php echo $row['order_id'] ?>">Download</a><span  class="warning">(Foreign)</span>
							<?php } else if($row['custom_proof_requested'] == 'yes') { 
										if($row['foreign_quantity'] > 0 && $row['english_quantity'] == '') { ?>
                                			<a href="../custom_upload/<?php echo $row['order_id'] . '_' . $row['last_name']; ?>/foreign/foreign.pdf">Download</a><br /><span  class="warning">Custom(Foreign)</span>
							<?php 		} else if($row['foreign_quantity'] > 0 && $row['english_quantity'] > 0) { ?>
											<a href="../custom_upload/<?php echo $row['order_id'] . '_' . $row['last_name']; ?>/english/english.pdf">Download</a><br /><span  class="warning">Custom(English)</span>
                                			<a href="../custom_upload/<?php echo $row['order_id'] . '_' . $row['last_name']; ?>/foreign/foreign.pdf">Download</a><br /><span  class="warning">Custom(Foreign)</span>
							<?php 		} else { ?>
                            				<a href="../custom_upload/<?php echo $row['order_id'] . '_' . $row['last_name']; ?>/english/english.pdf">Download</a><br /><span  class="warning">Custom(English)</span>
							<?php		}
								 } else { ?>
                        		<a href="../pdf/download_pdf.php?order_id=<?php echo $row['order_id'] ?>">Download</a>
                        	<?php } ?>
                        </td>
                        <td style=" <?php if($row['shipping_time'] == '1-3 work days' || $row['shipping_time'] == '4-8 work days') { echo 'border-right: 3px solid #375D81';} else { echo 'border-right: 1px solid #5C7F99';} ?>"><a style="padding: 5px; float: left;" class="button" href="download.php?order_id=<?php echo $row['order_id'] ?>&downloaded=yes">Downloaded</a></td>
                    </tr>
            	<?php } //end while ?>
            	<tr><td style="padding: 10px;" colspan="6"></td><tr>
            <?php
				####################################################
				# Close the else clause wrapping the results table #
				####################################################
				  }
			?>
            	
        	</table>
        
        	
</div> <!--end container div-->


<?php mysqli_close($conn); ?>
</body>
</html>