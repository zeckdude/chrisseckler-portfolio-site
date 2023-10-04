<?php

session_start();

ob_start();

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>

<title>Applied Materials Order Form - FAQ</title>

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

     

</script>

</head>











<body>





<div id="container">





<?php include("includes/header.php"); ?>

  

	

    <div class="form_container" id="faq_box">  

        <div class="row">

            <div class="clientform_table_header">Frequently Asked Questions</div>   

        </div>

        

        <div class="row">

            <div class="content">

                <p>

                	<span class="faq_question">Why is the form not working?</span>

                    <br />

                    <span class="faq_answer">You need to fill all minimum required fields in order for the form to be sent to PRO PRINT.</span>

                </p>

			</div>

        </div>       

         

		<div class="row">

            <div class="content">

                <p>

                	<span class="faq_question">Why is my building number not listed in the 'Delivery Bldg #' field' ?  </span>

                    <br />

                    <span class="faq_answer">If you are located in Silicon Valley, orders are delivered to your lobby. Orders from other areas are shipped via FedEx to your physical address. </span>

                </p>

			</div>

        </div> 

        

        <div class="row">

            <div class="content">

                <p>

                	<span class="faq_question">What if I’m unsure of the delivery date?  </span>

                    <br />

                    <span class="faq_answer">If no delivery date is checked, we always assume a standard 10 -business day turn-around to be sufficient. If you need your cards sooner, check either the 50% or 100% box. In addition, we ask that you give us an actual date in the “RUSH needed by” field.</span>

                </p>

			</div>

        </div> 

        

        <div class="row">

            <div class="content">

                <p>

                	<span class="faq_question">Do I need to send multiple orders if I want more than one language for the same person?  </span>

                    <br />

                    <span class="faq_answer">One order may contain an English Only card, a foreign language card, and notepads. If you want to order multiple languages, please submit separate orders for each language. After you place your first order, and re-visit the order form, just enter the employee id and it will fill out the form based on your last order.</span>

                </p>

			</div>

        </div> 

        

        <div class="row">

            <div class="content">

                <p>

                	<span class="faq_question">I have a translation from a previous order. How do I get it to you?  </span>

                    <br />

                    <span class="faq_answer">After confirming the proof of your card, you will be prompted to either upload an image of your previous card, or you may type your characters. Unless you supply them to us, we assume that the characters are not known to you, and the name will be literally translated (not recommended).</span>

                </p>

			</div>

        </div> 

        

        <div class="row">

            <div class="content">

                <p>

                	<span class="faq_question">I don’t see my address in the drop-down menu. What do I do?  </span>

                    <br />

                    <span class="faq_answer">Addresses in the drop-down menu are the ones we most commonly see ordered. If your company address is not mentioned, please fill it in completely under “Other Address” right after the Mail Stop field.</span>

                </p>

			</div>

        </div> 

        

        <div class="row">

            <div class="content">

                <p>

                	<span class="faq_question">How do I order Notepads?  </span>

                    <br />

                    <span class="faq_answer">If you desire notepads, please fill in the top section (first 8 fields) of the form completely; then skip down to "I want my card/pad to read"; fill-in name as desired on notepad only (no titles, degrees, etc.); then skip down again and check which size you prefer. If you are not located in St. Clara, we will also need your address (under "other address") and mailstop filled in (last line on the form before notepad sizes). Notepads are always produced in quantities of 10 pads per order. </span>

                </p>

			</div>

        </div> 

        

    </div> 

    

    

    	 

</div>



</body>



</html>