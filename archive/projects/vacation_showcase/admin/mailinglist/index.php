<?php
ob_start();
//session_start();
	include("../../includes/connection.php");
	
	/*if(!isset($_SESSION['authenticated_vs'])){
	header('Location: ' . $site_basedir . 'login.php');
	}*/
	
	$conn = dbConnect('query');
	
//This is the code for the mailing list
/**************************************************************************************************************************
*  Section 1 : Setting Different Variables
**************************************************************************************************************************/
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);

  include ('includes/include_fns.php');
  session_start();

  $admin_email = 'admin@localhost'; //This needs to be changed later once I integrate this code with the other login form and they enter their email there. Then this will be their email address
  $action = $_GET['action'];
  $buttons = array();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php include('../../includes/titleline.php'); ?></title>
<link rel="stylesheet" href="../../css/style.css" type="text/css" media="screen" />
<link rel="shortcut icon" href="../../images/favicon.png" />
<script src="../../js/jquery.js" type="text/javascript" language="javascript"></script>
<script src="../../js/jquery.MultiFile.js" type="text/javascript" language="javascript"></script>

<script src="../../js/jquery.blockUI.js" type="text/javascript" language="javascript"></script>
<script src="../../js/jquery.form.js" type="text/javascript" language="javascript"></script>
<script src="../../js/jquery.MetaData.js" type="text/javascript" language="javascript"></script>

<script type="text/javascript" language="javascript">
/*$(function(){ 
$('#multi_upload').MultiFile({ 
accept:'gif|jpg|png', max:10, STRING: { 
remove:'Remover', 
selected:'Selecionado: $file', 
denied:'Invalido arquivo de tipo $ext!', 
duplicate:'Arquivo ja selecionado:\n$file!' 
} 
}); 
});*/

$(function(){ // wait for document to load 
 $('#multi_upload').MultiFile({ 
  STRING: {
   file: '<em title="Click to remove" onclick="$(this).parent().prev().click()">$file</em>',
   remove: '<img src="/@/bin.gif" height="16" width="16" alt="x"/>'
  }
 }); 
});
</script>


<!--[if IE]>
<link href="css/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->







</head>

<body>      
    <!--PERMANENT FOR NOW UNTIL I CREATE DYNAMIC CSS-->
    <div id="header"></div>
    
     <div id="bottomleft_shadow">
     <div id="bottomright_shadow">
     <div id="left_shadow">
     <div id="right_shadow">
     <div id="bottom_shadow">
     <div id="container">
    
        <!--PERMANENT-->
        <a href="../../index.php"><div id="title"> 
            <h2>Peninsula Travel Experts'</h2>
            <h1>VACATION SHOWCASE</h1>
        </div></a>
        
        <div class="back"><a href="../admincontrols.php">Admin Controls</a></div>
        <div class="logout"><a href="<?php echo $site_basedir; ?>includes/logout.php">Logout</a></div>
        <!--EDITABLE-->
        <div id="adminenter_box">
        	<p>
        		Mailing List Manager
        	</p>
        </div>

        
        <div class="content_area" style="width: 520px;">
        	<div id="adminlinks">
                <a href="index.php?action=manage-subscribers">Manage Subscribers</a>
                <a href="index.php?action=manage-lists">Manage Lists</a>
                <a href="index.php?action=manage-mail">Manage Mail</a> 
            </div>  
        </div>
        
        <?php
		
		/**************************************************************************************************************************
		*  Section 3 : Runs different functions based on what is in the $_GET['action'] variable
		**************************************************************************************************************************/
		
		  switch ($action) {
		
			case '':
				subscriber_list();
			break;
			
			case 'manage-subscribers':
				echo '<div id="newagent_btn">';
						display_subscribers_toolbar();
				echo '</div>
					  <div id="adminenter_box">
						  <p>
							  Click on an existing entry to edit or delete it
						  </p>
					  </div>
					  <div class="content_area">';
						subscriber_list();
				echo '</div>';
			break;
			
			case 'manage-lists':
				echo '<div id="newagent_btn">';
						display_lists_toolbar();
				echo '</div>
					  <div id="adminenter_box">
						  <p>
							  Choose an option next to any List
						  </p>
					  </div>
					  <div class="content_area">';
						
						lists_list();
						//display_items('All Lists', get_all_lists(), 'information',
								//'show-archive','edit-list','delete-list','');
					echo '</div>';
			break;	
			
			case 'manage-mail':
				echo '<div class="content_area" style="height: 81px;">';
					display_mail_toolbar();
				echo '</div>';
			break;	
		
			case 'show-all-lists':
			 echo '<div id="newagent_btn">';
						display_lists_toolbar();
				echo '</div>
					  <div id="adminenter_box">
						  <p>
							  Choose an option next to any List
						  </p>
					  </div>
					  <div class="content_area">';
						
						lists_list();
						//display_items('All Lists', get_all_lists(), 'information',
								//'show-archive','edit-list','delete-list','');
				echo '</div>';
			break;
		
			case 'show-archive':
				echo '<div id="adminenter_box">
						  <p>
							  Archive for ' . get_list_name($_GET['id']) . 
						'</p>
					  </div>';
					  
				
			  display_archive_mail(get_archive($_GET['id']), 'view-html',
							'view-text', '');
			break;
		
			case 'information':
			  display_information($_GET['id']);
			break;
			
			case 'delete-list':
			  delete_list($_GET['id']);
			break;
			
			case 'edit-list':
			  edit_list($_GET['id']);
			break;
			
			case 'delete-mail':
			  delete_mail($_GET['id']);
			break;
		
			default:
			  subscriber_list();
			break;
			  
			case 'subscriber-list':
				echo '<div id="newagent_btn">';
						display_subscribers_toolbar();
				echo '</div>
					  <div id="adminenter_box">
						  <p>
							  Click on an existing entry to edit or delete it
						  </p>
					  </div>
					  <div class="content_area">';
						subscriber_list();
				echo '</div>';
			break;
			
			case 'edit-subscriber':
			  edit_subscriber();
			break;
			
			case 'new-subscriber':
			  new_subscriber();
			break;
			
			case 'delete-subscriber':
			  delete_subscriber();
			break;
		
			case 'create-mail':
			  display_mail_form($admin_email);
			break;
		
			case 'create-list':
			  display_list_form();
			break;
		
			case 'store-list':
			  if(store_list($_POST)) {
				echo '<div id="adminenter_box"><p>New list added.</p></div>
				<div class="content_area">';
				
				lists_list();
				//display_items('All Lists', get_all_lists(), 'information',
							  //'show-archive','edit-list','delete-list','');
				echo '</div>';
			  } //else {
				//echo "<p style=\"padding-bottom: 50px\">List could not be
					   //stored. Please try again.</p>";
			  //}
			break;
		
			case 'send':
				echo '<div class="content_area">';
				  send($_GET['id'], $admin_email);
				echo '</div>';
			break;
		
			case 'view-mail':
			
			  //display_items2(get_archive($_GET['id']), 'view-html',
							//'view-text', '');
			
			  display_unsent_mail(get_unsent_mail($admin_email),
							'preview-html', 'preview-text', 'delete-mail', 'send');
			break;
		  }
		
		
		
		
		?>
        
        
        
        <?php include('../../includes/companyline.php'); ?>
        
        
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    
</body>
</html>
