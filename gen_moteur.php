<html>
<head>
<?php
include_once("var.inc.php");
include_once("functions.inc.php");
include_once("encodage.inc.php");
?>
</head>
<body bgcolor="#FFCC99">
<?php
$connexion=connexion($database);

//afin d'avoir toujours la liste des colonnes car la variable name est ecrase dans le pgme
$liste_des_colonnes_table=$name;

$filename = $table."_rech.".$extension;
print "Ecriture du fichier <a href=$filename>$filename</a> <br>";
$fp = fopen( $filename, "w" ) or die("Impossible d'ouvrir $filename");
fwrite_encode( $fp, "<?php\n" );
fwrite_encode( $fp,'include("session_rech.php");'."\n");
fwrite_encode( $fp,'include("'.$table.'_parametres.'.$extension.'");'."\n");
fwrite_encode($fp,'@include("'.$table.'_diag.'.$extension.'");'."\n");
fwrite_encode( $fp,"//Inclusion de la page entete qui inclue les variables et les fonctions.\n");
fwrite_encode( $fp,'include("entete.php");'."\n");
fwrite_encode( $fp,'$connexion=connexion($bdd);'."\n");
fwrite_encode($fp,'if (!empty($mode_affichage_popup)) $affiche_popup=$mode_affichage_popup;'."\n");

fwrite_encode( $fp, "?>\n" );
fwrite_encode( $fp,$insertion_tout_deb_moteur."\n" );

echo $insertion_tout_deb_moteur;

fwrite_encode( $fp, '<h2><?php echo "$titreMoteur $titre_formulaire";?>'."</h2>\n" );

fwrite_encode( $fp,"<!-- Formulaire de saisie des criteres de recherche-->\n");
fwrite_encode( $fp,'<form name=recherche action=<?php echo $PHP_SELF;?> method=post>'."\n");
//empeche l'affichage du resultat la 1ere fois
fwrite_encode( $fp,'<input type=hidden name=lancer_rech value=1>'."\n");
fwrite_encode( $fp,'<input type=hidden name=tri value="'.$tri.'">'."\n");
if ((!empty($critere))||(!empty($rech_nan))||(!empty($rech_nan))){
	fwrite_encode( $fp,'<table><tr><td>'."\n");
	fwrite_encode( $fp,'<table>'."\n");
	for ($i=0;$i<count($critere);$i++){

            fwrite_encode( $fp,'<?php if (!isset($'.$name[$critere[$i]].')) $'.$name[$critere[$i]].'="";?>'."\n");
            $long=$len[$critere[$i]];
            $long++; //on augmente un peu la taille par precaution
            if ($long>50) $long=50;
            $fk='';
            if (!empty($tables[$critere[$i]])){
                    $nom_fk=explode(".",$tables[$critere[$i]]);
                    $fk=$nom_fk[0];
            }			
            if (!empty($fk)){
                //gestion de l'affichage des popup avec radios
                fwrite_encode($fp, '<tr><td><?php echo $criteres['.$i.']?></td><td>'."\n");
                fwrite_encode($fp,"<?php\n" );
                fwrite_encode($fp,'if ($affiche_popup==0)'."\n");
                fwrite_encode( $fp, "   lister_table('".$name[$critere[$i]]."','$fk',".$cols1[$critere[$i]].','.$cols2[$critere[$i]].",".'$'.$name[$critere[$i]].",1,\"".stripslashes($req_fk[$critere[$i]])."\");\n" );

                $req="select * from $fk";
                $result1 = execute_sql($req);
                $nom_col1= db_field_direct_name($result1,0);
                $nom_col2= db_field_direct_name($result1,1);

                fwrite_encode($fp,'if ($affiche_popup==2){'."\n");
                fwrite_encode($fp,'   echo "<input style=\'background-color:$couleur_protege;\' type=text onFocus=blur() size=30 value=\"$'.$name[$critere[$i]].'\" name=\"'.$name[$critere[$i]].'\">";'."\n");
                fwrite_encode($fp,'   echo "&nbsp;<a href=javascript:OuvrirPopup(\'$bdd\','."'$fk','$nom_col1','$nom_col2','1','','".$name[$critere[$i]]."','$table'".')><img border=0 src=images/b_search.png ALT=D&eacute;tails width=15 height=15></a>";'."\n");
                fwrite_encode($fp,'}'."\n");
                fwrite_encode($fp,"?>\n" );
                fwrite_encode($fp,"</td></tr>\n");
            }
            // Gestion de l etat du workflow
            elseif ($name[$critere[$i]]=='etat'){
                fwrite_encode($fp,'<tr><td><?php echo $criteres['.$i.']?></td><td>');
                fwrite_encode($fp,'<?php diag_etat($lesetats,"'.$name[$critere[$i]].'",$'.$name[$critere[$i]].");?>\n");
                fwrite_encode($fp,"</td></tr>\n");
			}
			elseif ((db_type($type[$critere[$i]],$flags[$critere[$i]])=='int')||(db_type($type[$critere[$i]],$flags[$critere[$i]])=='real')){
                fwrite_encode( $fp,'<tr><td><?php echo $criteres['.$i.']?></td><td><input type=text size='.$long.' maxlength='.$len[$critere[$i]].' name='.$name[$critere[$i]].' value="<?php echo $'.$name[$critere[$i]].'?>"></td></tr>'."\n");
                fwrite_encode($fp,"</td></tr>\n");
            }
			elseif (db_type($type[$critere[$i]],$flags[$critere[$i]])=='date'){
                fwrite_encode( $fp, "<?php\n" );
                fwrite_encode( $fp,'if (!isset($choix_'.$name[$critere[$i]].')) $choix_'.$name[$critere[$i]].'="=";'."\n");
                fwrite_encode( $fp, 'if ($choix_'.$name[$critere[$i]].'=="=")'."\n");
                fwrite_encode( $fp,'echo "<tr><td>".$criteres['.$i.']."</td><td><select name=choix_'.$name[$critere[$i]].'><option selected value=\"=\">Le<option value=\"sup\">Apr&egrave;s le<option value=\"inf\">Avant le</select><input type=text class=\"w16em dateformat-d-sl-m-sl-Y\" size=12 onChange=CheckDate(document.forms[0].'.$name[$critere[$i]].'.value) name='.$name[$critere[$i]].' value=\"$'.$name[$critere[$i]].'\">";'."\n");
                fwrite_encode( $fp, 'if ($choix_'.$name[$critere[$i]].'=="sup")'."\n");
                fwrite_encode( $fp,'echo "<tr><td>".$criteres['.$i.']."</td><td><select name=choix_'.$name[$critere[$i]].'><option value=\"=\">Le<option selected value=\"sup\">Apr&egrave;s le<option value=\"inf\">Avant le</select><input type=text class=\"w16em dateformat-d-sl-m-sl-Y\" size=12 onChange=CheckDate(document.forms[0].'.$name[$critere[$i]].'.value) name='.$name[$critere[$i]].' value=\"$'.$name[$critere[$i]].'\">";'."\n");
                fwrite_encode( $fp, 'if ($choix_'.$name[$critere[$i]].'=="inf")'."\n");
                fwrite_encode( $fp,'echo "<tr><td>".$criteres['.$i.']."</td><td><select name=choix_'.$name[$critere[$i]].'><option value=\"=\">Le<option value=\"sup\">Apr&egrave;s le<option selected value=\"inf\">Avant le</select><input type=text class=\"w16em dateformat-d-sl-m-sl-Y\" size=12 onChange=CheckDate(document.forms[0].'.$name[$critere[$i]].'.value) name='.$name[$critere[$i]].' value=\"$'.$name[$critere[$i]].'\">";'."\n");
                
                //Gestion de la recherche entre 2 dates
                fwrite_encode( $fp,'echo "&nbsp;Avant le <input type=text class=\"w16em dateformat-d-sl-m-sl-Y\" size=12 onChange=CheckDate(document.forms[0].'.$name[$critere[$i]].'2.value) name='.$name[$critere[$i]].'2 value=\"$'.$name[$critere[$i]].'2\">";'."\n");
                
                fwrite_encode( $fp, "?>\n" );
                fwrite_encode($fp,"</td></tr>\n");
            }
			elseif (db_type($type[$critere[$i]],$flags[$critere[$i]])=='enum'){
                fwrite_encode($fp,'<tr><td><?php echo $criteres['.$i.']?></td><td>');
                fwrite_encode($fp,"<?php enum_select('".$name[$critere[$i]]."','$table',".'$'.$name[$critere[$i]].");?>\n");
                fwrite_encode($fp,"</td></tr>\n");
            }
			elseif (db_type($type[$critere[$i]],$flags[$critere[$i]])=='set'){
                fwrite_encode($fp,'<tr><td><?php echo $criteres['.$i.']?></td><td>');
                fwrite_encode($fp,"<?php enum_select('".$name[$critere[$i]]."','$table',".'$'.$name[$critere[$i]].");?>\n");
                fwrite_encode($fp,"</td></tr>\n");
            }
            else {
                fwrite_encode( $fp,'<tr><td><?php echo $criteres['.$i.']?></td><td><input type=text size='.$long.' maxlength='.$len[$critere[$i]].' name='.$name[$critere[$i]].' id='.$name[$critere[$i]].' value="<?php echo $'.$name[$critere[$i]].'?>"></td></tr>'."\n");
            }
	}
	$i=0;
        if (isset($rech_1an)&&!empty($rech_1an)){
		$CIF2=explode("\r\n",$CIF);
		if (!empty($CIF2[0])){
			for ($z=0;$z<count($CIF2);$z++){
				list($val,$col)=explode(".",$CIF2[$z]);
				$req="select * from $val";
				$result1 = execute_sql($req);
				$nom_1an_id  = db_field_direct_name($result1, 0); //nom de la cle primaire 2
				$nom_col1= db_field_direct_name($result1,0);
				$nom_col2= db_field_direct_name($result1,1);
				//gestion de l'affichage des popup avec radios
				fwrite_encode($fp, '<tr><td><?php echo $label_1an['.$i.'];?>'."</td><td> \n");
				fwrite_encode($fp,"<?php\n" );
				fwrite_encode($fp,'if ($affiche_popup==0)'."\n");
				fwrite_encode( $fp, '   lister_table ("'.$nom_1an_id.'","'.$val.'",0,1,'.'$'.$nom_1an_id.",1,'');\n");
				fwrite_encode($fp,'if ($affiche_popup==2){'."\n");
				fwrite_encode($fp,'   echo "<input style=\'background-color:$couleur_protege;\' type=text onFocus=blur() size=30 value=\"$'.$nom_1an_id.'\" name=\"'.$nom_1an_id.'\">";'."\n");
				fwrite_encode($fp,'   echo "&nbsp;<a href=javascript:OuvrirPopup(\'$bdd\','."'$val','$nom_col1','$nom_col2','1','','$nom_col1','$table'".')><img border=0 src=images/b_search.png ALT=D&eacute;tails width=15 height=15></a>";'."\n");
				fwrite_encode($fp,'}'."\n");
				fwrite_encode($fp,"?>\n" );
				fwrite_encode($fp,"</td></tr>\n");
				$i++;
			}
		}
	}
	$i=0;
	if (!empty($rech_nan)){
		for ($z=0;$z<5;$z++){
			if (!empty($table_fille[$z])){
				$liste_table_fille=explode("\r\n",$table_fille[$z]);
				$liste_association=explode("\r\n",$association[$z]);
				while (list($cle,$val)=each($liste_table_fille)){
					list($val,$col)=explode(".",$val);
					list($cle_tmp,$val_tmp)=each($liste_association);
					list($table_asso,$col_asso)=explode(".",$val_tmp);
					$req="select * from $val";
					$result1 = execute_sql($req);
					$nom_nan_id  = db_field_direct_name($result1, 0); //nom de la cle primaire 2
					$nom_col1= db_field_direct_name($result1,0);
					//$nom_col2= db_field_direct_name($result1,$num_colonne2[$z]);
					$tab_liste_num_colonne2=explode(',',$num_colonne2[$z]);
					$tab_liste_num_colonne2_fk=explode(',',$num_colonne2_fk[$z]);
					
					$nom_col2= db_field_direct_name($result1,$tab_liste_num_colonne2[0]);
					
                                        if (!empty($tab_liste_num_colonne2[1])){
                                            $nom_autre_colonne= db_field_direct_name($result1,$tab_liste_num_colonne2[1]);
                                            fwrite_encode($fp,"<?php\n" );
                                            fwrite_encode($fp,'$num_autre_colonne="'.$num_colonne2[$z]."\";\n");
                                            fwrite_encode($fp,"?>\n" );
					}
					else{
                                            $nom_autre_colonne=$nom_col2;
					}
					
					
					//gestion de l'affichage des popup avec radios
					fwrite_encode($fp, '<tr><td><?php echo $label_nan['.$i.'];?>'."</td><td> \n");
					fwrite_encode($fp,"<?php\n" );
					fwrite_encode($fp,'if ($affiche_popup==0){'."\n");
					
                                        fwrite_encode($fp,"\$reql1=\"select * from $val where 1=1 \$$col"."_clause order by 2\";\n" );
                                        fwrite_encode($fp,"\$resultat_sql_l1=execute_sql(\$reql1);\n" );
                                        fwrite_encode($fp,"echo '<select name=$col_asso>';\n" );
                                        fwrite_encode($fp,"echo \"<option value=''>\";" );
                                        
                                        fwrite_encode($fp,"while(\$row_l1=mysqli_fetch_row(\$resultat_sql_l1)){\n" );
                                        
                                        fwrite_encode($fp,"if (\$row_l1[0]==\$$col_asso){");
                                        fwrite_encode($fp,"   echo \"<option selected value='\$row_l1[0]'>\";" );
					fwrite_encode($fp,'}'."\n");                                       
                                        fwrite_encode($fp,"else {");
                                        fwrite_encode($fp,"   echo \"<option value='\$row_l1[0]'>\";" );                                                                               
					fwrite_encode($fp,'}'."\n");

                                        
                                        for ($u=0;$u<count($tab_liste_num_colonne2);$u++){
                                            if (isset($tab_liste_num_colonne2_fk[$u])&&!empty($tab_liste_num_colonne2_fk[$u])){
                                                
                                                list($table_fk,$col_fk)=explode(".",$tab_liste_num_colonne2_fk[$u]);
                                                $req_fk="select * from $table_fk where $col_fk=\$row_l1[$tab_liste_num_colonne2[$u]]";
                                                fwrite_encode($fp,"echo tronquer(lister_col_num_lib(\"$req_fk\",1)).' ';" );
                                                //num_col_depuis_nom($tab_colonnes,$nom_colonne)            
                                            }
                                            else {
                                                fwrite_encode($fp,"echo tronquer(\$row_l1[$tab_liste_num_colonne2[$u]]).' ';" );
                                            }           
                                        }
                                        fwrite_encode($fp,"}\n" );
                                        fwrite_encode($fp,"echo '</select>';\n" );
					fwrite_encode($fp,'}'."\n");
        
					//fwrite_encode( $fp, '   lister_table("'.$col_asso.'","'.$val.'",0,'.$tab_liste_num_colonne2[0].','.'$'.$col_asso.",1,'');\n");
					
					
					fwrite_encode($fp,'if ($affiche_popup==2){'."\n");
					fwrite_encode($fp,'   echo "<input style=\'background-color:$couleur_protege;\' type=text onFocus=blur() size=30 value=\"$'.$col_asso.'\" name=\"'.$col_asso.'\">";'."\n");
					fwrite_encode($fp,'   echo "&nbsp;<a href=javascript:OuvrirPopup(\'$bdd\','."'$val','$nom_col1','$nom_col2','1','','$col_asso','$table','$nom_autre_colonne'".')><img border=0 src=images/b_search.png ALT=D&eacute;tails width=15 height=15></a>";'."\n");
					fwrite_encode($fp,'}'."\n");
					fwrite_encode($fp,"?>\n" );
					fwrite_encode($fp,"</td></tr>\n");
					$i++;
				}
			}
		}
	}

	fwrite_encode( $fp,"</table>"."\n");
	fwrite_encode( $fp,'</td><td>&nbsp;&nbsp;</td><td>'."\n");

	fwrite_encode( $fp,'<table>'."\n");
	fwrite_encode( $fp,'<?php'."\n");
	fwrite_encode( $fp,'if ($affichage_choix_colonne==1){'."\n");
	fwrite_encode( $fp,'   echo "<th>$message_affichage_colonnes</th>";'."\n");
	fwrite_encode( $fp,'}'."\n");
	fwrite_encode( $fp,'else {'."\n");
	fwrite_encode( $fp,'   $nb_col_affichable=1; '."\n");
	fwrite_encode( $fp,'}'."\n");
	fwrite_encode( $fp,'?>'."\n");
	fwrite_encode( $fp,'<tr><td>'."\n");

	fwrite_encode( $fp,'<div align=center><select <?php if ($affichage_choix_colonne==0) echo "style=visibility:hidden"?> MULTIPLE size=<?php echo $nb_col_affichable?> name=tab_affichage[]>'."\n");
	fwrite_encode( $fp,'<?php'."\n");
	fwrite_encode( $fp,'$test_pas_de_colonnes=0;'."\n");
	fwrite_encode( $fp,'for ($i=0;$i<count($label);$i++){'."\n");
	fwrite_encode( $fp,'   if (isset($tab_affichage)){'."\n");
	fwrite_encode( $fp,'      $test_pas_de_colonnes=1;'."\n");
	fwrite_encode( $fp,'      if (in_array($i,$tab_affichage)){'."\n");
	fwrite_encode( $fp,'         echo "<option selected value=$i>".tronquer_taille($label[$i],50)."</option>";'."\n");
	fwrite_encode( $fp,'      }'."\n");
	fwrite_encode( $fp,'      elseif (in_array($i,$col_affichable)){'."\n");
	fwrite_encode( $fp,'         echo "<option value=$i>".tronquer_taille($label[$i],50)."</option>";'."\n");
	fwrite_encode( $fp,'      }'."\n");	
	fwrite_encode( $fp,'   }'."\n");
	fwrite_encode( $fp,'   elseif ((in_array($i,$col_affichable))&&(in_array($i,$nu))){ '."\n");
	fwrite_encode( $fp,'      echo "<option selected value=$i>".tronquer_taille($label[$i],50)."</option>";'."\n");
	fwrite_encode( $fp,'   } '."\n");
	fwrite_encode( $fp,'   elseif (in_array($i,$col_affichable)){'."\n");
	fwrite_encode( $fp,'      echo "<option value=$i>".tronquer_taille($label[$i],50)."</option>";'."\n");
	fwrite_encode( $fp,'   }'."\n");		
	fwrite_encode( $fp,'}'."\n");

	fwrite_encode( $fp,'for ($i=0;$i<count($label);$i++){'."\n");
	fwrite_encode( $fp,'   if (($test_pas_de_colonnes==0)&&(in_array($label[$i],$resultats))){'."\n");
	fwrite_encode( $fp,'      $tab_affichage[count($tab_affichage)]=$i;'."\n");
	fwrite_encode( $fp,'   } '."\n");
	fwrite_encode( $fp,'}'."\n");

	fwrite_encode( $fp,'?>'."\n");
	fwrite_encode( $fp,'</select></div>'."\n");
	fwrite_encode( $fp,"</td></tr>"."\n");
	fwrite_encode( $fp,'<?php'."\n");
	fwrite_encode( $fp,'if ($affichage_tri==1){'."\n");
	fwrite_encode( $fp,'   echo "<TH>".$message_tri_colonnes."</TH><tr><td>";'."\n");
	fwrite_encode( $fp,'}'."\n");
	fwrite_encode( $fp,'else{'."\n");
	fwrite_encode( $fp,'   echo "<td></td><tr><td>";'."\n");
	fwrite_encode( $fp,'}'."\n");
	fwrite_encode( $fp,'if ($affichage_tri==1){'."\n");
	fwrite_encode( $fp,'   echo "<div align=center><select name=criteres_tri>";'."\n");
	fwrite_encode( $fp,'}'."\n");
	fwrite_encode( $fp,'else{'."\n");
	fwrite_encode( $fp,'   echo "<div align=center><select name=criteres_tri style=visibility:hidden>";'."\n");
	fwrite_encode( $fp,'}'."\n");

	fwrite_encode( $fp,'for ($i=0;$i<count($tab_colonnes);$i++){'."\n");
	fwrite_encode( $fp,'   if (isset($criteres_tri)){'."\n");
	fwrite_encode( $fp,'      if ($criteres_tri==$tab_colonnes[$i]){'."\n");
	fwrite_encode( $fp,'         echo "<option selected value=\'$tab_colonnes[$i]\'>".tronquer_taille($label[$i],50)."</option>";'."\n");
	fwrite_encode( $fp,'      }'."\n");
	fwrite_encode( $fp,'      elseif (in_array($i,$col_affichable))'."\n");
	fwrite_encode( $fp,'         echo "<option value=\'$tab_colonnes[$i]\'>".tronquer_taille($label[$i],50)."</option>";'."\n");
	fwrite_encode( $fp,'   }'."\n");
	fwrite_encode( $fp,'   elseif ($tab_colonnes[$i]==$tri){ '."\n");
	fwrite_encode( $fp,'      echo "<option selected value=\'$tab_colonnes[$i]\'>".tronquer_taille($label[$i],50)."</option>";'."\n");
	fwrite_encode( $fp,'      $criteres_tri=$tri;'."\n");
	fwrite_encode( $fp,'   }'."\n");
	fwrite_encode( $fp,'   elseif (in_array($i,$col_affichable))'."\n");
	fwrite_encode( $fp,'      echo "<option value=\'$tab_colonnes[$i]\'>".tronquer_taille($label[$i],50)."</option>";'."\n");
	fwrite_encode( $fp,'}'."\n");
	fwrite_encode( $fp,'?>'."\n");
	fwrite_encode( $fp,'</select></div>'."\n");
	fwrite_encode( $fp,"</td></tr>"."\n");


	fwrite_encode( $fp,"</table>"."\n");
	fwrite_encode( $fp,'</td></tr></table>'."\n");
	fwrite_encode( $fp,'<script type="text/javascript">'."\n");
	fwrite_encode( $fp,'function raz(){'."\n");
	for ($i=0;$i<count($critere);$i++){
			if (db_type($type[$critere[$i]],$flags[$critere[$i]])=='date'){
                fwrite_encode( $fp,'document.recherche.'.$name[$critere[$i]].'.value="";'."\n");
                fwrite_encode( $fp,'document.recherche.'.$name[$critere[$i]].'2.value="";'."\n");
            }
            else{
                fwrite_encode( $fp,'document.recherche.'.$name[$critere[$i]].'.value="";'."\n");
            }
	}
	if (!empty($rech_1an)){
		$CIF2=explode("\r\n",$CIF);
		if (!empty($CIF2[0])){
			for ($i=0;$i<count($CIF2);$i++){
				list($val,$col)=explode(".",$CIF2[$i]);
				$req="select * from $val";
				$result1 = execute_sql($req);
				$nom_1an_id  = db_field_direct_name($result1, 0); //nom de la cle primaire 2
				fwrite_encode( $fp,'document.recherche.'.$nom_1an_id.'.value="";'."\n");
			}
		}
	}
	if (!empty($rech_nan)){
		for ($i=0;$i<5;$i++){
			if (!empty($association[$i])){
				$liste_association=explode("\r\n",$association[$i]);
				while (list($cle,$val)=each($liste_association)){
					list($val,$col)=explode(".",$val);
					fwrite_encode( $fp,'document.recherche.'.$col.'.value="";'."\n");
				}
			}
		}
	}
	fwrite_encode( $fp,'}'."\n");
	fwrite_encode( $fp,'function inserer(){'."\n");
	fwrite_encode( $fp,'   document.forms[0].action="'.$table.'_ins.php";'."\n");
	fwrite_encode( $fp,'   document.forms[0].submit();'."\n");
	fwrite_encode( $fp,'}'."\n");
	fwrite_encode( $fp,'function export_xls(){'."\n");
	fwrite_encode( $fp,'   document.forms[0].action="'.$table.'_xls.php";'."\n");
	fwrite_encode( $fp,'   document.forms[0].submit();'."\n");
	fwrite_encode( $fp,'}'."\n");
	fwrite_encode( $fp,'function rechercher(ascdesc){'."\n");
	fwrite_encode( $fp,'   document.forms[0].action="<?php echo $_SERVER[\'PHP_SELF\']?>?ascdesc="+ascdesc;'."\n");
	fwrite_encode( $fp,'   document.forms[0].submit();'."\n");
	fwrite_encode( $fp,'}'."\n");

	fwrite_encode( $fp,'</script>'."\n");
		
	fwrite_encode( $fp,$insertion_deb_moteur."\n" );
	
	fwrite_encode( $fp,'<center><?php if ($excel==1) {?><input type=button onclick=export_xls() value="<?php echo $bouton_xls?>">&nbsp;<?php }?><input type=button onclick=raz() value="<?php echo $reset?>">&nbsp;<?php if (mb_strstr($mod, "I")) {?><input type=button onclick=inserer() value="<?php echo $nouveau?>">&nbsp;<?php }?><input type=button onclick=rechercher(\'asc\') value="<?php echo $rechercher_asc?>">&nbsp;<input type=button onclick=rechercher(\'desc\') value="<?php echo $rechercher_desc?>">');
	fwrite_encode( $fp,'</center>'."\n");
}
fwrite_encode( $fp,'</form>'."\n");


fwrite_encode( $fp, "<?php\n" );
fwrite_encode( $fp,"//Creation dynamique de la requete SQL en fonction des criteres de recherche\n");

if (!empty($critere)){
	for ($i=0;$i<count($critere);$i++){
	
			if (db_type($type[$critere[$i]],$flags[$critere[$i]])=='int'){

				fwrite_encode( $fp,'if (!empty($'.$name[$critere[$i]].')){'."\n");
				fwrite_encode( $fp,'   $critere_tab=explode("-",$'.$name[$critere[$i]].');'."\n");
				fwrite_encode( $fp,'   if ($clause=="")'."\n");
				fwrite_encode( $fp,'      $clause = "where '.$name[$critere[$i]].'=$critere_tab[0]";'."\n");
				fwrite_encode( $fp,'   else'."\n");
				fwrite_encode( $fp,'      $clause = "$clause and '.$name[$critere[$i]].'=$critere_tab[0]";'."\n");
				fwrite_encode( $fp,'}'."\n");
			}
			else if (db_type($type[$critere[$i]],$flags[$critere[$i]])=='date'){
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
					fwrite_encode( $fp,'if (!empty($'.$name[$critere[$i]].'2)){'."\n");
					fwrite_encode( $fp,'      $clause = "$clause and '.$name[$critere[$i]].' < \'".date_to_us($'.$name[$critere[$i]].'2)."\'";'."\n");
					fwrite_encode( $fp,'}'."\n");					
				}
				else {
					fwrite_encode( $fp,'if (!empty($'.$name[$critere[$i]].'))'."\n");
					fwrite_encode( $fp,'   if ($clause=="")'."\n");
                                        fwrite_encode( $fp,'      $clause = "where '.$name[$critere[$i]].' like \'%".addslashes($'.$name[$critere[$i]].')."%\'";'."\n");
                                        fwrite_encode( $fp,'   else'."\n");
                                        fwrite_encode( $fp,'      $clause = "$clause and '.$name[$critere[$i]].' like \'%".addslashes($'.$name[$critere[$i]].')."%\'";'."\n");
					fwrite_encode( $fp,''."\n");
				}
	}
}


fwrite_encode( $fp,'$liste_tables="'.$table.'";'."\n");
if (!empty($rech_1an)){
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
				fwrite_encode( $fp,'     $'.$nom_1an_id.'=explode("|",$'.$nom_1an_id.');'."\n");
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
if (!empty($rech_nan)){
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
					fwrite_encode( $fp,'     $'.$col.'=explode("|",$'.$col.');'."\n");
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
fwrite_encode( $fp,'if (empty($ascdesc)) $ascdesc="desc";'."\n");

fwrite_encode( $fp,'$query= "select distinct '.$table.'.'.$nom_id.' $liste_des_colonnes from $liste_tables $clause order by $criteres_tri $ascdesc";'."\n");
fwrite_encode( $fp,'?>'."\n");
fwrite_encode( $fp,$insertion_boucle_moteur."\n" );
fwrite_encode( $fp,'<?php'."\n");
for ($i=0;$i<count($tables);$i++){
	if (!empty($tables[$i])){
		fwrite_encode( $fp,'$pk_table["'.$name[$i].'"]="'.$tables[$i].'"'.";\n");
	}
}

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


if ((!empty($navigation)&&(!empty($CIF)))||(!empty($navigation2))){
	$CIF2=explode("\r\n",$CIF);
	if (!empty($CIF2[0])){
		for ($i=0;$i<count($CIF2);$i++){
			fwrite_encode( $fp,'$tab_liens['.$i.']="'.$CIF2[$i].'";'."\n");
		}
		$z=count($CIF2);
	}
	else
		$z=0;

	if (!empty($navigation2)){
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
	//empeche l'affichage du resultat la 1ere fois
	fwrite_encode( $fp,'if (isset($lancer_rech)&&$lancer_rech==1)'."\n");
	fwrite_encode( $fp,'   $result = execute_select($query,$mod,$tab_liens,'."'$nom_id'".',$pk_table,0,$mod_tabulaire_moteur,$all_lignes);'."\n");
}
else{
	//empeche l'affichage du resultat la 1ere fois
	fwrite_encode( $fp,'if (isset($lancer_rech)&&$lancer_rech==1)'."\n");
	fwrite_encode( $fp,'   $result = execute_select($query,$mod,0,"'.$nom_id.'",$pk_table,0,$mod_tabulaire_moteur,$all_lignes);'."\n");
}
fwrite_encode( $fp,'echo "</td></tr></table>";'.";\n");

fwrite_encode( $fp,'include("piedpage.php");'."\n");
fwrite_encode( $fp,'?>'."\n");
fwrite_encode( $fp,$insertion_fin_moteur."\n" );

fclose( $fp );
?>
</body>
</html>
