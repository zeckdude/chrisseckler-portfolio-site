<?php

// Displays List Deletion confirmation and deletes the entry if chosen
function delete_list($listid) {
  if(!$listid) {
    return false;
  }
  
  $deleted = false;
  $deleted2 = false;
  
  if (array_key_exists('delete', $_POST)) { 
  	  $conn=db_connect();
	  $sql = 'DELETE FROM lists WHERE listid = ?'; //This tells the database to delete the entry with the id # that is currently being sent from the form
	  $stmt = $conn->stmt_init();
	  if ($stmt->prepare($sql)) {
		$stmt->bind_param('i', $_POST['id']); 
		$deleted = $stmt->execute(); 
		}
		
	  $sql2 = 'DELETE FROM sub_lists WHERE listid = ?'; 
	  $stmt = $conn->stmt_init();
	  if ($stmt->prepare($sql2)) {
		$stmt->bind_param('i', $_POST['id']); 
		$deleted2 = $stmt->execute();
	  }	
  }
 
  if ($deleted == true || $deleted2 == true || array_key_exists('cancel_delete', $_POST) || !isset($_GET['id']))  {
	header('Location: index.php?action=show-all-lists'); 
	exit;
	}
	
  if (isset($stmt) && !$deleted && !$deleted2) {
	echo $stmt->error;
	}
	  
  $info=load_list_info($listid); //$info is an array that holds all the information about that list
  
  ?>
  
  <div id="adminenter_box">
	  <p>
		  Are you sure you want to delete this List?
	  </p>
  </div>
  
  <div class="content_area">
  
      <table id="subscriberedit_table">
          <thead>
              <tr>
                <th>List Name</th>
                <th>List Description</th>
                <th>Number of Subscribers</th>
                <th>Number of messages in archive</th>
              </tr>
          </thead>
          <tbody>
              <tr style="text-align: center; height: 70px;" >
              <?php if($info) { ?>
                <td><?php echo pretty($info[listname]);?></td>
                <td><?php echo pretty($info[blurb]);?></td>
                <td><?php echo $info[subscribers];?></td>
                <td><?php echo $info[archive];?></td>
              </tr>
              <?php } ?>
          </tbody>
      </table>
           
              
                  	
		  
    <form id="form1" name="form1" method="post" action="">
        <span id="delete_area">
            <span class="delete_btn"><input class="submit_button" name="cancel_delete" type="submit" id="cancel_delete" value="Cancel" /></span>
            <span class="delete_btn"><input class="submit_button" name="delete" type="submit" value="Confirm deletion" /></span>
            <input name="id" type="hidden" value="<?php echo $listid; ?>" />
        </span>
    </form>
    </div> 
<?php
} //end function delete_list



// Displays List edit page
function edit_list($listid) {
  if(!$listid) {
    return false;
  }
  
  $updated = false; 
	  
  if (array_key_exists('update', $_POST)) { 
	  $conn=db_connect();
	  $sql = 'UPDATE lists
			  SET listname = ?, blurb = ?
			  WHERE listid = ?';
			  
	  $stmt = $conn->stmt_init(); 
	  if ($stmt->prepare($sql)) { 
		  $stmt->bind_param('ssi', $_POST['name'], $_POST['blurb'], $_POST['id']);
		  $updated = $stmt->execute();
	  }
  }
	
  if ($updated == true || !isset($_GET['id'])) {
	  header('Location: index.php?action=show-all-lists');
	  exit; //and exit the script	
  }
  
  if (isset($stmt) && !$OK && !$updated) { 
	  echo $stmt->error;
  }
	  
  $info=load_list_info($listid); //$info is an array that holds all the information about that list
  
  if($info) { //the pretty function adds the necessary string functions to it, such as trim, htmlspecialchars, n12br, and stripslashes
    
	?>
		  
       <div id="adminenter_box">
        	<p>
        		You are editing the list information for <?php echo pretty($info[listname]); ?>
        	</p>
        </div>
       <div class="content_area">
           <form action="" method="post">
               
               
               
               <table id="form_table">
                        <tr>
                                <th>List Name:</th>
                               <td><input type="name" name="name" size="20" maxlength="20" value="<?php echo pretty($info[listname]); ?>" /></td>
                        </tr>
                        
                        <tr>
                            <th>List Description:</th>
                            <td><textarea rows="4" cols="72" name="blurb"><?php echo pretty($info[blurb]); ?></textarea></td>
                        </tr>
                        
                        <tr>
                            <th></th>
                            <td>
                                <input class="submit_button" type="submit" name="update" value="Edit the <?php echo pretty($info[listname]); ?> List" />
                            </td>
                        </tr>
                    </table>
               <input name="id" type="hidden" value="<?php echo $listid; ?>" />
           </form>
       </div>
       <br />
	<?php
  }
} //end function edit_list









// Displays Unsent Mail Deletion confirmation and deletes the mail if chosen
function delete_mail($mailid) {
  if(!$mailid) {
    return false;
  }
  
  $deleted = false;
  
  if (array_key_exists('delete', $_POST)) { 
  	  $conn=db_connect();
	  
	   $sql2 = "SELECT listid
	  	  		FROM mail
		  		WHERE mailid ='" . $_POST['id'] . "'";
			   
  	  $result = $conn->query($sql2) or die(mysqli_error());
	  $row = $result->fetch_assoc();
	  
	  //This deletes the email information from the database
	  $sql = 'DELETE FROM mail WHERE mailid = ?';
	  $stmt = $conn->stmt_init();
	  if ($stmt->prepare($sql)) {
		$stmt->bind_param('i', $_POST['id']);
		$deleted = $stmt->execute();
		}
		
	  //This deletes the folder and the preview files from the archive directory	
	  $path = 'archive/'.$row['listid'].'/'.$mailid;
	  $cmd = "rm -rf $path";
	  `$cmd`;
		
		
	  }
	  
  if ($deleted == true || array_key_exists('cancel_delete', $_POST) || !isset($_GET['id']))  {
	header('Location: index.php?action=view-mail'); 
	exit;
	}
	
  if (isset($stmt) && !$OK && !$deleted) {
	echo $stmt->error;
	}
	  
  $info=load_mail_info($mailid); //$info is an array that holds all the information about that list
  
  
 
   ?>
   <div id="adminenter_box">
        <p>
            Are you sure you want to delete the following Unsent mail?
        </p>
    </div>
  
  <div class="content_area">
  
      <table id="subscriberedit_table">
          <thead>
              <tr>
                <th>Email Subject</th>
                <th>List this email is assigned to</th>
              </tr>
          </thead>
          <tbody>
              <tr style="text-align: center; height: 70px;" >
              <?php if($info) { ?>
                <td><?php echo pretty($info[subject]);?></td>
                <td><?php echo pretty($info[listname]);?></td>
              </tr>
              <?php } ?>
          </tbody>
      </table>
           
              
                  	
		  
    <form id="form1" name="form1" method="post" action="">
          <p>
          	<span id="delete_area">
              <input class="submit_button" name="cancel_delete" type="submit" id="cancel_delete" value="Cancel" />
              <input class="submit_button" name="delete" type="submit" value="Confirm deletion" />
              <input name="id" type="hidden" value="<?php echo $mailid; ?>" />
          	</span>
          </p>
      </form>
    </div>

<?php } //end function delete_mail



function subscriber_list() {
	
	$conn=db_connect();
				
	//This query grabs all the subscriber information from the subscribers table
	$query2 = "SELECT email, realname, mimetype
	  		   FROM subscribers
			   ORDER BY email";
			   
	$result = $conn->query($query2) or die(mysqli_error()); 
?>
    <table id="subscriberedit2_table">
    	<thead>
            <tr id="schedule_header" class="dark_background">
                <th>Email</th>
                <th>Name</th>
                <th>Preferred Email Type</th>
                <th>Assigned List</th>
            </tr>
        </thead>
        
        <tbody>
			<?php while($row = $result->fetch_assoc()) { ?> <!--Starts the subscriber info main loop-->
                <tr onclick="window.location.href='index.php?action=edit-subscriber&email=<?php echo $row['email']; ?>'" OnMouseOver="this.className='cursor';" style="text-align: center;">
                    <td style="padding: 10px 10px;"><?php echo $row['email']; ?></td>
                    <td style="padding: 10px 10px;"><?php echo $row['realname']; ?></td>
                    <td style="padding: 10px 10px;"><?php if ($row['mimetype'] == 'H') {
                            echo 'Html';	
                        } else {
                            echo 'Text';	
                        }?>
                    </td>
                    <td style="padding: 10px 10px;"><?php 
                    //Grabbing all the entries that have the same email in the sub_lists table as in the subscribers table
                    $query3 = "SELECT *
                              FROM sub_lists 
                              WHERE email ='" . $row['email'] . "'";
                    $result2 = $conn->query($query3) or die(mysqli_error());
                    $string = "";
                    while($row2 = $result2->fetch_assoc()) { //Starts the loop that connects the sub_lists and subscriber table
                        
                        //Grabbing all the entries that have the same listid number in the lists table as in the sub_lists table
                        $query4 = "SELECT *
                              FROM lists 
                              WHERE listid ='" . $row2['listid'] . "'";
                        $result3 = $conn->query($query4) or die(mysqli_error());
                        while($row3 = $result3->fetch_assoc()) { //Starts the loop that grabs the entries that have the same listid in lists and in sub_lists
                            $string .= $row3['listname'];
                            $num_row = $result2->num_rows;
                            if ($num_row > 1) {
                                $string .= ", ";
                        
                            } //ends if statement
                            
                        } //ends the loop that grabs the entries that have the same listid in lists and in sub_lists
                        
                    } //ends the loop that connects the sub_lists and subscriber table
                    $string = rtrim($string, " ,");
                    echo $string;
                        
                    ?>
                    </td>
                     
                </tr>
            </tbody>
        <?php } ?> <!--Ends the subscriber info main loop-->

            </table>   
    <?php	
} //end function subscriber_list



function edit_subscriber() {
	 $conn=db_connect();
	
	$query = "SELECT email, realname, mimetype
	  		   FROM subscribers
			   WHERE email ='" . $_GET['email'] . "'";
			   
	$result = $conn->query($query) or die(mysqli_error());
	
	while($row = $result->fetch_assoc()) { 
		$email = $row['email'];
		$realname = $row['realname'];
		$mimetype = $row['mimetype'];
	}
	
	
	
	
	$inserted = false; 
	  
	if (array_key_exists('assign', $_POST)) {
		
		$sql = 'SELECT *
		 		FROM sub_lists
				WHERE email = "' . $_GET['email'] . '" AND listid = "' . $_POST['list_selection'] . '"';
		$result = $conn->query($sql) or die(mysqli_error());	
		$rownum = $result->num_rows;
		
		if ($rownum > 0) {
			$warning = 'This subscriber is already assigned to that list';	
		} else {
			
			$sql = 'INSERT INTO sub_lists (email, listid)
					VALUES(?, ?)'; 

			$stmt = $conn->stmt_init();
			if ($stmt->prepare($sql)) {
				$stmt->bind_param('si', $_GET['email'], $_POST['list_selection']); 
				$inserted = $stmt->execute(); 
			}
	
			//redirect if successful
			if ($inserted == true) { 
				header('Location: index.php?action=edit-subscriber&email='. $_GET["email"]);
				} else { 
				echo $stmt->error; 
				}
		}
	} //end if assign statement
	
	$updated = false;
	$updated2 = false;
	if (array_key_exists('update', $_POST)) {
			
		$sql = 'UPDATE subscribers
				SET email = ?, realname = ?, mimetype = ?
				WHERE email = ?';
				
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql)) { 
			$stmt->bind_param('ssss', $_POST['email'], $_POST['realname'], $_POST['mimetype'], $_GET['email']);
			$updated = $stmt->execute();
		}
		
		
		$sql2 = 'UPDATE sub_lists
				SET email = ?
				WHERE email = ?';
				
		$stmt = $conn->stmt_init(); 
		if ($stmt->prepare($sql2)) { 
			$stmt->bind_param('ss', $_POST['email'], $_GET['email']);
			$updated2 = $stmt->execute();
		}
		
		
		
	} //end if update statement	
	
		//redirect if successful
		if ($updated == true && $updated2 == true) { 
			header('Location: index.php?action=subscriber-list');
		} else { 
			echo $stmt->error; 
		}
	
	
?>

<div id="adminenter_box">
    <p>
        You are editing the subscriber information for <?php echo htmlentities($realname); ?>
    </p>
</div>

<div id="delete_agent_btn">
    <a href="index.php?action=delete-subscriber&email=<?php echo $email; ?>">- Delete this Subscriber</a>
</div>

<div class="content_area">

    <table id="subscriberedit_table">
    	<thead>
            <tr id="schedule_header">
                <th style="color: black;">Email</th>
                <th style="color: black;">Name</th>
                <th style="color: black;">Preferred Email Type</th>
                <th style="color: black;">Assigned list</th>
                <th style="color: black;">New list to assign to</th>
            </tr>
        </thead>
        
        <?php  
		
		if(isset($email)) { $_SESSION['email'] = $email; }
		if(isset($realname)) { $_SESSION['realname'] = $realname; }
		if(isset($mimetype)) { $_SESSION['mimetype'] = $mimetype; }
		
		
		?> <!--Starts the subscriber info main loop-->
        <tbody>
            <tr style="text-align: center; height: 100px;">
            	<form id="new_list" name="new_list" method="post" action="">
                <td><input name="email" type="text" id="email_edit" value="<?php echo $_SESSION['email']; ?>"/></td>
                <td><input name="realname" type="text" id="realname_edit" value="<?php echo $_SESSION['realname']; ?>"/></td>
                <td>
					<select name="mimetype">
                          <option <?php if($_SESSION['mimetype'] == 'H') { echo 'selected'; } ?>  value="H">
                          	Html
                          </option>
                          <option <?php if($_SESSION['mimetype'] == 'T') { echo 'selected'; } ?> value="T">
                          	Text
                          </option>
                    </select>
                </td>
                
                <td><?php 
				//Grabbing all the entries that have the same email in the sub_lists table as in the subscribers table
				$query3 = "SELECT *
	  		   			  FROM sub_lists 
						  WHERE email ='" . $email . "'";
				$result2 = $conn->query($query3) or die(mysqli_error());
				$string = "";
				while($row2 = $result2->fetch_assoc()) { //Starts the loop that connects the sub_lists and subscriber table
					
					//Grabbing all the entries that have the same listid number in the lists table as in the sub_lists table
					$query4 = "SELECT *
	  		   			  FROM lists 
						  WHERE listid ='" . $row2['listid'] . "'";
					$result3 = $conn->query($query4) or die(mysqli_error());
					
					while($row3 = $result3->fetch_assoc()) { //Starts the loop that grabs the entries that have the same listid in lists and in sub_lists
					
						if (isset($_GET['email']) && isset($_GET['listid'])) {
							
							$deleted = false;
							$conn=db_connect();
							$sql = 'DELETE FROM sub_lists 
									WHERE email = ? AND listid = ?'; 
							$stmt = $conn->stmt_init();
							if ($stmt->prepare($sql)) {
							  $stmt->bind_param('si', $email, $_GET['listid']); 
							  $deleted = $stmt->execute(); 
							}
								  
							if ($deleted == true)  {
							  header('Location: index.php?action=edit-subscriber&email='. $email); 
							  exit;
							}
							  
							if (isset($stmt) && !$OK && !$deleted) {
							  echo $stmt->error;
							}
						} //end if isset statement

						echo $row3['listname'] . '  <a href="index.php?action=edit-subscriber&email='. $_SESSION['email'] .'&listid='. $row2['listid'] .'">X</a><br />';
						
					} //ends the loop that grabs the entries that have the same listid in lists and in sub_lists
				} //ends the loop that connects the sub_lists and subscriber table	
				?></td> 
                <td>
                <?php
                $query = "SELECT *
	  					  FROM lists";
				$result = $conn->query($query) or die(mysqli_error());			  
                ?>
                <form id="new_list" name="new_list" method="post" action="">
                <span style="margin-top:20px; display: block;">
                <select name="list_selection">
					<?php while($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['listid'] . '">' . $row['listname'] . '</option>';
                    }
                    ?>
                </select>
                <input class="submit_button" type="submit" name="assign" id="submit" value="Assign" style="width: 75px; margin-bottom: 20px; padding: 5px;" />
                </span>
         		
                </td>
            </tr>
        </tbody>
        <?php  ?> <!--Ends the subscriber info main loop-->

	</table> <!--end schedule_table-->
		<input class="submit_button" type="submit" name="update" id="subscriberedit_submit" value="Edit Subscriber information" />
         </form>	<!--end subscriber edit form-->
         </form> <!--end assign form-->
         <?php echo $warning; ?>
</div>      
    <?php	
} //end function subscriber_edit



function new_subscriber() {
	$conn=db_connect();
	
	$inserted = false; 
	$inserted2 = false;
	if (array_key_exists('insert', $_POST)) { 
		
		$sql = 'INSERT INTO subscribers (email, realname, mimetype)
				VALUES(?, ?, ?)'; 
	
		$stmt = $conn->stmt_init();
		if ($stmt->prepare($sql)) {
			$stmt->bind_param('sss', $_POST['email'], $_POST['realname'], $_POST['mimetype']); 
			$inserted = $stmt->execute() or die(mysqli_error($conn)); 
		}
		
		
		$sql2 = 'INSERT INTO sub_lists (email, listid)
				VALUES(?, ?)'; 
	
		$stmt = $conn->stmt_init();
		if ($stmt->prepare($sql2)) {
			$stmt->bind_param('si', $_POST['email'], $_POST['list_selection']); 
			$inserted2 = $stmt->execute() or die(mysqli_error($conn)); 
		}
		
		} //end if insert

		//redirect if successful
		if ($inserted == true && $inserted2 == true) { 
			header('Location: index.php?action=subscriber-list');
		} else { 
			echo $stmt->error; 
		}
	?>
	
    <div id="adminenter_box">
        <p>
            You are adding a new Subscriber
        </p>
    </div>
    
    <div class="content_area" style="padding-bottom: 20px;">
        <table id="subscriberedit_table">
            <tr id="schedule_header">
                <th style="color: black;">Email</th>
                <th style="color: black;">Name</th>
                <th style="color: black;">Preferred Email Type</th>
                <th style="color: black;">List</th>
            </tr>
            
            <tr style="text-align: center; height: 115px; margin-bottom: 50px;">
            <form id="new_list" name="new_list" method="post" action="">
                <td><input name="email" type="text" id="email_pick" value=""/></td>
                <td><input name="realname" type="text" id="realname_pick" value=""/></td>
                <td>
                    <select name="mimetype">
                      <option value="H">HTML</option>
                      <option value="T">Text</option>
                    </select>
                </td> 
                <td>
                <?php
                $query = "SELECT *
                          FROM lists";
                $result = $conn->query($query) or die(mysqli_error());?>
    
                <select name="list_selection" style="position:relative; top: 25px;">
                    <?php while($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['listid'] . '">' . $row['listname'] . '</option>';
                    }?>
                </select>
                <input style="position:relative; top: 45px; left: -470px;" class="submit_button" type="submit" name="insert" id="submit" value="Add new Subscriber" />
            </form>
                </td>
            </tr>
    
        </table>
	</div>	
            
    <?php	
} //end function subscriber_new



// Displays List Deletion confirmation and deletes the entry if chosen
function delete_subscriber() {
	$conn=db_connect();
  
  $query = "SELECT email, realname, mimetype
	  		FROM subscribers
			WHERE email ='" . $_GET['email'] . "'";
			   
  $result = $conn->query($query) or die(mysqli_error());
  $row = $result->fetch_assoc();
  
  $deleted = false;
  $deleted2 = false;
  
  if (array_key_exists('delete', $_POST)) { 
  	  $conn=db_connect();
	  $sql = 'DELETE FROM subscribers WHERE email = ?'; //This tells the database to delete the entry with the id # that is currently being sent from the form
	  $stmt = $conn->stmt_init();
	  if ($stmt->prepare($sql)) {
		$stmt->bind_param('s', $_GET['email']); 
		$deleted = $stmt->execute(); 
		}
		
	  $sql2 = 'DELETE FROM sub_lists WHERE email = ?'; 
	  $stmt = $conn->stmt_init();
	  if ($stmt->prepare($sql2)) {
		$stmt->bind_param('s', $_POST['email']); 
		$deleted2 = $stmt->execute();
	  }	
  }
 
  if (($deleted == true && $deleted2 == true) || array_key_exists('cancel_delete', $_POST) || !isset($_GET['email']))  {
	header('Location: index.php?action=subscriber-list'); 
	exit;
	}
	
  if (isset($stmt) && !$deleted && !$deleted2) {
	echo $stmt->error;
	}
	?>  
  <div id="adminenter_box">
	  <p>
		  Are you sure you want to delete this Subscriber?
	  </p>
  </div>
  
  <div class="content_area">
		  <table id="subscriberedit_table">
              <thead>
                  <tr>
                      <th>Email</th>
                      <th>Name</th>
                      <th>Preferred Email Type</th>
                      <th>
                      	<?php
                      		$listname = "";
							$query2 = "SELECT email, listid
							  FROM sub_lists
							  WHERE email ='" . $_GET['email'] . "'";
								 
							$result2 = $conn->query($query2) or die(mysqli_error());
							echo "List";
								  $num_row = $result2->num_rows;
								  if ($num_row > 1) {
									  echo "s";
								  }
							echo " assigned to: ";
                      	?>
                      </th>
                  </tr>
              </thead>
              <tbody style="font-size: 11px;">
                  <tr style="text-align: center;">
                      <td><?php echo pretty($row['email']); ?></td>
                      <td><?php echo pretty($row['realname']); ?></td>
                      
                      
                      <td><?php if (pretty($row['mimetype']) == 'H') {
							  echo 'Html';	
						  } else {
							  echo 'Text';	
						  }?>
					  </td>
                      
                      
                      
                      <td>
						<?php	  
                              while($row2 = $result2->fetch_assoc()) {
                                  
                              $query3 = "SELECT listid, listname
                                        FROM lists
                                        WHERE listid ='" . $row2['listid'] . "'";
                              $result3 = $conn->query($query3) or die(mysqli_error());
                                while($row3 = $result3->fetch_assoc()) {
                                    $listname .= $row3['listname'];
                                    $num_row = $result2->num_rows;
                                    if ($num_row > 1) {
                                        $listname .= ", ";
                                    } //ends if statement
                                } //end while
                              } //end while
                              $listname = rtrim($listname, " ,");
                              echo $listname;
                        ?>
                      </td>
                  </tr>
              </tbody>
          </table>

		  
        <form id="form1" name="form1" method="post" action="">
            <span id="delete_area">
            	<span class="delete_btn"><input class="submit_button" name="cancel_delete" type="submit" id="cancel_delete" value="Cancel" /></span>
                <span class="delete_btn"><input class="submit_button" name="delete" type="submit" value="Confirm deletion" /></span>
            </span>
        </form>
    </div>
	<?php
  
} //end function delete_list



function lists_list() {
	
	$conn=db_connect();
				
	//This query grabs all the lists information from the lists table
	$query = "SELECT listid, listname
	  		   FROM lists
			   ORDER BY listid";
			   
	$result = $conn->query($query) or die(mysqli_error()); 
?>
    <table id="subscriberedit_table">
    	<thead>
            <tr id="schedule_header" class="dark_background">
                <th>List Name</th>
                <th>Information</th>
                <th>Show Archive</th>
                <th>Edit List</th>
                <th>Delete List</th>
            </tr>
        </thead>
        
        <tbody>
			<?php while($row = $result->fetch_assoc()) { ?> <!--Starts the subscriber info main loop-->
                <tr style="text-align: center;">
                    <td style="padding: 10px 10px;"><?php echo $row['listname']; ?></td>
                    <td style="padding: 10px 10px;"><a style="height: 100px;" href="index.php?action=information&id=<?php echo $row['listid']; ?>">Information</a></td>
                    <td style="padding: 10px 10px;"><a href="index.php?action=show-archive&id=<?php echo $row['listid']; ?>">Show Archive</a></td>
                    <td style="padding: 10px 10px;"><a href="index.php?action=edit-list&id=<?php echo $row['listid']; ?>">Edit</a></td> 
                    <td style="padding: 10px 10px;"><a href="index.php?action=delete-list&id=<?php echo $row['listid']; ?>">Delete</a></td> 
                </tr>
            </tbody>
        <?php } ?> <!--Ends the subscriber info main loop-->

            </table>   
    <?php	
} //end function lists_list















?>
