<html>
<head>
<?php
include_once("encodage.inc.php");
?>
</head>
<body bgcolor="#FFCC99">
<?php
/* NE SERT PAS POUR LE MOMENT
include_once("functions.inc.php");
include_once("var.inc.php");
$connexion=connexion($database);

$filename = $table."_session.".$extension;
print "Ecriture du fichier <a href=$filename>$filename</a> <br/>";
$fp = fopen( $filename, "w" ) or die("Impossible d'ouvrir $filename");
fwrite_encode( $fp, "<?php\n" );
fwrite_encode( $fp,'include("session_workflow.'.$extension.'");'."\n");
fwrite_encode( $fp, "?>\n" );
fclose( $fp );
*/
?>
</body>
</html>
