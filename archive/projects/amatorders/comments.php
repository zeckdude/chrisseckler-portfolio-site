<?php
session_start();
ob_start();

$_SESSION['ordering_mode'] = 'on';

//This code ensures that you have been to this page or page before it, so you can't manually type in the url without being redirected
if(!isset($_SESSION['ordering_step']) || $_SESSION['ordering_step'] < 6) {//if the ordering step has not been created or is less than the current page ordering step, because someone manually typed it in without having been to the index page
	header('Location: index.php');
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>Applied Materials Order Form - Comments</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="images/favicon.gif" />

<!--//////////  FOR USERS WITH INTERNET EXPLORER 6  //////////-->
<!--[if IE 6]>
        <link rel="stylesheet" type="text/css" href="css/ie6.css" />
<![endif]-->

<style type="text/css">
* { behavior: url(css/iepngfix.htc) }
</style> 
<!--//////////  FOR USERS WITH INTERNET EXPLORER 6  //////////-->

<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>

<script>
      $(document).ready(function(){
    	//This brings back all elements for browsers with javaScript enabled
		$(".hidden-nojs").show();
		$("#js_warning").hide();
	
	
        
    }); //end document ready
    
    
    function stopRKey(evt) { //disables enter key to submit form
      var evt = (evt) ? evt : ((event) ? event : null);
      var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
      if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
    }
    
    document.onkeypress = stopRKey; 
</script>

</head>





<body>

<?php include("includes/connection.php");

$conn = dbConnect("admin"); 
$done = false;

if(isset($_POST['comments_prev'])){ 
    
    //Comments
    $_SESSION["comments"] = $_POST['comments'];
    
    header('Location: shipping_options.php');
    
        exit;
}

if(isset($_POST['submit_order'])){ 
    
    //Comments
    $_SESSION["comments"] = $_POST['comments'];
	
	if($_SESSION['ordering_step'] == 6) { //if the ordering step is set to 6, then make it 7
		$_SESSION['ordering_step']++;	
	}
    
    header('Location: pdf/confirmation.php');
    
        exit;
}
  
  
/*  //These are the saved session variables
foreach($_SESSION as $key => $value) { //This assigns the temporary variable, $item, to each $_SESSION variable, for use in the loop
	//if($value != '') {
		echo '$_SESSION[' . $key . '] = ' . $value . '<br />';
	//}
} */

/*echo '<br /><br />';

foreach ($_SESSION['shipping'] as $counter => $shipping_array) { //This specifies the $_SESSION['order'] array to loop through 
	echo '<br />';
	echo $counter;
	echo '<br />';
	foreach ($shipping_array as $key => $value) { //This specifies the array within the $_SESSION['order'] array
		echo $key . ': ' . $value;
		echo '<br />';
	} //end foreach
	echo '<br />';
	$shipping_counter++; //This increments the shipping counter for any additional languages shipping option fields
} //end of outer foreach loop



echo '<br /><br />Foreign Characters for Name: ' . $_SESSION['foreign_characters_name'] . '<br /><br />';*/







?>




<div id="container">


<?php 
	include("includes/header.php");
	include("includes/js_warning.php");
?>

    <form id="clientForm" name="clientForm" method="post" action=""><!-- Begin Form -->
          
        <div class="form_container" id="comments">  
                <div class="row">
                	<div class="clientform_table_header">Comments<br /> <span class="warning">If you have any additional comments, please enter them below:</span></div>
                </div>   

                <div class="row">   
                      <div class="content" style="overflow:hidden;"> 
                          <span style="float:left;"><textarea name="comments"><?php echo stripslashes($_SESSION["comments"]); ?></textarea></span>
                      </div>
                </div>
                
                <div class="row">
                  <div class="content" style="overflow:hidden;"><input class="button prev submit" type="submit" name="comments_prev" value="Previous Step" /></div>
                  <div class="content" id="last_content"><input class="button next submit" type="submit" name="submit_order" value="Next Step" /></div>
                </div>  
        </div> 
          
    </form><!-- End Form --> 
</div>

</body>

</html>