<?php
include_once("var.inc.php");
include_once("functions.inc.php");
include("encodage.inc.php");
include("stylef.php");
?>
<HTML>
<BODY >
<H2>Modifier les parametres de votre site web</H2>
<SCRIPT LANGUAGE="javascript" SRC="scripts.js"></SCRIPT>
<FORM NAME=formulaire ACTION=var_write.php METHOD=POST>
<?php
$fichier="var.inc.php";


if (!$fp = fopen($fichier,"r")) {
   echo "Echec de l'ouverture de $fichier";
   exit;
}
else {
   echo "<TABLE BORDER=0>\n";
   $i=-1;
   while (!feof($fp)) { //on parcoure toutes les lignes
      $i++; //numero de la ligne dans le fichier
      $ligne = fgets($fp, 4096); // lecture du contenu de la ligne
      $ligne=trim ($ligne); //retire les blancs en début et fin de ligne

      if (mb_stristr($ligne,"$")){

         $tab = explode("=", $ligne);
         $tab[0]=mb_substr($tab[0],1,mb_strlen($tab[0]));
         $nom_var = mb_substr($tab[0],0,mb_strlen($tab[0]));
         $tab[1]=mb_substr($tab[1],0,mb_strlen($tab[1])-1);
         $tab[1]=mb_ereg_replace( "\"", "", $tab[1] );

         echo "<TR><TD>$nom_var :</TD><TD><INPUT TYPE=TEXT SIZE=40 NAME=var[$i] VALUE=\"".$tab[1]."\"></TD></TR>\n";
         if (mb_stristr($ligne,"couleur"))
            echo "<TR><TD>&nbsp</TD><TD><A HREF=javascript:OuvrirFen('palette.php?retour=var[$i]',600,420)>Utiliser la pallete</A></TD></TR>\n";

      }
      elseif (mb_stristr($ligne,"define")){

         $tab = explode("\"", $ligne);
         echo "<TR><TD>$tab[1] :</TD><TD><INPUT TYPE=TEXT SIZE=40 NAME=var[$i] VALUE=\"$tab[3]\"></TD></TR>\n";

      }
      elseif (mb_stristr($ligne,"include")){

         $tab = explode("\"", $ligne);
         echo "<TR><TD>Fichier inclus</TD><TD><INPUT TYPE=TEXT SIZE=40 NAME=var[$i] VALUE=\"$tab[1]\"></TD></TR>\n";

      }
      elseif ((!mb_stristr($ligne,"<?")) && (!mb_stristr($ligne,"?>")) && (!empty($ligne))){
         $ligne=mb_ereg_replace( "//", "", $ligne );
         echo "<TR><TD colspan=2>".$ligne."</TD></TR>\n";
      }
   }
   fclose($fp);
   echo "<TR><TD colspan=2><DIV ALIGN=center><INPUT TYPE=submit VALUE=\"Enregistrer les modifications\"></DIV></TD></TR>\n";
   echo "</TABLE>\n";

}
?>

</FORM>
</BODY>
</HTML>
