<?php
include ("var.inc.php");
include ("stylef.php");
include_once("functions.inc.php");
?><body bgcolor="#FFCC99">
<h2>Modifier les parametres de votre site web</H2>
<form name="formulaire">
<?php
$table=$_POST["table"];
$var=$_POST["var"];


$fichier=$table."_parametres.php";

if (is_file($fichier)) {
   if (!($TabFich = file($fichier))){
        echo "Le fichier ne peut être lu...<br>";
        exit;
   }
}
else {
   echo "Le fichier $fichier n'est pas valide<br>";
   exit;
}


// ouverture en écriture
if (!$fp = fopen($fichier,"w")) {
   echo "Echec de l'ouverture de $fichier";
   exit;
}
fwrite_encode( $fp,'<?php'."\n");
// Parcours des lignes du fichier pour analyse et mise à jour
for($i = 0; $i <= count($TabFich); $i++){
      $ligne=$TabFich[$i];
      $ligne=trim($ligne); //retire les blancs en début et fin de ligne
      // retire les antislashs et en remet devant les "
      $var[$i]=addcslashes(stripslashes($var[$i]),'"');
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

echo "<br><b>Modifications enregistrées !</b>";
?>
<br><br>
<a href="javascript:history.go(-1)">Retour</a>
<br><br>
<a href="db.php">Retour au menu général</a>
</form>
</body>