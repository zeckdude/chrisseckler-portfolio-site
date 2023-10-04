<?php
// set for 600x800 screen
$table_width='760';

function do_html_header($title='') {
  // print an HTML header

  global $table_width;

  //draw title bar
?>
  <html>
  <head>
    <title><?php echo $title?></title>
    <style>
      h1 { font-family: Arial,  Helvetica, sans-serif; font-size: 32;
           font-weight: bold; color:  black; margin-bottom: 0}
      h2 { margin-bottom: 0}
      b { font-family: Arial, Helvetica, sans-serif; font-size: 14;
          font-weight: bold; color: black }
      th { font-family: Arial,  Helvetica, sans-serif; font-size: 18
           font-weight: bold; color:  white; }
      body, li, td, p { font-family: Arial, Helvetica, sans-serif;
                     font-size: 14; margin=5px }
      a { color: #000000 }
    </style>
  </head>
  <body>
  <table width="<?php echo $table_width; ?>" cellspacing="0" cellpadding="6" border="0">
  <tr>
  <td width="<?php echo ($table_width - 73);?>">
      <a href="index.php"><h1><?php echo $title?></h1></a>
  </td>
  </tr>
  </table>
  <table width="<?php echo $table_width; ?>" cellpadding="0" cellspacing="0" border="0">
  <tr><td>
<?php
}

// Print a flexible list of items and optional action buttons for each
// This function is a bit of a mess to read
// $title is the heading
// $list is the array of items to list
//  - $list[x][0] -item id
//  - $list[x][1] -item name
//  - $list[x][2] -parent name (optional)
//  - $list[x][3] -parent id (optional)
// action1, 2, and 3 are the optional actions for up to three buttons per item

function display_items($title, $list, $action1='', $action2='', $action3='', $action4='') {
  global $table_width;
  
  
  echo '<div class="content_area">';
  echo "<table width=\"$table_width\" cellspacing=\"0\" cellpadding=\"0\"
         border=\"0\">";

  // count number of actions
  $actions=(($action1!='') + ($action2!='') + ($action3!='') + ($action4!=''));

  echo "<tr>
        <th colspan=\"".(1+$actions)."\" bgcolor=\"#5B69A6\">".$title."</th>
        </tr>";

  // count number of items
  $items=sizeof($list);

  if($items == 0) {
    echo "<tr>
          <td colspan=\"".(1+$actions)."\" align=\"center\">No Items to Display</td>
          </tr>";
  } else  {
    // print each row
    for($i=0; $i<$items; $i++) {
      

      echo "<tr>
            <td bgcolor=\"".$bgcolor."\"
             width=\"".($table_width - ($actions * 149))."\">";

      echo $list[$i][1];

      if ($list[$i][2]) {
        echo " - ".$list[$i][2];
      }

      echo "</td>";

      // create buttons for up to three actions per line
      for($j=1; $j<=4; $j++) {
        $var="action".$j;

        if($$var) {
          echo "<td bgcolor=\"".$bgcolor."\" width=\"149\">";
          // view/preview buttons are a special case as they link to a file
          if(($$var == 'preview-html') || ($$var == 'view-html') ||
             ($$var == 'preview-text') || ($$var == 'view-text')) {
            display_preview_button($list[$i][3], $list[$i][0], $$var);
          } else {
            display_button($$var, '&id=' . $list[$i][0] );
          }
          echo "</td>";
        }
      }
      echo "</tr>\n";
    }
    echo "</table>";
	echo "</div>";
  }
}











function display_archive_mail($list, $action1='', $action2='', $action3='', $action4='') {
  
  
  
  echo '<div class="content_area">';
  echo "<table id='subscriberedit_table' cellspacing=\"5\" cellpadding=\"0\"
         border=\"0\">";

  // count number of actions
  $actions=(($action1!='') + ($action2!='') + ($action3!='') + ($action4!=''));

  echo "<tr>
        	<th>Email Subject - List Name</th>
			<th>View Html</th>
			<th>View Text</th>
        </tr>";

  // count number of items
  $items=sizeof($list);

  if($items == 0) {
    echo "<tr>
		
          <td colspan='3' align='center'>No Items to Display</td>
          </tr>";
	echo "</table>";	  
	echo "</div>";
	
  } else  {
    // print each row
    for($i=0; $i<$items; $i++) {
      
	//This line prints out the Email Subject and List Name
    echo "<tr style='text-align: center;'> 
            	<td>" . $list[$i][1];
      				if ($list[$i][2]) {
        				echo " - ".$list[$i][2];
      				}
      	  echo "</td>";

      	  // create buttons for up to three actions per line
      for($j=1; $j<=4; $j++) {
        $var="action".$j;

        if($$var) {
          echo "<td>";
          // view/preview buttons are a special case as they link to a file
          if(($$var == 'view-html') || ($$var == 'view-text')) {
            display_preview_button($list[$i][3], $list[$i][0], $$var);
          } else {
            display_button($$var, '&id=' . $list[$i][0] );
          }
          echo "</td>";
        }
      }

    echo "</tr>";
    } //end for loop
    echo "</table>";
	echo "</div>";
  } //end else 
} // end function




function display_unsent_mail($list, $action1='', $action2='', $action3='', $action4='') {
  
  
  
  echo '<div class="content_area">';
  echo "<table id='subscriberedit_table' cellspacing=\"5\" cellpadding=\"0\"
         border=\"0\">";

  // count number of actions
  $actions=(($action1!='') + ($action2!='') + ($action3!='') + ($action4!=''));

  echo "<tr>
        	<th>Email Subject - List Name</th>
			<th>Preview Html</th>
			<th>Preview Text</th>
			<th>Delete Mail</th>
			<th>Send Mail</th>
        </tr>";

  // count number of items
  $items=sizeof($list);

  if($items == 0) {
    echo "<tr>
		
          <td colspan='3' align='center'>No Items to Display</td>
          </tr>";
	echo "</table>";	  
	echo "</div>";
	
  } else  {
    // print each row
    for($i=0; $i<$items; $i++) {
      
	//This line prints out the Email Subject and List Name
    echo "<tr style='text-align: center;'> 
            	<td>" . $list[$i][1];
      				if ($list[$i][2]) {
        				echo " - ".$list[$i][2];
      				}
      	  echo "</td>";

      	  // create buttons for up to three actions per line
      for($j=1; $j<=4; $j++) {
        $var="action".$j;

        if($$var) {
          echo "<td>";
          // view/preview buttons are a special case as they link to a file
          if(($$var == 'preview-html') || ($$var == 'view-html') ||
             ($$var == 'preview-text') || ($$var == 'view-text')) {
            display_preview_button($list[$i][3], $list[$i][0], $$var);
          } else {
            display_button($$var, '&id=' . $list[$i][0] );
          }
          echo "</td>";
        }
      }

    echo "</tr>";
    } //end for loop
    echo "</table>";
	echo "</div>";
  } //end else 
} // end function










// diplay stored information about each list
function display_information($listid) {
  if(!$listid) {
    return false;
  }

  $info=load_list_info($listid);

  if($info) {
    echo "<div class='content_area'>
		  <span style='display: block; padding: 20px; line-height: 20px;'>
		  <p><b>List Name:</b> ".pretty($info[listname])."</p>
          <p><b>List Description:</b> ".pretty($info[blurb])."</p>
          <p><b>Number of subscribers:</b> ".$info[subscribers]."</p>
          <p><b>Number of messages in archive:</b> ". $info[archive]."</p>
		  </span>
		  </div>";
  }
}


function display_form_button($button) {
  //display one of our standard buttons in a form
  echo "<div align=\"center\">
        <input type=\"image\" src=\"images/".$button.".gif\"
        border=\"0\" width=\"149\" height=\"43\"
        alt=\"".format_action($button)."\" /></a>
        </div>";
}

function display_button($button, $extra_parameters='') {
  //display one of our standard buttons as a href
  $url="index.php?action=$button";
  if($extra_parameters) {
    $url .= $extra_parameters;
  }

  echo "<div align=\"center\"><a href=\"".$url."\">
        <img src=\"images/".$button.".png\" border=\"0\"
        alt=\"".format_action($button)."\"/></a></div>";
}




function display_button2($button, $extra_parameters='') {
  //display one of our standard buttons as a href
  $url="index.php?action=$button";
  if($extra_parameters) {
    $url .= $extra_parameters;
  }

  echo "<div><a href=\"".$url."\">" .format_action($button). "</a></div>";
}





function display_preview_button($list, $mail, $button) {
  if (($button == 'view-html') || ($button== 'preview-html')) {
    echo "<div align=\"center\">
          <a href=\"archive/".$list."/".$mail."/index.html\"
          target=\"new\"><img src=\"images/".$button.".png\"
          width=\"32\" height=\"32\" border=\"0\"
          alt=\"".format_action($button)."\" /></a></div>\n";
  } else {
    echo "<div align=\"center\">
          <a href=\"archive/".$list."/".$mail."/text.txt\"
          target=\"new\"><img src=\"images/".$button.".png\"
          width=\"32\" height=\"32\" border=\"0\"
          alt=\"".format_action($button)."\" /></a></div>\n";
  }
}



function display_preview_button2($list, $mail, $button) {
  
    echo "<a class='submit_button' href=\"archive/".$list."/".$mail."/index.html\" target=\"new\">Preview Html</a>";

}




function display_spacer() {
  //display blank spacer the size of our buttons
  echo "<img src=\"images/spacer.gif\" border=\"0\"
        width=\"149\" height=\"43\" alt=\"\"/>";
}

function format_action($string) {
  // convert our actions into a displayable string
  // eg "account-setup" becomes "Account Setup"
  $string=str_replace('-', ' ', $string);
  $string=ucwords($string);
  return $string;
}

function display_toolbar($button, $extra_parameters='') {
  // draw our toolbar
  // there are up to five buttons per row and up to three rows
  // these numbers are completely arbitary and depend on the
  // images size and acceptable screen width

  global $table_width;

  echo "<table width=\"".$table_width."\"
         cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";

  for($i=0; $i < 3; $i++) {

    if($button[($i*5)]) {
      echo "<tr>
            <td bgcolor=\"#cccccc\">";

      for($j=0; $j < 5; $j++) {
        echo "<td bgcolor=\"#cccccc\">";
        if ($button[($i*5+$j)]) {
          display_button($button[$i*5+$j], $extra_parameters);
        } else {
          display_spacer();
        }
        echo "</td>";
      }
      echo "</tr>";
    }
  }
  echo "</table>";
}


function display_main_toolbar() {
  echo '<div id="toolbar">
 			<ul>
				<li><a href="index.php?action=manage-subscribers">Manage Subscribers</a></li>
				<li><a href="index.php?action=manage-lists">Manage Lists</a></li>
				<li><a href="index.php?action=manage-mail">Manage Mail</a></li>
			</ul>
  		</div>';
}

function display_subscribers_toolbar() {
  echo '<div id="subscribers_toolbar">
 			<ul>
				<li><a href="index.php?action=new-subscriber">+ Add a new Subscriber</a></li>
			</ul>
  		</div>';
}

function display_lists_toolbar() {
  echo '<div id="lists_toolbar">
 			<ul style="list-style-type: none;">
				<li><a href="index.php?action=create-list">+ Create a new List</a></li>
			</ul>
  		</div>';
}

function display_mail_toolbar() {
  echo '<div id="mail_toolbar">
				<a class="submit_button" style="height: 30px; position: relative; top: 35px; left: 170px;" href="index.php?action=create-mail">+ Create new Mail</a>
				<a class="submit_button" style="height: 30px; position: relative; top: 35px; left: 195px;" href="index.php?action=view-mail">View unsent Mail</a>
  		</div>';
}







function pretty($string) {
  //prepare a text message for tidy display as HTML

  $string=trim($string);
  $string=htmlspecialchars($string);
  $string=nl2br($string);
  $string=stripslashes($string);

  return $string;
}

function pretty_all($array) {
  //prepare an array of text messages for tidy display as HTML
  foreach ($array as $key => $val) {
    $array[$key]=pretty($val);
  }
  return $array;
}



function display_mail_form($email, $listid=0) {
  // display html form for uploading a new message
  global $table_width;
  $list=get_all_lists();
  $lists=sizeof($list);
?>

<div id="adminenter_box">
    <p>
        To create a new Mail:<br />
        1. Select the List to send it to<br />
        2. Choose a subject<br />
        3. Browse for the Text Version<br />
        4. Browse for the Html Version<br />
        5. Attach any images used in the Html
    </p>
</div>

<div class="content_area">
  <table id="mail_form_table" style="padding: 30px;" cellpadding="4" cellspacing="0" border="0">
  <form enctype="multipart/form-data" action="upload2.php" method="post" id="asdf">
   <tr><td style="padding-top: 0px; font-weight: bold;" colspan="2">Email Information: (required)</td></tr>
  <tr>
    <td>List:</td>
    <td>
      <select name="list">
      <?php
      for($i=0; $i<$lists; $i++) {
        echo "<option value=\"".$list[$i][0]."\"";

        if ($listid== $list[$i][0]) {
           echo " selected";
        }

        echo ">".$list[$i][1]."</option>\n";
      }
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td>Subject:</td>
    <td>
      <input type="text" name="subject" value="<?php echo $subject; ?>"
       size="60" /></td>
  </tr>
  <tr>
    <td>Text Version:</td>
    <td>
       <input type="file" name="userfile[0]" size="60"/></td>
  </tr>
  <tr><td>HTML Version:</td>
  <td>
    <input type="file" name="userfile[1]" size="60" /></td>
  </tr>
  <tr><td style="padding-top: 30px; font-weight: bold;" colspan="2">Images: (optional)</td></tr>
	
  <tr>
  	<td>Image(s):</td>
    <td>
	
    <input type='file' class="upload" name='images[]' size='60' />
	</td>





  <tr>
  <td></td>
  <td style="padding-top: 10px;" colspan="2">
  
  <input type="hidden" name="listid" value="<?php echo $listid; ?>">
  <input class="submit_button" type='submit' name='upload-files' value='Upload Files' />
  </td>
  </form>
  </tr>
  </table>
  </div>
<?php
}




function display_mail_form2($email, $listid=0) {
  // display html form for uploading a new message
  global $table_width;
  $list=get_all_lists();
  $lists=sizeof($list);
?>

<div id="adminenter_box">
    <p style="text-align: left; margin-left: 90px;">
        To create a new Mail:<br />
        1. Select the List to send it to<br />
        2. Choose a subject<br />
        3. Browse for the Text Version<br />
        4. Browse for the Html Version<br />
        5. Attach any images used in the Html
    </p>
</div>

<div class="content_area">
  <table id="mail_form_table" style="padding: 30px;" cellpadding="4" cellspacing="0" border="0">
  
  <form action="test.php" method="post" enctype="multipart/form-data" name="asdf" id="asdf">
   <tr><td style="padding-top: 0px; font-weight: bold;" colspan="2">Email Information: (required)</td></tr>
  <tr>
    <td>List:</td>
    <td>
      <select name="list">
      <?php
      for($i=0; $i<$lists; $i++) {
        echo "<option value=\"".$list[$i][0]."\"";

        if ($listid== $list[$i][0]) {
           echo " selected";
        }

        echo ">".$list[$i][1]."</option>\n";
      }
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td>Subject:</td>
    <td>
      <input type="text" name="subject" value="<?php echo $subject; ?>"
       size="60" /></td>
  </tr>
  <tr>
    <td>Text Version:</td>
    <td>
       <input type="file" name="userfile[0]" size="60"/></td>
  </tr>
  <tr><td>HTML Version:</td>
  <td>
    <input type="file" name="userfile[1]" size="60" /></td>
  </tr>
  <tr><td style="padding-top: 30px; font-weight: bold;" colspan="2">Images: (optional)</td></tr>
	
  <tr>
  	<td>Image(s):</td>
    <td>
	
    <input type="file" id="element_input" class="upload" name="images[]" /><br />
	</td>





  <tr>
  <td></td>
  <td style="padding-top: 10px;" colspan="2">
  
  <!--<input type="hidden" name="listid" value="<?php echo $listid; ?>">-->
  <input class="submit_button" type="submit" name="Submit" value="Submit" id="send" />
  </td>
  </form>
  </tr>
  </table>

  </div>
<?php
}









function display_list_form() {
// display html new list form
?>
   <br />

   <form action="index.php?action=store-list" method="post">
   
   
   <div id="adminenter_box">
        <p>
            You are creating a new List
        </p>
    </div>
   <div class="content_area">
       <table id="form_table">
       <tr>
       		<th>List Name:</th>
           <td><input type="name" name="name" size="20" maxlength="20"/></td>
       </tr>
       <tr>
       		<th>List Description:</th>
			<td><textarea rows="4" cols="72" name="blurb"></textarea></td>
	   </tr>
       
       <tr>
          <th></th>
          <td>
              <input class="submit_button" type="submit" name="update" value="Save List" />
          </td>
       </tr>
       </table>
   </div>
   <br />
   </form>
<?php
}



?>
