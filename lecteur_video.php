<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>lecteur-flv</title>
</head>
<body bgcolor="#ffffff">
<?php
if (isset($video)){
   if (mb_strstr($video, '.flv')){
?>
	<object 
		classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
		codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" 
		width="200" height="200" id="lecteur-flv" align="middle">
		<param name="movie" value="lecteur-flv.swf?video=<?php echo "$video";?>" />
		<param name="bgcolor" value="#ffffff" />
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="quality" value="high" />
			<embed 
				src="lecteur-flv.swf?video=<?php echo "$video";?>" width="200" height="200" 
				quality="high" bgcolor="#ffffff" 
				name="lecteur-flv" align="middle" allowScriptAccess="sameDomain" 
				type="application/x-shockwave-flash" 
				pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
<?php
   }
   else{
?>

<embed src=<?php echo "$video";?> width=200 height=200 controller="true">

<?php
   }
}    
?>	
</body>
</html>
