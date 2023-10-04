<?php 

session_start();

ob_start();



ini_set('default_charset', 'UTF-8');







error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);







$curr_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];



	



	include("../includes/connection.php");

	



if(!isset($_SESSION['authenticated_oc'])){

	header('Location: ' . $site_basedir . 'login.php');

}

	

	//This creates a database connection. The function that makes this happen is in the conn.inc.php file

	$conn = dbConnect('admin');

	

	

	if($_GET['corrections_complete'] == 'yes') {

		

		$sql = 'UPDATE orders SET

				status = "waiting_approval"

				WHERE order_id = ' . $_GET['order_id'];



		$result = $conn->query($sql) or die(mysqli_error());

		

		$sql = 'SELECT *

				FROM orders

				WHERE order_id = ' . $_GET['order_id'];

				

		$result = $conn->query($sql) or die(mysqli_error());

		$mail_row = $result->fetch_assoc();

		

		$mailTo = $mail_row['approved_by'];

		$date = date('m/j/y',strtotime($mail_row['date_submitted']));

		$subject = 'Manager approval needed for Business Card order for ' . $mail_row['first_name'] . ' ' . $mail_row['last_name'] . '(Order #' . $_GET['order_id'] . ')';

		$message = 

			'<html>

			<head>

			<title>Manager Approval needed</title>

			</head>

			<body>

				<table style="width: 400px; border: 1px solid #5C7F99; margin-left: auto; margin-right: auto; margin-top: 35px;">

					<thead>

						<tr style="background: #FFFFFF none repeat-x scroll left center; border-bottom: 1px solid #C2C9CF;"><th colspan="2" style="background: #375D81; border-bottom: 1px solid #5C7F99; color: #FFFFFF; padding: 7px 15px; text-align: left; font-size: 14px;"><span style="font-weight: normal;">Please review this business card order</span></th></tr>   

					</thead>    

					<tbody>

						<tr>

							<td colspan="2" style="padding: 7px 15px; color: #183152; ">

								<p>You are receiving this email because ' . $mail_row['first_name'] . ' ' . $mail_row['last_name'] . ' placed a business card order at Pro Print & Services on '.$date.'.</p>

								

								<br />

								

								<p>Corrections have been made to this order.</p>

								

								<br />

								

								<p>The order can only be processed once you have approved or disapproved. Thank you.</p>

								

								<br />

								

								<p>Please click on the following link to view a PDF proof of the card that was ordered.</p>

								

								<br />

								

								<p><a href="' . $site_basedir . 'manager_approval.php?employee_id=' . $mail_row['employee_id'] . '&order_id=' . $_GET['order_id'] . '">Please click here to view the Business Card Proof</a></p>

							</td>

						</tr> 

					</tbody>     

				</table>

			</body>



			</html>';

			

		$headers  = 'MIME-Version: 1.0' . "\r\n";

		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$headers .= 'From: Pro Print & Services <proprint@sprynet.com>';

		

		mail($mailTo, $subject, $message, $headers);

		

		$date_added = date('Y-m-d H:i:s',time());

		

		//This adds the note marking a change in status	

		$notes_sql = 'INSERT into notes SET

				order_id = "'.$_GET['order_id'].'",

				date_added = "'.$date_added.'",

				note_message = "'.$note_message['corrections_complete'].'"';



		$notes_result = $conn->query($notes_sql) or die(mysqli_error($conn));

		

		//This adds the note marking a change in status	

		$notes_sql = 'INSERT into notes SET

				order_id = "'.$_GET['order_id'].'",

				date_added = "'.$date_added.'",

				note_message = "'.$note_message['waiting_approval'].'"';



		$notes_result = $conn->query($notes_sql) or die(mysqli_error($conn));

	}

	

	

	function write_sortable_header_link( $column_id, $column_name ){ //Function that creates a link with the search query if needed

	   	if( ($_GET['sortby'] != $column_id) || !isset($_GET['sortby']) ) {//If the GET variable is not the column id of this button or if the GET sortby variable has not been set

		 $query = "?sortby=$column_id"; //then add this to the end of the url

		} else {

		 $query = '?sortby='.$column_id.'_desc'; //otherwise if the GET variable is the column id of this button, then add the descending code to the end of the variable

		}

		

	   if(isset($_GET['search_submit']) ){ //If the GET variable search_submit is in the url

		 $query .= '&search_submit=1'; //then add this to the end of the url string

		 $query .= '&searchby=' . urlencode($_GET['searchby']); //add whatever is currently in the GET searchby to the end of the url string

		 $query .= '&search_input=' . urlencode($_GET['search_input']); //add whatever is currently in the GET search_input to the end of the url string

	   }

	

	   $href = $_SERVER['SCRIPT_NAME'] . $query; //this is the href part of the link

	   echo "<a href='$href'>$column_name</a>"; //this creates the actual link

	}

	

	

	if(isset($_GET['search_submit'])) {

		$search_string = ' WHERE ' . $_GET['searchby'] . '= "' . $_GET['search_input'] . '" AND status != "billed" AND status != "delivered" AND status != "deleted" ';			

	}

	

	

	

	if(!isset($_GET['sortby']) && !isset($_GET['search_submit'])){ //Default, If no sort or search is set

		$sql = 'SELECT * 

				FROM orders 

				LEFT JOIN buildings ON orders.building_id = buildings.building_id

				WHERE status != "billed" AND status != "delivered" AND status != "deleted"

				ORDER BY order_id DESC';	

	}

	

	if(!isset($_GET['sortby']) && isset($_GET['search_submit']) ){ //If the search is set but no sort

		$sql = "SELECT * 

				FROM orders 

				LEFT JOIN buildings ON orders.building_id = buildings.building_id"

				 . $search_string . 

				"ORDER BY order_id DESC";

	}

	

	

	if(isset($_GET['sortby']) && !isset($_GET['search_submit'])) { //If the sort is set but no search

		switch ($_GET['sortby']) { 

			case "order_id":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id 

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY order_id ASC";

				break;

			case "order_id_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id 

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY order_id DESC";

				break;

				

			case "status":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY status ASC";

				break;

			case "status_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id 

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY status DESC";

				break;

	

			case "employee_id":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id 

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY employee_id ASC";

				break;

			case "employee_id_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY employee_id DESC";

				break;

				

			case "last_name":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY last_name ASC";

				break;

			case "last_name_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY last_name DESC";

				break;

				

			case "title":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY title ASC";

				break;

			case "title_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id 

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY title DESC";

				break;

				

			case "manager_email":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY approved_by ASC";

				break;

			case "manager_email_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY approved_by DESC";

				break;

				

			case "date_approved":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY date_approved ASC";

				break;

			case "date_approved_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY date_approved DESC";

				break;

				

			case "shipping_time":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY shipping_time ASC";

				break;

			case "shipping_time_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id 

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY shipping_time DESC";

				break;

				

			case "language":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY language ASC";

				break;

			case "language_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status != 'billed' OR status != 'delivered' OR status != 'deleted'

						ORDER BY language DESC";

				break;			

		} //end switch

	} //end if sort is set but no search

	

	

	if(isset($_GET['sortby']) && isset($_GET['search_submit'])) { //If the sort AND search is set

		switch ($_GET['sortby']) { 

			case "order_id":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY order_id ASC";

				break;

			case "order_id_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY order_id DESC";

				break;

				

			case "status":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id" 

						 . $search_string . 

						"ORDER BY status ASC";

				break;

			case "status_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY status DESC";

				break;

	

			case "employee_id":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY employee_id ASC";

				break;

			case "employee_id_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY employee_id DESC";

				break;

				

			case "last_name":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY last_name ASC";

				break;

			case "last_name_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY last_name DESC";

				break;

				

			case "title":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY title ASC";

				break;

			case "title_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY title DESC";

				break;

				

			case "manager_email":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY approved_by ASC";

				break;

			case "manager_email_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY approved_by DESC";

				break;

				

			case "date_approved":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY date_approved ASC";

				break;

			case "date_approved_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY date_approved DESC";

				break;

				

			case "shipping_time":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY shipping_time ASC";

				break;

			case "shipping_time_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY shipping_time DESC";

				break;

				

			case "language":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY language ASC";

				break;

			case "language_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY language DESC";

				break;			

		} //end switch

	} //end if search and sort

	

	

	$conn2 = mysql_connect('localhost','ideapale_amquery','amatorders');  

	mysql_select_db($db_name,$conn2);

	

	

	//This counts the number of entries for each status the ticker

	$ticker_sql = "SELECT status, COUNT(order_id)

					FROM orders

					WHERE status != 'billed' AND status != 'not_approved'  AND status != 'delivered' AND status != 'deleted'

					GROUP BY status";

					

	$ticker_result = $conn->query($ticker_sql) or die(mysqli_error());

	

	//This counts the total number of ongoing orders

	$ticker_total_sql = "SELECT COUNT(*)

						AS cnt

						FROM orders

						WHERE status != 'billed' AND status != 'not_approved'  AND status != 'delivered' AND status != 'deleted'";

						

	$ticker_total_result = $conn->query($ticker_total_sql) or die(mysqli_error());

	

	$total_row = $ticker_total_result->fetch_assoc();

	

	

	if ($total_row['cnt'] > 0) {

		//Include the PS_Pagination class

		include('../includes/ps_pagination.php');

		
		//echo '<br /><br /><br /><br /><br /><br /><br />The SQL is: ' . $sql;
		

		//Create a PS_Pagination object

		$pager = new PS_Pagination($conn2, $sql, 25, 10);

		//The paginate() function returns a mysql

		//result set for the current page

		$result = $pager->paginate();

	}



		

	

	

	

	

	

	

	

?> 





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $site_name; ?></title>

<link href="../css/style.css" rel="stylesheet" type="text/css" />

<link rel="shortcut icon" href="../images/favicon.gif" />



<style type="text/css">

	#tracker_table { border-collapse:collapse;}

	#tracker_table h4 { margin:0px; padding:0px; font-size: 14px; text-decoration: underline;}

	#tracker_table img { float:right;}

	#tracker_table ul { margin:10px 0 10px 40px; padding:0px;}

	#tracker_table th { background:#375D81 url(header_bkg.png) repeat-x scroll center left; color:#fff; padding:7px 15px; text-align:left;}

	#tracker_table td { padding:7px 15px; }

	

	tr#detail td { vertical-align: top; }

	#tracker_table div.arrow { background:transparent url(../images/arrows.png) no-repeat scroll 0px -16px; width:16px; height:16px; display:block;}

	#tracker_table div.up { background-position:0px 0px;}

</style>





<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>



<script type="text/javascript">  

	$(document).ready(function(){

		//$("#tracker_table tr:odd").addClass("odd");
		
		var adminButton = "#tracker_table tr:nth-child(3n)"; //Targeting the Admin Buttons Row 
		
		//$(adminButton).addClass("odd"); //Targeting the Admin Buttons Row
		$(adminButton).prev().addClass("odd");  //Targeting the Master Row
		//$(adminButton).next().addClass("odd"); //Targeting the Details Row
		
		$("#tracker_table tr:not(.odd)").hide();

		$("#tracker_table tr:first-child").show(); //This makes the header show up

		
		
		
		
		
		
		

		$("#tracker_table tr.odd").click(function(){
												  
			//$(this).next().addClass("ADMIN_ROW");
			//$(this).next().next().addClass("DETAILS_ROW");
			
			$(this).next().toggle(); //Making the Admin buttons row show/hide
			$(this).next().next().toggle(); //Making the details row show/hide
			
			$(this).find(".arrow").toggleClass("up");

		});

		//$("#report").jExpand();

		

		$("#tracker_table tr#master").click(function(){

		  if(!$(this).hasClass("selected")) { 

			$(this).addClass("selected");

		  } else {

			$(this).removeClass("selected");	  

		  }

		});

		

		//alert($(".note_message").val);

		

		/*var Str=$(".note_message").filter(function(){

		  return $(this).text().match(/^The order was manually edited\:/);

		}).text().replace(/The order was manually edited\:/,'');



		alert(Str);*/

		

		//$(".note_message:contains

		//if(jQuery.contains(document.documentElement, document.body); // true





		//$((".note_message"):contains("The order was manually edited:"))



		

		

		

	});

</script> 











</head>



<body>





<div id="container">

			

           <?php include("../includes/admin_header.php"); 
		   
		   //echo '<div style="z-index: 99999; position: absolute; top: 0; left: 0; background-color: white; border: 1px solid #375D81; padding: 20px;">' . $_SESSION['sql'] . '</div>';
		   ?>

    

    		<div id="search_nav_area">

                <form id="search" name="search" method="get" action="">

                    <select id="searchby" name="searchby">

                        <option value="order_id" <?php if($_GET['searchby'] == 'order_id'){echo 'selected';} ?>>Order ID</option>

                        <option value="employee_id" <?php if($_GET['searchby'] == 'employee_id'){echo 'selected';} ?>>Employee ID</option>

                        <option value="last_name" <?php if($_GET['searchby'] == 'last_name'){echo 'selected';} ?>>Last Name</option>

                    </select>

                    <input type="text" id="search_input" name="search_input" <?php if(isset($_GET['search_input'])){echo 'value="'.$_GET['search_input'].'"';}  ?>/>

                    <input class="button" type="submit" id="search_submit" name="search_submit" value="Search" />

                </form>

                <?php

				if ($total_row['cnt'] > 0) {

				

				?>

                <div id="pag_nav">

                    <span id="admin_button_group">

                        <?php

						

                            //Display the navigation

                            echo $pager->renderFullNav();	

                        ?>

                    </span>

              </div>

                <?php } ?>

 

            </div>

            

            <script type="text/javascript">

				var formWidth = $("#search").width();

				var pagnavWidth = $("#pag_nav").width();

				var combinedWidth = formWidth + pagnavWidth + 120;

				$("#search_nav_area").replaceWith('<div id="search_nav_area" style="width: ' + combinedWidth + 'px;">' + $("#search_nav_area").html() + '</div>');

			</script>

            

            

            

            <div class="ticker_container" id="ticker">  

                <div class="ticker_row">

                    <div class="clientform_table_header ticker_header"><center>Status Ticker</center></div>   

                </div>

           		

                <?php while($row = $ticker_result->fetch_assoc()) { ?>

                 <div class="ticker_row" style="overflow:hidden;">

                    <div class="ticker_content ticker_col_1"> 

                        <?php 

                        switch ($row['status']) {

                            case "waiting_approval":

                                echo "Waiting for manager approval: ";

                                break;

                            case "approved":

                                echo "Approved: ";

                                break;

                            case "printing":

                                echo "Ready for print: ";

                                break;

                            case "waiting_delivery":

                                echo "Waiting for delivery: ";

                                break;

                            case "delivered":

                                echo "Delivered: ";

                                break;

							case "waiting_translator":

                                echo "Waiting for translator: ";

                                break;

							case "waiting_trans_approval":

                                echo "Waiting for translation approval: ";

                                break;

							case "custom_proof":

                                echo "Custom proof requested: ";

                                break;

							case "waiting_custom_approval":

                                echo "Waiting for custom proof approval: ";

                                break;

							case "in_print":

                                echo "In Print: ";

                                break;

							case "waiting_corrections":

                                echo "Waiting for Corrections: ";

                                break;

							case "waiting_upload":

                                echo "Waiting for characters: ";

                                break;

                        }

						echo '</div>';

						echo '<div class="ticker_content ticker_col_2">';

                        echo $row['COUNT(order_id)']; 

                        ?>

                    </div>

                </div>

				<?php } //end while ?>

                

                <div class="ticker_row" style="overflow:hidden;" id="ticker_last_row">

                    <div class="ticker_content ticker_col_1">Total ongoing orders: </div>

                    <div class="ticker_content ticker_col_2"><?php echo $total_row['cnt']; ?></div>

                </div>

			</div>

            

            

            

             

            <table id="tracker_table">

            

           <tr id="tracker_headers">

            

               <th><?php write_sortable_header_link( 'status', 'Status' ); ?></th>

            

               <th><?php write_sortable_header_link( 'order_id', 'Order ID' ); ?></th>

            

            	<th><?php write_sortable_header_link( 'employee_id', 'Employee ID' ); ?></th>

               

               <th><?php write_sortable_header_link( 'last_name', 'Name' ); ?></th>

            

            	<th><?php write_sortable_header_link( 'title', 'Title' ); ?></th>

               

               <th><?php write_sortable_header_link( 'manager_email', 'Manager Email' ); ?></th>

            

            	<th><?php write_sortable_header_link( 'date_approved', 'Date Approved' ); ?></th>

               

               <th><?php write_sortable_header_link( 'shipping_time', 'Shipping Time' ); ?></th>

            

                <th><?php write_sortable_header_link( 'language', 'Ordered' ); ?></th>

                



                <th></th>            

            </tr>

            

            

            

            

            

            

            

            

            

            

            

        

            <?php 

			if($total_row['cnt'] >= 1) {

			while($row = mysql_fetch_assoc($result)) {

				

				//echo 'ARRAY: ';

				//print_r($row);

				

				//$_SESSION['foreign_characters_name'] = $row['foreign_characters_name'];

				

				if($row['non_us_card'] == 'yes') {

					$phone = $row['non_us_phone'];

				} else {
					
					if($row['phone_int_prefix'] != '') {
						$phone = $row['phone_int_prefix'] . '.' . $row['phone_prefix'] . '.' . $row['phone_first'] . '.' . $row['phone_last'];
					} else {
						$phone = $row['phone_prefix'] . '.' . $row['phone_first'] . '.' . $row['phone_last'];
					}
				}

				

				if($row['non_us_card'] == 'yes') {

					if($row['non_us_fax'] != '') {

						$fax = $row['non_us_fax'];

					} else {

						$fax = 'No fax number given';	

					}

				} else {

					if($row['fax_prefix'] != '') {

						$fax = $row['fax_prefix'] . '.' . $row['fax_first'] . '.' . $row['fax_last'];

					} else {

						$fax = 'No fax number given';	

					}

				}

				

				

				

				$nonus_address_sql = 'SELECT *

									  FROM non_us_addresses

									  WHERE order_id = ' . $row['order_id'];

						

				$nonus_address_result = $conn->query($nonus_address_sql) or die(mysqli_error());

				$nonus_address_row = $nonus_address_result->fetch_assoc();

				

				if($row['non_us_card'] == 'yes') {

					if($row['no_address'] == 'yes') {

						$address = 'No address chosen';

					} else {

						$address = $nonus_address_row['line_1'] . '<br />' . $nonus_address_row['line_2'] . '<br />' . $nonus_address_row['line_3'] . '<br />' . $nonus_address_row['line_4'];

					}

				} else {

					if($row['no_address'] == 'yes') {

						$address = 'No address chosen';

					} else if($row['custom_address'] == 'yes') {

						

						

						$address_sql = 'SELECT *

										FROM custom_addresses

										WHERE order_id = ' . $row['order_id'];

								

						$address_result = $conn->query($address_sql) or die(mysqli_error());

						$address_row = $address_result->fetch_assoc();

						

						$address = $address_row['line_1'] . '<br />';

						

						if(isset($address_row['line_2'])) {

							$address .= $address_row['line_2'];

						}

						

						$address .= $address_row['city'] . ', ' . $address_row['state'] . ' ' . $address_row['zip_1'];

						

						if(isset($address_row['zip_2']) && $address_row['zip_2'] > 0) {

							$address .= ' - ' . $address_row['zip_2'];

						}

						

						

					} else {

						$address = $row['address'] . '<br /> P.O. Box ' . $row['po_box'] . ', ' . $row['city'] . ', ' . $row['state'] . ' ' . $row['zip_code'];

					}

				}

				

				

				

			

			?>



                	<tr id="master" <?php if($row['shipping_time'] == '1-3 work days' || $row['shipping_time'] == '4-8 work days') { echo 'style="background: rgba(219, 20, 20, .5)"';}?>>

                    	<td style=" <?php if($row['shipping_time'] == '1-3 work days' || $row['shipping_time'] == '4-8 work days') { echo 'border-left: 3px solid #375D81';} else { echo 'border-left: 1px solid #5C7F99';} ?>">

							<?php switch ($row['status']) {

								case "not_approved":

                                    echo "Not Approved";

                                    break;

                                case "waiting_approval":

                                    echo "Waiting for manager approval";

                                    break;

                                case "approved":

                                    echo "Approved";

                                    break;

                                case "printing":

                                    echo "Ready for print";

                                    break;

                                case "waiting_delivery":

                                    echo "Waiting for delivery";

                                    break;

                                case "delivered":

                                    echo "Delivered";

                                    break;

								case "billed":

                                    echo "Billed";

                                    break;

								case "waiting_translator":

                                	echo "Waiting for translator";

                                	break;

								case "waiting_trans_approval":

                                	echo "Waiting for translation approval";

                                	break;

								case "custom_proof":

                                	echo "Custom proof requested";

                                	break;

								case "waiting_custom_approval":

                                	echo "Waiting for custom proof approval";

                                	break;

								case "in_print":

                                	echo "In Print";

                                	break;

								case "waiting_corrections":

									echo "Waiting for Corrections";

									break;

								case "waiting_upload":

									echo "Waiting for foreign characters";

									break;

                            } ?>

                        </td>

						<td><?php echo $row['order_id']; ?></td>

                        <td><?php echo $row['employee_id']; ?></td>

                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>

                        <td><?php echo $row['title']; ?></td>

                        <td><?php echo $row['approved_by']; ?></td>

                        <td><?php if($row['date_approved'] == '0000-00-00 00:00:00') {echo ' ';} else {echo date('n/j/y g:ia',strtotime($row['date_approved'])); } ?></td>

                        <td><?php 

								if($row['shipping_time'] == '1-3 work days' || $row['shipping_time'] == '4-8 work days') { 

									echo '<b>' . $row['rush_date'] . '</b>';

								} else {

									echo $row['shipping_time'];	

								}

							?>

						</td>

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

                        <td style=" <?php if($row['shipping_time'] == '1-3 work days' || $row['shipping_time'] == '4-8 work days') { echo 'border-right: 3px solid #375D81';} else { echo 'border-right: 1px solid #5C7F99';} ?>"><div class="arrow"></div></td>

					</tr>

                    <tr class="admin_buttons_row">         
                    	<td colspan="11">
                        		<span id="admin_sub_buttons">

                                <span class="admin_sub_button">

                                    <a class="button" href="edit_order.php?order_id=<?php echo $row['order_id'] ?>">Edit this Order</a>

                                </span>

                                

                                <?php 

								if($row['status'] == 'waiting_approval') {

								?>

                                    <span class="admin_sub_button">

                                        <a class="button" href="../includes/manager_mail.php?order_id=<?php echo $row['order_id']; ?>">Resend Manager Mail (<?php if($row['mng_mail_resent'] < 1) {echo '0';} else {echo $row['mng_mail_resent']; }?>)</a>

                                    </span>

                                <?php } 

								if($row['status'] == 'waiting_custom_approval') {

                                ?>

                                    <span class="admin_sub_button">

                                        <a class="button" href="../includes/custom_approval_mail.php?order_id=<?php echo $row['order_id']; ?>">Resend Custom Proof Approval Mail (<?php if($row['custom_approval_mail_resent'] < 1) {echo '0';} else {echo $row['custom_approval_mail_resent']; }?>)</a>

                                    </span>

                                <?php } 

								

								if($row['status'] == 'waiting_trans_approval') {

                                ?>

                                    <span class="admin_sub_button">

                                        <a class="button" href="../includes/trans_approval_mail.php?order_id=<?php echo $row['order_id']; ?>">Resend Translation Proof Approval Mail (<?php if($row['trans_mail_resent'] < 1) {echo '0';} else {echo $row['trans_mail_resent']; }?>)</a>

                                    </span>

                                <?php } ?>

                                

                                

                                

                                <span class="admin_sub_button">

                                    <a target="_blank" class="button" href="../admin/card_preview.php?order_id=<?php echo $row['order_id']; ?>">Preview Card</a>

                                </span> 
                                
                                 <span class="admin_sub_button" id="delete_order_btn">

                                    <a class="button" href="../admin/delete_order.php?order_id=<?php echo $row['order_id']; ?>">Delete Order</a>

                                </span> 

							</span>
                        </td>
                    </tr>

                    <tr id="details">
                        <td colspan="5">

                        

                        	 

						  

							





                        

                        

                      <?php if($row['status'] == 'waiting_corrections') { ?>

                        	<span class="detail_section">

                            <h4>Manager Corrections needed</h4>

                            <ul>

                                <li><span class="detail_title">The following corrections are needed: </span></li>

                                <li><span class="detail_text">

								<?php 

									$instr_sql = "SELECT *

												  FROM manager_instructions

												  WHERE order_id = '" . $row['order_id'] . "'";

									

									$instr_result = $conn->query($instr_sql) or die(mysqli_error());

								

									$i = 1;							

									while ($instr_row = $instr_result->fetch_assoc()) {				

										echo '(' . $i . ') ' . $instr_row['instruction_message'] . '<br />';

										$i++;

									}

								

								?></span></li>

								
                                <li>
                                	<span class="detail_text">
                                    	<?php if($row['custom_proof_requested'] == 'yes') { ?>
                                    		This is a custom proof order<br /><br />
                                            <a class="button" style="float: left; padding: 5px; position: relative;" href="upload_custom_proof.php?order_id=<?php echo $row['order_id'] ?>">Upload Corrected Proof</a>
                                    	<?php } else { ?>
                                    		<a class="button" style="float: left; padding: 5px; position: relative;" href="tracker.php?corrections_complete=yes&order_id=<?php echo $row['order_id'] ?>">Corrections Complete</a>
										<?php } ?>
                                	</span>
                                </li>

                             </ul>

                             </span>

                        <?php } ?>

                        	<span class="detail_section">

                            <h4>Administrative Details</h4>

                            <ul>

                                <li><span class="detail_title">Employee ID: </span><span class="detail_text"><?php echo $row['employee_id'] ?></span></li>

                                <li><span class="detail_title">Cost Center: </span><span class="detail_text"><?php echo $row['cost_center'] ?></span></li>

                                <li><span class="detail_title">Approved by: </span><span class="detail_text"><?php echo $row['approved_by'] ?></span></li>

                                <li><span class="detail_title">Delivery Bldg: </span><span class="detail_text"><?php echo $row['delivery_bldg'] ?></span></li>

                                <li><span class="detail_title">Delivery Email: </span><span class="detail_text"><?php echo $row['delivery_email'] ?></span></li>

                                <li><span class="detail_title">Delivery Ext: </span><span class="detail_text"><?php echo $row['ext'] ?></span></li>

                            </ul> 

                            </span>

                            

                            <span class="detail_section">

                            <h4>Shipping Options</h4>

                            <ul>

                                <li><span class="detail_title">Shipping Time: </span><span class="detail_text"><?php echo $row['shipping_time'] ?></span></li>

                                <li><span class="detail_title">Rush needed by: </span><span class="detail_text"><?php if($row['rush_date'] != '') {echo $row['rush_date'];} else {echo 'N/A';} ?></span></li>

                            </ul>

                            </span>

                            

                            <span class="detail_section">

                            <h4>Items Ordered</h4>

                            <ul>

                            	<?php 

									if($row['english_quantity'] > 0) { 

                                		echo '<li><span class="ordered_main">English Business Cards</span><span class="ordered_sub">' . $row['english_quantity'] . '</span></li>';

									}

									

									

									

									switch($language) {

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

									

									if($row['foreign_quantity'] > 0) {

										echo '<li><span class="ordered_main">Foreign Business Cards</span><span class="ordered_sub">' . $language . '</span><br/><span class="ordered_sub_third">' . $row['foreign_quantity'] . '</span></li>';

									}

									

									if($row['notepad_size_425x55'] == 'yes') { 

                                		echo '<li><span class="ordered_main">Notepads</span><span class="ordered_sub">4.25" x 5.5"</span></li>';

									}

									

									if($row['notepad_size_55x85'] == 'yes') { 

                                		echo '<li><span class="ordered_main">Notepads</span><span class="ordered_sub">5.5" x 8.5"</span></li>';

									}

								?>

                                

                            </ul>

                            </span>

                             

                            <span class="detail_section">

                            <h4>Language Options</h4>

                            <ul>

                                <li><span class="detail_title">Language: </span><span class="detail_text"><?php if(isset($row['language'])) {echo $row['language'];} elseif(isset($row['other_language'])) {echo $row['language'];} else {echo 'N/A';} ?></span></li>

                                <li><span class="detail_title">Email Language Proof to: </span><span class="detail_text"><?php if(isset($row['language']) || isset($row['other_language'])) {echo $row['email_language_proof'];} else {echo 'N/A';} ?></span></li>

                             </ul>

                             </span>

                             

                             <span class="detail_section">

                            <h4>User supplied characters</h4>

                            <ul>

                                 

                                 <?php

                                 if($row['foreign_characters_name'] != '' || $row['foreign_characters_line2'] != '' || $row['foreign_characters_line3'] != '' || $row['foreign_characters_line4'] != '') {

										$sql = 'SET NAMES utf8';

										$conn->query($sql) or die(mysqli_error());

                                 ?>   

                                

                                 

                                <li><span class="detail_title">Foreign Character Name: </span><span class="detail_text"><?php if($row['foreign_characters_name'] != '') {echo $row['foreign_characters_name'];} else {echo 'N/A';} ?></span></li>

                                <li><span class="detail_title">Foreign Character Line 2: </span><span class="detail_text"><?php if($row['foreign_characters_line2'] != '') {echo $row['foreign_characters_line2'];} else {echo 'N/A';} ?></span></li>

                                <li><span class="detail_title">Foreign Character Line 3: </span><span class="detail_text"><?php if($row['foreign_characters_line3'] != '') {echo $row['foreign_characters_line3'];} else {echo 'N/A';} ?></span></li>

                                <li><span class="detail_title">Foreign Character Line 4: </span><span class="detail_text"><?php if($row['foreign_characters_line4'] != '') {echo $row['foreign_characters_line4'];} else {echo 'N/A';} ?></span></li>

                               <?php } else { ?> 

                                	<li>There was no characters supplied for this order</li>

                                

                               <?php } ?>

                                

                                

                                

                             </ul>

                             </span>

                             

                             

                             <span class="detail_section">

                            	<h4>User supplied Artwork</h4>

                            	<ul>

                            		<li id='trans_center_links'>

                                    

                                    	

                                    

                                    	<?php



										$dirPath = '../upload/' . $row['upload_location'];

										

										if($row['upload_location'] != '') {

											

											// open the specified directory and check if it's opened successfully

											if ($handle = opendir($dirPath)) {

											

											   // keep reading the directory entries 'til the end

											   while (false !== ($file = readdir($handle))) {

													//echo $file;

												  // just skip the reference to current and parent directory

												  if ($file != "." && $file != "..") {

													 if (is_dir("$dirPath/$file")) {

														// found a directory, do something with it?

														echo "[$file]<br>";

													 } else {

														// found an ordinary file

														echo "<u><a target='_blank' href='" . $site_basedir . "upload/" . $row['upload_location'] . "/$file'>$file</a></u><br>";

													 }

												  }

											   }

											

											   // ALWAYS remember to close what you opened

											   closedir($handle);

											}

										} else {

											echo 'There was no artwork supplied for this order';	

										}

										

										?>

                                    </li>    

                             	</ul>

                             </span>

                             

                            <?php if($row['foreign_quantity'] > 0) { ?> 

                                 <span class="detail_section">

                                    <h4>Latest Translator Upload</h4>

                                    <ul>

                                        <li id='trans_center_links'>

                                            <?php

                                            $dirPath = '../trans_upload/' . $row['order_id'] . '_' . $row['last_name'];

                                            

                                            if(file_exists($dirPath)) {

                                                // open the specified directory and check if it's opened successfully

                                                if ($handle = opendir($dirPath)) {

                                                   // keep reading the directory entries 'til the end

                                                   while (false !== ($file = readdir($handle))) {

                                                        //echo $file;

                                                      // just skip the reference to current and parent directory

                                                      if ($file != "." && $file != "..") {

                                                         if (is_dir("$dirPath/$file")) {

                                                            // found a directory, do something with it?

                                                            echo "[$file]<br>";   

                                                         } else {

                                                            // found an ordinary file

                                                            echo "<u><a target='_blank' href='" . $site_basedir . "trans_upload/" . $row['order_id'] . '_' . $row['last_name'] . "/$file'>$file</a></u><span class='warning'>(" . date('n/j/y g:ia',strtotime($row['date_trans_upload'])) . ")</span><br>";

                                                         }

                                                      }

                                                   }

                                                

                                                   // ALWAYS remember to close what you opened

                                                   closedir($handle);

                                                }

                                            } else {

                                                echo 'The Translator PDF has not yet been uploaded.';	

                                            }

                                            

                                            ?>

                                        </li>    

                                    </ul>

                                 </span>

							<?php } ?>

                            

                            <?php if($row['custom_proof_requested'] == 'yes') { ?> 

                                 <span class="detail_section">

                                    <h4>Latest Custom Proof Upload</h4>

                                    <ul>

                                        <li id='trans_center_links'>

                                            <?php

                                            $dirPath = '../custom_upload/' . $row['order_id'] . '_' . $row['last_name'];

                                            

                                            if(file_exists($dirPath)) { 

                                                // open the specified directory and check if it's opened successfully

                                                /*if ($handle = opendir($dirPath)) {

                                                   // keep reading the directory entries 'til the end

                                                   while (false !== ($file = readdir($handle))) {

                                                        //echo $file;

                                                      // just skip the reference to current and parent directory

                                                      if ($file != "." && $file != "..") {

                                                         if (is_dir("$dirPath/$file")) {

                                                            // found a directory, do something with it?

                                                            echo "[$file]<br>";   

                                                         } else {

                                                            // found an ordinary file

                                                            echo "<u><a target='_blank' href='" . $site_basedir . "custom_upload/" . $row['order_id'] . '_' . $row['last_name'] . "/$file'>$file</a></u><span class='warning'>(" . date('n/j/y g:ia',strtotime($row['date_custom_upload'])) . ")</span><br>";

                                                         }

                                                      }

                                                   }

                                                

                                                   // ALWAYS remember to close what you opened

                                                   closedir($handle);

                                                }*/

												

												if($row['english_quantity'] > 0) { //If there are english cards	?>

                                                    <u><a target="_blank" href="<?php echo $site_basedir . 'custom_upload/' . $row['order_id'] . '_' . $row['last_name']; ?>/english/english.pdf">English.pdf</a></u>

                                                    <span class='warning'>(<?php echo date('n/j/y g:ia',strtotime($row['date_custom_upload'])); ?>)</span>

                                                    <br />

                                            	<?php	

												} 

												

												if($row['foreign_quantity'] > 0) { //If there are foreign cards ?>

                                                	<u><a target="_blank" href="<?php echo $site_basedir . 'custom_upload/' . $row['order_id'] . '_' . $row['last_name']; ?>/foreign/foreign.pdf">Foreign.pdf</a></u>

                                                    <span class='warning'>(<?php echo date('n/j/y g:ia',strtotime($row['date_custom_upload'])); ?>)</span>

                                                    <br />

                                            	<?php }

                                            } else {

                                                echo 'The Custom Proof PDF has not yet been uploaded.';	

                                            }

                                            

                                            ?>

                                        </li>    

                                    </ul>

                                 </span>

							<?php } ?>

                             

                             

                             

                             

                        </td>

                        <td colspan="6">

                        

                        

                        	<?php

							 	$notes_sql = "SELECT * 

										FROM notes 

										WHERE order_id = " . $row['order_id'] . "
										ORDER BY note_id ASC";

							 

							 	$notes_result = $conn->query($notes_sql) or die(mysqli_error());

								

							 

							 ?>

                             

                             

                             

                             <span class="notes_section">

                             <h4 style="float:left; margin-bottom: 16px;">History for this Order <a class="note_button" href="manual_note.php?order_id=<?php echo $row['order_id']; ?>"> +</a></h4>

                             <ul class="notes_area">

                             	<?php 

								

								if(mysqli_num_rows($notes_result) == 0) { 

                                	echo '<li><span class="detail_text">There are no notes for this order</span></li>';

                                }

								

								

								

								while($notes_row = $notes_result->fetch_assoc()) { 

								

								$note_timestamp = strtotime($notes_row['date_added']);

								$note_date = date("n/j/y g:ia", $note_timestamp);

								

								//echo 'There are ' . mysqli_num_rows($notes_result) . ' results being returned right now.';

								

								    

                                

									

								if(mysqli_num_rows($notes_result) > 0) { 
									$notes_row['note_message'] = stripslashes($notes_row['note_message']);
								?>
								
								
                                	<li><span class="detail_title">(<?php echo $note_date; ?>):  </span><span class="detail_text note_message" style="width: 235px;"> <?php echo $notes_row['note_message']; ?></span></li>

                                <?php 

								}

								

								} //end while ?> 

                             </ul>

                             

                             </span>

                        

                        

                        

                        

                        

                             

                            <span class="detail_section">

                            <h4 id="card_title">Card/Notepad Details</h4><span id="card_title_caption">(<?php if($row['non_us_card'] == 'yes') {echo 'Non US Card';} else {echo 'US Card';} ?>)</span>

                            <ul>

                                <li><span class="detail_title">Name: </span><span class="detail_text"><?php echo $row['full_name']; ?></span></li>

                                <li><span class="detail_title">Title: </span><span class="detail_text"><?php echo $row['title'] ?></span></li>

                                <li><span class="detail_title">Title 2: </span><span class="detail_text"><?php echo $row['title_2'] ?></span></li>

                                <li><span class="detail_title">Dept/Div: </span><span class="detail_text"><?php echo $row['dept_div'] ?></span></li>

                                <li><span class="detail_title">Dept/Div 2: </span><span class="detail_text"><?php echo $row['dept_div_2'] ?></span></li>

                                

                                <li><span class="detail_title">Phone(<?php echo $row['phone_symbol'] ?>): </span><span class="detail_text"><?php echo $phone ?></span></li>

                                <li><span class="detail_title">Fax: </span><span class="detail_text"><?php echo $fax ?></span></li>

                                <li><span class="detail_title">Other Number: </span><span class="detail_text"><?php 

								

								$contact_sql = 'SELECT *

										FROM contact_numbers

										WHERE order_id = ' . $row['order_id'];

										

								$contact_result = $conn->query($contact_sql) or die(mysqli_error());

								$row_cnt = $contact_result->num_rows;

								

								if($row_cnt > 0) {

									while($contact_row = $contact_result->fetch_assoc()) {

										

										if($contact_row['int_prefix'] != '') {

											$int = $contact_row['int_prefix'] . '.';

										} else {

											$int = '';

										}

										

											if($row['non_us_card'] == 'yes') {

												echo $contact_row['contact_type'] . ' (' . $contact_row['non_us_number'] . ')';

											} else {

												echo $contact_row['contact_type'] . ' (' . $int . $contact_row['prefix'] . '.' . $contact_row['first'] . '.' . $contact_row['last'] . ')';

											}

												

											echo '<br/>';

									}

								} else {

									echo '</p>There are no additional contact numbers</p>';	

								}

								

								

								

								?></span></li>

                                <li><span class="detail_title">Email: </span><span class="detail_text"><?php echo $row['email'] ?></span></li>

                                <li><span class="detail_title">Address: </span><span class="detail_text"><?php echo $address ?></span></li>

                                <li><span class="detail_title">Mail Stop: </span><span class="detail_text"><?php if($row['mail_stop'] == 0) {echo 'No Mail Stop given';} else {echo $row['mail_stop'];} ?></span></li>

                             </ul>

                             </span>



                             

                            <span class="detail_section">

                            <h4>Comments</h4>

                            <ul>

                                <li><span class="detail_title">Message: </span><span class="detail_text"><?php if($row['comments'] == '') {echo 'No Message given';} else {echo $row['comments'];} ?></span></li>

                             </ul>

                             </span> 

                             

                             

                             <?php 

								if($row['special_instructions'] != '') { 

								

							?>

                            

                             <span class="detail_section">

                            <h4>Custom Proof Instructions</h4>

                            <ul>

                                <li>

                                    <span class="detail_title">Message: </span>

                                    

                                    <span class="detail_text">

                                        <?php 

											if($row['special_instructions'] == '') {

												echo 'No Message given';

											} else {

												echo '(1) ' . $row['special_instructions'] . '<br />';

												 

												$instr_sql = "SELECT *

															  FROM custom_instructions

															  WHERE order_id = '" . $row['order_id'] . "'";

												

												$instr_result = $conn->query($instr_sql) or die(mysqli_error());

											

												$i = 2;							

												while ($instr_row = $instr_result->fetch_assoc()) {				

													echo '(' . $i . ') ' . $instr_row['custom_instruction'] . '<br />';

													$i++;

												}

											}

                                        ?>

                                    </span>

                             	</li>

                             </ul>

                             </span>

                         <?php } ?>

                        </td>

                    </tr>

                    

             

            <?php } //end while

			} else {//end if  ?>

            		<tr>

							<td colspan="10" style="border-bottom: 1px solid #5C7F99;">There are no Ongoing Orders.</td>

                        </tr>

            <?php } ?>

            		<tr><td colspan="11" id="tracker_table_footer" style="border-bottom: 1px solid #5C7F99; height: 0px;"></td></tr>	

        </table>

        

        

</div> <!--end container div-->





<?php mysqli_close($conn); ?>

</body>

</html>