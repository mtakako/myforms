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

$connexion=connexion($database);

$filename = $table."_workflow_ins.".$extension;
print "Ecriture du fichier <a href=$filename>$filename</a> <br/>";
$fp = fopen( $filename, "w" ) or die("Impossible d'ouvrir $filename");

fwrite_encode($fp, "<?php\n" );
fwrite_encode($fp,'include("'.$table.'_parametres.'.$extension.'");'."\n");
fwrite_encode($fp,'include("'.$table.'_diag.'.$extension.'");'."\n");
fwrite_encode($fp,"//Inclusion de la page entete qui inclue les variables et les fonctions.\n");
fwrite_encode($fp,'include("entete.php");'."\n");
fwrite_encode($fp,'$connexion=connexion($bdd);'."\n");
fwrite_encode($fp,'if (!empty($mode_affichage_popup)) $affiche_popup=$mode_affichage_popup;'."\n");
fwrite_encode($fp,'$table="'.$table.'";'."\n" );
fwrite_encode($fp, "?>\n" );

fwrite_encode($fp, '<?php if (!isset($suite)){'."\n" );
fwrite_encode($fp, 'echo "<h2>$titreInsert $titre_formulaire </h2>";'."\n" );
fwrite_encode($fp, '?>'."\n" );
fwrite_encode($fp,$insertion_deb_insertion."\n" );

$req="select * from $table";
$result = execute_sql($req);
$fields = mysqli_num_fields($result);
fwrite_encode($fp,"<form name=\"formulaire\" method=\"post\" enctype=\"multipart/form-data\"><table border=\"0\">\n" );
fwrite_encode($fp,'<script type="text/javascript">'."\n");

fwrite_encode($fp,$js_fonction_insertion."\n" );

fwrite_encode($fp,'function valider(){'."\n");

//Gestion si la 1ere colonne est autoincrement
$flags = db_field_direct_flags($result,0);
if (mb_stristr($flags,'auto')){
	$i = 1;
}
else{
	$i = 0;
}
//Recup de la premiere etape
$etape_depart=$tabetatstache["START"];
//Gestion javascript des zones obligatoires
while ($i < $fields) {
	$type  = db_field_direct_type($result, $i);
	$flags = db_field_direct_flags($result, $i);
	$nom_de_colonne =  db_field_direct_name($result, $i);

	if ($nom_de_colonne=='etat'){
		// ne rien faire en automatique, on ajoute ce code
		$i++;

		$tabetats_suivants=explode('|',$tabetats[$etat_en_cours]);
		if (count($tabetats_suivants)==1){
			// Ne rien faire, pas de controle si 1 seul etat suivant
		}
		else{
			fwrite_encode($fp,'   if (getCheckedRadioValue("etat")==null){'."\n");
			fwrite_encode($fp,'       alert("Indiquer un Etat de validation.");'."\n");
			fwrite_encode($fp,'       document.forms[0].elements["etat"].focus();'."\n");
			fwrite_encode($fp,'       return;'."\n");
			fwrite_encode($fp,'     }'."\n");
		}
		continue;
	}


	if (($etapes[$i]==$etape_depart)||($etapes[$i]=='Tous')){
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
		else if (db_type($type,$flags)=='date'){
			if (mb_stristr($flags,'not_null'))
			fwrite_encode($fp,'      if ((document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value=="")||(CheckDate(document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value)==0)){'."\n");
			else
			fwrite_encode($fp,'      if (CheckDate(document.forms[0].elements[\''.$tab_colonnes[$i].'\'].value)==0){'."\n");
			fwrite_encode($fp,'         alert("Voir la saisie de la zone " + document.forms[0].elements[\''.$tab_colonnes[$i].'\'].name);'."\n");
			fwrite_encode($fp,'         document.forms[0].elements[\''.$tab_colonnes[$i].'\'].focus();'."\n");
			fwrite_encode($fp,'         return;'."\n");
			fwrite_encode($fp,'      }'."\n");
		}
		else if (db_type($type,$flags)=='enum'){
			if (mb_stristr($flags,'not_null')&&($tab_colonnes[$i]!='etat')){
				fwrite_encode($fp,'      tmp=0;'."\n");
				fwrite_encode($fp,'      for (var i=0; i<document.forms[0].elements[\''.$tab_colonnes[$i].'\'].length;i++) {'."\n");
				fwrite_encode($fp,'         if (document.forms[0].elements[\''.$tab_colonnes[$i].'\'][i].checked) {'."\n");
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
	}
	$i++;
}


fwrite_encode($fp,$js_deb_insertion."\n" );

fwrite_encode($fp,'   document.forms[0].action="<?php echo $PHP_SELF;?>?suite=1"'.";\n");
fwrite_encode($fp,'   if (confirm("Voulez-vous confirmer votre saisie ?")){'."\n");

//Ajout de la selection automatique des options de liste dans les relations n a n avant la validation du formulaire
//Sinon les options ne passent pas dans le formulaire suivant
//Relation a 2 pattes
for ($w=0;$w<5;$w++){
    if (!empty($table_fille[$w])){
        if (($etapesnan[$w]==$etape_depart)||($etapesnan[$w]=='Tous')){             
            list($nom_table_relation,$col_relation_depart)=explode(".",$association[$w]);
            fwrite_encode($fp,"<?php\n" );
            fwrite_encode($fp,'if ($affiche_popup==0){'."\n");
            fwrite_encode($fp,"echo 'soumettre_1liste(document.forms[0].elements[\'$col_relation_depart"."[]\']);';\n" );
            fwrite_encode($fp,"}?>\n" );
        }
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
		fwrite_encode($fp,'	var oFCKeditor'.$l.' = new FCKeditor("'.$tab_colonnes[$editeur[$l]].'","'.$largeur_editeur[$editeur[$l]].'","'.$hauteur_editeur[$editeur[$l]].'","Default","");'."\n");
		fwrite_encode($fp,'	oFCKeditor'.$l.'.BasePath	= sBasePath ;'."\n");
		fwrite_encode($fp,'	oFCKeditor'.$l.'.ToolbarSet	= "Basic" ;'."\n");
		fwrite_encode($fp,'	oFCKeditor'.$l.'.ReplaceTextarea() ;'."\n");
	}
	fwrite_encode($fp,'}'."\n");
	fwrite_encode($fp,'</script>'."\n");
}


$flags = db_field_direct_flags($result,0);
if (mb_stristr($flags,'auto')){
	$i = 1;
}
else{
	$i = 0;
}
$num_gen=0; //numero de la zone de saisie pour l'editeur html

// Gestion du label, puis des zones de saisie
while ($i < $fields) {
	$type  = db_field_direct_type($result, $i);
	$nom  = db_field_direct_name($result, $i);
	$len   = db_field_direct_len($result, $i);
	$flags = db_field_direct_flags($result, $i);
	if (($etapes[$i]==$etape_depart||$etapes[$i]=='Tous'||$etapes[$i]=='Invisible')&&($nom!='etat')){
                if ($etapes[$i]=='Invisible') $visible='style="visibility:hidden;display:none"';

		fwrite_encode($fp,"<div $visible $div_attributs[$i]>\n");
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
				fwrite_encode($fp,'<?php echo $label['.$i.']?>'.$remarque.'<font color=red>(*)</font> :'."<br/>\n");
			else
				fwrite_encode($fp,$nom.$remarque."<font color=red>(*)</font> :<br/>\n");
		}
		else{
			if (isset($label)&&(!empty($label)))
				fwrite_encode($fp,'<?php echo $label['.$i.']?>'.$remarque." :<br/>\n");
			else
				fwrite_encode($fp,$nom.$remarque." :<br/>\n");
		}
	}
	$fk="";
	if (!empty($tables[$i])){
		$nom_fk=explode(".",$tables[$i]);
		$fk=$nom_fk[0];
	}
	// Gestion de elements du formulaire
	if ($etapes[$i]==$etape_depart||$etapes[$i]=='Tous'||$etapes[$i]=='Invisible'){
		$visible="";
		if ($etapes[$i]=='Invisible') $visible='visibility:hidden;display:none';
		if (empty($fk)){
			if ($nom=='etat'){
				// ne rien faire
				$i_etat=$i;
			}
			elseif (isset($photos)&&in_array($i,$photos)){
				//MdB gestion de photos 02/07/03
				fwrite_encode($fp,"\n");				
                                fwrite_encode($fp,"<input $attributs[$i] accept='image/*' onchange='preview_image(event,this)' type=file name='$nom'>\n");
				fwrite_encode($fp,"<img class='output_image' id='$nom'/>\n");
				fwrite_encode($fp,"\n");
			}
			elseif (isset($fichiers)&&in_array($i,$fichiers)){
				//MdB gestion des fichiers 13/10/12
				fwrite_encode($fp,"\n");
				fwrite_encode($fp,"<input $attributs[$i] type=file name='$nom'>\n");
				fwrite_encode($fp,"\n");
			}
			elseif (db_type($type,$flags)=='date'){
				fwrite_encode($fp,"\n");
				fwrite_encode($fp,"<input $attributs[$i] class=\"w16em dateformat-d-sl-m-sl-Y\" type=text size=12 id='$nom' name='$nom'>\n");
				fwrite_encode($fp,'<script type="text/javascript">'."\n");
				if (!empty($defauts[$i])){
					fwrite_encode($fp,"document.forms[0].$nom.value=".$defauts[$i].";\n");
				}
				else{
					fwrite_encode($fp,"document.forms[0].$nom.value=date_jour();\n");
				}
				fwrite_encode($fp,"</script>\n");
				fwrite_encode($fp,"\n");
			}
			elseif (mb_stristr($flags, 'enum')){
				fwrite_encode($fp,"\n");
				$valeur_defaut=field_defaut($i);			
				fwrite_encode($fp,"<?php\n");
				fwrite_encode($fp,'$attribut_html="'.$attributs[$i]."\";\n");
				fwrite_encode($fp,"enum_option('$nom','$table',\"$valeur_defaut\");\n");
				fwrite_encode($fp,'$attribut_html="";'."\n");
				fwrite_encode($fp,"?>\n");
				fwrite_encode($fp,"\n");
			}
			elseif (mb_stristr($flags, 'set')){
				fwrite_encode($fp,"<?php\n");
				fwrite_encode($fp,'$attribut_html="'.$attributs[$i]."\";\n");
				fwrite_encode($fp,'$tab_valeur_defaut=array("'.field_defaut($i)."\");\n");
				fwrite_encode($fp,"set_checkbox('$nom','$table',".'$tab_valeur_defaut'.");\n");
				fwrite_encode($fp,'$attribut_html="";'."\n");
				fwrite_encode($fp,"?>\n");
			}
			elseif ($len<=60){
				fwrite_encode($fp,"\n");
				fwrite_encode($fp,"<input $attributs[$i] type=text style=\"$visible\" value=\"<?php echo \"$defauts[$i]\"?>\" size=$len maxlength=$len name=$nom>\n");
			}
			elseif (($len > 60)&&($len<=100)){
				fwrite_encode($fp,"\n");
				fwrite_encode($fp,"<input $attributs[$i] type=text style=\"$visible\" value=\"<?php echo \"$defauts[$i]\"?>\" size=70 maxlength=$len name=$nom>\n");
			}
			elseif (($len > 100)&&($len<=255)){
				fwrite_encode($fp,"\n");
				if (empty($defauts[$i])){
					fwrite_encode($fp,"<textarea $attributs[$i] style=\"$visible\" name=$nom rows=3 cols=60></textarea>\n");
				}
				else{
					fwrite_encode($fp,"<textarea $attributs[$i] style=\"$visible\" name=$nom rows=3 cols=60><?php echo $defauts[$i]?></textarea>\n");
				}
			}
			else{
				fwrite_encode($fp,"\n");
				if (empty($defauts[$i])){
					fwrite_encode($fp,"<textarea $attributs[$i] style=\"$visible\" name=$nom rows=5 cols=60></textarea>\n");
				}
				else{
					if (mb_stristr($defauts[$i], 'include') === FALSE) {
						fwrite_encode($fp,"<textarea $attributs[$i] style=\"$visible\" name=$nom rows=5 cols=60><?php echo $defauts[$i]?></textarea>\n");
					}
					else{
						fwrite_encode($fp,"<textarea $attributs[$i] style=\"$visible\" name=$nom rows=5 cols=60><?php $defauts[$i]?></textarea>\n");
					}
				}
			}
		}
		// Gestion des FK
		else{
			fwrite_encode($fp,'<?php if (!isset($'.$nom.')) $'.$nom.'="";?>'."\n");
			//gestion de l'affichage des popups
			$req="select * from $fk";
			$result1 = execute_sql($req);
			$nom_col1= db_field_direct_name($result1,$cols1[$i]);
			$nom_col2= db_field_direct_name($result1,$cols2[$i]);
			fwrite_encode($fp,"<?php\n" );
			fwrite_encode($fp,'if ($affiche_popup==0)'."\n");
			fwrite_encode($fp, "   lister_table('$nom','$fk',$cols1[$i],$cols2[$i],\"$defauts[$i]\",1,stripslashes(\$req_fk[$i]));\n" );
			fwrite_encode($fp,'if ($affiche_popup==2){'."\n");
			fwrite_encode($fp,'   echo "<input style=\'background-color:$couleur_protege;\' type=text onFocus=blur() size=30 value=\"$'.$nom.'\" name=\"'.$nom.'\">";'."\n");
			fwrite_encode($fp,'   echo "&nbsp;<a href=javascript:OuvrirPopup(\'$bdd\','."'$fk','$nom_col1','$nom_col2','1','','$nom'".')><img border=0 src=images/b_search.png alt=Details width=15 height=15></a>";'."\n");
			if (!mb_stristr($flags,"not_null"))
				fwrite_encode($fp,'     echo "&nbsp;<a href=javascript:raz(document.forms[0].elements[\''.$nom.'\'])><img border=0 src=images/poubelle.gif alt=Effacer width=15 height=15></a>";'."\n");
			fwrite_encode($fp,"}\n" );
			fwrite_encode($fp,"?>\n" );
		}
		fwrite_encode($fp,"</div>\n");
	}
	$i++;
}


// Gestion des relations a 2 pattes
for ($z=0;$z<5;$z++){
    if (!empty($table_fille[$z])){
        if (($etapesnan[$z]==$etape_depart||$etapesnan[$z]=='Tous'||$etapesnan[$z]=='Invisible')){
            if ($etapesnan[$z]=='Invisible') $visible='style="visibility:hidden;display:none"';
            fwrite_encode($fp,"<div $visible>\n");
            list($nom_table_relation,$col_relation_depart)=explode(".",$association[$z]);
            list($val,$col)=explode(".",$table_fille[$z]);
            $res = execute_sql("select * from $val");
            $nom_nan_id  = db_field_direct_name($res, 0); //nom de la cle primaire 2
            
            $tab_liste_num_colonne2=explode(',',$num_colonne2[$z]);
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

            fwrite_encode($fp, '<?php echo ucfirst(mb_strtolower($relation_2pattes['.$z.']));?>'."<br />\n");
            fwrite_encode($fp,'<?php if (!isset($'.$nom_nan_id.')) $'.$nom_nan_id.'="";?>'."\n" );
//   lister_table_multiple($nom_objet,$table,$nom_table_id,$col1,$col2,$defaut,$vide,$relation,$nom_tableini_id)
            //gestion de l'affichage des popup avec checkbox
            fwrite_encode($fp,"<?php\n" );
            fwrite_encode($fp,'if ($affiche_popup==0){'."\n");

            if (!empty($tab_liste_num_colonne2[1])){
                $num_tri=($tab_liste_num_colonne2[0]+1).','.($tab_liste_num_colonne2[1]+1);
            }
            else{
                $num_tri=$tab_liste_num_colonne2[0]+1;                                           
            }
                                                    
            
            fwrite_encode($fp,"\$reql1=\"select * from $val where 1=1 \$$col"."_clause order by $num_tri\";\n" );
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
            fwrite_encode($fp,"echo '</select></td></tr></table>';\n" );				
            fwrite_encode($fp,"}\n" );
            fwrite_encode($fp,'if ($affiche_popup==2){'."\n");
            fwrite_encode($fp,'   echo "<textarea style=\'background-color:$couleur_protege;\' rows=4 cols=40 name='.$col.'[] onClick=blur() onFocus=blur()></textarea>";'."\n" );
            fwrite_encode($fp,'    echo "&nbsp;<a href=javascript:OuvrirPopup(\'$bdd\','."'$val','$nom_nan_id','$nom_col2','2','','$nom_nan_id','$table','$nom_autre_colonne'".')><img border=0 src=images/b_search.png alt=Details width=15 height=15></a>";'."\n");
            fwrite_encode($fp,'    echo "&nbsp;<a href=javascript:raz(document.forms[0].elements[\''.$nom_nan_id.'[]\'])><img border=0 src=images/poubelle.gif alt=Effacer width=15 height=15></a>";'."\n");
            fwrite_encode($fp,"}\n" );
            fwrite_encode($fp,"?>\n" );

            fwrite_encode($fp,"</div>\n" );
        }
    }
}






//insertion de la gestion de l etat de la fiche
$tabetats_suivants=explode('|',$tabetats['START']);
if (count($tabetats_suivants)>1){
	fwrite_encode($fp,"<div ".$div_attributs[$i_etat].">Etat <font color=red>(*)</font> :<br/>\n");
}
fwrite_encode($fp,'<?php enum_etats_suivants("etat", "START", "'.$attributs[$i_etat].'");?>'."\n");
if (count($tabetats_suivants)>1){
	fwrite_encode($fp,"</div>\n");
}

//inclusion de code specifique
fwrite_encode($fp,$insertion_fin_insertion."\n" );

fwrite_encode($fp,'<?php'."\n" );
fwrite_encode($fp,'echo "<input type=hidden value=$HTTP_REFERER name=url_retour>";'."\n" );
fwrite_encode($fp,'?>'."\n" );

fwrite_encode($fp,'<br/><font color=red>(*) Zone obligatoire</font>'."\n" );
fwrite_encode($fp,'<center><input type=button onClick=valider() value="<?php echo $inserer;?>"></center>'."\n");
fwrite_encode($fp,'</form>'."\n" );


fwrite_encode($fp,'<?php'."\n" );
fwrite_encode($fp,'}'."\n" );
fwrite_encode($fp,'else{'."\n" );
$flags = db_field_direct_flags($result,0);
if (mb_stristr($flags,'auto')){
$i = 1;
}
else{
$i = 0;
}

$values="";
$cols="";


$num_fields = mysqli_num_fields($result);
while ($i < $num_fields) {
	$nom  = db_field_direct_name($result, $i);
	$type  = db_field_direct_type($result, $i);
	$flags = db_field_direct_flags($result, $i);

	//MdB gestion SQL Insertion
	if ($etapes[$i]==$etape_depart||$etapes[$i]=='Tous'||$etapes[$i]=='Invisible'){
		if ((db_type($type,$flags)=='int')||(db_type($type,$flags)=='real')){
			fwrite_encode($fp,'   $critere_tab=explode("|",$'.$nom.');'."\n");
			fwrite_encode($fp,'   $'.$nom.'=$critere_tab[0];'."\n");
		}
		elseif (db_type($type,$flags)=='set'){
			fwrite_encode($fp,'   if (!empty($'.$nom.'))'."\n");
			fwrite_encode($fp,'      $'.$nom.'=implode(",",$'.$nom.');'."\n");
		}
		elseif (db_type($type,$flags)=='date'){
			fwrite_encode($fp,'   $'."$nom=date_to_us(".'$'."$nom);"."\n");
		}

		if (empty($cols))
			$cols= $nom;
		else
			$cols=$cols.','.$nom;

		if (empty($values)){
                    $values='"';
		}
		else{
                    $values.=".','";		
		}

		if (isset($photos)&&in_array($i,$photos)){
			$values.=".\"'\"".'.nom_fichier($_FILES[\''.$nom.'\'][\'name\'])'.".\"'\""; //MdB gestion de l'insertion de la photo
		}
		else if (isset($fichiers)&&in_array($i,$fichiers)){
			$values.=".\"'\"".'.nom_fichier($_FILES[\''.$nom.'\'][\'name\'])'.".\"'\""; //MdB gestion de l'insertion du fichier
		}
		else {
			//$values= $values.','\'".slash($'.$nom.',\''.$type.'\',\''.$flags.'\')."\'';
			//$values.='.\',\'.quote($'.$nom.',\''.$type.'\',\''.$flags.'\').';
			$values.='.quote($'.$nom.',\''.$type.'\',\''.$flags.'\')';
			$values.='.slash($'.$nom.',\''.$type.'\',\''.$flags.'\')';
			$values.='.quote($'.$nom.',\''.$type.'\',\''.$flags.'\')';	 
		}
		
	}
	$i++;
}

$req="insert into $table ($cols) values($values".'.")"';
fwrite_encode($fp,'   $req="'.$req.';'."\n" );
fwrite_encode($fp,'   execute_sql($req);'."\n" );
fwrite_encode($fp,'   $dernier_id=mysqli_insert_id($connexion);'."\n" );

// MdB Ajout de la clause permettant la MAJ de la liste des validateurs
$maclause="$nom_id=".'$dernier_id';
fwrite_encode($fp,'   $clause='."\"$maclause\";\n" );

// MdB 03/07/03 Gestion des photos
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
	//MdB gestion de l'insertion de la photo
	if (isset($ins_cols)&&in_array($i,$ins_cols)){
		if (isset($photos)&&in_array($i,$photos)){
			fwrite_encode($fp,'   //gestion des insertions des photos'."\n");
			fwrite_encode($fp,'   $nomDestination=\''.$table.'-\'.$dernier_id.\'-\'.\''.$nom.'\'."-".nom_fichier($_FILES["'.$nom.'"]["name"]);'."\n");
			fwrite_encode($fp,'   if (@copy($_FILES[\''.$nom.'\'][\'tmp_name\'], $rep."/".$nomDestination)) {'."\n");
			fwrite_encode($fp,'      echo("<b>Fichier $nomDestination copie avec succes</b>");'."\n");
			fwrite_encode($fp,'   } else {'."\n");
			//fwrite_encode($fp,'      echo("<b>La copie du fichier $nomDestination a echoue...</b>");'."\n");
			fwrite_encode($fp,'   }'."\n");
			fwrite_encode($fp,'   @unlink($_FILES["'.$nom.'"]["tmp_name"]);'."\n");
		}
		if (isset($fichiers)&&in_array($i,$fichiers)){
			fwrite_encode($fp,'   //gestion des insertions des fichiers'."\n");
			fwrite_encode($fp,'   $nomDestination=\''.$table.'-\'.$dernier_id.\'-\'.\''.$nom.'\'."-".nom_fichier($_FILES["'.$nom.'"]["name"]);'."\n");
			fwrite_encode($fp,'   if (@copy($_FILES[\''.$nom.'\'][\'tmp_name\'], $rep."/".$nomDestination)) {'."\n");
			fwrite_encode($fp,'      echo("<b>Fichier $nomDestination copie avec succes</b>");'."\n");
			fwrite_encode($fp,'   } else {'."\n");
			//fwrite_encode($fp,'      echo("<b>La copie du fichier $nomDestination a echoue...</b>");'."\n");
			fwrite_encode($fp,'   }'."\n");
			fwrite_encode($fp,'   @unlink($_FILES["'.$nom.'"]["tmp_name"]);'."\n");
		}
	}
	$i++;
}
/**************************** MAJ en cas de relation 1 a n ************************/

if (!empty($CIF)&&($un_a_n_insertion=="1")){
		$CIF2=explode("\r\n",$CIF);
		if (!empty($CIF2[0])){
			for ($z=0;$z<count($CIF2);$z++){
				list($val,$col)=explode(".",$CIF2[$z]);
				$req="select * from $val";
				$res = execute_sql($req);
				$nom_nan_id  = db_field_direct_name($res, 0); //nom de la cle primaire 2
				$nom_col2= db_field_direct_name($res,1);
				fwrite_encode($fp,'   if ($affiche_popup==2)'."\n");
				fwrite_encode($fp,'       $liens=explode("\\n",$'.$nom_nan_id.'[0]);'."\n" );
				fwrite_encode($fp,'   if ($affiche_popup==0)'."\n");
				fwrite_encode($fp,'      $liens=$'.$nom_nan_id.';'."\n" );
				fwrite_encode($fp,'   if ($liens[0]!="")'."\n");
				fwrite_encode($fp,'   for ($i=0;$i<count($liens);$i++){'."\n" );
				fwrite_encode($fp,'      $tab=explode("|",$liens[$i]);'."\n");
				fwrite_encode($fp,'      $lien_id=$tab[0];'."\n");
				fwrite_encode($fp,'      if($lien_id!=""){'."\n");
				fwrite_encode($fp,'         $req="update '.$val.' set '.$col.'=$dernier_id where '.$nom_nan_id.'=$lien_id";'."\n" );
				fwrite_encode($fp,'         execute_sql($req);'."\n" );
				fwrite_encode($fp,'      }'."\n" );
				fwrite_encode($fp,'   }'."\n" );
			}
		}
}


/**************************** MAJ en cas de relation a 2 pattes ************************/
for ($z=0;$z<5;$z++){
    if (!empty($table_fille[$z])){
        list($nom_table_relation1,$col_asso1)=explode(".",$relation[$z]);
        $table_relation=explode("\r\n",$association[$z]);
        list($nom_table_relation,$col_asso)=explode(".",$table_relation[0]);
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
        fwrite_encode($fp,'        $req="insert into '.$nom_table_relation.'('.$col_asso1.','.$col_asso.')'.' values($dernier_id,$lien_id)";'."\n" );
        fwrite_encode($fp,'         execute_sql($req);'."\n" );
        fwrite_encode($fp,'      }'."\n" );
        fwrite_encode($fp,'   }'."\n" );
    }
}


$filename2 = $table."_vue.".$extension;
fwrite_encode($fp,'   echo "<br/><h2>$inserer_OK</h2>";'."\n" );
fwrite_encode($fp,'   $id=$dernier_id;'."\n");

/******************* Deroulement des actions ********************/
if (isset($actions1[0])&&!empty($actions1[0])){
	fwrite_encode($fp,$actions1[0]."\n");
}


fwrite_encode($fp,'   include("'.$filename2.'");'."\n");
fwrite_encode($fp,'}'."\n" );
fwrite_encode($fp,'include("piedpage.php");'."\n");
fwrite_encode($fp,'?>'."\n" );
fclose( $fp );
?>
</body>
</html>
