<html>
<head>
<?php
include_once("encodage.inc.php");
asort($tableau_ordre_admin);
?>
</head>
<body bgcolor="#FFCC99">
<?php
include_once("functions.inc.php");
include_once("var.inc.php");
$connexion=connexion($database);


$filename = $table."_tableau_admin.".$extension;
print "Ecriture du fichier <a href=$filename>$filename</a> <br/>";
$fp = fopen( $filename, "w" ) or die("Impossible d'ouvrir $filename");
fwrite_encode( $fp, "<?php\n" );
fwrite_encode( $fp, 'function callback($buffer){'."\n" );
fwrite_encode( $fp, '  return $buffer;'."\n" );
fwrite_encode( $fp, '}'."\n" );

fwrite_encode( $fp, 'if ($export==1){'."\n" );
fwrite_encode( $fp, 'ob_start("callback");'."\n" );
fwrite_encode( $fp, "header('Content-disposition: filename=export.xls');\n" );
fwrite_encode( $fp, "header('Content-type: application/octetstream');\n" );
fwrite_encode( $fp, "header('Pragma: no-cache');\n" );
fwrite_encode( $fp, "header('Expires: 0');\n" );
fwrite_encode( $fp, '}'."\n" );
fwrite_encode( $fp, "?>\n" );

fwrite_encode( $fp, "<?php\n" );
fwrite_encode( $fp,'include("'.$table.'_parametres.'.$extension.'");'."\n");
fwrite_encode( $fp,"//Inclusion de la page entete qui inclue les variables et les fonctions.\n");
fwrite_encode( $fp,'include("entete.php");'."\n");
fwrite_encode( $fp,'include_once("var.inc.php");'."\n"); 
fwrite_encode( $fp,'include_once("functions.inc.php");'."\n");
fwrite_encode( $fp,'$connexion=connexion($bdd);'."\n");
fwrite_encode( $fp, "?>\n" );

//inclusion de code specifique
fwrite_encode( $fp,$insertion_deb_suivi_admin."\n" );

fwrite_encode( $fp, '<h2><?php echo "$titreTableau $titre_formulaire";?>'."</h2>\n" );
fwrite_encode( $fp, '<input type=button onclick="javascript:location.reload();" value="Actualiser"><br/>'."\n" );

fwrite_encode( $fp, '<?php'."\n" );
fwrite_encode( $fp, 'if (mb_stristr($_SERVER[HTTP_REFERER],"_rech")=== FALSE){'."\n" );
fwrite_encode( $fp, '	$redirection_export=$_SERVER[HTTP_REFERER];'."\n" );
fwrite_encode( $fp, '}'."\n" );
fwrite_encode( $fp, 'else {'."\n" );
fwrite_encode( $fp, '	$redirection_export=$filename;'."\n" );
fwrite_encode( $fp, '}'."\n" );
fwrite_encode( $fp, '?>'."\n" );

fwrite_encode( $fp, '<form target=_blank action="<?php echo $redirection_export?>">'."\n" );
fwrite_encode( $fp, '<input type="hidden" name="export" value="1">'."\n" );
fwrite_encode( $fp, '<input type="hidden" name="pos" value="<?php echo $pos?>">'."\n" );

fwrite_encode( $fp, '<input type=button onclick="document.forms[0].submit();" value="Export Excel">'."\n" );
fwrite_encode( $fp, '</form>'."\n" );

fwrite_encode( $fp, '<br/>'."\n" );
fwrite_encode( $fp, '<?php'."\n");

fwrite_encode( $fp, 'echo "Date du jour : ".date_to_france(date("Y-m-d"))."<br/><br/>";'."\n");

fwrite_encode( $fp, '$mois_fr = Array("", "Janvier", "F&eacute;vrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Ao&ucirc;t","Septembre", "Octobre", "Novembre", "D&eacute;cembre");'."\n");

fwrite_encode( $fp, 'if (empty($pos)){'."\n");
fwrite_encode( $fp, '	$pos=0;'."\n");
fwrite_encode( $fp, '}'."\n");

fwrite_encode( $fp, 'echo \'<a href="'.$filename.'?pos=\'.($pos-1).\'">\'.$mois_fr[date("n",mktime(0, 0, 0, date("m")+$pos-1, 1,   date("Y")))]." ".date("Y",mktime(0, 0, 0, date("m")+$pos-1, 1,   date("Y")))."</a>";'."\n");
fwrite_encode( $fp, 'echo "&nbsp;";'."\n");
fwrite_encode( $fp, 'echo $mois_fr[date("n",mktime(0, 0, 0, date("m")+$pos, 1,   date("Y")))]." ".date("Y",mktime(0, 0, 0, date("m")+$pos, 1,   date("Y")));'."\n");
fwrite_encode( $fp, 'echo "&nbsp;";'."\n");
fwrite_encode( $fp, 'echo \'<a href="'.$filename.'?pos=\'.($pos+1).\'">\'.$mois_fr[date("n",mktime(0, 0, 0, date("m")+$pos+1, 1,   date("Y")))]." ".date("Y",mktime(0, 0, 0, date("m")+$pos+1, 1,   date("Y")))."</a>";'."\n");
fwrite_encode( $fp, '?>'."\n");

$req="select * from $table";

$result = execute_sql($req);
$fields = mysqli_num_fields($result);

// Gestion de l'entete du tableau
fwrite_encode( $fp,'<style type="text/css" media="all">'."\n");
fwrite_encode( $fp,'.tableausuivi table {'."\n");
fwrite_encode( $fp,' border-width:1px; '."\n");
fwrite_encode( $fp,' border-style:solid; '."\n");
fwrite_encode( $fp,' border-collapse:collapse;'."\n");
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
fwrite_encode( $fp,'<tr>'."\n");
foreach ($tableau_ordre_admin as $key => $val) {
	if (!empty($val)){
		fwrite_encode( $fp,'<th>'."\n" );
		if (isset($label[$key])&&(!empty($label[$key])))
		fwrite_encode( $fp,'<?php echo ucfirst(mb_strtolower($label['.$key.']))?>'."\n" );
		fwrite_encode( $fp,'</th>'."\n" );
	}
}
fwrite_encode( $fp,'</tr>'."\n");
fwrite_encode( $fp,'<?php'."\n");
// Gestion de la boucle sur les tuples
fwrite_encode( $fp,'if (!empty($tableau_ordre_tri)&&!empty($tableau_ordre_tri_colonnes)){'."\n");
fwrite_encode( $fp,'	$tableau_clause = " order by $tableau_ordre_tri_colonnes";'."\n");
fwrite_encode( $fp,'	$clause_dt="where EXTRACT(YEAR_MONTH FROM $tableau_ordre_tri)=\"".date("Y",mktime(0, 0, 0, date("m")+$pos, 1,   date("Y"))).date("m",mktime(0, 0, 0, date("m")+$pos, 1,   date("Y"))).\'"\';'."\n");
fwrite_encode( $fp,'}'."\n");
fwrite_encode( $fp,'else {'."\n");
fwrite_encode( $fp,'	$tableau_clause = " order by 1 desc";'."\n");
fwrite_encode( $fp,'}'."\n");


fwrite_encode( $fp,'$req="select * from '.$table.' $clause_dt $tableau_clause"'.";\n" );
fwrite_encode( $fp,'$ret=execute_sql($req);'."\n" );
fwrite_encode( $fp,'$i=0;'."\n" );
fwrite_encode( $fp,'while ($row = mysqli_fetch_row($ret)){  '."\n");
fwrite_encode( $fp,'   if ($i%2==0)'."\n");
fwrite_encode( $fp,'      echo "<tr class=lig0>\n";'."\n");
fwrite_encode( $fp,'   else'."\n");
fwrite_encode( $fp,'      echo "<tr class=lig1>\n";'."\n");
fwrite_encode( $fp,'   $i++;'."\n" );
fwrite_encode( $fp,'?>'."\n");

//inclusion de code specifique
fwrite_encode( $fp,$insertion_boucle_suivi_admin."\n" );
// Affichage des lignes du tableau
foreach ($tableau_ordre_admin as $key => $val) {
	if (!empty($val)){
		$type  = db_field_direct_type($result, $key);
		$name  = db_field_direct_name($result, $key);
		$len   = db_field_direct_len($result, $key);
		$flags = db_field_direct_flags($result, $key);
		$fk="";
		if (!empty($tables[$key])){
			$nom_fk=explode(".",$tables[$key]);
			$fk=$nom_fk[0];
		}
		if (!empty($fk)){
			//gestion de l'affichage des popups 
                        fwrite_encode($fp, "<?php\n");
                        fwrite_encode($fp, 'if (!empty($req_fk['.$key.'])) {'."\n");
                        fwrite_encode($fp, '   $result1 = execute_sql($req_fk['.$key.']);'."\n");
                        fwrite_encode($fp, '   $nom_col1= db_field_direct_name($result1,$cols1['.$key.']);'."\n");
                        fwrite_encode($fp, '   if (mb_stristr($req_fk['.$key.'],\'where\')){'."\n");
                        fwrite_encode($fp, '      $req_table_etrangere_tab=explode(\'order\',$req_fk['.$key.']);'."\n");
                        fwrite_encode($fp, '      $req_table_etrangere= $req_table_etrangere_tab[0]." and $nom_col1=\'".$row['.$key.']."\'";'."\n");
                        fwrite_encode($fp, '   }'."\n");
                        fwrite_encode($fp, '   elseif (mb_stristr($req_fk['.$key.'],\'order\')){'."\n");
                        fwrite_encode($fp, '      $req_table_etrangere_tab=explode(\'order\',$req_fk['.$key.']);'."\n");
                        fwrite_encode($fp, '      $req_table_etrangere= $req_table_etrangere_tab[0]." where $nom_col1=\'".$row['.$key.']."\'";'."\n");
                        fwrite_encode($fp, '   }'."\n");
                        fwrite_encode($fp, '   else{'."\n");
                        fwrite_encode($fp, '      $req_table_etrangere=$req_fk[$i]." where $nom_col1=\'".$row['.$key.']."\'";'."\n");
                        fwrite_encode($fp, '   }'."\n");
                        fwrite_encode($fp, '}'."\n");

                        fwrite_encode($fp, 'else {'."\n");
                        fwrite_encode($fp, '   $req="select * from '.$fk.'";'."\n");
                        fwrite_encode($fp, '   $result1 = execute_sql($req);'."\n");
                        fwrite_encode($fp, '   $nom_col1= db_field_direct_name($result1,$cols1['.$key.']);'."\n");
                        fwrite_encode($fp, '   $req_table_etrangere="select * from '.$fk.' where $nom_col1=\'".$row['.$key.']."\'";'."\n");
                        fwrite_encode($fp, '}'."\n");

                        fwrite_encode($fp, "echo '<td>';\n");

                        fwrite_encode($fp, 'echo lister_col_num_lib($req_table_etrangere,$cols2['.$key.']);'."\n");
                        fwrite_encode($fp, "echo '</td>';\n");

                        fwrite_encode( $fp, "?>\n");

		}
		elseif (db_type($type,$flags)=='date'){
			fwrite_encode($fp,'<td><?php echo date_to_france($row['.$key."])?></td>\n");
		}
		elseif (isset($photos)&&in_array($key,$photos)){
			//MdB gestion de photos 02/07/03
			fwrite_encode($fp,"<td>\n");
			fwrite_encode($fp,"<?php\n");
			fwrite_encode($fp,'if (!empty($row['.$key.'])){'."\n");
			fwrite_encode($fp,'   $fichier=$rep.\'/'.$table.'-\'.$row[0].\'-\'.\''.$name.'\'."-".$row['.$key.'];'."\n");
			fwrite_encode($fp,'   echo "<img src=\"$fichier\">";'."\n");
			fwrite_encode($fp,"}\n");
			fwrite_encode($fp,"?>\n");
			fwrite_encode($fp,"</td>\n");
		}
		elseif (isset($fichiers)&&in_array($key,$fichiers)){
			//MdB gestion de fichiers 13/10/11
			fwrite_encode($fp,"<td>\n");
			fwrite_encode($fp,"<?php\n");
			fwrite_encode($fp,'if (!empty($row['.$key.'])){'."\n");
			fwrite_encode($fp,'   $fichier=$rep.\'/'.$table.'-\'.$row[0].\'-\'.\''.$name.'\'."-".$row['.$key.'];'."\n");
			fwrite_encode($fp,'   echo "$row['.$key.']&nbsp;<a target=_blank href=\"$fichier\">Voir</a><br />";'."\n");
			fwrite_encode($fp,"}\n");
			fwrite_encode($fp,"?>\n");
			fwrite_encode($fp,"</td>\n");
		}
		else {
			fwrite_encode($fp,'<td><?php echo ret_base_html($row['.$key."])?></td>\n");
		}
	}
}

fwrite_encode( $fp,"</tr>\n" );

fwrite_encode( $fp,'<?php'."\n" );
fwrite_encode( $fp,'}'."\n");
fwrite_encode( $fp,'?>'."\n" );

fwrite_encode( $fp,'</table> '."\n");
fwrite_encode( $fp,'</div>'."\n");

//inclusion de code specifique
fwrite_encode( $fp,$insertion_fin_suivi_admin."\n" );

fwrite_encode( $fp,'<?php'."\n" );
fwrite_encode( $fp,'include("piedpage.php");'."\n");

fwrite_encode( $fp, 'if ($export==1){'."\n" );
fwrite_encode( $fp,'$buffer=ob_get_contents();'."\n");
fwrite_encode( $fp,'ob_end_flush();'."\n");
fwrite_encode( $fp, '}'."\n" );

fwrite_encode( $fp,'?>'."\n" );
?>
</body>
</html>
