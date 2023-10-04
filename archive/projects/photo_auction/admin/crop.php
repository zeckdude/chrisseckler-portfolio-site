<?php
	
	$folder = '../images/';
	$new_folder = '../images/thumbs/';
	$filename = $_GET['filename'];
	$orig_w = 400;
	$orig_h = $_GET['height'];
	
	$targ_w = 120;
	$targ_h = 100;
	
	$ratio = $targ_w / $targ_h;
	
	if( isset($_POST['submit']))
	{	
		$src = imagecreatefromjpeg($folder.$filename);
	
		$tmp = imagecreatetruecolor($targ_w, $targ_h);
		imagecopyresampled($tmp, $src, 0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);
		imagejpeg($tmp, $new_folder.$filename,100);
		
		imagedestroy($tmp);
		imagedestroy($src);
		
		echo "<h1>Saved Thumbnail</h1><img src=\"$new_folder/$filename\"/>";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<title>Using the JQuery JCrop Plugin, and PHP for Image Uploads</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<script type="text/javascript" src="../js/jquery.pack.js"></script>
	<script type="text/javascript" src="../js/jquery.Jcrop.pack.js"></script>
	<link rel="stylesheet" href="../css/jquery.Jcrop.css" type="text/css" />
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
    
		<h1>Jcrop Plugin Behavior</h1>
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
				<input type="submit" id="submit" name="submit" value="Crop Image!" />
			</p>
		</form>
	</body>
</html>
