<html>
<head>
<?php
include_once("var.inc.php");
include_once("functions.inc.php");
include_once("encodage.inc.php");
include("stylef.php");
?>
</head>
<body>
<?php
//$connexion=connexion($bdd);
extract($_GET, EXTR_SKIP);
extract($_POST, EXTR_SKIP);
?>
<h2>Modifier les parametres de votre site web</h2>
<form name=formulaire>
<?php
$fichier="var.inc.php";

if (is_file($fichier)) {
	if (!($TabFich = file($fichier))){
		echo "Le fichier ne peut être lu...<br>";
		exit;
	}
}
else {
	echo "Le fichier n'est pas valide<br>";
	exit;
}


// ouverture en ecriture
if (!$fp = fopen($fichier,"w")) {
	echo "Echec de l'ouverture de $fichier";
	exit;
}
fwrite_encode( $fp,'<?php'."\n");
// Parcours des lignes du fichier pour analyse et mise a jour
for($i = 0; $i <= count($TabFich); $i++){
		$ligne=$TabFich[$i];
		$ligne=trim($ligne); //retire les blancs en debut et fin de ligne
		$var[$i]=stripslashes($var[$i]);
		if (mb_stristr($ligne,"$")){
			$tab = explode("=", $ligne);
			$tab[0]=mb_substr($tab[0],1,mb_strlen($tab[0]));
			$nom_var = mb_substr($tab[0],0,mb_strlen($tab[0]));
			fwrite_encode( $fp,'$'.$nom_var.'="'.$var[$i].'";'."\n");
		}
		elseif (mb_stristr($ligne,"define")){
			$tab = explode("\"", $ligne);
			fwrite_encode( $fp,'define ("'.$tab[1].'", "'.$var[$i].'");'."\n");
		}
		elseif (mb_stristr($ligne,"include")){
			$tab = explode("\"", $ligne);
			fwrite_encode( $fp,'@include_once("'.$var[$i].'");'."\n");
		}
		elseif ((!mb_stristr($ligne,"<?php")) && (!mb_stristr($ligne,"?>")) && (!empty($ligne)))
			fwrite_encode( $fp,$ligne."\n");
}
fwrite_encode( $fp,'?>'."\n");
fclose($fp);

echo "<br><b>Modifications enregistrees !</b>";
?>
<br/><br/>
<a href="var_read.php">Revoir les parametres</a>
<br/><br/>
<a href="db.php">Retour au menu</a>
</form>
</body>
</html>
