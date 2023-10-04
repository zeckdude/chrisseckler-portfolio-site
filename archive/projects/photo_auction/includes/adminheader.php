<div id="header">
    <a href="../index.php"><h1>Tack Sharp! - Silent Photography Auction</h1></a>
    
    <div style="position: relative; left: 10px;" id="navigation_bar">
        <ul id="nav">
            <li id="home_btn"><a href="../index.php">Home</a></li>
            <li id="photos_btn"><a href="../photos_list.php">Photos</a></li>
            <li id="contact_btn"><a href="../contact.php">Contact</a></li>
            <div id="spacer_btn"></div> 
        </ul>
         
        <div id="sub_nav_admin">
            <?php if(isset($_SESSION['authenticated_pa_admin'])){ ?>
                <ul id="sub_nav_admin_logout">
                    <li id="admin_logout_btn"><a href="../includes/logout.php">Admin Logout</a></li>
                </ul>
            <?php } else {?>
                <ul id="sub_nav_admin_login">
                    <li id="admin_login_btn"><a href="admin_login.php">Admin Login</a></li>
                </ul>
            <?php }?>
         </div>
     </div> 
     
     <div style="position: relative; left: 15px;" id="admin_nav">
     	<li id="list_btn"><a href="admin_list.php">View/Update Entries</a></li>
     	<li id="add_btn"><a href="admin_photo_new.php">+ Add a new Entry</a></li>
        <li id="manage_cat_btn"><a href="manage_cat.php">Manage Categories</a></li>
     </div>  
    
    
</div>