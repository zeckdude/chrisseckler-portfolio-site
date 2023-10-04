<?php


include("includes/connection.php");
$conn = dbConnect("admin"); 



if(isset($_GET['getClientId'])){ //find their last order and enters that information into the form
	
	$sql = "SELECT *
			FROM orders where employee_id='".$_GET['getClientId']."'
			ORDER by order_id DESC";
			
	$result = $conn->query($sql) or die(mysqli_error());
  
	if($row = $result->fetch_assoc()){
		//Administrative Details Area
		echo "formObj.cost_center.value = '".$row["cost_center"]."';\n"; 
		echo "formObj.delivery_bldg.value = '".$row["delivery_bldg"]."';\n"; 
		echo "formObj.approved_by.value = '".$row["approved_by"]."';\n"; 
		echo "formObj.delivery_email.value = '".$row["delivery_email"]."';\n"; 
		echo "formObj.ext.value = '".$row["ext"]."';\n"; 
		
		//Card Details Area
		/*echo "formObj.full_name.value = '".$row["full_name"]."';\n";
		echo "formObj.title.value = '".$row["full_name"]."';\n";
		echo "formObj.title_2.value = '".$row["title_2"]."';\n"; 
		echo "formObj.dept_div.value = '".$row["dept_div"]."';\n";
		echo "formObj.dept_div_2.value = '".$row["dept_div_2"]."';\n"; 
		echo "formObj.phone_prefix.value = '".$row["phone_prefix"]."';\n"; 
		echo "formObj.phone_first.value = '".$row["phone_first"]."';\n";
		echo "formObj.phone_last.value = '".$row["phone_last"]."';\n";
		echo "formObj.fax_prefix.value = '".$row["fax_prefix"]."';\n"; 
		echo "formObj.fax_first.value = '".$row["fax_first"]."';\n";
		echo "formObj.fax_last.value = '".$row["fax_last"]."';\n";
		echo "formObj.email.value = '".$row["email"]."';\n";
		echo "formObj.address.value = '".$row["building_id"]."';\n";
		echo "formObj.mail_stop.value = '".$row["mail_stop"]."';\n";*/
		
		
		
	  
	}else{
		echo "formObj.cost_center.value = '';\n";    
		echo "formObj.delivery_bldg.value = '';\n";    
		echo "formObj.approved_by.value = '';\n";
		echo "formObj.delivery_email.value = '';\n";    
		echo "formObj.ext.value = '';\n";    
		
		/*echo "formObj.full_name.value = '';\n";
		echo "formObj.title.value = '';\n";    
		echo "formObj.title_2.value = '';\n";    
		echo "formObj.dept_div.value = '';\n";    
		echo "formObj.phone_prefix.value = '';\n";    
		echo "formObj.phone_first.value = '';\n";
		echo "formObj.phone_last.value = '';\n";    
		echo "formObj.fax_prefix.value = '';\n";    
		echo "formObj.fax_first.value = '';\n";
		echo "formObj.fax_last.value = '';\n";        
		echo "formObj.email.value = '';\n";
		echo "formObj.address.value = '';\n";    
		echo "formObj.mail_stop.value = '';\n";*/    
	}    
}
 


if(isset($_GET['getClientId_card'])){ //find their last order and enters that information into the form
	
	$sql = "SELECT *
			FROM orders where employee_id='".$_GET['getClientId_card']."'
			ORDER by order_id DESC";
			
	$result = $conn->query($sql) or die(mysqli_error());
  
	if($row = $result->fetch_assoc()){
		
		//Card Details Area
		echo "formObj.full_name.value = '".$row["full_name"]."';\n";
		echo "formObj.title.value = '".$row["title"]."';\n";
		echo "formObj.title_2.value = '".$row["title_2"]."';\n"; 
		echo "formObj.dept_div.value = '".$row["dept_div"]."';\n"; 
		echo "formObj.dept_div_2.value = '".$row["dept_div_2"]."';\n"; 
		echo "formObj.phone_prefix.value = '".$row["phone_prefix"]."';\n"; 
		echo "formObj.phone_first.value = '".$row["phone_first"]."';\n";
		echo "formObj.phone_last.value = '".$row["phone_last"]."';\n";
		echo "formObj.fax_prefix.value = '".$row["fax_prefix"]."';\n"; 
		echo "formObj.fax_first.value = '".$row["fax_first"]."';\n";
		echo "formObj.fax_last.value = '".$row["fax_last"]."';\n";
		echo "formObj.email.value = '".$row["email"]."';\n";
		echo "formObj.address.value = '".$row["address"]."';\n";
		echo "formObj.mail_stop.value = '".$row["mail_stop"]."';\n";
		echo "formObj.other_address.value = '".$row["other_address"]."';\n";
		
	  
	}else{
		echo "formObj.full_name.value = '';\n";
		echo "formObj.title.value = '';\n";    
		echo "formObj.title_2.value = '';\n";    
		echo "formObj.dept_div.value = '';\n";
		echo "formObj.dept_div_2.value = '';\n";    
		echo "formObj.phone_prefix.value = '';\n";    
		echo "formObj.phone_first.value = '';\n";
		echo "formObj.phone_last.value = '';\n";    
		echo "formObj.fax_prefix.value = '';\n";    
		echo "formObj.fax_first.value = '';\n";
		echo "formObj.fax_last.value = '';\n";         
		echo "formObj.email.value = '';\n";
		echo "formObj.address.value = '';\n";    
		echo "formObj.mail_stop.value = '';\n";    
		echo "formObj.other_address.value = '';\n";
	}    
}
?> 