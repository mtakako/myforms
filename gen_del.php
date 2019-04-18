<html>
<head>
<?php
include_once("encodage.inc.php");
?>
</head>
<body bgcolor="#FFCC99">
<?php
include_once("functions.inc.php");
include_once("var.inc.php");
$connexion=connexion($database);


$filename = $table."_del.".$extension;
print "Ecriture du fichier $filename <br>";
$fp = fopen( $filename, "w" ) or die("Impossible d'ouvrir $filename");

fwrite_encode( $fp, "<?php\n" );
fwrite_encode( $fp,'include("session.php");'."\n");
fwrite_encode( $fp,'include("'.$table.'_parametres.'.$extension.'");'."\n");
fwrite_encode( $fp,"//Inclusion de la page entete qui inclue les variables et les fonctions.\n");
fwrite_encode( $fp,'include("entete.php");'."\n");
fwrite_encode( $fp,'$connexion=connexion($bdd);'."\n");

fwrite_encode( $fp,'if (!isset($sup)){'."\n" );
fwrite_encode( $fp,'   $flag_liens_a_supprimer=0;'."\n" );

if (!empty($CIF)){
    $CIF2=explode("\r\n",$CIF);
    if (!empty($CIF2[0])){
        for ($z=0;$z<count($CIF2);$z++){
            list($val,$col)=explode(".",$CIF2[$z]);
            fwrite_encode( $fp,'   $req='."\"select * from $val where $col=".'$id_sup'."\";\n" );
            fwrite_encode( $fp,'   $resultat_sql=execute_sql($req);'."\n" );
            //test de l'existance de liens
            fwrite_encode( $fp,'   if (mysqli_num_rows($resultat_sql)>0){'."\n" );
            fwrite_encode( $fp,'      echo "<br /> $message_sup_nan '.$val.'.<br /><b>Il existe des enregistrements li&eacute;s.<br /></b><br />\n";'."\n" );   
            fwrite_encode( $fp,'      $flag_liens_a_supprimer=1;'."\n" );
            fwrite_encode( $fp,'   }'."\n" );
            //affichage des liens existants
            fwrite_encode( $fp,'      while($row=mysqli_fetch_row($resultat_sql)){'."\n" );
            fwrite_encode( $fp,'         $req="select * from '.$val.' where ".db_field_direct_name($resultat_sql,0)."=$row[0]";'."\n" );
            fwrite_encode( $fp,'         echo lister_col2($req)."|";'."\n" );
            fwrite_encode( $fp,'      }'."\n" );
        }
    }
}
fwrite_encode( $fp,'if (($flag_liens_a_supprimer==1)&&($sup_cascade!=1)){'."\n" );
fwrite_encode( $fp,'   echo "<br />Merci de supprimer ces enregistrements avant de continuer.<br />\n";'."\n" );
fwrite_encode( $fp,'   exit;'."\n" );
fwrite_encode( $fp,'}'."\n" );

for ($z=0;$z<5;$z++){
	if (!empty($relation[$z])){
		list($nom_table,$nom_colonne)=explode('.',$relation[$z]);
		$req="select distinct $table.* from $nom_table,$table where $nom_table.$nom_colonne=$table.$nom_id and $nom_table.$nom_colonne=".'$id_sup';
		fwrite_encode( $fp,'   $req="'.$req.'";'."\n" );
		fwrite_encode( $fp,'   $resultat_sql=execute_sql($req);'."\n" );
		//test de l'existance de liens
		fwrite_encode( $fp,'   if (mysqli_num_rows($resultat_sql)>0){'."\n" );
		fwrite_encode( $fp,'      echo "<br /> $message_sup_nan '.$nom_table.'<br />\n";'."\n" );
		fwrite_encode( $fp,'      $flag_liens_a_supprimer=1;'."\n" );
		fwrite_encode( $fp,'   }'."\n" );
	}
}
fwrite_encode( $fp,'   if ($flag_liens_a_supprimer==1){'."\n" );
fwrite_encode( $fp,'      echo "<br /><br />Les liens et ces enregistrements seront supprim&eacute;s automatiquement.<br />Voulez-vous continuer ?";'."\n" );
fwrite_encode( $fp,'      echo "<form method=post>\n";'."\n" );
fwrite_encode( $fp,'      echo "<script language=javascript>\n";'."\n" );
fwrite_encode( $fp,'      echo "   function continuer(){\n";'."\n" );
fwrite_encode( $fp,'      echo "            document.forms[0].action=\'".$_SERVER[PHP_SELF]."?id_sup=$id_sup&sup=1\';\n";'."\n" );
fwrite_encode( $fp,'      echo "            document.forms[0].submit();\n";'."\n" );
fwrite_encode( $fp,'      echo "   }\n";'."\n" );
fwrite_encode( $fp,'      echo "   function annuler(){\n";'."\n" );
fwrite_encode( $fp,'      echo "            document.forms[0].action=\''.$table.'_rech.'.$extension.'\';\n";'."\n" );
fwrite_encode( $fp,'      echo "            document.forms[0].submit();\n";'."\n" );
fwrite_encode( $fp,'      echo "   }\n";'."\n" );
fwrite_encode( $fp,'      echo "</script>\n";'."\n" );
fwrite_encode( $fp,'      echo "<input type=hidden name=url value=".$_SERVER["HTTP_REFERER"].">\n";'."\n" );
fwrite_encode( $fp,'      echo "<input type=button onclick=javascript:continuer(); value=Continuer>\n";'."\n" );
fwrite_encode( $fp,'      echo "<input type=button onclick=javascript:annuler(); value=Annuler>\n";'."\n" );
fwrite_encode( $fp,'      echo "</form>\n";'."\n" );
fwrite_encode( $fp,'      include("piedpage.php");'."\n");
fwrite_encode( $fp,'      exit;'."\n" );
fwrite_encode( $fp,'   }'."\n" );

fwrite_encode( $fp,'}'."\n" );

// MdB 03/07/03 Gestion des photos
$req="select * from $table";
$result = execute_sql($req);
$flags = db_field_direct_flags($result,0);
if (mb_stristr($flags,'auto')){
	$i = 1;
}
else{
	$i = 0;
}
$num_fields = mysqli_num_fields($result);
while ($i < $num_fields) {
	$nom  = db_field_direct_name($result, $i);
	$nom_id  = db_field_direct_name($result, 0);
	//MdB gestion de l'insertion de la photo
	if (isset($photos)&&in_array($i,$photos)){
		fwrite_encode( $fp,'//gestion des suppressions des photos'."\n");   
		fwrite_encode( $fp,'$req='."\"select * from $table where $nom_id=".'$id_sup'."\";\n" );
		fwrite_encode( $fp,'$resultat_sql=execute_sql($req);'."\n" );
		fwrite_encode( $fp,'$row_sup=mysqli_fetch_row($resultat_sql);'."\n" );
		fwrite_encode( $fp,'$nom_fichier=$row_sup['.$i.'];'."\n" );
		fwrite_encode( $fp,'$nomDestination=$rep."/'.$table.'-".$id_sup.\'-\'.\''.$nom.'\'."-".$nom_fichier;'."\n");
		fwrite_encode( $fp,'@unlink($nomDestination);'."\n");  
	}
	if (isset($fichiers)&&in_array($i,$fichiers)){
		fwrite_encode( $fp,'//gestion des suppressions des fichiers'."\n");   
		fwrite_encode( $fp,'$req='."\"select * from $table where $nom_id=".'$id_sup'."\";\n" );
		fwrite_encode( $fp,'$resultat_sql=execute_sql($req);'."\n" );
		fwrite_encode( $fp,'$row_sup=mysqli_fetch_row($resultat_sql);'."\n" );
		fwrite_encode( $fp,'$nom_fichier=$row_sup['.$i.'];'."\n" );
		fwrite_encode( $fp,'$nomDestination=$rep."/'.$table.'-".$id_sup.\'-\'.\''.$nom.'\'."-".$nom_fichier;'."\n");
		fwrite_encode( $fp,'@unlink($nomDestination);'."\n");  
	}
	$i++;
}


if (!empty($CIF)){
	$CIF2=explode("\r\n",$CIF);
	if (!empty($CIF2[0])){
		for ($z=0;$z<count($CIF2);$z++){
			list($val,$col)=explode(".",$CIF2[$z]);
			fwrite_encode( $fp,'$req='."\"delete from $val where $col=".'$id_sup'."\";\n" );
			fwrite_encode( $fp,'$resultat_sql=execute_sql($req);'."\n" );
		}
	}
}

for ($z=0;$z<5;$z++){
	if (!empty($relation[$z])){
		list($nom_table,$nom_colonne)=explode('.',$relation[$z]);
		$req="delete from $nom_table where $nom_colonne=".'$id_sup';
		fwrite_encode( $fp,'$req="'.$req.'";'."\n" );
		fwrite_encode( $fp,'execute_sql($req);'."\n" );
	}

}

$req="select * from $table";
$result = execute_sql($req);
$flags = db_field_direct_flags($result,0);
$maclause="";
$f=0;
if (!mb_stristr($flags,'auto')){
	// gestion du passage des parametres pour la maj et la vue pour les relations a 3 pattes
	while ($f < $fields) {
		$type  = db_field_direct_type($result, $f);
		if (db_type($type,$flags)=='int'){
			$macolonne=db_field_direct_name($result, $f);
			if (empty($maclause))
				$maclause=$macolonne.'=$'.$macolonne;
			else
				$maclause=$maclause.' and '.$macolonne.'=$'.$macolonne;
		}
		$f++;
	}
	fwrite_encode( $fp,'$req='."\"delete from $table where $maclause\";\n" );
}
else{
	$maclause="$nom_id=".'$id_sup';
	fwrite_encode( $fp,'$req='."\"delete from $table where $maclause\";\n" );
}

fwrite_encode( $fp,'execute_sql($req);'."\n" );




fwrite_encode( $fp,'echo "<br /><H2>$del_OK</H2><br />\n";'."\n" );
fwrite_encode( $fp,'if (!isset($url))'."\n" );
fwrite_encode( $fp,'   $url=$_SERVER["HTTP_REFERER"];'."\n" );
fwrite_encode( $fp,'echo "<form action=$url method=post>\n";'."\n" );
fwrite_encode( $fp,'echo "<script language=javascript>\n";'."\n" );
fwrite_encode( $fp,'echo "   function valider(){\n";'."\n" );
fwrite_encode( $fp,'echo "            document.forms[0].submit();\n";'."\n" );
fwrite_encode( $fp,'echo "   }\n";'."\n" );
fwrite_encode( $fp,'echo "   var tmr = setTimeout(\'valider()\',1000);\n";'."\n" );
fwrite_encode( $fp,'echo "</script>\n";'."\n" );
fwrite_encode( $fp,'echo "<input type=hidden name=pour_netscape>\n";'."\n" );
fwrite_encode( $fp,'echo "</form>\n";'."\n" );
fwrite_encode( $fp,'include("piedpage.php");'."\n");
fwrite_encode( $fp,'?>'."\n");

fclose( $fp );
?>
</body>
</html>