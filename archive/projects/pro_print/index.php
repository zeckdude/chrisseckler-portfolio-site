<?php 

 	//get the file name and set to $currentPage variable
	$currentPage = pathinfo($_SERVER['SCRIPT_NAME']); //this put out just the page's name


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pro Print & Services - "Your Printing Gateway to the World"</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
<link rel="shortcut icon" href="../images/favicon.ico" />


<script>
  	$(document).ready(function(){
    
		$('#toc li').click(function(){
		  //Properties for Active Tabs
		  $(this).css({'z-index' : '999' ,'background' : 'url(images/navigation/tab-right.png) no-repeat top right'})
		  .find('a').css({'background' : 'url(images/navigation/tab-left.png) no-repeat top left' })
		  .find('.tab_color').css({'background' : 'url(images/navigation/tab-middle.png)' });
		  
		  
		  //Properties for Inactive Tabs
		  $(this).siblings().css({'z-index' : '' ,'background' : 'url(images/navigation/tab-right-inactive.png) no-repeat top right' })
		  .find('a').css({'background' : 'url(images/navigation/tab-left-inactive.png) no-repeat top left' })
		  .find('.tab_color').css({'background' : 'url(images/navigation/tab-middle-inactive.png)' });
		});
		
		var height = window.innerHeight;
		$('#browser_window').css("height", height);

		//Function that processes the Contact Form
		$("#submit").click(function(){					   				   
			$(".error").hide();
			var hasError = false;
			
			//Validating Form
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			
			var nameVal = $("#name").val();
			if(nameVal == '') {
				$("#name").after('<span id="nameErrorLine" class="error" style="position: absolute; top: 305px; left: 400px;">Enter your name.</span>');
				hasError = true;
			}
			
			var emailVal = $("#email").val();
			if(emailVal == '') {
				$("#email").after('<span id="emailErrorLine" class="error" style="position: absolute; top: 358px; left: 400px;">Enter an email address.</span>');
				hasError = true;
			} else if(!emailReg.test(emailVal)) {	
				$("#email").after('<span id="emailErrorLine" class="error" style="position: absolute; top: 358px; left: 400px;">Enter a valid Email.</span>');
				hasError = true;
			}
			
			var subjectVal = $("#subject").val();
			if(subjectVal == '') {
				$("#subject").after('<span id="subjectErrorLine" class="error" style="position: absolute; top: 413px; left: 400px;">Enter the subject.</span>');
				hasError = true;
			}
			
			var mainmessageVal = $("#mainmessage").val();
			if(mainmessageVal == '') {
				$("#mainmessagetitle").after('<span id="mainmessageErrorLine" class="error" style="position: relative; left: 5px;">Enter a message.</span>');
				hasError = true;
			}
			
			
			if(hasError == false) { //If there is no error then send the data to sendemail.php
				$.post("includes/contact_form/sendemail.php", { name: nameVal, email: emailVal, subject: subjectVal, mainmessage: mainmessageVal },
						function(data){
							$("#sendEmail").fadeOut("slow", function() {				   
								$("#sendEmail").before('<div id="response" style="display:none;"><h1>Thank you for contacting<br /> Pro Print & Services!</h1><div id="info_sent"><p><b>You sent the following information:</b></p><p><b>Name:</b> '+nameVal+'</p><p><b>From:</b> '+emailVal+'</p><p><b>Message:</b> '+mainmessageVal+'</p></div></div>');
								$("#response").fadeIn("slow");
							}); //end fadeout function
						} //end data function
				); //end post function
			} //end if statement
			
			return false;
		});	//end click function for Contact Form
		
		//Function that processes the Quote Form
		$("#quotes_submit").click(function(){					   				   
			$(".error").hide();
			var hasError = false;
			
			//Validating Form
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			
			var nameVal = $("#quotes_name").val();
			if(nameVal == '') {
				$("#quotes_name").after('<span id="quotes_nameErrorLine" class="error" style="position: absolute; top: 366px; left: 127px;">Enter your name.</span>');
				hasError = true;
			}
			
			var emailVal = $("#quotes_email").val();
			if(emailVal == '') {
				$("#quotes_email").after('<span id="quotes_emailErrorLine" class="error" style="position: absolute; top: 430px; left: 127px;">Enter an email address.</span>');
				hasError = true;
			} else if(!emailReg.test(emailVal)) {	
				$("#quotes_email").after('<span id="quotes_emailErrorLine" class="error" style="position: absolute; top: 430px; left: 127px;">Enter a valid Email.</span>');
				hasError = true;
			}
			
			var jobtypeVal = $("#quotes_jobtype").val();
			if(jobtypeVal == '') {
				$("#quotes_jobtype").after('<span id="quotes_jobtypeErrorLine" class="error" style="position: absolute; top: 496px; left: 127px;">Enter what you want printed.</span>');
				hasError = true;
			}
			
			var turnaroundVal = $("#quotes_turnaround").val();
			if(turnaroundVal == '') {
				$("#quotes_turnaround").after('<span id="quotes_turnaroundErrorLine" class="error" style="position: absolute; top: 562px; left: 127px;">Enter what date you need this order.</span>');
				hasError = true;
			}
			
			var quantityVal = $("#quotes_quantity").val();
			if(quantityVal == '') {
				$("#quotes_quantity").after('<span id="quotes_quantityErrorLine" class="error" style="position: absolute; top: 350px; left: 345px;">Enter how much you need.</span>');
				hasError = true;
			}
			
			var mainmessageVal = $("#quotes_mainmessage").val();
			
			
			if(hasError == false) { //If there is no error then send the data to sendemail.php
				$.post("includes/contact_form/sendemail_quote.php", { quotes_name: nameVal, quotes_email: emailVal, quotes_jobtype: jobtypeVal, quotes_turnaround: turnaroundVal, quotes_quantity: quantityVal, quotes_mainmessage: mainmessageVal,  },
						function(data){
							$("#quote_form").fadeOut("slow", function() {				   
								$("#quote_form").before('<div id="quotes_response" style="display:none;"><h1>Thank you for submitting a quote request.</h1><div id="info_sent"><p><b>You sent the following information:</b></p><p><b>Name:</b> '+nameVal+'</p><p><b>From:</b> '+emailVal+'</p><p><b>Job Type:</b> '+jobtypeVal+'</p><p><b>Turnaround:</b> '+turnaroundVal+'</p><p><b>Quantity:</b> '+quantityVal+'</p><p><b>Message:</b> '+mainmessageVal+'</p></div></div>');
								$("#quotes_response").fadeIn("slow");
							}); //end fadeout function
						} //end data function
				); //end post function
			} //end if statement
			
			return false;
		});	//end click function for Quote Form	
	
	
	
	
	
	
		//select all the a tag with name equal to modal
		$('[name=modal]').click(function(e) {
			//Cancel the link behavior
			e.preventDefault();
			
			//Get the A tag
			var id = $(this).attr('href');
		
			//Get the screen height and width
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();
		
			//Set heigth and width to mask to fill up the whole screen
			$('#mask').css({'width':maskWidth,'height':maskHeight});
			
			//transition effect		
			$('#mask').fadeIn(500);	
			$('#mask').fadeTo("normal",0.4);	
		
			//Get the window height and width
			var winH = $(window).height();
			var winW = $(window).width();
				  
			//Set the popup window to center
			$(id).css('top',  (winH/2-$(id).height()/2)-50);
			$(id).css('left', winW/2-$(id).width()/2);
		
			//transition effect
			$(id).fadeIn(500); 
		
		});
		
		//if close button is clicked
		$('.window .close').click(function (e) {
			//Cancel the link behavior
			e.preventDefault();
			
			$('#mask').fadeOut(500);
			$('.window').hide();
		});		
		
		//if mask is clicked
		$('#mask').click(function () {
			$(this).hide();
			$('.window').hide();
		});
	
	
	
	
	}); //end document ready function
  </script>
</head>

<body>

<div id="browser_window">
    <div id="container">
    	<div id="calculator"></div>
        <div id="pen1" href="#asia_tips" name="modal"><img style="margin-top: 130px; margin-left: 100px; z-index: 22; position: relative;" src="images/tips.png" /></div>
        <div id="stapler" href="#card_size" name="modal"><img style="margin-top: 45px; margin-left: 35px; z-index: 22; position: relative;" src="images/cardsize.png" /></div>
        <div id="postit"></div>
        <div id="coffeecup"></div>
        <div id="iphone"></div>
        <div id="top-right"></div>
        <div id="bottom-right"></div>
        <div id="bottom-left"></div>
        <div id="top-left"></div>
        
        <?php include_once('includes/header.php'); ?>
        	<div class="right">
            <div class="left">
            <div class="bottom">
                
                <div class="content" id="home">
                    <h2><span>Pro Print & Services</span></h2>
                    <div class="big_text_area">
                    	<span class="text_paper">
                        	<h3>Welcome to Pro Print & Services!</h3>
                            <span class="short_area">
                                <p>PRO PRINT & services is your “One-Stop Partner” for printed materials to operate and market your business.</p>
                                <p>This can be a full range of items, incl. stationery, business cards, product sheets, forms, invitations, and more – even foreign language translation and printing. </p>
                                <p>Our 20+ years of experience in this industry have taught us the importance of listening and understanding client requirements precisely, and consequently delivering a quality product on time every time!</p>
                            </span>
                        </span>
                    </div>
                    
                    <div class="image_area"></div>
                </div>
            
            
            
                <div class="content" id="services">
                    <h2><span>Pro Print & Services</span></h2>
                    <div class="big_text_area">
                    	<span class="text_paper">
                        	<h3>Our Services</h3>
                            <span class="short_area">
                                <p>Pro Print and Services offers a wide range of Printing Services. Although we mainly deal in Business Card Printing and specialize in Multilingual Business Card Printing, we also offer other services:</p>
                                <ul>
                                    <li>Notepad Printing</li>
                                    <li>T-Shirt Printing</li>
                                    <li>Printing on large objects such as boxes</li>
                                    <li>Decals</li>
                                    <li>Calendars</li>
                                    <li>Custom orders (Just ask us and perhaps we can do it)</li>
                                </ul>
                            </span>
                        </span>
                    </div>
                    
                    <div class="image_area_services"></div>
                </div>
           
            
            
                <div class="content" id="translations">
                    <h2><span>Pro Print & Services</span></h2>
                    <div class="big_text_area">
                    	<span class="text_paper">
                        	<h3>Translations & Multilingual Business Cards</h3>
                            <span class="scroll_area">
                               
                                <p><b>We offer:</b><br />Standard or custom layouts finished like this</p>
                                <ul>
                                    <li>Front: English</li>
                                    <li>Back: Japanese, Chinese, Korean, German, French, Hebrew, Russian, etc.</li>
                                </ul>
                                
                                <p><b>You can expect:</b><br />Standard or custom layouts finished like this:</p>
                                <ul>
                                    <li>Services of native linguists for correct translation</li>
                                    <li>Foreign language typesetting</li>
                                    <li>Inclusion of your company logo</li>
                                    <li>Graphic art services for design and camera-ready layout</li>
                                </ul>
                                
                                <p>However technical or complex your project is, count on us for accurate, timely translation. In foreign language projects, as with all of our services, we strive to be your one-stop partner. Because the entire process – from translation to finished printed piece – is handled right here, we can offer a uniquely flexible service where each stage flows seamlessly into the next. This allows us to make truly last-minute changes or meet a tight deadline, and that also means accurate, on-time jobs.</p>

                            </span>
                        </span>
                    </div>
                    
                    <div class="image_area_translations"></div>
                </div>
            
            
            
                <div class="content" id="contact_us">
                    <h2><span>Pro Print & Services</span></h2>
                    <div class="wide_text_area">
                    	<div id="content">
                        	<h3 class="title">How to Contact Pro Print and Services</h3>
                            <span class="wide_area">
                                <p>We are located in Northern California in close proximity to Silicon Valley.</p>
                                <p>You can reach us at 650-670-2405 or e-mail with your questions/requests to proprint@sprynet.com</p>
                                <p>Or you can fill out the form here </p>
                                <img src="images/arrow.png" style="position: relative; left: 60px; top: 0px;" />
                            </span>
                            <span id="contact_form">
								<?php include('includes/contact_form/verify.php'); //This is included in case JS is turned off. It validates the form on the server side ?>
                                <form name="contact_form" action="" method="post" id="sendEmail">
                                    
                                    	<span class="contact_section">
                                        	<span id="nametitle" class="contact_title">Name:</span>
                                        	<input class="input_align" name="name" id="name" type="text" value="<?php echo $_POST['name']; ?>"><?php if(isset($nameError)) echo '<span class="error">'.$nameError.'</span>'; ?>
                                        </span>
                                        
                                        <span class="contact_section">
                                            <span id="emailtitle" class="contact_title">Email:</span>
                                            <input class="input_align" name="email" id="email" type="text" value="<?php echo $_POST['email']; ?>"><?php if(isset($emailError)) echo '<span class="error">'.$emailError.'</span>'; ?>
    									</span>
                                        
                                        <span class="contact_section">
                                            <span id="mainmessagetitle" class="contact_title">Message:</span>
                                            <textarea name="mainmessage" id="mainmessage"><?php echo $_POST['mainmessage']; ?></textarea><?php if(isset($mainmessageError)) echo '<span class="error">'.$mainmessageError.'</span>'; ?>									</span>
                                        
                                        
                                        <span class="contact_section">
                                            <input id="submit" type="submit" value="Send Message"> </input>
                                            <input type="hidden" name="submitted" id="submitted" value="true" />
                                    	</span>
                                </form>
                            </span> <!--end span contact form -->
                        </div> <!--end content div -->
                    </div> <!--end wide text area div -->
                </div> <!--end contact us div -->
                  
                <div class="content" id="quotes">
                    <h2><span>Pro Print & Services</span></h2>
                    <div class="wide_text_area">
                    	<div id="content" style="width: 700px;">
                        	<h3 class="title">Want a Quote?</h3>
                            <span class="quote_area">
                                <p>Please fill out the following form with all necessary information</p>
                                <p>We will get back to you within 24 hours.</p>
                            </span>
                            <span id="quote_form">
                                <form name="contact_form" action="" method="post" id="quoteform">
                                    	<div id="quotes_par1" style="float:left; width: 180px; margin-right: 40px;">
                                            <span class="contact_section">
                                                <span id="quotes_nametitle" class="quotes_contact_title" style="font-weight:bold;">Name:</span><br />
                                                <input class="quote_input_align" name="quotes_name" id="quotes_name" type="text" value="<?php echo $_POST['quotes_name']; ?>"><?php if(isset($quotes_nameError)) echo '<span class="error">'.$quotes_nameError.'</span>'; ?>
                                            </span>
                                            
                                            <span class="contact_section">
                                                <span id="quotes_emailtitle" class="quotes_contact_title"  style="font-weight:bold;">Email:</span><br />
                                                <input class="quote_input_align" name="quotes_email" id="quotes_email" type="text" value="<?php echo $_POST['quotes_email']; ?>"><?php if(isset($quotes_emailError)) echo '<span class="error">'.$quotes_emailError.'</span>'; ?>
                                            </span>
                                            
                                            <span class="contact_section">
                                                <span id="quotes_jobtypetitle" class="quotes_jobtype_title"  style="font-weight:bold;">What kind of Job is this:</span>
                                                <input class="quote_input_align" name="quotes_jobtype" id="quotes_jobtype" type="text" value="<?php echo $_POST['quotes_jobtype']; ?>"><?php if(isset($quotes_jobtypeError)) echo '<span class="error">'.$quotes_jobtypeError.'</span>'; ?>
                                            </span>
                                            
                                            <span class="contact_section">
                                                <span id="quotes_turnaroundtitle" class="quotes_turnaround_title"  style="font-weight:bold;">When to be completed:</span>
                                                <input class="quote_input_align" name="quotes_turnaround" id="quotes_turnaround" type="text" value="<?php echo $_POST['quotes_turnaround']; ?>"><?php if(isset($quotes_turnaroundError)) echo '<span class="error">'.$quotes_turnaroundError.'</span>'; ?>
                                            </span>
                                        </div>
                                        
                                        <div id="quotes_par2" style="float:left; width: 235px;">
                                            <span class="contact_section">
                                                <span id="quotes_quantitytitle" class="quotes_quantity_title"  style="font-weight:bold;">What is the quantity needed:</span>
                                                <select class="input_align" name="quotes_quantity" id="quotes_quantity">
                                                    <option></option>
                                                    <option>250</option>
                                                    <option>500</option>
                                                    <option>1000</option>
                                                </select>
                                            </span>
                                            
                                            <span class="contact_section">
                                                <span id="quotes_mainmessagetitle" class="quotes_contact_title"  style="font-weight:bold;">Any other needed information:</span>
                                                <textarea name="quotes_mainmessage" id="quotes_mainmessage"><?php echo $_POST['quotes_mainmessage']; ?></textarea><?php if(isset($quotes_mainmessageError)) echo '<span class="error">'.$quotes_mainmessageError.'</span>'; ?>									</span>
                                            
                                            
                                            <span class="contact_section">
                                                <input id="quotes_submit" type="submit" value="Request Quote"> </input>
                                                <input type="hidden" name="quotes_submitted" id="quotes_submitted" value="true" />
                                            </span>
                                        </div>
                                </form>
                            </span> <!--end span quote form -->
                        </div> <!--end content div -->
                    </div> <!--end wide text area div -->
                </div> <!--end quotes div --> 
                   
                
            
            
            
                
            
            
            
                
			</div> <!--end bottom-->
            </div> <!--end left-->
            </div>  <!--end right--> 
    </div> <!--end container-->
    
    
    <div id="boxes">
        <!-- Start of Sticky Note -->
        <div id="asia_tips" class="window">
              <div id="etiquette_area">
                  <h2>Tips for doing business in Asia</h2>
                  <img style="float: left; padding: 7px 15px 0px 0px;" src="images/yen.gif" />
                  <p><u><b>Business Etiquette in Japan</b></u></p>
                  <p>There are a number of unwritten rules in daily life in Japan, which everybody observes, but nobody talks about, and which don't exist in Europe or USA. It's your choice in a way, but you'll make more friends and definitely be more successful in business if you observe these little rules.</p>
                  <div id="rules">
                      <ul>
                        <li>Take enough ("enough" often means a couple of hundred) professionally prepared "meishi" ("meishi" = business cards). For Japanese people (as else where in Asia-Pacific) exchanging "meishi" are like shaking hands. It is very awkward not to exchange "meishi" when you first meet. So make sure you have enough. Not to have "meishi" has the meaning of being unemployed.</li>
                        <li>Impress with facts and achievements, or the fame and power and size of your corporation. Bring documentation of your company in Japanese language.</li>
                        <li>Be on time and well prepared for meetings.</li>
                        <li>There is a sophisticated protocol how seating is arranged at meetings, at dinners or in cars etc. The seating protocol depends on seniority, guest-host relationship, the position of the door, decorations in the room, etc. If you are arranging important meetings or dinners at high level, it will impress if you follow these seating customs. Most foreigners who have not worked a long time in Japan will need advice from Japanese professionals to select the correct seating order. At dinners there are also customs about filling glasses etc.</li>
                        <li>There are a number of unwritten rules in daily life in Japan, which everybody observes, but nobody talks about, and which don't exist in Europe or USA. For example: no eating and drinking and no baby's perambulators (except folded up) on short-distance commuter trains. It's your choice in a way, but you'll make more friends if you observe these little rules.</li>
                      </ul>
                  </div>
        	  </div> <!--//end etiquette area-->
          <p class="close">X</p>
        </div> <!--//end asia_tips-->
        
        
        <div id="card_size" class="window">
              <div id="card_size_area">
                  <h2>Business Card Size Specifications</h2>
                  <img src="images/template.png" style="padding-bottom: 12px; padding-left: 70px;" />
                  
                  <p>While Pro Print & Services can accept many different business card sizes to print, we usually handle business cards following the size specification as shown in the image above. When designing your business card for print, please observe the following design specification so that your printed card will appear as you had planned.</p>
                  <div id="rules-small">
                      <ul>
                        <li><b>Bleed Dimensions:</b> 3.75 x 2.25 inches <i>(This area will be cut off)</i></li>
                        <li><b>Safe Design Zone:</b> 3.25 x 1.75 inches <i>(Keep type out of this area due to cutting variances)</i></li>
                        <li><b>Finished Dimensions:</b> 3.5 x 2 inches <i>(Total size of the file to be submitted to us)</i></li>
                        
                      </ul>
                  </div>
        	  </div> <!--//end etiquette area-->
          <p class="close">X</p>
        </div> <!--//end asia_tips-->

    
        <!-- Mask to cover the whole screen -->
        <div id="mask"></div>
    </div> <!--//end boxes-->
    


</div> <!--end browser_window-->




<script src="activatables.js" type="text/javascript"></script>
<script type="text/javascript">
activatables('page', ['home', 'services', 'translations', 'contact_us', 'quotes']);
</script>




</body>
</html>
