<?php 

session_start();







error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);





$curr_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];



	//Include the PS_Pagination class

	include('../includes/ps_pagination.php');



	include("../includes/connection.php");

	

if(!isset($_SESSION['authenticated_translator'])){

	header('Location: ' . $site_basedir . 'admin/trans_login.php');

}

	

	//This creates a database connection. The function that makes this happen is in the conn.inc.php file

	$conn = dbConnect('query');

	

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

		$search_string = ' WHERE ' . $_GET['searchby'] . '= "' . $_GET['search_input'] . '" AND status = "waiting_translator" ';			

	}

	

	

	

	if(!isset($_GET['sortby']) && !isset($_GET['search_submit'])){ //Default, If no sort or search is set

		$sql = 'SELECT * 

				FROM orders 

				LEFT JOIN buildings ON orders.building_id = buildings.building_id

				WHERE status = "waiting_translator"

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

						WHERE status = 'waiting_translator'

						ORDER BY order_id ASC";

				break;

			case "order_id_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id 

						WHERE status = 'waiting_translator'

						ORDER BY order_id DESC";

				break;

				

			case "status":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status = 'waiting_translator'

						ORDER BY status ASC";

				break;

			case "status_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id 

						WHERE status = 'waiting_translator'

						ORDER BY status DESC";

				break;

	

			case "employee_id":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id 

						WHERE status = 'waiting_translator'

						ORDER BY employee_id ASC";

				break;

			case "employee_id_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status = 'waiting_translator'

						ORDER BY employee_id DESC";

				break;

				

			case "last_name":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status = 'waiting_translator'

						ORDER BY last_name ASC";

				break;

			case "last_name_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status = 'waiting_translator'

						ORDER BY last_name DESC";

				break;

				

			case "title":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status = 'waiting_translator'

						ORDER BY title ASC";

				break;

			case "title_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id 

						WHERE status = 'waiting_translator'

						ORDER BY title DESC";

				break;

				

			case "manager_email":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status = 'waiting_translator'

						ORDER BY approved_by ASC";

				break;

			case "manager_email_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status = 'waiting_translator'

						ORDER BY approved_by DESC";

				break;

				

			case "date_approved":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status = 'waiting_translator'

						ORDER BY date ASC";

				break;

			case "date_approved_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status = 'waiting_translator'

						ORDER BY date DESC";

				break;

				

			case "shipping_time":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status = 'waiting_translator'

						ORDER BY shipping_time ASC";

				break;

			case "shipping_time_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id 

						WHERE status = 'waiting_translator'

						ORDER BY shipping_time DESC";

				break;

				

			case "language":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status = 'waiting_translator'

						ORDER BY language ASC";

				break;

			case "language_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id

						WHERE status = 'waiting_translator'

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

						"ORDER BY date ASC";

				break;

			case "date_approved_desc":

				$sql = "SELECT * 

						FROM orders 

						LEFT JOIN buildings ON orders.building_id = buildings.building_id"

						 . $search_string . 

						"ORDER BY date DESC";

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

	

	//Create a PS_Pagination object

	$pager = new PS_Pagination($conn2, $sql, 8, 10);

	//The paginate() function returns a mysql

	//result set for the current page

	$result = $pager->paginate();



		

	//$result = $conn->query($sql) or die(mysqli_error());

	

	//This counts the number of entries for each status the ticker

	$ticker_sql = "SELECT status, COUNT(order_id)

					FROM orders

					WHERE status = 'waiting_translator'

					GROUP BY status";

					

	$ticker_result = $conn->query($ticker_sql) or die(mysqli_error());

	

	//This counts the total number of ongoing orders

	$ticker_total_sql = "SELECT COUNT(*)

						AS cnt

						FROM orders

						WHERE status != 'billed' AND status != 'not_approved'";

						

	$ticker_total_result = $conn->query($ticker_total_sql) or die(mysqli_error());

	

	$total_row = $ticker_total_result->fetch_assoc();

	

	

?> 





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $site_name . ' - Translator Upload Center'; ?></title>

<link href="../css/style.css" rel="stylesheet" type="text/css" />

<link rel="shortcut icon" href="../images/favicon.gif" />



<style type="text/css">

	#tracker_table { border-collapse:collapse;}

	#tracker_table h4 { margin:0px; padding:0px; font-size: 14px; text-decoration: underline;}

	#tracker_table img { float:right;}

	#tracker_table ul { margin:10px 0 10px 40px; padding:0px;}

	#tracker_table th { background:#375D81 url(header_bkg.png) repeat-x scroll center left; color:#fff; padding:7px 15px; text-align:left;}

	#tracker_table td { padding:7px 15px; }

	#tracker_table div.arrow { background:transparent url(../images/arrows.png) no-repeat scroll 0px -16px; width:16px; height:16px; display:block;}

	#tracker_table div.up { background-position:0px 0px;}

</style>





<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>



<script type="text/javascript">  

	$(document).ready(function(){

		$("#tracker_table tr:odd").addClass("odd");

		$("#tracker_table tr:not(.odd)").hide();

		$("#tracker_table tr:first-child").show();

		

		$("#tracker_table tr.odd").click(function(){

			$(this).next("tr").toggle();

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



		

		

		

	});

</script> 











</head>



<body>





<div id="container">

			

           <?php include("../includes/trans_header.php"); ?>

    

    		<form id="search" name="search" method="get" action="">

            	<select id="searchby" name="searchby">

                	<option value="order_id">Order ID</option>

                    <option value="employee_id">Employee ID</option>

                    <option value="last_name">Last Name</option>

                </select>

                <input type="text" id="search_input" name="search_input" />

                <input class="button" type="submit" id="search_submit" name="search_submit" value="Search" />

            </form>

    		

           

           

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

                                echo "Waiting for approval: ";

                                break;

                            case "approved":

                                echo "Approved: ";

                                break;

                            case "printing":

                                echo "In print: ";

                                break;

                            case "waiting_delivery":

                                echo "Waiting for delivery: ";

                                break;

                            case "delivered":

                                echo "Delivered: ";

                                break;

							case "waiting_translator":

                                echo "Waiting for translation: ";

                                break;

                        }

						echo '</div>';

						echo '<div class="ticker_content ticker_col_2">';

                        echo $row['COUNT(order_id)']; 
						
						$main_row_cnt = $row['COUNT(order_id)'];

                        ?>

                    </div>

                </div>

				<?php } //end while ?>

                

			</div>

                


			<?php if($row_cnt > 1) { ?>
            <div id="pag_nav">

			<?php

                //Display the navigation

                echo $pager->renderFullNav();	
			
            ?>

            </div>
            
            <?php } ?>

             

            <table id="tracker_table">

            

            <tr id="tracker_headers">



               <th><?php write_sortable_header_link( 'order_id', 'Order ID' ); ?></th>

            

            	<th><?php write_sortable_header_link( 'language', 'Language' ); ?></th>

               

               <th><?php write_sortable_header_link( 'last_name', 'Name' ); ?></th>

            

            	<th><?php write_sortable_header_link( 'title', 'Title' ); ?></th>

                <th><?php write_sortable_header_link( 'dept_div', 'Dept/Div' ); ?></th>

                <th>Upload</th>                 



                <th></th>            

            </tr>

            

            

            

            

            

            

            

            

            

            

            

        

            <?php 
			//if($row_cnt > 0) {
			while($row = mysql_fetch_assoc($result)) { 

				

				$phone = $row['phone_prefix'] . '.' . $row['phone_first'] . '.' . $row['phone_last'];

				

				if($row['fax_prefix'] != '') {

					$fax = $row['fax_prefix'] . '.' . $row['fax_first'] . '.' . $row['fax_last'];

				}

				

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

					

					$address .= ', ' . $address_row['city'] . ', ' . $address_row['state'] . ' ' . $address_row['zip_1'];

					

					if(isset($address_row['zip_2'])) {

						$address .= ' - ' . $address_row['zip_2'];

					}

					

					

				} else {

					$address = $row['address'] . '<br /> P.O. Box ' . $row['po_box'] . ', ' . $row['city'] . ', ' . $row['state'] . ' ' . $row['zip_code'];

				}

				

				

				

				if($row['status'] == 'waiting_translator') {

					

					$instr_sql = "SELECT *

								FROM trans_instructions

								WHERE order_id = '" . $row['order_id'] . "'";

					

					$instr_result = $conn->query($instr_sql) or die(mysqli_error());

					$row_cnt = $instr_result->num_rows;

					

					

					

					

					

					
				 ?>
			

				

                	<tr id="master">

						<td style=" <?php if($row['shipping_time'] == '1-3 work days' || $row['shipping_time'] == '4-8 work days') { echo 'border-left: 3px solid #375D81';} else { echo 'border-left: 1px solid #5C7F99';} ?>"><?php if($row_cnt > 0) {echo '<b>' . $row['order_id'] . '</b>';} else {echo $row['order_id'];} ?></td>

                        <td><?php if($row['language'] != '') {echo $row['language'];} else {echo $row['other_language'];} ?></td>

                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>

                        <td><?php echo $row['title']; ?></td>

                        <td><?php echo $row['dept_div']; ?></td>

                        <td><a class="button prev" href=" <?php echo $site_basedir; ?>admin/trans_char_upload.php?order_id=<?php echo $row['order_id']; ?>">Upload Translation Characters</a></td>

                        

                        

                        <td style=" <?php if($row['shipping_time'] == '1-3 work days' || $row['shipping_time'] == '4-8 work days') { echo 'border-right: 3px solid #375D81';} else { echo 'border-right: 1px solid #5C7F99';} ?>"><div class="arrow"></div></td>

					</tr>

                    

                    <tr id="detail">

                        <td colspan="5">



                        	<span class="detail_section">

                            <h4>Administrative Details</h4>

                            <ul>

                                <li><span class="detail_title">Order ID: </span><span class="detail_text"><?php echo $row['order_id'] ?></span></li>

                                <li><span class="detail_title">Language: </span><span class="detail_text"><?php if(isset($row['language'])) {echo $row['language'];} elseif(isset($row['other_language'])) {echo $row['language'];} else {echo 'N/A';} ?></span></li> 

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

                            <h4>User supplied characters</h4>

                            <ul>

                                 

                                 <?php

                                 if($row['foreign_characters_name'] != '' || $row['foreign_characters_line2'] != '' || $row['foreign_characters_line3'] != '' || $row['foreign_characters_line4'] != '') {

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

														echo "<a target='_blank' href='" . $site_basedir . "upload/" . $row['upload_location'] . "/$file'>$file</a><br>";

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

                             

                             



                             

                             

                             

                             

                             

                             

                        </td>

                        <td colspan="6">

                             

                            <span class="detail_section">

                            <h4>Card/Notepad Details</h4>

                            <ul>

                                <li><span class="detail_title">Name: </span><span class="detail_text"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></span></li>

                                <li><span class="detail_title">Title: </span><span class="detail_text"><?php echo $row['title'] ?></span></li>

                                <li><span class="detail_title">Title 2: </span><span class="detail_text"><?php echo $row['title_2'] ?></span></li>

                                <li><span class="detail_title">Dept/Div: </span><span class="detail_text"><?php echo $row['dept_div'] ?></span></li>

                                <li><span class="detail_title">Dept/Div 2: </span><span class="detail_text"><?php echo $row['dept_div_2'] ?></span></li>

                             </ul>

                             </span>



                             

                            <span class="detail_section">

                            <h4>Comments</h4>

                            <ul>

                            

                            	<?php if($row['comments'] != '') { ?>

                                	<li><span class="detail_title">Message: </span><span class="detail_text"><?php echo $row['comments'] ?></span></li>

                                <?php } else { ?>

                                	<li>There are no special instructions</li>

                                <?php } ?>

                             </ul>

                             </span>

                             

                             

                             <span class="detail_section">

                            <h4>Correction Instructions</h4>

                            <ul>          

                            	<?php 

									$i = 1;

								

									if($row_cnt > 0) { 

										while($instr_row = $instr_result->fetch_assoc()) {

								?>

                                			<li><span class="detail_title">Correction Instruction(<?php echo $i; ?>): </span><span class="detail_text"><?php echo $instr_row['instruction_message']; ?></span></li>

                                <?php $i++; 

								}

								

								} else { ?>

                                	<li>This order has not been translated and does not require any corrections</li>

                                <?php } ?>

                             </ul>

                             </span> 

                        </td>

                    </tr>

             

            <?php
			
			}
			
			
			}//end while
			//} //end if $row_cnt > 0
			 if($main_row_cnt == '') { ?>
            		<tr>
                    	<td colspan="11" style="border-bottom: 1px solid #5C7F99; height: 0px;">There are no orders that require translations at this time.</td>
                    </tr>
            
            <?php } ?>

            		<tr><td colspan="11" id="tracker_table_footer" style="border-bottom: 1px solid #5C7F99; height: 0px;"></td></tr>	

        </table>

        

        

</div> <!--end container div-->





<?php mysqli_close($conn); ?>

</body>

</html>