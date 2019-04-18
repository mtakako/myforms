<?php
include_once("var.inc.php");
include_once("encodage.inc.php");
include_once("functions.inc.php");
//mysqli_connect($host,$user,$password);
//mysqli_select_db($database);

$connexion=connexion($database);

$filename = $table."_config.".$extension;
print "Ecriture du fichier $filename <br>";
$fp = fopen( $filename, "w" ) or die("Impossible d'ouvrir $filename");

fwrite_encode( $fp,'<?php'."\n");
fwrite_encode( $fp,'$titre_formulaire="'.stripslashes($titre_formulaire).'";'."\n");
fwrite_encode( $fp,'$couleur_page="'.$couleur_page.'";'."\n");

fwrite_encode( $fp,'/******* Liste des noms des colonnes de la table******/'."\n");
for ($i=0;$i<count($label);$i++){
	fwrite_encode( $fp,'$tab_colonnes['.$i.']="'.stripslashes($name[$i]).'";'."\n");
}

fwrite_encode( $fp,'/******* Liste des noms des colonnes affichees******/'."\n");
for ($i=0;$i<count($label);$i++){
	fwrite_encode( $fp,'$label['.$i.']="'.stripslashes($label[$i]).'";'."\n");
}
fwrite_encode( $fp,'/******* Liste  des critere ******/'."\n");
for ($i=0;$i<count($critere);$i++){
	fwrite_encode( $fp,'$critere['.$i.']="'.stripslashes($critere[$i]).'";'."\n");
}
fwrite_encode( $fp,'/******* Liste des colonnes affichables ******/'."\n");
for ($i=0;$i<count($col_affichable);$i++){
	fwrite_encode( $fp,'$col_affichable['.$i.']="'.stripslashes($col_affichable[$i]).'";'."\n");
}
fwrite_encode( $fp,'/******* Liste des colonnes affichee par defaut ******/'."\n");
for ($i=0;$i<count($nu);$i++){
	fwrite_encode( $fp,'$nu['.$i.']="'.stripslashes($nu[$i]).'";'."\n");
}

fwrite_encode( $fp,'/******* Liste de la colonnes de tri ******/'."\n");
fwrite_encode( $fp,'$tri="'.$tri.'";'."\n");

fwrite_encode( $fp,'/******* Liste des colonnes avec editeur HTML ******/'."\n");
for ($i=0;$i<count($editeur);$i++){
	fwrite_encode( $fp,'$editeur['.$i.']="'.stripslashes($editeur[$i]).'";'."\n");
}

fwrite_encode( $fp,'/******* Liste des hauteurs de l editeur HTML ******/'."\n");
for ($i=0;$i<count($label);$i++){
	fwrite_encode( $fp,'$hauteur_editeur['.$i.']="'.stripslashes($hauteur_editeur[$i]).'";'."\n");
	fwrite_encode( $fp,'$largeur_editeur['.$i.']="'.stripslashes($largeur_editeur[$i]).'";'."\n");
}


fwrite_encode( $fp,'/******* Liste des colonnes photos ******/'."\n");
for ($i=0;$i<count($photos);$i++){
	fwrite_encode( $fp,'$photos['.$i.']="'.ucfirst(stripslashes($photos[$i])).'";'."\n");
}

fwrite_encode( $fp,'/******* Liste des colonnes fichiers ******/'."\n");
for ($i=0;$i<count($fichiers);$i++){
	fwrite_encode( $fp,'$fichiers['.$i.']="'.ucfirst(stripslashes($fichiers[$i])).'";'."\n");
}

fwrite_encode( $fp,'/******* Valeur par defaut des listes de validation ******/'."\n");
for ($i=0;$i<count($etapes);$i++){
	fwrite_encode( $fp,'$etapes['.$i.']="'.stripslashes($etapes[$i]).'";'."\n");
}
for ($i=0;$i<count($etapes);$i++){
	fwrite_encode( $fp,'$etapes2['.$i.']="'.stripslashes($etapes2[$i]).'";'."\n");
}
for ($i=0;$i<count($etapes);$i++){
	fwrite_encode( $fp,'$etapes3['.$i.']="'.stripslashes($etapes3[$i]).'";'."\n");
}

fwrite_encode( $fp,'/******* Liste des colonnes affiche dans la vue Utilisateur******/'."\n");
for ($i=0;$i<count($vue);$i++){
	fwrite_encode( $fp,'$vue['.$i.']="'.stripslashes($vue[$i]).'";'."\n");
}
fwrite_encode( $fp,'$vue_util_zone_vide="'.$vue_util_zone_vide.'";'."\n");


fwrite_encode( $fp,'/******* Liste des colonnes affiche dans la VIEW Admin ******/'."\n");
for ($i=0;$i<count($vue_admin);$i++){
	fwrite_encode( $fp,'$vue_admin['.$i.']="'.stripslashes($vue_admin[$i]).'";'."\n");
}
fwrite_encode( $fp,'$view_admin_zone_vide="'.$view_admin_zone_vide.'";'."\n");


fwrite_encode( $fp,'/******* Liste des colonnes affiche dans la page de MAJ ******/'."\n");
for ($i=0;$i<count($maj_cols);$i++){
	fwrite_encode( $fp,'$maj_cols['.$i.']="'.stripslashes($maj_cols[$i]).'";'."\n");
}

fwrite_encode( $fp,'/******* Liste des colonnes affiche dans la page de INS ******/'."\n");
for ($i=0;$i<count($ins_cols);$i++){
	fwrite_encode( $fp,'$ins_cols['.$i.']="'.stripslashes($ins_cols[$i]).'";'."\n");
}

fwrite_encode( $fp,'/******* Liste des colonnes affiche dans le tableau ******/'."\n");
for ($i=0;$i<count($tableau_ordre);$i++){
	fwrite_encode( $fp,'$tableau_ordre['.$i.']="'.stripslashes($tableau_ordre[$i]).'";'."\n");
}
for ($i=0;$i<count($tableau_ordre_admin);$i++){
	fwrite_encode( $fp,'$tableau_ordre_admin['.$i.']="'.stripslashes($tableau_ordre_admin[$i]).'";'."\n");
}
fwrite_encode( $fp,'$tableau_ordre_tri="'.stripslashes($tableau_ordre_tri).'";'."\n");
fwrite_encode( $fp,'$tableau_ordre_tri_colonnes="'.stripslashes($tableau_ordre_tri_colonnes).'";'."\n");


fwrite_encode( $fp,'/******* Valeur par defaut des zones en insertion ******/'."\n");
for ($i=0;$i<count($defauts);$i++){
	fwrite_encode( $fp,'$defauts['.$i.']=\''.stripslashes_guillemets($defauts[$i]).'\';'."\n");
}

fwrite_encode( $fp,'/******* Liste des noms des colonnes etrangeres ******/'."\n");
for ($i=0;$i<count($tables);$i++){
	fwrite_encode( $fp,'$tables['.$i.']="'.$tables[$i].'";'."\n");
}

fwrite_encode( $fp,'/******* Liste colonne cle des colonnes1 ******/'."\n");
for ($i=0;$i<count($cols1);$i++){
	fwrite_encode( $fp,'$cols1['.$i.']="'.$cols1[$i].'";'."\n");
}

fwrite_encode( $fp,'/******* Liste colonne affiche des colonnes2 ******/'."\n");
for ($i=0;$i<count($cols2);$i++){
	fwrite_encode( $fp,'$cols2['.$i.']="'.$cols2[$i].'";'."\n");
}

fwrite_encode( $fp,'/******* Liste des requetes pour une FK ******/'."\n");
for ($i=0;$i<count($label);$i++){
	fwrite_encode( $fp,'$req_fk['.$i.']="'.stripslashes($req_fk[$i]).'";'."\n");
}

fwrite_encode( $fp,'/******* Liste des attributs html a ajouter en INSERTION ******/'."\n");
for ($i=0;$i<count($label);$i++){
	fwrite_encode( $fp,'$attributs['.$i.']=\''.stripslashes_guillemets($attributs[$i]).'\';'."\n");
}
for ($i=0;$i<count($label);$i++){
	fwrite_encode( $fp,'$div_attributs['.$i.']=\''.stripslashes_guillemets($div_attributs[$i]).'\';'."\n");
}

fwrite_encode( $fp,'/******* Liste des attributs html a ajouter en EDITION ******/'."\n");
for ($i=0;$i<count($label);$i++){
	fwrite_encode( $fp,'$attributs_edit['.$i.']=\''.stripslashes_guillemets($attributs_edit[$i]).'\';'."\n");
}
for ($i=0;$i<count($label);$i++){
	fwrite_encode( $fp,'$div_attributs_edit['.$i.']=\''.stripslashes_guillemets($div_attributs_edit[$i]).'\';'."\n");
}

fwrite_encode( $fp,'/******* Liste des attributs html a ajouter dans la page de VUE ******/'."\n");
for ($i=0;$i<count($label);$i++){
	fwrite_encode( $fp,'$div_attributs_vue['.$i.']=\''.stripslashes_guillemets($div_attributs_vue[$i]).'\';'."\n");
}

fwrite_encode( $fp,'/******* Liste des attributs html a ajouter dans la page de VIEW ******/'."\n");
for ($i=0;$i<count($label);$i++){
	fwrite_encode( $fp,'$div_attributs_view['.$i.']=\''.stripslashes_guillemets($div_attributs_view[$i]).'\';'."\n");
}

fwrite_encode( $fp,'/******* Liste des actions de niveau 1 ******/'."\n");
for ($i=0;$i<count($actions1);$i++){
	fwrite_encode( $fp,'$actions1['.$i.']=\''.stripslashes_guillemets($actions1[$i]).'\';'."\n");
}

fwrite_encode( $fp,'/******* Liste des actions de niveau 2 ******/'."\n");
for ($i=0;$i<count($actions2);$i++){
	fwrite_encode( $fp,'$actions2['.$i.']=\''.stripslashes_guillemets($actions2[$i]).'\';'."\n");
}
fwrite_encode( $fp,'/******* Liste des actions de niveau 3 ******/'."\n");
for ($i=0;$i<count($actions3);$i++){
	fwrite_encode( $fp,'$actions3['.$i.']=\''.stripslashes_guillemets($actions3[$i]).'\';'."\n");
}

function ecrire_tableau($tableau,$num) {
	global $fp;
	if (!empty($tableau)){
		foreach ($tableau as $cle=>$valeur) {
			if(is_array($valeur)) {
				ecrire_tableau($valeur,$cle); 
			}
			else{
				fwrite_encode( $fp,'$diag_etats['.$num.']['.$cle.']="'.$valeur.'";'."\n"); 
			}
		}
	}
} 

fwrite_encode( $fp,'/******* Diagramme Etats ******/'."\n");
ecrire_tableau($diag_etats,'');

fwrite_encode( $fp,'/******* Gestion des insertions de PHP fichier specifique ******/'."\n");
fwrite_encode( $fp,'$insertion_deb_insertion=\''.stripslashes_guillemets($insertion_deb_insertion).'\';'."\n");
fwrite_encode( $fp,'$insertion_deb_edition=\''.stripslashes_guillemets($insertion_deb_edition).'\';'."\n");
fwrite_encode( $fp,'$insertion_tout_deb_moteur=\''.stripslashes_guillemets($insertion_tout_deb_moteur).'\';'."\n");
fwrite_encode( $fp,'$insertion_deb_moteur=\''.stripslashes_guillemets($insertion_deb_moteur).'\';'."\n");
fwrite_encode( $fp,'$insertion_deb_maj=\''.stripslashes_guillemets($insertion_deb_maj).'\';'."\n");
fwrite_encode( $fp,'$insertion_deb_vue=\''.stripslashes_guillemets($insertion_deb_vue).'\';'."\n");
fwrite_encode( $fp,'$insertion_deb_ins=\''.stripslashes_guillemets($insertion_deb_ins).'\';'."\n");
fwrite_encode( $fp,'$insertion_deb_view=\''.stripslashes_guillemets($insertion_deb_view).'\';'."\n");
fwrite_encode( $fp,'$insertion_deb_suivi_user=\''.stripslashes_guillemets($insertion_deb_suivi_user).'\';'."\n");
fwrite_encode( $fp,'$insertion_deb_suivi_admin=\''.stripslashes_guillemets($insertion_deb_suivi_admin).'\';'."\n");

fwrite_encode( $fp,'$insertion_fin_insertion=\''.stripslashes_guillemets($insertion_fin_insertion).'\';'."\n");
fwrite_encode( $fp,'$insertion_fin_edition=\''.stripslashes_guillemets($insertion_fin_edition).'\';'."\n");
fwrite_encode( $fp,'$insertion_fin_moteur=\''.stripslashes_guillemets($insertion_fin_moteur).'\';'."\n");
fwrite_encode( $fp,'$insertion_fin_maj=\''.stripslashes_guillemets($insertion_fin_maj).'\';'."\n");
fwrite_encode( $fp,'$insertion_fin_ins=\''.stripslashes_guillemets($insertion_fin_ins).'\';'."\n");

fwrite_encode( $fp,'$insertion_fin_vue=\''.stripslashes_guillemets($insertion_fin_vue).'\';'."\n");
fwrite_encode( $fp,'$insertion_fin_view=\''.stripslashes_guillemets($insertion_fin_view).'\';'."\n");
fwrite_encode( $fp,'$insertion_fin_suivi_user=\''.stripslashes_guillemets($insertion_fin_suivi_user).'\';'."\n");
fwrite_encode( $fp,'$insertion_fin_suivi_admin=\''.stripslashes_guillemets($insertion_fin_suivi_admin).'\';'."\n");

fwrite_encode( $fp,'$insertion_boucle_suivi_user=\''.stripslashes_guillemets($insertion_boucle_suivi_user).'\';'."\n");
fwrite_encode( $fp,'$insertion_boucle_suivi_admin=\''.stripslashes_guillemets($insertion_boucle_suivi_admin).'\';'."\n");
fwrite_encode( $fp,'$insertion_boucle_moteur=\''.stripslashes_guillemets($insertion_boucle_moteur).'\';'."\n");

fwrite_encode( $fp,'/******* Gestion des insertions de JS specifique ******/'."\n");
fwrite_encode( $fp,'$js_deb_insertion=\''.stripslashes_guillemets($js_deb_insertion).'\';'."\n");
fwrite_encode( $fp,'$js_deb_edition=\''.stripslashes_guillemets($js_deb_edition).'\';'."\n");
fwrite_encode( $fp,'$js_deb_maj=\''.stripslashes_guillemets($js_deb_maj).'\';'."\n");
fwrite_encode( $fp,'$js_deb_ins=\''.stripslashes_guillemets($js_deb_ins).'\';'."\n");
fwrite_encode( $fp,'$js_fonction_insertion=\''.stripslashes_guillemets($js_fonction_insertion).'\';'."\n");
fwrite_encode( $fp,'$js_fonction_edition=\''.stripslashes_guillemets($js_fonction_edition).'\';'."\n");
fwrite_encode( $fp,'$js_fonction_maj=\''.stripslashes_guillemets($js_fonction_maj).'\';'."\n");
fwrite_encode( $fp,'$js_fonction_ins=\''.stripslashes_guillemets($js_fonction_ins).'\';'."\n");

fwrite_encode( $fp,'/********************* Droits d affichage **************************/'."\n");
fwrite_encode( $fp,'$mod=\''.$mod.'\';'."\n");
fwrite_encode( $fp,'/*********** Taille du tableau des colonnes affichables ************/'."\n");

if (empty($nb_col_affichable)) $nb_col_affichable=3;
fwrite_encode( $fp,'$nb_col_affichable=\''.$nb_col_affichable.'\';'."\n");

fwrite_encode( $fp,'/******* Liste de relations 1 a n ******/'."\n");
fwrite_encode( $fp,'$CIF="'.$CIF.'";'."\n");
fwrite_encode( $fp,'$rech_1an="'.$rech_1an.'";'."\n");
fwrite_encode( $fp,'$navigation="'.$navigation.'";'."\n");

fwrite_encode( $fp,'/******* Liste de relations n a n ******/'."\n");
for ($i=0;$i<count($relation);$i++){
	fwrite_encode( $fp,'$relation['.$i.']="'.$relation[$i].'";'."\n");
}
for ($i=0;$i<count($association);$i++){
	fwrite_encode( $fp,'$association['.$i.']="'.$association[$i].'";'."\n");
}
for ($i=0;$i<count($table_fille);$i++){
	fwrite_encode( $fp,'$table_fille['.$i.']="'.$table_fille[$i].'";'."\n");
}
for ($i=0;$i<count($num_colonne2);$i++){
        fwrite_encode( $fp,'$num_colonne2['.$i.']="'.$num_colonne2[$i].'";'."\n");
}
for ($i=0;$i<count($num_colonne2_fk);$i++){
        fwrite_encode( $fp,'$num_colonne2_fk['.$i.']="'.$num_colonne2_fk[$i].'";'."\n");
}
fwrite_encode( $fp,'/******* Valeur par defaut des listes de validation ******/'."\n");
for ($i=0;$i<count($etapesnan);$i++){
	fwrite_encode( $fp,'$etapesnan['.$i.']="'.stripslashes($etapesnan[$i]).'";'."\n");
}
for ($i=0;$i<count($etapesnan2);$i++){
	fwrite_encode( $fp,'$etapesnan2['.$i.']="'.stripslashes($etapesnan2[$i]).'";'."\n");
}
for ($i=0;$i<count($etapesnan3);$i++){
	fwrite_encode( $fp,'$etapesnan3['.$i.']="'.stripslashes($etapesnan3[$i]).'";'."\n");
}

fwrite_encode( $fp,'$mode_affichage_popup="'.$mode_affichage_popup.'";'."\n");
fwrite_encode( $fp,'$rech_nan="'.$rech_nan.'";'."\n");
fwrite_encode( $fp,'$sup_cascade="'.$sup_cascade.'";'."\n");
fwrite_encode( $fp,'$navigation2="'.$navigation2.'";'."\n");

/***************************************/


fwrite_encode( $fp,'$couleur_page="'.$couleur_page.'";'."\n");
fwrite_encode( $fp,'$bdd="'.$database.'";'."\n");
fwrite_encode( $fp,'$titre="'.$table.'";'."\n");

if (isset($excel)&&($excel==1)){
	fwrite_encode( $fp,'$excel=1;'."\n");
}


fwrite_encode( $fp,'/******* Liste des noms des colonnes des Formulaires insertion, mise a jour et vues ******/'."\n");
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
