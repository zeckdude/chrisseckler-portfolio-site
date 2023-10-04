<div id="header">
    <a href="index.php"><h1>Tack Sharp! - Silent Photography Auction</h1></a>
    
    <div id="navigation_bar">
        <ul id="nav">
            <li id="home_btn"><a href="<?php echo $site_basedir .'index.php';?>">Home</a></li>
            <li id="photos_btn"><a href="<?php echo $site_basedir .'photos_list.php';?>">Photos</a></li>
            <li id="contact_btn"><a href="<?php echo $site_basedir .'contact.php';?>">Contact</a></li>
            <div id="spacer_btn"></div> 
        </ul>
         
        <div id="sub_nav">
            <?php if(isset($_SESSION['authenticated_pa'])){ ?>
                <ul id="sub_nav_logout">
                    <li id="logout_btn"><a href="<?php echo $site_basedir .'includes/logout.php';?>">Logout</a></li>
                    <li id="register_btn"><a href="<?php echo $site_basedir .'registration.php';?>">Register</a></li>
                </ul>
            <?php } else {?>
                <ul id="sub_nav_login">
                    <li id="login_btn"><a href="<?php echo $site_basedir .'login.php';?>">Login</a></li>
                    <li id="register_btn"><a href="<?php echo $site_basedir .'registration.php';?>">Register</a></li>
                </ul>
            <?php }?>
         </div>
     </div>   
    
    
</div>