<html>
<head>
<?php
include_once("var.inc.php");
include_once("encodage.inc.php");
?>
</head>
<?php
include_once("functions.inc.php");
include_once ("stylef.php");
?>

<body bgcolor="#FFCC99">
<?php
$filename = "menu.".$extension;
print "Ecriture dans le fichier $filename<br>";
$fp = fopen( $filename, "w" ) or die("Impossible d'ouvrir $filename");
$tables=$_POST['tables'];
$mon_menu="";
for($i=0;$i<count($tables);$i++){
   $mon_menu.="<A HREF=$tables[$i]_rech.php>[".ucfirst(mb_strtolower($tables[$i]))."]</A>&nbsp;";
}

fwrite_encode($fp,"$mon_menu");
fclose( $fp );

$filename = "menu2.".$extension;
print "Ecriture dans le fichier $filename<br>";
$fp = fopen( $filename, "w" ) or die("Impossible d'ouvrir $filename");

include_once("functions.inc.php");
$mon_menu="";
for($i=0;$i<count($tables);$i++){
   $mon_menu.="<A HREF=$tables[$i]_rech.php>[".ucfirst(mb_strtolower($tables[$i]))."]</A><br>";
}

fwrite_encode( $fp,"$mon_menu");
fclose( $fp );
?>

</body>
</htm>