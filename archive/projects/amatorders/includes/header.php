
<?php 
//include("http://www.idea-palette.com/amatorders_basic/includes/connection.php"); ?>

<div id="header">
    <a id="header_link" href="<?php echo $site_basedir . 'administrative_details.php'; ?>"><h1>Applied Materials Business Card Order Center</h1></a>
        <div id="nav">
            <a class="button" href="<?php echo $site_basedir . 'administrative_details.php'; ?>">Order Form</a>
            <a class="button" href="<?php echo $site_basedir . 'faq.php'; ?>">Frequently Asked Questions</a>
        </div>  
</div>


<?php
function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

$curr_page_name = curPageName();
if($curr_page_name == 'index.php' || $curr_page_name == 'administrative_details.php') {
?>
    <p class="instructions">Welcome to the Business Card Order Center brought to you by <a href="<?php echo $pro_print_url; ?>">Pro Print & Services</a>. 
        <br />Click the Next Step or Prev Step button and push the Submit Button when you are finished. <br />
        <br /> For questions, please refer to the <a href="faq.php">Frequently Asked Questions</a>. <br />
        <br /> Thank you and please call Pro Print at (650) 670-2405 or email <a href="mailto:support@amatorders.com?Subject=Customer%20Support%20Inquiry">support@amatorders.com</a> for any additional assistance.
    </p>
    
    <p class="instructions" style="text-align: center; display: none;">
    Thank you for visiting our site to order your business cards.<br /><br />

After 27 years of providing services to you - our valued internal customer - we are very sorry to report that
Applied Materials has made a decision to consolidate resources.<br /><br />
As a consequence, we will unfortunately not be able to fulfill your orders in the future.<br /><br />

We thank you for your past business and trust in us!<br />
Please call/email if there are any questions we can answer:<br />
<a href="tel:6506702405">650-670-2405</a><br />
<a href="mailto:support@amatorders.com">support@amatorders.com</a> 

    </p>
<?php
} ?>

