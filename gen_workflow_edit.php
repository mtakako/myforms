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
include_once($table."_diag.php");
include_once($table."_config.php");
$connexion=connexion($database);

$req="select * from $table";
$result = execute_sql($req);

$filename = $table."_workflow_edit.".$extension;
print "Ecriture du fichier <a href=$filename>$filename</a> <br/>";
$fp = fopen( $filename, "w" ) or die("Impossible d'ouvrir $filename");
fwrite_encode($fp,'<meta http-equiv="X-UA-Compatible" content="IE=8" />'."\n");

fwrite_encode($fp, "<?php\n" );
fwrite_encode($fp,'include("'.$table.'_parametres.'.$extension.'");'."\n");
fwrite_encode($fp,'include("'.$table.'_diag.'.$extension.'");'."\n");
fwrite_encode($fp,"//Inclusion de la page entete qui inclue les variables et les fonctions.\n");

fwrite_encode($fp,'include("entete.php");'."\n");
fwrite_encode($fp,'$connexion=connexion($bdd);'."\n");
fwrite_encode($fp,'$table="'.$table.'";'."\n" );
fwrite_encode($fp,'if (empty($id)) exit();'."\n" );
fwrite_encode($fp, "?>\n" );

/* test pour savoir si on lance un update ou affiche le formulaire*/
fwrite_encode($fp, '<?php if (!isset($suite)){'."\n" );
fwrite_encode($fp, 'echo "<h2>$titreEdit $titre_formulaire I-$id </h2>";'."\n" );
fwrite_encode($fp, '?>'."\n" );

/* requete SQL pour recuperer les donnees et etat*/
fwrite_encode($fp,'<?php '."\n");
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
   fwrite_encode($fp,'$req='."\"select * from $table where $maclause\";\n" );
}
else{
   $maclause="$nom_id=".'$id';
   fwrite_encode($fp,'$req='."\"select * from $table where $maclause\";\n" );
}
fwrite_encode($fp,'include("session_workflow_edit.'.$extension.'");'."\n");

fwrite_encode($fp,'$ret=execute_sql($req);'."\n" );
fwrite_encode($fp,'$row = mysqli_fetch_row($ret);  '."\n");
fwrite_encode($fp,'?>'."\n");
fwrite_encode($fp,$insertion_deb_edition."\n" );

/* Recuperation du numero de colonne de etat*/
for ($i=0;$i<count($tab_colonnes);$i++){
	if ('etat'==$tab_colonnes[$i]){
		$i_etat=$i;
	}
}

/* Recuperation de l etat en cours */
fwrite_encode($fp,'<?php '."\n");
fwrite_encode($fp,'$etat_en_cours=$row['.$i_etat.'];'."\n");
//Recup de l etape a venir
fwrite_encode($fp,'$etape_en_cours=$tabetatstache[$etat_en_cours];'."\n");
fwrite_encode($fp,'?>'."\n");


$fields = mysqli_num_fields($result);
fwrite_encode($fp,"<!-- Fonction de verification de saisie des donnees -->\n" );
fwrite_encode($fp,'<script type="text/javascript">'."\n");
//insertion de code specifique
fwrite_encode($fp,$js_fonction_edition."\n" );

fwrite_encode($fp,'function valider(){'."\n");
$flags = db_field_direct_flags($result,0);

	if (mb_stristr($flags,'auto')){
		$i = 1;
	}
	else{
		$i = 0;
	}
	//Gestion du code Javascript
	while ($i < $fields) {
			$type  = db_field_direct_type($result, $i);
			$flags = db_field_direct_flags($result, $i);
			$nom_de_colonne =  db_field_direct_name($result, $i);

			if ($nom_de_colonne=='etat'){
				// ne rien faire en automatique, on ajoute ce code
				$i++;

	  			fwrite_encode($fp,'   if (getCheckedRadioValue("etat")==null){'."\n");
	  			fwrite_encode($fp,'       alert("Indiquer un Etat de validation.");'."\n");
	  			fwrite_encode($fp,'       document.forms[0].elements["etat"].focus();'."\n");
	  			fwrite_encode($fp,'       return;'."\n");
	  			fwrite_encode($fp,'     }'."\n");

				continue;
			}

			//Test de etape en cours pour valider la zone
			fwrite_encode($fp,'   if (("'.$etapes[$i].'"=="<?php echo $etape_en_cours?>")||("'.$etapes2[$i].'"=="<?php echo $etape_en_cours?>")||("'.$etapes3[$i].'"=="<?php echo $etape_en_cours?>")||("'.$etapes[$i].'"=="Tous")){'."\n");
			if (db_type($type,$flags)=='int'){
				fwrite_encode($fp,'      tab=document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value.split("|");'."\n");
				if (mb_stristr($flags,'not_null'))
					fwrite_encode($fp,'      if ((tab[0]=="")||(isNotInteger(tab[0]))){'."\n");
				else
					fwrite_encode($fp,'      if (isNotInteger(tab[0])){'."\n");
				fwrite_encode($fp,'         alert("Voir la saisie de la zone " + document.forms[0].elements[\''.$tab_colonnes[$i].'\'].name);'."\n");
				fwrite_encode($fp,'         document.forms[0].elements[\''.$tab_colonnes[$i].'\'].focus();'."\n");
				fwrite_encode($fp,'         return;'."\n");
				fwrite_encode($fp,'      }'."\n");
			}
			elseif (db_type($type,$flags)=='real'){
				fwrite_encode($fp,'      tab=document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value.split("|");'."\n");
				if (mb_stristr($flags,'not_null'))
					fwrite_encode($fp,'      if ((tab[0]=="")||(isNaN(tab[0]))){'."\n");
				else
					fwrite_encode($fp,'      if (isNaN(tab[0])){'."\n");
				fwrite_encode($fp,'         alert("Voir la saisie de la zone " + document.forms[0].elements[\''.$tab_colonnes[$i].'\'].name);'."\n");
				fwrite_encode($fp,'         document.forms[0].elements[\''.$tab_colonnes[$i].'\'].focus();'."\n");
				fwrite_encode($fp,'         return;'."\n");
				fwrite_encode($fp,'      }'."\n");
			}

			else if (db_type($type,$flags)=='enum'){
				if (mb_stristr($flags,'not_null')){
					fwrite_encode($fp,'      tmp=0;'."\n");
					fwrite_encode($fp,'      for (var i=0; i<document.forms[0].elements[\''.$tab_colonnes[$i].'\'].length;i++) {'."\n");
					fwrite_encode($fp,'         if (document.forms[0].elements[\''.$tab_colonnes[$i].'\'][i].checked) {'."\n");
					fwrite_encode($fp,'            tmp=1;'."\n");
					fwrite_encode($fp,'         }'."\n");
					fwrite_encode($fp,'      }'."\n");
					fwrite_encode($fp,'      if (document.forms[0].elements[\''.$tab_colonnes[$i].'\'].checked) {'."\n");
					fwrite_encode($fp,'         tmp=1;'."\n");
					fwrite_encode($fp,'      }'."\n");					
					fwrite_encode($fp,'      if (tmp==0){'."\n");
					fwrite_encode($fp,'         alert("Voir la saisie de la zone '.$tab_colonnes[$i].'");'."\n");
					fwrite_encode($fp,'         document.forms[0].elements[\''.$tab_colonnes[$i].'\'][0].focus();'."\n");
					fwrite_encode($fp,'         return;'."\n");
					fwrite_encode($fp,'      }'."\n");
				}
			}
			else if (db_type($type,$flags)=='set'){
				if (mb_stristr($flags,'not_null')){
					fwrite_encode($fp,'      tmp=0;'."\n");
					fwrite_encode($fp,'      for (var i=0; i<document.forms[0].elements[\''.$tab_colonnes[$i].'[]\'].length;i++) {'."\n");
					fwrite_encode($fp,'         if (document.forms[0].elements[\''.$tab_colonnes[$i].'[]\'][i].checked) {'."\n");
					fwrite_encode($fp,'            tmp=1;'."\n");
					fwrite_encode($fp,'         }'."\n");
					fwrite_encode($fp,'      }'."\n");
					fwrite_encode($fp,'      if (tmp==0){'."\n");
					fwrite_encode($fp,'         alert("Voir la saisie de la zone '.$tab_colonnes[$i].'");'."\n");
					fwrite_encode($fp,'         document.forms[0].elements[\''.$tab_colonnes[$i].'\'][0].focus();'."\n");
					fwrite_encode($fp,'         return;'."\n");
					fwrite_encode($fp,'      }'."\n");
				}
			}
			else if (db_type($type,$flags)=='date'){
				if (mb_stristr($flags,'not_null'))
					fwrite_encode($fp,'      if ((document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value=="")||(CheckDate(document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value)==0)){'."\n");
				else
					fwrite_encode($fp,'      if (CheckDate(document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value)==0){'."\n");
				fwrite_encode($fp,'         alert("Voir la saisie de la zone '.$tab_colonnes[$i].'");'."\n");
				fwrite_encode($fp,'         document.forms[0].elements[\''.$tab_colonnes[$i].'\'].focus();'."\n");
				fwrite_encode($fp,'         return;'."\n");
				fwrite_encode($fp,'      }'."\n");
			}
			else if (isset($photos)&&in_array($i,$photos)){
				// ne rien faire
			}
			else if (isset($fichiers)&&in_array($i,$fichiers)){
			// ne rien faire
			}
			else  if (mb_stristr($flags,'not_null')){
				fwrite_encode($fp,'      if (document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value==""){'."\n");
				fwrite_encode($fp,'         alert("Renseigner la zone " + document.forms[0].elements[\''.$tab_colonnes[$i].'\'].name);'."\n");
				fwrite_encode($fp,'         document.forms[0].elements[\''.$tab_colonnes[$i].'\'].focus();'."\n");
				fwrite_encode($fp,'         return;'."\n");
				fwrite_encode($fp,'      }'."\n");
			}
			
			//Si format de type heure
			if (mb_stristr($nom_de_colonne,'heure')){
				fwrite_encode($fp,'      if (validation_heure(document.forms[0].elements[\''.$tab_colonnes[$i].'\'])){'."\n");
				fwrite_encode($fp,'         document.forms[0].elements[\''.$tab_colonnes[$i].'\'].focus();'."\n");
				fwrite_encode($fp,'         return;'."\n");
				fwrite_encode($fp,'      }'."\n");
			}
			
			//Fin de Test de l'etat pour valider la zone
			fwrite_encode($fp,'   }'."\n");
		//}
		$i++;
	}
//}

fwrite_encode($fp,$js_deb_edition."\n" );


fwrite_encode($fp,'   document.forms[0].action="<?php echo $PHP_SELF;?>?suite=1"'.";\n");
fwrite_encode($fp,'   if (confirm("Voulez-vous confirmer votre saisie ?")){'."\n");

//Ajout de la selection des options de liste dans les relations n a n avant la validation du formulaire
for ($w=0;$w<5;$w++){
    if (!empty($table_fille[$w])){
        list($nom_table_relation,$col_relation_depart)=explode(".",$association[$w]);
        fwrite_encode($fp,'   if (("'.$etapesnan[$w].'"=="<?php echo $etape_en_cours?>")||("'.$etapesnan2[$w].'"=="<?php echo $etape_en_cours?>")||("'.$etapesnan3[$w].'"=="<?php echo $etape_en_cours?>")||("'.$etapesnan[$w].'"=="Tous")){'."\n");
        fwrite_encode($fp,'<?php if ($affiche_popup==0){'."\n");
        fwrite_encode($fp,"echo 'soumettre_1liste(document.forms[0].elements[\'$col_relation_depart"."[]\']);';\n" );
        fwrite_encode($fp,"}?>\n" );
        fwrite_encode($fp,'}'."\n");
    }
}

fwrite_encode($fp,'      document.forms[0].submit();'."\n");
fwrite_encode($fp,'   }'."\n");
fwrite_encode($fp,'}'."\n");

fwrite_encode($fp,'</script> '."\n");


// Gestion de FCK
if (isset($editeur)){
   fwrite_encode($fp,'<script type="text/javascript" src="./fckeditor.js"></script>'."\n");
   fwrite_encode($fp,'<script type="text/javascript">'."\n");

   fwrite_encode($fp,'window.onload = function()'."\n");
   fwrite_encode($fp,'{'."\n");
   fwrite_encode($fp,'	var sBasePath = document.location.href.substring(0,document.location.href.lastIndexOf("'.$filename.'"));'."\n");

   for ($l=0;$l<sizeof($editeur);$l++){
	  fwrite_encode($fp,'      if (document.forms[0].elements[\''.$tab_colonnes[$editeur[$l]].'\']!=null){'."\n");
	  fwrite_encode($fp,'	var oFCKeditor'.$l.' = new FCKeditor("'.$tab_colonnes[$editeur[$l]].'","'.$largeur_editeur[$editeur[$l]].'","'.$hauteur_editeur[$editeur[$l]].'");'."\n");
	  fwrite_encode($fp,'	oFCKeditor'.$l.'.BasePath	= sBasePath ;'."\n");
	  fwrite_encode($fp,'	oFCKeditor'.$l.'.ToolbarSet	= "Basic" ;'."\n");
	  fwrite_encode($fp,'	oFCKeditor'.$l.'.ReplaceTextarea() ;'."\n");
	  fwrite_encode($fp,'      }'."\n");
   }
   fwrite_encode($fp,'}'."\n");
   fwrite_encode($fp,'</script>'."\n");
}

fwrite_encode($fp,"<!-- Formulaire de mise a jour des donnees-->\n" );
fwrite_encode($fp,"<form name=\"formulaire\" action=\"$filename\" enctype=\"multipart/form-data\" method=\"post\">\n" );

fwrite_encode($fp,'<div class="tableform">'."\n");

$flags = db_field_direct_flags($result,0);
if (mb_stristr($flags,'auto')){
   $i = 1;
}
else{
   $i = 0;
}
$num_gen=0; //numero de la zone de saisie pour l'editeur html
// Gestion du label et des zones de saisie
while ($i < $fields) {
   $type  = db_field_direct_type($result, $i);
   $nom  = db_field_direct_name($result, $i);
   $len   = db_field_direct_len($result, $i);
   //$len++; //on augmente un peu la taille par precaution
   $flags = db_field_direct_flags($result, $i);
	if ($nom=='etat'){
		// ne rien faire, pas de label car on le rajoute a la fin du formulaire
		$i++;
		continue;
	}
	if ($etapes[$i]!="Aucun"){
		fwrite_encode($fp,'<?php'."\n");
		fwrite_encode($fp,'$style=\'style=visibility:hidden;display:none\';'."\n");
		fwrite_encode($fp,'if ("'.$etapes[$i].'"=="Tous"){'."\n");
		fwrite_encode($fp,'   $style=\'\';'."\n");
		fwrite_encode($fp,'}'."\n");
		fwrite_encode($fp,'elseif ("'.$etapes[$i].'"=="Invisible"){'."\n");
		fwrite_encode($fp,'   $style=\'style=visibility:hidden;display:none\';'."\n");
		fwrite_encode($fp,'}'."\n");
		fwrite_encode($fp,'elseif (("'.$etapes[$i].'"==$etape_en_cours)||("'.$etapes2[$i].'"==$etape_en_cours)||("'.$etapes3[$i].'"==$etape_en_cours)){'."\n");
		fwrite_encode($fp,'   $style=\'\';'."\n");
		fwrite_encode($fp,'}'."\n");
		fwrite_encode($fp,'elseif ($row['.$i.']=="0000-00-00"){'."\n");
		fwrite_encode($fp,'   $style=\'style=visibility:hidden;display:none\';'."\n");
		fwrite_encode($fp,'}'."\n");
		fwrite_encode($fp,'elseif (!empty($row['.$i.'])){'."\n");
		fwrite_encode($fp,'   $style=\'\';'."\n");
		fwrite_encode($fp,'}'."\n");
		fwrite_encode($fp,'?>'."\n");

		fwrite_encode($fp,'<div style="<?php echo $style?>" '.$div_attributs_edit[$i].' class=trform>'."\n" );
		
		$remarque ="";
		//Si format de type heure
		if (mb_stristr($nom,'heure')){
			$remarque =" [00:00]";
		}
		elseif (mb_stristr($nom,'date_')){
			$remarque =" [00/00/0000]";
		}
		
		if (mb_stristr($flags,'not_null')){
			if (isset($label)&&(!empty($label)))
				fwrite_encode($fp,'<div class=tdform><?php echo $label['.$i.']?>'.$remarque.'<font color=red>(*)</font></div>'."\n" );
			else
				fwrite_encode($fp, '<div class=tdform>'.$nom.$remarque." <font color=red>(*)</color></div>\n" );
		}
		else{
			if (isset($label)&&(!empty($label)))
				fwrite_encode($fp,'<div class=tdform>'.'<?php echo $label['.$i.']?>'.$remarque.'</div>'."\n" );
			else
				fwrite_encode($fp,'<div class=tdform>'.$nom.$remarque."</div>\n" );
		}

		$fk="";
		if (!empty($tables[$i])){
		$nom_fk=explode(".",$tables[$i]);
		$fk=$nom_fk[0];
		}

	// Gestion de elements du formulaire
		fwrite_encode($fp,'<?php if (("'.$etapes[$i].'"==$etape_en_cours)||("'.$etapes2[$i].'"==$etape_en_cours)||("'.$etapes3[$i].'"==$etape_en_cours)||("'.$etapes[$i].'"=="Tous")||("'.$etapes[$i].'"=="Invisible")){?>'."\n");

		$visible="";
		if ($etapes[$i]=='Invisible') $visible='style=\"visibility:hidden;display:none\"';
		
                fwrite_encode($fp,'<?php echo "<div '.$visible.' class=\"$visible tdform tdfinform tdfin'.$i.'\">";?>'."\n");
		

		if (empty($fk)){
				//debut 2eme TD avec les input
			if (isset($photos)&&in_array($i,$photos)){
				//MdB gestion de photos 02/07/03
				fwrite_encode($fp,'<?php if (!empty($row['.$i.'])){'."\n");
				fwrite_encode($fp,"   echo \"<input $attributs_edit[$i] style=background-color:$couleur_protege; onFocus=blur() type=hidden ".'value=\"$row['.$i.']\"'." name=$name".'_photo'.">\";\n");
				fwrite_encode($fp,"   echo \"<input style=background-color:$couleur_protege; onFocus=blur()  type=hidden ".'value=\"$row['.$i.']\"'." name=$name".'_photo_sav'.">\";\n");

				if (!mb_stristr($flags,'not_null')){
					fwrite_encode($fp,'   echo "&nbsp;<a href=\"javascript:del_image(document.forms[0].elements[\''.$nom.'_photo\'],\''.$nom.'\')\"><img src=./images/del.gif></a>";'."\n");
				}

				fwrite_encode($fp,"}\n");
				fwrite_encode($fp,"else{\n");
				fwrite_encode($fp,"   echo \"<input style=background-color:$couleur_protege; onFocus=blur() type=hidden ".'value=\"$row['.$i.']\"'." name=$name".'_photo'.">\";\n");
				fwrite_encode($fp,"}\n");
                                fwrite_encode($fp,'   $fichier=$rep.\'/'.$table.'-\'.$row[0].\'-\'.\''.$nom.'\'."-".$row['.$i.'];'."\n");
				fwrite_encode($fp,'   echo "&nbsp;<a target=_blank href=\"$fichier\"><img src=\"$fichier\" id=\"'.$nom.'\" class=\"output_image\"/></a><br />";'."\n");
				fwrite_encode($fp,"echo \"<input $attributs_edit[$i] type=file ".'value=\"$row['.$i.']\"'." name=$nom onchange='preview_image(event,this)'>\";?>\n");				
			}
			elseif (isset($fichiers)&&in_array($i,$fichiers)){
				//MdB gestion des fichiers 13/10/12
				fwrite_encode($fp,'<?if (!empty($row['.$i.'])){'."\n");
				fwrite_encode($fp,"   echo \"<input $attributs_edit[$i] style=background-color:$couleur_protege; onFocus=blur() type=text ".'value=\"$row['.$i.']\"'." name=$nom".'_fichier'.">\";\n");
				fwrite_encode($fp,"   echo \"<input $attributs_edit[$i] style=background-color:$couleur_protege; onFocus=blur()  type=hidden ".'value=\"$row['.$i.']\"'." name=$nom".'_fichier_sav'.">\";\n");
				if (!mb_stristr($flags,'not_null')){
					fwrite_encode($fp,'   echo "&nbsp;<a href=\"javascript:del_image(document.forms[0].elements[\''.$nom.'_fichier\'])\"><img src=./images/del.gif></A>";'."\n");
				}

				fwrite_encode($fp,'   $fichier=$rep.\'/'.$table.'-\'.$row[0].\'-\'.\''.$nom.'\'."-".$row['.$i.'];'."\n");
				fwrite_encode($fp,'   echo "&nbsp;<a target=_blank href=\"$fichier\">Voir</a><br />";'."\n");

				fwrite_encode($fp,"}\n");
				fwrite_encode($fp,"else{\n");
				fwrite_encode($fp,"   echo \"<input style=background-color:$couleur_protege; onFocus=blur() type=hidden ".'value=\"$row['.$i.']\"'." name=$nom".'_image'.">\";\n");
				fwrite_encode($fp,"}\n");
				fwrite_encode($fp,"echo \"<input $attributs_edit[$i] type=file ".'value=\"$row['.$i.']\"'." name=$nom>\";?>\n");
			}
			elseif (db_type($type,$flags)=='date'){
					fwrite_encode($fp,"<?php echo \"<input $attributs_edit[$i] class='w16em dateformat-d-sl-m-sl-Y' id='$nom' type=text size=12 maxlength=$len ".'value=\"$row['.$i.']\"'." name=$nom>\";?>\n");
					fwrite_encode($fp,"\n".'<script type="text/javascript">'."\n");

					if (!empty($defauts[$i])){

                                        fwrite_encode($fp,"\n".'<?php'."\n");
                                        fwrite_encode($fp,'if (empty($row['.$i."])) echo \"document.forms[0].$nom.value=".$defauts[$i].";\";\n");
                                        fwrite_encode($fp,"\n".'?>'."\n");
					}
					else{
					fwrite_encode($fp,"if ((document.forms[0].$nom.value=='0000-00-00')||(document.forms[0].$nom.value=='')) document.forms[0].$nom.value=date_jour();\n");
					}
					fwrite_encode($fp,"</script>\n");
			}
			elseif (db_type($type,$flags)=='enum'){
					fwrite_encode($fp,"<?php\n");
					fwrite_encode($fp,'$attribut_html="'.$attributs_edit[$i]."\";\n");
					fwrite_encode($fp,"enum_option('$nom','$table',\"".'$row['.$i."]\");\n");
					fwrite_encode($fp,'$attribut_html="";'."\n");
					fwrite_encode($fp,"?>\n");
			}
			elseif (db_type($type,$flags)=='set'){
					fwrite_encode($fp,"<?php\n");
					fwrite_encode($fp,'$attribut_html="'.$attributs_edit[$i]."\";\n");
					fwrite_encode($fp,"set_checkbox('$nom','$table',".'explode(",",$row['.$i.']));'."\n");
					fwrite_encode($fp,'$attribut_html="";'."\n");
					fwrite_encode($fp,"?>\n");

			}
			elseif ($len<=60){
					fwrite_encode($fp,"<?php echo \"<input ".$attributs_edit[$i]." type=text style='$visible'  size=$len maxlength=$len ".'value=\"".ret_base($row['.$i.'])."\"'." name=$nom>\";?>\n");
			}
			elseif (($len > 60)&&($len<=100)){
					fwrite_encode($fp,"<?php echo \"<input  ".$attributs_edit[$i]." type=text style='$visible'  size=70 maxlength=$len ".'value=\"".ret_base($row['.$i.'])."\"'." name=$nom>\";?>\n");
			}
			elseif (($len > 100)&&($len<=255)){
					fwrite_encode($fp,"<?php echo \"<textarea  ".$attributs_edit[$i]." style='$visible' name=$nom rows=3 cols=60".'>".ret_base($row['.$i.'])."'."</textarea>\";?>\n");
			}
			else{
					fwrite_encode($fp,"<?php echo \"<textarea  ".$attributs_edit[$i]." style='$visible' name=$nom rows=5 cols=60".'>".ret_base($row['.$i.'])."'."</textarea>\";?>\n");
			}
		}
		else {
			//gestion de l'affichage des popups
			$req="select * from $fk";
			$result1 = execute_sql($req);
			$nom_cols1= db_field_direct_name($result1,$cols1[$i]);
			$nom_cols2= db_field_direct_name($result1,$cols2[$i]);
			

			fwrite_encode($fp,"<?php\n" );
			fwrite_encode($fp,'$fk_tab=explode(".",$tables['.$i.']);'."\n" );
			fwrite_encode($fp,'$fk_table=$fk_tab[0];'."\n" );

			fwrite_encode($fp,'if ($affiche_popup==0)'."\n");
			fwrite_encode($fp, "   lister_table('$nom',".'$fk_table,$cols1['.$i.'],$cols2['.$i.'],$row['.$i.'],1,stripslashes($req_fk['.$i."]));\n" );
			fwrite_encode($fp,'if ($affiche_popup==1){'."\n");
			fwrite_encode($fp, "   lister_table('$nom',".'$fk_table,$cols1['.$i.'],$cols2['.$i.'],$row['.$i.'],1,stripslashes($req_fk['.$i."]));\n" );

			fwrite_encode($fp,'   echo "&nbsp;<a href=javascript:OuvrirPopup(\'$bdd\','."'$fk','$nom_cols1','$nom_cols2','1','','$nom'".')><img border=0 src=images/b_search.png alt=Details width=15 height=15></a>";'."\n");
			fwrite_encode($fp,"}\n" );
			fwrite_encode($fp,'if ($affiche_popup==2){'."\n");
			fwrite_encode($fp,'    echo "<input style=\'background-color:$couleur_protege;\' type=text onFocus=blur() size=30 value=\"".lister_id_libelle(\''.$nom_col1.'\',\''.$fk.'\','.$cols1[$i].','.$cols2[$i].',"$row['.$i.']")."\" name=\"'.$nom.'\">";'."\n");
			fwrite_encode($fp,'     echo "&nbsp;<a href=javascript:OuvrirPopup(\'$bdd\','."'$fk','$nom_cols1','$nom_cols2','1','','$nom'".')><img border=0 src=images/b_search.png alt=Details width=15 height=15></a>";'."\n");
			if (!mb_stristr($flags,"not_null"))
				fwrite_encode($fp,'     echo "&nbsp;<a href=javascript:raz(document.forms[0].elements[\''.$nom.'\'])><img border=0 src=images/gomme.gif alt=Effacer width=15 height=15></a>";'."\n");
			fwrite_encode($fp,"}\n" );
			fwrite_encode($fp,"?>\n" );
		}
		//fin de 2eme TD avec input
		fwrite_encode($fp,'</div>'."\n");

		// Gestion de l'affichage sans zone de saisie du contenu
		fwrite_encode($fp,'<?php'."\n");

		fwrite_encode($fp,"}\n" );
		fwrite_encode($fp,"else {\n" );
			//Debut 2eme TD juste le texte
			fwrite_encode($fp,'   echo "<div '.$div_attributs_edit[$i].' class=\"tdform tdfinform tdfin'.$i.'\">";'."\n");

			if (empty($fk)){
				if (isset($photos)&&in_array($i,$photos)){
					fwrite_encode($fp,'   $fichier=$rep.\'/'.$table.'-\'.$row[0].\'-\'.\''.$nom.'\'."-".$row['.$i.'];'."\n");
					fwrite_encode($fp,'   echo $row['.$i.'].&nbsp;<a target=_blank href=\"$fichier\">Voir</a><br />";'."\n");
				}
				elseif (isset($fichiers)&&in_array($i,$fichiers)){
					fwrite_encode($fp,'   $fichier=$rep.\'/'.$table.'-\'.$row[0].\'-\'.\''.$nom.'\'."-".$row['.$i.'];'."\n");
					fwrite_encode($fp,'   echo $row['.$i.']."&nbsp;<a target=_blank href=\"$fichier\">Voir</a><br />";'."\n");
				}
				elseif (db_type($type,$flags)=='date'){
					fwrite_encode($fp,'   echo date_to_fr($row['.$i.']);'."\n");
				}
				else{
					if (isset($editeur)&&in_array($i,$editeur)){
						fwrite_encode($fp,'   echo $row['.$i.'];'."\n");
					}
					else {
						fwrite_encode($fp,'   echo ret_base_html($row['.$i.']);'."\n");
					}
					
					//Ajout d'une zone hidden pour les mails (afin d envoyer un mail de workflow)
					if (mb_stristr($nom,'mail')||mb_stristr($nom,'courriel')){
						fwrite_encode($fp,"echo \"<input type=hidden ".'value=\"".ret_base($row['.$i.'])."\"'." name=$nom>\";\n");
					}
				}
			}
			else {
				if (!empty($req_fk[$i])) {
					$result1 = execute_sql($req_fk[$i]);
					$nom_col1= db_field_direct_name($result1,$cols1[$i]);
					if (mb_stristr($req_fk[$i],'where')){
		                                $req_table_etrangere_tab=explode('order',$req_fk[$i]);
		                                $req_table_etrangere= $req_table_etrangere_tab[0]." and $nom_col1='".'$row['.$i."]'";
					}
					elseif (mb_stristr($req_fk[$i],'order')){
                                      	  $req_table_etrangere_tab=explode('order',$req_fk[$i]);
                                      	  $req_table_etrangere= $req_table_etrangere_tab[0]." where $nom_col1='".'$row['.$i."]'";
					}
					else{
						$req_table_etrangere=$req_fk[$i]." where $nom_col1='".'$row['.$i."]'";
					}
				}
				else {
					$req="select * from $fk";
					$result1 = execute_sql($req);
					$nom_col1= db_field_direct_name($result1,$cols1[$i]);
					//$nom_col2= db_field_direct_name($result1,$cols2[$i]);
					$req_table_etrangere="select * from $fk where $nom_col1='".'$row['.$i."]'";
				}
				fwrite_encode( $fp, "   echo lister_col_num_lib(\"$req_table_etrangere\",$cols2[$i]);\n");
				//Ajout d'une zone hidden pour les mails (afin d envoyer un mail de workflow)
				if (mb_stristr($nom,'mail')||mb_stristr($nom,'courriel')){
					fwrite_encode($fp,'   echo "<input type=hidden value=\""'.";\n");
					fwrite_encode( $fp, "   echo lister_col_num_lib(\"$req_table_etrangere\",$cols2[$i]);\n");
					fwrite_encode($fp,'   echo "\" name=\"'.$nom.'\">"'.";\n");
				}
			}


		// fin de 2eme TD texte
		fwrite_encode($fp,'echo "</div>";'."\n");
		fwrite_encode($fp,"}\n" );
		fwrite_encode($fp,"?>\n" );
		//fin de TR
		fwrite_encode($fp,"</div>\n" );
	}//fin du if si etat!=Aucun
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

        $res = execute_sql("select * from $val");
        $nom_nan_id  = db_field_direct_name($res, 0); //nom de la cle primaire 2
        
        $tab_liste_num_colonne2=explode(',',$num_colonne2[$w]);
        $nom_col2= db_field_direct_name($res,$tab_liste_num_colonne2[0]);

        
        if (!empty($tab_liste_num_colonne2[1])){
            $nom_autre_colonne= db_field_direct_name($res,$tab_liste_num_colonne2[1]);
            fwrite_encode($fp,"<?php\n" );
            fwrite_encode($fp,'$num_autre_colonne="'.$num_colonne2[$z]."\";\n");
            fwrite_encode($fp,"?>\n" );
        }
        else{
            $nom_autre_colonne=$nom_col2;
        }					
        
        fwrite_encode($fp,'<?php if (("'.$etapesnan[$w].'"==$etape_en_cours)||("'.$etapesnan2[$w].'"==$etape_en_cours)||("'.$etapesnan3[$w].'"==$etape_en_cours)||("'.$etapesnan[$w].'"=="Tous")||("'.$etapesnan[$w].'"=="Invisible")){?>'."\n");
        $visible="";
        if ($etapesnan[$w]=='Invisible') $visible='style="visibility:hidden;display:none"';
        fwrite_encode($fp,'<?php echo "<div '.$visible.' class=\"trform\">";?>'."\n");						
        fwrite_encode($fp, '<div class=tdform><?php echo ucfirst(mb_strtolower($relation_2pattes['.$w.']));?>'."</div>\n");
        fwrite_encode($fp,'<?php if (!isset($'.$nom_nan_id.')) $'.$nom_nan_id.'="";?>'."\n" );
        fwrite_encode($fp,'<div class="tdform tdfinform">'."\n");
        //gestion de l'affichage des popup avec checkbox
        fwrite_encode($fp,"<?php\n" );
        fwrite_encode($fp,'if ($affiche_popup==0){'."\n");
        fwrite_encode($fp,"\$reqini=\"select * from $val,$nom_table_relation where $val.$col=$nom_table_relation.$col_relation_depart and $nom_table_relation.$col_depart=\$id\";\n" );
        fwrite_encode($fp,"\$resultat_sql_ini=execute_sql(\$reqini);\n" );
        fwrite_encode($fp,"while(\$row_ini=mysqli_fetch_row(\$resultat_sql_ini)){\n" );
        fwrite_encode($fp,"   \$tab_ini[] = \$row_ini[0];\n" );
        fwrite_encode($fp,"}\n" );
        fwrite_encode($fp,"\$list_ini = @implode(',',\$tab_ini);\n" );

        fwrite_encode($fp,"if (empty(\$list_ini)) \$list_ini = 0;\n");

        $num_tri=$num_colonne2[$w]+1;
        fwrite_encode($fp,"\$reql1=\"select * from $val where $col not in (\$list_ini) \$$col"."_clause order by $num_tri\";\n" );
        fwrite_encode($fp,"\$resultat_sql_l1=execute_sql(\$reql1);\n" );
        fwrite_encode($fp,"echo '<table border=\"0\"><tr><th>Liste des options</th><th></th><th>Options choisies</th></tr>';\n" );
        fwrite_encode($fp,"echo '<tr><td style=\"text-align:center\"><select name=l1_$col_relation_depart size=\"10\" multiple>';\n" );
        
        fwrite_encode($fp,"while(\$row_l1=mysqli_fetch_row(\$resultat_sql_l1)){\n" );
        fwrite_encode($fp,"   echo \"<option value='\$row_l1[0]'>\"" );
        for ($u=0;$u<count($tab_liste_num_colonne2);$u++){
            fwrite_encode($fp,".tronquer(\$row_l1[$tab_liste_num_colonne2[$u]]).' '" );
        }
        fwrite_encode($fp,";\n" );                                        

        fwrite_encode($fp,"}\n" );
        fwrite_encode($fp,"echo '</select></td>';\n" );
        fwrite_encode($fp,"echo '<td style=\"text-align:center\">';\n" );
        fwrite_encode($fp,"echo '<input type=\"button\" value=\">>\" onclick=\"soumettre_1liste(document.forms[0].l1_$col_relation_depart);deplacer(document.forms[0].l1_$col_relation_depart,document.forms[0].elements[\'$col_relation_depart"."[]\'])\"><br/><br/>';\n" );
        fwrite_encode($fp,"echo '<input type=\"button\" value=\">\" onclick=deplacer(document.forms[0].l1_$col_relation_depart,document.forms[0].elements[\'$col_relation_depart"."[]\'])><br/><br/>';\n" );
        fwrite_encode($fp,"echo '<input type=\"button\" value=\"<\" onclick=\"deplacer(document.forms[0].elements[\'$col_relation_depart"."[]\'],document.forms[0].l1_$col_relation_depart)\"><br/><br/>';\n" );
        fwrite_encode($fp,"echo '<input type=\"button\" value=\"<<\" onclick=\"soumettre_1liste(document.forms[0].elements[\'$col_relation_depart"."[]\']);deplacer(document.forms[0].elements[\'$col_relation_depart"."[]\'],document.forms[0].l1_$col_relation_depart)\"><br/>';\n" );
        fwrite_encode($fp,"echo '<td style=\"text-align:center\"><select name=$col_relation_depart"."[] size=\"10\" multiple>';\n" );
        fwrite_encode($fp,"\$reql2=\"select * from $val,$nom_table_relation where $val.$col=$nom_table_relation.$col_relation_depart and $nom_table_relation.$col_depart=\$id order by $num_tri\";\n" );
        fwrite_encode($fp,"\$resultat_sql_l2=execute_sql(\$reql2);\n" );
        
        fwrite_encode($fp,"while(\$row_l2=mysqli_fetch_row(\$resultat_sql_l2)){\n" );
        fwrite_encode($fp,"   echo \"<option value='\$row_l2[0]'>\"" );
        for ($u=0;$u<count($tab_liste_num_colonne2);$u++){
            fwrite_encode($fp,".tronquer(\$row_l2[$tab_liste_num_colonne2[$u]]).' '" );
        }
        fwrite_encode($fp,";\n" );                                        
        fwrite_encode($fp,"}\n" );					
        fwrite_encode($fp,"echo '</select></td></tr></table>';\n" );
        fwrite_encode($fp,"}\n" );
        fwrite_encode($fp,'if ($affiche_popup==2){'."\n");
        fwrite_encode($fp,'   echo "<textarea style=\'background-color:$couleur_protege;\' rows=4 cols=40 name='.$col.'[] onClick=blur() onFocus=blur()>";'."\n" );
        fwrite_encode($fp,"   echo valeurs_nan(\$id,'$col_depart','$col_relation_depart','$col','$col','$nom_col2','$nom_table_relation','$val',$nom_autre_colonne);"."\n" );
        fwrite_encode($fp,'   echo "</textarea>";'."\n" );
        fwrite_encode($fp,'    echo "&nbsp;<a href=javascript:OuvrirPopup(\'$bdd\','."'$val','$nom_nan_id','$nom_col2','2','','$nom_nan_id','$table','$nom_autre_colonne'".')><img border=0 src=images/b_search.png alt=Details width=15 height=15></a>";'."\n");
        fwrite_encode($fp,'    echo "&nbsp;<a href=javascript:raz(document.forms[0].elements[\''.$nom_nan_id.'[]\'])><img border=0 src=images/poubelle.gif alt=Effacer width=15 height=15></a>";'."\n");
        fwrite_encode($fp,"}\n" );
        fwrite_encode($fp,"?>\n" );
        fwrite_encode($fp,"</div>\n" );
        fwrite_encode($fp,"</div>\n" );
        fwrite_encode($fp,"<?php } \n" );
        
        fwrite_encode($fp,"else {\n" ); // Affichage des valeurs de la table fille si il en a
        fwrite_encode($fp,'echo "<div class=\"trform\">";'."\n");	
        fwrite_encode($fp,'echo "<div class=tdform>".ucfirst(mb_strtolower($relation_2pattes['.$w.']));'."\n");
        fwrite_encode($fp,'echo "</div>";'."\n");                                                
        fwrite_encode($fp,'echo "<div class=\"tdform tdfinform\">";'."\n");                    
        fwrite_encode($fp,"\$reql2=\"select * from $val,$nom_table_relation where $val.$col=$nom_table_relation.$col_relation_depart and $nom_table_relation.$col_depart=\$id order by $num_tri\";\n" );
        fwrite_encode($fp,"\$resultat_sql_l2=execute_sql(\$reql2);\n" );
        
        fwrite_encode($fp,"while(\$row_l2=mysqli_fetch_row(\$resultat_sql_l2)){\n" );
        for ($u=0;$u<count($tab_liste_num_colonne2);$u++){
            fwrite_encode($fp," echo \$row_l2[$tab_liste_num_colonne2[$u]].'&nbsp;';\n" );
        }
        fwrite_encode($fp,'echo "<br />";'."\n");                    
        fwrite_encode($fp,"}\n" );			

        fwrite_encode($fp,'echo "</div>";'."\n");                    
        fwrite_encode($fp,'echo "</div>";'."\n");                    
        fwrite_encode($fp,"} ?>\n" );
    }
}


//insertion de la gestion de l etat de la fiche
fwrite_encode($fp,'<div '.$div_attributs_edit[$i_etat].' class=trform>'."\n" );
fwrite_encode($fp,'<div class="tdform">'."\n");

fwrite_encode($fp,"Etat <font color=red>(*)</font>\n");
fwrite_encode($fp,"</div>\n");
fwrite_encode($fp,'<div class="tdform tdfinform tdfin'.$i_etat.'">'."\n");
fwrite_encode($fp,'<?php enum_etats_suivants("etat", $etat_en_cours, "'.$attributs_edit[$i_etat].'");?>'."\n");
fwrite_encode($fp,"</div>\n");
fwrite_encode($fp,"</div>\n");


//Fin du tableau de div
fwrite_encode($fp,"</div>\n");



$req="select * from $table";
$result = execute_sql($req);
$nom_id  = db_field_direct_name($result, 0);
//fin de l'instance du generateur

fwrite_encode($fp,"<input type=hidden name=id value=".'<?php echo $id?>'.">\n");
$flags = db_field_direct_flags($result,0);
if (mb_stristr($flags,'auto'))
   fwrite_encode($fp,"<input type=hidden name=$nom_id value=".'<?php echo $id?>'.">\n");

fwrite_encode($fp,"<input type=hidden name=url_retour value=".'<?php echo $HTTP_REFERER?>'.">\n");

fwrite_encode($fp,'<br/><font color=red>(*) Zone obligatoire</font>'."\n" );
//affichage du bouton valider s'il y a encore des etats ensuite
fwrite_encode($fp,'<?php if (!empty($tabetats[$etat_en_cours])){?>'."\n");
fwrite_encode($fp,'<center><input type=button onClick=valider() value="<?php echo $updater;?>"></center>'."\n");
fwrite_encode($fp,'<?php }?>'."\n");

//affichage de l'objet cache contenant la where clause
fwrite_encode($fp,'<?php echo "<input type=hidden name=clause value=\"'.$maclause.'\">";?>'."\n" );
fwrite_encode($fp,'<?php echo "<input type=hidden name=\"i_etat\" value=\"$i_etat\">";?>'."\n" );
fwrite_encode($fp,'<?php echo "<input type=hidden name=\"desc_etat_en_cours\" value=\"$etat_en_cours\">";?>'."\n" );
fwrite_encode($fp,'<?php echo "<input type=hidden name=\"desc_etape_en_cours\" value=\"$etape_en_cours\">";?>'."\n" );
fwrite_encode($fp,"</form>\n");

//inclusion de code specifique
fwrite_encode($fp,$insertion_fin_edition."\n" );

fwrite_encode($fp,'<?php }'."\n" );
fwrite_encode($fp,'else{'."\n" );

$set="";
$req="select * from $table";
$result = execute_sql($req);
$fields = mysqli_num_fields($result);
$flags = db_field_direct_flags($result,0);
if (mb_stristr($flags,'auto')){
   $i = 1;
}
else{
   $i = 0;
}

fwrite_encode($fp,'$req_update="update '.$table.' set ";'."\n");
fwrite_encode($fp,'$set="";'."\n");

while ($i < $fields) {
	$nom  = db_field_direct_name($result, $i);
	$type  = db_field_direct_type($result, $i);
	$flags = db_field_direct_flags($result, $i);
	if ((db_type($type,$flags)=='int')||(db_type($type,$flags)=='real')){
		fwrite_encode($fp,'   $critere_tab=explode("|",$'.$nom.');'."\n");
		fwrite_encode($fp,'   $'.$nom.'=$critere_tab[0];'."\n");
	}
   	elseif (db_type($type,$flags)=='date'){
		fwrite_encode($fp,'   $'."$nom=date_to_us(".'$'."$nom);"."\n");
   	}
   	elseif (db_type($type,$flags)=='set'){
		fwrite_encode($fp,'   if (!empty($'.$nom.'))'."\n");
		fwrite_encode($fp,'      $'.$nom.'=implode(",",$'.$nom.');'."\n");
	}
	if (isset($photos)&&in_array(($i),$photos)){
		fwrite_encode($fp,'   if (("'.$etapes[$i].'"==$desc_etape_en_cours)||("'.$etapes2[$i].'"==$desc_etape_en_cours)||("'.$etapes3[$i].'"==$desc_etape_en_cours)||("'.$etapes[$i].'"=="Tous")){'."\n");

		fwrite_encode($fp,'   if (!empty($_FILES[\''.$nom.'\'][\'name\'])) {'."\n");
		fwrite_encode($fp,'      //gestion des insertions des photos'."\n");
		fwrite_encode($fp,'      if (!empty($'.$nom.'_photo)||($'.$nom.'_photo==" ")) {'."\n");
		fwrite_encode($fp,'         $nomDestination=\''.$table.'-\'.$id.\'-\'.\''.$nom.'\'."-".$'.$nom.'_photo_sav;'."\n");
		fwrite_encode($fp,'         @unlink($rep."/".$nomDestination);'."\n");
		fwrite_encode($fp,'      }'."\n");
		fwrite_encode($fp,'      $nomDestination=\''.$table.'-\'.$id.\'-\'.\''.$nom.'\'."-".nom_fichier($_FILES["'.$nom.'"]["name"]);'."\n");
		fwrite_encode($fp,'      if (copy($_FILES[\''.$nom.'\'][\'tmp_name\'], $rep."/".$nomDestination)) {'."\n");
		fwrite_encode($fp,'         //echo("<b>Fichier $nomDestination copie avec succes</b>");'."\n");
		fwrite_encode($fp,'         $'.$nom.'_maj=nom_fichier($_FILES[\''.$nom.'\'][\'name\']);'."\n");
		fwrite_encode($fp,'      } else {'."\n");
		fwrite_encode($fp,'         echo("<b>La copie du fichier $nomDestination a echoue...</b>");'."\n");
		fwrite_encode($fp,'      }'."\n");
		fwrite_encode($fp,'   }'."\n");
		fwrite_encode($fp,'   else{'."\n");
		fwrite_encode($fp,'      if ($'.$nom.'_photo=="") {'."\n");
		fwrite_encode($fp,'         $nomDestination=\''.$table.'-\'.$id.\'-\'.\''.$nom.'\'."-".$'.$nom.'_photo_sav;'."\n");
		fwrite_encode($fp,'         @unlink($rep."/".$nomDestination);'."\n");
		fwrite_encode($fp,'         $'.$nom.'_maj="";'."\n");
		fwrite_encode($fp,'      }'."\n");
		fwrite_encode($fp,'      if (!empty($'.$nom.'_photo)&& ($'.$nom.'_photo!=" ")) {'."\n");
		fwrite_encode($fp,'         $'.$nom.'_maj=$'.$nom.'_photo;'."\n");
		fwrite_encode($fp,'      }'."\n");
		fwrite_encode($fp,'   }'."\n");
		//fwrite_encode($fp,'   @unlink($_FILES["'.$nom.'"]["tmp_name"]);'."\n");

		fwrite_encode($fp,'   $set= $set."$virgule '.$nom."='\$".$nom.'_maj\'";'."\n");
		fwrite_encode($fp,'$virgule=\',\';'."\n");
		fwrite_encode($fp,'}'."\n");
	}
	elseif (isset($fichiers)&&in_array(($i),$fichiers)){
		fwrite_encode($fp,'   if (("'.$etapes[$i].'"==$desc_etape_en_cours)||("'.$etapes2[$i].'"==$desc_etape_en_cours)||("'.$etapes3[$i].'"==$desc_etape_en_cours)||("'.$etapes[$i].'"=="Tous")){'."\n");

		fwrite_encode($fp,'   if (!empty($_FILES[\''.$nom.'\'][\'name\'])) {'."\n");
		fwrite_encode($fp,'      //gestion des insertions des fichiers'."\n");
		fwrite_encode($fp,'      if (!empty($'.$nom.'_fichier)||($'.$nom.'_fichier==" ")) {'."\n");
		fwrite_encode($fp,'         $nomDestination=\''.$table.'-\'.$id.\'-\'.\''.$nom.'\'."-".$'.$nom.'_fichier_sav;'."\n");
		fwrite_encode($fp,'         @unlink($rep."/".$nomDestination);'."\n");
		fwrite_encode($fp,'      }'."\n");
		fwrite_encode($fp,'      $nomDestination=\''.$table.'-\'.$id.\'-\'.\''.$nom.'\'."-".nom_fichier($_FILES["'.$nom.'"]["name"]);'."\n");
		fwrite_encode($fp,'      if (copy($_FILES[\''.$nom.'\'][\'tmp_name\'], $rep."/".$nomDestination)) {'."\n");
		fwrite_encode($fp,'         //echo("<b>Fichier $nomDestination copie avec succes</b>");'."\n");
		fwrite_encode($fp,'         $'.$nom.'_maj=nom_fichier($_FILES[\''.$nom.'\'][\'name\']);'."\n");
		fwrite_encode($fp,'      } else {'."\n");
		fwrite_encode($fp,'         echo("<b>La copie du fichier $nomDestination a echoue...</b>");'."\n");
		fwrite_encode($fp,'      }'."\n");
		fwrite_encode($fp,'   }'."\n");
		fwrite_encode($fp,'   else{'."\n");
		fwrite_encode($fp,'      if ($'.$nom.'_fichier=="") {'."\n");
		fwrite_encode($fp,'         $nomDestination=\''.$table.'-\'.$id.\'-\'.\''.$nom.'\'."-".$'.$nom.'_fichier_sav;'."\n");
		fwrite_encode($fp,'         @unlink($rep."/".$nomDestination);'."\n");
		fwrite_encode($fp,'         $'.$nom.'_maj="";'."\n");
		fwrite_encode($fp,'      }'."\n");
		fwrite_encode($fp,'      if (!empty($'.$nom.'_fichier)&& ($'.$nom.'_fichier!=" ")) {'."\n");
		fwrite_encode($fp,'         $'.$nom.'_maj=$'.$nom.'_fichier;'."\n");
		fwrite_encode($fp,'      }'."\n");
		fwrite_encode($fp,'   }'."\n");
		//fwrite_encode($fp,'   @unlink($_FILES["'.$nom.'"]["tmp_name"]);'."\n");
		fwrite_encode($fp,'   $set= $set."$virgule '.$nom."='\$".$nom.'_maj\'";'."\n");
		fwrite_encode($fp,'$virgule=\',\';'."\n");
		fwrite_encode($fp,'}'."\n");
	}
	else{
		fwrite_encode($fp,'   if (("'.$etapes[$i].'"==$desc_etape_en_cours)||("'.$etapes2[$i].'"==$desc_etape_en_cours)||("'.$etapes3[$i].'"==$desc_etape_en_cours)||("'.$etapes[$i].'"=="Tous")||("'.$etapes[$i].'"=="Invisible")){'."\n");
		fwrite_encode($fp,'   $set= $set."$virgule '.$nom."=\".quote($".$nom.",'".$type."','".$flags."').slash(\$".$nom.',\''.$type.'\',\''.$flags."').quote($".$nom.",'".$type."','".$flags."');"."\n");
		fwrite_encode($fp,'$virgule=\',\';'."\n");
		fwrite_encode($fp,'}'."\n");
	}

	$i++;
}

fwrite_encode($fp,'$req_update=$req_update.$set." where ".$clause'.";\n" );
fwrite_encode($fp,'execute_sql($req_update);'."\n" );


/**************************** MAJ en cas de relation a 2 pattes ************************/
for ($z=0;$z<5;$z++){
    if (!empty($table_fille[$z])){
        list($nom_table_relation1,$col_asso1)=explode(".",$relation[$z]);
        $table_relation=explode("\r\n",$association[$z]);
        list($nom_table_relation,$col_asso)=explode(".",$table_relation[0]);
        list($val_tmp,$col_depart)=explode(".",$relation[$z]);

        fwrite_encode($fp,'   if (("'.$etapesnan[$z].'"==$desc_etape_en_cours)||("'.$etapesnan2[$z].'"==$desc_etape_en_cours)||("'.$etapesnan3[$z].'"==$desc_etape_en_cours)||("'.$etapesnan[$z].'"=="Tous")){'."\n");
        // supression des liens dans la table relation
        fwrite_encode($fp,'   $req="delete from '.$nom_table_relation.' where '.$col_depart.'=$id";'."\n" );
        fwrite_encode($fp,'   execute_sql($req);'."\n" );
        list($val,$col)=explode(".",$table_fille[$z]);
        $res = execute_sql("select * from $val");
        $nom_nan_id  = db_field_direct_name($res, 0); //nom de la cle primaire 2
        $nom_col2= db_field_direct_name($res,1);
        fwrite_encode($fp,'   if ($affiche_popup==2)'."\n");
        fwrite_encode($fp,'       $liens=explode("\\n",$'.$col_asso.'[0]);'."\n" );
        fwrite_encode($fp,'   if ($affiche_popup==0)'."\n");
        fwrite_encode($fp,'      $liens=$'.$col_asso.';'."\n" );
        fwrite_encode($fp,'   if ($liens[0]!="")'."\n");
        fwrite_encode($fp,'   for ($i=0;$i<count($liens);$i++){'."\n" );
        fwrite_encode($fp,'      $tab=explode("|",$liens[$i]);'."\n");
        fwrite_encode($fp,'      $lien_id=$tab[0];'."\n");
        fwrite_encode($fp,'      if($lien_id!=""){'."\n");
        fwrite_encode($fp,'        $req="insert into '.$nom_table_relation.'('.$col_asso1.','.$col_asso.')'.' values($id,$lien_id)";'."\n" );
        fwrite_encode($fp,'         execute_sql($req);'."\n" );
        fwrite_encode($fp,'      }'."\n" );
        fwrite_encode($fp,'   }'."\n" );
        fwrite_encode($fp,'}'."\n" );
    }
}





fwrite_encode($fp,'   if (mb_ereg(\''.$table.'\',$url_retour))'."\n" );
fwrite_encode($fp,'      $url_retour="'.$table.'_rech.php";'."\n" );

fwrite_encode($fp,'   echo "<br/><h2>$update_OK</h2>";'."\n" );

/******************* Deroulement des actions ********************/
for ($i=0;$i<count($lesetats);$i++){
	fwrite_encode($fp,'if ($etat=="'.$lesetats[$i].'"){'."\n");

	if (isset($actions1[$i])&&!empty($actions1[$i])){
		fwrite_encode($fp,$actions1[$i]."\n");
	}
	fwrite_encode($fp,'}'."\n");
}


$filename2 = $table."_vue.".$extension;
fwrite_encode($fp,'   include("'.$filename2.'");'."\n");

/*
fwrite_encode($fp,'   echo "<form action=$url_retour method=post>\n";'."\n" );
fwrite_encode($fp,'   echo "<script language=javascript>\n";'."\n" );
fwrite_encode($fp,'   echo "   function valider(){\n";'."\n" );
fwrite_encode($fp,'   echo "            document.forms[0].submit();\n";'."\n" );
fwrite_encode($fp,'   echo "   }\n";'."\n" );
fwrite_encode($fp,'   echo "   var tmp = setTimeout(\'valider()\',1000);\n";'."\n" );
fwrite_encode($fp,'   echo "</script>\n";'."\n" );
fwrite_encode($fp,'   echo "<input type=hidden name=pour_netscape>\n";'."\n" );
fwrite_encode($fp,'   echo "</form>\n";'."\n" );
*/
fwrite_encode($fp,'}'."\n" );
fwrite_encode($fp,'?>'."\n" );
//fwrite_encode($fp,'</form>'."\n" );
fwrite_encode($fp,'<?php'."\n" );
fwrite_encode($fp,'include("piedpage.php");'."\n");
fwrite_encode($fp,'?>'."\n" );

?>
</body>
</html>
