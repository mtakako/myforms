<?php
include_once("var.inc.php");
include_once("encodage.inc.php");
include_once("functions.inc.php");
$connexion=connexion($database);

$filename = $table."_parametres.".$extension;
print "Ecriture du fichier $filename <br>";
$fp = fopen( $filename, "w" ) or die("Impossible d'ouvrir $filename");

fwrite_encode( $fp,'<?php'."\n");
fwrite_encode( $fp,'$couleur_page="'.$couleur_page.'";'."\n");
fwrite_encode( $fp,'$bdd="'.$database.'";'."\n");
fwrite_encode( $fp,'$titre="'.$table.'";'."\n");

if (isset($excel)&&($excel==1)){
	fwrite_encode( $fp,'$excel=1;'."\n");
}

fwrite_encode( $fp,'/******* Liste des noms des colonnes des Formulaires insertion, mise a jour et vues ******/'."\n");
fwrite_encode( $fp,'include_once("'.$table."_config.".$extension.'");'."\n");
$w=0;
$x=0;
if (isset($table_fille[0])){
		for ($z=0;$z<5;$z++){
			if (!empty($table_fille[$z])){
				$liste_table_fille=explode("\r\n",$table_fille[$z]);
				if (count($liste_table_fille)>1){ //relation a plus de 2 pattes
					$nom_objet="";
					while (list($cle,$val)=each($liste_table_fille)){
						list($val,$col)=explode(".",$val);
						if (empty($nom_objet))
							$nom_objet=$col;
						else
							$nom_objet=$nom_objet."_".$col;
					}
					fwrite_encode( $fp,'$ins_nan['.$w.']="'.addcslashes(stripslashes(ucfirst($nom_objet)),'"').'";'."\n");
					$w++;
				}
				if (count($liste_table_fille)==1){ //relation a plus a 2 pattes
					$nom_objet="";
					list($cle,$val)=each($liste_table_fille);
					list($val,$col)=explode(".",$val);
					fwrite_encode( $fp,'$relation_2pattes['.$x.']="'.addcslashes(stripslashes(ucfirst($col)),'"').'";'."\n");
					$x++;
				}
			}
		}
}


fwrite_encode( $fp,'/********************* Liste des libelles des criteres de recherche **************************/'."\n");
for ($i=0;$i<count($critere);$i++){
	fwrite_encode( $fp,'$criteres['.$i.']="'.addcslashes(stripslashes($label[$critere[$i]]),'"').'";'."\n");
}
fwrite_encode( $fp,'/********************* Liste des libelles des tables en relation **************************/'."\n");

$i=0;
if (!empty($CIF)){
		$CIF2=explode("\r\n",$CIF);
		if (!empty($CIF2[0])){
			for ($z=0;$z<count($CIF2);$z++){
				list($val,$col)=explode(".",$CIF2[$z]);
				$req="SELECT * FROM $val";
				$result1 = execute_sql($req);
				$nom_1an_id  = db_field_direct_name($result1, 0); //nom de la cle primaire 2
				fwrite_encode( $fp,'$label_1an['.$i.']="'.addcslashes(stripslashes(ucfirst($nom_1an_id)),'"').'";'."\n");
				$i++;
			}
		}
}

$i=0;
if (isset($table_fille[0])){
		for ($z=0;$z<5;$z++){
			if (!empty($table_fille[$z])){
				$liste_table_fille=explode("\r\n",$table_fille[$z]);
				while (list($cle,$val)=each($liste_table_fille)){
					list($val,$col)=explode(".",$val);
					fwrite_encode( $fp,'$label_nan['.$i.']="'.addcslashes(stripslashes(ucfirst($col)),'"').'";'."\n");
					$i++;
				}
			}
		}
}

fwrite_encode( $fp,'/********************* Liste des libelles du resultat du moteur **************************/'."\n");
for ($i=0;$i<count($nu);$i++){
	fwrite_encode( $fp,'$resultats['.$i.']="'.addcslashes(stripslashes($label[$nu[$i]]),'"').'";'."\n");
}

fwrite_encode( $fp,'?>'."\n");

fclose( $fp );
?>
