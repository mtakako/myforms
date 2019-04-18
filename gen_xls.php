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

//afin d'avoir toujours la liste des colonnes car la variable name est ecrase dans le pgme
$liste_des_colonnes_table=$name;

$filename = $table."_xls.".$extension;
print "Ecriture du fichier <A HREF=$filename>$filename</A> <br>";
$fp = fopen( $filename, "w" ) or die("Impossible d'ouvrir $filename");
fwrite_encode( $fp, "<?php\n" );
fwrite_encode( $fp,'include("session.php");'."\n");
fwrite_encode( $fp, 'function callback($buffer){'."\n" );
fwrite_encode( $fp, '  return @utf8_decode($buffer);'."\n" );
fwrite_encode( $fp, '}'."\n" );
fwrite_encode( $fp, 'ob_start("callback");'."\n" );
fwrite_encode( $fp, "header('Content-disposition: filename=export.xls');\n" );
fwrite_encode( $fp, "header('Content-type: application/octetstream');\n" );
fwrite_encode( $fp, "header('Pragma: no-cache');\n" );
fwrite_encode( $fp, "header('Expires: 0');\n" );
fwrite_encode( $fp,'include_once("'.$table.'_parametres.'.$extension.'");'."\n");
fwrite_encode( $fp,'include_once("var.inc.php");'."\n"); 
fwrite_encode( $fp,'include_once("functions.inc.php");'."\n");
fwrite_encode( $fp,'$connexion=connexion($bdd);'."\n");
fwrite_encode( $fp,'$PHP_SELF=$_SERVER["PHP_SELF"];'."\n");
fwrite_encode( $fp,'extract($_GET, EXTR_SKIP);'."\n");
fwrite_encode( $fp,'extract($_POST, EXTR_SKIP);'."\n");
fwrite_encode( $fp, "?>\n" );

fwrite_encode( $fp, "<?php\n" );
fwrite_encode( $fp,"//Creation dynamique de la requete SQL en fonction des criteres de recherche\n");
fwrite_encode( $fp,'$clause="";'."\n");
if (isset($critere)){
	for ($i=0;$i<count($critere);$i++){
		if (mb_stristr($type[$critere[$i]], 'int')){
				fwrite_encode( $fp,'if (!empty($'.$name[$critere[$i]].')){'."\n");
				fwrite_encode( $fp,'   $critere_tab=explode("-",$'.$name[$critere[$i]].');'."\n");
				fwrite_encode( $fp,'   if ($clause=="")'."\n");
				fwrite_encode( $fp,'      $clause = "where '.$name[$critere[$i]].'=$critere_tab[0]";'."\n");
				fwrite_encode( $fp,'   else'."\n");
				fwrite_encode( $fp,'      $clause = "$clause and '.$name[$critere[$i]].'=$critere_tab[0]";'."\n");
				fwrite_encode( $fp,'}'."\n");
			}
			else if (mb_stristr($type[$critere[$i]], 'date')){
					fwrite_encode( $fp,'if (!empty($'.$name[$critere[$i]].')){'."\n");
					fwrite_encode( $fp,'   if ($choix_'.$name[$critere[$i]].'=="inf")'."\n");
					fwrite_encode( $fp,'      $signe="<";'."\n");
					fwrite_encode( $fp,'   if ($choix_'.$name[$critere[$i]].'=="sup")'."\n");
					fwrite_encode( $fp,'      $signe=">";'."\n");
					fwrite_encode( $fp,'   if ($choix_'.$name[$critere[$i]].'=="=")'."\n");
					fwrite_encode( $fp,'      $signe="=";'."\n");
					fwrite_encode( $fp,'   if ($clause=="")'."\n");
					fwrite_encode( $fp,'      $clause = "where '.$name[$critere[$i]].' $signe \'".date_to_us($'.$name[$critere[$i]].')."\'";'."\n");
					fwrite_encode( $fp,'   else'."\n");
					fwrite_encode( $fp,'      $clause = "$clause and '.$name[$critere[$i]].' $signe \'".date_to_us($'.$name[$critere[$i]].')."\'";'."\n");
					fwrite_encode( $fp,'}'."\n");
				}
				else {
					fwrite_encode( $fp,'if (!empty($'.$name[$critere[$i]].'))'."\n");
					fwrite_encode( $fp,'   if ($clause=="")'."\n");
					fwrite_encode( $fp,'      $clause = "where '.$name[$critere[$i]].' like \'%$'.$name[$critere[$i]].'%\'";'."\n");
					fwrite_encode( $fp,'   else'."\n");
					fwrite_encode( $fp,'      $clause = "$clause and '.$name[$critere[$i]].' like \'%$'.$name[$critere[$i]].'%\'";'."\n");
					fwrite_encode( $fp,''."\n");
				}
	}
}


fwrite_encode( $fp,'$liste_tables="'.$table.'";'."\n");
if (isset($rech_1an)){
		$CIF2=explode("\r\n",$CIF);
		if (!empty($CIF2[0])){
			for ($i=0;$i<count($CIF2);$i++){
				list($tab,$col)=explode(".",$CIF2[$i]);
				$req="select * from $tab";
				$result1 = execute_sql($req);
				$nom_1an_id  = db_field_direct_name($result1, 0); //nom de la cle primaire 2
				fwrite_encode( $fp,'if (!empty($'.$nom_1an_id.')){'."\n");
				fwrite_encode( $fp,'  $verif_table=explode(",",$liste_tables);'."\n");
				fwrite_encode( $fp,'  if (!in_array("'.$tab.'", $verif_table))'."\n");
				fwrite_encode( $fp,'     $liste_tables=$liste_tables.",'.$tab.'";'."\n");
				fwrite_encode($fp,'   if ($affiche_popup==2){'."\n");
				fwrite_encode( $fp,'     $'.$nom_1an_id.'=explode("-",$'.$nom_1an_id.');'."\n");
				fwrite_encode( $fp,'     $'.$nom_1an_id.'= $'.$nom_1an_id.'[0];'."\n");
				fwrite_encode($fp,'   }'."\n");
				fwrite_encode( $fp,'   if ($clause=="")'."\n");
				fwrite_encode( $fp,'      $clause = "where '.$table.'.'.$name[0].'='.$tab.'.'.$col.' and '.$tab.'.'.$nom_1an_id.'=$'.$nom_1an_id.'";'."\n");
				fwrite_encode( $fp,'   else'."\n");
				fwrite_encode( $fp,'      $clause = "$clause and '.$table.'.'.$name[0].'='.$tab.'.'.$col.' and '.$tab.'.'.$nom_1an_id.'=$'.$nom_1an_id.'";'."\n");
				fwrite_encode( $fp,'}'."\n");
			}
		}
}
if (isset($rech_nan)){
		for ($i=0;$i<5;$i++){
			if (!empty($association[$i])){
				$liste_association=explode("\r\n",$association[$i]);
				while (list($cle,$val)=each($liste_association)){
					list($tab,$col)=explode(".",$val);
					list($table_relation,$relation_col)=explode(".",$relation[$i]);
					fwrite_encode( $fp,'if (!empty($'.$col.')){'."\n");
					fwrite_encode( $fp,'  $verif_table=explode(",",$liste_tables);'."\n");
					fwrite_encode( $fp,'  if (!in_array("'.$tab.'", $verif_table))'."\n");
					fwrite_encode( $fp,'     $liste_tables=$liste_tables.",'.$tab.'";'."\n");
					fwrite_encode($fp,'   if ($affiche_popup==2){'."\n");
					fwrite_encode( $fp,'     $'.$col.'=explode("-",$'.$col.');'."\n");
					fwrite_encode( $fp,'     $'.$col.'= $'.$col.'[0];'."\n");
					fwrite_encode($fp,'   }'."\n");
					fwrite_encode( $fp,'   if ($clause=="")'."\n");
					fwrite_encode( $fp,'      $clause = "where '.$table.'.'.$name[0].'='.$table_relation.'.'.$relation_col.' and '.$tab.'.'.$col.'=$'.$col.'";'."\n");
					fwrite_encode( $fp,'   else'."\n");
					fwrite_encode( $fp,'      $clause = "$clause and '.$table.'.'.$name[0].'='.$table_relation.'.'.$relation_col.' and '.$tab.'.'.$col.'=$'.$col.'";'."\n");
					fwrite_encode( $fp,'}'."\n");
				}
			}
		}
}

$cols="";
for ($i=0;$i<count($nu);$i++){
	$element=$nu[$i];
	if (!empty($cols))
		$cols=$cols.',';    //ajoute une virgule si il y a deja des colonnes
	$cols=$cols.$table.'.'.$name[$element];       //on met le nom de la table puis le nom de la colonne
}


//Ajout du critere de rechercher sur un id eventuel qui est passe a la page en parametre
$result = execute_sql("select * from $table");
$nom_id  = db_field_direct_name($result, 0); //nom de la cle primaire
$fields = mysqli_num_fields($result);
fwrite_encode( $fp,'if (!empty($id)){'."\n");
fwrite_encode( $fp,'   if ($clause=="")'."\n");
fwrite_encode( $fp,'      $clause = "where '.$nom_id.'=$id";'."\n");
fwrite_encode( $fp,'   else'."\n");
fwrite_encode( $fp,'      $clause = "$clause and '.$nom_id.'=$id";'."\n");
fwrite_encode( $fp,'}'."\n");

fwrite_encode( $fp,'for ($i=0;$i<count($tab_affichage);$i++){'."\n");
fwrite_encode( $fp,'   $num=$tab_affichage[$i];'."\n");
fwrite_encode( $fp,'   $liste_des_colonnes=$liste_des_colonnes.", '.$table.'.".$tab_colonnes[$num];'."\n");
fwrite_encode( $fp,'}'."\n");

fwrite_encode( $fp,'$query= "select distinct '.$table.'.'.$nom_id.' $liste_des_colonnes from $liste_tables $clause order by $criteres_tri";'."\n");

for ($i=0;$i<count($tables);$i++){
	if (!empty($tables[$i])){
		fwrite_encode( $fp,'$pk_table["'.$name[$i].'"]="'.$tables[$i].'"'.";\n");
	}

}


//eviter de tronquer le texte...
fwrite_encode( $fp,'$lg_max=10000;'."\n");
fwrite_encode( $fp,'if (!isset($pk_table))'."\n");
fwrite_encode( $fp,'   $pk_table=""'.";\n");
fwrite_encode( $fp,'echo "<table bgcolor=$couleur_fond_bas width=100% height=100%><tr valign=top><td>";'.";\n");

$flags = db_field_direct_flags($result,0);
if (!mb_stristr($flags,'auto')){
	$f=0;
	while ($f < $fields) {
		$type  = db_field_direct_type($result, $f);
		if (db_type($type,$flags)=='int'){
			fwrite_encode( $fp,'$colonnes_nan['.$f.']="'.db_field_direct_name($result, $f).'";'."\n");
		}
		$f++;
	}
}


if ((isset($navigation)&&(isset($CIF)))||(isset($navigation2))){
	$CIF2=explode("\r\n",$CIF);
	if (!empty($CIF2[0])){
		for ($i=0;$i<count($CIF2);$i++){
			fwrite_encode( $fp,'$tab_liens['.$i.']="'.$CIF2[$i].'";'."\n");
		}
		$z=count($CIF2);
	}
	else
		$z=0;

	if (isset($navigation2)){
		for ($i=0;$i<5;$i++){
			if (!empty($table_fille[$i])){
				$liste_table_fille=explode("\r\n",$table_fille[$i]);
				list($table_relation,$relation_col)=explode(".",$relation[$i]);
				while (list($cle,$val)=each($liste_table_fille)){
					list($val,$col)=explode(".",$val);
					fwrite_encode( $fp,'$tab_liens['.$z.']="'.$val.'.'.$relation_col.'";'."\n");
					$z++;
				}
			}
		}
	}
	fwrite_encode( $fp,'   $result = execute_select($query,0,$tab_liens,'."'$nom_id'".',$pk_table,0,$mod_tabulaire_moteur,1);'."\n");
}
else{
	fwrite_encode( $fp,'   $result = execute_select($query,0,0,"'.$nom_id.'",$pk_table,0,$mod_tabulaire_moteur,1);'."\n");
}
fwrite_encode( $fp,'echo "</td></tr></table>";'.";\n");

fwrite_encode( $fp,'$buffer=ob_get_contents();'."\n");
fwrite_encode( $fp,'ob_end_flush();'."\n");

fwrite_encode( $fp,'?>'."\n");
fwrite_encode( $fp,''."\n");
fclose( $fp );
?>
</body>
</html>