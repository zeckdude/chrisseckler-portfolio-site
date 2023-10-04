<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Multi File Upload</title>

<script src="../../js/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
						   
//This is all the code for the Multi Uploader						   
var fileMax = 3;
$('#asdf').after('<div id="files_list" style="border:1px solid black;padding:5px;background:#fff;font-size:x-small;"><strong>Files (maximum '+fileMax+'):</strong></div>');
$("input.upload").change(function(){
doIt(this, fileMax);
});

});	

function doIt(obj, fm) {
if($('input.upload').size() > fm) {alert('Max files is '+fm); obj.value='';return true;}
$(obj).hide();
$(obj).parent().prepend('<input type="file" class="upload" name="images[]" />').find("input").change(function() {doIt(this, fm)});
var v = obj.value;
if(v != '') {
$("div#files_list").append('<div>'+v+'<input type="button" class="remove" value="Delete" /></div>')
.find("input").click(function(){
$(this).parent().remove();
$(obj).remove();
return true;
});
}

};


	</script>

    

</head> 

<body>
	<h1>Multiple File Upload</h1>
	
	
<form action="test.php" method="post" enctype="multipart/form-data" name="asdf" id="asdf">
  <div id="mUpload">
	<input type="file" id="element_input" class="upload" name="images[]" /><br />
    <input type="submit" name="Submit" value="Submit" id="send" />
  </div>
</form>	
</body>
</html>
