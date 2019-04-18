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

$filename = $table."_vue.".$extension;
print "Ecriture du fichier $filename<br>";
$fp = fopen( $filename, "w" ) or die("Impossible d'ouvrir $filename");

fwrite_encode( $fp, "<?php\n" );
fwrite_encode( $fp,'include("'.$table.'_parametres.'.$extension.'");'."\n");
fwrite_encode( $fp,"//Inclusion de la page entete qui inclue les variables et les fonctions.\n");

fwrite_encode( $fp,'$vue=1;'."\n");
fwrite_encode( $fp,'include("entete.php");'."\n");
fwrite_encode( $fp,'$connexion=connexion($bdd);'."\n");
fwrite_encode( $fp,'if (empty($id)) exit();'."\n" );
fwrite_encode( $fp, "?>\n" );

$req="select * from $table";
$result = execute_sql($req);
$fields = mysqli_num_fields($result);

fwrite_encode( $fp,"<!-- Formulaire de mise a jour des donnees-->\n" );
fwrite_encode( $fp,"<form name=formulaire action=$filename method=post>\n" );
fwrite_encode( $fp,'<?php '."\n");

$flags = db_field_direct_flags($result,0);
$maclause="";
$f=0;
if (!mb_stristr($flags,'auto')){
	// gestion du pasage des parametres pour la maj et la vue pour les relations a 3 pattes
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
	fwrite_encode( $fp,'$req='."\"select * from $table where $maclause\";\n" );
}
else{
	$maclause="$nom_id=".'$id';
	fwrite_encode( $fp,'$req='."\"select * from $table where $maclause\";\n" );
}
fwrite_encode( $fp,'include("session_vue.'.$extension.'");'."\n");

fwrite_encode( $fp,'$ret=execute_sql($req);'."\n" );
fwrite_encode( $fp,'$row = mysqli_fetch_row($ret);  '."\n");
fwrite_encode( $fp,'?>'."\n");

//inclusion de code specifique
fwrite_encode( $fp,$insertion_deb_vue."\n" );

fwrite_encode( $fp, '<h2><?php echo "$titreView $titre_formulaire I-$id";?>'."</h2>\n" );
fwrite_encode( $fp, '<input type=button onClick=window.print() value="Imprimer la page">'."\n");


// Gestion de l'entete du tableau
fwrite_encode( $fp,'<style type="text/css" media="all">'."\n");
fwrite_encode( $fp,'.tableausuivi table {'."\n");
fwrite_encode( $fp,' border-width:1px; '."\n");
fwrite_encode( $fp,' border-style:solid; '."\n");
fwrite_encode( $fp,' border-collapse:collapse;'."\n");
fwrite_encode( $fp,' width:180mm;'."\n");
fwrite_encode( $fp,' }'."\n");
fwrite_encode( $fp,'.tableausuivi td { '."\n");
fwrite_encode( $fp,' border-width:1px;'."\n");
fwrite_encode( $fp,' border-style:solid; '."\n");
fwrite_encode( $fp,' }'."\n");
fwrite_encode( $fp,'.tableausuivi th { '."\n");
fwrite_encode( $fp,' border-width:1px;'."\n");
fwrite_encode( $fp,' border-style:solid; '."\n");
fwrite_encode( $fp,'}'."\n");
fwrite_encode( $fp,'</style>'."\n");
fwrite_encode( $fp,'<div class="tableausuivi">'."\n");
fwrite_encode( $fp,'<table>'."\n");

$flags = db_field_direct_flags($result,0);
if (mb_stristr($flags,'auto')){
	$i = 1;
}
else{
	$i = 0;
}
while ($i < $fields) {
	$type  = db_field_direct_type($result, $i);
	$name  = db_field_direct_name($result, $i);
	$len   = db_field_direct_len($result, $i);
	$flags = db_field_direct_flags($result, $i);
	if (isset($vue)&&in_array($i,$vue)){
	  fwrite_encode( $fp,'<?php'."\n");
	  fwrite_encode( $fp,'if (($vue_util_zone_vide=="invisible")&&(empty($row['.$i.'])||($row['.$i.']=="0000-00-00")))'."\n");
	  fwrite_encode( $fp,'echo "<tr style=display:none>";'."\n");
	  fwrite_encode( $fp,'else'."\n");
	  fwrite_encode( $fp,'echo "<tr>";'."\n");
	  fwrite_encode( $fp,'?>'."\n");	  
		if (isset($label)&&(!empty($label)))
			fwrite_encode( $fp,'<td '.$div_attributs_vue[$i].'><?php echo $label['.$i.']?></td>'."\n" );
		else
			fwrite_encode( $fp,'<td '.$div_attributs_vue[$i].'>'.ucfirst(mb_strtolower($name))."</td>\n" );
		$fk="";
		if (!empty($tables[$i])){
			$nom_fk=explode(".",$tables[$i]);
			$fk=$nom_fk[0];
		}
		if (!empty($fk)){
			//gestion de l'affichage des cles etrangeres
			fwrite_encode($fp, "<?php\n");
			fwrite_encode($fp, 'if (!empty($req_fk['.$i.'])) {'."\n");
			fwrite_encode($fp, '   $result1 = execute_sql($req_fk['.$i.']);'."\n");
			fwrite_encode($fp, '   $nom_col1= db_field_direct_name($result1,$cols1['.$i.']);'."\n");
			fwrite_encode($fp, '   if (mb_stristr($req_fk['.$i.'],\'where\')){'."\n");
                        fwrite_encode($fp, '      $req_table_etrangere_tab=explode(\'order\',$req_fk['.$i.']);'."\n");
                        fwrite_encode($fp, '      $req_table_etrangere= $req_table_etrangere_tab[0]." and $nom_col1=\'".$row['.$i.']."\'";'."\n");
			fwrite_encode($fp, '   }'."\n");
			fwrite_encode($fp, '   elseif (mb_stristr($req_fk['.$i.'],\'order\')){'."\n");
                        fwrite_encode($fp, '      $req_table_etrangere_tab=explode(\'order\',$req_fk['.$i.']);'."\n");
                        fwrite_encode($fp, '      $req_table_etrangere= $req_table_etrangere_tab[0]." where $nom_col1=\'".$row['.$i.']."\'";'."\n");
			fwrite_encode($fp, '   }'."\n");
			fwrite_encode($fp, '   else{'."\n");
			fwrite_encode($fp, '      $req_table_etrangere=$req_fk['.$i.']." where $nom_col1=\'".$row['.$i.']."\'";'."\n");
			fwrite_encode($fp, '   }'."\n");
			fwrite_encode($fp, '}'."\n");

			fwrite_encode($fp, 'else {'."\n");
			fwrite_encode($fp, '   $req="select * from '.$fk.'";'."\n");
			fwrite_encode($fp, '   $result1 = execute_sql($req);'."\n");
			fwrite_encode($fp, '   $nom_col1= db_field_direct_name($result1,$cols1['.$i.']);'."\n");
			fwrite_encode($fp, '   $req_table_etrangere="select * from '.$fk.' where $nom_col1=\'".$row['.$i.']."\'";'."\n");
			fwrite_encode($fp, '}'."\n");

			fwrite_encode($fp, "echo '<td>';\n");

			fwrite_encode($fp, 'echo lister_col_num_lib($req_table_etrangere,$cols2['.$i.']);'."\n");
			fwrite_encode($fp, "echo '</td>';\n");

			fwrite_encode( $fp, "?>\n");

		}
		elseif (db_type($type,$flags)=='date'){
			fwrite_encode($fp,'<td><?php echo date_to_fr($row['.$i."])?></td>\n");
		}
		elseif (isset($photos)&&in_array($i,$photos)){
			//MdB gestion de photos 02/07/03
			fwrite_encode($fp,"<td>\n");
			fwrite_encode($fp,"<?php\n");
			fwrite_encode($fp,'if (!empty($row['.$i.'])){'."\n");
			fwrite_encode($fp,'   $fichier=$rep.\'/'.$table.'-\'.$row[0].\'-\'.\''.$name.'\'."-".$row['.$i.'];'."\n");
                        fwrite_encode($fp,'   echo "<a target=_blank href=\"$fichier\"><img src=\"$fichier\" id=\"'.$name.'\" class=\"output_image\"/></a><br />";'."\n");
			fwrite_encode($fp,"}\n");
			fwrite_encode($fp,"?>\n");
			fwrite_encode($fp,"</td>\n");
		}
		elseif (isset($fichiers)&&in_array($i,$fichiers)){
			//MdB gestion de fichiers 13/10/11
			fwrite_encode($fp,"<td>\n");
			fwrite_encode($fp,"<?php\n");
			fwrite_encode($fp,'if (!empty($row['.$i.'])){'."\n");
			fwrite_encode($fp,'   $fichier=$rep.\'/'.$table.'-\'.$row[0].\'-\'.\''.$name.'\'."-".$row['.$i.'];'."\n");
			fwrite_encode($fp,'   echo "$row['.$i.']&nbsp;<a target=_blank href=\"$fichier\">Voir</a><br />";'."\n");
			fwrite_encode($fp,"}\n");
			fwrite_encode($fp,"?>\n");
			fwrite_encode($fp,"</td>\n");
		}
		else {
			if (isset($editeur)&&in_array($i,$editeur)){
				fwrite_encode($fp,'<td><?php echo $row['.$i."]?></td>\n");
			}
			else {
				fwrite_encode($fp,'<td><?php echo ret_base_html($row['.$i."])?></td>\n");
			}
		}
	  fwrite_encode( $fp,"</tr>\n" );

	}
	$i++;
}

//Gestion des relations n a n avec 2 pattes
$i=0;
$w=0;
for ($w=0;$w<5;$w++){
    if (!empty($table_fille[$w])){			
        $table_relation=explode("\r\n",$association[$w]);
        list($nom_table_relation,$col_relation_depart)=explode(".",$table_relation[0]);
        list($val,$col)=explode(".",$table_fille[$w]);
        list($val_tmp,$col_depart)=explode(".",$relation[$w]);      
        $tab_liste_num_colonne2=explode(',',$num_colonne2[$w]);
        $tab_liste_num_colonne2_fk=explode(',',$num_colonne2_fk[$w]);

        fwrite_encode($fp,"<?php\n" ); // Affichage des valeurs de la table fille si il en a
        fwrite_encode($fp,'echo "<tr\">";'."\n");	
        fwrite_encode($fp,'echo "<td>".ucfirst(mb_strtolower($relation_2pattes['.$w.']));'."\n");
        fwrite_encode($fp,'echo "</td>";'."\n");                                                
        fwrite_encode($fp,'echo "<td>";'."\n");                    
        fwrite_encode($fp,"\$reql2=\"select * from $val,$nom_table_relation where $val.$col=$nom_table_relation.$col_relation_depart and $nom_table_relation.$col_depart=\$id order by $num_tri\";\n" );
        fwrite_encode($fp,"\$resultat_sql_l2=execute_sql(\$reql2);\n" );
        
        fwrite_encode($fp,"while(\$row_l2=mysqli_fetch_row(\$resultat_sql_l2)){\n" );
        for ($u=0;$u<count($tab_liste_num_colonne2);$u++){
            //fwrite_encode($fp," echo \$row_l2[$tab_liste_num_colonne2[$u]].'&nbsp;';\n" );
            if (isset($tab_liste_num_colonne2_fk[$u])&&!empty($tab_liste_num_colonne2_fk[$u])){
                
                list($table_fk,$col_fk)=explode(".",$tab_liste_num_colonne2_fk[$u]);
                $req_fk="select * from $table_fk where $col_fk=\$row_l2[$tab_liste_num_colonne2[$u]]";
                fwrite_encode($fp,"echo tronquer(lister_col_num_lib(\"$req_fk\",1)).' ';" );
                //num_col_depuis_nom($tab_colonnes,$nom_colonne)            
            }
            else {
                fwrite_encode($fp,"echo tronquer(\$row_l2[$tab_liste_num_colonne2[$u]]).' ';" );
            }            
        }
        fwrite_encode($fp,'echo "<br />";'."\n");                    
        fwrite_encode($fp,"}\n" );			

        fwrite_encode($fp,'echo "</td>";'."\n");                    
        fwrite_encode($fp,'echo "</tr>";'."\n");                    
        fwrite_encode($fp,"?>\n" );
    }
}


fwrite_encode( $fp,'<?php'."\n" );
fwrite_encode( $fp,'include("piedpage.php");'."\n");
fwrite_encode( $fp,'?>'."\n" );
//inclusion de code specifique
fwrite_encode( $fp,$insertion_fin_vue."\n" );
?>

</body>
</html>
