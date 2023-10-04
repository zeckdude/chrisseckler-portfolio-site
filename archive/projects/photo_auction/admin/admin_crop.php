<?php 
session_start();

include("../includes/connection.php");

if(!isset($_SESSION['authenticated_pa_admin'])){
	header('Location: ' . $site_basedir . 'admin/admin_login.php');
}

//From Tutorial at: http://net.tutsplus.com/videos/screencasts/working-with-the-jcrop-plugin/
$folder = '../images/';
	$new_folder = '../images/thumbs/';
	$mini_folder = '../images/mini_thumbs/';
	$filename = $_GET['filename'];
	$orig_w = 400;
	$orig_h = $_GET['height'];
	
	$targ_w = 175;
	$targ_h = 175;
	
	$mini_targ_w = 120;
	$mini_targ_h = 120;
	
	$ratio = $targ_w / $targ_h;
	
	if( isset($_POST['submit']))
	{	
		//Creates thumbnail based on crop selection
		$src = imagecreatefromjpeg($folder.$filename);
	
		$tmp = imagecreatetruecolor($targ_w, $targ_h);
		imagecopyresampled($tmp, $src, 0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);
		imagejpeg($tmp, $new_folder.$filename,100);
		
		imagedestroy($tmp);
		imagedestroy($src);
		
		
		//Creates mini_thumbnail based on crop selection
		$src = imagecreatefromjpeg($folder.$filename);
	
		$tmp = imagecreatetruecolor($mini_targ_w, $mini_targ_h);
		imagecopyresampled($tmp, $src, 0,0,$_POST['x'],$_POST['y'],$mini_targ_w,$mini_targ_h,$_POST['w'],$_POST['h']);
		imagejpeg($tmp, $mini_folder.$filename,100);
		
		imagedestroy($tmp);
		imagedestroy($src);
		
		header('Location: ' . $site_basedir . 'admin/admin_list.php');
		//echo "<h1>Saved Thumbnail</h1><img src=\"$new_folder/$filename\"/>";
	}
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_name; ?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/jquery.Jcrop.css" type="text/css" />
<script type="text/javascript" src="../js/jquery.pack.js"></script>
<script type="text/javascript" src="../js/jquery.Jcrop.pack.js"></script>

<script type="text/javascript">
            $(function(){
                $('#cropbox').Jcrop({
                    aspectRatio: <?php echo $ratio?>,
                    setSelect: [0,0,<?php echo $orig_w.','.$orig_h;?>],
                    onSelect: updateCoords,
                    onChange: updateCoords
                });
            });
            
            function updateCoords(c)
            {
                showPreview(c);
                $("#x").val(c.x);
                $("#y").val(c.y);
                $("#w").val(c.w);
                $("#h").val(c.h);
            }
            
            function showPreview(coords)
            {
                var rx = <?php echo $targ_w;?> / coords.w;
                var ry = <?php echo $targ_h;?> / coords.h;
                
                $("#preview img").css({
                    width: Math.round(rx*<?php echo $orig_w;?>)+'px',
                    height: Math.round(ry*<?php echo $orig_h;?>)+'px',
                    marginLeft:'-'+  Math.round(rx*coords.x)+'px',
                    marginTop: '-'+ Math.round(ry*coords.y)+'px'
                });
            }
        </script>
        
		<style type="text/css">
            #preview
            {
                width: <?php echo $targ_w?>px;
                height: <?php echo $targ_h?>px;
                overflow:hidden;
            }
        </style>
<link rel="shortcut icon" href="../../images/favicon.ico" />
</head>
        
<body>
	<div id="container">
    <?php include('../includes/adminheader.php'); ?>
    
    <div id="main_content">
        <div id="highest_items">    	       
            <h2 style="margin-left: 0px;">Please crop a thumbnail for the Auction Photo</h2>
            <table>
                <tr>
                    <td>
                        <img src="<?php echo $folder.$filename?>" id="cropbox" alt="cropbox" />
                        
                    </td>
                    <td>
                        Thumb Preview:
                        <div id="preview">
                            <img src="<?php echo $folder.$filename?>" alt="thumb" />
                        </div>
                    </td>
                </tr>
            </table>
            
            <form action="<?php echo $_SERVER['REQUEST_URI']?>" method="post">
                <p>
                    <input type="hidden" id="x" name="x" />
                    <input type="hidden" id="y" name="y" />
                    <input type="hidden" id="w" name="w" />
                    <input type="hidden" id="h" name="h" />
                    <input class="crop_btn" type="submit" id="submit" name="submit" value="Crop Image!" />
                </p>
            </form>
        </div> <!--end highest items div-->
    </div> <!--end main content div-->
</div> <!--end container div-->



</body>
</html>